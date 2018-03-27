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
        <div class=" ">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_issue_left_nav.php';?>
                <div class="container-fluid"  style="margin-left: 248px">
                    <div class="top-area">

                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 0px">
                            <form id="filter_form" action="/admin/user/filter" accept-charset="UTF-8" method="get">

                                工作流

                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">

                            <div class="project-item-select-holder">

                                <a class="btn  " href="/admin/workflow/edit/<?=$id?>"  >
                                    <i class="fa fa-edit"></i>
                                    编辑
                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="content-list pipelines" style="margin-top:-70px">

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
<script src="/dev/js/jquery.min.js"></script>
<script src="<?=ROOT_URL?>dev/lib/jsplumb/js/jsplumb.min.js"></script>

<script src="<?=ROOT_URL?>dev/js/admin/workflow_design.js"></script>
<script type="text/javascript">

    var $Workflow = null;
    var workflow_data = <?=$data?>;
    $(function() {




    });

</script>
</body>
</html>