<?php
$page = 'product';
?>
<!DOCTYPE html>
<!-- saved from url=(0034)https://mobile.ant.design/index-cn -->
<html class="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterLab - 互联网项目、产品管理解决方案--产品介绍</title>
    <link href="./favicon.ico" rel="shortcut icon" type="image/x-icon">
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

        <? include 'header.php'?>

        <div class="main-wrapper">
            <section class="home-s1">
                <div class="banner-wrapper">
                    <div class="banner-text-wrapper" style=" width: 54%;
                                max-width: 560px;
                                min-width: 420px;
                                min-height: 336px;
                                color: #0d1a26;">
                        <h2>MasterLab</h2>

                        <p style="opacity: 1; transform: translate(0px, 0px);font-size: 20px; line-height: 40px; color: #314659;" class="">
                            <span>
                                基于事项驱动和敏捷开发的项目管理工具;将工程技术之道和艺术设计之美融合一身，在网页、桌面、移动环境都打造出众的体验，让团队协作焕发无限可能。
                                </span>
                        </p>
                        <div class="start-button"><a href="http://wx.888zb.com" target="_blank">
                                <button type="button" class="ant-btn ant-btn-primary ant-btn-lg"><span>开始体验</span>
                                </button>
                            </a>
                            <a href="./help.php" >
                                <button type="button" class="ant-btn ant-btn-primary ant-btn-background-ghost">
                                    <span>用户手册</span></button>
                            </a>
                            <span class="github-btn"><a class="gh-btn"
                                                        href="https://github.com/gopeak/masterlab/"
                                                        target="_blank"><span class="gh-ico"
                                                                              aria-hidden="true"></span><span
                                            class="gh-text">github</span></a></span>
                        </div>
                    </div>
                </div>
            </section>
            <section class="home-s2">
                <div class="wrapper"><h3>产品特点</h3>
                    <div class="ant-row" style="margin-left: -36px; margin-right: -36px; margin-bottom: 80px;">
                        <div class="ant-col-12" style="padding-left: 36px; padding-right: 36px;"><img
                                    src="./product_files/KUmyjoMxFFbjEdjiIWOw.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 792 -->基于事项驱动 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 794 --> 功能全面<!-- /react-text --></div>
                                <p>跟踪bug，新功能，任务，优化改进等,提交团队协作效率</p></div>
                        </div>
                        <div class="ant-col-12" style="padding-left: 36px; padding-right: 36px;"><img
                                    src="./product_files/hfFgCpcxpGjeAlXFFgyT.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 800 -->开源 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 802 --> 免费<!-- /react-text --></div>
                                <p>基于开源技术，回报社区。最新技术栈
                                    使用 PHP7/Go/React/Vue/Antd 等前沿技术开发</p></div>
                        </div>
                    </div>
                    <div class="ant-row" style="margin-left: -24px; margin-right: -24px;">
                        <div class="ant-col-12" style="padding-left: 24px; padding-right: 24px;"><img
                                    src="./product_files/nlUNcWIVLKoarLnWNaWS.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 809 -->敏捷开发 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 811 --> Devops<!-- /react-text --></div>
                                <p>从需求构思到代码落地，将先进理论融入全套流程，为你提供最优秀的敏捷开发实践，将团队协作提升至全新的标准。</p></div>
                        </div>
                        <div class="ant-col-12" style="padding-left: 24px; padding-right: 24px;"><img
                                    src="./product_files/JjNULDGGwgOZmsZAqvjH.png" alt="">
                            <div class="des">
                                <div><!-- react-text: 817 -->简单易用 <!-- /react-text --><span class="divider"></span>
                                    <!-- react-text: 819 --> 二次开发<!-- /react-text --></div>
                                <p>注重用户交互，扁平化风格，使用bootsrap和gitlab设计规范。</p></div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="home-page page1">
                <div class="home-page-wrapper" id="page1-wrapper">
                    <div class="page1-bg" style="transform: translate(0px, 527.227px);">Feature</div>
                    <h2>功能点</h2>
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
                                    <h3>多产品(组织)</h3>
                                    <p>众多项目进行分组分类,便于管理</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper">
                                        <i class="point-0 left"   style="background: rgb(47, 84, 235); border-color: rgb(47, 84, 235); opacity: 0.4; transform: translate(-30px, -15.4624px);"></i>
                                        <i
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
                                    <h3>基于项目</h3>
                                    <p style="    width: 220px;">「项目」是 Masterlab 的基本单位， 新建一个项目，邀请相关成员加入，你们就可以借助各类应用来共同实现产品目标了。</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(245, 34, 45, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/hBbIHzUsSbSxrhoRFYzi.svg"
                                             alt="img"></div>
                                    <h3>事项驱动</h3>
                                    <p>将事项划分为 Bug、新功能、任务、优化改进、用户故事、技术任务、史诗任务，也可以进行新增自己的事项类型</p></div>
                            </li>
                        </ul>
                        <ul class="page1-box-wrapper">
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(26, 196, 77, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/BISfzKcCNCYFmTYcUygW.svg"
                                             alt="img"></div>
                                    <h3>统计图表</h3>
                                    <p>直观和实时可视化呈现，化繁为简，快速而准确决策</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(250, 173, 20, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/XxqEexmShHOofjMYOCHi.svg"
                                             alt="img" style="margin-left: -15px;"></div>
                                    <h3>自定义事项UI</h3>
                                    <p>每个事项类型均有预定义的表单配置方案，可以自定意配置事项的表单</p></div>
                            </li>
                            <li>
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(114, 46, 209, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/JsixxWSViARJnQbAAPkI.svg"
                                             alt="img"></div>
                                    <h3>工作流</h3>
                                    <p>支持自定义任务状态和流转动作</p></div>
                            </li>
                        </ul>
                        <ul class="page1-box-wrapper">
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(250, 140, 22, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/pbmKMSFpLurLALLNliUQ.svg"
                                             alt="img"></div>
                                    <h3>迭代开发</h3>
                                    <p>将需求分配到对应的迭代，支持多迭代并行开发。</p></div>
                            </li>
                            <li>
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(235, 45, 150, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/aLQyKyUyssIUhHTZqCIb.svg"
                                             alt="img"></div>
                                    <h3>看板视图</h3>
                                    <p>支持看板视图，帮助团队快速同步信息、沟通进度。</p></div>
                            </li>
                            <li class="" style="opacity: 1; transform: translate(0px, 0px);">
                                <div class="page1-box">
                                    <div class="page1-point-wrapper"></div>
                                    <div class="page1-image" style="box-shadow: rgba(24, 144, 255, 0.12) 0px 6px 12px;">
                                        <img src="https://gw.alipayobjects.com/zos/rmsportal/RpJIQitGbSCHwLMimybX.svg"
                                             alt="img"></div>
                                    <h3>自动化测试</h3>
                                    <p>自动化测试保障产品质量</p></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <section class="home-s4" style="display: none">
                <div class="wrapper"><h3>谁在使用</h3>
                    <div class="ant-row" style="margin-bottom: 48px;">
                        <div class="ant-col-8">Ismond</div>
                        <div class="ant-col-8">爱不离手</div>
                        <div class="ant-col-8">心动游戏</div>
                    </div>
                    <div class="ant-row">
                        <div class="ant-col-8">蝴蝶互动</div>
                        <div class="ant-col-8">YY直播</div>
                        <div class="ant-col-8">昆仑万维</div>
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
        <? include 'footer.php'?>
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