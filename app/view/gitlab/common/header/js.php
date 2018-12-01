<script src="<?= ROOT_URL ?>gitlab/assets/webpack/runtime.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/common.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/main.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/notify/bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- recoding -->

<!--<script src="--><?//= ROOT_URL ?><!--recoding/lib/jquery.min.js"></script>-->
<!--<script src="--><?//= ROOT_URL ?><!--recoding/lib/bootstrap.min.js"></script>-->
<!--<script src="--><?//= ROOT_URL ?><!--recoding/components/tooltip.js"></script>-->
<!--<script>-->
<!--	    $(function () {-->
<!--			$('[data-toggle="tooltip"]').tooltip()-->
<!--		})-->
<!--</script>-->
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
    
    $(function(){
        moment().format()
    	// 通用快捷键 .addKeys 新增快捷键 .delKeys 解绑快捷键 参数: 数组
	    // m: 打开导航菜单
	    // h: 帮助
	    // s: 焦点搜索框
	    // r: 刷新
	    // c: 创建
	    // ctrl+enter: 提交
    	keyMaster.addKeys([
    		{
    			key: 'm',
    			'trigger-element': '.js-key-nav',
    			trigger: 'click'
    		},
    		{
    			key: 'h',
    			'trigger-element': '.js-key-help',
    			trigger: 'click'
    		},
    		{
    			key: 's',
    			'trigger-element': '.js-key-search',
    			trigger: 'input'
    		},
    		{
    			key: 'r',
    			handle: function(){
    				location.reload()
    			}
    		},
    		{
    			key: 'c',
    			'trigger-element': '.js-key-create',
    			trigger: 'click'
    		},
    		{
    			key: ['command+enter', 'ctrl+enter'],
    			'trigger-element': '.js-key-enter',
    			trigger: 'click'
    		},
    		{
    			key: 'b',
    			'trigger-element': '.js-key-back',
    			trigger: 'click'
    		}
    	])

    	// 监听所有modal，关闭后解绑提交快捷键
    	$('*').on('hidden.bs.modal', function (e) {
    	    keyMaster.delKeys(['command+enter', 'ctrl+enter', 'esc'])
    	})

        

    	// 解绑快捷键
    	// keyMaster.delKeys(['m', 'h'])

        function csrfSafeMethod(method) {
            // 匹配method的请求模式，js正则匹配用test
            return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
        }
        $.ajaxSetup({
            beforeSend:function (xhr, settings) {
                if(!csrfSafeMethod(settings.type)){
                    xhr.setRequestHeader("ML-CSRFToken", '<?= $csrf_token ?>');
                    console.log(settings)
                }

            }
        });
    })
    
</script>
