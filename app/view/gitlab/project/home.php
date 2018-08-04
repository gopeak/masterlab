<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/autosearch.js" type="text/javascript" charset="utf-8"></script>
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
                            <?=$project_name?>
                            <span class="visibility-icon has-tooltip" data-container="body" title=""
                                  data-original-title="Private - Project access must be granted explicitly to each user."><i class="fa fa-lock"></i>
                            </span>
                        </h1>
                        <div class="project-home-desc">
                            <p dir="auto"> <?=$project['description'] ?> </p>
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
                                    <?=$project['detail'] ?>
                                </div>
                            </article>

                        </div>
                    </div>
                    <div class="project-show-files">
                        <div class="tree-holder clearfix" id="tree-holder">

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
