<!DOCTYPE html>
<!-- saved from url=(0034)https://mobile.ant.design/index-cn -->
<html class="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ant Design Mobile - 移动端设计规范</title>
    <link rel="icon" href="https://zos.alipayobjects.com/rmsportal/wIjMDnsrDoPPcIV.png" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="./product_files/index-1.css">
    <link rel="stylesheet" type="text/css" href="./product_files/index-2.css">
    <link rel="stylesheet" type="text/css" href="./product_files/featrue.css">

    <!--[if lte IE 10]>
    <script src="https://as.alipayobjects.com/g/component/??console-polyfill/0.2.2/index.js,es5-shim/4.5.7/es5-shim.min.js,es5-shim/4.5.7/es5-sham.min.js,html5shiv/3.7.2/html5shiv.min.js,media-match/2.0.2/media.match.min.js"></script>
    <![endif]-->
    <script async="" src="./product_files/analytics.js"></script>
    <script>
        if (!window.Intl) {
            document.writeln('<script src="https://as.alipayobjects.com/g/component/intl/1.0.1/??Intl.js,locale-data/jsonp/en.js,locale-data/jsonp/zh.js">' + '<' + '/script>');
        }
        if (!window.Promise) {
            document.writeln('<script src="https://as.alipayobjects.com/g/component/es6-promise/3.2.2/es6-promise.min.js"' + '>' + '<' + '/' + 'script>');
        }

        (function () {
            function checkIfMobile() {
                var ua = window.navigator.userAgent.toLowerCase();
                if (ua.indexOf('android') !== -1 || ua.indexOf('iphone') !== -1) {
                    return true;
                }
                return false;
            }

            function checkIfCn() {
                return window.navigator.language.toLowerCase() === 'zh-cn'; // wtf safari is 'zh-CN', while chrome and other is 'zh-CN'
            }

            if (checkIfMobile()) {
                var url = location.port ? 'http://127.0.0.1:8002/' : window.location.origin + '/kitchen-sink/';
                if (checkIfCn()) {
                    url = url + '?lang=zh-CN';
                } else {
                    url = url + '?lang=en-US';
                }
                //return location.href = url;
            }

            function isLocalStorageNameSupported() {
                const testKey = 'test';
                const storage = window.localStorage;
                try {
                    storage.setItem(testKey, '1');
                    storage.removeItem(testKey);
                    return true;
                } catch (error) {
                    return false;
                }
            }

            // 优先级提高到所有静态资源的前面，语言不对，加载其他静态资源没意义
            var pathname = location.pathname;

            function isZhCN(pathname) {
                return /-cn\/?$/.test(pathname);
            }

            function getLocalizedPathname(path, zhCN) {
                var pathname = path.startsWith('/') ? path : '/' + path;
                if (!zhCN) { // to enUS
                    return /\/?index-cn/.test(pathname) ? '/' : pathname.replace('-cn', '');
                } else if (pathname === '/') {
                    return '/index-cn';
                } else if (pathname.endsWith('/')) {
                    return pathname.replace(/\/$/, '-cn/');
                }
                return pathname + '-cn';
            }

            // 首页无视链接里面的语言设置 https://github.com/ant-design/ant-design/issues/4552
            if (isLocalStorageNameSupported() && (pathname === '/' || pathname === '/index-cn')) {
                var lang = (window.localStorage && localStorage.getItem('locale')) || (window.navigator.language.toLowerCase() === 'zh-cn' ? 'zh-CN' : 'en-US');
                if ((lang === 'zh-CN') !== isZhCN(pathname)) {
                    //location.pathname = getLocalizedPathname(pathname, lang === 'zh-CN');
                }
            }
            document.documentElement.className += isZhCN(pathname) ? 'zh-cn' : 'en-us';
        })()
    </script>

    <script type="text/javascript" charset="utf-8" async="" src="./product_files/introduce.zh-CN.md.js"></script>
