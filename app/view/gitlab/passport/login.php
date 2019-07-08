<!DOCTYPE html>
<html class="devise-layout-html">
<head>
    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
</head>

<script type="text/javascript">
    $(document).ready(function () {
        $("#login_submit_btn").on("click", function () {
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: '<?=ROOT_URL?>passport/do_login',
                data: $('#new_user').serialize(),
                success: function (resp) {
                    if (resp.ret == 200) {
                        window.location.href = '<?=ROOT_URL?>';
                    } else {
                        notify_error(resp.msg, resp.data);
                    }
                },
                error: function (resp) {
                    notify_error(resp.msg, resp.data);
                }
            });
        });

        $("#register_submit_btn").on("click", function () {
            $('.gl-field-error').each(function(){
                $(this).addClass('hide');
            })
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: '<?=ROOT_URL?>passport/register',
                data: $('#new_new_user').serialize(),
                success: function (resp) {
                    if (resp.ret == 200) {
                        notify_success('注册成功')
                        setTimeout(function(){ window.location.href = root_url+'passport/login'; }, 2000);
                    } else {
                        if(resp.ret=='104'){
                            for (var skey in resp.data) {
                                $('#tip_error_'+skey).html(resp.data[skey]);
                                $('#tip_error_'+skey).removeClass('hide');
                            }
                            notify_error(resp.msg,resp.data);

                        }else{
                            notify_error(resp.msg+":"+resp.data);
                        }
                    }
                },
                error: function (resp) {
                    notify_error(resp.msg.resp.data);
                }
            });
        });

        $("#refresh_login_vcode").click(function () {
            var timestamp = new Date().getTime();
            $("#img_login_vcode").attr('src', '<?=ROOT_URL?>passport/output_captcha?mode=login' + '&' + timestamp);
        });

        $("#refresh_reg_vcode").click(function () {
            var timestamp = new Date().getTime();
            $("#img_reg_vcode").attr('src', '<?=ROOT_URL?>passport/output_captcha?mode=reg' + '&' + timestamp);
        });

        Mousetrap.bind('enter', function () {
            $("#login_submit_btn").click();
        });

        $("#li-register").click(function () {
            Mousetrap.bind('enter', function () {
                $("#register_submit_btn").click();
            });
        });

        $("#li-login").click(function () {
            Mousetrap.bind('enter', function () {
                $("#login_submit_btn").click();
            });
        });

        $(document).on("keydown", function(event) {
            if (event.keyCode == 13 && $("#login_submit_btn").length) {
                $("#login_submit_btn").click();
            }
        });
    });
</script>

