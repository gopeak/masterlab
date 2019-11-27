<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
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
        <div class="container-fluid container-limited">
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
                                <strong>事项类型列表</strong>
                            </div>
                            <ul class="flex-list content-list">
                                <?php if(empty($list)) { ?>
                                    <!--li class="flex-row">无事项类型</li-->
                                    <? require_once VIEW_PATH.'gitlab/common/list_empty_data_dom.php';?>
                                <?php }else{ ?>
                                <?php foreach ($list as $item) { ?>
                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">

                                        <span class="label-name">
                                            <a href="javascript:void(0);">
                                                <span class="label color-label " style="background-color: #69D100; color: #FFFFFF" title="red waring"
                                                      data-container="body"><i class="fa <?= $item['font_awesome'] ?> icon-2x"></i> <?= $item['name'] ?></span>
                                            </a>
                                        </span>

                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">

                                                </div>
                                                <?= $item['description'] ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-fixed-content controls">
                                        <div class="project-action-button dropdown inline">

                                        </div>

                                    </div>
                                </li>
                                <?php }} ?>

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
