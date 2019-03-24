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
                    dataType: "json",
                    async: true,
                    url: "./index.php?action=check_redis_connect",
                    data: $('#install_form').serialize(),
                    success: function (resp) {
                        if(resp.ret!=200){
                            alert( resp.msg);
                            return;
                        }else{
                            alert( "连接服务器成功" );
                            $('#install_form').submit();
                        }
                    },
                    error: function (res) {
                        alert("网络错误:" + res);
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
            <h2>Redis和异步服务器配置</h2>
            <h5 style="color: red">使用Redis和异步服务将极大提高Masterlab的性能</h5>
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
            <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">Redis和异步服务器配置</span><span class="c">创建数据库</span><span
                        class="d">安装</span></div>
        </div>
    </div>
    <form method="post" id="install_form" action="index.php?step=3">
        <input type="hidden" value="3" name="step">

        <div class="form-box control-group">
            <fieldset>
                <legend>Redis服务器</legend>
                <div>
                    <span>快速读取数据而不需要访问数据库</span>
                </div>
                <div>
                    <label>服务器地址</label>
                    <span>
                        <input type="text" name="redis_host"
                               value="<?php echo $_POST['redis_host'] ? $_POST['redis_host'] : '127.0.0.1'; ?>">
                  </span> <em>一般为  127.0.0.1</em>
                </div>

                <div>
                    <label>Redis端口</label>
                    <span>
                    <input type="text" name="redis_port" maxlength="20"
                           value="<?php echo $_POST['redis_port'] ? $_POST['redis_port'] : '6379'; ?>">
                  </span> <em>默认端口一般为 6379</em>
                </div>

                <div>
                    <label>密码</label>
                    <span>
                    <input type="text" name="redis_password" maxlength="40"
                           value="<?php echo $_POST['redis_password'] ? $_POST['redis_password'] : ''; ?>">
                    </span> <em>如果有密码请填写</em>
                </div>
                <div>
                    <label></label>
                    <span> </span>
                </div>
            </fieldset>
            <fieldset>
                <legend>MasterlabSocket服务器</legend>
                <div>
                    <span>用于实时数据通信以及执行任务和异步发送邮件</span>
                </div>
                <div>
                    <label>服务器地址</label>
                    <span>
                        <input type="text" name="socket_host"
                               value="<?php echo $_POST['socket_host'] ? $_POST['socket_host'] : '127.0.0.1'; ?>">
                  </span> <em>一般为  127.0.0.1</em>
                </div>

                <div>
                    <label>端口</label>
                    <span>
                    <input type="text" name="socket_port" maxlength="20"
                           value="<?php echo $_POST['socket_port'] ? $_POST['socket_port'] : '9002'; ?>">
                  </span> <em>默认端口为 9002</em>
                </div>
                <div>
                    <label>PHP命令行程序路径</label>
                    <span>
                    <input type="text" name="php_bin"
                           value="<?php echo $_POST['php_bin'] ? $_POST['php_bin'] : $php_bin; ?>">
                  </span> <em> <?php  if(!$fetch_php_bin_ret){ echo '注意：获取php执行程序路径失败,请手动设置';}?></em>
                </div>
            </fieldset>
        </div>

        <div class="btn-box">
            <a href="index.php?step=1" class="btn btn-primary">上一步</a>
            <a id="next"   href="javascript:void(0);"   class="btn btn-primary">下一步</a>
        </div>
    </form>
</div>
<?php ECHO $html_footer; ?>
</body>
</html>