<body class="ui_charcoal login-page application navless" data-page="sessions:new">
<div class="page-wrap">

    <? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

    <? require_once VIEW_PATH . 'gitlab/common/body/header.php'; ?>

    <div class="container navless-container">
        <div class="content">
            <div class="flash-container flash-container-page">
            </div>

            <div class="row">
                <div class="col-sm-5 pull-right new-session-forms-container">
                    <div>
                        <ul class="nav-links new-session-tabs nav-tabs" role="tablist">
                            <li id="li-login" class="active" role="presentation">
                                <a data-toggle="tab" href="#login-pane" role="tab">欢迎您回来</a>
                            </li>
                            <li id="li-register" role="presentation">
                                <a data-toggle="tab" href="#register-pane" role="tab">注 册</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="login-box tab-pane active" id="login-pane" role="tabpanel">
                                <div class="login-body">
                                    <form class="new_user gl-show-field-errors" aria-live="assertive" id="new_user"
                                          action="<?= ROOT_URL ?>users/sign_in" accept-charset="UTF-8" method="post">
                                        <input name="utf8" type="hidden" value="&#x2713;"/>
                                        <input type="hidden" name="authenticity_token" value=""/>
                                        <div class="form-group">
                                            <label for="login">用户名或邮箱地址</label>
                                            <input class="form-control top" autofocus="autofocus" autocapitalize="off"
                                                   autocorrect="off"
                                                   required="required" title="This field is required." type="text"
                                                   name="username" id="user_login"
                                                   value=""
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label for="user_password">密 码</label>
                                            <input class="form-control bottom" required="required"
                                                   title="This field is required."
                                                   type="password" name="password" id="user_password" value=""/>
                                        </div>
                                        <?php if ($captcha_login_switch) { ?>
                                            <div class="form-group">
                                                <label for="user_password">验证码</label>
                                                <input class="form-control bottom" required="required"
                                                       title="This vcode is required."
                                                       type="text" name="vcode" id="user_vcode" value=""/>
                                            </div>
                                            <div>
                                                <img id="img_login_vcode"
                                                     src="<?= ROOT_URL ?>passport/output_captcha?mode=login&n=<?php echo rand(100, 999); ?>">
                                                <a id="refresh_login_vcode" href="javascript:void(0);">换一张</a>
                                            </div>
                                        <?php } ?>
                                        <div class="remember-me checkbox">
                                            <label for="user_remember_me">
                                                <input name="user[remember_me]" type="hidden" value="0"/>
                                                <input class="remember-me-checkbox" type="checkbox" value="1"
                                                       name="remember_me" id="user_remember_me"/>
                                                <span>记住账号</span>
                                            </label>
                                            <div class="pull-right forgot-password">
                                                <a href="<?= ROOT_URL ?>passport/find_password">找回密码</a>
                                            </div>
                                        </div>

                                        <div class="submit-container move-submit-down">
                                            <input type="button" id="login_submit_btn" name="login_submit_btn"
                                                   value="登 录" class="btn btn-save"/>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane login-box" id="register-pane" role="tabpanel">
                                <div class="login-body">
                                    <form class="new_new_user gl-show-field-errors" aria-live="assertive"
                                          id="new_new_user" action="/passport/register" accept-charset="UTF-8" method="post">

                                        <input name="utf8" type="hidden" value=""/>
                                        <input type="hidden" name="authenticity_token" value=""/>
                                        <div class="devise-errors">

                                        </div>
                                        <div class="form-group">
                                            <label for="new_display_name">显示名称</label>
                                            <input class="form-control top" required="required"
                                                   title="不能为空" type="text" name="display_name"
                                                   id="new_display_name"/>
                                            <p id="tip_error_display_name" class="gl-field-error hide"></p>
                                        </div>
                                        <div class="username form-group">
                                            <label for="new_user_username">用户名</label>
                                            <input class="form-control middle" pattern="[a-zA-Z0-9_\.][a-zA-Z0-9_\-\.]*[a-zA-Z0-9_\-]|[a-zA-Z0-9_]"
                                                   required="required" title="支持字母和数字."
                                                   type="text" name="username" id="username" value="" />
                                            <p id="tip_error_username" class="gl-field-error hide"></p>
                                            <p class="validation-success hide">用户名可用.</p>
                                            <p class="validation-pending hide">正在检查用户名是否可用...</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_user_email">邮箱地址</label>
                                            <input class="form-control middle" required="required"
                                                   title="请输入您的email地址"
                                                   type="email" value="" name="email" id="new_user_email"/>
                                            <p id="tip_error_email" class="gl-field-error hide"></p>
                                            <p id="tip_success_email" class="gl-field-error hide">email可用.</p>
                                            <p id="tip_pending_email" class="gl-field-error hide">正在检查email是否可用...</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_user_email_confirmation">邮箱地址确认</label>
                                            <input class="form-control middle" required="required"
                                                   title="请再次输入密码."
                                                   type="email" name="email_confirmation"
                                                   id="new_user_email_confirmation"/>
                                            <p id="tip_error_email_confirmation" class="gl-field-error hide"></p>
                                        </div>
                                        <div class="form-group append-bottom-20" id="password-strength">
                                            <label for="new_user_password">密码</label>
                                            <input class="form-control bottom" required="required" pattern=".{8,}"
                                                   title="Minimum length is 8 characters."
                                                   type="password" name="password" id="new_user_password"/>
                                            <p id="tip_error_password" class="gl-field-error hide"></p>
                                        </div>
                                        <?php if ($captcha_reg_switch) { ?>
                                            <div class="form-group">
                                                <label for="reg_vcode">验证码</label>
                                                <input class="form-control middle" required="required"
                                                       type="text" value="" name="vcode" id="reg_vcode"/>
                                                <p id="tip_error_vcode" class="gl-field-error hide"></p>
                                            </div>
                                            <div>
                                                <img id="img_reg_vcode"
                                                     src="<?= ROOT_URL ?>passport/output_captcha?mode=reg&n=<?php echo rand(100, 999); ?>">
                                                <a id="refresh_reg_vcode" href="javascript:void(0);">换一张</a>
                                            </div>
                                        <?php } ?>
                                        <div>
                                            <input type="button" id="register_submit_btn" name="register_submit_btn"
                                                   value="确 定" class="btn-register btn"/>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix submit-container hide">
                                    <p>
                                        <span class="light">没有收到确认邮件？</span>
                                        <a href="#">重新发送</a>.
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <? require_once VIEW_PATH . 'gitlab/common/body/brand-holder.php'; ?>


            </div>
        </div>
    </div>
    <hr class="footer-fixed">
    <? require_once VIEW_PATH . 'gitlab/common/body/footer.php'; ?>

</div>
</body>
</html>
