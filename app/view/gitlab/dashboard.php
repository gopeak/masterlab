<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css?v=<?=$_version?>" rel="stylesheet" type="text/css"/>
    <link href="<?=ROOT_URL?>dev/css/statistics.css?v=<?=$_version?>" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

</head>

<body class="dashboard" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>
<section class="has-sidebar page-layout max-sidebar">
<? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

<div class="page-layout page-content-body">
<? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>
<style>
    .assignee-more {
        border-top: 1px solid #efefef;
        text-align: center;
        padding: 10px 0 0;
    }
    .assignee-more a{
        color: #ccc;
        display: block;
    }
    .assignee-more a:hover{
        color: #999;
    }
</style>
<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>

        <div class="content-header">
            <!--            <div class="breadcrumb">-->
            <!--                首页-->
            <!--            </div>-->

            <div class="user-profile">
                <div class="user-profile-content">
                    <div class="user-avatar">
                        <img src="<?= $user['avatar'] ?>" alt="">
                    </div>

                    <div class="user-profile-text">
                        <div class="text-title"><span id="current_time"></span><?= $user['display_name'] ?>，祝你开心每一天！
                        </div>
                        <div class="text-content">
                            <?= $user['title'] ?>
                            <?php
                            if (!empty($user['sign'])) {
                                echo '|&nbsp;&nbsp;&nbsp;&nbsp;' . $user['sign'];
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <ul class="user-profile-extra">
                    <li class="extra-item">
                        <p class="extra-item-title">项目数</p>
                        <p class="extra-item-num"><?=$project_count?></p>
                    </li>

                    <li class="extra-item">
                        <p class="extra-item-title">未完成事项数</p>
                        <p class="extra-item-num"><?=$un_done_issue_count?></span></p>
                    </li>

                    <li class="extra-item">
                        <p class="extra-item-title">用户数</p>
                        <p class="extra-item-num"><?=$user_count?></p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content padding-0" id="content-body1">
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