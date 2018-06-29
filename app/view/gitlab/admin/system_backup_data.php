<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>


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
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>

                <div class="panel"  style="margin-left:160px;">
                    <button class="btn btn-save ">备份数据</button>
                    <div></div>
                    <div>
                        <iframe src="<?=ROOT_URL?>admin/data_backup/iframe_backup" width="100%" height="500px;">
                            <script>window.scrollTo(0,document.body.scrollHeight);</script>
                        </iframe>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>


<script>




</script>





</body>
</html>
