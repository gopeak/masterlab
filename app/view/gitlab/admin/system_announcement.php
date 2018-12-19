<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<script src="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
    window.project_uploads_path = "/issue/main/upload";
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

                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">公告栏</a>
                                </li>
                                <li>
                                    <span class="hint">你在每个页面顶部显示公告栏，公告栏可以插入文字。对于通知用户系统变化是非常有用的</span>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list prepend-top-default">
                            <form class="form-horizontal" id="new_announce" action="<?=ROOT_URL?>admin/system/announcement_release" accept-charset="UTF-8" method="post">
                                <input type="hidden" id="status" value="1" name="params[status]">
                                <div class="form-group">
                                    <label class="control-label" >公告内容:</label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="content" id="content"><?=$info['content']?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" >有效时间:</label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="text" class="laydate_input_date form-control" name="expire_time"
                                                   id="expire_time" value="<?=$info['expire_time']?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row-content-block">
                                    <div class="pull-right">
                                        <a class="btn btn-cancel" id="disable_announcement" href="#">禁用公告</a>
                                    </div>
                                    <span class="append-right-10">
                                        <input type="button" name="commit" id="commit" value="发布公告" class="btn btn-save js-key-enter" >
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


<link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
<script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

<script>
    window.onload = function () {
        laydate.render({
            elem: '.laydate_input_date'
            , type: 'datetime'
            , trigger: 'click'
        });
    };

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
                    auth_check(res);
                    if (res.ret == "200") {
                        notify_success(res.msg);
                    } else {
                        notify_error(res.msg);
                    }
                },
                error: function (res) {
                    // alert("请求数据错误" + res);
                    notify_error('请求数据错误: ' + res);
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
                    auth_check(res);
                    if (res.ret == "200") {
                        notify_success(res.msg);
                    } else {
                        notify_error(res.msg);
                    }
                },
                error: function (res) {
                    notify_error('请求数据错误: ' + res);
                }
            });

        });
    });


</script>


</body>
</html>
