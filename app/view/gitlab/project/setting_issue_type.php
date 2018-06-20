<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="/gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
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
                            问题类型
                        </h4>
                        <p>
                        将问题分为不同的类型, 例如 缺陷或任务等。 每个问题类型都可以分别配置不同的选项。
                        </p>
                        <p>问题类型方案用于定义这个项目使用哪几种问题类型。 要改变项目的问题类型, 可以选择另一个问题类型方案, 或编辑当前的问题类型界面方案。</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <!--问题类型-->
                                <strong>Default Issue Type Scheme</strong>

                            </div>
                            <ul class="flex-list content-list">
                                <?php if(empty($list)) { ?>
                                    <li class="flex-row">无问题类型</li>
                                <?php }else{ ?>
                                <?php foreach ($list as $item) { ?>
                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">

                                        <span class="label-name">
                                            <a href="/ismond/xphp/issues?label_name%5B%5D=Error">
                                                <span class="label color-label " style="background-color: #69D100; color: #FFFFFF" title="red waring"
                                                      data-container="body"><i class="fa <?= $item['font_awesome'] ?> icon-2x"></i> <?= $item['name'] ?></span>
                                            </a>
                                        </span>

                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">

                                                </div>
                                                <?= $item['description'] ?>
                                                <?= $item['is_system']?"这是系统默认的问题类型":"" ?>

                                                <!--a class="commit-id monospace" href="#">jira</a>
                                                <a class="commit-id monospace" href="#">Default Field Configuration</a>
                                                <a class="commit-id monospace" href="#">Default Screen Scheme</a>

                                                <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T07:49:42Z"
                                                      data-toggle="tooltip" data-placement="top" data-container="body"
                                                      data-original-title="Jul 29, 2017 3:49pm GMT+0800">Default Screen Scheme</time-->
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-fixed-content controls">
                                        <div class="project-action-button dropdown inline">

                                        </div>

                                    </div>
                                </li>
                                <?php }} ?>

                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">

                                        <span class="label-name">
                                            <a href="/ismond/xphp/issues?label_name%5B%5D=Error">
                                                <span class="label color-label " style="background-color: #FF0000; color: #FFFFFF" title="red waring"
                                                      data-container="body"><i class="fa fa-bug icon-2x"></i> Error</span>
                                            </a>
                                        </span>

                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">

                                                </div>

                                                测试过程，维护过程发现影响系统运行的缺陷
                                                <a class="commit-id monospace" href="#">jira</a>
                                                <a class="commit-id monospace" href="#">Default Field Configuration</a>
                                                <a class="commit-id monospace" href="#">Default Screen Scheme</a>

                                                <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T07:49:42Z"
                                                      data-toggle="tooltip" data-placement="top" data-container="body"
                                                      data-original-title="Jul 29, 2017 3:49pm GMT+0800">Default Screen Scheme</time>
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
                                        <span class="label-name">
                                            <a href="/ismond/xphp/issues?label_name%5B%5D=Error">
                                                <span class="label color-label " style="background-color: #69D100; color: #FFFFFF" title="red waring"
                                                      data-container="body"><i class="fa fa-bug icon-2x"></i> 任务</span>
                                            </a>
                                        </span>

                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">
                                                </div>
                                                <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T07:49:42Z"
                                                      data-toggle="tooltip" data-placement="top" data-container="body"
                                                      data-original-title="Jul 29, 2017 3:49pm GMT+0800">2 months ago</time>
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
</body>
</html>


</div>