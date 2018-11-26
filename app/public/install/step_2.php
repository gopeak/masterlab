<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $html_title; ?></title>
    <link href="css/install.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery.icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input[type="radio"]').on('ifChecked', function (event) {
                if (this.id == 'radio-0') {
                    $('.select-module').show();
                } else {
                    $('.select-module').hide();
                }
            }).iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
            $('#next').click(function () {
                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    url: 'index.php?action=check_mysql',
                    data: $('#install_form').serialize(),
                    success: function (resp) {
                        if (resp.ret == 200) {
                            $('#install_form').submit();
                        } else {
                            alert(resp.msg);
                        }
                    },
                    error: function (resp) {
                        alert(resp);
                    }
                });

            });
        });
    </script>
</head>

<body>
<?php ECHO $html_header; ?>
<div class="main">
    <div class="step-box" id="step2">
        <div class="text-nav">
            <h1>Step.2</h1>
            <h2>选择安装方式</h2>
            <h5>根据需要选择系统模块完全或手动安装</h5>
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
            <div class="schedule-text"><span class="a">检查安装环境</span><span class="c">创建数据库</span><span
                        class="b">系统设置</span><span class="d">安装</span></div>
        </div>
    </div>
    <form method="get" id="install_form" action="index.php">
        <input type="hidden" value="3" name="step">
        <input type="hidden" value="submit" name="submitform">
        <input type="hidden" value="<?php echo $install_recover; ?>" name="install_recover">
        <div class="form-box control-group">
            <fieldset>
                <legend>数据库信息</legend>
                <div>
                    <label>数据库服务器</label>
                    <span>
          <input type="text" name="db_host" maxlength="20"
                 value="<?php echo $_POST['db_host'] ? $_POST['db_host'] : 'localhost'; ?>">
          </span> <em>数据库服务器地址，一般为localhost</em></div>
                <div>
                    <label>数据库名</label>
                    <span>
          <input type="text" name="db_name" maxlength="40"
                 value="<?php echo $_POST['db_name'] ? $_POST['db_name'] : 'masterlab'; ?>">
          </span> <em></em></div>
                <div>
                    <label>数据库用户名</label>
                    <span>
          <input type="text" name="db_user" maxlength="20"
                 value="<?php echo $_POST['db_user'] ? $_POST['db_user'] : ''; ?>">
          </span> <em></em></div>
                <div>
                    <label>数据库密码</label>
                    <span>
          <input type="password" name="db_pwd" maxlength="20"
                 value="<?php echo $_POST['db_pwd'] ? $_POST['db_pwd'] : ''; ?>">
          </span> <em></em></div>

                <div>
                    <label>数据库端口</label>
                    <span>
          <input type="text" name="db_port" maxlength="20"
                 value="<?php echo $_POST['db_port'] ? $_POST['db_port'] : '3306'; ?>">
          </span> <em>数据库默认端口一般为3306</em></div>
                <?php if ($demo_data) { ?>
                    <div>
                        <label>&nbsp;</label>
                        <input type="checkbox"
                               name="demo_data" <?php echo($_POST['demo_data'] == 1 ? 'checked' : ''); ?> id="demo_data"
                               value="1">
                        <h4>安装演示数据</h4></div>
                <?php } ?>
                <?php if ($install_error != '') { ?>
                    <div>
                        <label></label>
                        <font class="error"><?php echo $install_error; ?></font></div>
                <?php } ?>
            </fieldset>
        </div>
        <div class="btn-box"><a href="index.php?step=1" class="btn btn-primary">上一步</a><a id="next"
                                                                                          href="javascript:void(0);"
                                                                                          class="btn btn-primary">下一步</a>
        </div>
    </form>
</div>
<?php ECHO $html_footer; ?>
</body>
</html>
