<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <script src="/dev/lib/moment.js"></script>
    <script src="/dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="/dev/js/admin/issue_ui.js?v=<?= $_version ?>" type="text/javascript"  charset="utf-8"></script>
    <script src="/dev/js/issue/form.js?v=<?= $_version ?>" type="text/javascript"  charset="utf-8"></script>
    <script src="/dev/js/issue/detail.js?v=<?= $_version ?>" type="text/javascript"  charset="utf-8"></script>
    <script src="/dev/js/issue/main.js?v=<?= $_version ?>" type="text/javascript"  charset="utf-8"></script>
    <script src="/dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="/dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript"   charset="utf-8"></script>
    <link href="/dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="/dev/lib/simplemde/dist/simplemde.min.js"></script>
    <link rel="stylesheet" href="/dev/lib//simplemde/dist/simplemde.min.css">

    <link href="/dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="/dev/lib/laydate/laydate.js"></script>

    <link rel="stylesheet" href="/dev/lib/editor.md/css/editormd.css">
    <script src="/dev/lib/editor.md/editormd.js"></script>
    <script src="/dev/lib/editor.md/lib/marked.min.js"></script>
    <script src="/dev/lib/editor.md/lib/prettify.min.js"></script>
    <script src="/dev/lib/editor.md/lib/flowchart.min.js"></script>
    <script src="/dev/lib/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="/dev/lib/editor.md/editormd.js"></script>

    <link href="/dev/lib/jquery.spinner/css/bootstrap-spinner.min.css" rel="stylesheet">
    <script src="/dev/lib/jquery.spinner/js/jquery.spinner.min.js"></script>

    <link href="/dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>

    <link rel=stylesheet href="/dev/lib/jQueryGantt/platform.css" type="text/css">
    <link rel=stylesheet href="/dev/lib/jQueryGantt/libs/jquery/dateField/jquery.dateField.css" type="text/css">

    <link rel=stylesheet href="/dev/lib/jQueryGantt/gantt.css" type="text/css">
    <link rel=stylesheet href="/dev/lib/jQueryGantt/ganttPrint.css" type="text/css" media="print">

    <script src="/dev/lib/jquery.min.3.1.1.js"></script>
    <script src="/dev/lib/jquery-ui/jquery-ui.min.js"></script>

    <script src="/dev/lib/jQueryGantt/libs/jquery/jquery.livequery.1.1.1.min.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/jquery/jquery.timers.js"></script>

    <script src="/dev/lib/jQueryGantt/libs/utilities.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/forms.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/date.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/dialogs.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/layout.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/i18nJs.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/jquery/dateField/jquery.dateField.js"></script>
    <script src="/dev/lib/jQueryGantt/libs/jquery/JST/jquery.JST.js"></script>

    <script type="text/javascript" src="/dev/lib/jQueryGantt/libs/jquery/svg/jquery.svg.min.js"></script>
    <script type="text/javascript" src="/dev/lib/jQueryGantt/libs/jquery/svg/jquery.svgdom.1.8.js"></script>

    <script src="/dev/lib/jQueryGantt/ganttUtilities.js"></script>
    <script src="/dev/lib/jQueryGantt/ganttTask.js"></script>
    <script src="/dev/lib/jQueryGantt/ganttDrawerSVG.js"></script>
    <script src="/dev/lib/jQueryGantt/ganttZoom.js"></script>
    <script src="/dev/lib/jQueryGantt/ganttGridEditor.js"></script>
    <script src="/dev/lib/jQueryGantt/ganttMaster.js"></script>


</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="hornet" style="background-color: #fff;">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<div class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>


