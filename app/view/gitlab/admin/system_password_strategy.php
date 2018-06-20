<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="/dev/js/admin/setting.js" type="text/javascript" charset="utf-8"></script>
    <script src="/dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

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

                <div class="prepend-top-default" style="margin-left: 160px">

                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">
                            <p>
                            </p>
                            <h4 class="prepend-top-0">
                                密码策略
                            </h4>

                        </div>
                        <div class="col-lg-10">

                            <div class="panel ">
                                <form class="form-horizontal" ID="form_password_strategy" action="/admin/system/basic_setting_update" accept-charset="UTF-8" method="POST">

                                    <div class="panel-heading">

                                     <span>当前密码策略:<strong>禁用</strong></span>


                                </div>

                                    <fieldset class="features merge-requests-feature append-bottom-default">

                                    <h5 class="prepend-top-0">

                                    </h5>
                                    <div class="form-group">
                                        <div class="checkbox builds-feature">
                                            <label for="strategy_disable">
                                                <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                <input type="radio" value="1" name="params[password_strategy]" id="strategy_disable">
                                                <strong>禁用: </strong>
                                                <br>
                                                <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;允许所有密码</span>
                                            </label>
                                        </div>

                                        <div class="checkbox builds-feature">
                                            <label for="strategy_basic">
                                                <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                <input type="radio" value="2" name="params[password_strategy]" id="strategy_basic">
                                                <strong>基本: </strong>
                                                <br>
                                                <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;不允许非常简单的密码<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                            </label>
                                        </div>

                                        <div class="checkbox builds-feature">
                                            <label for="strategy_mix">
                                                <input name="project[only_allow_merge_if_pipeline_succeeds]" type="hidden" value="0">
                                                <input type="radio" value="3" name="params[password_strategy]" id="strategy_mix">
                                                <strong>安全：  </strong>
                                                <br>
                                                <span class="descr">&nbsp;&nbsp;&nbsp;&nbsp;要求强密码  关于安全密码策略<a href="#"><i class="fa fa-question-circle"></i></a></span>
                                            </label>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="form-group">

                                        <input type="button" name="commit" value="更新" class="btn btn-save "  >

                                    </div>

                                </fieldset>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>



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


</div>