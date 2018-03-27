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
                        <a class="group-path" href="/ismond">ismond</a>
                    </span> /
                    <a class="project-item-select-holder" href="/ismond/xphp">xphp</a>
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
                            xphp
                            <span class="visibility-icon has-tooltip" data-container="body" title=""
                                  data-original-title="Private - Project access must be granted explicitly to each user."><i class="fa fa-lock"></i>
                            </span>
                        </h1>
                        <div class="project-home-desc">
                            <p dir="auto">轻量级、高性能的PHP开发框架
                                Lightweight, high-performance PHP development framework</p>
                        </div>
                        <div class="project-repo-buttons">
                            <div class="count-buttons">
                                <a class="btn star-btn toggle-star" data-remote="true" rel="nofollow" data-method="post" href="/ismond/xphp/toggle_star"><i class="fa fa-star"></i>
                                    <span class="starred">Unstar</span>
                                </a><div class="count-with-arrow">
                                    <span class="arrow"></span>
                                    <span class="count star-count">
1
</span>
                                </div>



                            </div>
                            <span class="hidden-xs">
<div class="project-clone-holder">
<div class="git-clone-holder input-group">
<div class="input-group-btn">

<ul class="dropdown-menu dropdown-menu-right clone-options-dropdown">
<li>
<a class="ssh-selector" href="git@192.168.3.213:ismond/xphp.git" data-html="true" data-placement="right" data-container="body" data-title="Add an SSH key to your profile<br>to pull or push via SSH.">SSH</a>
</li>
<li>
<a class="http-selector" href="http://sven@192.168.3.213/ismond/xphp.git" data-html="true" data-placement="right" data-container="body" data-title="Set a password on your account<br>to pull or push via HTTP">HTTP</a>
</li>
</ul>
</div>
<input type="text" name="project_clone" id="project_clone" value="git@192.168.3.213:ismond/xphp.git" class="js-select-on-focus form-control" readonly="readonly">
<div class="input-group-btn">
<button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="bottom" data-container="body" data-title="Copy URL to clipboard" data-clipboard-target="#project_clone" type="button" title="Copy URL to clipboard"><i aria-hidden="true" class="fa fa-clipboard"></i></button>
</div>
</div>
<script>
  $('ul.clone-options-dropdown a').on('click',function(e){
      e.preventDefault();
      var $this = $(this);
      $('a.clone-dropdown-btn span').text($this.text());
      $('#project_clone').val($this.attr('href'));
  });
</script>

</div>
<div class="project-action-button dropdown inline">

<ul class="dropdown-menu dropdown-menu-align-right" role="menu">
<li class="dropdown-header">Source code</li>
<li>
<a rel="nofollow" download="" href="/ismond/xphp/repository/archive.zip?ref=master"><i class="fa fa-download"></i>
<span>Download zip</span>
</a></li>
<li>
<a rel="nofollow" download="" href="/ismond/xphp/repository/archive.tar.gz?ref=master"><i class="fa fa-download"></i>
<span>Download tar.gz</span>
</a></li>
<li>
<a rel="nofollow" download="" href="/ismond/xphp/repository/archive.tar.bz2?ref=master"><i class="fa fa-download"></i>
<span>Download tar.bz2</span>
</a></li>
<li>
<a rel="nofollow" download="" href="/ismond/xphp/repository/archive.tar?ref=master"><i class="fa fa-download"></i>
<span>Download tar</span>
</a></li>
</ul>
</div>
<div class="project-action-button dropdown inline">
<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
<i class="fa fa-plus"></i>
<i class="fa fa-caret-down"></i>
</a>
<ul class="dropdown-menu dropdown-menu-align-right project-home-dropdown">
<li>
<a href="/ismond/xphp/issues/new"><i class="fa fa-exclamation-circle fa-fw"></i>
New issue
</a></li>
<li>
<a href="/ismond/xphp/merge_requests/new"><i class="fa fa-tasks fa-fw"></i>新增版本
</a></li>

<li>
<a href="/ismond/xphp/new/master"><i class="fa fa-file fa-fw"></i>新增模块
</a></li>
<li>
<a href="/ismond/xphp/branches/new"><i class="fa fa-code-fork fa-fw"></i>新增迭代
</a></li>
<li>
<a href="/ismond/xphp/tags/new"><i class="fa fa-tags fa-fw"></i>新增角色
</a></li>
</ul>
</div>


