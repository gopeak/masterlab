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
                            alert( "Redis连接成功" );
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
            <h2>Redis服务器配置</h2>
            <h5>使用Redis服务将极大提高Masterlab的性能</h5>
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
            <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">Redis服务器配置</span><span class="c">创建数据库</span><span
                        class="d">安装</span></div>
        </div>
    </div>
    <form method="post" id="install_form" action="index.php?step=3">
        <input type="hidden" value="3" name="step">

        <div class="form-box control-group">
            <fieldset>
                <legend>Redis服务器</legend>
                <div>
                    <label>服务器</label>
                    <span>
                        <input type="text" name="redis_host" maxlength="20"
                               value="<?php echo $_POST['redis_host'] ? $_POST['redis_host'] : '127.0.0.1'; ?>">
                  </span> <em>服务器地址，一般为localhost</em>
                </div>

                <div>
                    <label>Redis端口</label>
                    <span>
                    <input type="text" name="redis_port" maxlength="20"
                           value="<?php echo $_POST['redis_port'] ? $_POST['redis_port'] : '6379'; ?>">
                  </span> <em>默认端口一般为 6379</em>
                </div>

                <div>
                    <label>数据库名</label>
                    <span>
                    <input type="text" name="redis_dbname" maxlength="40"
                           value="<?php echo $_POST['redis_dbname'] ? $_POST['redis_dbname'] : 'masterlab'; ?>">
                    </span> <em></em>
                </div>


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
