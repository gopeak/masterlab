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
                            <div class="avatar s70 avatar-tile identicon" style="background-color: #E3F2FD; color: #555"><?=$data['first_word']?></div>
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