<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="content" id="content-body">
            <div id="ndo" style="display:none;position:absolute;right:5px;top:5px;width:378px;padding:5px;background-color: #FFF5E6; border:1px solid #F9A22F; font-size:12px" class="noprint">
                This Gantt editor is free thanks to <a href="http://twproject.com" target="_blank">Twproject</a> where it can be used on a complete and flexible project management solution.<br> Get your projects done! Give <a href="http://twproject.com" target="_blank">Twproject a try now</a>.
            </div>
            <div id="workSpace" style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;position:relative;margin:0 5px"></div>

            <style>
                .resEdit {
                    padding: 15px;
                }

                .resLine {
                    width: 95%;
                    padding: 3px;
                    margin: 5px;
                    border: 1px solid #d0d0d0;
                }

                body {
                    overflow: hidden;
                }

                .ganttButtonBar h1{
                    color: #000000;
                    font-weight: bold;
                    font-size: 28px;
                    margin-left: 10px;
                }

            </style>

            <form id="gimmeBack" style="display:none;" action="../gimmeBack.jsp" method="post" target="_blank"><input type="hidden" name="prj" id="gimBaPrj"></form>
            <div id="gantEditorTemplates" style="display:none;">
                <div class="__template__" type="GANTBUTTONS"><!--
  <div class="ganttButtonBar noprint">
    <div class="buttons">
      <a style="display:none" href="https://gantt.twproject.com/"><img src="res/twGanttLogo.png" alt="Twproject" align="absmiddle" style="max-width: 136px; padding-right: 15px"></a>

      <button onclick="$('#workSpace').trigger('undo.gantt');return false;" class="button textual icon requireCanWrite" title="undo"><span class="teamworkIcon">&#39;</span></button>
      <button onclick="$('#workSpace').trigger('redo.gantt');return false;" class="button textual icon requireCanWrite" title="redo"><span class="teamworkIcon">&middot;</span></button>
      <span class="ganttButtonSeparator requireCanWrite requireCanAdd"></span>
      <button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanAdd" title="insert above"><span class="teamworkIcon">l</span></button>
      <button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanAdd" title="insert below"><span class="teamworkIcon">X</span></button>
      <span class="ganttButtonSeparator requireCanWrite requireCanInOutdent"></span>
      <button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanInOutdent" title="un-indent task"><span class="teamworkIcon">.</span></button>
      <button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanInOutdent" title="indent task"><span class="teamworkIcon">:</span></button>
      <span class="ganttButtonSeparator requireCanWrite requireCanMoveUpDown"></span>
      <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move up"><span class="teamworkIcon">k</span></button>
      <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move down"><span class="teamworkIcon">j</span></button>
      <span class="ganttButtonSeparator requireCanWrite requireCanDelete"></span>
      <button onclick="$('#workSpace').trigger('deleteFocused.gantt');return false;" class="button textual icon delete requireCanWrite" title="Elimina"><span class="teamworkIcon">&cent;</span></button>
      <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('expandAll.gantt');return false;" class="button textual icon " title="EXPAND_ALL"><span class="teamworkIcon">6</span></button>
      <button onclick="$('#workSpace').trigger('collapseAll.gantt'); return false;" class="button textual icon " title="COLLAPSE_ALL"><span class="teamworkIcon">5</span></button>

    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('zoomMinus.gantt'); return false;" class="button textual icon " title="zoom out"><span class="teamworkIcon">)</span></button>
      <button onclick="$('#workSpace').trigger('zoomPlus.gantt');return false;" class="button textual icon " title="zoom in"><span class="teamworkIcon">(</span></button>
    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('print.gantt');return false;" class="button textual icon " title="Print"><span class="teamworkIcon">p</span></button>
    <span class="ganttButtonSeparator"></span>
      <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();return false;" class="button textual icon requireCanSeeCriticalPath" title="CRITICAL_PATH"><span class="teamworkIcon">&pound;</span></button>
    <span class="ganttButtonSeparator requireCanSeeCriticalPath"></span>
      <button onclick="ge.splitter.resize(.1);return false;" class="button textual icon" ><span class="teamworkIcon">F</span></button>
      <button onclick="ge.splitter.resize(50);return false;" class="button textual icon" ><span class="teamworkIcon">O</span></button>
      <button onclick="ge.splitter.resize(100);return false;" class="button textual icon"><span class="teamworkIcon">R</span></button>
      <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('fullScreen.gantt');return false;" class="button textual icon" title="FULLSCREEN" id="fullscrbtn"><span class="teamworkIcon">@</span></button>
      <button onclick="ge.element.toggleClass('colorByStatus' );return false;" class="button textual icon"><span class="teamworkIcon">&sect;</span></button>

    <button onclick="editResources();" class="button textual requireWrite" title="edit resources"><span class="teamworkIcon">M</span></button>
      &nbsp; &nbsp;
      <a id="toggle_focus_mode" href="#" role="button" aria-label="" title="" class="btn btn-default    js-focus-mode-btn" data-original-title="切换聚焦模式">
                                                    <span style="display: none;">
                                                        <svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M.147 15.496l2.146-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.146-1.428-1.428zM14.996.646l1.428 1.43-2.146 2.145 1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125l1.286 1.286L14.996.647zm-13.42 0L3.72 2.794l1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286L.147 2.075 1.575.647zm14.848 14.85l-1.428 1.428-2.146-2.146-1.286 1.286c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616l-1.286 1.286 2.146 2.146z" fill-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <span>
                                                        <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M8.591 5.056l2.147-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.147-1.429-1.43zM5.018 8.553l1.429 1.43L4.3 12.127l1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125L2.872 10.7l2.146-2.147zm4.964 0l2.146 2.147 1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286-2.147-2.146 1.43-1.429zM6.447 5.018l-1.43 1.429L2.873 4.3 1.586 5.586c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616L4.3 2.872l2.147 2.146z" fill-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </a>

    <a class="button login"  href="#"  data-toggle="modal" data-target="#modal-create-issue"  title="添加事项"   >添加事项</a>
    <button onclick="saveGanttOnServer();" class="button first big requireWrite" style="display:none;" title="Save">Save</button>
    <button onclick='newProject();' class='button requireWrite newproject' style="display:none;"><em>clear project</em></button>
    <button class="button login" title="login/enroll" onclick="loginEnroll($(this));" style="display:none;">login/enroll</button>
    <button class="button opt collab" title="Start with Twproject" onclick="collaborate($(this));" style="display:none;"><em>collaborate</em></button>
    </div></div>
  --></div>

                <div class="__template__" type="TASKSEDITHEAD"><!--
  <table class="gdfTable" cellspacing="0" cellpadding="0">
    <thead>
    <tr style="height:40px">
      <th class="gdfColHeader" style="width:35px; border-right: none"></th>
      <th class="gdfColHeader" style="width:25px;"></th>
      <th class="gdfColHeader gdfResizable" style="width:100px;">编号</th>
      <th class="gdfColHeader gdfResizable" style="width:300px;">事项</th>
      <th class="gdfColHeader"  align="center" style="width:17px;" title="里程碑开始日期."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">开始日期</th>
      <th class="gdfColHeader"  align="center" style="width:17px;" title="里程碑结束日期."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">结束日期</th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">用时.</th>
      <th class="gdfColHeader gdfResizable" style="width:20px;">进度%</th>
      <th class="gdfColHeader gdfResizable requireCanSeeDep" style="width:50px;">依赖.</th>
      <th class="gdfColHeader gdfResizable" style="width:1000px; text-align: left; padding-left: 10px;">经办人</th>
    </tr>
    </thead>
  </table>
  --></div>

                <div class="__template__" type="TASKROW"><!--
  <tr id="tid_(#=obj.id#)" taskId="(#=obj.id#)" class="taskEditRow (#=obj.isParent()?'isParent':''#) (#=obj.collapsed?'collapsed':''#)" level="(#=level#)">
    <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
    <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
    <td class="gdfCell"><input type="text" name="code" value="(#=obj.code?obj.code:''#)" placeholder="code/short name"></td>
    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10+18#)px;">
      <div class=" (#=obj.isSprintTop()?' is_sprint_top':'exp-controller'#) (#=obj.isModuleTop()?' is_module_top':'exp-controller'#)" align="center"></div>
      <input type="text" name="name" value="(#=obj.name#)" placeholder="name">
    </td>
    <td class="gdfCell" align="center"><input type="checkbox" name="startIsMilestone"></td>
    <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
    <td class="gdfCell" align="center"><input type="checkbox" name="endIsMilestone"></td>
    <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
    <td class="gdfCell"><input type="text" name="duration" autocomplete="off" value="(#=obj.duration#)"></td>
    <td class="gdfCell"><input type="text" name="progress" class="validated" entrytype="PERCENTILE" autocomplete="off" value="(#=obj.progress?obj.progress:''#)" (#=obj.progressByWorklog?"readOnly":""#)></td>
    <td class="gdfCell requireCanSeeDep"><input type="text" name="depends" autocomplete="off" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
    <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
  </tr>
  --></div>


                <div class="__template__" type="TASKEMPTYROW"><!--
  <tr class="taskEditRow emptyRow" >
    <th class="gdfCell" align="right"></th>
    <td class="gdfCell noClip" align="center"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell requireCanSeeDep"></td>
    <td class="gdfCell"></td>
  </tr>
  --></div>

                <div class="__template__" type="TASKBAR"><!--
  <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
    <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
      <div class="taskStatus" status="(#=obj.status#)"></div>
      <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
      <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

      <div class="taskLabel"></div>
      <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
    </div>
  </div>
  --></div>


                <div class="__template__" type="CHANGE_STATUS"><!--
    <div class="taskStatusBox">
    <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="Active"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="Completed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="Failed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="Suspended"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_WAITING" title="Waiting" style="display: none;"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="Undefined"></div>
    </div>
  --></div>




                <div class="__template__" type="TASK_EDITOR"><!--
  <div class="ganttTaskEditor">
    <h2 class="taskData">Task editor</h2>
    <table  cellspacing="1" cellpadding="5" width="100%" class="taskData table" border="0">
          <tr>
        <td width="200" style="height: 80px"  valign="top">
          <label for="code">code/short name</label><br>
          <input type="text" name="code" id="code" value="" size=15 class="formElements" autocomplete='off' maxlength=255 style='width:100%' oldvalue="1">
        </td>
        <td colspan="3" valign="top"><label for="name" class="required">name</label><br><input type="text" name="name" id="name"class="formElements" autocomplete='off' maxlength=255 style='width:100%' value="" required="true" oldvalue="1"></td>
          </tr>


      <tr class="dateRow">
        <td nowrap="">
          <div style="position:relative">
            <label for="start">start</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" id="startIsMilestone" name="startIsMilestone" value="yes"> &nbsp;<label for="startIsMilestone">is milestone</label>&nbsp;
            <br><input type="text" name="start" id="start" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
            <span title="calendar" id="starts_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>          </div>
        </td>
        <td nowrap="">
          <label for="end">End</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="checkbox" id="endIsMilestone" name="endIsMilestone" value="yes"> &nbsp;<label for="endIsMilestone">is milestone</label>&nbsp;
          <br><input type="text" name="end" id="end" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
          <span title="calendar" id="ends_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>
        </td>
        <td nowrap="" >
          <label for="duration" class=" ">Days</label><br>
          <input type="text" name="duration" id="duration" size="4" class="formElements validated durationdays" title="Duration is in working days." autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DURATIONDAYS">&nbsp;
        </td>
      </tr>

      <tr>
        <td  colspan="2">
          <label for="status" class=" ">status</label><br>
          <select id="status" name="status" class="taskStatus" status="(#=obj.status#)"  onchange="$(this).attr('STATUS',$(this).val());">
            <option value="STATUS_ACTIVE" class="taskStatus" status="STATUS_ACTIVE" >active</option>
            <option value="STATUS_WAITING" class="taskStatus" status="STATUS_WAITING" >suspended</option>
            <option value="STATUS_SUSPENDED" class="taskStatus" status="STATUS_SUSPENDED" >suspended</option>
            <option value="STATUS_DONE" class="taskStatus" status="STATUS_DONE" >completed</option>
            <option value="STATUS_FAILED" class="taskStatus" status="STATUS_FAILED" >failed</option>
            <option value="STATUS_UNDEFINED" class="taskStatus" status="STATUS_UNDEFINED" >undefined</option>
          </select>
        </td>

        <td valign="top" nowrap>
          <label>progress</label><br>
          <input type="text" name="progress" id="progress" size="7" class="formElements validated percentile" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="PERCENTILE">
        </td>
      </tr>

          </tr>
          <tr>
            <td colspan="4">
              <label for="description">Description</label><br>
              <textarea rows="3" cols="30" id="description" name="description" class="formElements" style="width:100%"></textarea>
            </td>
          </tr>
        </table>

    <h2>Assignments</h2>
  <table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable">
    <tr>
      <th style="width:100px;">name</th>
      <th style="width:70px;">Role</th>
      <th style="width:30px;">est.wklg.</th>
      <th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
    </tr>
  </table>

  <div style="text-align: right; padding-top: 20px">
    <span id="saveButton" class="button first" onClick="$(this).trigger('saveFullEditor.gantt');">Save</span>
  </div>

  </div>
  --></div>



                <div class="__template__" type="ASSIGNMENT_ROW"><!--
  <tr taskId="(#=obj.task.id#)" assId="(#=obj.assig.id#)" class="assigEditRow" >
    <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
    <td ><select type="select" name="roleId"  class="formElements"></select></td>
    <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delAssig del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>



                <div class="__template__" type="RESOURCE_EDITOR"><!--
  <div class="resourceEditor" style="padding: 5px;">

    <h2>Project team</h2>
    <table  cellspacing="1" cellpadding="0" width="100%" id="resourcesTable">
      <tr>
        <th style="width:100px;">name</th>
        <th style="width:30px;" id="addResource"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
      </tr>
    </table>

    <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="button big">Save</button></div>
  </div>
  --></div>



                <div class="__template__" type="RESOURCE_ROW"><!--
  <tr resId="(#=obj.id#)" class="resRow" >
    <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delRes del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>


            </div>

        </div>
    </div>
    </div>
</div>

</div>

<div class="modal" id="modal-create-issue" style=" padding-right: 16px;">
    <form class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form" id="create_issue" action="/issue/main/add" accept-charset="UTF-8" method="post">
        <div class="modal-dialog issue-modal-dialog" style="width: 800px;">
            <div class="modal-content issue-modal-content">
                <div class="modal-header issue-modal-header">

                    <h3 class="modal-header-title">添加事项</h3>

                    <a class="close" data-dismiss="modal" href="#">×</a>
                </div>
                <div class="modal-body issue-modal-body">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="params[project_id]" id="project_id" value="1">
                    <input type="hidden" name="params[master_issue_id]" id="master_issue_id" value="">
                    <input type="hidden" name="authenticity_token" value="">

                        <div class="form-group">
                            <label class="control-label" for="issue_type">事项类型:</label>
                            <div class="col-sm-10">
                                <select id="create_issue_types_select" name="params[issue_type]"
                                        class="selectpicker"
                                        dropdownAlignRight="true"
                                        data-live-search="true"
                                        title="">
                                    <option value="">请选择类型</option>
                                </select>
                            </div>
                        </div>
                        <hr id="create_header_hr" style="display: block;">

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">标 题:<span class="required"> *</span></div>
                        <div class="col-sm-8"><input type="text" class="form-control" name="params[summary]" id="create_issue_text_summary"  value=""  />
                            <p id="tip-summary" class="gl-field-error hide"></p></div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">经办人:<span class="required"> *</span></div>
                        <div class="col-sm-8">
                            <div class="issuable-form-select-holder">
                                <input type="hidden" value="" name="params[assignee]" id="create_issue_user_assignee"/>
                                <div class="dropdown ">
                                    <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search"
                                            type="button" data-first-user="sven"
                                            data-null-user="true"
                                            data-current-user="true"
                                            data-project-id="1"
                                            data-selected="null"
                                            data-field-name="params[assignee]"
                                            data-default-label="经办人"
                                            data-selected=""
                                            data-toggle="dropdown">
                                        <span class="dropdown-toggle-text is-default">经办人</span>
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                        <div class="dropdown-title">
                                            <span>选择经办人</span>
                                            <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                <i class="fa fa-times dropdown-menu-close-icon"></i>
                                            </button>
                                        </div>
                                        <div class="dropdown-input">
                                            <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee"
                                                   autocomplete="off"/>
                                            <i class="fa fa-search dropdown-input-search"></i>
                                            <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                        </div>
                                        <div class="dropdown-content "></div>
                                        <div class="dropdown-loading">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="assign-to-me-link " href="#">赋予给我</a>

                            <p id="tip-assignee" class="gl-field-error hide"></p></div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">迭 代:<span class="required"> *</span></div>
                        <div class="col-sm-8"><select id="create_issue_sprint" name="params[sprint]" class="selectpicker"  title=""   ><option value="0">待办事项</option><option data-content="<span >Sprint1</span>" value="65" selected>Sprint1</option><option data-content="<span >Sprint2</span>" value="43" >Sprint2</option><option data-content="<span ></span>" value="undefined" ></option><option data-content="<span ></span>" value="undefined" ></option></select>
                            <p id="tip-sprint" class="gl-field-error hide"></p></div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">开始日期:<span class="required"> *</span></div>
                        <div class="col-sm-8">
                            <input type="text" class="laydate_input_date form-control" name="params[start_date]" id="laydate_start_date"  value=""  />
                            <p id="tip-summary" class="gl-field-error hide"></p>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">截止日期:<span class="required"> *</span></div>
                        <div class="col-sm-8">
                            <input type="text" class="laydate_input_date form-control" name="params[due_date]" id="laydate_due_date"  value=""  />
                            <p id="tip-summary" class="gl-field-error hide"></p>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">起始里程碑:<span class="required"> *</span></div>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="params[is_start_milestone]" id="is_start_milestone" >
                                </label>
                            </div>
                            <p id="tip-summary" class="gl-field-error hide"></p>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">结束里程碑:<span class="required"> *</span></div>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="params[is_end_milestone]" id="is_end_milestone" >
                                </label>
                            </div>
                            <p id="tip-summary" class="gl-field-error hide"></p>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">用时(天):</div>
                        <div class="col-sm-4">

                            <div data-trigger="spinner">
                                <div class="row">
                                    <div class="col-md-2"><button type="button" data-spin="up">+</button></div>
                                    <div class="col-md-8"><input type="text"   class="form-control" name="params[duration]" id="duration"  value="1" data-ruler="quantity"></div>
                                    <div class="col-md-2"><button type="button" data-spin="down">-</button></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-5"></div>
                    </div>

                    <div class=" form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">描 述:</div>
                        <div class="col-sm-8">

                            <div id="description_md">
                                <textarea style="display:none;" name="params[description]" id="description"></textarea>
                            </div>
                            <div class="help-block"><a href="https://zh.wikipedia.org/wiki/Markdown" target="_blank">help</a></div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                </div>
                <div class="modal-footer issue-modal-footer footer-block row-content-block">
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    <span class="append-right-10">
                    <input id="btn-add" type="button" name="commit" value="保存" class="btn btn-save">
                </span>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="/dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="/dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript">

    var ge;
    $(function() {
        var canWrite=true; //this is the default for test purposes

        // here starts gantt initialization
        ge = new GanttMaster();
        ge.set100OnClose=true;

        ge.shrinkParent=true;

        ge.init($("#workSpace"));
        loadI18n(); //overwrite with localized ones

        //in order to force compute the best-fitting zoom level
        delete ge.gantt.zoom;

        var project=loadFromLocalStorage();

        if (!project.canWrite)
            $(".ganttButtonBar button.requireWrite").attr("disabled","true");

        ge.loadProject(project);
        ge.checkpoint(); //empty the undo stack
    });



    function getDemoProject(){
        //console.debug("getDemoProject")

        ret= {};
        var method = 'get';
        var url = '/project/gantt/fetchProjectIssues/<?=$project_id?>';
        $.ajax({
            type: method,
            dataType: "json",
            async: false,
            url: url,
            data: {} ,
            success: function (resp) {
                ret = resp.data;
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



    function loadGanttFromServer(taskId, callback) {

        //this is a simulation: load data from the local storage if you have already played with the demo or a textarea with starting demo data
        var ret=loadFromLocalStorage();

        //this is the real implementation
        /*
        //var taskId = $("#taskSelector").val();
        var prof = new Profiler("loadServerSide");
        prof.reset();

        $.getJSON("ganttAjaxController.jsp", {CM:"LOADPROJECT",taskId:taskId}, function(response) {
          //console.debug(response);
          if (response.ok) {
            prof.stop();

            ge.loadProject(response.project);
            ge.checkpoint(); //empty the undo stack

            if (typeof(callback)=="function") {
              callback(response);
            }
          } else {
            jsonErrorHandling(response);
          }
        });
        */

        return ret;
    }


    function saveGanttOnServer() {

        //this is a simulation: save data to the local storage or to the textarea
        saveInLocalStorage();

        /*
        var prj = ge.saveProject();

        delete prj.resources;
        delete prj.roles;

        var prof = new Profiler("saveServerSide");
        prof.reset();

        if (ge.deletedTaskIds.length>0) {
          if (!confirm("TASK_THAT_WILL_BE_REMOVED\n"+ge.deletedTaskIds.length)) {
            return;
          }
        }

        $.ajax("ganttAjaxController.jsp", {
          dataType:"json",
          data: {CM:"SVPROJECT",prj:JSON.stringify(prj)},
          type:"POST",

          success: function(response) {
            if (response.ok) {
              prof.stop();
              if (response.project) {
                ge.loadProject(response.project); //must reload as "tmp_" ids are now the good ones
              } else {
                ge.reset();
              }
            } else {
              var errMsg="Errors saving project\n";
              if (response.message) {
                errMsg=errMsg+response.message+"\n";
              }

              if (response.errorMessages.length) {
                errMsg += response.errorMessages.join("\n");
              }

              alert(errMsg);
            }
          }

        });
        */
    }

    function newProject(){
        clearGantt();
    }


    function clearGantt() {
        ge.reset();
    }

    //-------------------------------------------  Get project file as JSON (used for migrate project from gantt to Teamwork) ------------------------------------------------------
    function getFile() {
        $("#gimBaPrj").val(JSON.stringify(ge.saveProject()));
        $("#gimmeBack").submit();
        $("#gimBaPrj").val("");

        /*  var uriContent = "data:text/html;charset=utf-8," + encodeURIComponent(JSON.stringify(prj));
         neww=window.open(uriContent,"dl");*/
    }


    function loadFromLocalStorage() {
        var ret;
        ret=getDemoProject();
        return ret;
        if (localStorage) {
            if (localStorage.getObject("teamworkGantDemo")) {
                ret = localStorage.getObject("teamworkGantDemo");
            }
        }

        //if not found create a new example task
        if (!ret || !ret.tasks || ret.tasks.length == 0){
            ret=getDemoProject();
        }
        return ret;
    }


    function saveInLocalStorage() {
        var prj = ge.saveProject();
        console.log(prj);
        if (localStorage) {
            //localStorage.setObject("teamworkGantDemo", prj);
        }
    }


    //-------------------------------------------  Open a black popup for managing resources. This is only an axample of implementation (usually resources come from server) ------------------------------------------------------
    function editResources(){

        //make resource editor
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
    }


    function showBaselineInfo (event,element){
        //alert(element.attr("data-label"));
        $(element).showBalloon(event, $(element).attr("data-label"));
        ge.splitter.secondBox.one("scroll",function(){
            $(element).hideBalloon();
        })
    }

</script>

<script type="text/javascript">
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
            "CANNOT_WRITE":"No permission to change the following task:",
            "CHANGE_OUT_OF_SCOPE":"Project update not possible as you lack rights for updating a parent project.",
            "START_IS_MILESTONE":"Start date is a milestone.",
            "END_IS_MILESTONE":"End date is a milestone.",
            "TASK_HAS_CONSTRAINTS":"Task has constraints.",
            "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":"Error: there is a dependency on an open task.",
            "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK":"Error: due to a descendant of a closed task.",
            "TASK_HAS_EXTERNAL_DEPS":"This task has external dependencies.",
            "GANNT_ERROR_LOADING_DATA_TASK_REMOVED":"GANNT_ERROR_LOADING_DATA_TASK_REMOVED",
            "CIRCULAR_REFERENCE":"Circular reference.",
            "CANNOT_DEPENDS_ON_ANCESTORS":"Cannot depend on ancestors.",
            "INVALID_DATE_FORMAT":"The data inserted are invalid for the field format.",
            "GANTT_ERROR_LOADING_DATA_TASK_REMOVED":"An error has occurred while loading the data. A task has been trashed.",
            "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE":"Cannot close a task with open issues",
            "TASK_MOVE_INCONSISTENT_LEVEL":"You cannot exchange tasks of different depth.",
            "CANNOT_MOVE_TASK":"CANNOT_MOVE_TASK",
            "PLEASE_SAVE_PROJECT":"PLEASE_SAVE_PROJECT",
            "GANTT_SEMESTER":"Semester",
            "GANTT_SEMESTER_SHORT":"s.",
            "GANTT_QUARTER":"Quarter",
            "GANTT_QUARTER_SHORT":"q.",
            "GANTT_WEEK":"Week",
            "GANTT_WEEK_SHORT":"w."
        };
    }

    function createNewResource(el) {
        var row = el.closest("tr[taskid]");
        var name = row.find("[name=resourceId_txt]").val();
        var url = contextPath + "/applications/teamwork/resource/resourceNew.jsp?CM=ADD&name=" + encodeURI(name);

        openBlackPopup(url, 700, 320, function (response) {
            //fillare lo smart combo
            if (response && response.resId && response.resName) {
                //fillare lo smart combo e chiudere l'editor
                row.find("[name=resourceId]").val(response.resId);
                row.find("[name=resourceId_txt]").val(response.resName).focus().blur();
            }

        });
    }
</script>
<script type="text/javascript">

    var _cur_project_id = '<?=$project_id?>';

    var _simplemde = {};
    var _editor_md = null;

    var _cur_uid = null;
    var _editor_md = null;

    var $IssueMain = null;

    _editor_md = editormd({
        id   : "description_md",
        placeholder : "",
        width: "100%",
        height: 240,
        markdown: "",
        path: '/dev/lib/editor.md/lib/',
        imageUpload: true,
        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
        imageUploadURL: "/issue/detail/editormd_upload",
        saveHTMLToTextarea: true,
        autoFocus : false,
        tocm: true,    // Using [TOCM]
        emoji: true,
        saveHTMLToTextarea: true,
        toolbarIcons      : "custom",
    });
    var _issueConfig = {
        "priority":<?=json_encode($priority)?>,
        "issue_types":<?=json_encode($issue_types)?>,
        "issue_status":<?=json_encode($issue_status)?>,
        "issue_resolve":<?=json_encode($issue_resolve)?>,
        "issue_module":<?=json_encode($project_modules)?>,
        "issue_version":<?=json_encode($project_versions)?>,
        "issue_labels":<?=json_encode($project_labels)?>,
        "users":<?=json_encode($users)?>,
        "projects":<?=json_encode($projects)?>
    };

    function initIssueType(issue_types) {
        console.log(issue_types)
        var issue_types_select = document.getElementById('create_issue_types_select');
        $('#create_issue_types_select').empty();

        for (var _key in  issue_types) {

            issue_types_select.options.add(new Option(issue_types[_key].name, issue_types[_key].id));
        }
        //$('.selectpicker').selectpicker('refresh');
    }

    $(function(){
        // 聚焦模式切换
        $('#toggle_focus_mode').bind('click',function(){
            $('.main-sidebar').toggleClass('hidden');
            $('.with-horizontal-nav').toggleClass('hidden');
            $('.layout-nav').toggleClass('hidden');
        });
        new UsersSelect();
        initIssueType(window._issueConfig.issue_types);
        $(".laydate_input_date").each(function (i) {
            var id = $(this).attr('id');
            laydate.render({
                elem: '#' + id,
                position: 'fixed'
            });
        });



        $("#modal-create-issue").on('show.bs.modal', function (e) {

             if (_cur_project_id != '') {
                 var issue_types = [];
                 _cur_form_project_id = _cur_project_id;
                 for (key in _issueConfig.issue_types) {
                     issue_types.push(_issueConfig.issue_types[key]);
                 }
                 IssueMain.prototype.initCreateIssueType(issue_types, true);
             } else {
                 _cur_form_project_id = "";
             }
             keyMaster.addKeys([
                 {
                     key: ['command+enter', 'ctrl+enter'],
                     'trigger-element': '#modal-create-issue .btn-save',
                     trigger: 'click'
                 },
                 {
                     key: 'esc',
                     'trigger-element': '#modal-create-issue .close',
                     trigger: 'click'
                 }
             ])
         })

    })

</script>
</body>
</html>

