<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
   <style>

       .container {
           width: 100%;
           margin: auto;
           min-width: 1100px;
           position: relative;
           padding: 10px;
       }

       .tile_40 {
           width: 40%;
       }

       .tile_60 {
           width: 60%;
       }

       .tile__name {
           cursor: move;
           padding-bottom: 10px;
           border-bottom: 1px solid #FF7373;
       }

       .tile__list {
           margin-top: 10px;
       }


   </style>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid"  >

                    <div id="multi" class="container row">

                            <div class="col-md-4 group_panel">
                                <div class="panel panel-info">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading tile__name " data-force="25" draggable="false" >分配给我的问题</div>
                                    <div class="panel-body">
                                        <!-- Table -->
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>类型</th>
                                                <th>优先级</th>
                                                <th>主题</th>
                                            </tr>
                                            </thead>
                                            <script id="assignee_issue_tpl" type="text/html" >
                                                {{#issues}}
                                                <tr>
                                                    <th scope="row">#{{id}}</th>
                                                    <td>{{issue_type_html issue_type}}</td>
                                                    <td>{{priority_html priority }}</td>
                                                    <td><a href="<?= ROOT_URL ?>issue/detail/index/{{id}}" >{{summary}}</a></td>
                                                </tr>
                                                {{/issues}}
                                            </script>
                                            <script id="assignee_more" type="text/html" >
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td><a href="#" style="float: right">更 多</a> </td>
                                                </tr>
                                            </script>
                                            <tbody id="panel_assignee_issues">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel panel-info">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading tile__name " data-force="25" draggable="false" >我参与的项目</div>
                                    <div class="panel-body">
                                        <!-- Table -->
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>图标</th>
                                                <th>地址</th>
                                                <th>名称</th>
                                                <th>负责人</th>
                                            </tr>
                                            </thead>
                                            <script id="join_project_tpl" type="text/html" >
                                                {{#projects}}
                                                <tr>
                                                    <td>
                                                        {{#if avatar_exist}}
                                                        <a href="#" class="avatar-image-container">
                                                            <img src="{{avatar}}"  class="avatar has-tooltip s40">
                                                        </a>
                                                        {{^}}
                                                        <div class="avatar-container s40" style="display: block">
                                                            <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
                                                                <div class="avatar project-avatar s40 identicon"
                                                                     style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                                                            </a>
                                                        </div>
                                                        {{/if}}
                                                    </td>
                                                    <td  >/{{path}}/{{key}}</td>
                                                    <td>{{name}}</td>
                                                    <td>{{user_html default_assignee }}</td>
                                                </tr>
                                                {{/projects}}
                                            </script>
                                            <script id="panel_join_projects_more" type="text/html" >
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td><a href="#" style="float: right">更 多</a> </td>
                                                </tr>
                                            </script>

                                            <tbody id="panel_join_projects">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        <div class="col-md-8 group_panel">
                            <div class="panel panel-info">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false" >活动动态</div>
                                <div class="panel-body">
                                    <script id="activity_tpl" type="text/html" >
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title=""
                                                      datetime="{{time_full}}"
                                                      data-toggle="tooltip"
                                                      data-placement="top"
                                                      data-container="body"
                                                      data-original-title="{{time_full}}"
                                                      data-tid="449">{{time_text}}</time>
                                            </div>
                                            <div class="system-note-image pushed-to-icon">
                                                {{type}}
                                            </div>
                                            <div class="system-note-image user-avatar">
                                                <a href="/huqiang"><img class="avatar has-tooltip s32 hidden-xs" alt="胡强's avatar" title="胡强" data-container="body" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=64&amp;d=identicon"></a>
                                            </div>
                                            <div class="event-title">
                                                <span class="author_name">
                                                    <a  href="/user/profile/{{user_id}}">{{user_id}}</a>
                                                </span>
                                                <span class="pushed">{{action}} {{title}}</span>

                                            </div>
                                            <div class="event-body">
                                                <span  >{{detail}}</span>
                                            </div>

                                        </div>
                                        </div>

                                    </script>
                                    <div   id="panel_activity"  >

                                    </div>
                                    <div id="panel_activity_more" class="hide"><a href="#" style="float: right">更 多</a> </div>
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

<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/panel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>

<script type="text/javascript">

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

    var $panel = null;
    var _cur_page = 1;
    $(function() {
        var options = {
        }
        window.$panel = new Panel( options );
        window.$panel.fetchPanelAssigneeIssues( 1 );
        window.$panel.fetchPanelActivity( _cur_page );
        window.$panel.fetchPanelJoinProjects();
    });


</script>
</body>
</html>