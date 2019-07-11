<script src="<?= ROOT_URL ?>dev/vendor/get-browser-info.js"></script>
<?php
if (isset($is_login_page) && $is_login_page) {
?>
<script type="text/javascript">
    window.onload = function () {
            // var cookieFlag = getCookie('check_browser_flag');
            //if (typeof(cookieFlag) === 'undefined' || !cookieFlag) {
                var brName = getExploreName();
                //判断浏览器类型
                if (brName === 'IE' || brName === 'Edge' || brName === 'IE>=11' || brName === 'Unkonwn') {
                    window.location.href = '/dev/html/check_brower/index.html';
                }
            //}
     }
</script>
<? } ?>

<script src="<?= ROOT_URL ?>gitlab/assets/webpack/runtime.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/common.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/main.bundle.js?v=<?= $_version ?>"></script>
<script src="<?= ROOT_URL ?>dev/js/browser_info.js?v=<?= $_version ?>"></script>
<script src="<?= ROOT_URL ?>dev/lib/notify/bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- recoding -->

<!-- end -->
<script src="<?= ROOT_URL ?>dev/js/logo.js"></script>
<script src="<?= ROOT_URL ?>dev/js/function.helper.js?v=<?= $_version ?>"></script>
<script src="<?= ROOT_URL ?>dev/vendor/define-loading.js"></script>
<script src="<?= ROOT_URL ?>dev/vendor/define-status-html.js"></script>

<script src="<?= ROOT_URL ?>dev/vendor/key-master.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
<script>

    window.project_uploads_path = "/issue/main/upload";
    window.preview_markdown_path = "/issue/main/preview_markdown";

</script>
<script src="<?= ROOT_URL ?>dev/js/key_master.js?v=<?= $_version ?>"></script>
<!--script src="<?= ROOT_URL ?>dev/js/csrf.js?v=<?= $_version ?>"></script-->
<script>
    $(function () {
        function csrfSafeMethod(method) {
            // 匹配method的请求模式
            return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
        }

        $.ajaxSetup({
            beforeSend: function (xhr, settings) {
                if (!csrfSafeMethod(settings.type)) {
                    xhr.setRequestHeader("ML-CSRFToken", "<?= $csrf_token ?>");
                }

            }
        });

        /*ajax预处理缓存*/
        var ajaxRequestList = {};


        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            if (Object.prototype.toString.call(options.data) == "[object FormData]") {
                options.data.append("_csrftoken", "<?= $csrf_token ?>");
            } else if (Object.prototype.toString.call(options.data) == "[object String]") {
                if (Object.prototype.toString.call(originalOptions.data) == "[object Object]") {
                    options.data = $.param($.extend(originalOptions.data || {}, {
                        _csrftoken: "<?= $csrf_token ?>"
                    }));
                } else if (Object.prototype.toString.call(originalOptions.data) == "[object String]") {
                    options.data = options.data + "&_csrftoken=" + "<?= $csrf_token ?>";
                }
            }
            //console.log(options.headers);

            /*
                 判断唯一标识,同一个ajax只能同时存在一次
                 single(string): 唯一标识
                 mine(boolean): 如果ajax标识重复则用自身(true)还是原来的
                 once(boolean): 是否唯一，唯一(true)则只会请求成功一次
             */
            if (typeof originalOptions.single === 'string') {
                if (!ajaxRequestList[originalOptions.single]) {
                    ajaxRequestList[originalOptions.single] = jqXHR;
                    if (originalOptions.once === true) {
                        jqXHR.fail(function () {
                            delete ajaxRequestList[originalOptions.single];
                        });
                    } else {
                        jqXHR.always(function () {
                            delete ajaxRequestList[originalOptions.single];
                        });
                    }
                } else {
                    if (originalOptions.mine === true) {
                        ajaxRequestList[originalOptions.single].abort();
                    } else {
                        jqXHR.abort();
                    }
                }
            }


        });
    })
</script>
<input type="hidden" id="csrf_token" value="<?= $csrf_token ?>">
