
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
                            <a>重置密码</a>
                        </li>
                    </ul>

                    <div class="login-box">
                        <div class="login-body">
                            <form class="gl-show-field-errors" id="new_user" action="<?=ROOT_URL?>passport/reset_password" accept-charset="UTF-8" method="post">
                                <input type="hidden" name="email" value="<?=$email?>" />
                                <input type="hidden" name="verify_code" value="<?=$verify_code?>" />
                                <div class="devise-errors">

                                </div>
                                <div class="form-group">
                                    <label for="password">新密码</label>
                                    <input class="form-control top" required="required" title="This field is required" type="password" name="password" id="user_password" />
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">确认密码</label>
                                    <input class="form-control bottom" title="This field is required" required="required" type="password"
                                           name="password_confirmation" id="user_password_confirmation" />
                                </div>
                                <div class="clearfix">
                                    <input type="submit" name="commit" value="提交修改" class="btn btn-primary" />
                                </div>
                            </form></div>
                    </div>
                    <div class="clearfix prepend-top-20">

                    </div>
                    <p>
                    <span class="light">

                    <a href="<?=ROOT_URL?>passport/login">返回登录</a>
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
