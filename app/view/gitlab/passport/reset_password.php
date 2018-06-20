
<!DOCTYPE html>
<html class="devise-layout-html">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

</head>

<body class="ui_charcoal login-page application navless" data-page="passwords:edit">
<div class="page-wrap">

    <? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
    <? require_once VIEW_PATH.'gitlab/common/body/header.php';?>


    <div class="container navless-container">
        <div class="content">
            <div class="flash-container flash-container-page">
            </div>

            <div class="row">
                <div class="col-sm-5 pull-right new-session-forms-container">
                    <ul class="nav-links nav-tabs new-session-tabs single-tab">
                        <li class="active">
                            <a>Change your password</a>
                        </li>
                    </ul>

                    <div class="login-box">
                        <div class="login-body">
                            <form class="gl-show-field-errors" id="new_user" action="/passport/reset_password" accept-charset="UTF-8" method="post">
                                <input type="hidden" name="email" value="<?=$email?>" />
                                <input type="hidden" name="verify_code" value="<?=$verify_code?>" />
                                <div class="devise-errors">

                                </div>
                                <div class="form-group">
                                    <label for="password">New password</label>
                                    <input class="form-control top" required="required" title="This field is required" type="password" name="password" id="user_password" />
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm new password</label>
                                    <input class="form-control bottom" title="This field is required" required="required" type="password"
                                           name="password_confirmation" id="user_password_confirmation" />
                                </div>
                                <div class="clearfix">
                                    <input type="submit" name="commit" value="Change your password" class="btn btn-primary" />
                                </div>
                            </form></div>
                    </div>
                    <div class="clearfix prepend-top-20">
                        <p>
                            <span class="light">Didn't receive a confirmation email?</span>
                            <a href="<?=ROOT_URL?>users/confirmation/new">Request a new one</a>
                        </p>
                    </div>
                    <p>
                    <span class="light">
                    Already have login and password?
                    <a href="/passport/login">Sign in</a>
                    </span>
                    </p>


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
