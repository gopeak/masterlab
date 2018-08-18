<?php
$page = 'ux';
?>
<!DOCTYPE html>
<!-- saved from url=(0058)https://antv.alipay.com/zh-cn/g2/3.x/tutorial/history.html -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <<title>MasterLab - 互联网项目、产品管理解决方案--里程碑</title>
    <link rel="icon" href="https://gw.alipayobjects.com/os/antv/assets/favoricon.png" type="image/x-icon">
    <link rel="stylesheet" href="./history_files/bootstrap.min.css">
    <link rel="stylesheet" href="./history_files/bootstrap-grid.min.css">
    <link rel="stylesheet" href="./history_files/font_470089_q8g1f7kwli.css">
    <link rel="stylesheet" href="./history_files/common-84eda.css">
    <link rel="stylesheet" href="./history_files/solarized-light.css">
    <link rel="stylesheet" href="./history_files/tocbot.css">
    <link rel="stylesheet" href="./history_files/doc-dda30.css">
    <link href="./favicon.ico" rel="shortcut icon" type="image/x-icon">

    <link href="./favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./product_files/index-1.css">
    <link rel="stylesheet" type="text/css" href="./product_files/index-2.css">
    <link rel="stylesheet" type="text/css" href="./product_files/featrue.css">

</head>
<body class="template-doc">
<div style="display: none">
    <img src="./history_files/logo-with-text.svg" alt=""> <img
            src="./history_files/bpKcpwimYnZMTarUxCEd.png" alt="">
</div>
<? include 'header.php' ?>

<div class="drawer-toggle"><span class="iconfont icon-menu-fold"></span></div>
<div class="drawer-overlay"></div>
<div class="doc-container container-fluid">
    <div class="row flex-xl-nowrap">
        <div class="menu bd-sidebar drawer">
            <div class="inner">
                <div class="filter-container"></div>
                <ul class="list-group">
                    <li class="list-group-item "><a href="./history.php">更新日志</a></li>
                    <li class="list-group-item "><a href="./milestone.php">里程碑</a></li>
                    <li class="list-group-item active"><a href="./todo.php">未来规划</a></li>
                </ul>
            </div>
        </div>
        <div class="main-container ant-col-xs-24 ant-col-sm-24 ant-col-md-18 ant-col-lg-19">
            <article class="markdown">
                <h2>一、第一个里程碑Todo</h2>

                <h3>1.1 事项功能点</h3>

                <ol><li>事项列表的复制，删除            √   </li><li>事项列表加入到 Backlog Sprint   √</li><li>事项列表，可以在右侧弹出详情</li><li>事项子任务                     √    </li><li>事项列表的搜索优化</li><li>事项详情的操作按钮功能(编辑 复制 自定义字段 关注 状态 解决结果 附件 删除)     √</li><li>事项的协作人               √</li></ol>

                <h3>1.2 项目功能点</h3>

                <ol><li>列表优化显示,参考 https://www.processon.com/diagrams/new#temp-system </li><li>项目设置</li></ol>

                <h3>1.3 敏捷功能点</h3>

                <ol><li>Backlog, Sprint, Kanban √</li><li>UI √</li><li>backlog和sprint 实现自定义排序 √</li></ol>

                <h3>1.4 系统</h3>

                <ol><li>系统中的各种设置项的应用(时间 公告 附件 UI)    1</li><li>备份和恢复 doing</li><li>导入                                          推迟</li><li>操作日志   3</li><li>错误日志   3</li><li>Sql慢查询日志                                 推迟</li><li>监听器                                        推迟</li><li>网络钩子                                      推迟</li></ol>

                <h3>1.5 服务程序</h3>

                <ol><li>服务器端</li><li>worker</li><li>client</li><li>定时执行 推迟</li></ol>

                <h3>1.6 其他</h3>

                <ol><li>权限控制的应用      1        </li><li>用户资料功能点      1</li><li>首页显示定义和实现   2  参考 https://www.talkingdata.com/spa/app-analytics/#/productCenter</li><li>动态的定义和显示    2</li><li>统一的语言(中文)   3</li><li>快捷键</li><li>使用帮助和提示     右下角帮助图标可参考 http://www.jq22.com/yanshi17798</li></ol>

                <h2>二、UI和交互改进</h2>

                <ol><li>事项弹出层滚动优化                      √</li><li>事项弹出层表单行间距调小                需要在后台的frame文档结构添加新class名</li><li>事项列表根据选项可直接右侧浮出详情</li><li>上传UI高度调小                         √</li></ol>

                <h3>全局</h3>

                <ol><li>logo(蝴蝶),包含动画类似gitlab的狐狸脑袋</li><li>Loading 动画, 无数据插画, 错误的友好提示</li></ol>

                <h3>事项模块</h3>

                <ol><li>事项弹出层滚动优化</li><li>事项弹出层表单行间距调小</li><li>事项列表根据选项可直接右侧浮出详情</li><li>事项表单上传组件高度调小</li><li>事项详情的主题和描述位置调整</li><li>事项详情的右侧面板，折叠后显示不一致</li><li>修复系统的界面设置不能拖拽</li></ol>

                <h3>敏捷模块</h3>

                <ol><li>Backlog页面左侧菜单UI美化</li><li>Backlog 页面的Sprint子面板增加描述UI</li><li>Backlog页面左侧面板取消滚动，而右侧事项列表要求滚动</li><li>左侧面板的Backlog和Closed可以将事项拖动进去</li><li>看板事项UI美化</li></ol>

                <h3>项目</h3>

                <ol><li>项目列表首页优化 </li><li>项目表单设计</li><li>非常好的UI和交互参考 https://preview.pro.ant.design/</li></ol>

                <h2>第二次里程碑Todo</h2>

                <ol><li>跟进不同角色有不通的 UI和交互</li><li>首页可以自定义面板</li><li>创建事项时,提供描述模板供用户选择</li><li>增加一个便签功能，类似 http://www.jq22.com/yanshi19271</li><li>使用Hopscotch进行友好提示 http://www.jq22.com/yanshi215</li><li>参考 hotjar 功能,网页热图、鼠标轨迹记录、转换漏斗(识别访问者离开)、表单分析、反馈调查、收集反馈、问卷、等</li><li>帮助界面参考 https://ned.im/noty/</li></ol>

            </article>
        </div>
    </div>
