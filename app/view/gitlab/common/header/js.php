<script>
    var browserInfo = function (userAgent) {
        var u = userAgent || navigator.userAgent;
        var self = this;
        var match = {
            //内核
            'Trident': u.indexOf('Trident') > 0 || u.indexOf('NET CLR') > 0,
            'Presto': u.indexOf('Presto') > 0,
            'WebKit': u.indexOf('AppleWebKit') > 0,
            'Gecko': u.indexOf('Gecko/') > 0,
            //浏览器
            'Safari': u.indexOf('Safari') > 0,
            'Chrome': u.indexOf('Chrome') > 0 || u.indexOf('CriOS') > 0,
            'IE': u.indexOf('MSIE') > 0 || u.indexOf('Trident') > 0,
            'Edge': u.indexOf('Edge') > 0,
            'Firefox': u.indexOf('Firefox') > 0,
            'Opera': u.indexOf('Opera') > 0 || u.indexOf('OPR') > 0,
            'Vivaldi': u.indexOf('Vivaldi') > 0,
            'UC': u.indexOf('UC') > 0 || u.indexOf(' UBrowser') > 0,
            'QQBrowser': u.indexOf('QQBrowser') > 0,
            'QQ': u.indexOf('QQ/') > 0,
            'Baidu': u.indexOf('Baidu') > 0 || u.indexOf('BIDUBrowser') > 0,
            'Maxthon': u.indexOf('Maxthon') > 0,
            'LBBROWSER': u.indexOf('LBBROWSER') > 0,
            '2345Explorer': u.indexOf('2345Explorer') > 0,
            'Sogou': u.indexOf('MetaSr') > 0 || u.indexOf('Sogou') > 0,
            'Wechat': u.indexOf('MicroMessenger') > 0,
            'Taobao': u.indexOf('AliApp(TB') > 0,
            'Alipay': u.indexOf('AliApp(AP') > 0,
            'Weibo': u.indexOf('Weibo') > 0,
            'Suning': u.indexOf('SNEBUY-APP') > 0,
            'iQiYi': u.indexOf('IqiyiApp') > 0,
            //操作系统平台
            'Windows': u.indexOf('Windows') > 0,
            'Linux': u.indexOf('Linux') > 0,
            'Mac': u.indexOf('Macintosh') > 0,
            'Android': u.indexOf('Android') > 0 || u.indexOf('Adr') > 0,
            'WP': u.indexOf('IEMobile') > 0,
            'BlackBerry': u.indexOf('BlackBerry') > 0 || u.indexOf('RIM') > 0 || u.indexOf('BB') > 0,
            'MeeGo': u.indexOf('MeeGo') > 0,
            'Symbian': u.indexOf('Symbian') > 0,
            'iOS': u.indexOf('like Mac OS X') > 0,
            //移动设备
            'Mobile': u.indexOf('Mobi') > 0 || u.indexOf('iPh') > 0 || u.indexOf('480') > 0,
            'Tablet': u.indexOf('Tablet') > 0 || u.indexOf('iPad') > 0 || u.indexOf('Nexus 7') > 0
        };
        if (match.Mobile) {
            match.Mobile = !(u.indexOf('iPad') > 0);
        }
        //基本信息
        var hash = {
            engine: ['WebKit', 'Trident', 'Gecko', 'Presto'],
            browser: ['Safari', 'Chrome', 'IE', 'Edge', 'Firefox', 'Opera', 'Vivaldi', 'UC', 'QQBrowser', 'QQ', 'Baidu', 'Maxthon', 'Sogou', 'LBBROWSER', '2345Explorer', 'Wechat', 'Taobao', 'Alipay', 'Weibo', 'Suning', 'iQiYi'],
            os: ['Windows', 'Linux', 'Mac', 'Android', 'iOS', 'WP', 'BlackBerry', 'MeeGo', 'Symbian'],
            device: ['Mobile', 'Tablet']
        };
        self.device = 'PC';
        self.language = (function () {
            var g = (navigator.browserLanguage || navigator.language);
            var arr = g.split('-');
            if (arr[1]) {
                arr[1] = arr[1].toUpperCase();
            }
            return arr.join('-');
        })();
        for (var s in hash) {
            for (var i = 0; i < hash[s].length; i++) {
                var value = hash[s][i];
                if (match[value]) {
                    self[s] = value;
                }
            }
        }
        //系统版本信息
        var osVersion = {
            'Windows': function () {
                var v = u.replace(/^.*Windows NT ([\d.]+);.*$/, '$1');
                var hash = {
                    '6.4': '10',
                    '6.3': '8.1',
                    '6.2': '8',
                    '6.1': '7',
                    '6.0': 'Vista',
                    '5.2': 'XP',
                    '5.1': 'XP',
                    '5.0': '2000'
                };
                return hash[v] || v;
            },
            'Android': function () {
                return u.replace(/^.*Android ([\d.]+);.*$/, '$1');
            },
            'iOS': function () {
                return u.replace(/^.*OS ([\d_]+) like.*$/, '$1').replace(/_/g, '.');
            },
            'Mac': function () {
                return u.replace(/^.*Mac OS X ([\d_]+).*$/, '$1').replace(/_/g, '.');
            }
        }
        self.osVersion = '';
        if (osVersion[self.os]) {
            self.osVersion = osVersion[self.os]();
        }
        //浏览器版本信息
        var version = {
            'Chrome': function () {
                return u.replace(/^.*Chrome\/([\d.]+).*$/, '$1');
            },
            'IE': function () {
                var v = u.replace(/^.*MSIE ([\d.]+).*$/, '$1');
                if (v == u) {
                    v = u.replace(/^.*rv:([\d.]+).*$/, '$1');
                }
                return v != u ? v : '';
            },
            'Edge': function () {
                return u.replace(/^.*Edge\/([\d.]+).*$/, '$1');
            },
            'Firefox': function () {
                return u.replace(/^.*Firefox\/([\d.]+).*$/, '$1');
            },
            'Safari': function () {
                return u.replace(/^.*Version\/([\d.]+).*$/, '$1');
            },
            'Opera': function () {
                return u.replace(/^.*Opera\/([\d.]+).*$/, '$1');
            },
            'Vivaldi': function () {
                return u.replace(/^.*Vivaldi\/([\d.]+).*$/, '$1');
            },
            'Maxthon': function () {
                return u.replace(/^.*Maxthon\/([\d.]+).*$/, '$1');
            },
            'QQBrowser': function () {
                return u.replace(/^.*QQBrowser\/([\d.]+).*$/, '$1');
            },
            'QQ': function () {
                return u.replace(/^.*QQ\/([\d.]+).*$/, '$1');
            },
            'Baidu': function () {
                return u.replace(/^.*BIDUBrowser[\s\/]([\d.]+).*$/, '$1');
            },
            'UC': function () {
                return u.replace(/^.*UC?Browser\/([\d.]+).*$/, '$1');
            },
            '2345Explorer': function () {
                return u.replace(/^.*2345Explorer\/([\d.]+).*$/, '$1');
            },
            'Wechat': function () {
                return u.replace(/^.*MicroMessenger\/([\d.]+).*$/, '$1');
            },
            'Taobao': function () {
                return u.replace(/^.*AliApp\(TB\/([\d.]+).*$/, '$1');
            },
            'Alipay': function () {
                return u.replace(/^.*AliApp\(AP\/([\d.]+).*$/, '$1');
            },
            'Weibo': function () {
                return u.replace(/^.*weibo__([\d.]+).*$/, '$1');
            },
            'Suning': function () {
                return u.replace(/^.*SNEBUY-APP([\d.]+).*$/, '$1');
            },
            'iQiYi': function () {
                return u.replace(/^.*IqiyiVersion\/([\d.]+).*$/, '$1');
            }
        };
        self.version = '';
        if (version[self.browser]) {
            self.version = version[self.browser]();
        }
    };
    var browserInfo = new browserInfo();
    if(browserInfo.engine == 'WebKit' || browserInfo.engine == 'Gecko'){

    }else{

        // alert('您的浏览器不能兼容Masterlab,请更换使用谷歌内核的浏览器!');
        var alertHtml = '<div class="alert alert-define alert-warning center" role="alert"><strong>提示！</strong>您的浏览器不能兼容Masterlab,请更换使用谷歌内核的浏览器!</div>'
         $('body').prepend(alertHtml)
        //alert(alertHtml);
    }
</script>

<script src="<?= ROOT_URL ?>gitlab/assets/webpack/runtime.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/common.bundle.js"></script>
<script src="<?= ROOT_URL ?>gitlab/assets/webpack/main.bundle.js?v=<?=$_version?>"></script>
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
            // 匹配method的请求模式
            return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
        }
        $.ajaxSetup({
            beforeSend:function (xhr, settings) {
                if(!csrfSafeMethod(settings.type)){
                    xhr.setRequestHeader("ML-CSRFToken", '<?= $csrf_token ?>');
                    //console.log(settings)
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
<input type="hidden" id="csrf_token" value="<?= $csrf_token ?>">
