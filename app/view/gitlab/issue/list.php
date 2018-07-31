<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

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
    <style>
        body.unmask {
            overflow: hidden;
            height: 971px;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
                right: -100%;
            }
            50% {
                opacity: 0;
                right: -50%;
            }
            100% {
                opacity: 1;
                right: 0;
            }
        }

        @-webkit-keyframes fade-in {
            0% {
                opacity: 0;
                right: -100%;
            }
            50% {
                opacity: 0;
                right: -50%;
            }
            100% {
                opacity: 1;
                right: 0;
            }
        }

        #content-body .float-right-side {
            display: none;
            width: 50%;
            position: absolute;
            top: 0;
            right: 0;
            background: #fff;
            box-shadow: -1px 0 8px rgba(0, 0, 0, 0.5), 0 -1px 4px rgba(0, 0, 0, 0.3);
            padding: 0 20px 20px;
            overflow: auto;
            height: 93.5%;
            animation-name: fade-in;
            animation-duration: 0.75s;
            min-height: 860px;
            z-index: 10;
        }
        #content-body > .container-fluid {
            position: relative;
        }

        @media (min-width: 768px) {
            #content-body .issuable-actions {
                float: unset;
            }
        }

        .float-right-side .row {
            clear: both;
            margin-left: 0;
            margin-right: 0;
        }

        .float-right-side .detail-part .row {
            margin-bottom: 16px;
            margin-top: 25px;
            padding-left: 25px;
            padding-right: 25px;
        }

        .float-right-side .content-block {
            border-bottom: unset;
        }

        .float-right-side .issuable-header {
            width: 100%;
        }

        .float-right {
            float: right;
        }

        .float-left {
            line-height: 2px;
            margin-right: 2px;
        }

        .close-float-panel {
            position: absolute;
            top: 10px;
            right: 0;
            font-size: 16px;
        }

        .font-bloder {
            font-weight: 800;
        }

        .CodeMirror.cm-s-default.CodeMirror-wrap, .CodeMirror.cm-s-default.CodeMirror-wrap.CodeMirror-empty, .CodeMirror.cm-s-default.CodeMirror-wrap, .CodeMirror.cm-s-default.CodeMirror-wrap.CodeMirror-empty.CodeMirror-focused {
            width: auto !important;
            margin-top: 106px !important;
        }

        .editormd-preview {
            width: auto !important;
            top: 106px !important;
        }

        #view_choice.dropdown-menu {
            position: absolute;
            top: 38px;
            left:123px;
            box-shadow: unset;
            border: 1px solid #e5e5e5;
            border-radius: 3px;
            padding: 0;
            z-index: 3;
            min-width: unset;
            width:162px;
        }

        #view_choice li {
            width: 100%;
            padding: 8px 40px;
            padding-left:20px;
            text-align: left;
            color: #2e2e2e;
            cursor: pointer;
            position: relative;
        }

        #view_choice li.active, #view_choice li:hover {
            background: #f6fafd;
        }

        #view_choice li.active:before {
            content: "";
            background: url("<?=ROOT_URL?>dev/img/check.png") center no-repeat;
            width: 20px;
            height: 20px;
            position: absolute;
            top: 8px;
            right:13px;
        }

        #change_view {
            box-shadow: unset;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 3px;
            color: rgba(0, 0, 0, 0.85);
            font-size: 14px;
            padding: 6px 8px 6px 10px;
        }

        #list_render_id tr.active {
            background: #ebf2f9;
        }

        .maskLayer {
            z-index: 5;
            position: fixed;
            right: 0;
            left: 0;
            bottom: 0;
            top: 0;
            background: rgba(0, 0, 0, 0.2);
        }

        .td-block {
            border-spacing: 0;
            display: table;
            table-layout: fixed;
            width: 100%;
        }

        table tbody tr.pop_subtack td {
            min-height: 100px;
            font-size: 10px;
            padding: 10px 25px;
            padding-top: 15px;
            vertical-align: top;
        }

        table tbody tr.pop_subtack td p:first-child {
            font-weight: 700;
        }

        table tbody tr.pop_subtack {
            animation-name: fade-in;
            animation-duration: 0.5s;
        }

        table tbody tr.pop_subtack p{
            margin:0 0 5px;
        }

        table tbody tr td.width_35 {
            width: 35%;
        }

        table tbody tr td.width_3_6 {
            width: 3.6%;
        }

        table tbody tr td.width_4 {
            width: 4%;
        }

        table tbody tr td.width_6 {
            width: 6%;
        }

        table tbody tr td.width_6_1 {
            width: 6.1%;
        }

        table tbody tr td.width_7 {
            width: 7%;
        }

        table tbody tr td.width_7_2 {
            width: 7.2%;
        }

        table tbody tr td.width_7_9 {
            width: 7.9%;
        }

        table tbody tr td{
            cursor:pointer;
        }
        .camper-helper__bubble{
            -webkit-animation:rotate in 0.3s both;
            -moz-animation:rotate in 0.3s both;
            animation:rotate-in 0.3s both;
            -webkit-animation-delay:2s;
            -moz-animation-delay:1.33s;
            animation-delay:2s;
            position:absolute;
            top:0;
            right:0;
            bottom:0;
            left:0;
            background:#1AAA6B;
            color:#fff;
            box-shadow:0 1px 3px rgba(0,0,0,0.25);
            border-radius:100%;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:antialiased;
        }

        .camper-helper__bubble:after{
            -webkit-transform:rotate(12deg);
            -moz-transform:rotate(12deg);
            -ms-transform:rotate(12deg);
            transform:rotate(12deg);
            content:'';
            position:absolute;
            bottom:-2.25em;
            left:50%;
            margin-left:-1.5rem;
            width:0;
            height:0;
            border:1.6rem solid #1AAA6B;
            border-right-color:rgba(255,255,255,0);
            border-bottom-color:rgba(255,255,255,0);
            z-index:6;
        }

        .camper-helper_bubble-content{
            position:absolute;
            top:2em;
            right:1.5rem;
            bottom:1.5rem;
            left:1.5rem;
            -webkit-justify-content:center;
            -moz-justify-content:center;
            justify-content:center;
            -webkit-flex-direction:column;
            -moz-flex-direction:column;
            -ms-flex-direction:column;
            flex-direction:column;
            -webkit-box-orient:vertical;
            -moz-box-orient:vertical;
            -webkit-box-orient:vertical;
            box-orient:vertical;
        }
        .camper-helper{
            transition:all 0.3s ease;
            position:fixed;
            left:-1rem;
            width:15rem;
            height:0;
            padding:15rem 0 0;
            z-index:9;
            bottom:7rem;
        }
        .camper-helper__nerd{
            position:absolute;;
            top:105%;
            left:17%;
        }
        .camper-helper__buttons{
            padding:0.5em 1rem 0;
        }
        .flush--bottom{
            margin-bottom:0;
        }
        .push_half--top{
            margin-top:0.625em;
            color:#fff;
        }
        .camper-helper h5{
            font-size:1.5rem;
        }
        .btn--full-width{
           display: block;
            width:100%;
            padding:4px 10px;
        }
        .btn--reversed{
            background: #fff;
            border-color:rgba(255,255,255,0);
            color:#283c46;
        }
        .btn{
           /* border-radius:1.5em;*/
            vertical-align: middle;
            text-decoration: none;
            text-align: center;
            white-space: normal;
            cursor:pointer;
        }
        .camper-helper__buttons>a{
            margin-top:0.7rem;
        }
        .camper-helper__buttons>.btn:hover, .camper-helper__buttons>.btn:focus{
            background: inherit;
            border-color:inherit;
            color:inherit;
        }
        .camper-helper__buttons>.btn:first-child:hover{
            background: #fff;
            color:black;
        }
        .btn--semi-transparent{
            background:rgba(0,0,0,0.15);
            border-color:rgba(255,255,255,0);
            color:#fff;
        }
        .small-tips{
            background: #F9F7E8;
            padding:10px 60px;
        }
        .block-bg{
            background: #1AAA6B;
            padding:10px 20px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        #tips_panel .card{
            padding:0;
        }
        #tips_panel h4{
            color:#fff;
        }
        #tips_panel .card-body{
            padding:10px 20px 20px;
            min-height:800px;
        }
        .tips_arrow_bottom{
            position:absolute;
            top:60px;
            left:10%;
        }
        #tips_panel .modal-dialog{
            margin-top:50px;
        }
        .close-detail-tips{
            background:rgba(0,0,0,0.15);
            float:right;
            margin-top:-38px;
            color:#fff;
            border-color:transparent;
        }
        #helper_panel{
            position:fixed;
            bottom:0;
            border:1px solid #E5E5E5;
            right:18px;
            border-radius:4px;
            justify-content: flex-start;
            box-shadow: 2px -1px 20px 2px #E5E5E5;
            min-height:200px;
            width:300px;
            max-height:600px;
            background:#FAFAFA ;
            animation-name: fade-in;
            animation-duration: 0.75s;
        }
        #helper_panel ul{
            list-style:none;
            padding-left:0;
            margin-bottom:0;
            font-size:12px;
            font-weight:600;
            color:#56A9DD;
        }
        #helper_panel .extra-help ul{
            border:unset;
        }
        #helper_panel hr{
            border-bottom:1px solid rgb(238, 238, 238);
            border-top:unset;
        }
        #helper_panel ul:first-child li:last-child{
            margin-bottom:unset;
        }
        #helper_panel ul li{
            margin-bottom:10px;
            cursor:pointer;
        }
        #helper_panel .close-helper{
            background: #979DA1;
            border-radius:15px;
            width:60px;
            height:22px;
            position:absolute;
            top:-26px;
            right:0;
            font-weight: 700;
            color:#fff;
            cursor:pointer;
        }
        #helper_panel .close-helper span:first-child{
            padding-left:5px;
        }
        #helper_panel .panel{
            background: transparent;
            letter-spacing: 1px;
        }
        #helper_panel .panel-title p{
            margin:0;
            padding-top:10px;
            font-size:14px;
        }
        #helper_panel .panel .panel-body,#helper_panel .panel-title{
            padding:10px 28px;
            letter-spacing:2px;
        }
        #helper_panel .bottom{
            width:100%;
            background: #fff;
            padding:10px 20px;
            color:#CDD5DC;
        }
        #helper_panel li .fa{
            font-size: 15px;
            color:#c1cbd4;
            margin-right:5px;
        }
        #helper_panel input{
            border:unset;
            padding:10px;
            width:88%;
            outline:none;
            color:black;
        }
        #helper_panel input::-webkit-input-placeholder{
            color:#CDD5DC;
        }
        #helper_panel #detail_content{
            overflow-y: auto;
            max-height:600px;
            padding:20px;
            overflow-x: hidden;
            border-radius:5px;
            position:relative;
        }
        #helper_panel .bg-linear{
            transform:scaleY(0);
            background: linear-gradient(180deg,currentColor,hsla(0,0%,100%,0));
            transform-origin: top;
            top:0;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            height:28px;
            position:absolute;
            left:0;
            right:0;
            z-index:1;
            box-sizing: border-box;
            color:white;
        }
        #helper_panel .detail{
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        #helper_panel .img-content{
            width:calc(100% + 28px + 0px);
            margin:15px -13px;
            position:relative;
        }
        #helper_panel .img-content img{
            width:calc(100% + 0px + 0px);
            padding:5px;
            border:1px solid #ddd;
            border-radius:5px;
        }
        #helper_panel h3{
            margin:20px 0;
            color:#56A9DD;
        }
        #helper_panel h4{
            margin:10px 0 20px;
        }
        #helper_panel .fragment{
            margin:10px 0;
        }
        #helper_panel .catalog-link ul{
            list-style: disc;
            list-style-position:inside;
            color:#1B69B6;
            margin:15px 0;
        }
        #helper_panel .catalog-link ul li a{
            color:#56A9DD;
        }
        #helper_panel .clean-card{
            position: absolute;
            top:5px;
            right:17px;
            font-size:22px;
            color:red;
            z-index:1;
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
                        <div class="issuable-actions" id="issue-actions">
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
                                        <li><a id="btn-move" href="#">移动</a></li>
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
                            <div class="detail-part">
                                    <span class="float-left font-bloder">
                                    代理人信息
                                    </span>
                                <hr>
                                <div class="row">
                                    <div class="assignee-panel">
                                        <a class="userInfo-head img-link" href="">
                                            <img src="../dev/img/test-float-panel.png" class="user-picture"/>
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
                                                        <a class="author_link" href="/<?= $user['username'] ?>">
                                                            <img alt="@<?= $user['username'] ?>" class="avatar s40"
                                                                 src="<?= $user['avatar'] ?>"/></a>
                                                    </div>

                                                    <div class="timeline-content timeline-content-form">
                                                        <form data-type="json"
                                                              class="new-note js-quick-submit common-note-form gfm-form js-main-target-form"
                                                              enctype="multipart/form-data"
                                                              action="<?= ROOT_URL ?>issue/main/comment"
                                                              accept-charset="UTF-8" data-remote="true" method="post"
                                                              style="display: block;">
                                                            <input name="utf8" type="hidden" value="✓">
                                                            <input type="hidden" name="authenticity_token"
                                                                   value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                                                            <input type="hidden" name="view" id="view" value="inline">

                                                            <div id="editor_md">
                                                                <textarea style="display:none;"></textarea>
                                                            </div>

                                                            <div class="note-form-actions clearfix">
                                                                <input id="btn-comment"
                                                                       class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button"
                                                                       type="button" value="Comment">

                                                                <a id="btn-comment-reopen"
                                                                   class="btn btn-nr btn-reopen btn-comment js-note-target-reopen "
                                                                   title="Reopen issue" href="#">Reopen issue</a>
                                                                <a data-no-turbolink="true"
                                                                   data-original-text="Close issue"
                                                                   data-alternative-text="Comment &amp; close issue"
                                                                   class="btn btn-nr btn-close btn-comment js-note-target-close hidden"
                                                                   title="Close issue"
                                                                   href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close
                                                                    issue</a>
                                                                <a class="btn btn-cancel js-note-discard"
                                                                   data-cancel-text="Cancel" role="button">Discard
                                                                    draft</a>
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
                    <div class="camper-helper center hide ">
                        <div class="camper-helper__bubble">
                            <div class="camper-helper_bubble-content">
                                <h5 class="push_half--top flush--bottom">
                                    Hello! If you need help,I can help you ~
                                </h5>
                                <div class="camper-helper__buttons">
                                    <a id="showMoreTips" class="btn btn--reversed btn--full-width push_half--bottom">Yes, let’s star!</a><!--todo:需要添加动画效果-->
                                    <a id="closeTips" class="btn btn--full-width btn--semi-transparent" data-behavior="dismiss_camper_helper">No thanks</a>
                                </div>
                            </div>
                        </div>
                        <img src="<?=ROOT_URL?>dev/img/smile.png" class="camper-helper__nerd img--sized" alt="">

                    </div>
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

    <div id="helper_panel" class="hide">
        <div class="close-helper">
            <span class="text">close</span>
            <span><i class="fa fa-times"></i></span><!--class="bg-times"-->
        </div>
        <div class="bg-linear"></div>
        <div class="helper-content hide">
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
        <div class="clean-card">
            <i class="fa fa-times-circle fa-fw"></i>
        </div>
        <div class="card" id="detail_content"><!--详细内容-->
            <div class="detail">
                <h4>这是一个标题</h4>
                <div class="fragment">欢迎光临参加本次主题</div>
                <div class="fragment">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Est explicabo ipsam non numquam pariatur perferendis possimus ratione veniam.
                    Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                    voluptas voluptatem.
                </div>
                <div class="fragment">
                    <h3>blue title</h3>
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
                    Est explicabo ipsam non numquam pariatur perferendis possimus ratione veniam.
                    Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                    voluptas voluptatem.
                </div>
                <div class="fragment-notice"><!--虚线框，背景色-->

                </div>
                <div class="catalog-link">
                    <ul>
                        <li><a href="">click me</a></li>
                        <li><a href="">click me</a></li>
                        <li><a href="">click me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card hide" id="contact-panel"><!--对话框-->

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


