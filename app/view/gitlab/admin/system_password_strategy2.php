<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
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
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>


                <div class="row prepend-top-default" style="margin-left: 160px">


                    <div class="panel ">
                        <div class="panel-heading">

                            <strong>密码策略</strong> <span>当前密码策略:禁用</span>
                            <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="✓">
                                <div class="form-group">
                                </div>
                            </form>
                        </div>

                        <fieldset class="features merge-requests-feature append-bottom-default">

                            <h5 class="prepend-top-0">

                            </h5>
                            <div class="form-group">
                                <div class="checkbox builds-feature">
                                    <label for="project_only_allow_merge_if_pipeline_succeeds">
                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                        <input type="radio" value="1" name="strategy" id="strategy_disable">
                                        <strong>禁用: </strong>
                                        <br>
                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;允许所有密码</span>
                                    </label>
                                </div>

                                <div class="checkbox builds-feature">
                                    <label for="project_only_allow_merge_if_pipeline_succeeds">
                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                        <input type="radio" value="1" name="strategy" id="strategy_basic">
                                        <strong>基本: </strong>
                                        <br>
                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;不允许非常简单的密码<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                    </label>
                                </div>

                                <div class="checkbox builds-feature">
                                    <label for="project_only_allow_merge_if_pipeline_succeeds">
                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                        <input type="radio" value="1" name="strategy" id="strategy_mix">
                                        <strong>安全：  </strong>
                                        <br>
                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;要求强密码  关于安全密码策略<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                    </label>
                                </div>

                                <div class="checkbox builds-feature">
                                    <label for="project_only_allow_merge_if_pipeline_succeeds">
                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                        <input type="radio" value="1" name="strategy" id="strategy_custom">
                                        <strong>自定义： 使用你自己的设定</strong>
                                        <br>
                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;使用你自己的设定</span>
                                    </label>
                                </div>

                            </div>

                            <div class="form-group">

                                        <input type="button" name="commit" value="保存" class="btn btn-create "  >

                            </div>

                        </fieldset>

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


</div>