<div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
<form class="inline notification-form" id="new_notification_setting" action="/notification_settings" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="project_id" id="project_id" value="31">
<input class="notification_setting_level" type="hidden" value="global" name="notification_setting[level]" id="notification_setting_level">
<div class="js-notification-toggle-btns">
<div class="">
<button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
<i class="fa fa-bell js-notification-loading"></i>
Global
<i class="fa fa-caret-down"></i>
</button>
<ul class="dropdown-15-31-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
<li role="menuitem"><a class="update-notification is-active" data-notification-level="global" data-notification-title="Global" href="#"><strong class="dropdown-menu-inner-title">Global</strong><span class="dropdown-menu-inner-content">Use your global notification setting</span></a></li>
<li role="menuitem"><a class="update-notification " data-notification-level="watch" data-notification-title="Watch" href="#"><strong class="dropdown-menu-inner-title">Watch</strong><span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a></li>
<li role="menuitem"><a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#"><strong class="dropdown-menu-inner-title">On mention</strong><span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a></li>
<li role="menuitem"><a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#"><strong class="dropdown-menu-inner-title">Participate</strong><span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a></li>
<li role="menuitem"><a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#"><strong class="dropdown-menu-inner-title">Disabled</strong><span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a></li>
<li class="divider"></li>
<li>
<a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-31-Project" data-toggle="modal" href="#" role="button">
<strong class="dropdown-menu-inner-title">Custom</strong>
<span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span>
</a>
</li>
</ul>

</div>
</div>
</form></div>

<div class="project-action-button inline">
</div>

