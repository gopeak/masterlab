<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<script src="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>



<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "";
    window.project_uploads_path = "/ismond/xphp/uploads";
    window.preview_markdown_path = "/api/v4/preview_markdown.json";
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

                <div class="prepend-top-default"  style="margin-left:160px;">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <strong>公告栏</strong> <span> 你在JIRA每个页面顶部显示公告栏，公告栏可以插入文字或HTML。对于通知用户系统变化是非常有用的</span>

                        </div>
                        <div class="panel-body">
                        <form class="form-horizontal " id="new_announce" action="<?=ROOT_URL?>admin/system/announcement_release" accept-charset="UTF-8" method="post">

                            <input type="hidden" id="status" value="1" name="params[status]">
                            <div class="form-group">
                                <label class="control-label" >公告内容:</label>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="content" id="content"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" >有效时间(单位分钟):</label>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="" name="expire_time" id="expire_time" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row-content-block">
                                <div class="pull-right">
                                    <a class="btn btn-cancel" id="disable_announcement" href="#">禁用横幅广告</a>
                                </div>
                                <span class="append-right-10">
                                    <input type="button" name="commit" id="commit" value="设置横幅广告" class="btn btn-save" >
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

<script>

    $(function() {
        $("#disable_announcement").click(function(){

            var method = 'post';
            var url   =  '/admin/system/announcement_disable' ;
            $('#status').val('2');

            $.ajax({
                type: method,
                dataType: "json",
                async: true,
                url: url,
                data: {status:2} ,
                success: function (res) {
                    alert(res.msg );
                },
                error: function (res) {
                    alert("请求数据错误" + res);
                }
            });

        });
        $("#commit").click(function(){

            var method = 'post';
            var url   =  '/admin/system/announcement_release' ;
            $('#status').val('2');

            $.ajax({
                type: method,
                dataType: "json",
                async: true,
                url: url,
                data: $('#new_announce').serialize() ,
                success: function (res) {
                    alert(res.msg );
                },
                error: function (res) {
                    alert("请求数据错误" + res);
                }
            });

        });
    });


</script>


</body>
</html>


</div>