<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link href="<?= ROOT_URL ?>/gitlab/assets/application.css">
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
            font-size: 1em;
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
                <div class="container-fluid">
                    <div class="nav-block activity-filter-block">
                        <div class="controls">
                            <a title="Subscribe" class="btn rss-btn has-tooltip" href="/ismond/b2b.atom?private_token=vyxEf937XeWRN9gDqyXk"><i class="fa fa-rss"></i>
                            </a>
                        </div>

                    </div>
                    <div class="issues-holder">
                        <div class="table-holder">
                            <div class="boards-list" id="boards-list">
                                <div class="board is-expandable">
                                    <div class="board-inner">
                                        <header class="board-header">
                                            <h3 class="board-title">
                                                <span class="board-title-text">Backlog</span>
                                                <div class="board-count-badge">
                                                    <span class="issue-count-badge-count">60</span>
                                                </div>
                                            </h3>
                                        </header>
                                        <div class="board-list-component">
                                            <ul class="board-list">
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li draggable="false" class="card board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="board is-draggable">
                                    <div class="board-inner">
                                        <header class="board-header has-border">
                                            <h3 class="board-title js-board-handle">
                                                <span class="board-title-text color-label">InDev</span>
                                                <div class="board-count-badge">
                                                    <span class="issue-count-badge-count">2</span>
                                                </div>
                                            </h3>
                                        </header>
                                        <div class="board-list-component">
                                            <ul class="board-list">
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="board is-draggable">
                                    <div class="board-inner">
                                        <header class="board-header has-border">
                                            <h3 class="board-title js-board-handle">
                                                <span class="board-title-text color-label">InReview</span>
                                                <div class="board-count-badge">
                                                    <span class="issue-count-badge-count">3</span>
                                                </div>
                                            </h3>
                                        </header>
                                        <div class="board-list-component">
                                            <ul class="board-list">
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="board is-expandable">
                                    <div class="board-inner">
                                        <header class="board-header">
                                            <h3 class="board-title js-board-handle">
                                                <span class="board-title-text">Closed</span>
                                                <div class="board-count-badge">
                                                    <span class="issue-count-badge-count">123</span>
                                                </div>
                                            </h3>
                                        </header>
                                        <div class="board-list-component">
                                            <ul class="board-list">
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="card is-disabled board-item">
                                                    <div>
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                <a href="#" title="#" class="js-no-trigger">Expose build performance data to Prometheus</a>
                                                                <span class="card-number">#2235</span>
                                                            </h4>
                                                            <div class="card-assignee"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">CI/CD</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">Doing</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">auto updated</button>
                                                            <button type="button" class="label color-label has-tooltip" style="background-color: rgb(255, 236, 219); color: rgb(51, 51, 51);">awaiting feedback</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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



<script src="<?= ROOT_URL ?>/dev/js/jquery.min.js"></script>
<script src="<?= ROOT_URL ?>/dev/lib/sortable/sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">
    $(function(){

        function Board(opts){
            this.el = $(opts.el)
            this.handle = opts.handle
            this.list = this.el.find('.board-list-component')
            this.init()
        }
        Board.prototype.init = function() {
            if(this.el.hasClass("close")){
                this.list.hide()
            }
            this.trigger()
        }
        Board.prototype.trigger = function(){
            const self = this
            this.el.on("click", this.handle, function(event){
                if(self.el.hasClass("close")){
                    self.el.removeClass("close")
                    self.list.show()
                }else{
                    self.el.addClass("close")
                    self.list.hide()
                }
            })
        }

        $(".is-expandable").each( function(i, el) {
            new Board({
                el: $(el),
                handle: $(el).find(".board-header")
            })
        })

        var container = document.getElementById("boards-list");
        var sort = Sortable.create(container, {
            animation: 150,
            handle: ".board-title",
            draggable: ".board",
            onUpdate: function (evt){
                var item = evt.item;
            }
        })
        var items = document.getElementsByClassName('board-list');
        [].forEach.call(items, function (el){
            Sortable.create(el, {
                group: 'item',
                animation: 150
            })
        })
    })

</script>

<script type="text/javascript">

    var $backlog = null;
    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/agile/fetch_backlog_issues/<?=$project_id?>",
            get_url:"/agile/get",
            pagination_id:"pagination"
        }
        window.$backlog = new Backlog( options );
        //window.$backlog.fetchAll( );
    });

</script>

</body>
</html>
