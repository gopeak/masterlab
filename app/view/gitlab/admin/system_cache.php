<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>
<script src="<?= ROOT_URL ?>dev/lib/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>

        <script>
            var findFileURL = "";
            window.project_uploads_path = "/issue/main/upload";
            window.preview_markdown_path = "/api/v4/preview_markdown.json";
        </script>

        <div class="page-with-sidebar">

            <? require_once VIEW_PATH . 'gitlab/admin/common-page-nav-admin.php'; ?>


            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">

                    <div class="flash-container flash-container-page">
                    </div>

                </div>
                <div class="container-fluid ">

                    <div class="content" id="content-body">

                        <?php include VIEW_PATH . 'gitlab/admin/common_system_left_nav.php'; ?>

                        <div class="row has-side-margin-left">
                            <div class="col-lg-12">
                                <div class="top-area">
                                    <ul class="nav-links">
                                        <li class="active">
                                            <a href="#">缓 存</a>
                                        </li>
                                        <li>
                                            <span class="hint">启用缓存可以提高服务器的响应速度</span>
                                        </li>
                                    </ul>
                                    <div class="nav-controls">
                                        <div class="btn-group" role="group">
                                        </div>
                                    </div>
                                </div>
                                <div class="content-list prepend-top-default">
                                    <form class="form-horizontal" id="new_announce" action="#" accept-charset="UTF-8"
                                          method="post">
                                        <?php
                                        foreach ($redis_configs as $redis_config) {

                                            ?>
                                            <div class="form-group">
                                                <label class="control-label"></label>
                                                <div class="col-sm-5">
                                                    Redis 主机: <?=$redis_config[0] ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"></label>
                                                <div class="col-sm-5">
                                                    Redis 端口: <?=$redis_config[1] ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"></label>
                                                <div class="col-sm-5">
                                                    Redis 密码: <?=@$redis_config[2] ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <a class="btn  btn-default" id="btn-redis_clear" href="#">清除数据</a>
                                                    <span style="font-size: 10px">升级补丁或数据异常时需要清除缓存</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <a class="btn  btn-default" id="btn-compute_issue" href="#">同步数据</a>
                                                   <span style="font-size: 10px">升级1.2版本时，需同步事项的关注和评论数</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
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

    $(function () {
        $("#btn-redis_clear").click(function () {
            var method = 'post';
            var url = '/admin/system/flushCache';
            $.ajax({
                type: method,
                dataType: "json",
                async: true,
                url: url,
                data: {},
                success: function (resp) {
                    auth_check(resp);
                    if (resp.ret == "200") {
                        notify_success(resp.msg);
                    } else {
                        notify_error(resp.msg, resp.data);
                    }
                },
                error: function (resp) {
                    // alert("请求数据错误" + res);
                    notify_error('请求数据错误: ' + resp);
                }
            });

        });

        $("#btn-compute_issue").click(function () {

            loading.show('body', "请稍等");
            var method = 'post';
            var url = '/admin/system/computeIssueData';
            $.ajax({
                type: method,
                dataType: "json",
                async: true,
                url: url,
                data: {},
                success: function (resp) {
                    loading.closeAll();
                    auth_check(resp);
                    if (resp.ret == "200") {
                        notify_success(resp.msg);
                    } else {
                        notify_error(resp.msg, resp.data);
                    }
                },
                error: function (resp) {
                    loading.closeAll();
                    // alert("请求数据错误" + res);
                    notify_error('请求数据错误: ' + resp);
                }
            });

        });

    });


</script>


</body>
</html>
