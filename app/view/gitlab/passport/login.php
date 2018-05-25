
<!DOCTYPE html>
<html class="devise-layout-html">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

</head>

<script type="text/javascript">
    $(document).ready(function(){
        $("#login_submit_btn").on("click", function(){
            $.ajax({
                type: "POST",
                async: false,
                dataType:'json',
                url: '/passport/do_login',
                data: $('#new_user').serialize(),
                success: function (resp) {

                     if( resp.ret==200){
                         window.location.href='/issue/main';
                     }else{
                         alert( resp.msg );
                     }
                },
                error: function (res) {
                    alert("请求数据错误:" + res.msg);
                }
            });
        });

        $("#register_submit_btn").on("click", function(){
            $.ajax({
                type: "POST",
                async: false,
                dataType:'json',
                url: '/passport/register',
                data: $('#new_new_user').serialize(),
                success: function (res) {
                    alert( res.msg );
                },
                error: function (res) {
                    alert("请求数据错误:" + res.msg);
                }
            });
        });
    });
</script>

<body class="ui_charcoal login-page application navless" data-page="sessions:new">
<div class="page-wrap">

    <? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

    <? require_once VIEW_PATH.'gitlab/common/body/header.php';?>



    <div class="container navless-container">
        <div class="content">
            <div class="flash-container flash-container-page">
            </div>

            <div class="row">
                <div class="col-sm-5 pull-right new-session-forms-container">
                    <div>
                        <ul class="nav-links new-session-tabs nav-tabs" role="tablist">
                            <li class="active" role="presentation">
                                <a data-toggle="tab" href="#login-pane" role="tab">Sign in</a>
                            </li>
                            <li role="presentation">
                                <a data-toggle="tab" href="#register-pane" role="tab">Register</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="login-box tab-pane active" id="login-pane" role="tabpanel">
                                <div class="login-body">
                                    <form class="new_user gl-show-field-errors" aria-live="assertive" id="new_user" action="/users/sign_in" accept-charset="UTF-8" method="post">
                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="authenticity_token" value="" />
                                        <div class="form-group">
                                            <label for="login">Username or email</label>
                                            <input class="form-control top" autofocus="autofocus" autocapitalize="off" autocorrect="off"
                                                   required="required" title="This field is required." type="text" name="username" id="user_login"
                                                   value="121642038@qq.com"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label for="user_password">Password</label>
                                            <input class="form-control bottom" required="required" title="This field is required."
                                                   type="password" name="password" id="user_password" value="testtest" />
                                        </div>
                                        <div class="remember-me checkbox">
                                            <label for="user_remember_me">
                                                <input name="user[remember_me]" type="hidden" value="0" />
                                                <input class="remember-me-checkbox"   type="checkbox" value="1" name="remember_me" id="user_remember_me" />
                                                <span>Remember me</span>
                                            </label>
                                            <div class="pull-right forgot-password">
                                                <a href="/passport/find_password">Forgot your password?</a>
                                            </div>
                                        </div>
                                        <?php if($captcha_login_switch) { ?>
                                        <div><img src="/passport/output_captcha?n=<?php echo rand(100, 999); ?>"></div>
                                        <?php }?>
                                        <div class="submit-container move-submit-down">
                                            <input type="button" id="login_submit_btn" name="login_submit_btn" value="Sign in" class="btn btn-save" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane login-box" id="register-pane" role="tabpanel">
                                <div class="login-body">
                                    <form class="new_new_user gl-show-field-errors" aria-live="assertive" id="new_new_user" action="/users" accept-charset="UTF-8" method="post">

                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="authenticity_token" value="" />
                                        <div class="devise-errors">

                                        </div>
                                        <div class="form-group">
                                            <label for="new_user_name">Full name</label>
                                            <input class="form-control top" required="required" title="This field is required." type="text" name="display_name" id="new_user_name" />
                                        </div>
                                        <div class="username form-group">
                                            <label for="new_user_username">Username</label>
                                            <input class="form-control middle" pattern="[a-zA-Z0-9_\.][a-zA-Z0-9_\-\.]*[a-zA-Z0-9_\-]|[a-zA-Z0-9_]"
                                                   required="required" title="Please create a username with only alphanumeric characters."
                                                   type="text" name="username" id="username" value="" />
                                            <p class="validation-error hide">Username is already taken.</p>
                                            <p class="validation-success hide">Username is available.</p>
                                            <p class="validation-pending hide">Checking username availability...</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_user_email">Email</label>
                                            <input class="form-control middle" required="required" title="Please provide a valid email address."
                                                   type="email" value="" name="email" id="new_user_email" />
                                        </div>
                                        <div class="form-group">
                                            <label for="new_user_email_confirmation">Email confirmation</label>
                                            <input class="form-control middle" required="required" title="Please retype the email address."
                                                   type="email" name="email_confirmation" id="new_user_email_confirmation" />
                                        </div>
                                        <div class="form-group append-bottom-20" id="password-strength">
                                            <label for="new_user_password">Password</label>
                                            <input class="form-control bottom" required="required" pattern=".{8,}" title="Minimum length is 8 characters."
                                                   type="password" name="password" id="new_user_password" />
                                            <p class="gl-field-hint">Minimum length is 8 characters</p>
                                        </div>
                                        <?php if($captcha_reg_switch) { ?>
                                            <div><img src="/passport/output_captcha?n=<?php echo rand(100, 999); ?>"></div>
                                        <?php }?>
                                        <div>
                                            <input type="button" id="register_submit_btn" name="register_submit_btn" value="Register" class="btn-register btn" />
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix submit-container">
                                    <p>
                                        <span class="light">Didn't receive a confirmation email?</span>
                                        <a href="#">Request a new one</a>.
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <? require_once VIEW_PATH.'gitlab/common/body/brand-holder.php';?>


            </div>
        </div>
    </div>
    <hr class="footer-fixed">
    <? require_once VIEW_PATH.'gitlab/common/body/footer.php';?>

</div>
</body>
</html>
