<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>


    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/agile/board_column.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>


    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>

    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link href="<?=ROOT_URL?>gitlab/assets/application.css">
    <style>
        .boards-list{
                width: 100%;
                height: 900px;
                display: flex;
                width: 100%;
                padding: 16px 8px;
                overflow-x: scroll;
                white-space: nowrap;
                min-height: 200px;
            }
            .board{
                height: 100%;
                padding-right: 8px;
                padding-left: 8px;
                white-space: normal;
                vertical-align: top;
                width: 400px;
            }
            .board-inner {
                position: relative;
                height: 100%;
                font-size: 14px;
                background: #fafafa;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
            }
            .board.is-expandable .board-header {
                cursor: pointer;
            }
            .board.is-collapsed {
                width: 50px;
            }
            .board.is-draggable header{
                border-top-color: rgb(66, 139, 202);
            }
            .board-header.has-border::before {
                border-top: 3px solid;
                border-color: inherit;
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                content: '';
                position: absolute;
                width: calc(100% + 2px);
                top: 0;
                left: 0;
                margin-top: -1px;
                margin-right: -1px;
                margin-left: -1px;
                padding-top: 1px;
                padding-right: 1px;
                padding-left: 1px;
            }
            .board-title {
                margin: 0;
                padding: 12px 16px;
                font-size: 1em;
                border-bottom: 1px solid #e5e5e5;
                display: flex;
                align-items: center;
                cursor: pointer;
            }
            .board-title-text {
                margin-right: auto;
                font-weight: 600;
            }
            .board-title-text.color-label{
                background-color: rgb(66, 139, 202);
                color: rgb(255, 255, 255);
                padding: 2px 8px;
                border-radius: 100px;
            }
            .board-count-badge {
                display: inline-flex;
                align-items: stretch;
                height: 24px;
            }
            .issue-count-badge-count {
                display: flex;
                align-items: center;
                padding-right: 10px;
                padding-left: 10px;
                border: 1px solid #e5e5e5;
                border-radius: 3px;
                line-height: 1;
            }
            .board-list-component{
                height: calc(100% - 49px);
                overflow: hidden;
                position: relative;
            }
            .board-list {
                height: 100%;
                margin: 0;
                padding: 5px;
                list-style: none;
                overflow-y: scroll;
                overflow-x: hidden;
            }
            .board-list .board-item {
                cursor: pointer;
            }
            .board-list .board-item:hover {
                background-color: #f5f5f5
            }
            .card:not(:last-child) {
                margin-bottom: 5px;
            }
            .card {
                position: relative;
                padding: 11px 10px 11px 16px;
                background: #fff;
                border-radius: 4px;
                box-shadow: 0 1px 2px rgba(186,186,186,0.5);
                list-style: none;
            }
            .card-header {
                display: flex;
                min-height: 20px;
            }
            .card-title {
                margin: 0 30px 0 0;
                font-size: 12px;
                line-height: inherit;
            }
            .card-header .card-assignee {
                display: flex;
                justify-content: flex-end;
                position: absolute;
                right: 15px;
                height: 20px;
                width: 20px;
            }
            .card-footer {
                margin: 0 0 5px;
            }
            .card-footer > * {
                margin: 10px 0 0;
            }
            .board.close{
                width: 30px;
            }
            .board.close .board-title{
                border-bottom: 0;
                writing-mode: vertical-lr;
                padding: 10px 5px;
            }
            .board.close .board-count-badge{
                display: none;
            }
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
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">


                <div class="scrolling-tabs-container sub-nav-scroll">

                        <div class="issues-filters">
                            <div class="filtered-search-block issues-details-filters row-content-block second-block"
                                 v-pre="false">
                                <form class="filter-form js-filter-form" action="#" accept-charset="UTF-8" method="get">
                                    <input name="utf8" type="hidden" value="&#x2713;"/>
                                    <div class="issues-other-filters filtered-search-wrapper">

                                        <div class="filter-dropdown-container">
                                            <div class="dropdown inline prepend-right-10">
                                                <select id="boards_select" name="boards_select" class="selectpicker"   >
                                                    <?php foreach ($boards as $board) { ?>
                                                        <option value="<?=$board['type'].'@@'.$board['id'];?>"><?=$board['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="filtered-search-box" style="left:5px">
                                            <div class="filtered-search-box-input-container">
                                                <div class="scroll-container">
                                                    <ul class="tokens-container list-unstyled">
                                                        <li class="input-token">
                                                            <input class="form-control filtered-search"
                                                                   data-base-endpoint="/ismond/xphp" data-project-id="31"
                                                                   data-username-params="[]" id="filtered-search-issues"
                                                                   placeholder="Search or filter results...">
                                                        </li>
                                                    </ul>
                                                    <i class="fa fa-filter"></i>
                                                    <button class="clear-search hidden" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu hint-dropdown"
                                                     id="js-dropdown-hint">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-action="submit">
                                                            <button class="btn btn-link">
                                                                <i class="fa fa-search"></i>
                                                                <span>回车或点击搜索</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                                <i class="fa {{icon}}"></i>
                                                                <span class="js-filter-hint">{{hint}}</span>
                                                                <span class="js-filter-tag dropdown-light-content">{{tag}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>


                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="author" data-icon="pencil" data-tag="@author"
                                                     id="js-dropdown-author">
                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link dropdown-user">
                                                                <img alt="{{name}}&#39;s avatar" class="avatar"
                                                                     data-src="{{avatar_url}}" width="30">
                                                                <div class="dropdown-user-details"><span>{{name}}</span>
                                                                    <span class="dropdown-light-content">@{{username}}</span>
                                                                </div>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="assignee" data-icon="user" data-tag="@assignee"
                                                     id="js-dropdown-assignee">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-value="none">
                                                            <button class="btn btn-link">
                                                                No Assignee
                                                            </button>
                                                        </li>
                                                        <li class="divider"></li>
                                                    </ul>
                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link dropdown-user">
                                                                <img alt="{{name}}&#39;s avatar" class="avatar"
                                                                     data-src="{{avatar_url}}" width="30">
                                                                <div class="dropdown-user-details"><span>{{name}}</span>
                                                                    <span class="dropdown-light-content">@{{username}}</span>
                                                                </div>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="module" data-icon="square" data-tag="module"
                                                     data-type="input" id="js-dropdown-module">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-value="none">
                                                            <button class="btn btn-link">
                                                                No Module
                                                            </button>
                                                        </li>
                                                        <li class="divider"></li>
                                                    </ul>
                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                                <span class="label-title js-data-value">{{name}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="status" data-icon="info" data-tag="status" data-type="input"
                                                     id="js-dropdown-status">

                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                                <span class="label label-{{color}}   js-data-value">{{name}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="resolve" data-icon="info" data-tag="resolve"
                                                     data-type="input" id="js-dropdown-resolve">

                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                            <span style="color:{{color}}"
                                                                  class="label-title js-data-value">{{name}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="priority" data-icon="info" data-tag="priority"
                                                     data-type="input" id="js-dropdown-priority">

                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                            <span style="color:{{status_color}}"
                                                                  class="label-title js-data-value">{{name}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="filter-dropdown-container"><div class="prepend-left-10"><button title="" type="button" class="btn btn-inverted" data-original-title="">
                                                    View scope
                                                </button></div> <div class="board-extra-actions"><a href="#" role="button" aria-label="Toggle focus mode" title="" class="btn btn-default has-tooltip prepend-left-10 js-focus-mode-btn" data-original-title="Toggle focus mode"><span style="display: none;"><svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg"><path d="M.147 15.496l2.146-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.146-1.428-1.428zM14.996.646l1.428 1.43-2.146 2.145 1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125l1.286 1.286L14.996.647zm-13.42 0L3.72 2.794l1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286L.147 2.075 1.575.647zm14.848 14.85l-1.428 1.428-2.146-2.146-1.286 1.286c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616l-1.286 1.286 2.146 2.146z" fill-rule="evenodd"></path></svg></span> <span><svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M8.591 5.056l2.147-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.147-1.429-1.43zM5.018 8.553l1.429 1.43L4.3 12.127l1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125L2.872 10.7l2.146-2.147zm4.964 0l2.146 2.147 1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286-2.147-2.146 1.43-1.429zM6.447 5.018l-1.43 1.429L2.873 4.3 1.586 5.586c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616L4.3 2.872l2.147 2.146z" fill-rule="evenodd"></path></svg></span></a></div></div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <script>
                            new UsersSelect();
                            new LabelsSelect();
                            new MilestoneSelect();
                            new IssueStatusSelect();
                            $(document).off('page:restore').on('page:restore', function (event) {
                                if (gl.FilteredSearchManager) {
                                    new gl.FilteredSearchManager();
                                }
                                Issuable.init();
                                new gl.IssuableBulkActions({
                                    prefixId: 'issue_',
                                });
                            });
                        </script>
                </div>

                <div class="container-fluid">

                    <div class="issues-holder">
                        <div class="table-holder">
                            <div class="boards-list" id="boards-list">
                                <div class="board is-expandable">
                                    <div class="board-inner">
                                        <header class="board-header">
                                            <h3 class="board-title">
                                                <span class="board-title-text">Backlog</span>
                                                <div class="board-count-badge">
                                                    <span id="backlog_count" class="issue-count-badge-count"></span>
                                                </div>
                                            </h3>
                                        </header>
                                        <div class="board-list-component">
                                            <ul class="board-list" id="backlog_render_id">


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="columns_render_id">
                                </div>
                                <div id="closed_render_id">
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/html" id="backlog_list_tpl">

    {{#backlogs}}
    <li draggable="false" class="card board-item">
        <div>
            <div class="card-header">
                <h4 class="card-title">
                    <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                        {{summary}}
                    </a>
                    <span class="card-number">#{{issue_num}}</span>
                </h4>
                <div class="card-assignee">{{make_user assignee ../users }}</div>
            </div>
            <div class="card-footer">
                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
            </div>
        </div>
    </li>
    {{/backlogs}}

</script>

<script type="text/html" id="column_list_tpl">
    {{#columns}}
        {{#if_eq name 'Closed' }}

        {{^}}
            <div class="board is-draggable">
                <div class="board-inner">
                    <header class="board-header has-border">
                        <h3 class="board-title js-board-handle">
                            <span class="board-title-text color-label">{{name}}</span>
                            {{#if count }}
                                <div class="board-count-badge">
                                    <span class="issue-count-badge-count">{{count}}</span>
                                </div>
                            {{/if}}
                        </h3>
                    </header>
                    <div class="board-list-component">
                        <ul class="board-list">
                            {{#issues}}
                            <li class="card is-disabled board-item">
                                <div>
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                                                {{summary}}
                                            </a>
                                            <span class="card-number">#{{issue_num}}</span>
                                        </h4>
                                        <div class="card-assignee">{{make_user assignee ../users }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                        <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                        <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                        <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                    </div>
                                </div>
                            </li>
                            {{/issues}}
                        </ul>
                    </div>
                </div>
            </div>
        {{/if_eq}}
    {{/columns}}
</script>

<script type="text/html" id="closed_list_tpl">
    {{#columns}}
        {{#if_eq name 'Closed' }}
    <div class="board is-expandable close">
        <div class="board-inner">
            <header class="board-header">
                <h3 class="board-title js-board-handle">
                    <span class="board-title-text">{{name}}</span>
                    {{#if count }}
                    <div class="board-count-badge">
                        <span class="issue-count-badge-count">{{count}}</span>
                    </div>
                    {{/if}}
                </h3>
            </header>
            <div class="board-list-component">
                <ul class="board-list">

                    {{#issues}}
                    <li class="card is-disabled board-item">
                        <div>
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                                        {{summary}}
                                    </a>
                                    <span class="card-number">#{{issue_num}}</span>
                                </h4>
                                <div class="card-assignee">{{make_user assignee ../users }}</div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                            </div>
                        </div>
                    </li>
                    {{/issues}}

                </ul>
            </div>
        </div>
    </div>
        {{/if_eq}}
    {{/columns}}
</script>


<script src="<?=ROOT_URL?>dev/js/jquery.min.js"></script>
<script src="<?=ROOT_URL?>dev/lib/sortable/Sortable.js"></script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">
    $(function(){


    })

</script>

<script type="text/javascript">

    var _issueConfig = {
        priority:null,
        issue_types:null,
        issue_status:null,
        issue_resolve:null,
        issue_module:null,
        issue_version:null,
        issue_labels:null,
        users:null,
        projects:null
    };
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';
    var _active_sprint_id = '<?=$active_sprint_id?>';

    var $board = null;
    $(function () {
        var options = {
        }
        window.$board = new BoardColumn(options);
        if(_active_sprint_id!=''){
            window.$board .fetchBoardBySprint(_active_sprint_id);
        }
        //$('.selectpicker').selectpicker();
        $("#boards_select").change(function(){
            console.log($(this).val());
            var valueArr =  $(this).val().split('@@');
            if(valueArr[0]=='sprint'){
                window.$board .fetchBoardBySprint(valueArr[1]);
            }else{
                window.$board .fetchBoardById(valueArr[1]);
            }
        });

    });

</script>


</body>
</html>
