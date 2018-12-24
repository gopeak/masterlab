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
                                    <a href="#">新增工作流</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <button id="btn_add_states" type="button" class="btn   "  data-html="true" data-toggle="popover" title="Popover title" data-content="<select id='states' name='states'><option>Open</option><option>Closed</option></select>"><i class="fa fa-plus"></i>增加状态</button>
                                    <a class="btn has-tooltip" title="" href="/admin/workflow" data-original-title="返回列表">
                                        <i class="fa fa-reply-all"></i>&nbsp;返回列表
                                    </a>
                                    <a class="btn btn-new btn-workflow_add" >
                                        <i class="fa fa-save"></i>
                                        保存
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <form class="form-horizontal " id="new_workflow" action="/admin/workflow/add" accept-charset="UTF-8" method="post">

                                <input type="hidden" id="add_name"  name="params[name]" value="<?=$params['name']?>">
                                <input type="hidden" id="add_description" name="params[description]" value="<?=$params['description']?>" >

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

                                <div class="footer-block form-actions">

                                    <span class="append-right-10">
                                        <input type="button" name="commit" id="commit" value="保存" class="btn btn-save btn-workflow_add" >
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

        $('[data-toggle="popover"]').popover();
        $('#btn_add_states').on('show.bs.popover', function () {
            // do something…
            console.log($('#states'));
        })
        window.$Workflow = new Workflow( {add_url:"/admin/workflow/add"} );

    });
        console.log($.prototype)

</script>
</body>
</html>