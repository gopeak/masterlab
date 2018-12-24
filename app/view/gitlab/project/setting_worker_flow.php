<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js?v=<?=$_version?>"></script>

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
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">
            <div class="content" id="content-body">


                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            事项类型
                        </h4>
                        <p>
                        将事项分为不同的类型, 例如 缺陷或任务等。 每个事项类型都可以分别配置不同的选项。
                        </p>
                        <p>事项类型方案用于定义这个项目使用哪几种事项类型。 要改变项目的事项类型, 可以选择另一个事项类型方案, 或编辑当前的事项类型界面方案。</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <!--事项类型-->
                                <strong>Default Issue Type Scheme</strong>

                            </div>
                            <ul class="flex-list content-list">
                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">
                                        <a href="/ismond/xphp/tags/v1.2">
                                        <span class="item-title" style="font-size: 20px">
                                            <i class="fa fa-bug icon-2x"></i> </span>
                                            <span  style="font-size: 20px" title="Bug" data-original-title="variables config should be a hash of key value pairs" class="js-pipeline-url-yaml label label-danger has-tooltip" aria-describedby="tooltip268552">
                                                Bug
                                            </span>
                                        </a>
                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18"><path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path></svg>

                                                </div>

                                                测试过程，维护过程发现影响系统运行的缺陷
                                                <a class="commit-id monospace" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">jira</a>
                                                <a class="commit-id monospace" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">Default Field Configuration</a>
                                                <a class="commit-id monospace" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">Default Screen Scheme</a>

                                                <time class="js-timeago js-timeago-render-my" title="" datetime="2017-07-29T07:49:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 3:49pm GMT+0800">Default Screen Scheme</time>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-fixed-content controls">
                                        <div class="project-action-button dropdown inline">

                                        </div>

                                    </div>
                                </li>
                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">
                                        <a href="/ismond/xphp/tags/v1.0">
                                            <span class="item-title" style="font-size: 20px">
                                                <i class="fa fa-tasks icon-2x"> </i>
                                            </span>
                                            <span style="font-size: 20px" title="任务" data-original-title="Latest pipeline for this branch" class="js-pipeline-url-lastest label label-success has-tooltip">
                                                任务
                                            </span>
                                        </a><div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18"><path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path></svg>

                                                </div>
                                                <a class="commit-id monospace" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">2f126945</a>
                                                ·
                                                <span class="str-truncated">
<a class="commit-row-message" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">remove 11.php</a>
</span>
                                                ·
                                                <time class="js-timeago js-timeago-render-my" title="" datetime="2017-07-29T07:49:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 3:49pm GMT+0800">2 months ago</time>
                                            </div>

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
</section>
</body>
</html>


</div>