<!DOCTYPE html>
<html class="devise-layout-html">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

</head>

<body class="ui_charcoal login-page application navless" data-page="passwords:new">
<div class="page-wrap">

    <? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
    <? require_once VIEW_PATH.'gitlab/common/body/header.php';?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#commit").on("click", function(){
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType:'json',
                    url: '/passport/send_find_password_email',
                    data: $('#new_user').serialize(),
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

    <div class="container navless-container">
        <div class="content">
            <div class="flash-container flash-container-page">
            </div>

            <div class="row">
                <div class="col-sm-5 pull-right new-session-forms-container">
                    <ul class="nav-links nav-tabs new-session-tabs single-tab">
                        <li class="active">
                            <a>Reset Password</a>
                        </li>
                    </ul>

                    <div class="login-box">
                        <div class="login-body">
                            <form class="gl-show-field-errors" id="new_user" action="/users/password" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="" />
                                <div class="devise-errors">

                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input class="form-control" required="required" autofocus="autofocus" title="Please provide a valid email address."
                                           type="email" name="email" id="user_email" />
                                </div>
                                <div class="clearfix">
                                    <input type="button" id="commit" name="commit" value="Reset password" class="btn-primary btn" />
                                </div>
                            </form></div>
                    </div>
                    <div class="clearfix prepend-top-20">
                        <p>
                            <span class="light">
                            Already have login and password?
                            <a href="/passport/login">Sign in</a>
                            </span>
                        </p>

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
