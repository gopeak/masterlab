<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>dev/lib/moment.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="<?=ROOT_URL?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="<?=ROOT_URL?>dev/js/agile/board_column.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js?v=<?=$_version?>"></script>
    <!-- <script src="<?=ROOT_URL?>dev/js/admin/issue_ui.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script> -->
    <script src="<?=ROOT_URL?>dev/js/issue/main.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/issue/form.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>

    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/editor.md/css/editormd.css"/>

    <script src="<?=ROOT_URL?>dev/lib/editor.md/lib/marked.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/editor.md/lib/prettify.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/editor.md/lib/flowchart.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/editor.md/editormd.js"></script>

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/e-smart-zoom-jquery.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/video-js/video-js.min.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/video-js/video.min.js"></script>

    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

    <script>
        window.project_uploads_path = "";
        window.preview_markdown_path = "";
    </script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>"  type="text/javascript"></script>
    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/sweetalert2/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/sweetalert2/sweetalert-dev.css"/>

    <link href="<?=ROOT_URL?>gitlab/assets/application.css?v=<?=$_version?>">
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/css/board.css?v=<?=$_version?>">
</head>

<body class="" data-group=""  >

<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>


<script>
    var findFileURL = "";
</script>

<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="">
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
                                                <select id="boards_select" name="boards_select" class="selectpicker">
                                                    <?php foreach ($boards as $board) { ?>
                                                        <option value="<?=$board['type'].'@@'.$board['id'].'@@'.@$board['sprint_id'];?>"><?=$board['name'];?></option>
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
                                                                   placeholder="搜索或过滤结果...">
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
                                                     data-hint="报告人" data-icon="pencil" data-tag="@author"
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
                                                     data-hint="经办人" data-icon="user" data-tag="@assignee"
                                                     id="js-dropdown-assignee">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-value="none">
                                                            <button class="btn btn-link">
                                                                --
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
                                                     data-hint="迭代" data-icon="rocket" data-tag="sprint"
                                                     data-type="input" id="js-dropdown-sprint">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-value="none">
                                                            <button class="btn btn-link">
                                                                --
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
                                                     data-hint="模块" data-icon="square" data-tag="module"
                                                     data-type="input" id="js-dropdown-module">
                                                    <ul data-dropdown>
                                                        <li class="filter-dropdown-item" data-value="none">
                                                            <button class="btn btn-link">
                                                                --
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
                                                     data-hint="状态" data-icon="info" data-tag="status" data-type="input"
                                                     id="js-dropdown-status">

                                                    <ul class="filter-dropdown" data-dropdown data-dynamic>
                                                        <li class="filter-dropdown-item">
                                                            <button class="btn btn-link">
                                                                <span class="label label-{{color}} js-data-value">{{name}}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu"
                                                     data-hint="解决结果" data-icon="info" data-tag="resolve"
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
                                                     data-hint="优先级" data-icon="info" data-tag="priority"
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
                                        <div class="filter-dropdown-container">
                                            <div class="board-extra-actions">

                                                <a id="toggle_focus_mode" href="#" role="button" aria-label="" title="切换聚焦模式"
                                                   class="btn btn-default has-tooltip prepend-left-10 js-focus-mode-btn"
                                                   data-original-title="切换聚焦模式"
                                                >
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
                                                <button class="btn btn-default"  type="submit"  id="btn-submit" style="margin-left: 0px" ><i class="fa fa-search"></i>
                                                </button>
                                                <!--<a class="btn btn-new js-key-create" data-target="#modal-create-issue" data-toggle="modal"
                                                   id="btn-create-issue" style="margin-bottom: 4px;"
                                                   href="#modal-create-issue"><i class="fa fa-plus fa-fw"></i>
                                                    添加事项
                                                </a>-->
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

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
                                            <ul   data='backlog' class="board-list" id="backlog_render_id">

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


<div class="modal" id="modal-issue_move">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_issue_move"
          action="<?=ROOT_URL?>agile/board_issue_move"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">移动事项</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="id_name">显示名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[description]" id="edit_description"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button name="submit" type="button" class="btn btn-save" id="btn-issue_type_update">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>
                </div>
            </div>
    </form>
</div>

    </div>
</section>

<script type="text/html" id="backlog_list_tpl">

    {{#backlogs}}
    <li data-issue_id="{{id}}"  data-from-backlog="true" data-from_closed="false" draggable="false" class="card board-item">
        <div>
            <div class="card-header">
                <h4 class="card-title">
                    {{issue_type_html issue_type }}
                    <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                        <span class="card-number">#{{id}}</span>
                        {{summary}}
                    </a>
                </h4>
                <div class="card-assignee">{{make_user assignee}}</div>
            </div>
            <div class="card-footer">
                {{priority_html priority}}
                {{status_html status}}
                {{resolve_html resolve}}
                <!--<a href="#" data-issue_id="{{id}}">
                    <i class="fa fa-pencil"></i>
                </a>-->
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
                        <ul  id="ul_{{id}}" data='{{data}}' class="board-list">
                            {{#issues}}
                            <li data-issue_id="{{id}}"  data-from-backlog="false" data-from_closed="false"  class="card is-disabled board-item">
                                <div>
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            {{issue_type_html issue_type }}
                                            <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                                                <span class="card-number">#{{id}}</span>
                                                {{summary}}
                                            </a>
                                        </h4>
                                        <div class="card-assignee">{{user_html assignee}}</div>
                                    </div>
                                    <div class="card-footer">
                                        {{priority_html priority}}
                                        {{status_html status}}
                                        {{resolve_html resolve}}
                                        <!--<a href="#modal-edit-issue" class="js-board-item-edit board-item-edit" data-issue_id="{{id}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>-->
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
                <ul  id="ul_{{id}}" data='closed'  class="board-list">

                    {{#issues}}
                    <li  data-issue_id="{{id}}" data-from_closed="true" data-from_backlog="false"  class="card is-disabled board-item">
                        <div>
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{issue_type_html issue_type }}
                                    <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" target="_blank" title="#" class="js-no-trigger">
                                        <span class="card-number">#{{id}}</span>
                                        {{summary}}
                                    </a>
                                </h4>
                                <div class="card-assignee">{{user_html assignee}}</div>
                            </div>
                            <div class="card-footer">
                                {{priority_html priority}}
                                {{status_html status}}
                                {{resolve_html resolve}}
                                <!--<a href="#modal-edit-issue" class="js-board-item-edit board-item-edit" data-issue_id="{{id}}">
                                    <i class="fa fa-pencil"></i>
                                </a>-->
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


<script src="<?=ROOT_URL?>dev/lib/sortable/Sortable.js"></script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script type="text/javascript">
    $(function(){
        // 聚焦模式切换
        $('#toggle_focus_mode').bind('click',function(){
            $('.main-sidebar').toggleClass('hidden');
            $('.with-horizontal-nav').toggleClass('hidden');
            $('.layout-nav').toggleClass('hidden');
        })
    })

    var _simplemde = {};

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
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';
    var _active_sprint_id = '<?=$active_sprint_id?>';
    var $IssueMain = null;
    var _description_templates = <?=json_encode($description_templates)?>;

    var _perm_kanban = <?=(int)$perm_kanban?>;

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
                window.$board .fetchBoardBySprint(valueArr[2]);
            }else{
                window.$board .fetchBoardById(valueArr[1]);
            }
        });

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

        $("#modal-create-issue").on('show.bs.modal', function (e) {
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

    });
    var _curFineAttachmentUploader = null;
    var _curIssueId = null;
    var _curTmpIssueId = null;
    var _curQrToken = null;
    var mobileUploadInterval = null;

</script>


</body>
</html>
