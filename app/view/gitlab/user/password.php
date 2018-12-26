<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/js/user/profile.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="profiles:show" data-project="">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="content padding-0" id="content-body">
            <div class="cover-block user-cover-block">
                <div class="scrolling-tabs-container">
                    <div class="fade-left">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="fade-right">
                        <i class="fa fa-angle-right"></i>
                    </div>
                    <?php
                    $profile_nav='password';
                    include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                    ?>
                </div>
            </div>
            <div class="container-fluid container-limited">
            <div class="row prepend-top-default">
                <div class="col-lg-4 profile-settings-sidebar">
                    <h4 class="prepend-top-0">密码</h4>
                    <p>成功修改密码后，将跳到登录页你可以用你的新密码登录。</p>
                </div>
                <div class="col-lg-8">
                    <h5 class="prepend-top-10"></h5>
                    <form class="update-password" id="edit_password" action="<?=ROOT_URL?>user/password" accept-charset="UTF-8" method="post">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="authenticity_token" value="">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="label-light" for="user_current_password">当前密码:</label>
                                </div>
                                <div class="col-lg-6">
                                    <input required="required" class="form-control" type="password" name="params[origin_pass]" id="user_current_password">
                                </div>
                                <div class="col-lg-4">
                                    <p class="help-block">修改前必须提供你的当前密码。</p>
                                </div   >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="label-light" for="user_password">新密码:</label>
                                </div>
                                <div class="col-lg-6">
                                    <input required="required" class="form-control" type="password" name="params[new_password]" id="user_password">
                                </div>
                                <div class="col-lg-4">
                                    <p class="help-block"></p>
                                </div   >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="label-light" for="user_password_confirmation">密码确认:</label>
                                </div>
                                <div class="col-lg-6">
                                    <input required="required" class="form-control" type="password" name="params[password_confirmation]" id="user_password_confirmation">
                                </div>
                                <div class="col-lg-4">
                                    <p class="help-block"></p>
                                </div   >
                            </div>
                        </div>

                    </form>
                </div>
            </div>

                <hr>
                <div class="row prepend-top-default append-bottom-default">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-3">
                        <input type="button" name="commit" id="commit" value="保存密码" class="btn btn-create append-right-10 js-key-enter">
                        <a class="account-btn-link" rel="nofollow"  href="<?=ROOT_URL?>passport/find_password">忘记密码</a>
                    </div>
                    <div class="col-lg-3">

                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
        </div>

    </div>
</div>

    </div>
</section>
<script type="text/javascript">

    var $profile = null;
    $(function() {

        var options = {
            uid:window.current_uid,
            update_password_url:"<?=ROOT_URL?>user/setNewPassword",
        }

        $('#commit').bind('click',function(){
            window.$profile.updatePassword();
        })
        window.$profile = new Profile( options );
    });



</script>


</body>
</html>

