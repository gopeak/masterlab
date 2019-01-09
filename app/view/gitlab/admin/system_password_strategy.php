<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

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

                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">密码策略</a>
                                </li>
                                <li>
                                    <span class="hint">当前密码策略:<strong>禁用</strong></span>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <form class="form-horizontal" ID="form_password_strategy" action="<?=ROOT_URL?>admin/system/basic_setting_update" accept-charset="UTF-8" method="POST">
                                <div class="table-holder">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label for="strategy_disable">
                                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                        <input type="radio" value="1" name="params[password_strategy]" id="strategy_disable">
                                                        <strong>禁用: </strong>
                                                        <br>
                                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;允许所有密码</span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="strategy_basic">
                                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                        <input type="radio" value="2" name="params[password_strategy]" id="strategy_basic">
                                                        <strong>基本: </strong>
                                                        <br>
                                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;不允许非常简单的密码<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="strategy_mix">
                                                        <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                        <input type="radio" value="3" name="params[password_strategy]" id="strategy_mix">
                                                        <strong>安全：  </strong>
                                                        <br>
                                                        <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;要求强密码  关于安全密码策略<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row-content-block">
                                        <div class="pull-right">
                                            <!--<a class="btn btn-cancel" href="#">Cancel</a>-->
                                        </div>
                                        <span class="append-right-10">
                                            <input type="button" name="commit" value="更新" class="btn btn-save js-key-enter">
                                        </span>
                                    </div>
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

<script type="text/javascript">

    function fetchPasswordStrategySetting(  ) {

        var params = {  module:'password_strategy', format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/admin/system/setting_fetch',
            data: params ,
            success: function (res) {
                auth_check(res);
                for(var i in res.data.settings) {
                    var setting = res.data.settings[i];
                    if( setting._key=='password_strategy'){
                        $("input[type=radio][value="+setting._value+"]").attr("checked",true);
                    }

                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    $(function() {
        fetchPasswordStrategySetting();
    });

</script>

</body>
</html>
