$(function() {
    let options = {};
    $("#role_select").selectpicker({title: "请选择角色",  showTick: true, iconBase: "fa", tickIcon: "fa-check"});
    var canWrite=true; //this is the default for test purposes
    // here starts gantt initialization
    ge = new GanttMaster();
    ge.set100OnClose=true;

    ge.shrinkParent=true;

    ge.init($("#workSpace"));
    loadI18n(); //overwrite with localized ones

    //in order to force compute the best-fitting zoom level
    delete ge.gantt.zoom;

    var project = loadGanttFromServer(window._cur_project_id, null);
    if (!project.canWrite){
        $(".ganttButtonBar button.requireWrite").attr("disabled","true");
    }

    ge.loadProject(project);
    ge.checkpoint(); //empty the undo stack

});

function fetGanttIssues(project_id, callback){
    //console.debug("getDemoProject")
    loading.show('#TWGanttArea');
    ret= {};
    var method = 'get';
    var url = '/project/gantt/fetchProjectIssues/' + project_id;
    $.ajax({
        type: method,
        dataType: "json",
        async: false,
        url: url,
        data: {} ,
        success: function (resp) {
            ret = resp.data;
            loading.hide('#TWGanttArea');
            (callback && typeof(callback) === "function") && callback();
        },
        error: function (res) {
            //notify_error("请求数据错误" + res);
            ret = {};
            return false;
        }
    });
    console.log(ret);

    return ret;
}

function loadGanttFromServer(project_id, callback) {
    //this is a simulation: load data from the local storage if you have already played with the demo or a textarea with starting demo data
    var ret = fetGanttIssues(project_id, callback);
    return ret;
}


function show_setting(){
    window.$_gantAjax.fetchGanttSetting(window._cur_project_id);
    //
    $("#btn-setting-save").click(function(){
        window.$_gantAjax.saveGanttSetting();
    });
}

function show_be_hidden_list(){
    window.$_gantAjax.fetchGanttBeHiddenIssueList(window._cur_project_id);
}

//-------------------------------------------  Open a black popup for managing resources. This is only an axample of implementation (usually resources come from server) ------------------------------------------------------
function editResources(){

    //make resource editor
    window.$_gantAjax.fetchResource(window._cur_project_id);
    // btn-member-add
    $("#btn-member-add").click(function(){
        window.$_gantAjax.addResource();
    });
    return;

    var resourceEditor = $.JST.createFromTemplate({}, "RESOURCE_EDITOR");
    var resTbl=resourceEditor.find("#resourcesTable");

    for (var i=0;i<ge.resources.length;i++){
        var res=ge.resources[i];
        resTbl.append($.JST.createFromTemplate(res, "RESOURCE_ROW"))
    }

    //bind add resource
    resourceEditor.find("#addResource").click(function(){
        resTbl.append($.JST.createFromTemplate({id:"new",name:"resource"}, "RESOURCE_ROW"))
    });

    //bind save event
    resourceEditor.find("#resSaveButton").click(function(){
        var newRes=[];
        //find for deleted res
        for (var i=0;i<ge.resources.length;i++){
            var res=ge.resources[i];
            var row = resourceEditor.find("[resId="+res.id+"]");
            if (row.length>0){
                //if still there save it
                var name = row.find("input[name]").val();
                if (name && name!="")
                    res.name=name;
                newRes.push(res);
            } else {
                //remove assignments
                for (var j=0;j<ge.tasks.length;j++){
                    var task=ge.tasks[j];
                    var newAss=[];
                    for (var k=0;k<task.assigs.length;k++){
                        var ass=task.assigs[k];
                        if (ass.resourceId!=res.id)
                            newAss.push(ass);
                    }
                    task.assigs=newAss;
                }
            }
        }
        //loop on new rows
        var cnt=0
        resourceEditor.find("[resId=new]").each(function(){
            cnt++;
            var row = $(this);
            var name = row.find("input[name]").val();
            if (name && name!="")
                newRes.push (new Resource("tmp_"+new Date().getTime()+"_"+cnt,name));
        });
        ge.resources=newRes;
        closeBlackPopup();
        ge.redraw();
    });

    var ndo = createModalPopup(400, 500).append(resourceEditor);

    new UsersSelect();
}

function showBaselineInfo (event,element){
    //alert(element.attr("data-label"));
    $(element).showBalloon(event, $(element).attr("data-label"));
    ge.splitter.secondBox.one("scroll",function(){
        $(element).hideBalloon();
    })
}


$.JST.loadDecorator("RESOURCE_ROW", function(resTr, res){
    resTr.find(".delRes").click(function(){$(this).closest("tr").remove()});
});

$.JST.loadDecorator("ASSIGNMENT_ROW", function(assigTr, taskAssig){
    var resEl = assigTr.find("[name=resourceId]");
    var opt = $("<option>");
    resEl.append(opt);
    for(var i=0; i< taskAssig.task.master.resources.length;i++){
        var res = taskAssig.task.master.resources[i];
        opt = $("<option>");
        opt.val(res.id).html(res.name);
        if(taskAssig.assig.resourceId == res.id)
            opt.attr("selected", "true");
        resEl.append(opt);
    }
    var roleEl = assigTr.find("[name=roleId]");
    for(var i=0; i< taskAssig.task.master.roles.length;i++){
        var role = taskAssig.task.master.roles[i];
        var optr = $("<option>");
        optr.val(role.id).html(role.name);
        if(taskAssig.assig.roleId == role.id)
            optr.attr("selected", "true");
        roleEl.append(optr);
    }

    if(taskAssig.task.master.permissions.canWrite && taskAssig.task.canWrite){
        assigTr.find(".delAssig").click(function(){
            var tr = $(this).closest("[assId]").fadeOut(200, function(){$(this).remove()});
        });
    }
});

function loadI18n(){
    GanttMaster.messages = {
        "CANNOT_WRITE":"没有权限修改.",
        "CHANGE_OUT_OF_SCOPE":"没有权限更新.",
        "START_IS_MILESTONE":"里程碑开始日期.",
        "END_IS_MILESTONE":"里程碑结束日期.",
        "TASK_HAS_CONSTRAINTS":"该事项已经被限制.",
        "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":"依赖一个开启的事项发生错误.",
        "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK":"Error: 不能派生一个关闭的事项.",
        "TASK_HAS_EXTERNAL_DEPS":"该事项已经有了依赖.",
        "GANNT_ERROR_LOADING_DATA_TASK_REMOVED":"载入数据错误，事项可能已经被删除",
        "CIRCULAR_REFERENCE":"循环引用.",
        "CANNOT_DEPENDS_ON_ANCESTORS":"不能依赖于父级实现.",
        "INVALID_DATE_FORMAT":"无效的日期格式.",
        "GANTT_ERROR_LOADING_DATA_TASK_REMOVED":"载入数据错误，事项可能已经被删除",
        "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE":"不能关闭打开的事项",
        "TASK_MOVE_INCONSISTENT_LEVEL":"不能移动不同级别的事项.",
        "CANNOT_MOVE_TASK":"无法移动此事项",
        "PLEASE_SAVE_PROJECT":"请保存项目",
        "GANTT_SEMESTER":"周期",
        "GANTT_SEMESTER_SHORT":"s.",
        "GANTT_QUARTER":"4 /",
        "GANTT_QUARTER_SHORT":"q.",
        "GANTT_WEEK":"Week",
        "GANTT_WEEK_SHORT":"w."
    };
}
