<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/moment.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/issue/form.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/issue/detail.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>


    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <script src="<?=ROOT_URL?>dev/lib/simplemde/dist/simplemde.min.js"></script>
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib//simplemde/dist/simplemde.min.css">

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <style>
        .masklayer{
            z-index:1002;
            position:fixed;
            right:0;
            left:0;
            bottom:0;
            top:0;
            background: red;
        }
        body.unmask{
            overflow:hidden;
            height:971px;
        }

        #content-body .float-right-side{
            width:50%;
            height:100%;
	        position:absolute;
            top:0;
            right:0;
            background:#fff;
            box-shadow:-1px 0px 8px rgba(0,0,0,0.5), 0px -1px 4px rgba(0,0,0,0.3);
        }
        #content-body>.container-fluid{
            position:relative;
        }
    </style>

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
                                       href="<?=ROOT_URL?>issue/main?fav_filter=<?= $f['id'] ?>">
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
                                    if ( count($hideFilters) > 0 ) {

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
                                                   href="<?=ROOT_URL?>issue/main?fav_filter=<?= $f['id'] ?>" role="button">
                                                    <strong class="dropdown-menu-inner-title"><?= $f['name'] ?></strong>
                                                    <span class="dropdown-menu-inner-content"><?= $f['description'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>

                                </div>
                            </div>

                        </div>

                        <div class="nav-controls">

                            <a class="btn append-right-10 has-tooltip" title="Subscribe" href="#"><i
                                        class="fa fa-rss"></i>
                            </a>
                            <a class="btn btn-new" data-target="#modal-create-issue" data-toggle="modal"
                               id="btn-create-issue"
                               href="#modal-create-issue"><i class="fa fa-plus fa-fw"></i>
                                New issue
                            </a>

                        </div>
                    </div>
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
                                    <div class="filter-dropdown-container">
                                        <div class="dropdown inline prepend-left-10">

                                            <button class="dropdown-toggle"  id="save_filter-btn"  type="button">
                                                <i class="fa fa-filter "></i> Save Filter
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </form>

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
                                prefixId: 'issue_',
                            });
                        });
                    </script>

                    <div class="issues-holder">
                        <div class="table-holder">
                            <table class="table  tree-table" id="tree-slider">
                                <thead>

                                <tr>
                                    <th class="js-pipeline-info pipeline-info">类型</th>
                                    <th class="js-pipeline-info pipeline-info">关键字</th>
                                    <th class="js-pipeline-info pipeline-info">模块</th>
                                    <th class="js-pipeline-commit pipeline-commit">主题</th>
                                    <th class="js-pipeline-stages pipeline-info">经办人</th>
                                    <th class="js-pipeline-stages pipeline-info"><span
                                                class="js-pipeline-date pipeline-stages">报告人</span></th>
                                    <th class="js-pipeline-stages pipeline-info"><span
                                                class="js-pipeline-date pipeline-stages">优先级</span></th>
                                    <th class="js-pipeline-stages pipeline-info"><span
                                                class="js-pipeline-date pipeline-stages">状态</span></th>
                                    <th class="js-pipeline-stages pipeline-info"><span
                                                class="js-pipeline-date pipeline-stages">解决结果</span></th>
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
                        <div class="clearfix detail-page-header">
                            <div class="issuable-header" id="issuable-header">
                                <!-- <script type="text/html" id="issuable-header_tpl"> -->
                                    <a class="btn btn-default pull-right visible-xs-block gutter-toggle issuable-gutter-toggle js-sidebar-toggle" href="#">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                    <div class="issuable-meta">
                                        <strong class="identifier">Issue
                                            <a href="<?=ROOT_URL?>issue/main/{{issue.id}}" id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a></strong>
                                        由
                                        <strong>
                                            <a class="author_link  hidden-xs" href="/sven">
                                                <img id="creator_avatar" width="24" class="avatar avatar-inline s24 " alt="" src="{{issue.creator_info.avatar}}">
                                                <span id="author" class="author has-tooltip" title="@{{issue.creator_info.username}}" data-placement="top">{{issue.creator_info.display_name}}</span></a>
                                            <a class="author_link  hidden-sm hidden-md hidden-lg" href="/sven">
                                                <span class="author">@{{issue.creator_info.username}}</span></a>
                                        </strong>
                                        于
                                        <time class="js-timeago js-timeago-render" title="" >{{issue.create_time}}
                                        </time>
                                        创建
                                    </div>
                                 <!-- </script> -->
                            </div>

                            <div class="issuable-actions" id="issue-actions">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button id="btn-edit" type="button" class="btn btn-default"><i class="fa fa-edit"></i> 编辑</button>
                                    <button id="btn-copy" type="button" class="btn btn-default"><i class="fa fa-copy"></i> 复制</button>
                                    <!--<button id="btn-attachment" type="button" class="btn btn-default"><i class="fa fa-file-image-o"></i> 附件</button>-->
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            状态
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" id="allow_update_status">
                                        </ul>
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
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            管理
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">管理关注</a></li>
                                            <li ><a id="btn-move" href="#">移动</a></li>
                                            <li><a id="btn-delete" href="#">删除</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="issue_fields">
                                <h3 class="page-title">
                                    事项详情
                                </h3>
                                <hr>
                                <div class="row">
                                    <div class=" form-group col-lg-6">
                                        <div class="form-group issue-assignee">
                                            <label class="control-label col-sm-2" >类型:</label>
                                            <div class=" col-sm-10">
                                                <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2"  >解决结果:</label>
                                            <div class="col-sm-10">
                                                <span style=" color: {{issue.resolve_info.color}}" >{{issue.resolve_info.name}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-2"  >状态:</label>
                                        <div class="col-sm-10">
                                            <span class="label label-{{issue.status_info.color}} prepend-left-5">{{issue.status_info.name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-2" for="issue_label_ids">优先级:</label>
                                        <div class="col-sm-10">
                                            <span class="label " style="color:{{issue.priority_info.status_color}}">{{issue.priority_info.name}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-2" for="issue_milestone_id">影响版本:</label>
                                        <div class="col-sm-10">
                                            {{#issue.effect_version_names}}
                                            <span>{{name}}</span>&nbsp;
                                            {{/issue.effect_version_names}}
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-2" for="issue_label_ids">解决版本:</label>
                                        <div class="col-sm-10">
                                            {{#issue.fix_version_names}}
                                            <span>{{name}}</span>&nbsp;
                                            {{/issue.fix_version_names}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label col-sm-2" for="issue_milestone_id">模块:</label>
                                        <div class="col-sm-10">
                                            <span>{{issue.module_name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-2" for="issue_label_ids">标签:</label>
                                        <div class="col-sm-10">
                                            {{#issue.labels_names}}
                                            <a class="label-link" href="<?=ROOT_URL?>issue/main/?label={{name}}">
                                                <span class="label color-label has-tooltip" style="background-color: {{bg_color}}; color: {{color}}"
                                                      title="" data-container="body" data-original-title="red waring">{{title}}</span>
                                            </a>
                                            {{/issue.labels_names}}
                                        </div>
                                    </div>
                                </div>
                                <h3 class="page-title">
                                    事项详情
                                </h3>
                                <hr>
                                 <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <div class="title hide-collapsed">Assignee
                                            <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                            <a class="edit-link pull-right" href="#" style="font-size: 12px;">Edit</a></div>
                                        <div class="value hide-collapsed" style="">
                                            <a class="author_link bold " href="/<?=$issue['assignee_info']['username']?>">
                                                <img width="32" class="avatar avatar-inline s32 " alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                <span class="author "><?=$issue['assignee_info']['display_name']?></span>
                                                <span class="username">@<?=$issue['assignee_info']['username']?></span></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label col-sm-2" for="issue_label_ids">解决版本:</label>
                                        <div class="col-sm-10">
                                            {{#issue.fix_version_names}}
                                            <span>{{name}}</span>&nbsp;
                                            {{/issue.fix_version_names}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                 <div class="row">
                                    <div class="form-group col-lg-6 ">
                                        <div class="sidebar-collapsed-icon">
                                            <i aria-hidden="true" class="fa fa-clock-o"></i>
                                            <small>None</small>
                                        </div>
                                        <div class="title hide-collapsed "><span class="bold">Milestone</span>
                                            <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                            <a class="edit-link pull-right" href="#"><small>Edit</small></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="selectbox hide-collapsed">
                                            <input type="hidden" name="issue[milestone_id]" />
                                            <div class="dropdown ">
                                                <button class="dropdown-menu-toggle js-milestone-select js-extra-options"
                                                        type="button"
                                                        data-show-no="true"
                                                        data-field-name="issue[milestone_id]"
                                                        data-project-id="<?=$project_id?>"
                                                        data-issuable-id="<?=$issue_id?>"
                                                        data-milestones="/api/v4/milestones.json"
                                                        data-ability-name="issue"
                                                        data-issue-update="<?=ROOT_URL?>issue/main/patch/<?=$issue_id?>"
                                                        data-use-id="true"
                                                        data-toggle="dropdown">
                                                    <span class="dropdown-toggle-text ">Milestone</span>
                                                    <i class="fa fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-select dropdown-menu-selectable">
                                                    <div class="dropdown-title">
                                                        <span>Assign milestone</span>
                                                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                        </button>
                                                    </div>
                                                    <div class="dropdown-input">
                                                        <input type="search" id="" class="dropdown-input-field" placeholder="Search milestones" autocomplete="off" />
                                                        <i class="fa fa-search dropdown-input-search"></i>
                                                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                    </div>
                                                    <div class="dropdown-content "></div>
                                                    <div class="dropdown-loading">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class="form-group col-lg-6 ">
                                        <div class="title hide-collapsed " style="margin-top: 10px"><span class="bold">时间</span>
                                        </div>
                                        <div class="block due_date" style="border-bottom: 0px solid #e8e8e8;padding: 10px 0;">
                                            <div class="sidebar-collapsed-icon">
                                                <i aria-hidden="true" class="fa fa-calendar"></i>
                                                <span class="js-due-date-sidebar-value"><?=$issue['start_date']?></span></div>
                                            <div class="title hide-collapsed"><small  >开始时间</small>
                                                <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                                <a class="edit-link2 pull-right" href="#" style="color: rgba(0,0,0,0.85);"><small id="a_start_date_edit">Edit</small></a></div>
                                            <div class="value hide-collapsed">
                                                <span class="value-content">
                                                        <small class="no-value" id="small_start_date" ><?=$issue['start_date']?></small>

                                                </span>
                                                <span class="hidden js-remove-due-date-holder no-value">-
                                                <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 ">
                                        <div class="block due_date">
                                            <div class="sidebar-collapsed-icon">
                                                <i aria-hidden="true" class="fa fa-calendar"></i>
                                                <small class="js-due-date-sidebar-value"><?=$issue['due_date']?></small></div>
                                            <div class="title hide-collapsed"><small>截止时间</small>
                                                <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                                <a class="edit-link2 pull-right" href="#"  style="color: rgba(0,0,0,0.85);"><small id="a_due_date_edit">Edit</small></a></div>
                                            <div class="value hide-collapsed">
                                              <span class="value-content">
                                                <small class="no-value" id="small_due_date" ><?=$issue['due_date']?></small>
                                              </span>
                                                <span class="hidden js-remove-due-date-holder no-value">-
                                                    <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 ">
                                        <div class="block participants">
                                            <div class="sidebar-collapsed-icon">
                                                <i class="fa fa-users"></i>
                                                <span>1</span></div>
                                            <div class="title hide-collapsed">协助人</div>
                                            <div class="hide-collapsed participants-list" id="assistants_div">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class="form-group col-lg-6 ">
                                        <div class="block project-reference">
                                            <div class="sidebar-collapsed-icon dont-change-state">
                                                <button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="left" data-container="body" data-title="Copy reference to clipboard" data-clipboard-text="ismond/xphp#1" type="button" title="Copy reference to clipboard">
                                                    <i aria-hidden="true" class="fa fa-clipboard"></i>
                                                </button>
                                            </div>
                                            <div class="title hide-collapsed">
                                                <span class="bold">子任务</span>
                                            </div>
                                            <div id="child_issues_div" class="cross-project-reference hide-collapsed">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 ">
                                        <div class="block project-reference">
                                            <div class="sidebar-collapsed-icon dont-change-state">
                                                <button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="left" data-container="body" data-title="Copy reference to clipboard" data-clipboard-text="ismond/xphp#1" type="button" title="Copy reference to clipboard">
                                                    <i aria-hidden="true" class="fa fa-clipboard"></i>
                                                </button>
                                            </div>
                                            <div class="title hide-collapsed">
                                                <span class="bold">自定义字段</span>
                                            </div>
                                            <div id="custom_field_values_div" class="cross-project-reference hide-collapsed">

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

<?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

<script type="text/html"  id="save_filter_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="save_filter_text" placeholder="请输入过滤器名称" name="save_filter_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="save_filter_btn"   onclick="IssueMain.prototype.saveFilter($('#save_filter_text').val())"  href="#">确定</a>
        </div>
    </div>
</script>


<script type="text/html" id="list_tpl">
    {{#issues}}

    <tr class="tree-item" data-id="{{id}}">
        <td>
            {{make_issue_type issue_type ../issue_types }}
        </td>
        <td>
            {{pkey}}
        </td>
        <td>
            {{make_module module ../issue_module }}
        </td>
        <td>

            <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" class="commit-row-message">
                {{summary}}
            </a>

        </td>
        <td>
            {{make_user assignee ../users }}
        </td>
        <td>
            {{make_user reporter ../users }}
        </td>
        <td>
            {{make_priority priority ../priority }}

        </td>
        <td>
            {{make_status status ../issue_status }}
        </td>

        <td>
            {{make_resolve resolve ../issue_resolve}}
        </td>
        <td class="created_text">{{created_text}}
        </td>
        <td class="updated_text">{{updated_text}}
        </td>
        <td class="pipeline-actions">
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
                                <a   href="#modal-edit-issue" class="issue_edit_href"  data-issue_id="{{id}}">
                                    编辑
                                </a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="issue_copy_href" data-issue_id="{{id}}"  data-issuekey="IP-524">复制</a>
                            </li>
                            {{#if_eq sprint '0' }}
                                <li class="aui-list-item">
                                    <a href="#" class="issue_sprint_href" data-issue_id="{{id}}"data-issuekey="IP-524">Sprint</a>
                                </li>
                            {{else}}
                                <li class="aui-list-item ">
                                    <a href="#" class="issue_backlog_href" data-issue_id="{{id}}" data-issuekey="IP-524">Backlog</a>
                                </li>
                            {{/if_eq}}
                            {{#if_eq master_id '0' }}
                                <li class="aui-list-item">
                                    <a href="#" class="issue_convert_child_href" data-issue_id="{{id}}" data-issuekey="IP-524">转换为子任务</a>
                                </li>
                            {{/if_eq}}

                            <li class="aui-list-item">
                                <a href="#" class="issue_delete_href" data-issue_id="{{id}}" data-issuekey="IP-524">删除</a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </td>
    </tr>
    {{/issues}}

</script>


<script type="text/html"  id="wrap_field">
        <div class=" form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">{{display_name}}:{{required_html}}</div>
            <div class="col-sm-8">{field_html}</div>
            <div class="col-sm-1"></div>
        </div>

</script>


<script type="text/html"  id="li_tab_tpl">
    <div role="tabpanel"  class="tab-pane " id="{{id}}">

        <div   id="create_ui_config_{{id}}" style="min-height: 200px">

        </div>

    </div>
</script>

<script type="text/html"  id="nav_tab_li_tpl">
    <li role="presentation" class="active">
        <a id="a_{{id}}" href="#{{id}}" role="tab" data-toggle="tab">
            <span id="span_{{id}}">{{title}}&nbsp;</span>
        </a>
    </li>
</script>

<script type="text/html"  id="content_tab_tpl">
    <div role="tabpanel"  class="tab-pane " id="{{id}}">
        <div class="dd-list" id="create_ui_config-{{id}}" style="min-height: 200px">

        </div>
    </div>
</script>

<script type="text/html"  id="fav_filter_first_tpl">
    <li class="fav_filter_li">
        <a id="state-opened" title="清除该过滤条件" href="javascript:$IssueMain.updateFavFilter('0');"><span>所有事项</span> <span class="badge">0</span>
        </a>
    </li>
    {{#first_filters}}
    <li class="fav_filter_li">
        <a id="state-opened" title="{{description}}" href="javascript:$IssueMain.updateFavFilter({{id}});"><span>{{name}}</span> <span class="badge">0</span>
        </a>
    </li>
    {{/first_filters}}

</script>
<script type="text/html"  id="fav_filter_hide_tpl">

    {{#hide_filters}}
    <li>
        <a class="update-notification fav_filter_a" data-notification-level="custom" data-notification-title="Custom"  href="javascript:$IssueMain.updateFavHideFilter({{id}});" role="button">
            <strong class="dropdown-menu-inner-title">{{name}}</strong>
            <span class="dropdown-menu-inner-content">{{description}}</span>
        </a>
    </li>
    {{/hide_filters}}

</script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js"></script>
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

    var _simplemde = {};
    var _fineUploader = {};
    var _fineUploaderFile = {};
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';

    var $IssueMain = null;
    var query_str = '<?=$query_str?>';
    var urls = parseURL(window.location.href);
    console.log(urls);
    var qtipApi = null;
    new UsersSelect();
    $(function () {
        // single keys
        Mousetrap.bind('c', function() {
            console.log('c');
            $('#btn-create-issue').click();
        });

        Mousetrap.bind('e', function() {
            if(_issue_id!='undefined' && _issue_id!=null){
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

        }
        window.$IssueMain = new IssueMain(options);
        window.$IssueMain.fetchIssueMains();

        $('#btn-add').bind('click',function () {
            IssueMain.prototype.add();
        });

        $('#btn-update').bind('click',function () {
            IssueMain.prototype.update();
        });

        /*详情页的ajax*/
        /*console.log('***********');
        console.log(options);
        $('#issue_id').val(id);
         $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/issue/detail/get/" + options.list_tpl_id,
            data: {},
            success: function (resp) {

                var source = $('#issuable-header_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#issuable-header').html(result);
            }
         })*/


        $('#save_filter-btn').qtip({
            content: {
                text: $('#save_filter_tpl').html(),
                title: "新增过滤器",
                button: "关闭"
            },
            show: 'click',
            hide: 'click',
            style:{
                classes:"qtip-bootstrap",
                width:"500px"
            },
            position: {
                my: 'top left',  // Position my top left...
                at: 'bottom center', // at the bottom right of...
                target: $('.filtered-search')
            },
            events: {
                show: function( event, api ) {
                    var t=setTimeout("$('#save_filter_text').focus();",200)
                }
            }
        });
        window.qtipApi = $('#save_filter-btn').qtip('api');


    });

    window.document.body.onmouseover = function(event){
        _issue_id = $(event.target).closest('tr').data('id');
    }

</script>
<style>

    .CodeMirror, .CodeMirror-scroll {
        min-height: 100px;
        max-height: 200px;
    }
</style>

</body>
</html>

