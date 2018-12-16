<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css" rel="stylesheet" type="text/css"/>
    <link href="<?=ROOT_URL?>dev/css/statistics.css" rel="stylesheet">
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

                        </div>

                        <div class="group_panel panel-second">

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
                <div class="modal-body" id="tools-dialog">

                </div>
            </div>
        </div>
    </div>
</section>

<script id="tools_list_tpl" type="text/html">
    <ul class="tools-list">
        {{#widgets}}
        <li>
        <div class="tool-img">
            <img src="{{pic}}" alt="">
        </div>

        <div class="tool-info">
            <h3 class="tool-title">
            {{name}}
            </h3>
            <p class="tool-content">
            {{description}}
            </p>
        </div>

        <div class="tool-action">
            {{#if isExist}}
            <span>已添加</span>
            {{^}}
            <a href="javascript:;" onclick="addNewTool('{{id}}')">添加小工具</a>
            {{/if}}
        </div>
        </li>
        {{/widgets}}
    </ul>
</script>

<script id="tool_form_tpl" type="text/html">
    <form class="form-horizontal" id="tool_form_{{_key}}" name="tool_form_{{_key}}">
        {{#parameter}}
        <div class="form-group">
            <div class="col-sm-2 form-label text-right">{{name}}：</div>
            <div class="col-sm-8" id="{{field}}_{{../id}}">
            </div>
        </div>
        {{/parameter}}
        <div class="form-group">
            <div class="col-sm-8 col-md-offset-2">
                <a href="javascript:;" class="btn btn-default" onclick="saveForm({{id}}, '{{_key}}')">保存</a>
            </div>
        </div>
    </form>
</script>

<script id="my_projects-body_tpl" type="text/html">
    <ul class="panel-project" id="my_projects_wrap">

    </ul>
</script>
<script id="my_projects_tpl" type="text/html">
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

<script id="assignee_my-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>#id</th>
            <th>类型</th>
            <th>优先级</th>
            <th>主题</th>
        </tr>
        </thead>
        <tbody id="assignee_my_wrap">

        </tbody>
    </table>
    <div id="assignee_my_more" class="assignee-more" style="display: none">
        <a href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine" style="float: right"
           data-toggle="tooltip"
           data-placement="top"
           data-container="body"
           data-original-title="更多问题">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</script>
<script id="assignee_my_tpl" type="text/html">
    {{#issues}}
    <tr>
        <th scope="row">#{{issue_num}}</th>
        <td>{{issue_type_html issue_type}}</td>
        <td>{{priority_html priority }}</td>
        <td><a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">{{summary}}</a></td>
    </tr>
    {{/issues}}
</script>

<script id="activity-body_tpl" type="text/html">
    <ul  id="activity_wrap" class="event-list" id="panel_activity">
    </ul>
</script>
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

<script id="nav-body_tpl" type="text/html">
    <div id="nav_wrap" class="clearfix">

    </div>
</script>
<script id="nav_tpl" type="text/html">
    <div class="link-group">
        <a href="<?=ROOT_URL?>org/create">创建组织</a>
        <a href="<?=ROOT_URL?>project/main/_new">创建项目</a>
        <a href="<?=ROOT_URL?>issue/main/#create">创建事项</a>
        <a href="<?=ROOT_URL?>passport/logout" >
            <i class="fa fa-power-off"></i> <span> 注 销</span>
        </a>
    </div>
</script>

<script id="org-body_tpl" type="text/html">
    <ul id="org_wrap" class="member-list clearfix">

    </ul>
</script>

<script id="org_tpl" type="text/html">
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

<!--项目数据统计-->
<script id="project_stat-body_tpl" type="text/html">
    <div id="project_stat_wrap" class="row header-body">
    </div>
</script>
<script id="project_stat_tpl" type="text/html">

        <div class="col-sm-3 col-xs-12 column header-body-item">
            <span class="item-text">总事项</span>
            <span id="issues_count" class="item-num">-</span>
        </div>
        <div class="col-sm-3 col-xs-12 column header-body-item">
            <span class="item-text">未解决</span>
            <span id="no_done_count" class="item-num">-</span>

        </div>
        <div class="col-sm-3 col-xs-12 column header-body-item">
            <span class="item-text">关闭</span>
            <span id="closed_count" class="item-num">-</span>
        </div>
        <div class="col-sm-3 col-xs-12 column header-body-item">
            <span class="item-text">迭代次数</span>
            <span id="sprint_count" class="item-num">-</span>

        </div>
</script>

<!--项目已解决与未解决对比-->
<script id="project_abs-body_tpl" type="text/html">
    <canvas height="360" id="project_abs_wrap"  style="max-height:500px;min-width: 400px; height: 380px;"></canvas>
</script>
<script id="project_abs_tpl" type="text/html">
</script>

<!--项目饼状图-->
<script id="project_pie-body_tpl" type="text/html">
    <canvas height="260" width="260" id="project_pie_wrap"  style="max-width:280px;width: 280px;height: 200px;margin:0 auto;"></canvas>
</script>
<script id="project_pie_tpl" type="text/html">
</script>

<!--项目按事项优先级统计-->
<script id="project_priority_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>优先级</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="project_priority_stat_wrap">

        </tbody>
    </table>
</script>
<script id="project_priority_stat_tpl" type="text/html">
    {{#priority_stat}}
    <tr>
        <td>{{priority_html id }}</td>
        <td>{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 2em;width:{{percent}}%;
                             {{#lessThan percent 30}}
                                background-color: #f5222d;
                             {{/lessThan}}
                             {{#greaterThan percent 90}}
                                background-color: #168f48;
                             {{/greaterThan}}
                            ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/priority_stat}}
</script>

<!--项目按事项开发者统计-->
<script id="project_developer_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>开发者</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="project_developer_stat_wrap">

        </tbody>
    </table>
</script>
<script id="project_developer_stat_tpl" type="text/html">
    {{#assignee_stat}}
    <tr>
        <td>
            {{user_html user_id }}
        </td>
        <td  >{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 0em;width:{{percent}}%;
                                 {{#lessThan percent 30}}
                                    background-color: #f5222d;
                                 {{/lessThan}}
                                 {{#greaterThan percent 90}}
                                    background-color: #168f48;
                                 {{/greaterThan}}
                                ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/assignee_stat}}
</script>

<!--项目按事项状态统计-->
<script id="project_status_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>状态</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="project_status_stat_wrap">

        </tbody>
    </table>
</script>
<script id="project_status_stat_tpl" type="text/html">
    {{#status_stat}}
    <tr>
        <td>
            {{status_html id}}
        </td>
        <td  >{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 0em;width:{{percent}}%;
                             {{#lessThan percent 30}}
                                background-color: #f5222d;
                             {{/lessThan}}
                             {{#greaterThan percent 90}}
                                background-color: #168f48;
                             {{/greaterThan}}
                            ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/status_stat}}
</script>

<!--项目按事项类型统计-->
<script id="project_issue_type_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>类型</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="project_issue_type_stat_wrap">

        </tbody>
    </table>
</script>
<script id="project_issue_type_stat_tpl" type="text/html">
    {{#type_stat}}
    <tr>
        <td>
            {{issue_type_html id }}
        </td>
        <td  >{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 0em;width:{{percent}}%;
                                 {{#lessThan percent 30}}
                                    background-color: #f5222d;
                                 {{/lessThan}}
                                 {{#greaterThan percent 90}}
                                    background-color: #168f48;
                                 {{/greaterThan}}
                                ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/type_stat}}
</script>

<!--迭代数据统计-->
<script id="sprint_stat-body_tpl" type="text/html">
    <div id="sprint_stat_wrap" class="row header-body">
    </div>
</script>
<script id="sprint_stat_tpl" type="text/html">
    <div class="col-sm-3 col-xs-12 column header-body-item">
        <span id="issues_count" class="item-num">-</span>
        <span class="item-text">事项数</span>
    </div>
    <div class="col-sm-3 col-xs-12 column header-body-item">
        <span id="no_done_count" class="item-num">-</span>
        <span class="item-text">未解决</span>
    </div>
    <div class="col-sm-3 col-xs-12 column header-body-item">
        <span id="closed_count" class="item-num">-</span>
        <span class="item-text">关闭</span>
    </div>
</script>

<!--迭代倒计时-->
<script id="sprint_countdown-body_tpl" type="text/html">
    <div id="sprint_countdown_wrap" style="font-size: 48px;">
    </div>
</script>
<script id="sprint_countdown_tpl" type="text/html">

</script>

<!--迭代燃尽图-->
<script id="sprint_burndown-body_tpl" type="text/html">
    <div id="sprint_burndown_wrap" class="row header-body">
    </div>
</script>
<script id="sprint_burndown_tpl" type="text/html">

</script>

<!--迭代速率图-->
<script id="sprint_speed-body_tpl" type="text/html">
    <div id="sprint_speed_wrap" class="row header-body">
    </div>
</script>
<script id="sprint_speed_tpl" type="text/html">

</script>

<!--迭代pie图-->
<script id="sprint_pie-body_tpl" type="text/html">
    <canvas height="260" width="260" id="sprint_pie_wrap"  style="max-width:280px;width: 280px;height: 200px;margin:0 auto;"></canvas>
</script>
<script id="sprint_pie_tpl" type="text/html">
</script>


<!--迭代已解决与未解决-->
<script id="sprint_abs-body_tpl" type="text/html">
    <canvas height="360" id="sprint_abs_wrap"  style="max-height:500px;min-width: 400px; height: 380px;"></canvas>
</script>
<script id="sprint_abs_tpl" type="text/html">
</script>

<!--迭代按事项状态统计-->
<script id="sprint_status_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>优先级</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="sprint_status_stat_wrap">

        </tbody>
    </table>
</script>
<script id="sprint_status_stat_tpl" type="text/html">
    {{#priority_stat}}
    <tr>
        <td>{{priority_html id }}</td>
        <td>{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 2em;width:{{percent}}%;
                             {{#lessThan percent 30}}
                                background-color: #f5222d;
                             {{/lessThan}}
                             {{#greaterThan percent 90}}
                                background-color: #168f48;
                             {{/greaterThan}}
                            ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/priority_stat}}
</script>

<!--迭代按事项开发者统计-->
<script id="sprint_developer_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>开发者</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="sprint_developer_stat_wrap">

        </tbody>
    </table>
</script>
<script id="sprint_developer_stat_tpl" type="text/html">
    {{#assignee_stat}}
    <tr>
        <td>
            {{user_html user_id }}
        </td>
        <td  >{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 0em;width:{{percent}}%;
                                 {{#lessThan percent 30}}
                                    background-color: #f5222d;
                                 {{/lessThan}}
                                 {{#greaterThan percent 90}}
                                    background-color: #168f48;
                                 {{/greaterThan}}
                                ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/assignee_stat}}
</script>

<!--迭代按事项事项类型统计-->
<script id="sprint_issue_type_stat-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>类型</th>
            <th>事项</th>
            <th>百分比</th>
        </tr>
        </thead>
        <tbody id="sprint_issue_type_stat_wrap">

        </tbody>
    </table>
</script>
<script id="sprint_issue_type_stat_tpl" type="text/html">
    {{#type_stat}}
    <tr>
        <td>
            {{issue_type_html id }}
        </td>
        <td  >{{count}}</td>
        <td>
            <div class="progress">
                <div class="progress-outer">
                    <div class="progress-bar"
                         role="progressbar"
                         aria-valuenow="{{percent}}"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="min-width: 0em;width:{{percent}}%;
                                 {{#lessThan percent 30}}
                                    background-color: #f5222d;
                                 {{/lessThan}}
                                 {{#greaterThan percent 90}}
                                    background-color: #168f48;
                                 {{/greaterThan}}
                                ">
                    </div>
                </div>
                <span class="progress-text">{{percent}}%</span>
            </div>
        </td>
    </tr>
    {{/type_stat}}
</script>


<script id="form_select_tpl" type="text/html">
    <select name="{{name}}" class="form-control">
        {{#list}}
        <option value="{{id}}">
            {{name}}
        </option>
        {{/list}}
    </select>
</script>

<script id="form_group_select_tpl" type="text/html">
    <select name="{{name}}" class="form-control">
        {{#list}}
        <optgroup label="{{name}}">
            {{#sprints}}
            <option value="{{id}}">{{name}}</option>
            {{/sprints}}
        </optgroup>
        {{/list}}
    </select>
</script>

<script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/widget.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>

<script type="text/javascript">

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


    // 可用的工具列表
    var _widgets = <?=json_encode($widgets)?>;
    console.log(_widgets);

    // 用户布局方式
    var _layout = '<?=$user_layout?>';

    // 用户自定义布局配置
    var _user_widgets = <?=json_encode($user_widgets)?>;
    console.log(_user_widgets);

    // 用户参与的项目列表
    var _user_in_projects = <?=json_encode($user_in_projects)?>;
    console.log(_user_in_projects);

    // 用户可选的迭代列表
    var _user_in_sprints = <?=json_encode($user_in_sprints)?>;
    console.log(_user_in_sprints);

    var $panel = null;
    var _cur_page = 1;
    var temp_obj = {};
    var layout = "aa";

    var $widgetsAjax = null;

    // 项目图表
    var ctx_project_pie = null;//document.getElementById('project_pie').getContext('2d');
    var ctx_project_bar = null;//document.getElementById('project_bar').getContext('2d');
    var projectPie = null;
    var projectBar = null;

    // 迭代图表
    var ctx_sprint_bar = null;
    var ctx_sprint_pie = null;
    var sprintPie = null;
    var sprintBar = null;

    $(function () {
        var options = {}
        window.$widgetsAjax = new Widgets(options);
    });

    $(function () {
        initHtml();
        filterHasTool();
        $(document).on("click", ".panel-action i", function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).siblings("ul").slideDown(100);
        });

        $(document).on("click", function () {
            $(".panel-action ul").slideUp(100);
        });
        
        $(document).on("click", ".panel-action .panel-edit", function () {
            var $panel = $(this).parents(".panel");
        });

        $(document).on("click", ".panel-action .panel-delete", function () {
            var $panel = $(this).parents(".panel");
            var index = $panel.index;
            var parent_index = $panel.index();

            moveWidget(parent_index, index, false);
            filterHasTool();
            $panel.remove();
        });
    });

    (function () {
        'use strict';
        var byId = function (id) {
                return document.getElementById(id);
            },

            console = window.console;

        //移动panel
        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el) {
            Sortable.create(el, {
                group: 'photo',
                animation: 150,
                onStart: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();

                    moveWidget(parent_index, index, false, true);
                },
                onEnd: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();
                    moveWidget(parent_index, index, true);
                    saveUserWidget(_user_widgets);
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

    // 版式布局切换
    function doLayout(layoutType) {
        _layout =  layoutType;
        var $layout_types = ["a", "aa", "ab", "ba", "aaa"];
        var $list = $("#module_list"),
            $layout = $(".layout-panel"),
            $panel_first = $(".panel-first"),
            $panel_second = $(".panel-second"),
            $panel_third = $(".panel-third"),
            $item_first = $panel_first.find(".panel"),
            $item_second = $panel_second.find(".panel"),
            $item_third = $panel_third.find(".panel");
        var sort = 0,
            html_list = [];

        for (var val of $layout_types) {
            $layout.removeClass(`layout-${val}`);
        }

        $layout.addClass(`layout-${layoutType}`);

        var length1 = $item_first.length;
        var length2 = $item_second.length;
        var length3 = $item_third.length;

        switch(layoutType.length)
        {
            case 1:
                $panel_first.append($panel_second.html() + $panel_third.html());
                $panel_second.hide();
                $panel_third.hide();
                $panel_second.html("");
                $panel_third.html("");
                break;
            case 2:
                if (length1 > 1 && length2 === 0 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i >= length1/2) {
                            $panel_second.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                } else if (length3 > 0) {
                    $panel_second.append($panel_third.html());
                }

                $panel_third.html("");
                $panel_second.show();
                $panel_third.hide();
                break;
            case 3:
                if (length1 > 1 && length2 === 0 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i >= length1/3 && i < length1 * 2/3 ) {
                            $panel_second.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }

                        if (i >= i < length1 * 2/3) {
                            $panel_third.append($(this));
                            $(this).remove();
                        }
                    });
                } else if (length2 > 1 && length3 === 0) {
                    $item_second.each(function (i) {
                        if (i >= length2/2) {
                            $panel_third.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                } else if (length1 > 1 && length2 === 1 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i === length1-1) {
                            $panel_third.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                }

                $panel_second.show();
                $panel_third.show();
                break;
        }
        $("#modal-layout").modal('hide');
    }
    
    // 初始化数据html
    function initHtml() {
        var panel_data = [];

        for([key, value] of Object.entries(_user_widgets)) {
            panel_data = panel_data.concat(value);
        }

        panel_data.forEach(function (user_widget) {
            var config_widget = getConfigWidgetData(user_widget.widget_id);
            user_widget['_key'] = config_widget._key;
            user_widget['config_widget'] = config_widget;
            console.log(user_widget);
            addTool(user_widget, user_widget.panel, true);
        });
    }

    //根据id获取相应的widgets数据
    function getConfigWidgetData (id) {
        var temp = _widgets.filter(function (val) {
            return val.id == id;
        })[0];
        var data = {
            id: id,
            title: temp.name,
            _key: temp._key,
            method:temp.method,
            required_param: temp.required_param,
            parameter: temp.parameter
        };
        return data;
    }

    //添加新工具
    function addNewTool(id) {
        var config_widget = getConfigWidgetData(id);

        var user_widget ={
            id:null,
            panel: "first",
            _key: config_widget._key,
            parameter: config_widget.parameter,
            order_weight:1,
            widget_id: id,
            required_param:config_widget.required_param,
            is_saved_parameter:false,
            user_id:current_uid
        }
        user_widget['config_widget'] = config_widget;
        console.log(user_widget);
        addTool(user_widget);

        delete user_widget['config_widget'];
        _user_widgets.first.unshift(user_widget);

        filterHasTool();
        saveUserWidget(_user_widgets);
        $("#modal-tools-add").modal('hide');
    }

    // 增加工具通用方法
    function addTool(user_widget,  isList) {

        var config_widget = user_widget.config_widget;
        var panel = user_widget.panel;

        var html = `<div id="widget_${config_widget._key}" class="panel panel-info" data-column="${panel}">
            <div class="panel-heading tile__name " data-force="25" draggable="false">
            <h3 class="panel-heading-title">${config_widget.title}</h3>
            <div class="panel-heading-extra">
                <div class="panel-action">
                    <i class="fa fa-angle-down"></i>
                    <ul>
                        ${config_widget.required_param ? '<li class="panel-edit" onclick="show_form(\''+config_widget._key+'\');">编辑</li>' : ''}
                        <li class="panel-delete" onclick="removeWidget('${config_widget._key}')">删除</li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="panel-body" id="toolform_${config_widget._key}">

            </div>
            <div class="panel-body" id="tool_${config_widget._key}">

            </div>
            </div>`;

        if (isList) {
            $(`.panel-${panel}`).append(html);
        } else {
            $(`.panel-${panel}`).prepend(html);
        }

        // 生成表单
        var source = $('#tool_form_tpl').html();
        var template = Handlebars.compile(source);
        var result = template(config_widget);
        $(`#toolform_${config_widget._key}`).html(result);
        makeFormHtml(config_widget.id, config_widget.parameter, user_widget.parameter);

        // 是否显示过滤器表单
        if (config_widget.required_param && !user_widget.is_saved_parameter) {
            $(`#toolform_${config_widget._key}`).show();
            $(`#tool_${config_widget._key}`).hide();
        } else {
            // 渲染数据
            source = $(`#${config_widget._key}_tpl`).html();
            template = Handlebars.compile(source);
            result = template(config_widget);
            $(`#tool_${config_widget._key}`).html(result);

            var body_html =$(`#${config_widget._key}-body_tpl`).html();
            $(`#tool_${config_widget._key}`).html(body_html);

            if(config_widget.method=='fetchAssigneeIssues'){
                $widgetsAjax.fetchAssigneeIssues(config_widget._key, 1);
            }
            if(config_widget.method=='fetchUserHaveJoinProjects'){
                $widgetsAjax.fetchUserHaveJoinProjects(config_widget._key);
            }
            if(config_widget.method=='fetchOrgs'){
                $widgetsAjax.fetchOrgs(config_widget._key, 1);
            }
            if(config_widget.method=='fetchNav'){
                $widgetsAjax.fetchNav(config_widget._key, 1);
            }
            if(config_widget.method=='fetchActivity'){
                $widgetsAjax.fetchActivity(config_widget._key, 1);
            }
            if(config_widget.method=='fetchProjectStat'){
                $widgetsAjax.fetchProjectStat(user_widget);
            }
            if(config_widget.method=='fetchProjectPriorityStat'){
                $widgetsAjax.fetchProjectPriorityStat(user_widget);
            }
            if(config_widget.method=='fetchProjectStatusStat'){
                $widgetsAjax.fetchProjectStatusStat(user_widget);
            }
            if(config_widget.method=='fetchProjectDeveloperStat'){
                $widgetsAjax.fetchProjectDeveloperStat(user_widget);
            }
            if(config_widget.method=='fetchProjectIssueTypeStat'){
                $widgetsAjax.fetchProjectIssueTypeStat(user_widget);
            }
            if(config_widget.method=='fetchProjectPie'){
                $widgetsAjax.fetchProjectPie(user_widget);
            }
            if(config_widget.method=='fetchProjectAbs'){
                $widgetsAjax.fetchProjectAbs(user_widget);
            }
            if(config_widget.method=='fetchSprintStat'){
                $widgetsAjax.fetchSprintStat(user_widget);
            }
            if(config_widget.method=='fetchSprintCountdown'){
                $widgetsAjax.fetchSprintCountdown(user_widget);
            }
            if(config_widget.method=='fetchSprintBurndown'){
                $widgetsAjax.fetchSprintBurndown(user_widget);
            }
            if(config_widget.method=='fetchSprintSpeedRate'){
                $widgetsAjax.fetchSprintSpeedRate(user_widget);
            }
            if(config_widget.method=='fetchSprintPie'){
                $widgetsAjax.fetchSprintPie(user_widget);
            }
            if(config_widget.method=='fetchSprintAbs'){
                $widgetsAjax.fetchSprintAbs(user_widget);
            }
            if(config_widget.method=='fetchSprintPriorityStat'){
                $widgetsAjax.fetchSprintPriorityStat(user_widget);
            }
            if(config_widget.method=='fetchSprintStatusStat'){
                $widgetsAjax.fetchSprintStatusStat(user_widget);
            }
            if(config_widget.method=='fetchSprintDeveloperStat'){
                $widgetsAjax.fetchSprintDeveloperStat(user_widget);
            }
            if(config_widget.method=='fetchSprintIssueTypeStat'){
                $widgetsAjax.fetchSprintIssueTypeStat(user_widget);
            }

            $(`#toolform_${config_widget._key}`).hide();
            $(`#tool_${config_widget._key}`).show();
        }
    }

    //移动pannel
    function moveWidget(parent_index, index, add, obj) {
        var parent_text = "first";
        if (parent_index === 1) {
            parent_text = "second";
        } else if (parent_index === 2) {
            parent_text = "third";
        }

        if (!add) {
            if (obj) {
                temp_obj = _user_widgets[parent_text][index];
            }
            _user_widgets[parent_text].splice(index, 1);
        } else {
            _user_widgets[parent_text].splice(index, 0, temp_obj);
        }
        console.log(_user_widgets);
    }

    function removeWidget(_key) {

        var $panel = $(`#widget_${_key}`);
        var index = $panel.index;
        var parent_index = $panel.index();
        $(`#widget_${_key}`).remove();

        var parent_text = "first";
        if (parent_index === 1) {
            parent_text = "second";
        } else if (parent_index === 2) {
            parent_text = "third";
        }
        _user_widgets[parent_text].splice(index, 1);

        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/removeUserWidget',
            data: {widget_key:_key},
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('保存成功');
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

        console.log(_user_widgets);
    }

    function saveUserWidget(user_widgets){

        var user_widgets_json = JSON.stringify(user_widgets);
        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/saveUserWidget',
            data: {panel:user_widgets_json, layout:_layout},
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('保存成功');
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    //过滤工具是否存在
    function filterHasTool() {
        var panel_data = [];

        for(value of Object.values(_user_widgets)) {
            panel_data = panel_data.concat(value);
        }
        _widgets.forEach(function (data) {
            panel_data.forEach(function (val) {
                if (val.widget_id === data.id) {
                    data.isExist = true;
                }
            });
        });

        source = $("#tools_list_tpl").html();
        var template = Handlebars.compile(source);
        var result = template({widgets: _widgets});
        $("#tools-dialog").html(result);
    }

    function makeFormHtml(id, parameter, user_parameter) {
        parameter.forEach(function (val) {

            var show_value = '';
            for ( var i = 0; i <user_parameter.length; i++){
                if(user_parameter[i].name==val.field){
                    show_value = user_parameter[i].value;
                }
            }
            if(show_value==''){
                show_value = val.value;
            }

           if (val.type.indexOf("select") >= 0 ) {
               makeSelectHtml(id, val.field, val.type, val.value, show_value);
           } else if (val.type === "date") {
               makeDateSelectHtml(id, val.field, val.value, show_value);
           } else {
               $(`#${val.field}_${id}`).html(`<input type="text" class="form-control" name="${val.field}" value="${show_value}"  />`);
           }
        });
    }

    function makeSelectHtml(id, field, type, value, selected_value) {
        var data = {
            name: field,
            list: []
        };

        if (type === "my_projects_select") {
            data.list = _user_in_projects;
            source = $("#form_select_tpl").html();
        } else if (type === "my_projects_sprint_select") {
            data.list = _user_in_sprints;
            source = $("#form_group_select_tpl").html();
        } else {
            value.forEach(function (val) {
                var temp = {
                    id: val.value,
                    name: val.title
                };
               data.list.push(temp);
            });
            source = $("#form_select_tpl").html();
        }

        template = Handlebars.compile(source);
        result = template(data);
        $(`#${field}_${id}`).html(result);
    }

    function makeDateSelectHtml(id, field, value, selected_value ) {
        var html = `<input type="text" class="laydate_input_date form-control" name="${field}" id="${field}_date_${id}"  value="${selected_value}"  />`;

        $(`#${field}_${id}`).html(html);

        laydate.render({
            elem: `#${field}_date_${id}`
        });
    }

    function saveForm(id, key) {
        var configs = $(`#tool_form_${key}`).serializeArray();
        console.log(configs);
        var configsJson = JSON.stringify(configs);

        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/saveUserWidgetParameter',
            data: {parameter:configsJson, widget_key:key},
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('保存成功');
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    }

    /**
     * 显示过滤器表单
     * @param _key
     */
    function show_form(_key){
        $(`#toolform_${_key}`).show();
        $(`#tool_${_key}`).hide();
    }
    
    //提交数据
    function submitData() {
        console.log()
    }

</script>
</body>
</html>