/*
 Copyright (c) 2012-2018 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
function GridEditor(master) {
  this.master = master; // is the a GantEditor instance

  var editorTabel = $.JST.createFromTemplate({}, "TASKSEDITHEAD");
  if (!master.permissions.canSeeDep)
    editorTabel.find(".requireCanSeeDep").hide();

  this.gridified = $.gridify(editorTabel);
  this.element = this.gridified.find(".gdfTable").eq(1);

  this.minAllowedDate=new Date(new Date().getTime()-3600000*24*365*20).format();
  this.maxAllowedDate=new Date(new Date().getTime()+3600000*24*365*30).format();
}


GridEditor.prototype.fillEmptyLines = function () {
  //console.debug("fillEmptyLines")
  var factory = new TaskFactory();
  var master = this.master;

  //console.debug("GridEditor.fillEmptyLines");
  var rowsToAdd = master.minRowsInEditor - this.element.find(".taskEditRow").length;
  var empty=this.element.find(".emptyRow").length;
  rowsToAdd=Math.max(rowsToAdd,empty>5?0:5-empty);

  //fill with empty lines
  for (var i = 0; i < rowsToAdd; i++) {
    var emptyRow = $.JST.createFromTemplate({}, "TASKEMPTYROW");
    if (!master.permissions.canSeeDep)
      emptyRow.find(".requireCanSeeDep").hide();

    //click on empty row create a task and fill above
    emptyRow.click(function (ev) {
      //console.debug("emptyRow.click")
      var emptyRow = $(this);
      //add on the first empty row only
      if (!master.permissions.canAdd || emptyRow.prevAll(".emptyRow").length > 0)
        return;

      master.beginTransaction();
      var lastTask;
      var start = new Date().getTime();
      var level = 0;
      if (master.tasks[0]) {
        start = master.tasks[0].start;
        level = master.tasks[0].level + 1;
      }

      //fill all empty previouses
      var cnt=0;
      emptyRow.prevAll(".emptyRow").addBack().each(function () {
        cnt++;
        var ch = factory.build("tmp_fk" + new Date().getTime()+"_"+cnt, "", "", level, start, Date.workingPeriodResolution);
        var task = master.addTask(ch);
        lastTask = ch;
      });
      master.endTransaction();
      if (lastTask.rowElement) {
        lastTask.rowElement.find("[name=name]").focus();//focus to "name" input
      }
    });
    this.element.append(emptyRow);
  }
};


GridEditor.prototype.addTask = function (task, row, hideIfParentCollapsed) {
  //console.debug("GridEditor.addTask",task,row);
  //var prof = new Profiler("ganttGridEditor.addTask");

  //remove extisting row
  this.element.find("#tid_" + task.id).remove();

  var taskRow = $.JST.createFromTemplate(task, "TASKROW");
  console.log(task);
  if (!this.master.permissions.canSeeDep)
    taskRow.find(".requireCanSeeDep").hide();

  if (!this.master.permissions.canSeePopEdit)
    taskRow.find(".edit .teamworkIcon").hide();

  //save row element on task
  task.rowElement = taskRow;

  this.bindRowEvents(task, taskRow);

  if (typeof(row) != "number") {
    var emptyRow = this.element.find(".emptyRow:first"); //tries to fill an empty row
    if (emptyRow.length > 0)
      emptyRow.replaceWith(taskRow);
    else
      this.element.append(taskRow);
  } else {
    var tr = this.element.find("tr.taskEditRow").eq(row);
    if (tr.length > 0) {
      tr.before(taskRow);
    } else {
      this.element.append(taskRow);
    }

  }

  if(task.type==='sprint'){
    taskRow.find(".edit .teamworkIcon").hide();
  }

  //[expand]
  if (hideIfParentCollapsed) {
    if (task.collapsed) taskRow.addClass('collapsed');
    var collapsedDescendant = this.master.getCollapsedDescendant();
    if (collapsedDescendant.indexOf(task) >= 0) taskRow.hide();
  }
  //prof.stop();
  return taskRow;
};

GridEditor.prototype.refreshExpandStatus = function (task) {
  //console.debug("refreshExpandStatus",task);
  if (!task) return;
  if (task.isParent()) {
    task.rowElement.addClass("isParent");
  } else {
    task.rowElement.removeClass("isParent");
  }


  var par = task.getParent();
  if (par && !par.rowElement.is("isParent")) {
    par.rowElement.addClass("isParent");
  }

};

GridEditor.prototype.refreshTaskRow = function (task) {
  //console.debug("refreshTaskRow")
  //var profiler = new Profiler("editorRefreshTaskRow");

  var canWrite=this.master.permissions.canWrite || task.canWrite;

  var row = task.rowElement;
  //console.log(task,'task.start:',task.start,new Date(task.start).format());
  row.find(".taskRowIndex").html(task.getRow() + 1);
  row.find(".indentCell").css("padding-left", task.level * 10 + 18);
  row.find("[name=name]").val(task.name);
  row.find("[name=code]").val(task.code);
  row.find("[status]").attr("status", task.status);

  row.find("[name=duration]").val(durationToString(task.duration)).prop("readonly",!canWrite || task.isParent() && task.master.shrinkParent);
  row.find("[name=progress]").val(task.progress).prop("readonly",!canWrite || task.progressByWorklog==true);
  row.find("[name=startIsMilestone]").prop("checked", task.startIsMilestone);
  row.find("[name=start]").val(new Date(task.start).format()).updateOldValue().prop("readonly",!canWrite || task.depends || !(task.canWrite  || this.master.permissions.canWrite) ); // called on dates only because for other field is called on focus event
  row.find("[name=endIsMilestone]").prop("checked", task.endIsMilestone);
  row.find("[name=end]").val(new Date(task.end).format()).prop("readonly",!canWrite || task.isParent() && task.master.shrinkParent).updateOldValue();
  row.find("[name=depends]").val(task.depends);
  row.find(".taskAssigs").html(task.getAssigsString());

  //manage collapsed
  if (task.collapsed)
    row.addClass("collapsed");
  else
    row.removeClass("collapsed");


  //Enhancing the function to perform own operations
  this.master.element.trigger('gantt.task.afterupdate.event', task);
  //profiler.stop();
};

GridEditor.prototype.redraw = function () {
  //console.debug("GridEditor.prototype.redraw")
  //var prof = new Profiler("gantt.GridEditor.redraw");
  for (var i = 0; i < this.master.tasks.length; i++) {
    this.refreshTaskRow(this.master.tasks[i]);
  }
  // check if new empty rows are needed
  if (this.master.fillWithEmptyLines)
    this.fillEmptyLines();

  //prof.stop()

};

GridEditor.prototype.reset = function () {
  this.element.find("[taskid]").remove();
};


GridEditor.prototype.bindRowEvents = function (task, taskRow) {
  var self = this;
  //console.debug("bindRowEvents",this,this.master,this.master.permissions.canWrite, task.canWrite);

  //bind row selection
  taskRow.click(function (event) {
    var row = $(this);
    //console.debug("taskRow.click",row.attr("taskid"),event.target)
    //var isSel = row.hasClass("rowSelected");
    row.closest("table").find(".rowSelected").removeClass("rowSelected");
    row.addClass("rowSelected");

    //set current task
    self.master.currentTask = self.master.getTask(row.attr("taskId"));

    //move highlighter
    self.master.gantt.synchHighlight();

    //if offscreen scroll to element
    var top = row.position().top;
    if (top > self.element.parent().height()) {
      row.offsetParent().scrollTop(top - self.element.parent().height() + 100);
    } else if (top <= 40) {
      row.offsetParent().scrollTop(row.offsetParent().scrollTop() - 40 + top);
    }
  });


  if (this.master.permissions.canWrite || task.canWrite) {
    self.bindRowInputEvents(task, taskRow);

  } else { //cannot write: disable input
    taskRow.find("input").prop("readonly", true);
    taskRow.find("input:checkbox,select").prop("disabled", true);
  }

  if (!this.master.permissions.canSeeDep)
    taskRow.find("[name=depends]").attr("readonly", true);

  self.bindRowExpandEvents(task, taskRow);

  if (this.master.permissions.canSeePopEdit) {
    taskRow.find(".edit").click(function () {
      if(task.id>0){
          self.openMasterlabEditor(task, false)
      }

    });

    taskRow.dblclick(function (ev) { //open editor only if no text has been selected
      if (window.getSelection().toString().trim()==""){
          if(task.id>0){
              self.openMasterlabEditor(task, $(ev.target).closest(".taskAssigs").size()>0)
          }
      }

      });
  }
  //prof.stop();
};


GridEditor.prototype.bindRowExpandEvents = function (task, taskRow) {
  var self = this;
  //expand collapse
  taskRow.find(".exp-controller").click(function () {
    var el = $(this);
    var taskId = el.closest("[taskid]").attr("taskid");
    var task = self.master.getTask(taskId);
    if (task.collapsed) {
      self.master.expand(task,false);
    } else {
      self.master.collapse(task,false);
    }
  });
};

GridEditor.prototype.bindRowInputEvents = function (task, taskRow) {
  var self = this;

  //bind dateField on dates
  taskRow.find(".date").each(function () {
    var el = $(this);
    el.click(function () {
      var inp = $(this);
      inp.dateField({
        inputField: el,
        minDate:self.minAllowedDate,
        maxDate:self.maxAllowedDate,
        callback:   function (d) {
          $(this).blur();
        }
      });
    });

    el.blur(function (date) {
      var inp = $(this);
      if (inp.isValueChanged()) {
        if (!Date.isValid(inp.val())) {
          alert(GanttMaster.messages["INVALID_DATE_FORMAT"]);
          inp.val(inp.getOldValue());

        } else {
          var row = inp.closest("tr");
          var taskId = row.attr("taskId");
          var task = self.master.getTask(taskId);

          var leavingField = inp.prop("name");
          var dates = resynchDates(inp, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
          //console.debug("resynchDates",new Date(dates.start), new Date(dates.end),dates.duration)
          //update task from editor
          self.master.beginTransaction();
          self.master.changeTaskDates(task, dates.start, dates.end);
          self.master.endTransaction();
          inp.updateOldValue(); //in order to avoid multiple call if nothing changed
        }
      }
    });
  });


  //milestones checkbox
  taskRow.find(":checkbox").click(function () {
    var el = $(this);
    var row = el.closest("tr");
    var taskId = row.attr("taskId");

    var task = self.master.getTask(taskId);

    //update task from editor
    var field = el.prop("name");

    if (field == "startIsMilestone" || field == "endIsMilestone") {
      self.master.beginTransaction();
      //milestones
      task[field] = el.prop("checked");
      resynchDates(el, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
      self.master.endTransaction();
    }

  });


  //binding on blur for task update (date exluded as click on calendar blur and then focus, so will always return false, its called refreshing the task row)
  taskRow.find("input:text:not(.date)").focus(function () {
    $(this).updateOldValue();

  }).blur(function (event) {
    var el = $(this);
    var row = el.closest("tr");
    var taskId = row.attr("taskId");
    var task = self.master.getTask(taskId);
    //update task from editor
    var field = el.prop("name");
    if (el.isValueChanged()) {
      self.master.beginTransaction();

      if (field == "depends") {
        var oldDeps = task.depends;
        task.depends = el.val();

        // update links
        var linkOK = self.master.updateLinks(task);
        if (linkOK) {
          //synchronize status from superiors states
          var sups = task.getSuperiors();

          var oneFailed=false;
          var oneUndefined=false;
          var oneActive=false;
          var oneSuspended=false;
          var oneWaiting=false;
          for (var i = 0; i < sups.length; i++) {
            oneFailed=oneFailed|| sups[i].from.status=="STATUS_FAILED";
            oneUndefined=oneUndefined|| sups[i].from.status=="STATUS_UNDEFINED";
            oneActive=oneActive|| sups[i].from.status=="STATUS_ACTIVE";
            oneSuspended=oneSuspended|| sups[i].from.status=="STATUS_SUSPENDED";
            oneWaiting=oneWaiting|| sups[i].from.status=="STATUS_WAITING";
          }

          if (oneFailed){
            task.changeStatus("STATUS_FAILED")
          } else if (oneUndefined){
            task.changeStatus("STATUS_UNDEFINED")
          } else if (oneActive){
            //task.changeStatus("STATUS_SUSPENDED")
            task.changeStatus("STATUS_WAITING")
          } else  if (oneSuspended){
            task.changeStatus("STATUS_SUSPENDED")
          } else  if (oneWaiting){
            task.changeStatus("STATUS_WAITING")
          } else {
            task.changeStatus("STATUS_ACTIVE")
          }
            self.master.changeTaskDeps(task); //dates recomputation from dependencies
            var params = {depends:task.depends};
            self.master.updateIssue(task.id, params)

        }

      } else if (field == "duration") {
        var dates = resynchDates(el, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
        self.master.changeTaskDates(task, dates.start, dates.end);

      } else if (field == "name" && el.val() == "") { // remove unfilled task
        self.master.deleteCurrentTask(taskId);


      } else if (field == "progress" ) {
        task[field]=parseFloat(el.val())||0;
        el.val(task[field]);

      } else {
        task[field] = el.val();
      }
      self.master.endTransaction();

    } else if (field == "name" && el.val() == "") { // remove unfilled task even if not changed
      if (task.getRow()!=0) {
          self.master.deleteCurrentTask(taskId);
      }else {
          el.oneTime(1,"foc",function(){$(this).focus()}); //
          event.preventDefault();
          //return false;
      }

    }
  });

  //cursor key movement
  taskRow.find("input").keydown(function (event) {
    var theCell = $(this);
    var theTd = theCell.parent();
    var theRow = theTd.parent();
    var col = theTd.prevAll("td").length;

    var ret = true;
    if (!event.ctrlKey) {
      switch (event.keyCode) {
      case 13:
        if (theCell.is(":text"))
          theCell.blur();
        break;

        case 37: //left arrow
          if (!theCell.is(":text") || (!this.selectionEnd || this.selectionEnd == 0))
            theTd.prev().find("input").focus();
          break;
        case 39: //right arrow
          if (!theCell.is(":text") || (!this.selectionEnd || this.selectionEnd == this.value.length))
            theTd.next().find("input").focus();
          break;

        case 38: //up arrow
          //var prevRow = theRow.prev();
          var prevRow = theRow.prevAll(":visible:first");
          var td = prevRow.find("td").eq(col);
          var inp = td.find("input");

          if (inp.length > 0)
            inp.focus();
          break;
        case 40: //down arrow
          //var nextRow = theRow.next();
          var nextRow = theRow.nextAll(":visible:first");
          var td = nextRow.find("td").eq(col);
          var inp = td.find("input");
          if (inp.length > 0)
            inp.focus();
          else
            nextRow.click(); //create a new row
          break;
        case 36: //home
          break;
        case 35: //end
          break;

        case 9: //tab
        case 13: //enter
          break;
      }
    }
    return ret;

  }).focus(function () {
    $(this).closest("tr").click();
  });


  //change status
  taskRow.find(".taskStatus").click(function () {
    var el = $(this);
    var tr = el.closest("[taskid]");
    var taskId = tr.attr("taskid");
    var task = self.master.getTask(taskId);

    var changer = $.JST.createFromTemplate({}, "CHANGE_STATUS");
    changer.find("[status=" + task.status + "]").addClass("selected");
    changer.find(".taskStatus").click(function (e) {
      e.stopPropagation();
      var newStatus = $(this).attr("status");
      changer.remove();
      self.master.beginTransaction();
      task.changeStatus(newStatus);
      self.master.endTransaction();
      el.attr("status", task.status);
    });
    el.oneTime(3000, "hideChanger", function () {
      changer.remove();
    });
    el.after(changer);
  });

};

GridEditor.prototype.openMasterlabEditor = function (task, editOnlyAssig) {

    $('#modal-create-issue').modal('show');
    loading.show('#modal-body');
    $('#issue_id').val(task.id);
    $('#action').val('update');
    $('#gantt_description').text('');
    $.ajax({
        type: 'get',
        dataType: "json",
        async: true,
        url: root_url + "issue/detail/get/" + task.id,
        data: {},
        success: function (resp) {
            loading.hide('#modal-body');
            auth_check(resp);
            var issue = resp.data.issue;
            $('#summary').val(issue.summary);
            $('#create_issue_types_select').val(issue.issue_type);
            $('#priority').val(issue.priority);
            $('#gantt_status').val(issue.gantt_status);
            $('#assignee').val(issue.assignee);
            $('#sprint').val(issue.sprint);
            $('#start_date').val(issue.start_date);
            $('#due_date').val(issue.due_date);
            $('#duration').val(issue.duration);
            $('#progress').val(issue.progress);
            if(issue.is_start_milestone!='0'){
                $('#is_start_milestone').attr("checked", true);
            }
            if(issue.is_end_milestone!='0'){
                $('#is_end_milestone').attr("checked", true);
            }
            $('.selectpicker').selectpicker('refresh');

            let user = getUser(window._issueConfig.users, issue.assignee);
            $('#user_dropdown-toggle-text').html(user.display_name);

            let sprint = getObjectValue(window._issueConfig.sprint, issue.sprint);
            $('#sprint_name').html(sprint.name);
         // if(!window._editor_md){
          $('#gantt_description').text(issue.description);
            window._editor_md = editormd({
              id   : "description_md",
              placeholder : "",
              width: "600px",
              readOnly:false,
              styleActiveLine:true,
              lineNumbers:true,
              height: 240,
              markdown: issue.description,
              path: '/dev/lib/editor.md/lib/',
              imageUpload: true,
              imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
              imageUploadURL: "/issue/detail/editormd_upload",
              saveHTMLToTextarea: true,
              emoji: true,
              toolbarIcons      : "custom",
            })
         // }

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


GridEditor.prototype.openFullEditor = function (task, editOnlyAssig) {
  var self = this;


  if (!self.master.permissions.canSeePopEdit)
    return;

  var taskRow=task.rowElement;

  //task editor in popup
  var taskId = taskRow.attr("taskId");

  //make task editor
  var taskEditor = $.JST.createFromTemplate(task, "TASK_EDITOR");

  //hide task data if editing assig only
  if (editOnlyAssig) {
    taskEditor.find(".taskData").hide();
    taskEditor.find(".assigsTableWrapper").height(455);
    taskEditor.prepend("<h1>\""+task.name+"\"</h1>");
  }

  //got to extended editor
  if (task.isNew()|| !self.master.permissions.canSeeFullEdit){
    taskEditor.find("#taskFullEditor").remove();
  } else {
    taskEditor.bind("openFullEditor.gantt",function () {
      window.location.href=contextPath+"/applications/teamwork/task/taskEditor.jsp?CM=ED&OBJID="+task.id;
    });
  }


  taskEditor.find("#name").val(task.name);
  taskEditor.find("#description").val(task.description);
  taskEditor.find("#code").val(task.code);
  taskEditor.find("#progress").val(task.progress ? parseFloat(task.progress) : 0).prop("readonly",task.progressByWorklog==true);
  taskEditor.find("#progressByWorklog").prop("checked",task.progressByWorklog);
  taskEditor.find("#status").val(task.status);
  taskEditor.find("#type").val(task.typeId);
  taskEditor.find("#type_txt").val(task.type);
  taskEditor.find("#relevance").val(task.relevance);
  //cvc_redraw(taskEditor.find(".cvcComponent"));


  if (task.startIsMilestone)
    taskEditor.find("#startIsMilestone").prop("checked", true);
  if (task.endIsMilestone)
    taskEditor.find("#endIsMilestone").prop("checked", true);

  taskEditor.find("#duration").val(durationToString(task.duration));
  var startDate = taskEditor.find("#start");
  startDate.val(new Date(task.start).format());
  //start is readonly in case of deps
  if (task.depends || !(this.master.permissions.canWrite ||task.canWrite)) {
    startDate.attr("readonly", "true");
  } else {
    startDate.removeAttr("readonly");
  }

  taskEditor.find("#end").val(new Date(task.end).format());

  //make assignments table
  var assigsTable = taskEditor.find("#assigsTable");
  assigsTable.find("[assId]").remove();
  // loop on assignments
  for (var i = 0; i < task.assigs.length; i++) {
    var assig = task.assigs[i];
    var assigRow = $.JST.createFromTemplate({task: task, assig: assig}, "ASSIGNMENT_ROW");
    assigsTable.append(assigRow);
  }

  taskEditor.find(":input").updateOldValue();

  if (!(self.master.permissions.canWrite || task.canWrite)) {
    taskEditor.find("input,textarea").prop("readOnly", true);
    taskEditor.find("input:checkbox,select").prop("disabled", true);
    taskEditor.find("#saveButton").remove();
    taskEditor.find(".button").addClass("disabled");

  } else {

    //bind dateField on dates, duration
    taskEditor.find("#start,#end,#duration").click(function () {
      var input = $(this);
      if (input.is("[entrytype=DATE]")) {
        input.dateField({
          inputField: input,
          minDate:self.minAllowedDate,
          maxDate:self.maxAllowedDate,
          callback:   function (d) {$(this).blur();}
        });
      }
    }).blur(function () {
      var inp = $(this);
      if (inp.validateField()) {
        resynchDates(inp, taskEditor.find("[name=start]"), taskEditor.find("[name=startIsMilestone]"), taskEditor.find("[name=duration]"), taskEditor.find("[name=end]"), taskEditor.find("[name=endIsMilestone]"));
        //workload computation
        if (typeof(workloadDatesChanged)=="function")
          workloadDatesChanged();
      }
    });

    taskEditor.find("#startIsMilestone,#endIsMilestone").click(function () {
      var inp = $(this);
      resynchDates(inp, taskEditor.find("[name=start]"), taskEditor.find("[name=startIsMilestone]"), taskEditor.find("[name=duration]"), taskEditor.find("[name=end]"), taskEditor.find("[name=endIsMilestone]"));
    });

    //bind add assignment
    var cnt=0;
    taskEditor.find("#addAssig").click(function () {
      cnt++;
      var assigsTable = taskEditor.find("#assigsTable");
      var assigRow = $.JST.createFromTemplate({task: task, assig: {id: "tmp_" + new Date().getTime()+"_"+cnt}}, "ASSIGNMENT_ROW");
      assigsTable.append(assigRow);
      $("#bwinPopupd").scrollTop(10000);
    }).click();

    //save task
    taskEditor.bind("saveFullEditor.gantt",function () {
      //console.debug("saveFullEditor");
      var task = self.master.getTask(taskId); // get task again because in case of rollback old task is lost

      self.master.beginTransaction();
      task.name = taskEditor.find("#name").val();
      task.description = taskEditor.find("#description").val();
      task.code = taskEditor.find("#code").val();
      task.progress = parseFloat(taskEditor.find("#progress").val());
      //task.duration = parseInt(taskEditor.find("#duration").val()); //bicch rimosso perchè devono essere ricalcolata dalla start end, altrimenti sbaglia
      task.startIsMilestone = taskEditor.find("#startIsMilestone").is(":checked");
      task.endIsMilestone = taskEditor.find("#endIsMilestone").is(":checked");

      //task.type = taskEditor.find("#type_txt").val();
      //task.typeId = taskEditor.find("#type").val();
      //task.relevance = taskEditor.find("#relevance").val();

      //set assignments
      var cnt=0;

      //change dates
      task.setPeriod(Date.parseString(taskEditor.find("#start").val()).getTime(), Date.parseString(taskEditor.find("#end").val()).getTime() + (3600000 * 22));

      //change status
      task.changeStatus(taskEditor.find("#status").val());

      if (self.master.endTransaction()) {
        taskEditor.find(":input").updateOldValue();
        closeBlackPopup();
      }

    });
  }

  taskEditor.attr("alertonchange","true");
  var ndo = createModalPopup(800, 450).append(taskEditor);//.append("<div style='height:800px; background-color:red;'></div>")

  //workload computation
  if (typeof(workloadDatesChanged)=="function")
    workloadDatesChanged();



};
