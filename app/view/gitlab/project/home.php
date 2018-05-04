<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <div class="header-content">

            <? require_once VIEW_PATH.'gitlab/common/body/header-dropdown.php';?>
            <? require_once VIEW_PATH.'gitlab/common/body/header-logo.php';?>
            <div class="title-container">
                <h1 class="title">
                    <span class="group-title">
                        <a class="group-path" href="/<?=$org_name?>"><?=$org_name?></a>
                    </span> /
                    <a class="project-item-select-holder" href="<?=$project_root_url?>"><?=$pro_key?></a>
                    <button name="button" type="button" class="dropdown-toggle-caret js-projects-dropdown-toggle"
                            aria-label="Toggle switch project dropdown" data-target=".js-dropdown-menu-projects" data-toggle="dropdown" data-order-by="last_activity_at"><i class="fa fa-chevron-down"></i>
                    </button>
                </h1>
            </div>
            <? require_once VIEW_PATH.'gitlab/common/body/header-navbar-collapse.php';?>
            <button class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <i class="fa fa-ellipsis-v"></i> </button>
            <? require_once VIEW_PATH.'gitlab/common/body/header-js-dropdown-menu-projects.php';?>
        </div>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <? require_once VIEW_PATH.'gitlab/project/common-home-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">


            <div class="flash-container flash-container-page">
            </div>


        </div>

        <div class="container-fluid ">
            <div class="content" id="content-body">


                <div class="project-home-panel text-center">
                    <div class="container-fluid limit-container-width">
                        <div class="avatar-container s70 project-avatar">
                            <div class="avatar s70 avatar-tile identicon" style="background-color: #E3F2FD; color: #555">X</div>
                        </div>
                        <h1 class="project-title">
                            <?=$data['project_name'] ?>
                            <span class="visibility-icon has-tooltip" data-container="body" title=""
                                  data-original-title="Private - Project access must be granted explicitly to each user."><i class="fa fa-lock"></i>
                            </span>
                        </h1>
                        <div class="project-home-desc">
                            <p dir="auto"> <?=$data['info'] ?> </p>
                        </div>

                    </div>
                </div>


                <div class="container-fluid">

                </div>
                <div class="container-fluid">
                    <div class="row prepend-top-default">
                        <div class="col-lg-3 profile-settings-sidebar">
                            <h4 class="prepend-top-0">
                                基本信息
                                <a name="h4_basic_info" id="h4_basic_info" ></a>
                            </h4>
                        </div>
                        <div class="col-lg-9">
                            <article class="file-holder readme-holder">

                                <div class="file-content wiki">
                                    <?=$data['info'] ?>
                                    <h3>----------------------------删除线----------------------------------</h3>
                                    <h3 align="" dir="auto">
                                        <a id="user-content-轻量级基于php7的开发框架-" class="anchor" href="#" aria-hidden="true"></a>轻量级,基于PHP7的开发框架 </h3>

                                    <p align="" dir="auto">Xphp目的是快速的轻松的构建一个高性能,可扩展,易于维护的Web应用程序或站点</p>

                                    <p align="" dir="auto">
                                        <a href="#"><img src="https://img.shields.io/travis/mholt/caddy.svg?label=linux+build"></a>
                                        <a href="#"><img src="https://img.shields.io/appveyor/ci/mholt/caddy.svg?label=windows+build"></a>

                                    </p>

                                    <p align="" dir="auto">
                                        <a href="http://192.168.3.213/ismond/xphp/repository/archive.zip?ref=master">下载</a> ·
                                        <a href="http://192.168.3.213/ismond/xphp/wikis/home">文档</a> ·
                                        <a href="#">社区</a>
                                    </p>

                                    <p dir="auto">Xphp 具有高性能,轻量级,易于上手,功能完备的PHP LMVC 开发框架.
                                        LMVC分别是 Logic逻辑 Model模型 View视图 Ctrl控制器，与传统的MVC框架比多一层Logic层，目的是解决在复杂的应用系统时，逻辑代码混杂于Model或Ctrl之间的问题。 </p>



                                    <h2 dir="auto">
                                        <a id="user-content-lmvc开发模式" class="anchor" href="#" aria-hidden="true"></a>LMVC开发模式</h2>



                                    <h2 dir="auto">
                                        <a id="user-content-待完成功能" class="anchor" href="#" aria-hidden="true"></a>待完成功能</h2>

                                    <ul dir="auto">
                                        <li>
                                            <strong>松耦合的设计</strong><br>
                                        </li>
                                        <li>
                                            <strong>连贯式的Sql语句查询构建器</strong><br>
                                        </li>
                                        <li>
                                            <strong>增加项目运维平台</strong><br>
                                        </li>
                                        <li>
                                            <strong>日志处理</strong> ,系统日志,错误日志,逻辑日志不同处理,同时提供查询页面</li>
                                        <li>
                                            <strong>安全性增强</strong><br>
                                        </li>
                                        <li>
                                            <strong>队列处理</strong><br>
                                        </li>
                                    </ul>

                                    <h2 dir="auto">
                                        <a id="user-content-贡献" class="anchor" href="#%E8%B4%A1%E7%8C%AE" aria-hidden="true"></a>贡献</h2>

                                    <p dir="auto">感谢
                                        leigin
                                        秋士悲</p>

                                    <p dir="auto">Thanks for making Xphp-- and the Web -- better!</p>

                                    <h2 dir="auto">
                                        <a id="user-content-关于" class="anchor" href="#%E5%85%B3%E4%BA%8E" aria-hidden="true"></a>关于</h2>

                                    <p dir="auto">仅内部使用</p>

                                    <p dir="auto"><em>Author on Twitter: <a href="https://twitter.com/sven" rel="nofollow noreferrer" target="_blank">@sven</a></em></p>
                                </div>
                            </article>

                        </div>
                    </div>
                    <div class="project-show-files">
                        <div class="tree-holder clearfix" id="tree-holder">





                            <script>
                                new NewCommitForm($('.js-create-dir-form'))
                            </script>

                            <script>
                                // Load last commit log for each file in tree
                                $('#tree-slider').waitForImages(function() {
                                    //gl.utils.ajaxGet("/ismond/xphp/refs/master/logs_tree/");
                                });
                            </script>

                        </div>

                    </div>
                </div>

            </div>

            <div class="project-edit-container">

            </div>

        </div>


    </div>
</div>
</body>
</html>
