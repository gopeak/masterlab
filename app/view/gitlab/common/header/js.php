<script src="<?= ROOT_URL ?>dev/js/browser_info.js?v=<?=$_version?>"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/runtime.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/common.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/main.bundle.js?v=<?=$_version?>"></script>
<script src="<?= ROOT_URL ?>dev/lib/notify/bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- recoding -->

<!-- end -->
<script src="<?= ROOT_URL ?>dev/js/logo.js"></script>
<script src="<?= ROOT_URL ?>dev/js/function.helper.js"></script>
<script src="<?= ROOT_URL ?>dev/vendor/define-loading.js"></script>
<script src="<?= ROOT_URL ?>dev/vendor/define-status-html.js"></script>
<script src="<?= ROOT_URL ?>dev/vendor/get-browser-info.js"></script>
<script src="<?= ROOT_URL ?>dev/vendor/key-master.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
<script>

    window.project_uploads_path = "/issue/main/upload";
    window.preview_markdown_path = "/issue/main/preview_markdown";

</script>
<script src="<?= ROOT_URL ?>dev/js/key_master.js?v=<?=$_version?>"></script>
<!--script src="<?= ROOT_URL ?>dev/js/csrf.js?v=<?=$_version?>"></script-->
<script>
    $(function(){
        function csrfSafeMethod(method) {
            // 匹配method的请求模式
            return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
        }
        $.ajaxSetup({
            beforeSend:function (xhr, settings) {
                if(!csrfSafeMethod(settings.type)){
                    xhr.setRequestHeader("ML-CSRFToken", "<?= $csrf_token ?>");
                }

            }
        });
        $.ajaxPrefilter( function(options, originalOptions, jqXHR){
            if(Object.prototype.toString.call(options.data) == "[object FormData]"){
                options.data.append("_csrftoken","<?= $csrf_token ?>");
            }else if(Object.prototype.toString.call(options.data) == "[object String]"){
                if(Object.prototype.toString.call(originalOptions.data) == "[object Object]"){
                    options.data = $.param($.extend(originalOptions.data||{}, {
                        _csrftoken: "<?= $csrf_token ?>"
                    }));
                }else if(Object.prototype.toString.call(originalOptions.data) == "[object String]"){
                    options.data = options.data+"&_csrftoken="+"<?= $csrf_token ?>";
                }
            }
            //console.log(options.headers);
        });
    })
</script>
<input type="hidden" id="csrf_token" value="<?=$csrf_token?>">