</head>
<body>
<div id="react-content">
    <div data-reactroot="" class="page-wrapper">
        <header id="header" class="clearfix home-page-header">
            <div class="ant-row">
                <div class="ant-col-xs-24 ant-col-sm-24 ant-col-md-8 ant-col-lg-5 ant-col-xl-5 ant-col-xxl-4"><a
                            id="logo" href="./index.php"><img alt="logo"
                                                                                     src="./product_files/KDpgvguMpGfqaHPjicRK.svg"><span>Ant Design Mobile</span></a>
                </div>
                <div class="ant-col-xs-0 ant-col-sm-0 ant-col-md-16 ant-col-lg-19 ant-col-xl-19 ant-col-xxl-20">
                    <div id="search-box"><i class="anticon anticon-search"></i>
                        <div class="ant-select-show-search ant-select-auto-complete ant-select ant-select-combobox ant-select-enabled">
                            <div class="ant-select-selection
            ant-select-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                 aria-expanded="false">
                                <div class="ant-select-selection__rendered">
                                    <div unselectable="on" class="ant-select-selection__placeholder"
                                         style="display: block; user-select: none;">搜索组件...
                                    </div>
                                    <ul>
                                        <li class="ant-select-search ant-select-search--inline">
                                            <div class="ant-select-search__field__wrap hide"><input type="text" value=""
                                                                                                    class="ant-input ant-select-search__field"><span
                                                        class="ant-select-search__field__mirror">

                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <span class="ant-select-arrow" unselectable="on"
                                      style="user-select: none;"><b></b></span></div>
                        </div>
                    </div>
                    <button type="button" class="ant-btn header-lang-button ant-btn-sm ant-btn-background-ghost"><span>EN</span>
                    </button>
                    <div class="ant-select-sm version ant-select ant-select-enabled">
                        <div class="ant-select-selection
            ant-select-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true"
                             aria-expanded="false" tabindex="0">
                            <div class="ant-select-selection__rendered">
                                <div class="ant-select-selection-selected-value" title="2.2.3"
                                     style="display: block; opacity: 1;">2.2.3
                                </div>
                            </div>
                            <span class="ant-select-arrow" unselectable="on" style="user-select: none;"><b></b></span>
                        </div>
                    </div>
                    <ul class="ant-menu menu-site ant-menu-light ant-menu-root ant-menu-horizontal" id="nav"
                        role="menu">
                        <li class="ant-menu-item ant-menu-item-selected" role="menuitem"><a
                                    href="https://mobile.ant.design/index-cn"><span>首页</span></a></li>
                        <li class="ant-menu-item" role="menuitem"><a
                                    href="https://mobile.ant.design/docs/react/introduce-cn"><span>Web 组件</span></a>
                        </li>
                        <li class="ant-menu-item" role="menuitem"><a href="https://rn.mobile.ant.design/"><span>React Native 组件</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="main-wrapper">
            <section class="home-s1">
                <div class="banner-wrapper">
                    <div class="banner-text-wrapper"><h2>Ant Design Mobile</h2>
                        <p>一个基于 Preact / React / React Native 的 UI 组件库</p>
                        <div class="start-button"><a href="https://mobile.ant.design/docs/react/introduce-cn">
                                <button type="button" class="ant-btn ant-btn-primary ant-btn-lg"><span>开始探索</span>
                                </button>
                            </a>
                            <button type="button" class="ant-btn ant-btn-primary ant-btn-background-ghost">
                                <span>扫描演示</span></button>
                            <span class="github-btn"><a class="gh-btn"
                                                        href="https://github.com/ant-design/ant-design-mobile/"
                                                        target="_blank"><span class="gh-ico"
                                                                              aria-hidden="true"></span><span
                                            class="gh-text">Star</span></a><a class="gh-count" target="_blank"
                                                                              href="https://github.com/ant-design/ant-design-mobile/stargazers/"
                                                                              style="display: block;">5725</a></span>
                        </div>
                    </div>
                </div>
            </section>
            <section class="home-s2">
                <div class="wrapper"><h3>懂你所需</h3>
                    <div class="ant-row" style="margin-left: -36px; margin-right: -36px; margin-bottom: 80px;">
                        <div class="ant-col-12" style="padding-left: 36px; padding-right: 36px;"><img
                                    src="./product_files/KUmyjoMxFFbjEdjiIWOw.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 792 -->组件丰富 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 794 --> 功能全面<!-- /react-text --></div>
                                <p>提供了 40+ 基础组件、覆盖各类场景，组件特性丰富、满足各种功能需求。</p></div>
                        </div>
                        <div class="ant-col-12" style="padding-left: 36px; padding-right: 36px;"><img
                                    src="./product_files/hfFgCpcxpGjeAlXFFgyT.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 800 -->一步上手 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 802 --> 按需加载<!-- /react-text --></div>
                                <p>上手足够简单，既可以一次加载所有代码、也可以只加载用到的某几个组件的代码、避免冗余。</p></div>
                        </div>
                    </div>
                    <div class="ant-row" style="margin-left: -24px; margin-right: -24px;">
                        <div class="ant-col-12" style="padding-left: 24px; padding-right: 24px;"><img
                                    src="./product_files/nlUNcWIVLKoarLnWNaWS.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 809 -->体积小巧 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 811 --> 性能出众<!-- /react-text --></div>
                                <p>在不损失功能的基础上，尽量保证了单个组件的体积最小、性能最优。</p></div>
                        </div>
                        <div class="ant-col-12" style="padding-left: 24px; padding-right: 24px;"><img
                                    src="./product_files/JjNULDGGwgOZmsZAqvjH.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 817 -->简易定制 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 819 --> 多种风格<!-- /react-text --></div>
                                <p>支持灵活的样式定制，简易生成多种风格，满足个性化产品需求。</p></div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="home-page page1">
                <div class="home-page-wrapper" id="page1-wrapper">
                    <div class="page1-bg" style="transform: translate(0px, 527.227px);">Feature</div>
                    <h2>What can <span>Pro</span> do for you </h2>
                    <div class="title-line-wrapper page1-line">
                        <div class="title-line"></div>
                    </div>
                    <div>
                        <ul class="page1-box-wrapper">
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"><i class="point-0 left tween-one-entering"
                                                                        style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.4; transform: translate(-30px, -19.1044px);"></i><i
                                                class="point-0 right"
                                                style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.4; transform: translate(20px, -13.6993px);"></i><i
                                                class="point-ring"
                                                style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.4; transform: translate(-65px, 14.4687px);"></i><i
                                                class="point-1 tween-one-entering"
                                                style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.4; transform: translate(-45px, 81.2782px);"></i><i
                                                class="point-2 tween-one-entering"
                                                style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.4; transform: translate(35px, 5.07536px);"></i><i
                                                class="point-3 tween-one-entering"
                                                style="background: rgb(19, 194, 194); border-color: rgb(19, 194, 194); opacity: 0.2; transform: translate(50px, 49.9961px);"></i>
                                    </div>
                                    <div class="page1-image" style="box-shadow: rgba(19, 194, 194, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/VriUmzNjDnjoFoFFZvuh.svg"
                                             alt="img"></div>
                                    <h3>优雅美观</h3>
                                    <p>基于 Ant Design 体系精心设计</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"><i class="point-0 left"
                                                                        style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(-30px, -15.4624px);"></i><i
                                                class="point-0 right tween-one-entering"
                                                style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(20px, -23.4878px);"></i><i
                                                class="point-ring tween-one-entering"
                                                style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(-65px, 10.4063px);"></i><i
                                                class="point-1 tween-one-entering"
                                                style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(-45px, 70.8837px);"></i><i
                                                class="point-2"
                                                style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(35px, 3.58154px);"></i><i
                                                class="point-3 tween-one-entering"
                                                style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.2; transform: translate(50px, 58.9835px);"></i>
                                    </div>
                                    <div class="page1-image" style="box-shadow: rgba(47, 84, 235, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/smwQOoxCjXVbNAKMqvWk.svg"
                                             alt="img"></div>
                                    <h3>常见设计模式</h3>
                                    <p>提炼自中后台应用的典型页面和场景</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(245, 34, 45, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/hBbIHzUsSbSxrhoRFYzi.svg"
                                             alt="img"></div>
                                    <h3>最新技术栈</h3>
                                    <p>使用 React/dva/antd 等前端前沿技术开发</p></div>
                            </li>
                        </ul>
                        <ul class="page1-box-wrapper">
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(26, 196, 77, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/BISfzKcCNCYFmTYcUygW.svg"
                                             alt="img"></div>
                                    <h3>响应式</h3>
                                    <p>针对不同屏幕大小设计</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(250, 173, 20, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/XxqEexmShHOofjMYOCHi.svg"
                                             alt="img" style="margin-left: -15px;"></div>
                                    <h3>主题</h3>
                                    <p>可配置的主题满足多样化的品牌诉求</p></div>
                            </li>
                            <li>
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(114, 46, 209, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/JsixxWSViARJnQbAAPkI.svg"
                                             alt="img"></div>
                                    <h3>国际化</h3>
                                    <p>内建业界通用的国际化方案（敬请期待）</p></div>
                            </li>
                        </ul>
                        <ul class="page1-box-wrapper">
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(250, 140, 22, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/pbmKMSFpLurLALLNliUQ.svg"
                                             alt="img"></div>
                                    <h3>最佳实践</h3>
                                    <p>良好的工程实践助你持续产出高质量代码</p></div>
                            </li>
                            <li>
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(235, 45, 150, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/aLQyKyUyssIUhHTZqCIb.svg"
                                             alt="img"></div>
                                    <h3>Mock 数据</h3>
                                    <p>实用的本地数据调试方案</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(24, 144, 255, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/RpJIQitGbSCHwLMimybX.svg"
                                             alt="img"></div>
                                    <h3>UI 测试</h3>
                                    <p>自动化测试保障前端产品质量</p></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <section class="home-s4">
                <div class="wrapper"><h3>谁在使用</h3>
                    <div class="ant-row" style="margin-bottom: 48px;">
                        <div class="ant-col-8"><img src="./product_files/BGcxWbIWmgBlIChNOpqp.png" alt=""></div>
                        <div class="ant-col-8"><img src="./product_files/qTKmDWNtAZMaYarVLIZT.png" alt=""></div>
                        <div class="ant-col-8"><img src="./product_files/ARwKOjaDethbuHOfMWOW.png" alt=""></div>
                    </div>
                    <div class="ant-row">
                        <div class="ant-col-8"><img src="./product_files/HinWzLTHESDKjWqvqChF.png" alt=""></div>
                        <div class="ant-col-8"><img src="./product_files/MHkXUADpUDavOJfLrMpy.png" alt=""></div>
                        <div class="ant-col-8"><img src="./product_files/YEiMaxUWGRExNqYAwQhy.png" alt=""></div>
                    </div>
                </div>
            </section>
            <style>
                .main-wrapper {
                    padding: 0;
                }

                #header {
                    box-shadow: none;
                    width: 100%;
                }

                #header,
                #header .ant-select-selection,
                #header .ant-menu {
                    background: transparent;
                }
            </style>
        </div>
        <footer id="footer" class="dark">
            <div class="footer-wrap">
                <div class="ant-row">
                    <div class="ant-col-xs-24 ant-col-sm-24 ant-col-lg-6">
                        <div class="footer-center"><h2>Ant Design</h2>
                            <div><a target="_blank " rel="noopener noreferrer"
                                    href="https://github.com/ant-design/ant-design-mobile">Ant Design Mobile GitHub</a>
                            </div>
                            <div><a target="_blank " rel="noopener noreferrer"
                                    href="https://github.com/ant-design/ant-design-mobile-rn">Ant Design Mobile RN
                                    GitHub</a></div>
                            <div><a target="_blank " rel="noopener noreferrer" href="https://ant.design/">Ant Design</a>
                            </div>
                            <div><a target="_blank" rel="noopener noreferrer" href="https://pro.ant.design/">Ant Design
                                    Pro</a></div>
                            <div><a target="_blank" rel="noopener noreferrer" href="https://github.com/react-component">React
                                    Component GitHub</a></div>
                        </div>
                    </div>
                    <div class="ant-col-xs-24 ant-col-sm-24 ant-col-lg-6">
                        <div class="footer-center"><h2><span>相关站点</span></h2>
                            <div><a target="_blank" rel="noopener noreferrer" href="http://motion.ant.design/">Ant
                                    Motion</a><span> - </span><span>设计动效</span></div>
                            <div><a target="_blank" rel="noopener noreferrer" href="http://ux.ant.design/">Ant
                                    UX</a><span> - </span><span>页面逻辑素材</span></div>
                            <div><a target="_blank" rel="noopener noreferrer" href="http://library.ant.design/">AntD
                                    Library</a><span> - </span><span>Axure library</span></div>
                        </div>
                    </div>
                    <div class="ant-col-xs-24 ant-col-sm-24 ant-col-lg-6">
                        <div class="footer-center"><h2><span>社区</span></h2>
                            <div><a target="_blank" rel="noopener noreferrer"
                                    href="https://gitter.im/ant-design/ant-design"><span>在线讨论</span></a></div>
                            <div><a target="_blank" rel="noopener noreferrer"
                                    href="http://github.com/ant-design/ant-design-mobile/issues"><span>报告 Bug</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="ant-col-xs-24 ant-col-sm-24 ant-col-lg-6">
                        <div class="footer-center"><h2><img class="title-icon"
                                                            src="./product_files/nBVXkrFdWHxbZlmMbsaH.svg" alt=""><span>蚂蚁体验云</span>
                            </h2>
                            <div><a target="_blank " rel="noopener noreferrer" href="https://ant.design/">Ant Design</a><span> - </span><span>蚂蚁 UI 体系</span>
                            </div>
                            <div><a target="_blank" rel="noopener noreferrer"
                                    href="https://antv.alipay.com/">AntV</a><span> - </span><span>数据可视化</span></div>
                            <div><a target="_blank" rel="noopener noreferrer"
                                    href="https://eggjs.org/">Egg</a><span> - </span><span>企业级 Node 开发框架</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ant-row bottom-bar">
                <div class="ant-col-sm-24 ant-col-lg-4"></div>
                <div class="ant-col-sm-24 ant-col-lg-20"><span
                            style="line-height: 16px; padding-right: 12px; margin-right: 11px; border-right: 1px solid rgba(255, 255, 255, 0.55);"><a
                                href="https://docs.alipay.com/policies/privacy/antfin" rel="noopener noreferrer"
                                target="_blank"><span>隐私权政策</span></a></span><span style="margin-right: 24px;"><a
                                href="https://render.alipay.com/p/f/fd-izto3cem/index.html" rel="noopener noreferrer"
                                target="_blank"><span>权益保障承诺书</span></a></span><span style="margin-right: 12px;">ICP 证浙 B2-2-100257</span><span
                            style="margin-right: 12px;"><!-- react-text: 194 -->Copyright © <!-- /react-text --><span>蚂蚁金融服务集团</span></span>
                </div>
            </div>
        </footer>
    </div>
</div>


<script src="./product_files/saved_resource"></script>

<!-- react-router@3.0.5 -->
<script src="./product_files/cazbJtoQZXZDNurlPtJd.js"></script>

<!-- history@3.2.1 -->
<script src="./product_files/VnttsLkEQmyLDBBluBQq.js"></script>
<!-- babel-polyfill@6.20.0 -->
<script src="./product_files/wzWaWInUcXErDyTwvySY.js"></script>
<script src="./product_files/common.js"></script>
<script src="./product_files/index.js"></script>


</body>
</html>