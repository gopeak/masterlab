<script src="<?= ROOT_URL ?>gitlab/assets/webpack/runtime.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/common.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/main.bundle.min.js"></script>
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
<script>

    window.project_uploads_path = "/issue/main/upload";
    window.preview_markdown_path = "/issue/main/preview_markdown";
    
    $(function(){
    	// 通用快捷键 .addKeys 新增快捷键 .delKeys 解绑快捷键 参数: 数组
	    // m: 打开导航菜单
	    // h: 帮助
	    // s: 焦点搜索框
	    // r: 刷新
	    // n: 新增项目
    	keyMaster.addKeys([
    		{
    			key: 'm',
    			'trigger-element': '.global-dropdown-toggle',
    			trigger: 'click',
    		},
    		{
    			key: 'h',
    			'trigger-element': '#helper-btn',
    			trigger: 'click',
    		},
    		{
    			key: 's',
    			'trigger-element': '#search',
    			trigger: 'input',
    		},
    		{
    			key: 'r',
    			handle: function(){
    				location.reload()
    			}
    		}
    	])

    	// 解绑快捷键
    	// keyMaster.delKeys(['m'])
    })
    
</script>