</div>
<footer class="navbar navbar-expand-lg bg-dark" style="display: none">
    <div class="container">
        <div class="navbar-collapse" id="navbarFooter">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="declaration" href="https://weibo.com/antv2017"><span
                                class="iconfont icon-sinaweibo"></span></a></li>
                <li class="nav-item"><a class="declaration" href="https://github.com/antvis/"><span
                                class="iconfont icon-github"></span></a></li>
                <li class="nav-item"><a class="declaration" href="https://antv.alipay.com/zh-cn/about.html">关于我们</a>
                </li>
            </ul>
            <a class="declaration" href="https://docs.alipay.com/policies/privacy/antfin">隐私权政策</a> <span>|</span> <a
                    class="declaration" href="https://render.alipay.com/p/f/fd-izto3cem/index.html">权益保障承诺书</a> <span>ICP 证浙 B2-2-100257 Copyright © 蚂蚁金融服务集团</span>
        </div>
    </div>
</footer>
<script type="text/javascript">/* eslint-disable */
    window.__meta = {
        "currentProduct": "g2",
        "assets": "/assets",
        "dist": "/assets/dist/3.0.0",
        "href": "/zh-cn/g2/3.x/tutorial/history.html",
        "locale": "zh-cn",
        "version": "3.0.0"
    };</script>
<script src="./history_files/lodash-4.17.4.min.js"></script>
<script src="./history_files/jquery-3.2.1.min.js"></script>
<script src="./history_files/jquery.autocomplete-1.4.3.min.js"></script>
<script src="./history_files/jquery.visible-1.2.0.min.js"></script>
<script src="./history_files/popper.min.js"></script>
<script src="./history_files/bootstrap.min.js"></script>
<script src="./history_files/lazyload-2.0.0-beta.2.min.js"></script>
<div id="___tracers" style="display:none">

</div>
<script src="./history_files/jquery.headroom-0.9.4.min.js"></script>
<script src="./history_files/clipboard-1.7.1.min.js"></script>
<script src="./history_files/tocbot.min.js"></script>
<script src="./history_files/doc-eda67.js"></script>
<script src="./history_files/common-729ed.js"></script>
<div class="autocomplete-suggestions"
     style="position: absolute; display: none; max-height: 300px; z-index: 9999;"></div>
<div class="autocomplete-suggestions"
     style="position: absolute; display: none; max-height: 300px; z-index: 9999;"></div>
</body>
</html>