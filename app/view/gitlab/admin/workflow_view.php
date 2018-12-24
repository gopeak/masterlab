<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/jsplumb/css/main.css">
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/jsplumb/css/jsplumbtoolkit-defaults.css">
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/jsplumb/css/jsplumbtoolkit-demo.css">
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/jsplumb/demo/statemachine/demo.css">
</head>

<body class="" data-demo-id="statemachine">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="container-fluid">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_issue_left_nav.php';?>
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">查看工作流</a>
                                </li>
                            </ul>

                            <div class="nav-controls">
                                <a class="btn has-tooltip" title="" href="/admin/workflow" data-original-title="返回列表">
                                    <i class="fa fa-reply-all"></i> 返回列表
                                </a>
                                    <a class="btn  " href="<?=ROOT_URL?>admin/workflow/edit/<?=$id?>"  >
                                        <i class="fa fa-edit"></i>
                                        编辑
                                    </a>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="jtk-demo-main">
                                <!-- demo -->
                                <div class="jtk-demo-canvas canvas-wide statemachine-demo jtk-surface jtk-surface-nopan" id="canvas">

                                </div>
                                <!-- /demo -->
                            </div>



                            <div>
                                <span>Data:</span><br>

                                <textarea cols="120" rows="20" id="workflow_json" name="workflow_json" style="margin-left: 80px">

                                </textarea>
                            </div>
                            <div class="gl-pagination" id="pagination">

                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

    </div>
</section>
<!-- <script src="<?=ROOT_URL?>dev/lib/jquery.min.js"></script> -->
<script src="<?=ROOT_URL?>dev/lib/jsplumb/js/jsplumb.min.js"></script>

<script src="<?=ROOT_URL?>dev/js/admin/workflow_design.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $Workflow = null;
    var workflow_data = <?=$data?>;
    $(function() {




    });

</script>
</body>
</html>