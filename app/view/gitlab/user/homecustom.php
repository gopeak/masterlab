<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css" rel="stylesheet" type="text/css"/>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

</head>
<body class="dashboard" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

        <script>
            var findFileURL = "";
        </script>
        <div class="page-with-sidebar">

            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">
                    <div class="flash-container flash-container-page">
                    </div>
                </div>

                <div class="content padding-0" id="content-body1">
                    <div class="cover-block user-cover-block">
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <?php
                            $profile_nav='custom_index';
                            include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="nav-controls">
                        <div class="btn-group" role="group">
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-tools-add" data-toggle="modal" href="#modal-tools-add">
                                <i class="fa fa-plus"></i>
                                添加小工具
                            </a>
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-layout" data-toggle="modal" href="#modal-layout">
                                <i class="fa fa-th-large"></i>
                                版式布局
                            </a>
                        </div>
                    </div>
                </div>

                <div class="content container-fluid" id="content-body">
                    <div id="multi" class="container layout-panel layout-aa row">
                        <div class="group_panel panel-first">
                            <div class="panel panel-info" data-sort="1">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name" data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">我参与的项目</h3>
                                    <div class="panel-heading-extra"><a href="<?= ROOT_URL ?>projects">更 多</a></div>
                                </div>
                                <div class="panel-body padding-0">
                                    <ul class="panel-project" id="panel_join_projects">

                                    </ul>

                                    <script id="join_project_tpl" type="text/html">
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
                                            <a href="<?= ROOT_URL ?>{{path}}/{{key}}">{{name}}</a>
                                        </span>

                                            </div>

                                            <div class="project-item-body">
                                                {{user_html create_uid }}
                                            </div>

                                            <div class="project-item-footer">
                                                <span class="footer-text">{{type_name}}</span>
                                                <time class="js-time"
                                                      datetime="{{create_time}}"
                                                      data-toggle="tooltip"
                                                      data-placement="top"
                                                      data-container="body"
                                                      data-original-title="{{create_time_text}}"
                                                      data-tid="{{id}}">
                                                </time>
                                            </div>
                                        </li>
                                        {{/projects}}
                                    </script>
                                </div>
                            </div>

                            <div class="panel panel-info" data-sort="3">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">分配给我的问题</h3>
                                    <div class="panel-heading-extra" id="panel_issue_more"><a href="<?= ROOT_URL ?>issue/main/?sys_filter=assignee_mine">更 多</a></div>
                                </div>

                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#id</th>
                                            <th>类型</th>
                                            <th>优先级</th>
                                            <th>主题</th>
                                        </tr>
                                        </thead>
                                        <script id="assignee_issue_tpl" type="text/html">
                                            {{#issues}}
                                            <tr>
                                                <th scope="row">#{{issue_num}}</th>
                                                <td>{{issue_type_html issue_type}}</td>
                                                <td>{{priority_html priority }}</td>
                                                <td><a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">{{summary}}</a></td>
                                            </tr>
                                            {{/issues}}
                                        </script>
                                        <!-- <script id="assignee_more" type="text/html">
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td><a href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine" style="float: right">更 多</a></td>
                                    </tr>
                                </script> -->
                                        <tbody id="panel_assignee_issues">


                                        </tbody>
                                    </table>
                                    <script id="assignee_more" type="text/html">
                                        <div class="assignee-more">
                                            <a href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               data-container="body"
                                               data-original-title="全部问题">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                        </div>
                                    </script>
                                </div>
                            </div>

                            <div class="panel panel-info" data-sort="5">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">活动动态</h3>
                                    <div class="panel-heading-extra hide" id="panel_activity_more"><a href="#">全部动态</a></div>
                                </div>

                                <div class="panel-body">
                                    <ul class="event-list" id="panel_activity">
                                    </ul>

                                    <script id="activity_tpl" type="text/html">
                                        {{#activity}}
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                {{user_html user_id}}
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="<?=ROOT_URL?>user/profile/{{user_id}}" class="username">{{user.display_name}}</a>
                                                    <span class="event">
                                                {{action}}
                                                {{#if_eq type ''}}
                                                    <a href="#">{{title}}</a>
                                                {{/if_eq}}
                                                {{#if_eq type 'agile'}}
                                                    <a href="<?=ROOT_URL?>default/ERP/sprints/{{obj_id}}">{{title}}</a>
                                                {{/if_eq}}
                                                {{#if_eq type 'issue'}}
                                                    <a href="<?=ROOT_URL?>issue/detail/index/{{obj_id}}">{{title}}</a>
                                                {{/if_eq}}
                                                {{#if_eq type 'issue_comment'}}
                                                    <a href="<?=ROOT_URL?>issue/detail/index/{{obj_id}}">{{title}}</a>
                                                {{/if_eq}}
                                                {{#if_eq type 'user'}}
                                                    <a href="<?=ROOT_URL?>user/profile/{{user_id}}">{{title}}</a>
                                                {{/if_eq}}
                                                {{#if_eq type 'project'}}
                                                    <a href="<?=ROOT_URL?>project/main/home/?project_id={{project_id}}">{{title}}</a>
                                                {{/if_eq}}
											</span>
                                                </h4>

                                                <time class="event-time js-time" title=""
                                                      datetime="{{time}}"
                                                      data-toggle="tooltip"
                                                      data-placement="top"
                                                      data-container="body"
                                                      data-original-title="{{time_full}}"
                                                      data-tid="449">{{time_text}}
                                                </time>
                                            </div>
                                        </li>
                                        {{/activity}}
                                        <div class="text-center" style="margin-top: .8em;">
                                    <span class="text-center">
                                            总数:<span id="issue_count">{{total}}</span> 每页显示:<span id="page_size">{{page_size}}</span>
                                    </span>
                                        </div>
                                    </script>

                                </div>
                                <div class="gl-pagination" id="ampagination-bootstrap">

                                </div>
                            </div>

                        </div>

                        <div class="group_panel panel-second">
                            <div class="panel panel-info" data-sort="2">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">快速开始 / 便捷导航</h3>
                                </div>

                                <div class="panel-body">
                                    <div class="link-group">
                                        <a href="<?=ROOT_URL?>org/create">创建组织</a>
                                        <a href="<?=ROOT_URL?>project/main/_new">创建项目</a>
                                        <a href="<?=ROOT_URL?>issue/main/#create">创建事项</a>
                                        <a href="<?=ROOT_URL?>passport/logout" >
                                            <i class="fa fa-power-off"></i> <span> 注 销</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-info" data-sort="4">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">组织</h3>
                                </div>

                                <div class="panel-body">
                                    <script id="org_li_tpl" type="text/html">
                                        {{#orgs}}
                                        <li class="col-md-6 member-list-item">
                                            <a href="<?=ROOT_URL?>org/detail/{{id}}">
											<span class="g-avatar g-avatar-sm member-avatar">
												<img src="{{avatar}}">
											</span>
                                                <span class="member-name">{{name}}</span>
                                            </a>
                                        </li>
                                        {{/orgs}}
                                    </script>
                                    <ul id="panel_orgs" class="member-list clearfix">

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="group_panel panel-third">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal home-modal" id="modal-layout">
        <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_add"
              action="<?=ROOT_URL?>admin/issue_type/add"
              accept-charset="UTF-8"
              method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                        <h3 class="modal-header-title">版式布局</h3>
                    </div>

                    <div class="modal-body layout-dialog" id="layout-dialog">
                        <p><strong>选择仪表板布局</strong></p>
                        <ul>
                            <li><a onclick="doLayout('a')" id="layout-a"><strong>A</strong></a></li>
                            <li><a onclick="doLayout('aa')" id="layout-aa"><strong>AA</strong></a></li>
                            <li><a onclick="doLayout('ba')" id="layout-ba"><strong>BA</strong></a></li>
                            <li><a onclick="doLayout('ab')" id="layout-ab"><strong>AB</strong></a></li>
                            <li><a onclick="doLayout('aaa')" id="layout-aaa"><strong>AAA</strong></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="modal home-modal" id="modal-tools-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">添加小工具</h3>
                </div>

                <div class="modal-body" id="layout-dialog">
                    <ul class="tools-list">
                        <li>
                            <div class="tool-img">
                                <img src="http://masterlab.ink/attachment/project/avatar/1.jpg" alt="">
                            </div>
                            
                            <div class="tool-info">
                                <h3 class="tool-title">
                                    标题
                                </h3>
                                <p class="tool-content">
                                    内容内容内容
                                </p>
                            </div>

                            <div class="tool-action">
                                <a href="javascript:;" onclick="addNewTool('标题', 'tool_aa', 'type')">添加小工具</a>
                            </div>
                        </li>

                        <li>
                            <div class="tool-img">
                                <img src="http://masterlab.ink/attachment/project/avatar/1.jpg" alt="">
                            </div>

                            <div class="tool-info">
                                <h3 class="tool-title">
                                    标题
                                </h3>
                                <p class="tool-content">
                                    内容内容内容
                                </p>
                            </div>

                            <div class="tool-action">
                                <a href="#">添加小工具</a>
                            </div>
                        </li>

                        <li>
                            <div class="tool-img">
                                <img src="http://masterlab.ink/attachment/project/avatar/1.jpg" alt="">
                            </div>

                            <div class="tool-info">
                                <h3 class="tool-title">
                                    标题
                                </h3>
                                <p class="tool-content">
                                    内容内容内容
                                </p>
                            </div>

                            <div class="tool-action">
                                <a href="#">添加小工具</a>
                            </div>
                        </li>

                        <li>
                            <div class="tool-img">
                                <img src="http://masterlab.ink/attachment/project/avatar/1.jpg" alt="">
                            </div>

                            <div class="tool-info">
                                <h3 class="tool-title">
                                    标题
                                </h3>
                                <p class="tool-content">
                                    内容内容内容
                                </p>
                            </div>

                            <div class="tool-action">
                                <a href="#">添加小工具</a>
                            </div>
                        </li>

                        <li>
                            <div class="tool-img">
                                <img src="http://masterlab.ink/attachment/project/avatar/1.jpg" alt="">
                            </div>

                            <div class="tool-info">
                                <h3 class="tool-title">
                                    标题
                                </h3>
                                <p class="tool-content">
                                    内容内容内容
                                </p>
                            </div>

                            <div class="tool-action">
                                <a href="#">添加小工具</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script id="tool_type_tpl" type="text/html">
    <form action="" class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-2">标题</div>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="????">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-md-offset-2">
                <a href="" class="btn btn-save">保存</a>
            </div>
        </div>
    </form>
</script>

<script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/panel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>

<script type="text/javascript">
    var _widgets = <?=json_encode($widgets)?>;
    var $panel = null;
    var _cur_page = 1;

    (function () {
        'use strict';

        var byId = function (id) {
                return document.getElementById(id);
            },

            console = window.console;

        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el) {
            Sortable.create(el, {
                group: 'photo',
                animation: 150,
                onStart: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    console.log(evt.item.title+"拖动前位置：",index);
                },
                onEnd: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    console.log(evt.item.title+"拖动后位置：",index);
                },
                onUpdate: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    //debugger;
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    console.log(evt.item.title+"拖动后位置：",index);
                }
            });
        });

    })();

    function doLayout(layoutType) {
        var $list = $("#module_list");
        var $layout = $(".layout-panel");
        var $layout_types = ["a", "aa", "ab", "ba", "aaa"];
        var $panel_first = $(".panel-first .panel");
        var $panel_second = $(".panel-second .panel");
        var $panel_third = $(".panel-third .panel");
        var sort = 0;
        var html_list = [];

        $panel_first.each(function (i) {
            sort++;
            $panel_first.eq(i).attr("data-sort", sort);
            html_list.push($panel_first.eq(i).prop("outerHTML"));

            if ($panel_second.eq(i).length > 0) {
                sort++;
                $panel_second.eq(i).attr("data-sort", sort);
                html_list.push($panel_second.eq(i).prop("outerHTML"));
            }

            if ($panel_third.eq(i).length > 0) {
                sort++;
                $panel_third.eq(i).attr("data-sort", sort);
                html_list.push($panel_third.eq(i).prop("outerHTML"));
            }
        });

        $panel_second.each(function (i) {
            if (i > $panel_first.length - 1) {
                sort++;
                $panel_second.eq(i).attr("data-sort", sort);
                html_list.push($panel_second.eq(i).prop("outerHTML"));

                if ($panel_third.eq(i).length > 0) {
                    sort++;
                    $panel_third.eq(i).attr("data-sort", sort);
                    html_list.push($panel_third.eq(i).prop("outerHTML"));
                }
            }
        });

        $panel_third.each(function (i) {
            if (i > $panel_first.length - 1 && i > $panel_second.length - 1) {
                sort++;
                $panel_third.eq(i).attr("data-sort", sort);
                html_list.push($panel_third.eq(i).prop("outerHTML"));
            }
        });

        for (var val of $layout_types) {
            $layout.removeClass(`layout-${val}`);
        }

        $layout.addClass(`layout-${layoutType}`);

        $(".panel-first").html("");
        $(".panel-second").html("");
        $(".panel-third").html("");
        switch(layoutType.length)
        {
            case 1:
                var $html = "";
                for (var html of html_list) {
                    $html += html;
                }

                $(".panel-first").html($html);
                break;
            case 2:
                var $html1 = "";
                var $html2 = "";
                html_list.forEach(function (item, i) {
                    var key = i + 1;

                    if (key % 2 === 0) {
                        $html2 += item;
                    } else {
                        $html1 += item;
                    }
                });
                $(".panel-first").html($html1);
                $(".panel-second").html($html2);
                break;
            case 3:
                var $html1_1 = "";
                var $html1_2 = "";
                var $html1_3 = "";
                html_list.forEach(function (item, i) {
                    var key = i + 1;

                    if (key % 3 === 2) {
                        $html1_2 += item;
                    } else if (key % 3 === 0) {
                        $html1_3 += item;
                    }else {
                        $html1_1 += item;
                    }
                });

                $(".panel-first").html($html1_1);
                $(".panel-second").html($html1_2);
                $(".panel-third").html($html1_3);
                break;
        }
        $("#modal-layout").modal('hide');
    }

    function addNewTool(title, id, type) {
        var sort = 1;
        var html = `<div class="panel panel-info" data-sort="${sort}">
            <div class="panel-heading tile__name " data-force="25" draggable="false">
            <h3 class="panel-heading-title">${title}</h3>
            <div class="panel-heading-extra" id="panel_issue_more"></div>
            </div>
            <div class="panel-body" id="${id}">

            </div>
            </div>`;

        $(".panel-first").prepend(html);

        var data = {

        };
        source = $(`#tool_${type}_tpl`).html();
        template = Handlebars.compile(source);
        result = template(data);
        $(`#${id}`).html(result);

        $("#modal-tools-add").modal('hide');
    }

</script>
</body>
</html>