<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?=ROOT_URL?>dev/css/dashboard.css" rel="stylesheet" type="text/css"/>
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

        <div class="content-header">
            <!--            <div class="breadcrumb">-->
            <!--                首页-->
            <!--            </div>-->

            <div class="user-profile">
                <div class="user-profile-content">
                    <div class="user-avatar">
                        <img src="<?= $user['avatar'] ?>" alt="">
                    </div>

                    <div class="user-profile-text">
                        <div class="text-title"><span id="current_time"></span><?= $user['display_name'] ?>，祝你开心每一天！</div>
                        <div class="text-content">技术总监 | 某某公司－某某某事业群－某某平台部－某某技术部－UED</div>
                    </div>
                </div>

                <ul class="user-profile-extra">
                    <li class="extra-item">
                        <p class="extra-item-title">项目数</p>
                        <p class="extra-item-num">56</p>
                    </li>

                    <li class="extra-item">
                        <p class="extra-item-title">项目数</p>
                        <p class="extra-item-num">56</p>
                    </li>

                    <li class="extra-item">
                        <p class="extra-item-title">项目数</p>
                        <p class="extra-item-num">56</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content container-fluid" id="content-body">
            <div id="multi" class="container row">
                <div class="col-md-8 group_panel">
                    <div class="panel panel-info">
                        <!-- Default panel contents -->
                        <div class="panel-heading tile__name" data-force="25" draggable="false" >
                            <h3 class="panel-heading-title">我参与的项目</h3>
                            <div class="panel-heading-extra"><a href="<?=ROOT_URL?>/projects">全部项目</a></div>
                        </div>
                        <div class="panel-body padding-0">
                            <ul class="panel-project" id="panel_join_projects">

                            </ul>

                            <script id="join_project_tpl" type="text/html" >
                                {{#projects}}
                                <li class="event-block project-item col-md-4">
                                    <div class="project-item-title">
                                        {{#if avatar_exist}}
                                        <span class="g-avatar g-avatar-md project-item-pic">
                                            <img src="{{avatar}}">
                                        </span>
                                        {{^}}
                                        <span class="g-avatar g-avatar-md project-item-pic pic-bg">
                                            {{first_word}}
                                        </span>
                                        {{/if}}

                                        <span class="project-item-name">
                                            <a href="<?=ROOT_URL?>/{{path}}/{{key}}">{{name}}</a>
                                        </span>
                                    </div>

                                    <div class="project-item-body">
                                        {{user_html default_assignee }}
                                    </div>

                                    <div class="project-item-footer">
                                        <span class="footer-text">{{type_name}}</span>

                                        <time class="footer-time js-timeago js-timeago-render" title=""
                                              datetime="{{create_time}}"
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              data-container="body"
                                              data-original-title="{{create_time}}"
                                              data-tid="449">{{create_time}}</time>
                                    </div>
                                </li>
                                {{/projects}}
                            </script>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <!-- Default panel contents -->
                        <div class="panel-heading tile__name " data-force="25" draggable="false" >
                            <h3 class="panel-heading-title">活动动态</h3>
                            <div class="panel-heading-extra hide" id="panel_activity_more"><a href="#">全部动态</a></div>
                        </div>

                        <div class="panel-body">
                            <ul class="event-list" id="panel_activity">
                            </ul>

                            <script id="activity_tpl" type="text/html" >
                                {{#activity}}
                                <li class="event-list-item">
                                    <div class="g-avatar g-avatar-lg event-list-item-avatar">
											<span class="event-avatar">
												<img src="https://gw.alipayobjects.com/zos/rmsportal/gaOngJwsRYRaVAuXXcmB.png">
											</span>
                                    </div>

                                    <div class="event-list-item-content">
                                        <h4 class="event-list-item-title">
                                            <a class="username">{{user_html user_id}}</a>
                                            <span class="event">在
                                                <a href="#">{{title}}</a> {{action}}
                                                <a href="#">{{type}}</a>
											</span>
                                        </h4>

                                        <time class="event-time js-timeago js-timeago-render" title=""
                                              datetime="{{time_full}}"
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              data-container="body"
                                              data-original-title="{{time_full}}"
                                              data-tid="449">{{time_text}}</time>
                                    </div>
                                </li>

<!--                                <div class="event-block event-item" style="padding: 10px 0 10px 10px;">-->
<!--                                    <div class="event-item-timestamp">-->
<!--                                        <time class="js-timeago js-timeago-render" title=""-->
<!--                                              datetime="{{time_full}}"-->
<!--                                              data-toggle="tooltip"-->
<!--                                              data-placement="top"-->
<!--                                              data-container="body"-->
<!--                                              data-original-title="{{time_full}}"-->
<!--                                              data-tid="449">{{time_text}}</time>-->
<!--                                    </div>-->
<!--                                    {{user_html user_id}}-->
<!--                                    <div class="event-title">-->
<!---->
<!--                                                <span class="author_name">-->
<!--                                                    <a  href="/user/profile/{{user_id}}">{{user.display_name}}</a>-->
<!--                                                </span>-->
<!--                                        <span class="pushed">{{action}} {{type}} {{title}}</span>-->
<!---->
<!--                                    </div>-->
<!--                                    <div class="event-body">-->
<!--                                        <span  >{{detail}}</span>-->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!--                                </div>-->
                                {{/activity}}
                            </script>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 group_panel">
                    <div class="panel panel-info">
                        <!-- Default panel contents -->
                        <div class="panel-heading tile__name " data-force="25" draggable="false" >
                            <h3 class="panel-heading-title">分配给我的问题</h3>
                            <div class="panel-heading-extra"><a href="#">全部问题</a></div>
                        </div>

                        <div class="panel-body">
                            <div class="link-group" id="panel_assignee_issues">
                                <a href="#/">操作一</a>
                            </div>

                            <script id="assignee_issue_tpl" type="text/html" >
                                {{#issues}}
                                <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">{{summary}}</a>
                                {{/issues}}
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
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

    (function () {
        'use strict';
        getCurrentTime();

        var byId = function (id) { return document.getElementById(id); },
            loadScripts = function (desc, callback) {
                var deps = [], key, idx = 0;

                for (key in desc) {
                    deps.push(key);
                }

                (function _next() {
                    var pid,
                        name = deps[idx],
                        script = document.createElement('script');

                    script.type = 'text/javascript';
                    script.src = desc[deps[idx]];

                    pid = setInterval(function () {
                        if (window[name]) {
                            clearTimeout(pid);

                            deps[idx++] = window[name];

                            if (deps[idx]) {
                                _next();
                            } else {
                                callback.apply(null, deps);
                            }
                        }
                    }, 30);

                    document.getElementsByTagName('head')[0].appendChild(script);
                })()
            },
            console = window.console;

        if (!console.log) {
            console.log = function () {
                alert([].join.apply(arguments, ' '));
            };
        }
        // Multi groups
        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el){
            Sortable.create(el, {
                group: 'photo',
                animation: 150
            });
        });

        //判断当前时间
        function getCurrentTime() {
            var now = new Date(),
                hour = now.getHours(),
                dom = $("#current_time");

            if(hour < 6){dom.text("凌晨好！")}
            else if (hour < 9){dom.text("早上好！")}
            else if (hour < 12){dom.text("上午好！")}
            else if (hour < 14){dom.text("中午好！")}
            else if (hour < 17){dom.text("下午好！")}
            else if (hour < 19){dom.text("傍晚好！")}
            else if (hour < 22){dom.text("晚上好！")}
            else {dom.text("夜里好！")}
        }

    })();


</script>
</body>
</html>