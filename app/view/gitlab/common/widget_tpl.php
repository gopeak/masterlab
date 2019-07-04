
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
           data-original-title="更多事项">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</script>
 
<script id="assignee_my_tpl" type="text/html">
    {{#issues}}
    <tr>
        <th scope="row">#{{issue_num}}</th>
        <td>{{priority_html priority }}</td>
        <td><a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">
		{{summary}}
                {{#if_eq warning_delay 1 }}
                <span style="color:#fc9403" title="即将延期">即将延期</span>
                {{/if_eq}}
                {{#if_eq postponed 1 }}
                <span style="color:#db3b21" title="逾期">逾期</span>
                {{/if_eq}}
         {{status_html status }}
		</a></td>
    </tr>
    {{/issues}}
</script>

<script id="unresolve_assignee_my-body_tpl" type="text/html">
    <table class="table">
        <thead>
        <tr>
            <th>#id</th>
            <th>优先级</th>
            <th>主题</th>
        </tr>
        </thead>
        <tbody id="unresolve_assignee_my_wrap">

        </tbody>
    </table>
    <div id="unresolve_assignee_my_more" class="assignee-more" style="display: none">
        <a href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine" style="float: right"
           data-toggle="tooltip"
           data-placement="top"
           data-container="body"
           data-original-title="更多事项">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</script>

<script id="unresolve_assignee_my_tpl" type="text/html">
    {{#issues}}
    <tr>
        <th scope="row">#{{issue_num}}</th>
        <td>{{priority_html priority }}</td>
        <td><a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">
                {{summary}}
                {{#if_eq warning_delay 1 }}
                <span style="color:#fc9403" title="即将延期">即将延期</span>
                {{/if_eq}}
                {{#if_eq postponed 1 }}
                <span style="color:#db3b21" title="逾期">逾期</span>
                {{/if_eq}}
                {{status_html status }}
            </a></td>
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
    <div class="gl-pagination" id="ampagination-bootstrap">

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
            {{#if avatarExist}}
            <span class="g-avatar g-avatar-sm member-avatar">
                <img src="{{avatar}}">
            </span>
            {{^}}
            <span class="g-avatar g-avatar-md project-item-pic pic-bg">
                {{first_word}}
            </span>
            {{/if}}
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

    <canvas height="160" width="260" id="sprint_burndown_wrap"  style="  "></canvas>
</script>
<script id="sprint_burndown_tpl" type="text/html">

</script>

<!--迭代速率图-->
<script id="sprint_speed-body_tpl" type="text/html">
    <canvas height="160" width="260" id="sprint_speed_wrap"  style="  "></canvas>
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

<!--迭代按事项优先级统计-->
<script id="sprint_priority_stat-body_tpl" type="text/html">
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
<script id="sprint_priority_stat_tpl" type="text/html">
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


<script id="form_select_tpl" type="text/html">
    <select name="{{name}}" id="{{id}}" class="form-control">
        {{#list}}
        {{#if selected}}
        <option value="{{id}}" selected="selected">
            {{^}}
        <option value="{{id}}">
            {{/if}}
            {{name}}
        </option>
        {{/list}}
    </select>
</script>

<script id="form_group_select_tpl" type="text/html">
    <select name="{{name}}" id="{{id}}" class="form-control">
        {{#list}}
        <optgroup label="{{name}}">
            {{#sprints}}
            {{#if selected}}
            <option value="{{id}}" selected="selected">
                {{^}}
            <option value="{{id}}">
                {{/if}}
                {{name}}
            </option>
            {{/sprints}}
        </optgroup>
        {{/list}}
    </select>
</script>

<script id="panel_tpl" type="text/html">
    <div class="panel-heading tile__name " data-force="25" draggable="false">
        <h3 class="panel-heading-title">{{widget.config_widget.title}}</h3>
        <div class="panel-heading-extra">
            <div class="panel-action">
                <i class="fa fa-angle-down"></i>
                <ul>
                    {{#if widget.config_widget.required_param}}

                    <li class="panel-edit" onclick="show_form('{{widget._key}}')">编辑</li>

                    {{/if}}
                    <li class="panel-delete" onclick="removeWidget('{{widget._key}}')">删除</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-body" id="toolform_{{widget._key}}">

    </div>
    {{#if widget.is_project}}
    <div class="panel-body padding-0" id="tool_{{widget._key}}">
        {{^}}
        <div class="panel-body" id="tool_{{widget._key}}">
            {{/if}}
        </div>

</script>