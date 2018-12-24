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
                                <a href="#">工作流</a>
                            </li>
                        </ul>
                        <div class="nav-controls">
                                <a class="btn has-tooltip" title="" href="/admin/workflow" data-original-title="返回列表">
                                    <i class="fa fa-reply-all"></i> 返回列表
                                </a>
                                <a class="btn btn-save btn-workflow_update" >
                                    <i class="fa fa-save"></i>
                                    保存
                                </a>
                        </div>
                    </div>

                    <div class="content-list">

                        <form class="form-horizontal " id="form_edit" action="/admin/workflow/update" accept-charset="UTF-8" method="post">

                            <input type="hidden" id="edit_id"  name="id" value="<?=$id?>">
                            <?php
                            if(isset($params['name'])){
                            ?>
                            <input type="hidden" id="edit_name"  name="params[name]" value="<?=$params['name']?>">
                            <?php
                            }
                            ?>
                            <?php
                            if(isset($params['description'])){
                            ?>
                            <input type="hidden" id="edit_description" name="params[description]" value="<?=$params['description']?>" >
                           <?php
                            }
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="jtk-demo-main" style="margin-top:0px">
                                        <!-- demo -->
                                        <div class="jtk-demo-canvas canvas-wide statemachine-demo jtk-surface jtk-surface-nopan" id="canvas">

                                        </div>
                                        <!-- /demo -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label" >Data:</label>
                                <div class="col-sm-5">
                                    <textarea cols="120" rows="2" id="workflow_json" name="params[data]"  ></textarea>
                                </div>
                            </div>

                            <div class="footer-block row-content-block">

                                <span class="append-right-10">
                                    <input type="button" name="commit" id="commit" value="保存" class="btn btn-save btn-workflow_update" >
                                </span>
                            </div>

                        </form>
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
<script src="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="<?=ROOT_URL?>dev/lib/jsplumb/js/jsplumb.min.js"></script>
<script src="<?=ROOT_URL?>dev/js/admin/workflow.js?v=<?=$_version?>"></script>
<script src="<?=ROOT_URL?>dev/js/admin/workflow_design.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $Workflow = null;
    var workflow_data = <?=$workflow['data']?>;
    $(function() {

        $('#btn_add_states').on('click', function () {
            // do something…
            console.log($('#btn_add_states'));
        })

        window.$Workflow = new Workflow( {update_url:"/admin/workflow/update"} );

    });

</script>
</body>
</html>