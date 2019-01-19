<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/admin/issue_ui.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/form.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/detail.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/main.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.description_templates = <?=json_encode($description_templates)?>;
        window.project_uploads_path = "/issue/main/upload";
        window.preview_markdown_path = "/issue/main/preview_markdown";
    </script>

    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.css"/>

    <script src="<?= ROOT_URL ?>dev/lib/simplemde/dist/simplemde.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib//simplemde/dist/simplemde.min.css">

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/e-smart-zoom-jquery.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/editor.md/css/editormd.css"/>

    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/marked.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/prettify.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/editormd.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.css"/>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/issue/list.css?v=<?=$_version?>"/>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<div class=""></div>
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>

        <script>
            var findFileURL = "";
        </script>
        <div class="page-with-sidebar">
            <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>
            <? require_once VIEW_PATH . 'gitlab/issue/common-filter-nav-links-sub-nav.php'; ?>

            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">

                    <div class="flash-container flash-container-page">
                    </div>
                </div>
                <div class=" ">
                    <div class="content" id="content-body">
                        <div class="container-fluid padding-0">

                            <div class="issues-filters">
                                <div class="filtered-search-block issues-details-filters row-content-block second-block"
                                     v-pre="false">
                                    <form id="filter-form" class="filter-form js-filter-form" action="#"
                                          accept-charset="UTF-8" method="get">
                                        <input name="utf8" type="hidden" value="&#x2713;"/>
                                        <input name="page" id="filter_page" type="hidden" value="1">
                                        <!--<div class="check-all-holder">
                                            <input type="checkbox" name="check_all_issues" id="check_all_issues"
                                                   class="check_all_issues left"/>
                                        </div>-->
                                        <div class="issues-other-filters filtered-search-wrapper">
                                            <div class="filtered-search-box">
                                                <div class="dropdown filtered-search-history-dropdown-wrapper">
                                                    <button
                                                            class="dropdown-menu-toggle filtered-search-history-dropdown-toggle-button"
                                                            type="button" data-toggle="dropdown">
                                                    <span class="dropdown-toggle-text ">
                                                        <i class="fa fa-history"></i>
                                                    </span>
                                                        <i class="fa fa-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-select filtered-search-history-dropdown">
                                                        <div class="dropdown-title"><span>历史搜索</span>
                                                            <button class="dropdown-title-button dropdown-menu-close"
                                                                    aria-label="Close" type="button"><i
                                                                        class="fa fa-times dropdown-menu-close-icon"></i>
                                                            </button>
                                                        </div>
                                                        <div class="dropdown-content filtered-search-history-dropdown-content">
                                                            <div class="js-filtered-search-history-dropdown"></div>
                                                        </div>
                                                        <div class="dropdown-loading"><i
                                                                    class="fa fa-spinner fa-spin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filtered-search-box-input-container">
                                                    <div class="scroll-container">
                                                        <ul class="tokens-container list-unstyled">
                                                            <li class="input-token">
                                                                <input class="form-control filtered-search"
                                                                       data-base-endpoint="/ismond/xphp"
                                                                       data-project-id="31"
                                                                       data-username-params="[]"
                                                                       id="filtered-search-issues"
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
                                                                    <span>提示:按"回车键"进行查询</span>
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
                                                                    <div class="dropdown-user-details">
                                                                        <span>{{name}}</span>
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
                                                                    <div class="dropdown-user-details">
                                                                        <span>{{name}}</span>
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
                                                         data-hint="状态" data-icon="info" data-tag="status"
                                                         data-type="input"
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
                                            <!--<div class="filter-dropdown-container">
                                            <div class="dropdown inline prepend-left-10">
                                                <button class="dropdown-toggle" data-display="static" data-toggle="dropdown" type="button">
                                                    排  序
                                                    <i aria-hidden="true" data-hidden="true" class="fa fa-chevron-down"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-selectable dropdown-menu-sort">
                                                    <li>
                                                        <a class="sort_link"  data-field="created" data-sortby="desc" href="#">
                                                            创建时间 <? /*=$sort_field=='created' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a  class="sort_link"  data-field="updated" data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>" href="#">
                                                            更新时间 <? /*=$sort_field=='updated' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link"  data-field="priority"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"   href="#">
                                                            优先级 <? /*=$sort_field=='priority' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link" data-field="module"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"  href="#">
                                                            模  块 <? /*=$sort_field=='module' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link"  data-field="issue_type"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"  href="#">
                                                            类  型 <? /*=$sort_field=='issue_type' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link"  data-field="status"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"  href="#">
                                                            状  态 <? /*=$sort_field=='status' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link"  data-field="resolve"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"  href="#">
                                                            解决结果 <? /*=$sort_field=='resolve' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                        <a class="sort_link" data-field="due_date"  data-sortby="<? /*=$sort_by=='desc' ? "asc":"desc"*/ ?>"  href="#">
                                                            截止日期 <? /*=$sort_field=='due_date' ? '<i class="fa fa-sort-'.$sort_by.'"></i>':''*/ ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>-->
                                            <div class="filter-dropdown-container">
                                                <div class="dropdown inline prepend-left-10" title="">

                                                    <button class="dropdown-toggle" id="btn-go_search" type="submit"
                                                            title="请求数据">
                                                        <i class="fa fa-search "></i> 搜 索
                                                    </button>
                                                   <button class="dropdown-toggle" id="save_filter-btn" type="button"
                                                            title="保存搜索条件">
                                                        <i class="fa fa-save "></i> 保 存
                                                    </button>

                                                    <button id="change_view" class="dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="fa fa-outdent"></i> 更改视图
                                                    </button><!-- aria-haspopup="true" aria-expanded="false"-->
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                        id="view_choice">
                                                        <li class="normal" data-stopPropagation="true">
                                                            <i class="fa fa-list"></i> 列表视图
                                                        </li>
                                                        <li class="float-part" data-stopPropagation="true">
                                                            <i class="fa fa-outdent"></i> 详细视图
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    if(isset($projectPermArr[\main\app\classes\PermissionLogic::CREATE_ISSUES])){
                                                    ?>
                                                    <a class="btn btn-new js-key-create"
                                                       data-target="#modal-create-issue" data-toggle="modal"
                                                       id="btn-create-issue" style="margin-bottom: 4px;"
                                                       href="#modal-create-issue"><i class="fa fa-plus fa-fw"></i>
                                                        创 建
                                                    </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="small-tips hide"><!-- todo:当用户第一次进来，点击input的时候，然后setTimeout消失 -->
                                    <img src="<?= ROOT_URL ?>dev/img/tips_top.png" alt="">
                                    这是一些提示
                                </div>
                            </div>

                            <script>
                                new UsersSelect();
                                new LabelsSelect();
                                new MilestoneSelect();
                                new IssueStatusSelect();
                                new SubscriptionSelect();
                                var filteredSearchManager = null;
                                $(document).off('page:restore').on('page:restore', function (event) {
                                    if (gl.FilteredSearchManager) {
                                        window.filteredSearchManager = new gl.FilteredSearchManager();
                                    }
                                    Issuable.init();
                                    new gl.IssuableBulkActions({
                                        prefixId: 'issue_'
                                    });
                                });
                            </script>

                            <div class="issues-holder">

                                <div class="table-holder" >
                                    <table class="table  tree-table" id="tree-slider" style="display:none;">
                                        <thead>

                                        <tr>
                                            <th class="js-pipeline-info pipeline-info">关键字</th>
                                            <th class="js-pipeline-info pipeline-info">
                                                <a class="sort_link" data-field="issue_type"
                                                   data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                    类  型 <?= $sort_field == 'issue_type' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                </a>
                                </th>
                                <th class="js-pipeline-stages pipeline-info">
                                    <a class="sort_link" data-field="priority"
                                       data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                        优先级 <?= $sort_field == 'priority' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                    </a>
                                </th>
                                <?php
                                if ($is_all_issues) {
                                    ?>
                                    <th class="js-pipeline-info pipeline-info">项 目</th>
                                <?php } ?>

                                <th class="js-pipeline-info pipeline-info">
                                    <a class="sort_link" data-field="module"
                                       data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                        模 块 <?= $sort_field == 'module' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                    </a>
                                </th>
                                <th class="js-pipeline-commit pipeline-commit">主 题</th>
                                <th class="js-pipeline-stages pipeline-info">经办人</th>
                                <!--<th class="js-pipeline-stages pipeline-info">
                                    <span class="js-pipeline-date pipeline-stages">报告人</span>
                                </th>-->
                                <th class="js-pipeline-stages pipeline-info">
                                    <a class="sort_link" data-field="status"
                                       data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                        状  态 <?= $sort_field == 'status' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                    </a>
                                </th>
                                <th class="js-pipeline-stages pipeline-info">
                                    <a class="sort_link" data-field="resolve"
                                       data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                        解决结果 <?= $sort_field == 'resolve' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                    </a>
                                </th>
                                <th class="js-pipeline-date pipeline-date">
                                    <a title="排序将按 '截止日期' 排列" class="sort_link" data-field="due_date"
                                       data-sortby="<?= $sort_by == 'desc' ? "asc" : "desc" ?>" href="#">
                                        限  期 <?= $sort_field == 'due_date' ? '<i class="fa fa-sort-' . $sort_by . '"></i>' : '' ?>
                                    </a>
                                </th>
                                <th class="js-pipeline-actions pipeline-actions">操 作

                                </th>
                                </tr>
                                </thead>
                                <tbody id="list_render_id">

                                </tbody>
                                </table>
                            </div>
                                <div class="table-holder">
                                    <div id="detail_render_id" style="display:none;">

                                    </div>
                                </div>

                                <div class="row-content-block second-block" v-pre="false">
                                    <form class="filter-form js-filter-form" action="#" accept-charset="UTF-8"
                                          method="get">
                                        <div class="issuable-actions" id="issue-actions">
                                            <input type="checkbox" name="btn-check_all_issues" id="btn-check_all_issues"
                                                   class="left"> 全 选
                                            <span style="margin-left: 1em">
                                        选中项： </span>
                                            <div class="btn-group" role="group" aria-label="...">
                                                <button id="btn-batchDelete" type="button" class="btn btn-default">
                                                    <i class="fa fa-remove"></i>
                                                    删 除
                                                </button>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        解决结果
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        foreach ($issue_resolve as $item) {
                                                            echo '<li><a class="btn_batch_update"  data-field="resolve" data-id="' . $item['id'] . '"  href="#" style="color:' . $item['color'] . '">' . $item['name'] . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        模 块
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        foreach ($project_modules as $key => $item) {
                                                            echo '<li><a class="btn_batch_update" data-field="module" data-id="' . $key . '"  href="#" >' . $item['name'] . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        迭 代
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        foreach ($sprints as $item) {
                                                            echo '<li><a class="btn_batch_update"   data-field="sprint" data-id="' . $item['id'] . '"  href="#">' . $item['name'] . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>

                                            <span style="margin-left: 1em">
                                        总数:<span id="issue_count"></span> 每页显示:<span id="page_size"></span>
                                    </span>
                                        </div>
                                    </form>
                                </div>

                                <div class="gl-pagination" id="ampagination-bootstrap">

                                </div>

                            </div>


                            <?php include VIEW_PATH . 'gitlab/issue/detail-right-list.php'; ?>
                            <!--
                            <!--                    <div class="camper-helper center hide ">-->
                            <!--                        <div class="camper-helper__bubble">-->
                            <!--                            <div class="camper-helper_bubble-content">-->
                            <!--                                <h5 class="push_half--top flush--bottom">-->
                            <!--                                    Hello! If you need help,I can help you ~-->
                            <!--                                </h5>-->
                            <!--                                <div class="camper-helper__buttons">-->
                            <!--                                    <a id="showMoreTips" class="btn btn--reversed btn--full-width push_half--bottom">Yes, let’s star!</a><!--todo:需要添加动画效果-->
                            <!--                                    <a id="closeTips" class="btn btn--full-width btn--semi-transparent" data-behavior="dismiss_camper_helper">No thanks</a>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                        </div>-->
                            <!--                        <img src="-->
                            <? //=ROOT_URL?><!--dev/img/smile.png" class="camper-helper__nerd img--sized" alt="">-->
                            <!--                    </div>-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="maskLayer hide"></div> --><!--背景遮罩-->


            <div id="tips_panel" class="modal">
                <div class="modal-dialog" style="width:100%;">
                    <div class="card" style="width: 1200px;margin:0 auto;">
                        <div class="block-bg text-center">
                            <img src="<?= ROOT_URL ?>dev/img/smile.png" alt="">
                            <h4 class="text-center">123456</h4>
                            <a class="btn close-detail-tips">Thanks & Return</a>
                        </div>
                        <img class="tips_arrow_bottom" src="<?= ROOT_URL ?>dev/img/tips_bottom.png" alt="">
                        <div class="card-body text-center">
                            <p class="card-text">Some make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>
            </div><!--第二阶段实施-->


            <?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

            <script type="text/html" id="save_filter_tpl">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" id="save_filter_text" placeholder="请输入过滤器名称" name="save_filter_text"
                               class="form-control"/>
                    </div>
                    <div class="col-md-4"><a class="btn btn-sm" id="save_filter_btn"
                                             onclick="IssueMain.prototype.saveFilter($('#save_filter_text').val())"
                                             href="#">确定</a>
                    </div>
                </div>
            </script>

            <div id="fine-uploader-gallery" style="display: none"></div>

            <script type="text/html" id="list_tpl">
                {{#issues}}

                <tr class="tree-item" data-id="{{id}}">

                    <td class="width_6">
                        <div class="checkbox">
                            <label>
                                <input name="check_issue_id_arr" id="issue_id_{{id}}" type="checkbox" value="{{id}}">#{{issue_num}}
                            </label>
                        </div>
                    </td>
                    <td class="width_6">
                        {{issue_type_html issue_type}}
                    </td>
                    <td class="width_5">
                         {{priority_html priority }}
                    </td>
                    <?php
                    if ($is_all_issues) {
                        ?>
                        <td class="width_8">
                            {{make_project project_id}}
                        </td>
                    <?php } ?>
                    <td class="width_4">
                        {{module_html module}}
                    </td>
                    <td class="show-tooltip width_35">
                        <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}" class="commit-row-message">
                            {{lightSearch summary '<?= $search ?>'}}
                        </a>

                        {{#if_eq warning_delay 1 }}
                            <span class="label label-warning " title="即将延期"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                        {{/if_eq}}

                        {{#if_eq postponed 1 }}
                        <span class="label label-danger" title="已经延期"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                        {{/if_eq}}

                        {{#if_eq have_children '0'}}
                        {{^}}
                        <a href="#" style="color:#f0ad4e" data-issue_id="{{id}}" data-issue_type="{{issue_type}}"
                           class="have_children prepend-left-5 has-tooltip"
                           data-original-title="该任务拥有{{have_children}}项子任务"
                        >
                            子任务 <span class="badge">{{have_children}}</span>
                        </a>
                        {{/if_eq}}

                    </td>
                    <td class="width_4">
                        {{user_html assignee}}
                    </td>
                    <!--
                    <td class="width_4">
                        {{user_html reporter}}
                    </td>-->

                    <td class="width_6_1">
                        <div class="status-select" data-issue_id="{{id}}" id="status-list-{{id}}">
                            {{status_html status }}
                            <ul class="status-list">

                            </ul>
                        </div>
                    </td>

                    <td class="width_7_9">
                        <div class="resolve-select" data-issue_id="{{id}}" id="resolve-list-{{id}}">
                            {{resolve_html resolve }}
                            <ul class="resolve-list">

                            </ul>
                        </div>
                    </td>
                    <td class="width_8">
                        <small class="no-value date-select-edit" id="date-select-show-{{id}}" data-issue_id="{{id}}" style="display:block;width: 100%;height: 20px;">{{show_date_range}}</small>
                    </td>
                    <td class="pipeline-actions width_4">
                        <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                            <div class="js-notification-toggle-btns">
                                <div class="">
                                    <a class="dropdown-new  notifications-btn "
                                       style="color: #8b8f94;" href="#" data-target="dropdown-15-31-Project"
                                       data-toggle="dropdown"
                                       id="notifications-button"
                                       type="button" aria-expanded="false">
                                        ...
                                        <i class="fa fa-caret-down"></i>
                                    </a>

                                    <ul class="dropdown dropdown-menu dropdown-menu-no-wrap dropdown-menu-selectable"
                                        style="left:-120px;width:160px;min-width:140px; ">

                                        <li class="aui-list-item active">
                                            <a href="javascript:;" class="issue_edit_href" data-issue_id="{{id}}">
                                                编辑
                                            </a>
                                        </li>
                                        <li class="aui-list-item">
                                            <a href="javascript:;" class="issue_copy_href" data-issue_id="{{id}}"
                                               data-issuekey="{{issue_num}}">复制</a>
                                        </li>
                                        {{#if_eq sprint '0' }}
                                        <li class="aui-list-item">
                                            <a href="javascript:;" class="issue_sprint_href" data-issue_id="{{id}}"
                                               data-issuekey="{{issue_num}}">添加到迭代</a>
                                        </li>
                                        {{else}}
                                        <li class="aui-list-item ">
                                            <a href="javascript:;" class="issue_backlog_href" data-issue_id="{{id}}"
                                               data-issuekey="{{issue_num}}">转换为待办事项</a>
                                        </li>
                                        {{/if_eq}}
										<li class="aui-list-item">
                                            <a href="javascript:;" class="issue_create_child"
                                               data-issue_id="{{id}}"
                                               data-issuekey="{{issue_num}}">创建子任务</a>
                                        </li>
                                        {{#if_eq master_id '0' }}
                                        <li class="aui-list-item">
                                            <a href="javascript:;" class="issue_convert_child_href"
                                               data-issue_id="{{id}}"
                                               data-issuekey="{{issue_num}}">转换为子任务</a>
                                        </li>
                                        {{/if_eq}}
                                        <?php
                                        if(isset($projectPermArr[\main\app\classes\PermissionLogic::DELETE_ISSUES])) {
                                            ?>
                                            <li class="aui-list-item">
                                                <a href="javascript:;" class="issue_delete_href" data-issue_id="{{id}}"
                                                   data-issuekey="IP-{{id}}">删除</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--新增一个tr当他们点击子【更多子任务】的时候-->
                {{#if_eq have_children '0'}}

                {{else}}
                <tr id="tr_subtask_{{id}}" class='pop_subtack hide' data-master_id="{{master_id}}">
                    <td colspan="12">
                        <div class="td-block">
                            <h5>子任务:</h5>
                            <div class="event-body">
                                <ul id="ul_subtask_{{id}}" class="well-list event_commits">

                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                {{/if_eq}}

                {{/issues}}

            </script>

            <script type="text/html" id="list_tpl_detail">
                {{#issues}}
                <div class="issue-box" class="display-flex" data-id="{{id}}">
                    <div class="issuable-info-container display-flex">
                        <div class="checkbox">
                            <label style="padding-top: 15%;">
                                <input name="check_issue_id_arr" id="issue_id_{{id}}" type="checkbox" value="{{id}}"/>
                            </label>
                        </div>
                        <div class="issuable-main-info" >
                            <div class="checkbox show-tooltip" data-id="{{id}}">
                                <span class="issue-title-text">
                                    <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}">{{lightSearch summary '<?= $search ?>'}}</a>
                                </span>
                                {{priority_html priority }}
                            </div>
                            <div class="issue-titles" >
                                <div  data-issue_id="{{id}}" id="status-list-{{id}}">
                                    #{{issue_num}}  {{created_text_html created created_text }} {{user_name_html reporter}}
                                    {{issue_type_html issue_type}}
                                    <div class="status-select" style="display: inline-block;" data-issue_id="{{id}}" id="status-list-{{id}}">
                                        {{status_html status }}
                                        <ul class="status-list">

                                        </ul>
                                    </div>
                                    <div class="resolve-select" style="display: inline-block;" data-issue_id="{{id}}" id="resolve-list-{{id}}">
                                        {{resolve_html resolve }}
                                        <ul class="resolve-list">

                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="issuable-metas display-flex" >
                            <div class="issuable-right display-flex" >
                                {{user_html assignee}}
                                <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                                    <div class="js-notification-toggle-btns">
                                        <div class="">
                                            <a class="dropdown-new  notifications-btn "
                                               style="color: #8b8f94;" href="#" data-target="dropdown-15-31-Project"
                                               data-toggle="dropdown"
                                               id="notifications-button"
                                               type="button" aria-expanded="false">
                                                ...
                                                <i class="fa fa-caret-down"></i>
                                            </a>

                                            <ul class="dropdown dropdown-menu dropdown-menu-no-wrap dropdown-menu-selectable"
                                                style="left:-120px;width:160px;min-width:140px; ">

                                                <li class="aui-list-item active">
                                                    <a href="javascript:;" class="issue_edit_href" data-issue_id="{{id}}">
                                                        编辑
                                                    </a>
                                                </li>
                                                <li class="aui-list-item">
                                                    <a href="javascript:;" class="issue_copy_href" data-issue_id="{{id}}"
                                                       data-issuekey="IP-524">复制</a>
                                                </li>
                                                {{#if_eq sprint '0' }}
                                                <li class="aui-list-item">
                                                    <a href="javascript:;" class="issue_sprint_href" data-issue_id="{{id}}"
                                                       data-issuekey="IP-524">添加到迭代</a>
                                                </li>
                                                {{else}}
                                                <li class="aui-list-item ">
                                                    <a href="javascript:;" class="issue_backlog_href" data-issue_id="{{id}}"
                                                       data-issuekey="IP-524">转换为待办事项</a>
                                                </li>
                                                {{/if_eq}}
                                                {{#if_eq master_id '0' }}
                                                <li class="aui-list-item">
                                                    <a href="javascript:;" class="issue_convert_child_href"
                                                       data-issue_id="{{id}}"
                                                       data-issuekey="IP-524">转换为子任务</a>
                                                </li>
                                                {{/if_eq}}

                                                <li class="aui-list-item">
                                                    <a href="javascript:;" class="issue_delete_href" data-issue_id="{{id}}"
                                                       data-issuekey="IP-524">删除</a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="issuable-updated-at">
                                <small class="edited-text"><span>更新于 </span>
                                <time class="js-timeago issue_edited_ago js-timeago-render-my" title=""
                                      datetime="{{updated}}" data-toggle="tooltip"
                                      data-placement="bottom" data-container="body" data-original-title="{{updated_text}}">
                                </time>
                                </small>
                            </div>

                        </div>
                    </div>
                </div>



                <!--新增一个tr当他们点击子【更多子任务】的时候-->
<!--                {{#if_eq have_children '0'}}-->
<!---->
<!--                {{else}}-->
<!--                    <div id="tr_subtask_{{id}}" class="td-block" data-master_id="{{master_id}}">-->-->
<!--                        <h5>子任务:</h5>-->
<!--                        <div class="event-body">-->
<!--                            <ul id="ul_subtask_{{id}}" class="well-list event_commits">-->
<!---->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                {{/if_eq}}-->

                {{/issues}}

            </script>

            <script type="text/html" id="main_children_list_tpl">
                {{#children}}
                <li class="commits-stat">
                    {{user_html assignee}}
                    <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}" target="_blank"
                       style="margin-left:5px;top: 3px;">#{{id}}
                        {{summary}}
                    </a>

                </li>
                {{/children}}
            </script>

            <script type="text/html" id="wrap_field">
                <div class=" form-group">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2">{{display_name}}:{{required_html}}</div>
                    <div class="col-sm-8">{field_html}</div>
                    <div class="col-sm-1"></div>
                </div>
            </script>

            <script type="text/html" id="li_tab_tpl">
                <div role="tabpanel" class="tab-pane " id="{{id}}">
                    <div id="{{type}}_ui_config_{{id}}" style="min-height: 200px">
                    </div>
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

            <script type="text/tpl" id="custom-filter-tpl">

        <?php
                foreach ($favFilters as $f) {
                    $active = '';
                    $class = '';
                    if ($f['id'] == $active_id) {
                        $active = ' <i class="fa fa-check"></i>';
                        $class = 'label deploy-project-label';
                    }

                    ?>
                <a class=" <?= $class ?> "  id="fav_filter-<?= $f['id'] ?>"  href="<?= ROOT_URL ?>issue/main?fav_filter=<?= $f['id'] ?>"  >
                    <?= $f['name'] ?><?= $active ?>
                </a><br>
        <?php } ?>



            </script>


            <script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>

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
                    "projects":<?=json_encode($projects)?>,
                    "sprint":<?=json_encode($sprints)?>
                };

                var _simplemde = {};

                var _fineUploaderFile = {};
                var _issue_id = null;
                var _cur_project_id = '<?=$project_id?>';
                var _active_sprint_id = '<?=@$active_sprint['id']?>';
                var _cur_uid = null;
                var _editor_md = null;
                var _description_templates = <?=json_encode($description_templates)?>;

                var $IssueMain = null;
                var $IssueDetail = null;
                var query_str = '<?=$query_str?>';
                var urls = parseURL(window.location.href);
				
				var is_save_filter = '0';

                var qtipApi = null;

                var _fineUploader = null;

                var subtack = [];
                var isFloatPart = false;

                new UsersSelect();

                var issue_view='<?=isset($G_Preferences['issue_view'])?$G_Preferences['issue_view']:'' ?>';
                var list_render_id='list_render_id';
                var list_tpl_id='list_tpl';
                if(issue_view!=undefined)
                {
                    if(issue_view==='detail')
                    {
                        list_render_id='detail_render_id';
                        list_tpl_id='list_tpl_detail';
                        $("#detail_render_id").show();
                    }
                    else {
                        $("#tree-slider").show();
                    }
                }

                $(function () {

                    getFineUploader();

                    keyMaster.addKeys([
                        {
                            key: 'e',
                            'item-element': '.tree-item',
                            'trigger-element': '.issue_edit_href',
                            trigger: 'click'
                        },
                        {
                            key: 'd',
                            'item-element': '.tree-item',
                            'trigger-element': '.issue_delete_href',
                            trigger: 'click',
                        }
                    ])

                    // single keys
                    // Mousetrap.bind('c', function () {
                    //     $('#btn-create-issue').click();
                    // });

                    // Mousetrap.bind('e', function () {
                    //     if (_issue_id != 'undefined' && _issue_id != null && _issue_id != 0) {
                    //         window.$IssueMain.fetchEditUiConfig(_issue_id, 'update');
                    //     }
                    // });

                    var options = {
                        query_str: window.query_str,
                        query_param_obj: urls.searchObject,
                        list_render_id: list_render_id, //list_render_id detail_render_id
                        list_tpl_id: list_tpl_id, //list_tpl list_tpl_detail
                        filter_form_id: "filter_form",
                        filter_url: "<?=ROOT_URL?>issue/main/filter?project=<?=$project_id?>",
                        get_url: "<?=ROOT_URL?>issue/main/get",
                        update_url: "<?=ROOT_URL?>issue/main/update",
                        add_url: "<?=ROOT_URL?>issue/main/add",
                        delete_url: "<?=ROOT_URL?>issue/main/delete",
                        pagination_id: "pagination"
                    };

                    function getdata(res) {
                        for (var i in res.issues) {
                            if (res.issues[i]['master_id'] && res.issues[i]['master_id'] > 0) {
                                subtack.push(res.issues[i]);
                            }
                        }
                    }

                    window.$IssueMain = new IssueMain(options);
                    window.$IssueMain.fetchIssueMains(getdata);

                    $('#btn-add').bind('click', function () {
                        IssueMain.prototype.add();
                    });

                    $("#btn-create-issue").bind("click", function () {
						$('#master_issue_id').val('');
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
                    });

                    $('#btn-update').bind('click', function () {
                        IssueMain.prototype.update();
                    });

                    $('#btn-batchDelete').bind('click', function () {
                        IssueMain.prototype.batchDelete();
                    });
                    $('#btn-check_all_issues').bind('click', function () {
                        IssueMain.prototype.checkedAll();
                    });


                    $('.btn_batch_update').bind('click', function () {
                        var field = $(this).data('field');
                        var value = $(this).data('id');
                        IssueMain.prototype.batchUpdate(field, value);
                    });

                    $('.sort_link').bind('click', function () {

                        var searchObj = {};
                        for (var i in urls.searchObject) {
                            var key = decodeURIComponent(i);
                            var value = decodeURIComponent(urls.searchObject[i]);
                            searchObj[key] = value;
                        }

                        var field = $(this).data('field');
                        var sortby = $(this).data('sortby');
                        searchObj['sort_field'] = field;
                        searchObj['sort_by'] = sortby;
                        console.log(searchObj);

                        url = root_url + urls.pathname.substr(1) + '?' + parseParam(searchObj);
                        console.log(url);
                        window.location.href = url;
                    });


                    /*点击选择view的样式*/
                    $('#view_choice').on('click', function (e) {
                        $('#view_choice .active').removeClass('active');
                        $('#list_render_id tr.active').removeClass('active');
                        $('#detail_render_id div.active').removeClass('issue-box-active');
                        if ($(e.target).parent().attr('id') == 'view_choice') {
                            $(e.target).addClass('active');
                        }
                        if ($(e.target).hasClass('float-part')) {
                            isFloatPart = true;
                            getRightPartData($('#list_render_id tr:first-child').attr('data-id')||$('#detail_render_id div:first-child').attr('data-id'));
                            $('.float-right-side').show();
                            $('#list_render_id tr:first-child').addClass('active');
                            $('#detail_render_id').children(":first").addClass('issue-box-active');
                        } else {
                            isFloatPart = false;
                        }
                    });

                    //点击tips提示
                    $('#showMoreTips').click(function () {
                        $('#tips_panel').modal();
                        $('.camper-helper').addClass('hide');
                    });

                    //关闭背景颜色
                    $('#tips_panel').on('shown.bs.modal', function () {
                        $('.modal-backdrop.in').css('opacity', '0.2');
                    });

                    //关闭tips提示框
                    $('#closeTips').click(function () {
                        $('.camper-helper').addClass('hide');
                    });

                    //关闭tips的弹出框
                    $('.close-detail-tips').click(function () {
                        $('.camper-helper').removeClass('hide');
                        $('#tips_panel').modal('hide');
                    });


                    //添加bottom的textare的focus事件
                    $('.bottom-part textarea').on('focus', function () {
                        $('.textarea-tips').addClass('hide');
                    });

                    $('.bottom-part textarea').on('blur', function () {
                        $('.textarea-tips').addClass('hide');
                        if (this.value == '') {
                            $('.textarea-tips').removeClass('hide');
                        }
                        //$('.textarea-tips').addClass('hide');
                    });

                    //左侧菜单的内容
                    $('#list_render_id').on('click', function (e) {
                        $('#list_render_id tr.active').removeClass('active');
                        if ($(e.target).attr('href') && $(e.target).parent().hasClass('show-tooltip')) {
                            var dataId = $(e.target).parent().parent().attr('data-id');
                            $(e.target).parent().parent().addClass('active');

                            if (isFloatPart) {
                                showFloatDetail(dataId);
                                return false;
                            }
                        } else if ($(e.target).parent().next().hasClass('pop_subtack hide')) {
                            $(e.target).parent().next().removeClass('hide');
                            $(e.target).parent().addClass('active');
                        } else if ($(e.target).parent().next().hasClass('pop_subtack')) {
                            $(e.target).parent().next().addClass('hide');
                            $(e.target).parent().removeClass('active');
                        }
                    });

                    $('#detail_render_id').on('click', '.issue-box', function (e) {
                        var dataId = $(this).data('id');
                        if (!$(e.target).attr('type') && !$(e.target).hasClass('commit-id') && !$(e.target).hasClass('label') && !$(e.target).hasClass('prepend-left-5') && !$(e.target).parent().hasClass('resolve-select')) {
                            $(this).addClass('issue-box-active').siblings('.issue-box').removeClass('issue-box-active');
                            if (isFloatPart) {
                                showFloatDetail(dataId);
                                return false;
                            }
                        }
                    });

//                    $('#detail_render_id').on('click', function (e) {
//                        $('#detail_render_id').children("div").removeClass('issue-box-active');
//
//                        if ($(e.target).hasClass('show-tooltip')) {
//                            var dataId = $(e.target).attr('data-id');
//                            $(e.target).parent().parent().parent().addClass('issue-box-active');
//
//                            if (isFloatPart) {
//                                showFloatDetail(dataId);
//                                return false;
//                            }
//
//                        } else if ($(e.target).attr('href') && $(e.target).parent().hasClass('show-tooltip')) {
//
//                        } else if ($(e.target).parent().next().hasClass('pop_subtack hide')) {
//                            $(e.target).parent().next().removeClass('hide');
//                            $(e.target).parent().addClass('active');
//                        } else if ($(e.target).parent().next().hasClass('pop_subtack')) {
//                            $(e.target).parent().next().addClass('hide');
//                            $(e.target).parent().removeClass('active');
//                        }
//                    });

                    //获取详情页信息
                    function getRightPartData(dataId) {
                        $('.maskLayer').removeClass('hide');//可以不要，但是由于跳转的时候速度太慢，所以防止用户乱点击
                        _issue_id = dataId;

                        $IssueDetail = new IssueDetail({});
                        $IssueDetail.fetchIssue(dataId, true);
                    }

                    //显示右侧浮动窗
                    function showFloatDetail(dataId) {
                        getRightPartData(dataId);
                        $('.float-right-side').show();
                    }

                    /*详情页的ajax*/
                    $('#save_filter-btn').qtip({
                        content: {
                            text: $('#save_filter_tpl').html(),
                            title: "新增过滤器",
                            button: "关闭"
                        },
                        show: 'click',
                        hide: 'click',
                        style: {
                            classes: "qtip-bootstrap",
                            width: "500px"
                        },
                        position: {
                            my: 'top left',  // Position my top left...
                            at: 'bottom center', // at the bottom right of...
                            target: $('.filtered-search')
                        },
                        events: {
                            show: function (event, api) {
                                var t = setTimeout("$('#save_filter_text').focus();", 200)
                            }
                        }
                    });
                    window.qtipApi = $('#save_filter-btn').qtip('api');


                    $('#custom-filter-more').qtip({
                        content: {
                            text: $('#custom-filter-tpl').html(),
                            title: "您收藏的过滤器",
                            button: "关闭"
                        },
                        show: 'click',
                        hide: 'click',
                        style: {
                            classes: "qtip-bootstrap",
                            width: "500px"
                        },
                        position: {
                            my: 'top left',  // Position my top left...
                            at: 'bottom center', // at the bottom right of...
                        }
                    });
                    window.qtipApi = $('#custom-filter-more').qtip('api');

                    //右边悬浮层按钮事件
                    $('#btn-edit').bind('click', function () {
                        window.$IssueMain.fetchEditUiConfig(_issue_id, 'update');
                    });

                    $('#btn-copy').bind('click', function () {
                        window.$IssueMain.fetchEditUiConfig(_issue_id, 'copy');
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

                    $("#modal-edit-issue").on('show.bs.modal', function (e) {
                        keyMaster.addKeys([
                            {
                                key: ['command+enter', 'ctrl+enter'],
                                'trigger-element': '#modal-edit-issue .btn-save',
                                trigger: 'click'
                            }
                        ])
                    })

                    //获取上传插件
                    function getFineUploader() {
                        _fineUploader = new qq.FineUploader({
                            element: document.getElementById('issue_right_attachments_uploder'),
                            template: 'qq-template-gallery',
                            multiple: true,
                            request: {
                                endpoint: '/issue/main/upload?project_id='+_cur_project_id+'&_csrftoken=' + encodeURIComponent(document.getElementById('csrf_token').value)
                            },
                            deleteFile: {
                                enabled: true,
                                forceConfirm: true,
                                endpoint: "/issue/main/upload_delete?project_id="+_cur_project_id
                            },
                            validation: {
                                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', '7z', 'zip', 'rar', 'bmp', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf', 'xlt', 'xltx', 'txt'],
                            }
                        });
                    }

                });

                var _curFineAttachmentUploader = null;
                var _curIssueId = null;
                var _curTmpIssueId = null;
                var _curQrToken = null;
                var mobileUploadInterval = null;


            </script>
</body>
</html>