</span>
                        </div>
                    </div>
                </div>

                <nav class="container-fluid project-stats">
                    <ul class="nav">
                        <li>
                            <a href="#h4_basic_info">基本信息</a></li>
                        <li>
                            <a href="#h4_issue_type">问题类型</a></li>
                        <li>
                            <a href="#h4_version">版本 (3)
                            </a></li>
                        <li>
                            <a href="#h4_module">模块 (2)
                            </a></li>
                        <li>
                            <a href="#h4_worker_flow">工作流</a>
                        </li>
                        <li>
                            <a href="#h4_ui">界面</a>
                        </li>
                        <li class="missing">
                            <a href="#h4_field">字段</a></li>
                        <li class="missing">
                            <a href="#h4_permission">权限</a></li>
                        <li class="missing">
                            <a href="#h4_project_role">项目角色</a></li>
                    </ul>
                </nav>
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
                                    <p align="center" dir="auto">
                                        <a href="http://git.oschina.net/ismond_org/xphp" rel="nofollow noreferrer" target="_blank">Xphp</a>
                                    </p>

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
                <hr>
                <div class="row prepend-top-default">
                    <div class="col-lg-3 profile-settings-sidebar">
                        <h4 class="prepend-top-0" >
                            问题类型
                            <a name="h4_issue_type" id="h4_issue_type" ></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <div class="project-edit-errors"></div>
                        <form class="edit-project" id="edit_project_31" enctype="multipart/form-data" action="/ismond/xphp" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch">




                            <ul class="project-config-list project-config-itemlist">
                                <?php if(!empty($data['issue_type'])) { ?>
                                <?php foreach ($data['issue_type'] as $item) { ?>
                                <li>
                                    <span class="project-config-list-label">
                                        <img class="project-config-icon project-config-icon-issuetype" alt="" height="16" src="/secure/viewavatar?size=xsmall&amp;avatarId=10303&amp;avatarType=issuetype" title="缺陷 - 测试过程，维护过程发现影响系统运行的缺陷" width="16">
                                        <span class="project-config-issuetype-name">
                                            <a href="/plugins/servlet/project-config/BOM/issuetypes/1"><?=$item['name']?></a>
                                        </span>
                                    </span>
                                </li>
                                <?php }} ?>

                            </ul>



                        </form>
                    </div>
                </div>
                <div class="row prepend-top-default"></div>
                <hr>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            版本
                            <a name="h4_version" id="h4_version"></a>
                        </h4>
                        <p class="append-bottom-0">
                        </p><p>
                            Runs a number of housekeeping tasks within the current repository,
                            such as compressing file revisions and removing unreachable objects.
                        </p>
                        <p></p>
                    </div>
                    <div class="col-lg-9">
                        <ul class="project-config-list project-config-itemlist">
                            <?php if(!empty($data['versions'])) { ?>
                            <?php foreach ($data['versions'] as $item) { ?>
                            <li>
                                <span class="project-config-list-label">
                                    <span class="aui-icon aui-icon-small aui-iconfont-workflow icon-default"></span>
                                    <a class="project-config-workflow-edit" href="/secure/admin/workflows/EditWorkflowDispatcher.jspa?atl_token=BQ4M-GFPA-TO2Z-ZG2Q%7C7ca3e2dde0494a6bdf77fdb22378368cf7bf0942%7Clin&amp;wfName=jira&amp;project=10501" title="编辑工作流">
                                        <span class="aui-icon aui-icon-small aui-iconfont-edit icon-default"><?= $item['name'] ?></span>
                                    </a>
                                </span>
                            </li>
                            <?php }} ?>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            模块
                            <a name="h4_module" id="h4_module"></a>
                        </h4>
                        <p class="append-bottom-0">
                        </p><p>
                            Export this project with all its related data in order to move your project to a new GitLab instance. Once the export is finished, you can import the file from the "New Project" page.
                        </p>
                        <p>
                            Once the exported file is ready, you will receive a notification email with a download link.
                        </p>
                        <p></p>
                    </div>
                    <div class="col-lg-9">
                        <ul class="project-config-list project-config-itemlist">
                            <?php if(!empty($data['modules'])) { ?>
                            <?php foreach ($data['modules'] as $item) { ?>
                            <li>
                                <span class="project-config-list-label">
                                    <span class="aui-icon icon-default aui-icon-small aui-iconfont-admin-jira-screens"></span>
                                    <a class="project-config-screenscheme-name" href="/secure/admin/ConfigureFieldScreenScheme.jspa?id=1" title="Default Screen Scheme"><?= $item['name'] ?></a>
                                    <span class="project-config-list-default aui-lozenge"><?= $item['name'] ?></span>
                                </span>
                            </li>
                            <?php }} ?>
                        </ul>
                        <div class="bs-callout bs-callout-info">
                            <p class="append-bottom-0">
                            </p><p>
                                The following items will be exported:
                            </p>
                            <ul>
                                <li>Project and wiki repositories</li>
                                <li>Project uploads</li>
                                <li>Project configuration including web hooks and services</li>
                                <li>Issues with comments, merge requests with diffs and comments, labels, milestones, snippets, and other project entities</li>
                            </ul>
                            <p>
                                The following items will NOT be exported:
                            </p>
                            <ul>
                                <li>Job traces and artifacts</li>
                                <li>LFS objects</li>
                                <li>Container registry images</li>
                                <li>CI variables</li>
                                <li>Any encrypted tokens</li>
                            </ul>
                            <p></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0 warning-title">
                            工作流
                            <a name="h4_worker_flow" id="h4_worker_flow"></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <ul id="project-config-summary-versions-list" class="project-config-list project-config-itemlist">
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.1
                    </span>
                            </li>
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.0
                    </span>
                            </li>
                        </ul>


                    </div>
                </div>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            界面
                            <a name="h4_worker_flow" id="h4_ui"></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <ul id="project-config-summary-versions-list" class="project-config-list project-config-itemlist">
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.1
                    </span>
                            </li>
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.0
                    </span>
                            </li>
                        </ul>


                    </div>
                </div>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            字段
                            <a name="h4_field" id="h4_field"></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <ul id="project-config-summary-versions-list" class="project-config-list project-config-itemlist">
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.1
                    </span>
                            </li>
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.0
                    </span>
                            </li>
                        </ul>


                    </div>
                </div>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            权限
                            <a name="h4_permission" id="h4_permission"></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <ul id="project-config-summary-versions-list" class="project-config-list project-config-itemlist">
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.1
                    </span>
                            </li>
                            <li>
                    <span class="project-config-list-label">
                                                                        <span class="project-config-icon project-config-icon-version"></span>
                        1.0
                    </span>
                            </li>
                        </ul>


                    </div>
                </div>
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">
                            项目角色
                            <a name="h4_project_role" id="h4_project_role"></a>
                        </h4>
                    </div>
                    <div class="col-lg-9">
                        <ul id="project-config-summary-versions-list" class="project-config-list project-config-itemlist">
                            <li>
                                <span class="project-config-list-label"><span class="project-config-icon project-config-icon-version"></span>1.1</span>
                            </li>
                            <li>
                                <span class="project-config-list-label"><span class="project-config-icon project-config-icon-version"></span>1.0</span>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
</body>
</html>
