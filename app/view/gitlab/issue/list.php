<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/issuable.bundle.js"></script>
    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/admin/issue_ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/form.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/detail.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.description_templates = <?=json_encode($description_templates)?>;
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
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
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/editor.md/css/editormd.css"/>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/editormd.js"></script>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/issue/detail-list.css"/>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
    <div class=""></div>
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
    <? require_once VIEW_PATH . 'gitlab/issue/common-filter-nav-links-sub-nav.php'; ?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid">
                    <?php
                    if (count($hideFilters) > 0) {
                        ?>
                        <div class="top-area">
                            <ul class="nav-links issues-state-filters" id="fav_filters">
                                <?php

                                foreach ($firstFilters as $f) {
                                    $active = '';
                                    if ($f['id'] == $active_id) {
                                        $active = 'active';
                                    }
                                    ?>
                                    <li class="fav_filter_li <?= $active ?>">
                                        <a id="fav_filter-<?= $f['id'] ?>" title="<?= $f['description'] ?>"
                                           href="<?= ROOT_URL ?>issue/main?fav_filter=<?= $f['id'] ?>">
                                            <span><?= $f['name'] ?></span>
                                            <span class="badge">0</span>
                                        </a>
                                    </li>
                                <?php } ?>


                            </ul>
                            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                                <div class="js-notification-toggle-btns">
                                    <div class="">
                                        <?php
                                        if (count($hideFilters) > 0) {
                                            ?>
                                            <a class="dropdown-new  notifications-btn " style="color: #8b8f94;" href="#"
                                               data-target="dropdown-15-31-Project" data-toggle="dropdown"
                                               id="notifications-button" type="button" aria-expanded="false">
                                                更多
                                                <i class="fa fa-caret-down"></i>
                                            </a>
                                        <?php } ?>
                                        <ul class="dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable"
                                            role="menu" id="fav_hide_filters">
                                            <?php
                                            foreach ($hideFilters as $f) {
                                                $active = '';
                                                if ($f['id'] == $active_id) {
                                                    $active = 'is-active';
                                                }
                                                ?>
                                                <li>
                                                    <a class="update-notification <?= $active ?>"
                                                       id="fav_filter-<?= $f['id'] ?>"
                                                       href="<?= ROOT_URL ?>issue/main?fav_filter=<?= $f['id'] ?>"
                                                       role="button">
                                                        <strong class="dropdown-menu-inner-title"><?= $f['name'] ?></strong>
                                                        <span class="dropdown-menu-inner-content"><?= $f['description'] ?></span>
                                                    </a>
                                                    <span class="float-right"></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="issues-filters">
                        <div class="filtered-search-block issues-details-filters row-content-block second-block"
                             v-pre="false">
                            <form class="filter-form js-filter-form" action="#" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="&#x2713;"/>
                                <input name="page" id="filter_page" type="hidden" value="1">
                                <div class="check-all-holder">
                                    <input type="checkbox" name="check_all_issues" id="check_all_issues"
                                           class="check_all_issues left"/>
                                </div>
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
                                                <div class="dropdown-title"><span>Recent searches</span>
                                                    <button class="dropdown-title-button dropdown-menu-close"
                                                            aria-label="Close" type="button"><i
                                                                class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-content filtered-search-history-dropdown-content">
                                                    <div class="js-filtered-search-history-dropdown"></div>
                                                </div>
                                                <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
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
                                                            <span class="label label-{{color}} js-data-value">{{name}}</span>
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
                                    <div class="filter-dropdown-container">
                                        <div class="dropdown inline prepend-left-10">

                                            <button class="dropdown-toggle" id="save_filter-btn" type="button">
                                                <i class="fa fa-filter "></i> 保存搜索条件
                                            </button>
                                            <button id="change_view" class="dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                更改视图<span class="caret"></span>
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

                                            <a class="btn btn-new" data-target="#modal-create-issue" data-toggle="modal"
                                               id="btn-create-issue" style="margin-bottom: 4px;"
                                               href="#modal-create-issue"><i class="fa fa-plus fa-fw"></i>
                                                创 建
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="small-tips hide"><!-- todo:当用户第一次进来，点击input的时候，然后setTimeout消失 -->
                            <img src="<?=ROOT_URL?>dev/img/tips_top.png" alt="">
                            这是一些提示
                        </div>
                    </div>

                    <script>
                        new UsersSelect();
                        new LabelsSelect();
                        new MilestoneSelect();
                        new IssueStatusSelect();
                        new SubscriptionSelect();

                        $(document).off('page:restore').on('page:restore', function (event) {
                            if (gl.FilteredSearchManager) {
                                new gl.FilteredSearchManager();
                            }
                            Issuable.init();
                            new gl.IssuableBulkActions({
                                prefixId: 'issue_'
                            });
                        });
                    </script>

                    <div class="issues-holder">
                        <div class="table-holder">
                            <table class="table  tree-table" id="tree-slider">
                                <thead>

                                <tr>
                                    <th class="js-pipeline-info pipeline-info">关键字</th>
                                    <th class="js-pipeline-info pipeline-info">类型</th>
                                    <th class="js-pipeline-stages pipeline-info">
                                        <span class="js-pipeline-date pipeline-stages">优先级</span>
                                    </th>
                                    <th class="js-pipeline-info pipeline-info">模块</th>
                                    <th class="js-pipeline-commit pipeline-commit">主题</th>
                                    <th class="js-pipeline-stages pipeline-info">经办人</th>
                                    <th class="js-pipeline-stages pipeline-info">
                                        <span class="js-pipeline-date pipeline-stages">报告人</span>
                                    </th>
                                    <th class="js-pipeline-stages pipeline-info">
                                        <span class="js-pipeline-date pipeline-stages">状态</span>
                                    </th>
                                    <th class="js-pipeline-stages pipeline-info">
                                        <span class="js-pipeline-date pipeline-stages">解决结果</span>
                                    </th>
                                    <th class="js-pipeline-date pipeline-date">创建时间</th>
                                    <th class="js-pipeline-date pipeline-date">更新时间</th>
                                    <th class="js-pipeline-actions pipeline-actions">操作

                                    </th>
                                </tr>

                                </thead>
                                <tbody id="list_render_id">

                                </tbody>
                            </table>
                        </div>
                        <div class="gl-pagination" id="ampagination-bootstrap">

                        </div>
                    </div>

                    <div class="float-right-side">
                        <div class="issuable-header clearfix" id="issuable-header">

                        </div>
                        <script type="text/html" id="issuable-header_tpl">
                            <h3 class="page-title">
                                Issue<a href="<?= ROOT_URL ?>issue/main/{{issue.id}}" id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a></strong>
                            </h3>

                            <div class="issuable-meta">
                                由
                                <strong>
                                    <a class="author_link  hidden-xs" href="/sven">
                                        <img id="creator_avatar" width="24" class="avatar avatar-inline s24 " alt=""
                                             src="{{issue.creator_info.avatar}}">
                                        <span id="author" class="author has-tooltip"
                                              title="@{{issue.creator_info.username}}" data-placement="top">{{issue.creator_info.display_name}}</span></a>
                                    <a class="author_link  hidden-sm hidden-md hidden-lg" href="/sven">
                                        <span class="author">@{{issue.creator_info.username}}</span></a>
                                </strong>
                                于
                                <time class="js-timeago js-timeago-render" title="">{{issue.create_time}}
                                </time>
                                创建
                            </div>
                            <span class="close-float-panel float-right">
                                    <i class="fa fa-times"></i>
                                </span>
                        </script>

                        <div class="issuable-actions clearfix" id="issue-actions">
                            <div class="btn-group" role="group" aria-label="...">
                                <button id="btn-edit" type="button" class="btn btn-default"><i class="fa fa-edit"></i>
                                    编辑
                                </button>
                                <button id="btn-copy" type="button" class="btn btn-default"><i class="fa fa-copy"></i>
                                    复制
                                </button>
                                <!--<button id="btn-attachment" type="button" class="btn btn-default"><i class="fa fa-file-image-o"></i> 附件</button>-->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        状态
                                        <i class="fa fa-caret-down"></i>
                                    </button>

                                    <ul class="dropdown-menu" id="allow_update_status">
                                    </ul>

                                    <script type="text/html" id="allow_update_status_tpl">
                                        {{#allow_update_status}}
                                        <li><a id="btn-{{_key}}" data-status_id="{{id}}" class="allow_update_status" href="#">
                                                <span class="label label-{{color}} prepend-left-5">{{name}}</span></a></li>
                                        {{/allow_update_status}}
                                    </script>
                                </div>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        更多
                                        <i class="fa fa-caret-down"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li><a id="btn-watch" data-followed="" href="#">关注</a></li>
                                        <li><a id="btn-create_subtask" href="#">创建子任务</a></li>
                                        <li><a id="btn-convert_subtask" href="#">转化为子任务</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div style="margin-left: 20px" class="btn-group" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        解决结果
                                        <i class="fa fa-caret-down"></i>
                                    </button>

                                    <ul class="dropdown-menu" id="allow_update_resolves">
                                    </ul>

                                    <script type="text/html"  id="allow_update_resolves_tpl">
                                        {{#allow_update_resolves}}
                                        <li>
                                            <a id="btn-{{_key}}" data-resolve_id="{{id}}" class="allow_update_resolve"
                                               href="#" style="color:{{color}}">{{name}}</a>
                                        </li>
                                        {{/allow_update_resolves}}
                                    </script>
                                </div>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        管理
                                        <i class="fa fa-caret-down"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li><a href="#">管理关注</a></li>
                                        <li><a id="btn-move" href="#">移动</a></li>
                                        <li><a id="btn-delete" href="#">删除</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="issue-detail issue-fields">
                            <span class="font-bloder">事项详情</span>
                            <hr>

                            <div id="issue_fields">

                            </div>
                            <script type="text/html" id="issue_fields_tpl">
                                <div class="row">
                                    <div class=" form-group col-lg-6">
                                        <div class="form-group issue-assignee">
                                            <label class="control-label col-sm-3">类型:</label>
                                            <div class=" col-sm-9">
                                                <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">解决结果:</label>
                                            <div class="col-sm-9">
                                                <span style=" color: {{issue.resolve_info.color}}">{{issue.resolve_info.name}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-3">状态:</label>
                                        <div class="col-sm-9">
                                            <span class="label label-{{issue.status_info.color}} prepend-left-5">{{issue.status_info.name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-3" for="issue_label_ids">优先级:</label>
                                        <div class="col-sm-9">
                                            <span class="label " style="color:{{issue.priority_info.status_color}}">{{issue.priority_info.name}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-3" for="issue_milestone_id">影响版本:</label>
                                        <div class="col-sm-9">
                                            {{#issue.effect_version_names}}
                                            <span>{{name}}</span>&nbsp;
                                            {{/issue.effect_version_names}}
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-3" for="issue_label_ids">解决版本:</label>
                                        <div class="col-sm-9">
                                            {{#issue.fix_version_names}}
                                            <span>{{name}}</span>&nbsp;
                                            {{/issue.fix_version_names}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-3" for="issue_milestone_id">模块:</label>
                                        <div class="col-sm-9">
                                            <span>{{issue.module_name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-3" for="issue_label_ids">标签:</label>
                                        <div class="col-sm-9">
                                            {{#issue.labels_names}}
                                            <a class="label-link" href="<?= ROOT_URL ?>issue/main/?label={{name}}">
                                                    <span class="label color-label has-tooltip"
                                                          style="background-color: {{bg_color}}; color: {{color}}"
                                                          title="" data-container="body"
                                                          data-original-title="red waring">{{title}}</span>
                                            </a>
                                            {{/issue.labels_names}}
                                        </div>
                                    </div>
                                </div>
                            </script>
                        </div>

                        <div class="issue-detail detail-page-description">
<!--                            <div class="issue-title-data hidden" data-endpoint="#" data-initial-title="{{issue.summary}}"></div>-->
                            <div id="detail-page-description">

                            </div>
                            <script type="text/html" id="detail-page-description_tpl">
                                <h3 class="issue-detail-title">描述</h3>

                                {{#if issue.description}}
                                <div class="description js-task-list-container is-task-list-enabled">
                                    <p class="wiki"><p dir="auto"><pre>{{issue.description}}</pre></p></div>
                                    <textarea class="hidden js-task-list-field">{{issue.description}}</textarea>
                                </div>

                                <small class="edited-text"><span>最后修改于 </span>
                                    <time class="js-timeago issue_edited_ago js-timeago-render" title=""
                                          datetime="{{issue.updated_text}}" data-toggle="tooltip"
                                          data-placement="bottom" data-container="body" data-original-title="{{issue.updated}}">{{issue.updated_text}}
                                    </time>
                                </small>

                                {{/if}}
                            </script>
                        </div>

                        <div id="detail-page-attachments" class="issue-detail issue-attachments">
                            <h3 class="issue-detail-title">附件</h3>

                            <input type="hidden"  name="params[attachments]" id="attachments"  value=""  />
                            <input type="hidden"  name="params[fine_uploader_json]" id="fine_uploader_json"  value=""  />
                            <div id="attachments_uploder" class="fine_uploader_img"></div>
                        </div>

                        <div class="issue-detail issue-assignee">
                            <h3 class="issue-detail-title">受理人</h3>

                            <div id="detail-page-assignee">

                            </div>

                            <script type="text/html" id="detail-page-assignee_tpl">
                                <div class="sidebar-collapsed-icon sidebar-collapsed-user" data-container="body" data-placement="left" data-toggle="tooltip" title="<?=$issue['assignee_info']['display_name']?>">
                                    <a class="author_link" href="/{{assignee_info.username}}">
                                        <img width="24" class="avatar avatar-inline s24 " alt="" src="{{assignee_info.avatar}}">
                                        <span class="author">{{assignee_info.display_name}}</span></a>
                                </div>
                                {{assignee_info.username}}
                            </script>
                        </div>

                        <div class="issue-detail issue-start-date">
                            <h3 class="issue-detail-title">开始时间</h3>

                            <div id="detail-page-start-date">

                            </div>

                            <script type="text/html" id="detail-page-start-date_tpl">
                                {{start_date}}
                            </script>
                        </div>

                        <div class="issue-detail issue-end-date">
                            <h3 class="issue-detail-title">截止时间</h3>
                            <div id="detail-page-end-date">

                            </div>

                            <script type="text/html" id="detail-page-end-date_tpl">
                                {{due_date}}
                            </script>
                        </div>

                        <div class="issue-detail issue-assistants">
                            <h3 class="issue-detail-title">协助人</h3>

                            <div id="detail-page-assistants">

                            </div>

                            <script type="text/html" id="detail-page-assistants_tpl">
                                {{assistants}}
                            </script>
                        </div>

                        <div id="parent_block" class="issue-detail issue-parent-block hide">
                            <h3 class="issue-detail-title">父任务</h3>

                            <div id="parent_issue_div" class="cross-project-reference hide-collapsed">

                            </div>

                            <script type="text/html" id="parent_issue_tpl">
                                <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
                            </script>
                        </div>

                        <div class="issue-detail issue-child-block">
                            <h3 class="issue-detail-title">子任务</h3>

                            <ul id="child_issues_div" class="cross-project-reference hide-collapsed">

                            </ul>

                            <script type="text/html" id="child_issues_tpl">
                                {{#child_issues}}
                                <li>
                                    <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
                                </li>
                                {{/child_issues}}
                            </script>
                        </div>

                        <div id="custom_field_values_block" class="issue-detail issue-project-reference hide">
                            <h3 class="issue-detail-title">自定义字段</h3>

                            <div id="custom_field_values_div" class="cross-project-reference hide-collapsed">

                            </div>

                            <script type="text/html" id="custom_field_values_tpl">
                                {{#custom_field_values}}
                                <span>
                                    <cite title="{{field.description}}">{{field_title}}:{{show_value}}</cite>
                                </span>
                                <button class="btn btn--map-pin btn-transparent" data-toggle="tooltip" data-placement="left"
                                        data-container="body" data-title="{{show_value}}" data-body="{{value}}"
                                        data-clipboard-text="{{value}}" type="button" title="{{value}}">
                                    <i aria-hidden="true" class="fa fa-map-pin"></i>
                                </button>
                                {{/custom_field_values}}
                            </script>
                        </div>

                        <div class="issue-detail issue-discussion">
                            <h3 class="issue-detail-title">评论</h3>

                            <input type="hidden" name="issue_id" id="issue_id" value="" />

                            <div id="notes">
                                <ul class="notes main-notes-list timeline" id="timelines_list">

                                </ul>
                                <div class="note-edit-form">

                                </div>

                                <ul class="notes notes-form timeline">
                                    <li class="timeline-entry">
                                        <div class="flash-container timeline-content"></div>
                                        <div class="timeline-icon hidden-xs hidden-sm">
                                            <a class="author_link" href="/<?=$user['username']?>">
                                                <img alt="@<?=$user['username']?>" class="avatar s40" src="<?=$user['avatar']?>" /></a>
                                        </div>

                                        <div class="timeline-content timeline-content-form">
                                            <form data-type="json" class="new-note js-quick-submit common-note-form gfm-form js-main-target-form" enctype="multipart/form-data" action="<?=ROOT_URL?>issue/main/comment" accept-charset="UTF-8" data-remote="true" method="post" style="display: block;">
                                                <input name="utf8" type="hidden" value="✓">
                                                <input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                                                <input type="hidden" name="view" id="view" value="inline">

                                                <div id="editor_md">
                                                    <textarea style="display:none;"></textarea>
                                                </div>

                                                <div class="note-form-actions clearfix">
                                                    <input id="btn-comment" class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button" type="button" value="Comment">

                                                    <a id="btn-comment-reopen"  class="btn btn-nr btn-reopen btn-comment js-note-target-reopen " title="Reopen issue" href="#">Reopen issue</a>
                                                    <a data-no-turbolink="true" data-original-text="Close issue" data-alternative-text="Comment &amp; close issue" class="btn btn-nr btn-close btn-comment js-note-target-close hidden" title="Close issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close issue</a>
                                                    <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel" role="button">Discard draft</a>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>

                                <div id="timeline-edit">

                                </div>
                            </div>

                            <script type="text/html"  id="timeline_tpl">
                                {{#timelines}}
                                <li id="timeline_{{id}}" name="timeline_{{id}}" class="note note-row-{{id}} timeline-entry" data-author-id="{{uid}}" >
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <a href="/{{user.username}}">
                                                <img alt="" class="avatar s40" src="{{user.avatar}}" /></a>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@{{user.username}}</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">@{{user.display_name}}</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@{{user.username}}</span>
                                                    {{#if is_issue_commented}}
                                                    {{{action}}}
                                                    {{^}}
                                                    <span class="system-note-message">
                                                        {{{content}}}
                                                     </span>
                                                    {{/if}}
                                                    <a href="#note_{{id}}">{{time_text}}</a>
                                                </div>

                                                <div id="note-actions_{{id}}" class="note-actions">
                                                    {{#if is_issue_commented}}
                                                    {{#if is_cur_user}}
                                                    <a id="btn-timeline-edit_{{id}}" data-id="{{id}}" title="Edit comment"
                                                       class="note-action-button js-note-edit2" href="#timeline_{{id}}">
                                                        <i class="fa fa-pencil link-highlight"></i>
                                                    </a>
                                                    <a id="btn-timeline-remove_{{id}}" data-id="{{id}}"
                                                       class="note-action-button js-note-remove danger"
                                                       data-title="Remove comment"
                                                       data-confirm2="Are you sure you want to remove this comment?"
                                                       data-url="<?=ROOT_URL?>issue/detail/delete_timeline/{{id}}"
                                                       href="#timeline_{{id}}" >
                                                        <i class="fa fa-trash-o danger-highlight"></i>
                                                    </a>
                                                    {{/if}}
                                                    {{/if}}
                                                </div>
                                            </div>
                                            {{#if is_issue_commented}}
                                            <div class="js-task-list-container note-body is-task-list-enabled">
                                                <form class="edit-note common-note-form js-quick-submit gfm-form" action="<?=ROOT_URL?>issue/detail/update_timeline/{{id}}" accept-charset="UTF-8" method="post" data-remote="true">

                                                    <div id="timeline-text_{{id}}" class="note-text md ">
                                                        <p dir="auto">
                                                            {{{content_html}}}
                                                        </p>
                                                    </div>

                                                    <div id="timeline-div-editormd_{{id}}" class="note-awards" >
                                                        <textarea  id="timeline-textarea_{{id}}" name="content" class="hidden js-task-list-field original-task-list">{{content}}</textarea>
                                                    </div>
                                                    <div id="timeline-footer-action_{{id}}" class="note-form-actions hidden clearfix">
                                                        <div class="settings-message note-edit-warning js-edit-warning">
                                                            Finish editing this message first!
                                                        </div>
                                                        <input data-id="{{id}}"  type="button" name="comment_commit" value="Save comment" class="btn btn-nr btn-save js-comment-button btn-timeline-update">
                                                        <button data-id="{{id}}"  class="btn btn-nr btn-cancel note-edit-cancel" type="button">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            {{^}}
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">
                                                        {{{content_html}}}
                                                    </p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="<?=ROOT_URL?>issue/detail/timeline/{{id}}">
                                                        <div class="award-menu-holder js-award-holder">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            {{/if}}
                                        </div>
                                    </div>
                                </li>
                                {{/timelines}}
                            </script>

                            <script type="text/html"  id="timeline-edit_tpl">
                                <ul class="notes notes-form timeline">
                                    <li class="timeline-entry">
                                        <div class="flash-container timeline-content"></div>
                                        <div class="timeline-icon hidden-xs hidden-sm">
                                            <a class="author_link" href="/<?=$user['username']?>">
                                                <img alt="@<?=$user['username']?>" class="avatar s40" src="<?=$user['avatar']?>" /></a>
                                        </div>

                                        <div class="timeline-content timeline-content-form">
                                            <form data-type="json" class="new-note js-quick-submit common-note-form gfm-form js-main-target-form" enctype="multipart/form-data" action="<?=ROOT_URL?>issue/main/comment" accept-charset="UTF-8" data-remote="true" method="post" style="display: block;">
                                                <input name="utf8" type="hidden" value="✓">
                                                <input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                                                <input type="hidden" name="view" id="view" value="inline">

                                                <div id="editor_md">
                                                    <textarea style="display:none;"></textarea>
                                                </div>

                                                <div class="note-form-actions clearfix">
                                                    <input id="btn-comment" class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button" type="button" value="Comment">

                                                    <a id="btn-comment-reopen"  class="btn btn-nr btn-reopen btn-comment js-note-target-reopen " title="Reopen issue" href="#">Reopen issue</a>
                                                    <a data-no-turbolink="true" data-original-text="Close issue" data-alternative-text="Comment &amp; close issue" class="btn btn-nr btn-close btn-comment js-note-target-close hidden" title="Close issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close issue</a>
                                                    <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel" role="button">Discard draft</a>
                                                </div>
                                            </form>
                                        </div>

                                    </li>
                                </ul>
                            </script>
                        </div>
                    </div>
<!--                    -->
<!--                    <div class="camper-helper center hide ">-->
<!--                        <div class="camper-helper__bubble">-->
<!--                            <div class="camper-helper_bubble-content">-->
<!--                                <h5 class="push_half--top flush--bottom">-->
<!--                                    Hello! If you need help,I can help you ~-->
<!--                                </h5>-->
<!--                                <div class="camper-helper__buttons">-->
<!--                                    <a id="showMoreTips" class="btn btn--reversed btn--full-width push_half--bottom">Yes, let’s star!</a><!--todo:需要添加动画效果-->-->
<!--                                    <a id="closeTips" class="btn btn--full-width btn--semi-transparent" data-behavior="dismiss_camper_helper">No thanks</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <img src="--><?//=ROOT_URL?><!--dev/img/smile.png" class="camper-helper__nerd img--sized" alt="">-->
<!---->
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
                    <img src="<?=ROOT_URL?>dev/img/smile.png" alt="">
                    <h4 class="text-center">123456</h4>
                    <a class="btn close-detail-tips">Thanks & Return</a>
                </div>
                <img class="tips_arrow_bottom" src="<?=ROOT_URL?>dev/img/tips_bottom.png" alt="">
                <div class="card-body text-center">
                    <p class="card-text">Some make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </div><!--第二阶段实施-->

    <div id="helper_panel" class="">
        <div class="close-helper">
            <span class="text">close</span>
            <span><i class="fa fa-times"></i></span><!--class="bg-times"-->
        </div>
        <div class="bg-linear"></div>
        <div class="helper-content">
            <div class="panel">
                <div class="panel-title">
                    <p>是否有以下这些疑问？</p>
                </div>
                <div class="panel-body">
                    <div class="main-content">
                        <ul id="">
                            <li class="more-detail"><i class="fa fa-file"></i> 开始使用</li>
                            <li class="more-detail"><i class="fa fa-file"></i> 快捷键的试用</li>
                            <li class="new-page"><i class="fa fa-link"></i> 我们工作特点</li><!--可以做链接-->
                        </ul>
                    </div>
                    <hr>
                    <div class="extra-help">
                        <ul>
                            <li class="comment-content"><i class="fa fa-comments"></i> contact us</li>
                            <li class="history-detail"><i class="fa fa-history"></i> 历史记录</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="search-help">
                    <input type="text" class="searchAnswer" placeholder="You can Search what you need">
                    <span class="icon-content"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
        <div class="clean-card hide">
            <i class="fa fa-times fa-fw"></i>
        </div>
        <div class="card hide" id="detail_content"><!--详细内容-->
            <div class="detail">
                <h4>这是一个标题</h4>
                <div class="fragment">欢迎光临参加本次主题</div>
                <div class="fragment">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Est explicabo ipsam non numquam pariatur perferendis possimus ratione veniam.
                    Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                    voluptas voluptatem.
                </div>
                <div class="img-content"><!--2px白边-->
                    <img src="<?=ROOT_URL?>dev/img/gitlab_header_logo.png" alt="">
                </div>
                <div class="fragment">
                    <h4>这又是一个标题</h4>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Est explicabo ipsam non numquam p<a href="">click me</a> perferendis possimus ratione veniam.
                    Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                    voluptas voluptatem.
                </div>
                <p class="second-title">
                    <span class="small-title">123456 : </span><a href="">456</a>
                </p>
                <p class="second-title">
                    <span class="small-title">123456 : </span>
                </p>
                <div class="fragment-notice"><!--虚线框，背景色-->
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut blanditiis culpa, cumque,
                    dicta dolorum earum eligendi exercitationem facilis,
                    illo inventore nam nesciunt nobis non numquam rem sunt veritatis vitae.
                </div>
                <div class="catalog-link">
                    <p class="second-title">
                        <span class="small-title">链接地址：</span>
                    </p>
                    <ul>
                        <li><a href="">click me</a></li>
                        <li><a href="">click me</a></li>
                        <li><a href="">click me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card hide" id="contact-panel"><!--对话框-->
            <div class="top-part">
                <i class="fa fa-arrow-left"></i>
                <p class="text-center">
                    <span class="small-title">建议&疑问</span>
                </p>
                <div class="img-group text-center">
                    <div class="img-col">
                        <div class="img_item">
                            <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                        </div>
                    </div>
                    <div class="img-col">
                        <div class="img_item">
                            <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                        </div>
                    </div>
                    <div class="img-col">
                        <div class="img_item">
                            <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                        </div>
                    </div>
                    <div class="img-col">
                        <div class="img_item">
                            <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                        </div>
                    </div>
                    <div class="img-col">
                        <div class="img_item">
                            <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                        </div>
                    </div>
                </div>
                <p class="small-title text-center">我们的团队竭尽全力帮助您~</p>
                <p class="text-center">我们会在几小时之内解决您的疑问</p>
            </div>
            <div class="bottom-part">
                <span class="textarea-tips">留下您的建议或问题吧~</span>
                <textarea></textarea>
                <i class="spot"></i>
                <a href="" class="btn sendContact">提交</a>
            </div>
        </div>
        <div class="card hide" id="history-content"><!--历史信息-->
            <div class="top-part">
                <i class="fa fa-arrow-left"></i>
                <p class="text-center">
                    <span class="small-title">12345</span>
                </p>
            </div>
            <div class="list-content">
                <div class="list-fragment">
                    <p class="title-text">刚刚用户输入的问题XXX</p>
                    <p>
                        <i class="fa fa-check"></i>
                        <span>已接收，等待回答</span>
                    </p>
                </div>
            </div>
        </div>
    </div>


<?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

<script type="text/html" id="save_filter_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="save_filter_text" placeholder="请输入过滤器名称" name="save_filter_text"
                   class="form-control"/>
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="save_filter_btn"
                                 onclick="IssueMain.prototype.saveFilter($('#save_filter_text').val())" href="#">确定</a>
        </div>
    </div>
</script>

<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="将文件拖放到此处以添加附件"
         style="background-color: #ffffff"
    >
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            浏览
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
            <span>拖拽文件完成...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <div class="qq-thumbnail-wrapper">
                    <a href="#"> <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale></a>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    Retry
                </button>

                <div class="qq-file-info">
                    <div class="qq-file-name">
                        <span class="qq-upload-file-selector qq-upload-file"></span>
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    </div>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                    </button>
                </div>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">关闭</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">否</button>
                <button type="button" class="qq-ok-button-selector">是</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">取消</button>
                <button type="button" class="qq-ok-button-selector">确定</button>
            </div>
        </dialog>
    </div>
</script>

<script type="text/template" id="btn-fine-uploader">
    <div class="qq-uploader-selector " qq-drop-area-text="Drop files here" style="display: ">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container" >
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone style="display: none">
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector ">
            <div><i class="fa fa-file-image-o"></i> 附件</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing" style="display: none">
            <span>Processing dropped files...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals" style="display: none">
            <li>
            </li>
        </ul>
    </div>
</script>

<div id="fine-uploader-gallery" style="display: none"></div>


<script type="text/html" id="list_tpl">
    {{#issues}}

    <tr class="tree-item" data-id="{{id}}">

        <td class="width_4">
            #{{id}}
        </td>

        <td class="width_6">
            {{issue_type_html issue_type}}
        </td>
        <td class="width_4">
            {{priority_html priority }}
        </td>
        <td class="width_3_6">
            {{module_html module}}
        </td>
        <td class="show-tooltip width_35">
            <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}" class="commit-row-message">
                {{summary}}
            </a>

            {{#if_eq have_children '0'}}
            {{^}}
            <a href="#" style="color:#f0ad4e" data-issue_id="{{id}}"
               class="have_children prepend-left-5 has-tooltip"
               data-original-title="该任务拥有{{have_children}}项子任务"
            >
                子任务 <span class="badge">{{have_children}}</span>
            </a>
            {{/if_eq}}

        </td>
        <td class="width_6">
            {{user_html assignee}}
        </td>
        <td class="width_6">
            {{user_html reporter}}
        </td>

        <td class="width_6_1">
            {{status_html status }}
        </td>

        <td class="width_7_9">
            {{resolve_html resolve}}
        </td>
        <td class="created_text width_7_2">{{created_text}}
        </td>
        <td class="updated_text width_7_2">{{updated_text}}
        </td>
        <td class="pipeline-actions width_4">
            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                <div class="js-notification-toggle-btns">
                    <div class="">
                        <a class="dropdown-new  notifications-btn "
                           style="color: #8b8f94;" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown"
                           id="notifications-button"
                           type="button" aria-expanded="false">
                            ...
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown dropdown-menu dropdown-menu-no-wrap dropdown-menu-selectable"
                            style="left:-120px;width:160px;min-width:140px; ">

                            <li class="aui-list-item active">
                                <a href="#modal-edit-issue" class="issue_edit_href" data-issue_id="{{id}}">
                                    编辑
                                </a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="issue_copy_href" data-issue_id="{{id}}" data-issuekey="IP-524">复制</a>
                            </li>
                            {{#if_eq sprint '0' }}
                            <li class="aui-list-item">
                                <a href="#" class="issue_sprint_href" data-issue_id="{{id}}" data-issuekey="IP-524">Sprint</a>
                            </li>
                            {{else}}
                            <li class="aui-list-item ">
                                <a href="#" class="issue_backlog_href" data-issue_id="{{id}}" data-issuekey="IP-524">Backlog</a>
                            </li>
                            {{/if_eq}}
                            {{#if_eq master_id '0' }}
                            <li class="aui-list-item">
                                <a href="#" class="issue_convert_child_href" data-issue_id="{{id}}"
                                   data-issuekey="IP-524">转换为子任务</a>
                            </li>
                            {{/if_eq}}

                            <li class="aui-list-item">
                                <a href="#" class="issue_delete_href" data-issue_id="{{id}}"
                                   data-issuekey="IP-524">删除</a>
                            </li>
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


<script type="text/html" id="main_children_list_tpl">
    {{#children}}
        <li class="commits-stat">
            {{user_html assignee}}
            <a href="<?= ROOT_URL ?>issue/detail/index/{{id}}" target="_blank" style="margin-left:5px;top: 3px;">#{{id}} {{summary}}
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
        <div id="create_ui_config_{{id}}" style="min-height: 200px">
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
        <div class="dd-list" id="create_ui_config-{{id}}" style="min-height: 200px">

        </div>
    </div>
</script>

<script type="text/html" id="fav_filter_first_tpl">
    <li class="fav_filter_li">
        <a id="state-opened" title="清除该过滤条件" href="javascript:$IssueMain.updateFavFilter('0');"><span>所有事项</span> <span
                    class="badge">0</span>
        </a>
    </li>
    {{#first_filters}}
    <li class="fav_filter_li">
        <a id="state-opened" title="{{description}}" href="javascript:$IssueMain.updateFavFilter({{id}});"><span>{{name}}</span>
            <span class="badge">0</span>
        </a>
    </li>
    {{/first_filters}}

</script>
<script type="text/html" id="fav_filter_hide_tpl">
    {{#hide_filters}}

    <li>
        <a class="update-notification fav_filter_a" data-notification-level="custom" data-notification-title="Custom"
           href="javascript:$IssueMain.updateFavHideFilter({{id}});" role="button">
            <strong class="dropdown-menu-inner-title">{{name}}</strong>
            <span class="dropdown-menu-inner-content">{{description}}</span>
        </a>
    </li>

    {{/hide_filters}}
</script>


<script>
    IssuableContext.prototype.PARTICIPANTS_ROW_COUNT = 7;

    gl.IssuableResource = new gl.SubbableResource('/api/v4/issue_1.json');
    new gl.IssuableTimeTracking("{\"id\":1,\"iid\":1,\"assignee_id\":15,\"author_id\":15,\"description\":\"拼写错误\",\"lock_version\":null,\"milestone_id\":null,\"position\":0,\"state\":\"closed\",\"title\":\"InWord\",\"updated_by_id\":15,\"created_at\":\"2017-10-19T10:56:27.764Z\",\"updated_at\":\"2017-10-31T08:59:27.604Z\",\"deleted_at\":null,\"time_estimate\":0,\"total_time_spent\":0,\"human_time_estimate\":null,\"human_total_time_spent\":null,\"branch_name\":null,\"confidential\":false,\"due_date\":null,\"moved_to_id\":null,\"project_id\":31,\"milestone\":null,\"labels\":[]}");
    new MilestoneSelect('{"full_path":"ismond/xphp"}');
    gl.Subscription.bindAll('.subscription');
    new IssuableContext('{\"id\":<?=$user['uid']?>,\"name\":\"<?=$user['display_name']?>\",\"username\":\"<?=$user['username']?>\"}');
    window.sidebar = new Sidebar();
</script>

<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>

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

    var _simplemde = {};

    var _fineUploaderFile = {};
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';
    var _cur_uid = null;
    var _editor_md = null;
    var _description_templates = <?=json_encode($description_templates)?>;

    var $IssueMain = null;
    var $IssueDetail = null;
    var query_str = '<?=$query_str?>';
    var urls = parseURL(window.location.href);

    var qtipApi = null;

    var _fineUploader = null;

    var subtack = [];
    var isFloatPart = false;

    new UsersSelect();

    _editor_md = editormd("editor_md", {
        width: "100%",
        height: 240,
        markdown: "",
        path: '<?=ROOT_URL?>dev/lib/editor.md/lib/',
        imageUpload: true,
        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
        imageUploadURL: "<?=ROOT_URL?>issue/detail/editormd_upload",
        tocm: true,    // Using [TOCM]
        emoji: true,
        saveHTMLToTextarea: true
    });

    $(function () {
        getFineUploader();
        // single keys
        Mousetrap.bind('c', function () {
            $('#btn-create-issue').click();
        });

        Mousetrap.bind('e', function () {
            if (_issue_id != 'undefined' && _issue_id != null && _issue_id != 0) {
                window.$IssueMain.fetchEditUiConfig(_issue_id, 'update');
            }
        });

        var options = {
            query_str: window.query_str,
            query_param_obj: urls.searchObject,
            list_render_id: "list_render_id",
            list_tpl_id: "list_tpl",
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

        $('#btn-update').bind('click', function () {
            IssueMain.prototype.update();
        });

        /*点击选择view的样式*/
        $('#view_choice').on('click', function (e) {
            $('#view_choice .active').removeClass('active');
            $('#list_render_id tr.active').removeClass('active');
            if ($(e.target).parent().attr('id') == 'view_choice') {
                $(e.target).addClass('active');
            }
            if ($(e.target).hasClass('float-part')) {
                isFloatPart = true;
                getRightPartData($('#list_render_id tr:first-child').attr('data-id'));
                $('.float-right-side').show();
                $('#helper_panel').addClass('hide');
                $('#list_render_id tr:first-child').addClass('active');
            } else {
                isFloatPart = false;
            }
        });

        //点击tips提示
        $('#showMoreTips').click(function(){
            $('#tips_panel').modal();
            $('.camper-helper').addClass('hide');
        });

        //关闭背景颜色
        $('#tips_panel').on('shown.bs.modal',function(){
            $('.modal-backdrop.in').css('opacity','0.2');
        });

        //关闭tips提示框
        $('#closeTips').click(function(){
            $('.camper-helper').addClass('hide');
        });

        //关闭tips的弹出框
        $('.close-detail-tips').click(function(){
            $('.camper-helper').removeClass('hide');
            $('#tips_panel').modal('hide');
        });

        //helper的内容
        $('#helper_panel').on('click',function(e){
           if($(e.target).parent().hasClass('close-helper')){
               $('#helper_panel').addClass('hide never');
            }else if($(e.target).hasClass('more-detail')||$(e.target).hasClass('comment-content')||$(e.target).hasClass('history-detail')){
               $('.close-helper').addClass('hide');
           }
            if($(e.target).parent().hasClass('clean-card')||$(e.target).hasClass('clean-card')||$(e.target).hasClass('fa-arrow-left')){
                $('.card').addClass('hide');
                $('.helper-content').removeClass('hide');
                $('.clean-card').addClass('hide');
                $('.close-helper').removeClass('hide');
            }
            if($(e.target).hasClass('more-detail')||$(e.target).hasClass('comment-content')||$(e.target).hasClass('history-detail')){
                $('.helper-content').addClass('hide');
                $('#helper_panel').addClass('hide');
            }

           if($(e.target).parent().hasClass('clean-card')||$(e.target).hasClass('clean-card')||$(e.target).hasClass('fa-arrow-left')){
               $('.card').addClass('hide');
               $('.helper-content').removeClass('hide');
               $('.clean-card').addClass('hide');
           }

           if($(e.target).hasClass('more-detail')||$(e.target).hasClass('comment-content')||$(e.target).hasClass('history-detail')){
               $('.helper-content').addClass('hide');
           }

            if($(e.target).hasClass('more-detail')){
               $('.card').removeClass('hide');
               $('.clean-card').removeClass('hide');
            }
            if($(e.target).hasClass('comment-content')){
                $('#contact-panel').removeClass('hide');
            }
            if($(e.target).hasClass('history-detail')){
                $('#history-content').removeClass('hide');
            }
        });
        /*todo:添加滚动事件，添加两属性值right:17px;scaleY(1)==>bg-linear(可以不做)*/

        //添加bottom的textare的focus事件
        $('.bottom-part textarea').on('focus',function(){
           $('.textarea-tips').addClass('hide');
        });

        $('.bottom-part textarea').on('blur',function(){
            $('.textarea-tips').addClass('hide');
            if(this.value==''){
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
                    getRightPartData(dataId);
                    $('.float-right-side').show();
                    $('#helper_panel').addClass('hide');
                    return false;
                }
            }else if($(e.target).parent().next().hasClass('pop_subtack hide')){
                $(e.target).parent().next().removeClass('hide');
                $(e.target).parent().addClass('active');
            }else if($(e.target).parent().next().hasClass('pop_subtack')){
                $(e.target).parent().next().addClass('hide');
                $(e.target).parent().removeClass('active');
            }
        });

        //获取详情页信息
        function getRightPartData(dataId) {
            $('.maskLayer').removeClass('hide');//可以不要，但是由于跳转的时候速度太慢，所以防止用户乱点击
            _issue_id = dataId;

            $IssueDetail = new IssueDetail({});
            $IssueDetail.fetchIssue(dataId, true);
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

        //右边悬浮层按钮事件
        $('#btn-edit').bind('click',function () {
            window.$IssueMain.fetchEditUiConfig(_issue_id, 'update');
        });

        $('#btn-copy').bind('click',function () {
            window.$IssueMain.fetchEditUiConfig(_issue_id, 'copy');
        });

        //获取上传插件
        function getFineUploader() {
            _fineUploader = new qq.FineUploader({
                element: document.getElementById('attachments_uploder'),
                template: 'qq-template-gallery',
                multiple: true,
                request: {
                    endpoint: '/issue/main/upload'
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    endpoint: "/issue/main/upload_delete"
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', '7z', 'zip', 'rar', 'bmp', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf', 'xlt', 'xltx', 'txt'],
                }
            });
        }
    });

//    window.document.body.onmouseover = function (event) {
//        _issue_id = $(event.target).closest('tr').data('id');
//    }

</script>
</body>
</html>

