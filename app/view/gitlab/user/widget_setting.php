<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css?v=<?=$_version?>" rel="stylesheet" type="text/css"/>
    <link href="<?=ROOT_URL?>dev/css/statistics.css?v=<?=$_version?>" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>" type="text/javascript"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>


</head>
<body class="dashboard" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

        <div class="page-with-sidebar">
            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">
                    <div class="flash-container flash-container-page">
                    </div>
                </div>

                <div class="content padding-0" id="content-body1">
                    <div class="cover-block user-cover-block">
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <?php
                            $profile_nav='custom_index';
                            include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="nav-controls">
                        <div class="btn-group" role="group">
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-tools-add" data-toggle="modal" href="#modal-tools-add">
                                <i class="fa fa-plus"></i>
                                添加小工具
                            </a>
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-layout" data-toggle="modal" href="#modal-layout">
                                <i class="fa fa-th-large"></i>
                                版式布局
                            </a>
                        </div>
                    </div>
                </div>

                <div class="content container-fluid" id="content-body">
                    <div id="multi" class="container layout-panel layout-aa row">
                        <div class="group_panel panel-first">
                        </div>

                        <div class="group_panel panel-second">

                        </div>

                        <div class="group_panel panel-third">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php require_once VIEW_PATH.'gitlab/common/widget_tpl.php';?>

<?php require_once VIEW_PATH.'gitlab/common/widget_script.php';?>
</body>
</html>