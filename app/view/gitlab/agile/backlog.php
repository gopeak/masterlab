<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">
    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/issue/main/upload";
        window.preview_markdown_path = "/issue/main/preview_markdown";
    </script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>
    <link href="/<?= ROOT_URL ?>gitlab/assets/application.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/backlog.css">

    <script src="<?=ROOT_URL?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/form.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/detail.js" type="text/javascript" charset="utf-8"></script>

    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/editor.md/css/editormd.css"/>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/marked.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/prettify.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/editormd.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">

<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
<? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
<? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>


<script>
    var findFileURL = "";
</script>

<div class="page-with-sidebar">
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content padding-0" id="content-body">
                <div class="container-fluid padding-0">
                    <div class="nav-block">
                        <div class="controls">

                        </div>

                    </div>
                    <div class="issues-holder">
                        <div class="table-holder">

                            <div class="classification">
                                <div class="classification-side">
                                    <div class="classification-side-item">
                                        <div class="classification-title drag_to_backlog_closed" data-id="0" data-type="backlog">
                                            <a id="btn-backlog_issues" href="#" title="Backlog's issues"> 待办事项 </a>
                                        </div>
                                    </div>
                                    <div class="classification-side-item">
                                        <div class="classification-title drag_to_backlog_closed" data-id="-1" data-type="closed">
                                            <a id="btn-closed_issues" href="#" title="Closed's issues">  已关闭事项 </a>
                                        </div>
                                    </div>
                                    <div class="classification-side-item">
                                        <div class="classification-title" data-type="sprint">
                                            迭 代
                                            <a href="#" data-toggle="modal" data-target="#modal-sprint_add"
                                               title="Create a sprint" style="float: right;" class="js-key-create">
                                                <span class="">创  建</span>
                                            </a>
                                        </div>
                                        <div class="classification-inner" id="sprints_list_div">

                                        </div>
                                    </div>
                                </div>
                                <div class="classification-main">
                                    <div id="backlog_list" class="classification-backlog">
                                        <div class="classification-backlog-header">
                                            <div class="classification-backlog-name">Backlog</div>
                                            <div class="classification-backlog-issue-count"><span
                                                        id="backlog_count"></span> issues
                                            </div>
                                        </div>

                                        <div class="classification-backlog-inner" id="backlog_render_id">

                                        </div>
                                    </div>

                                    <div id="closed_list" class="classification-backlog hidden">
                                        <div class="classification-backlog-header">
                                            <div class="classification-backlog-name">Closed</div>
                                            <div class="classification-backlog-issue-count">
                                                <span id="closed_count"></span> issues
                                            </div>
                                        </div>

                                        <div class="classification-backlog-inner" id="closed_render_id">

                                        </div>
                                    </div>
                                    <div id="sprint_list" class="classification-backlog hidden">
                                        <div class="classification-backlog-header">
                                            <div class="classification-backlog-name"><span id="sprint_name"></span></div>
                                            <div class="classification-backlog-issue-count">
                                                <span id="sprint_count"></span> issues
                                            </div>
                                            <div class="classification-backlog-issue-create float-right">
                                                <a class="btn btn-new btn-sm js-key-create" data-target="#modal-create-issue" data-toggle="modal"
                                                   id="btn-create-issue" style="margin-bottom: 4px;"
                                                   href="#modal-create-issue"><i class="fa fa-plus fa-fw"></i>
                                                    添加事项
                                                </a>
                                            </div>
                                        </div>

                                        <div class="classification-backlog-inner" id="sprint_render_id">

                                        </div>
                                    </div>

                                    <?php include VIEW_PATH . 'gitlab/issue/detail-right-list.php'; ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

<div class="modal" id="modal-sprint_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_sprint_add"
          action="<?= ROOT_URL ?>agile/addSprint"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增Sprint</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="project_id" id="project_id" value="<?= $project_id ?>">
                    <div class="form-group">
                        <label class="control-label" for="id_name">名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="id_name" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <textarea class="form-control" name="params[description]"
                                          id="id_description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_name">开始时间:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="laydate_input_date form-control" name="params[start_date]"
                                       id="id_start_date" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_name">结束时间:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="laydate_input_date form-control" name="params[end_date]"
                                       id="id_end_date" value=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-create" id="btn-sprint_add">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-sprint_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_sprint_edit"
          action="<?= ROOT_URL ?>agile/updateSprint"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑Sprint</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="sprint_id" id="edit_sprint_id" value="">
                    <div class="form-group">
                        <label class="control-label" for="sprint_edit_name">名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="sprint_edit_name" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="sprint_edit_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <textarea class="form-control" name="params[description]"
                                          id="sprint_edit_description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="sprint_edit_start_date">开始时间:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="laydate_input_date form-control" name="params[start_date]"
                                       id="sprint_edit_start_date" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="sprint_edit_end_date">结束时间:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="laydate_input_date form-control" name="params[end_date]"
                                       id="sprint_edit_end_date" value=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-create" id="btn-sprint_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>

<div class="maskLayer hide"></div> --><!--背景遮罩-->

