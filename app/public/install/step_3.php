<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $html_title; ?></title>
    <link href="css/install.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.validation.min.js"></script>
    <script type="text/javascript" src="js/jquery.icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });

        $(function () {
            jQuery.validator.addMethod("lettersonly", function (value, element) {
                return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
            }, "不得含有特殊字符");
            $("#install_form").validate({
                errorElement: "font",
                rules: {
                    db_host: {required: true},
                    db_name: {required: true},
                    db_user: {required: true},
                    db_port: {required: true, digits: true},
                    site_name: {required: true},
                    linkman: {required: true},
                    phone: {required: true, digits: true },
                    email: {required: true, email: true },
                    admin: {required: true, lettersonly: true},
                    password: {required: true, minlength: 6},
                    rpassword: {required: true, equalTo: '#password'},
                }
            });

            jQuery.extend(jQuery.validator.messages, {
                required: "未输入",
                digits: "格式错误",
                lettersonly: "不得含有特殊字符",
                equalTo: "两次密码不一致",
                minlength: "密码至少6位"
            });

            $('#next').click(function () {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    async: true,
                    url: "./index.php?action=check_mysql_connect",
                    data: $('#install_form').serialize(),
                    success: function (resp) {
                        if(resp.ret!=200){
                            alert( resp.msg);
                        }else{
                            alert( "Mysql连接成功" );
                            $('#install_form').submit();
                        }
                    },
                    error: function (res) {
                        alert("网络错误:" + JSON.stringify(res));
                    }
                });
            });

        });
    </script>