<script type="text/html" id="list_tpl">
    {{#issues}}

    <tr class="tree-item" data-id="{{id}}">
        <td class="width_6">
            {{issue_type_html issue_type}}
        </td>
        <td class="width_4">
            #{{id}}
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
            <a href="#" style="color:#f0ad4e" data-issue_id="{{id}}" class="have_children prepend-left-5">
                父任务 <span class="badge">{{have_children}}</span>
            </a>
            {{/if_eq}}

        </td>
        <td class="width_6">
            {{user_html assignee}}
        </td>
        <td class="width_6">
            {{user_html reporter}}
        </td>
        <td class="width_7">
            {{priority_html priority }}
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
    {{#if_eq master_id '0'}}

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
        // single keys
        Mousetrap.bind('c', function () {
            console.log('c');
            $('#btn-create-issue').click();
        });

        Mousetrap.bind('e', function () {
            if (_issue_id != 'undefined' && _issue_id != null) {
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
                $('#list_render_id tr:first-child').addClass('active');
            } else {
                isFloatPart = false;
            }
        });

        //自定义的子任务模版
        /*Handlebars.registerHelper('show_tr', function (data, options) {
            if (data > 0) {
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });*/

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
            console.log($(e.target));
           if($(e.target).parent().hasClass('close-helper')){
               console.log('hello~~~');
               $('#helper_panel').addClass('hide');
           }
        });
        /*todo:添加滚动事件，添加两属性值right:17px;scaleY(1)==>bg-linear*/

        //左侧菜单的内容
        $('#list_render_id').on('click', function (e) {
            $('#list_render_id tr.active').removeClass('active');
            if ($(e.target).attr('href') && $(e.target).parent().hasClass('show-tooltip')) {
                var dataId = $(e.target).parent().parent().attr('data-id');
                $(e.target).parent().parent().addClass('active');
                getRightPartData(dataId);
                if (isFloatPart) {
                    $('.float-right-side').show();
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


    });

    window.document.body.onmouseover = function (event) {
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