<script type="text/html" id="backlog_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="backlog" data-id="{{id}}">
        <div>
            <table>
                <tr>
                    <td>
                        {{issue_type_icon issue_type }}
                    </td>
                    <td>
                        <span class="label label-default" style="min-width: 40px">{{priority_html priority}}</span>
                    </td>
                    <td style="min-width: 40px">
                        {{status_html status}}
                    </td>
                    <td>
                        <span class="view-detail" data-issue-id="{{id}}" title="事项标题">#{{issue_num}} {{summary}}</span>
                    </td>
                    <td>
                        <span title="优先级权重值" class="label label-default text-primary">{{weight}}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <!-- <span class="label color-label has-tooltip" style="background-color: #F0AD4E; color: #FFFFFF" title="" data-container="body" data-original-title="red waring">Warn</span>-->
                    </td>
                    <td>
                        <span class="list-item-name">
                            {{user_html assignee}}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{/issues}}
</script>

<script type="text/html" id="sprint_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="sprint" data-id="{{id}}">
        <div>
            <table>
                <tr>
                    <td>
                        {{issue_type_icon issue_type }}
                    </td>
                    <td>
                        <span class="label label-default" style="min-width: 40px">{{priority_html priority}}</span>
                    </td>
                    <td style="min-width: 40px">
                        {{status_html status}}
                    </td>
                    <td>
                        <span class="view-detail" data-issue-id="{{id}}" title="事项标题">#{{issue_num}} {{summary}}</span>
                    </td>
                    <td>
                        <span title="优先级权重值" class="label label-default text-primary">{{weight}}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                       <!-- <span class="label color-label has-tooltip" style="background-color: #F0AD4E; color: #FFFFFF" title="" data-container="body" data-original-title="red waring">Warn</span>-->
                    </td>
                    <td>
                        <span class="list-item-name">
                            {{user_html assignee}}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{/issues}}
</script>

<script type="text/html" id="closed_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="closed" data-id="{{id}}">
        <div>
            <table>
                <tr>
                    <td>
                        {{issue_type_icon issue_type }}
                    </td>
                    <td>
                        <span class="label label-default" style="min-width: 40px">{{priority_html priority}}</span>
                    </td>
                    <td style="min-width: 40px">
                        {{status_html status}}
                    </td>
                    <td>
                        <span class="view-detail" data-issue-id="{{id}}" title="事项标题">#{{issue_num}} {{summary}}</span>
                    </td>
                    <td>
                        <span title="优先级权重值" class="label label-default text-primary">{{weight}}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <!-- <span class="label color-label has-tooltip" style="background-color: #F0AD4E; color: #FFFFFF" title="" data-container="body" data-original-title="red waring">Warn</span>-->
                    </td>
                    <td>
                        <span class="list-item-name">
                            {{user_html assignee}}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{/issues}}
</script>


