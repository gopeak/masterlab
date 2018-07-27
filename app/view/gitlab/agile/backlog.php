<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link href="/<?= ROOT_URL ?>gitlab/assets/application.css">
    <style>
        .classification{
                position: relative;
                min-height: 400px;
                height: 100%;
            }
            .classification-main{
                margin-left: 15%;
            }
            .classification-side{
                width: 15%;
                position: absolute;
                left: -16px;
                top: 0;
                bottom: 0;
                border-right: 1px solid #ddd;
                overflow-y: scroll;
            }
            .classification-side-item{
                border-bottom: 1px solid #ddd;
            }
            .classification-title{
                font-size: 12px;
                font-weight: bolder;
                padding: 8px;
                background-color: #f5f5f5;
            }
            .classification-item{
                padding: 12px 8px;
                font-size: 12px;
                border-top: 1px dotted #ddd;
                border-bottom: 1px dotted #ddd;
                margin-bottom: -1px;
            }
            .classification-item.open{
                border-bottom: 1px solid #ddd;
                border-top: 1px solid #ddd;
            }
            .classification-item.open .classification-item-inner{
                height: auto;
            }
            .classification-item-inner{
                height: 30px;
                overflow: hidden;
            }
            .classification-item:hover{
                background-color: #fcfcfc;
            }
            .classification-item-header{
                cursor: pointer;
            }
            .classification-item-header h3{
                margin: 0;
                font-size: 14px;
                font-weight: normal;
            }
            .classification-item-line{
                background: #e5e5e5;
                margin-top: 5px;
                height: 5px;
            }
            .classification-item-expanded{

            }
            .classification-item-expanded ul{
                padding: 0;
                margin: 0;
            }
            .classification-item-expanded li{
                list-style: none;
                color: #666;
                font-size: inherit;
            }
            .classification-item-group{
                display: table;
                table-layout: fixed;
                width: 100%;
                margin-top: 10px;
            }
            .classification-item-group-cell{
                display: table-cell;
            }
            .classification-backlog-header{
                padding: 8px;
                /*border-bottom: 1px solid #ddd;*/
                display: flex;
                font-size: 12px;
            }
            .classification-backlog-name{
                font-weight: bolder;
            }
            .classification-backlog-issue-count{
                padding: 0 0 0 12px;
                color: #999;
            }
            .classification-backlog-inner{
                padding: 8px;
            }
            .classification-backlog-item{
                font-size: 14px;
                border: 1px solid #ddd;
                padding: 6px;
                border-left: 4px solid #ddd;
                cursor: move;
                margin: 0 0 -1px 0;
                background-color: #fff;
            }
            .classification-backlog-item:hover{
                border-left-color: #009900;
                background-color: #f5f5f5;
            }
            .classification-out-line{
                border: 2px dashed #999 !important;
            }
            .classification-none{
                display: none;
            }
            .classification-inner{
                padding: 10px;
            }
            .classification-inner .classification-backlog-item{
                display: none;
            }
            .chosen-item{
                border: 2px solid #ec0044;
            }

        /*.classification-item .sortable-chosen{
            display: none;
        }*/
    </style>

</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">

<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>
    </div>
</header>

<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>

<div class="page-with-sidebar">
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid">
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
                                            <a id="btn-backlog_issues" href="#" title="Backlog's issues"> Backlog </a>
                                        </div>
                                    </div>
                                    <div class="classification-side-item">
                                        <div class="classification-title drag_to_backlog_closed" data-id="-1" data-type="closed">
                                            <a id="btn-closed_issues" href="#" title="Closed's issues">  Closed </a>
                                        </div>
                                    </div>
                                    <div class="classification-side-item">
                                        <div class="classification-title" data-type="sprint">
                                            Sprints
                                            <a href="#" data-toggle="modal" data-target="#modal-sprint_add"
                                               title="Create a sprint" style="float: right;">
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
                                        </div>

                                        <div class="classification-backlog-inner" id="sprint_render_id">

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-sprint_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">新增Sprint</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_sprint_add"
                      action="<?= ROOT_URL ?>agile/addSprint" accept-charset="UTF-8" method="post">

                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="project_id" id="project_id" value="<?= $project_id ?>">
                    <div class="form-group">
                        <label class="control-label" for="id_name">名称:<span style="color: red"> *</span></label>
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

                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-create" id="btn-sprint_add">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="backlog_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="backlog" data-id="{{id}}">
        {{issue_type_html issue_type }}
        {{priority_html priority}}
        <a href="#">#{{id}}</a>
        <span> {{summary}}</span>
        <span class="list-item-name" style="float:right">
            {{user_html assignee}}
        </span>
    </div>
    {{/issues}}
</script>

<script type="text/html" id="sprint_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="sprint" data-id="{{id}}">
        {{issue_type_html issue_type }}
        {{priority_html priority}}
        <a href="#">#{{id}}</a>
        <span> {{summary}}</span>
        <span class="list-item-name" style="float:right">
            {{make_user assignee}}
        </span>
    </div>
    {{/issues}}
</script>

<script type="text/html" id="closed_issue_tpl">
    {{#issues}}
    <div id="backlog_issue_{{id}}" class="js-sortable classification-backlog-item" data-type="closed" data-id="{{id}}">
        {{issue_type_html issue_type }}
        {{priority_html priority}}
        <a href="#">#{{id}}</a>
        <span> {{summary}}</span>
        <span class="list-item-name" style="float:right">
            {{make_user assignee}}
        </span>
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
                </h3>
                <div class="classification-item-line"></div>
            </div>
            <div class="classification-item-expanded">
                <ul>
                    <li class="classification-item-group">
                        <div class="classification-item-group-cell">描述:</div>
                    </li>
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

<script src="<?= ROOT_URL ?>dev/js/jquery.min.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">

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

    var _page = '<?=$page_type?>';

    $(function () {

        $("#btn-sprint_add").bind("click", function () {
            window.$backlog.addSprint();
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
        var cSide = $('.classification-side')
        $(document).on('scroll', function(){
            //console.log($(document).scrollTop())
            if($(document).scrollTop() > 102){
                cSide.css({
                    position: "fixed",
                    left: 0
                })
            }else{
                cSide.css({
                    position: "absolute",
                    left: -15
                })
            }
        })
    });

</script>

</body>
</html>