</head>
<body>
<?php echo $html_header; ?>
<div class="main">
    <div class="step-box" id="step3">
        <div class="text-nav">
            <h1>Step.3</h1>
            <h2>创建数据库</h2>
            <h5>填写数据库及站点相关信息</h5>
        </div>
        <div class="procedure-nav">
            <div class="schedule-ico"><span class="a"></span><span class="b"></span><span class="c"></span><span
                        class="d"></span></div>
            <div class="schedule-point-now"><span class="a"></span><span class="b"></span><span class="c"></span><span
                        class="d"></span></div>
            <div class="schedule-point-bg"><span class="a"></span><span class="b"></span><span class="c"></span><span
                        class="d"></span></div>
            <div class="schedule-line-now"><em></em></div>
            <div class="schedule-line-bg"></div>
            <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">Redis和异步服务器配置</span><span
                        class="c">创建数据库</span><span class="d">安装</span></div>
        </div>
    </div>
    <form action="" id="install_form" method="post">
        <input type="hidden" value="submit" name="submitform">
        <input type="hidden" value="<?php echo $install_recover; ?>" name="install_recover">
        <input type="hidden" value="<?php echo $_POST['redis_host'] ? $_POST['redis_host'] : 'localhost'?>" name="redis_host">
        <input type="hidden" value="<?php echo $_POST['redis_port'] ? $_POST['redis_port'] : '6379'?>" name="redis_port">
        <input type="hidden" value="<?php echo $_POST['redis_password'] ? $_POST['redis_password'] : ''?>" name="redis_password">
        <input type="hidden" value="<?php echo $_POST['socket_host'] ? $_POST['socket_host'] : 'localhost'?>" name="socket_host">
        <input type="hidden" value="<?php echo $_POST['socket_port'] ? $_POST['socket_port'] : '9002'?>" name="socket_port">
        <input type="hidden" value="<?php echo $_POST['php_bin'] ? $_POST['php_bin'] : $php_bin?>" name="php_bin">
        <div class="form-box control-group">
            <fieldset>
                <legend>数据库信息</legend>
                <div>
                    <label>数据库服务器</label>
                    <span> <input type="text" name="db_host"  value="<?php echo $_POST['db_host'] ? $_POST['db_host'] : 'localhost'; ?>">
                    </span> <em>数据库服务器地址，一般为localhost</em>
                </div>
                <div>
                    <label>数据库名</label>
                    <span>
                        <input type="text" name="db_name"   value="<?php echo $_POST['db_name'] ? $_POST['db_name'] : 'masterlab'; ?>">
                    </span> <em></em>
                </div>
                <div>
                    <label>数据库用户名</label>
                    <span>
                        <input type="text" name="db_user"   value="<?php echo $_POST['db_user'] ? $_POST['db_user'] : 'root'; ?>">
                    </span> <em></em>
                </div>
                <div>
                    <label>数据库密码</label>
                    <span>
                        <input type="password" name="db_pwd"   value="<?php echo $_POST['db_pwd'] ? $_POST['db_pwd'] : ''; ?>">
                    </span> <em></em>
                </div>
                <div style="display: none">
                    <label>数据库表前缀</label>
                    <span>
                        <input type="text" name="db_prefix"   value="<?php echo $_POST['db_prefix'] ? $_POST['db_prefix'] : ''; ?>">
                    </span> <em>同一数据库运行多个程序时，请修改前缀</em>
                </div>
                <div>
                    <label>数据库端口</label>
                    <span>
                        <input type="text" name="db_port" maxlength="20" value="<?php echo $_POST['db_port'] ? $_POST['db_port'] : '3306'; ?>">
                    </span> <em>数据库默认端口一般为3306</em>
                </div>
                <?php if ($demo_data) { ?>
                    <div style="display: none">
                        <label>&nbsp;</label>
                        <input type="checkbox"
                               name="demo_data" <?php echo($_POST['demo_data'] == 1 ? 'checked' : 'checked'); ?>
                               id="demo_data"
                               value="1">
                        <h4>安装演示数据</h4>
                    </div>
                <?php } ?>
                <?php if ($install_error != '') { ?>
                    <div>
                        <label></label>
                        <font class="error"><?php echo $install_error; ?></font></div>
                <?php } ?>
            </fieldset>
            <fieldset>
                <legend>网站信息</legend>
                <div>
                    <label>公司名称</label>
                    <span>
                        <input name="site_name" value="<?php echo $_POST['site_name'] ? $_POST['site_name'] : '' ?>" maxlength="100" type="text">
                    </span> <em>输入公司名称</em>
                </div>
                <div>
                    <label>联系人</label>
                    <span>
                        <input name="linkman" id="linkman" value="<?php echo $_POST['linkman'] ? $_POST['linkman'] : '' ?>" maxlength="20"  type="text">
                    </span> <em></em>
                </div>
                <div>
                    <label>联系电话</label>
                    <span>
                        <input name="phone" id="phone"  value="<?php echo $_POST['phone'] ? $_POST['phone'] : '' ?>" maxlength="20"  type="text">
                    </span> <em></em>
                </div>
                <div>
                    <label>Email</label>
                    <span>
                        <input name="email" id="email"  value="<?php echo $_POST['email'] ? $_POST['email'] : '' ?>" maxlength="255"  type="text">
                    </span> <em>找回密码和登录账号</em>
                </div>
                <div>
                    <label>管理员账号</label>
                    <span>
                        <input name="admin"  id="admin"  readonly="readonly" value="<?php echo $_POST['admin'] ? $_POST['admin'] : 'master' ?>" maxlength="20"  type="text">
                    </span> <em></em>
                </div>
                <div>
                    <label>管理员密码</label>
                    <span>
                        <input name="password" id="password" maxlength="20"  value="<?php echo $_POST['password'] ? $_POST['password'] : '123456' ?>" type="password">
                    </span> <em>默认123456，管理员密码不少于6个字符</em>
                </div>
                <div>
                    <label>重复密码</label>
                    <span>
                        <input name="rpassword" value="<?php echo $_POST['rpassword'] ? $_POST['rpassword'] : '123456' ?>"   maxlength="20" type="password">
                    </span> <em>默认123456，确保两次输入的密码一致</em>
                </div>
            </fieldset>
        </div>
        <div class="btn-box"><a href="index.php?step=2" class="btn btn-primary">上一步</a>
            <a id="next" href="javascript:void(0);"  class="btn btn-primary">下一步</a>
        </div>
    </form>
</div>
<?php echo $html_footer; ?>
</body>
</html>