<script type="text/html" id="sprints_list_tpl">
    {{#sprints}}
    <div class="classification-item" data-id="{{id}}" data-type="sprint">
        <div class="classification-item-inner">
            <div class="classification-item-header">
                <h3>
                    {{name}}
                    {{#if_eq active '1'}}
                    (进行中)
                    {{/if_eq}}
                    <a href="#"  class="sprint_edit" onclick="window.$backlog.showEditSprint('{{id}}')"  title="编辑迭代" style="float: right;">
                        <i class="fa fa-pencil"></i>
                    </a>
                </h3>
                <div class="classification-item-line"></div>
            </div>
            <div class="classification-item-expanded">
                <ul>
                    <li class="classification-item-group">
                        <div class="classification-item-group-cell">{{description}}</div>
                    </li>
                    <li class="classification-item-group">
                        <div class="classification-item-group-cell">开始时间:</div>
                        <div>
                            {{#if_eq start_date '0000-00-00'}}
                            {{^}}
                            {{start_date}}
                            {{/if_eq}}
                        </div>
                    </li>
                    <li class="classification-item-group">
                        <div class="classification-item-group-cell">结束时间:</div>
                        <div>
                            {{#if_eq end_date '0000-00-00'}}
                            {{^}}
                            {{end_date}}
                            {{/if_eq}}
                        </div>
                    </li>
                    {{#if_eq active '0'}}
                    <li class="classification-item-group">
                        <div class="classification-item-group-cell">操作:</div>
                        <div><a onclick="window.$backlog.setSprintActive({{id}})" class="btn-sprint_set_active" href="#" data-id="{{id}}" title="设置为进行中的Sprint">设置进行中</a>
                        </div>
                    </li>
                    {{/if_eq}}
                </ul>
            </div>
        </div>
    </div>
    {{/sprints}}
</script>

<script type="text/html" id="wrap_field">
    <div class=" form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-2">{{display_name}}:{{required_html}}</div>
        <div class="col-sm-8">{field_html}</div>
        <div class="col-sm-1"></div>
    </div>
</script>

<script type="text/html" id="nav_tab_li_tpl">
    <li role="presentation" class="active">
        <a id="a_{{id}}" href="#{{id}}" role="tab" data-toggle="tab">
            <span id="span_{{id}}">{{title}}&nbsp;</span>
        </a>
    </li>
</script>

<script type="text/html" id="content_tab_tpl">
    <div role="tabpanel" class="tab-pane " id="{{id}}">
        <div class="dd-list" id="{{type}}_ui_config-{{id}}" style="min-height: 200px">

        </div>
    </div>
</script>

<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">
    var _simplemde = {};

    var $backlog = null;
    var _issueConfig = {
        priority:<?=json_encode($priority)?>,
        issue_types:<?=json_encode($issue_types)?>,
        issue_status:<?=json_encode($issue_status)?>,
        issue_resolve:<?=json_encode($issue_resolve)?>,
        issue_module:<?=json_encode($project_modules)?>,
        issue_version:<?=json_encode($project_versions)?>,
        issue_labels:<?=json_encode($project_labels)?>,
        users:<?=json_encode($users)?>,
        projects:<?=json_encode($projects)?>
    };
    var isFloatPart = false;
    var _fineUploader = null;
    var _fineUploaderFile = {};

    var _page = '<?=$page_type?>';
    var _issue_id = null;

    var _cur_project_id = '<?=$project_id?>';
    var _active_sprint_id = '<?=@$active_sprint['id']?>';
    var $IssueMain = null;
    var _description_templates = <?=json_encode($description_templates)?>;

    $(function () {
        new UsersSelect();
        new LabelsSelect();
        new MilestoneSelect();
        new IssueStatusSelect();

        $("#btn-sprint_add").bind("click", function () {
            window.$backlog.addSprint();
        });

        $('#btn-sprint_update').bind("click", function () {
            window.$backlog.updateSprint();
        });

        $("#btn-closed_issues").bind("click", function () {
            window.$backlog.fetchClosedIssues(<?=$project_id?>);
        });
        $("#btn-backlog_issues").bind("click", function () {
            window.$backlog.fetchAll(<?=$project_id?>);
        });

        laydate.render({
            elem: '#id_start_date'
        });
        laydate.render({
            elem: '#id_end_date'
        });
        laydate.render({
            elem: '#sprint_edit_start_date'
        });
        laydate.render({
            elem: '#sprint_edit_end_date'
        });

        var options = {
            pagination_id: "pagination"
        }
        window.$backlog = new Backlog(options);
        if(window._page=='backlog'){
            window.$backlog.fetchAll(<?=$project_id?>);
        }
        if(window._page=='sprint'){
            window.$backlog.fetchSprintIssues(<?=$sprint_id?>);
        }

        window.$backlog.fetchSprints(<?=$project_id?>);
        var cSide = $('.classification-side');
        $(document).on('scroll', function(){
            if($(document).scrollTop() > 102){
                // console.log(cSide.offset().top)
                cSide.css({
                    top:0
                })
            }else{
                cSide.css({
                    top:102 - $(document).scrollTop()
                })
            }
        })

        /*点击选择view的样式*/
        $(document).on("click", ".view-detail", function () {
            var id = $(this).attr("data-issue-id");

            $(".view-detail.active").removeClass("active");
            $(this).addClass("active");
            $('.float-right-side').show();
            getRightPartData(id);
        });
        $('#view-detail').on('click', function (e) {
            $('#view_choice .active').removeClass('active');
            $('#list_render_id tr.active').removeClass('active');
            if ($(e.target).parent().attr('id') == 'view_choice') {
                $(e.target).addClass('active');
            }
        });

        //关闭左侧面板，以及点击出现左侧面板
        $('#issuable-header').on('click',function(e){
            if($(e.target).hasClass('fa-times')){
                $('.float-right-side').hide();
                $('.maskLayer').addClass('hide');
                $('#list_render_id tr.active').removeClass('active');
            }
        });

        //获取详情页信息
        function getRightPartData(dataId) {
            $('.maskLayer').removeClass('hide');//可以不要，但是由于跳转的时候速度太慢，所以防止用户乱点击
            _issue_id = dataId;

            $IssueDetail = new IssueDetail({});
            $IssueDetail.fetchIssue(dataId, true);
        }

        //点击创建事项
        $("#btn-create-issue").bind("click", function () {
            if (_cur_project_id != '') {
                console.log(_issueConfig.issue_types);
                var issue_types = [];
                for (key in _issueConfig.issue_types) {
                    issue_types.push(_issueConfig.issue_types[key]);
                }
                IssueMain.prototype.initCreateIssueType(issue_types, true);
            }
        });

        window.$IssueMain = new IssueMain(options);
        //右边悬浮层按钮事件
        $('#btn-edit').bind('click', function () {
            window.$IssueMain.fetchEditUiConfig(_issue_id, 'update');
        });

        $('#btn-copy').bind('click', function () {
            window.$IssueMain.fetchEditUiConfig(_issue_id, 'copy');
        });
    });

    var _curFineAttachmentUploader = null;
    var _curIssueId = null;
    var _curTmpIssueId = null;
    var _curQrToken = null;
    var mobileUploadInterval = null;
</script>

</body>
</html>
