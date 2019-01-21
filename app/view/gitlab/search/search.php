<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <style>
        .breadcrumbs-sub-title {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #2e2e2e;
            font-weight: 600;
        }
        .breadcrumbs {
            display: -webkit-flex;
            display: flex;
            min-height: 48px;
            color: #2e2e2e;
        }
        .breadcrumbs-container {
            display: -webkit-flex;
            display: flex;
            width: 100%;
            position: relative;
            padding-top: 8px;
            padding-bottom: 8px;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
        }
        .float-right{
            float: right;
        }
    </style>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <nav class="breadcrumbs container-fluid container-limited" role="navigation">
                <div class="breadcrumbs-container">
                    <div class="breadcrumbs-links js-title-container">
                        <ul class="list-unstyled breadcrumbs-list js-breadcrumbs-list">

                            <li>
                                <h2 class="breadcrumbs-sub-title"><a href="/search">搜索结果:</a></h2>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid container-limited ">
            <div class="content" id="content-body">
                <div class="prepend-top-default">
                    <form class="js-search-form" action="/search" accept-charset="UTF-8" method="get">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="scope" id="scope" value="<?=$scope?>">
                        <div class="search-holder">
                            <div class="search-field-holder">
                                <input type="search" name="keyword" id="dashboard_search" value="<?=$keyword?>" placeholder="搜索事项或项目名称" class="form-control search-text-input js-search-input" autofocus="autofocus" spellcheck="false">
                                <i aria-hidden="true" data-hidden="true" class="fa fa-search search-icon"></i>
                                <button class="js-search-clear search-clear" tabindex="-1" type="button">
                                    <i aria-hidden="true" data-hidden="true" class="fa fa-times-circle"></i>
                                    <span class="sr-only">Clear search</span>
                                </button>
                            </div>
                            <!--<div class="dropdown project-filter">
                                <button class="dropdown-menu-toggle js-search-project-dropdown" data-default-label="Project:" data-toggle="dropdown" type="button">
                                    <span class="dropdown-toggle-text">Project:Any</span>
                                    <i aria-hidden="true" data-hidden="true" class="fa fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-select dropdown-menu-selectable dropdown-menu-right">
                                    <div class="dropdown-title"><span>Filter results by project</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i aria-hidden="true" data-hidden="true" class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                    <div class="dropdown-input"><input type="search" id="" class="dropdown-input-field" placeholder="Search projects" autocomplete="off"><i aria-hidden="true" data-hidden="true" class="fa fa-search dropdown-input-search"></i><i role="button" aria-hidden="true" data-hidden="true" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i></div>
                                    <div class="dropdown-content"></div>
                                    <div class="dropdown-loading"><i aria-hidden="true" data-hidden="true" class="fa fa-spinner fa-spin"></i></div>
                                </div>
                            </div>-->

                            <button name="button" type="submit" class="btn btn-success btn-search">搜 索</button>
                        </div>
                    </form>
                </div>
                <div class="scrolling-tabs-container inner-page-scroll-tabs is-smaller">
                    <div class="fade-left"><i aria-hidden="true" data-hidden="true" class="fa fa-angle-left"></i></div>
                    <div class="fade-right"><i aria-hidden="true" data-hidden="true" class="fa fa-angle-right"></i></div>
                    <ul class="nav-links search-filter user-profile-nav scrolling-tabs is-initialized">
                        <li class="<? if($scope=='project') echo 'active' ?>">
                            <a href="/search?project_id=&scope=project&keyword=<?=urlencode($keyword)?>">项 目
                                <span class="badge badge-pill"><?=$project_total?></span>
                            </a>
                        </li>
                        <li class="<? if($scope=='issue') echo 'active' ?>">
                            <a href="/search?project_id=&scope=issue&keyword=<?=urlencode($keyword)?>">事 项
                                <span class="badge badge-pill"><?=$issue_total?></span>
                            </a>
                        </li>
                        <li class="<? if($scope=='user') echo 'active' ?>">
                            <a href="/search?project_id=&scope=user&keyword=<?=urlencode($keyword)?>">用 户
                                <span class="badge badge-pill"><?=$user_total?></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="row-content-block">
                </div>

                <div class="results prepend-top-10">
                    <?php
                    if($scope=='project'){
                        include_once 'project_results.php';
                    }
                    if($scope=='issue'){
                        include_once 'issue_results.php';
                    }
                    if($scope=='user'){
                        include_once 'user_results.php';
                    }
                    ?>

                </div>


            </div>
        </div>
    </div>
</div>

    </div>

<script type="text/javascript">
    $(function () {
        new Search();
    })

</script>
</body>
</html>