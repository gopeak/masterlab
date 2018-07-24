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
        window.description_templates = <?=json_encode($description_templates)?>;
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
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/editor.md/css/editormd.css" />
    <script src="<?=ROOT_URL?>dev/lib/editor.md/editormd.js"></script>
    <style>
        body.unmask{
            overflow:hidden;
            height:971px;
        }

        @keyframes fade-in{
            0% {
                opacity:0;
                right:-100%;
            }
            50% {
                opacity:0;
                right:-50%;
            }
            100% {
                opacity:1;
                right:0;
            }
        }
        @-webkit-keyframes fade-in {
            0% {
                opacity:0;
                right:-100%;
            }
            50% {
                opacity:0;
                right:-50%;
            }
            100% {
                opacity:1;
                right:0;
            }
        }


        #content-body .float-right-side{
            display:none;
            width:50%;
	        position:absolute;
            top:0;
            right:0;
            background:#fff;
            box-shadow:-1px 0 8px rgba(0,0,0,0.5), 0 -1px 4px rgba(0,0,0,0.3);
            padding:0 20px 20px;
            overflow:auto;
            height:93.5%;
            animation-name:fade-in;
            animation-duration:0.75s;
            min-height:860px;
            z-index:10;
        }
        #content-body>.container-fluid{
            position:relative;
        }
        @media(min-width:768px){
            #content-body .issuable-actions{
                float:unset;
            }
        }
        .float-right-side .row{
            clear:both;
            margin-left:0;
            margin-right:0;
        }
        .float-right-side .detail-part .row{
            margin-bottom:16px;
            margin-top:25px;
            padding-left:25px;
            padding-right:25px;
        }
        .float-right-side .content-block{
            border-bottom:unset;
        }
        .float-right-side .issuable-header{
            width:100%;
        }
        .float-right{
            float:right;
        }
        .float-left{
            line-height:2px;
            margin-right:2px;
        }
        .close-float-panel{
            position:absolute;
            top:10px;
            right:0;
            font-size:16px;
        }
        .font-bloder{
            font-weight:800;
        }
        .CodeMirror.cm-s-default.CodeMirror-wrap,.CodeMirror.cm-s-default.CodeMirror-wrap.CodeMirror-empty,.CodeMirror.cm-s-default.CodeMirror-wrap,.CodeMirror.cm-s-default.CodeMirror-wrap.CodeMirror-empty.CodeMirror-focused{
            width:auto !important;
            margin-top:106px !important;
        }
        .editormd-preview{
            width:auto !important;
            top:106px !important;
        }
        #view_choice.dropdown-menu{
            position:absolute;
            top:38px;
            right:0;
            box-shadow:unset;
            border:1px solid #e5e5e5;
            border-radius:3px;
            padding:0;
            z-index:3;
            min-width:unset;
        }
        #view_choice li{
            width:100%;
            padding:8px 40px;
            text-align: left;
            color:#2e2e2e;
            cursor:pointer;
            position:relative;
        }
        #view_choice li.active,#view_choice li:hover{
            background:#f6fafd;
        }
        #view_choice li.active:before{
            content:"";
            background:url("<?=ROOT_URL?>dev/img/check.png") center no-repeat;
            width:20px;
            height:20px;
            position:absolute;
            top:8px;
            left:10px;
        }
        #change_view{
            box-shadow: unset;
            background: #fff;
            border:1px solid #e5e5e5;
            border-radius:3px;
            color:rgba(0,0,0,0.85);
            font-size:14px;
            padding:6px 8px 6px 10px;
        }
        #list_render_id tr.active{
            background:#ebf2f9;
        }
        .maskLayer{
            z-index:5;
            position:fixed;
            right:0;
            left:0;
            bottom:0;
            top:0;
            background: rgba(0,0,0,0.2);
        }
        .td-block{
            border-spacing:0;
            display:table;
            table-layout:fixed;
            width:100%;
        }
        table tbody tr.pop_subtack td{
            min-height:100px;
            font-size:10px;
            padding:10px 25px;
            padding-top:15px;
            vertical-align: top;
        }
        table tbody tr.pop_subtack td p:first-child{
            font-weight:700;
        }

        table tbody tr.pop_subtack{
            animation-name:fade-in;
            animation-duration:0.75s;
        }
        table tbody tr td.width_35{
            width:35%;
        }
        table tbody tr td.width_3_6{
            width:3.6%;
        }
        table tbody tr td.width_4{
            width:4%;
        }
        table tbody tr td.width_6{
            width:6%;
        }
        table tbody tr td.width_6_1{
            width:6.1%;
        }
        table tbody tr td.width_7{
            width:7%;
        }
        table tbody tr td.width_7_2{
            width:7.2%;
        }
        table tbody tr td.width_7_9{
            width:7.9%;
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
                                                <span class="float-right"></span>
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
                                            <button id="change_view" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更改视图</button><!-- aria-haspopup="true" aria-expanded="false"-->
                                            <ul class="dropdown-menu"  aria-labelledby="dropdownMenuButton" id="view_choice">
                                                <li class="normal" data-stopPropagation="true">列表视图</li>
                                                <li class="float-part" data-stopPropagation="true">详细视图</li>
                                            </ul>
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
                        <div class="issuable-header" id="issuable-header">

                        </div>
                        <script type="text/html" id="issuable-header_tpl">
                            <h3 class="page-title">
                                Issue<a href="<?=ROOT_URL?>issue/main/{{issue.id}}" id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a></strong>
                            </h3>
                            <div class="issuable-meta">
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
                            <span class="close-float-panel float-right">
                                    <i class="fa fa-times"></i>
                                </span>
                        </script>
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
                            <div class="issue-detail">
                                <span class="float-left font-bloder">
                                    事项详情
                                </span>
                                <hr>
                                <div id="issue_fields">

                                </div>
                                <script type="text/html" id="issue_fields_tpl">
                                    <div class="row">
                                        <div class=" form-group col-lg-6">
                                            <div class="form-group issue-assignee">
                                                <label class="control-label col-sm-3" >类型:</label>
                                                <div class=" col-sm-9">
                                                    <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3"  >解决结果:</label>
                                                <div class="col-sm-9">
                                                    <span style=" color: {{issue.resolve_info.color}}" >{{issue.resolve_info.name}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 ">
                                            <label class="control-label col-sm-3"  >状态:</label>
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
                                                <a class="label-link" href="<?=ROOT_URL?>issue/main/?label={{name}}">
                                                    <span class="label color-label has-tooltip" style="background-color: {{bg_color}}; color: {{color}}"
                                                          title="" data-container="body" data-original-title="red waring">{{title}}</span>
                                                </a>
                                                {{/issue.labels_names}}
                                            </div>
                                        </div>
                                    </div>
                                </script>
                               <div class="detail-part">
                                    <span class="float-left font-bloder">
                                    代理人信息
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="assignee-panel">
                                           <a class="userInfo-head img-link" href="">
                                               <img src="../dev/img/test-float-panel.png" class="user-picture" />
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>

                                    <span class="float-left font-bloder">
                                        里程
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="milestone-panel">
                                           <a class="text-link" href="">
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>

                                    <span class="float-left font-bloder">
                                        时间
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="time-panel">
                                           <a class="text-link" href="">
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>

                                    <span class="float-left font-bloder">
                                        协助人
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="assistant-panel">
                                           <a class="text-link" href="">
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>

                                    <span class="float-left font-bloder">
                                        子任务
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="task-panel">
                                           <a class="text-link" href="">
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>

                                    <span class="float-left font-bloder">
                                        自定义字段
                                    </span>
                                   <hr>
                                   <div class="row">
                                       <div class="field-panel">
                                           <a class="text-link" href="">
                                               <span class="author">123456</span>
                                           </a>
                                           <span class="float-right">编辑</span>
                                       </div>
                                   </div>
                               </div>

                                <span class="float-left font-bloder">
                                    评论
                                </span>
                                <hr>
                                <div class="row">
                                     <div class="issue-details issuable-details">
                                        <!--<div id="detail-page-description" class="content-block detail-page-description">
                                            <div class="issue-title-data hidden" data-endpoint="#" data-initial-title="{{issue.summary}}"></div>
                                            <script type="text/html" id="detail-page-description_tpl">
                                                <div class="issue-title-data hidden" data-endpoint="/" data-initial-title="{{issue.summary}}"></div>
                                                <h2 class="title">{{issue.summary}}</h2>
                                                <div class="description js-task-list-container is-task-list-enabled">
                                                    <div class="wiki">
                                                        <p dir="auto">{{issue.description}}</p></div>
                                                    <textarea class="hidden js-task-list-field">{{issue.description}}</textarea>
                                                </div>

                                                <small class="edited-text"><span>最后修改于 </span>
                                                    <time class="js-timeago issue_edited_ago js-timeago-render" title=""
                                                          datetime="{{issue.updated_text}}" data-toggle="tooltip"
                                                          data-placement="bottom" data-container="body" data-original-title="{{issue.updated}}">{{issue.updated_text}}</time>
                                                </small>
                                            </script>
                                        </div>-->
                                        <section class="issuable-discussion">
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

                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="maskLayer hide"></div>

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
<<<<<<< HEAD
        <td class="width_6">
            {{make_issue_type issue_type ../issue_types }}
=======
        <td>
            {{issue_type_html issue_type}}
>>>>>>> 48700be95e5a138763651c16fd2f598fbc651843
        </td>
        <td class="width_4">
            {{pkey}}
        </td>
<<<<<<< HEAD
        <td class="width_3_6">
            {{make_module module ../issue_module }}
=======
        <td>
            {{module_html module}}
>>>>>>> 48700be95e5a138763651c16fd2f598fbc651843
        </td>
        <td class="show-tooltip width_35">

            <a href="<?=ROOT_URL?>issue/detail/index/{{id}}" class="commit-row-message">
                {{summary}}
            </a>

        </td>
<<<<<<< HEAD
        <td class="width_6">
            {{make_user assignee ../users }}
        </td>
        <td class="width_6">
            {{make_user reporter ../users }}
        </td>
        <td class="width_7">
            {{make_priority priority ../priority }}

        </td>
        <td class="width_6_1">
            {{make_status status ../issue_status }}
        </td>

        <td class="width_7_9">
            {{make_resolve resolve ../issue_resolve}}
=======
        <td>
            {{user_html assignee}}
        </td>
        <td>
            {{user_html reporter}}
        </td>
        <td>
            {{priority_html priority }}

        </td>
        <td>
            {{status_html status }}
        </td>

        <td>
            {{resolve_html resolve}}
>>>>>>> 48700be95e5a138763651c16fd2f598fbc651843
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
    
    <!--新增一个tr当他们点击子【更多子任务】的时候-->
    {{#show_tr master_id}}
        <tr class='pop_subtack'>
            <td colspan="12">
                <div class="td-block">
                    <p>
                        <span>#子任务</span>
                    </p>
                    <p>
                        <span>编号：</span>
                        <span>XXXx</span>
                    </p>
                </div>
            </td>
        </tr>
    {{/show_tr}}
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
                                <textarea  id="timeline-textarea_{{id}}" name="content" class="hidden js-task-list-field original-task-list"  >{{content}}</textarea>
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

<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js"></script>
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
    var _fineUploader = {};
    var _fineUploaderFile = {};
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';
    var _editor_md = null;
    var _description_templates = <?=json_encode($description_templates)?>;

    var $IssueMain = null;
    var query_str = '<?=$query_str?>';
    var urls = parseURL(window.location.href);
    console.log(urls);
    var qtipApi = null;

    var subtack = [];
    var isFloatPart=false;

    new UsersSelect();

    _editor_md = editormd("editor_md", {
        width: "100%",
        height: 240,
        markdown : "",
        path : '<?=ROOT_URL?>dev/lib/editor.md/lib/',
        imageUpload : true,
        imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
        imageUploadURL : "<?=ROOT_URL?>issue/detail/editormd_upload",
        tocm            : true,    // Using [TOCM]
        emoji           : true,
        saveHTMLToTextarea:true

    });

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
        };

        function getdata(res){
            for(var i in res.issues){
                if(res.issues[i]['master_id']&&res.issues[i]['master_id']>0){
                    subtack.push(res.issues[i]);
                }
            }
        }

        window.$IssueMain = new IssueMain(options);
        window.$IssueMain.fetchIssueMains(getdata);
        
        $('#btn-add').bind('click',function () {
            IssueMain.prototype.add();
        });

        $('#btn-update').bind('click',function () {
            IssueMain.prototype.update();
        });

        /*点击选择view的样式*/
        $('#view_choice').on('click',function(e){
            $('#view_choice .active').removeClass('active');
            $('#list_render_id tr.active').removeClass('active');
            if($(e.target).parent().attr('id')=='view_choice'){
                $(e.target).addClass('active');
            }
            if($(e.target).hasClass('float-part')){
                isFloatPart=true;
                getRightPartData($('#list_render_id tr:first-child').attr('data-id'));
                $('.float-right-side').show();
                $('#list_render_id tr:first-child').addClass('active');
            }else{
                isFloatPart=false;
            }
        });

        //todo:解决bug关于下拉点击收起

        //todo:自定义helper
        Handlebars.registerHelper('show_tr', function(data, options) {
            if(data>0){
                return options.fn(this);
            }else{
                return options.inverse(this);
            }
        });


        //左侧菜单的内容
        $('#list_render_id').on('click',function(e){
            $('#list_render_id tr.active').removeClass('active');
            if($(e.target).attr('href')&&$(e.target).parent().hasClass('show-tooltip')){
                var dataId = $(e.target).parent().parent().attr('data-id');
                $(e.target).parent().parent().addClass('active');
                getRightPartData(dataId);
                if(isFloatPart){
                    $('.float-right-side').show();
                    return false;
                }
            }
        });

        //
        /*$('#list_render_id').on('mouseenter',function(e){//这个要换成点击
            if($(e.target).hasClass('show-tooltip')){
                setTimeout(function(){
                },300);
            }
        });*/

        //获取详情页信息
        function getRightPartData(dataId){
            $('.maskLayer').removeClass('hide');//可以不要，但是由于跳转的时候速度太慢，所以防止用户乱点击
            $.ajax({
                type: 'get',
                dataType: "json",
                async: true,
                url: "/issue/detail/get/" + dataId,
                data: {},
                success: function (resp) {
                    var source = $('#issuable-header_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#issuable-header').html(result);

                    var source = $('#issue_fields_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#issue_fields').html(result);
                }
            });
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

