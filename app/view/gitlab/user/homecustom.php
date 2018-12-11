<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css" rel="stylesheet" type="text/css"/>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

</head>
<body class="dashboard" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<style type="text/css">
    #layout-dialog .dialog-panel-body{padding:10px 0 10px 16px;}
    #layout-dialog p{margin:0 0 1em 0;text-align:left;}
    #layout-dialog ul{margin:0;padding:0;}
    #layout-dialog ul li{list-style-type:none;margin:0;padding:0;}
    #layout-dialog ul li a,#layout-dialog ul li a:link,#layout-dialog ul li a:visited{border:1px solid #bbb;display:block;float:left;margin:0 1em 1em 0;outline:none;padding:.35em;width:auto;}#layout-dialog ul li a:hover,#layout-dialog ul li a:active,#layout-dialog ul li a:focus{border-color:#666;}#layout-dialog ul li a strong{background:#fff url('/gitlab/images/sprite-layouts.png') no-repeat 0 0;cursor:pointer;display:block;float:left;height:37px;text-indent:-9999px;width:68px;}ul li a#layout-a strong{background-position:0 0;}ul li a#layout-aa strong{background-position:0 -41px;}ul li a#layout-ba strong{background-position:0 -82px;}ul li a#layout-ab strong{background-position:0 -123px;}ul li a#layout-aaa strong{background-position:0 -163px;}.layout-a ul li #layout-a strong,#layout-dialog #layout-a:hover strong,#layout-dialog #layout-a:active strong,#layout-dialog #layout-a:focus strong{background-position:-72px -1px;}.layout-aa ul li #layout-aa strong,#layout-dialog #layout-aa:hover strong,#layout-dialog #layout-aa:active strong,#layout-dialog #layout-aa:focus strong{background-position:-72px -41px;}.layout-ba #layout-ba strong,#layout-dialog #layout-ba:hover strong,#layout-dialog #layout-ba:active strong,#layout-dialog #layout-ba:focus strong{background-position:-72px -82px;}.layout-ab #layout-ab strong,#layout-dialog #layout-ab:hover strong,#layout-dialog #layout-ab:active strong,#layout-dialog #layout-ab:focus strong{background-position:-72px -122px;}.layout-aaa #layout-aaa strong,#layout-dialog #layout-aaa:hover strong,#layout-dialog #layout-aaa:active strong,#layout-dialog #layout-aaa:focus strong{background-position:-72px -163px;}.layout-a ul li a#layout-a,.layout-aa ul li a#layout-aa,.layout-ba ul li a#layout-ba,.layout-ab ul li a#layout-ab,.layout-aaa ul li a#layout-aaa{background-color:#eee;border-color:#666;}
</style>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

        <script>
            var findFileURL = "";
        </script>
        <div class="page-with-sidebar">

            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">

                    <div class="flash-container flash-container-page">
                    </div>

                </div>

                <div class="content padding-0" id="content-body1">
                    <div class="cover-block user-cover-block">
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <?php
                            $profile_nav='custom_index';
                            include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="nav-controls">
                        <div class="btn-group" role="group">
                            <a class="btn btn-new btn_issue_type_add js-key-create" data-target="#modal-issue_type_add" data-toggle="modal" href="#modal-issue_type_add">
                                <i class="fa fa-plus"></i>
                                添加小工具
                            </a>
                            <a class="btn btn-new btn_issue_type_add js-key-create" data-target="#modal-layout" data-toggle="modal" href="#modal-layout">
                                <i class="fa fa-plus"></i>
                                版式布局
                            </a>
                        </div>
                    </div>


                </div>

                <div class="content container-fluid" id="content-body">
                    <div id="multi" class="container row" style="box-sizing: border-box;display: block;margin: 0;position: relative;vertical-align: top;">
                        <div class="col-md-12 group_panel" id="module_list" style="display:flex;flex-direction:row;flex:0 1 100%;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;">
                            <div class="panel panel-info" style="display:flex;flex-direction:column;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;" title="1" >
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name" data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">我参与的项目</h3>
                                    <div class="panel-heading-extra"><a href="http://pm.masterlab.vip//projects">更 多</a></div>
                                </div>
                                <div class="panel-body padding-0">
                                    <ul class="panel-project" id="panel_join_projects"><div class="empty" type="general">
                                            <div class="inner">
                                                <div class="img"></div>
                                                <div class="info">数据为空</div>
                                                <div class="text">
                                                    <a class="btn btn-new" href="/project/main/_new">创建项目</a>
                                                </div>
                                            </div>
                                        </div></ul>

                                    <script id="join_project_tpl" type="text/html">
                                        {{#projects}}
                                        <li class="event-block project-item col-md-4">
                                            <div class="project-item-title">
                                                {{#if avatar_exist}}
                                        <span class="g-avatar g-avatar-md project-item-pic">
                                            <img src="{{avatar}}">
                                        </span>
                                                {{^}}
                                        <span class="g-avatar g-avatar-md project-item-pic pic-bg">
                                            {{first_word}}
                                        </span>
                                                {{/if}}
                                        <span class="project-item-name">
                                            <a href="http://pm.masterlab.vip/{{path}}/{{key}}">{{name}}</a>
                                        </span>
                                            </div>

                                            <div class="project-item-body">
                                                {{user_html create_uid }}
                                            </div>

                                            <div class="project-item-footer">
                                                <span class="footer-text">{{type_name}}</span>

                                                <time class="js-time"
                                                      datetime="{{create_time}}"
                                                      data-toggle="tooltip"
                                                      data-placement="top"
                                                      data-container="body"
                                                      data-original-title="{{create_time_text}}"
                                                      data-tid="{{id}}">
                                                </time>
                                            </div>
                                        </li>
                                        {{/projects}}
                                    </script>
                                </div>
                            </div>

                            <div class="panel panel-info" style="display:flex;flex-direction:column;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;" title="2" >
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">分配给我的问题</h3>
                                    <div class="panel-heading-extra" id="panel_issue_more"><a href="http://pm.masterlab.vip//issue/main?sys_filter=assignee_mine">更多</a></div>
                                </div>

                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#id</th>
                                            <th>类型</th>
                                            <th>优先级</th>
                                            <th>主题</th>
                                        </tr>
                                        </thead>
                                        <script id="assignee_issue_tpl" type="text/html">
                                            {{#issues}}
                                            <tr>
                                                <th scope="row">#{{issue_num}}</th>
                                                <td>{{issue_type_html issue_type}}</td>
                                                <td>{{priority_html priority }}</td>
                                                <td><a href="http://pm.masterlab.vip/issue/detail/index/{{id}}">{{summary}}</a></td>
                                            </tr>
                                            {{/issues}}
                                        </script>
                                        <tbody id="panel_assignee_issues">
                                        <tr>
                                            <th scope="row">#DEV137</th>
                                            <td><i class="fa fa-arrow-circle-o-up"></i>
                                                <a href="#" class="commit-id monospace">优化改进</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/137">客服头像--快速开始中的图片需要减少大小，截图要减少</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV124</th>
                                            <td><i class="fa fa-bug"></i>
                                                <a href="#" class="commit-id monospace">Bug</a></td>
                                            <td><span style="color:red">紧 急</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/124">自定义首页面板</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV114</th>
                                            <td><i class="fa fa-bug"></i>
                                                <a href="#" class="commit-id monospace">Bug</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/114">优化文档</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV108</th>
                                            <td><i class="fa fa-plus"></i>
                                                <a href="#" class="commit-id monospace">新功能</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/108">自定义首页面板</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV100</th>
                                            <td><i class="fa fa-bug"></i>
                                                <a href="#" class="commit-id monospace">Bug</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/100">动态内容缺失</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV70</th>
                                            <td><i class="fa fa-tasks"></i>
                                                <a href="#" class="commit-id monospace">任务</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/70">在wiki上编写使用指南</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV63</th>
                                            <td><i class="fa fa-arrow-circle-o-up"></i>
                                                <a href="#" class="commit-id monospace">优化改进</a></td>
                                            <td><span style="color:#ff0000">高</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/63">用户动态功能需要优化</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#DEV28</th>
                                            <td><i class="fa fa-bug"></i>
                                                <a href="#" class="commit-id monospace">Bug</a></td>
                                            <td><span style="color:#cc0000">重 要</span></td>
                                            <td><a href="http://pm.masterlab.vip/issue/detail/index/28">各个功能模块添加操作日志</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <script id="assignee_more" type="text/html">
                                        <div class="assignee-more">
                                            <a href="http://pm.masterlab.vip/issue/main?sys_filter=assignee_mine"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               data-container="body"
                                               data-original-title="全部问题">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                        </div>
                                    </script>
                                </div>
                            </div>

                            <div class="panel panel-info" style="display:flex;flex-direction:column;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;" title="3" >
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">活动动态</h3>
                                    <div class="panel-heading-extra" id="panel_activity_more"><a href="#">全部动态</a></div>
                                </div>

                                <div class="panel-body">
                                    <ul class="event-list" id="panel_activity">
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                修改事项状态为 进行中
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/132">注册时发送邮件地址有误</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543854727" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-04  00:12:07" data-tid="449">15 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                修改事项状态为 进行中
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/134">当登录状态失效后Ajax请求的接口应该跳转到登录页面</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543853882" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-04  00:12:02" data-tid="449">15 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                修改事项状态为 进行中
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/140">事项列表的经办人筛选出现重复bug</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543853874" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-04  00:12:54" data-tid="449">15 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                修改事项状态为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/139">点击事项详情的用户头像显示500错误页</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543849512" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  23:12:12" data-tid="449">16 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                修改事项状态为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/123">添加 hotjar 用于收集用户使用masterlab的使用情况</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543837333" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  19:12:13" data-tid="449">20 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11656"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="23335096@qq.com @李建" src="http://pm.masterlab.vip/attachment/avatar/11656.png"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11656" class="username">李建</a>
                                            <span class="event">
                                                为增强安全性防止 XSS 和 CSRF 攻击添加了评论
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/119">在需要安全检查的时候调用 $this-&amp;gt;checkCSRF()， 在每个页面新增了HTTP_ML_CSRFTOKEN HTTP头字段，服务端会对AJAX的POST请求进行csrf校验</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543833532" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:52" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11656"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="23335096@qq.com @李建" src="http://pm.masterlab.vip/attachment/avatar/11656.png"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11656" class="username">李建</a>
                                            <span class="event">
                                                删除了评论 在关键表单的页面进行csrf安全校验，在控制器提供了
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/42"></a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543833490" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:10" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11657"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="296459175@qq.com @陈方铭" src="http://pm.masterlab.vip/attachment/avatar/11657.png?t=1539830329"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11657" class="username">陈方铭</a>
                                            <span class="event">
                                                修改事项解决结果为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/114">优化文档</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543832612" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:32" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                创建了事项
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/3">事项列表的经办人筛选出现重复bug</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543831889" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:29" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                为添加了一个附件
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/">jingbanren.png</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543831887" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:27" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                创建了事项
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/3">点击事项详情的用户头像显示500错误页</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543831832" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  18:12:32" data-tid="449">21 小时前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/10000"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="cdwei @Sven" src="http://pm.masterlab.vip/attachment/avatar/10000.png?t=1540833319"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/10000" class="username">Sven</a>
                                            <span class="event">
                                                更新了事项
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/135">详细视图状态下事项列表点击优化</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543829535" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  17:12:15" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11654"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="1043423813@qq.com @Jelly" src="http://pm.masterlab.vip/attachment/avatar/11654.png?t=1539845533"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11654" class="username">Jelly</a>
                                            <span class="event">
                                                修改事项解决结果为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/96">事项详情页面点击事项编辑按钮后附件框会多出来一部分</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543828783" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  17:12:43" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11654"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="1043423813@qq.com @Jelly" src="http://pm.masterlab.vip/attachment/avatar/11654.png?t=1539845533"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11654" class="username">Jelly</a>
                                            <span class="event">
                                                修改事项解决结果为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/127">迭代页面无法编辑事项</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543827150" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  16:12:30" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11657"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="296459175@qq.com @陈方铭" src="http://pm.masterlab.vip/attachment/avatar/11657.png?t=1539830329"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11657" class="username">陈方铭</a>
                                            <span class="event">
                                                修改事项状态为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/137">客服头像--快速开始中的图片需要减少大小，截图要减少</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543825270" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  16:12:10" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11657"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="296459175@qq.com @陈方铭" src="http://pm.masterlab.vip/attachment/avatar/11657.png?t=1539830329"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11657" class="username">陈方铭</a>
                                            <span class="event">
                                                修改事项解决结果为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/137">客服头像--快速开始中的图片需要减少大小，截图要减少</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543825266" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  16:12:06" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11654"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="1043423813@qq.com @Jelly" src="http://pm.masterlab.vip/attachment/avatar/11654.png?t=1539845533"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11654" class="username">Jelly</a>
                                            <span class="event">
                                                修改事项解决结果为 已解决
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/131">事项列表的右侧的详情浮动中，无事项标题</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543824009" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  16:12:09" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11654"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="1043423813@qq.com @Jelly" src="http://pm.masterlab.vip/attachment/avatar/11654.png?t=1539845533"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11654" class="username">Jelly</a>
                                            <span class="event">
                                                修改事项解决结果为 结束
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/115">增加左侧菜单的布局</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543820744" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  15:12:44" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11656"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="23335096@qq.com @李建" src="http://pm.masterlab.vip/attachment/avatar/11656.png"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11656" class="username">李建</a>
                                            <span class="event">
                                                为事项列表的表格行中双击可以直接修改状态和解决结果、经办人添加了
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/116">- 修改状态的接口：http://domain/issue/main/update/
```
issue_id:86
params[status]:5
```
- 修改解决结果的接口：http://domain/issue/main/update/
```</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543820497" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  15:12:37" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                <span class="list-item-name"><a href="/user/profile/11656"><img width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-original-title="23335096@qq.com @李建" src="http://pm.masterlab.vip/attachment/avatar/11656.png"></a></span>
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="http://pm.masterlab.vip/user/profile/11656" class="username">李建</a>
                                            <span class="event">
                                                更新了事项
                                                    <a href="http://pm.masterlab.vip/issue/detail/index/116">事项列表的表格行中双击可以直接修改状态和解决结果、经办人</a>
											</span>
                                                </h4>

                                                <time class="event-time js-time" title="" datetime="1543812318" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="2018-12-03  12:12:18" data-tid="449">1 天前</time>
                                            </div>
                                        </li>
                                    <span class="text-center" style="margin-left: 1em">
                                        总数:<span id="issue_count">518</span> 每页显示:<span id="page_size">20</span>
                                    </span>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel panel-info" style="display:flex;flex-direction:column;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;" title="4" >
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">快速开始 / 便捷导航</h3>
                                </div>

                                <div class="panel-body">
                                    <div class="link-group">
                                        <a href="http://pm.masterlab.vip/org/create">创建组织</a>
                                        <a href="http://pm.masterlab.vip/project/main/_new">创建项目</a>
                                        <a href="http://pm.masterlab.vip/issue/main/#create">创建事项</a>
                                        <a href="http://pm.masterlab.vip/passport/logout">
                                            <i class="fa fa-power-off"></i> <span> 注 销</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-info" style="display:flex;flex-direction:column;align-content:space-between;flex-wrap: wrap;justify-content: flex-start;flex-shrink:0;" title="5" >
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false">
                                    <h3 class="panel-heading-title">组织</h3>
                                </div>

                                <div class="panel-body">
                                    <script id="org_li_tpl" type="text/html">
                                        {{#orgs}}
                                        <li class="col-md-6 member-list-item">
                                            <a href="http://pm.masterlab.vip/org/detail/{{id}}">
											<span class="g-avatar g-avatar-sm member-avatar">
												<img src="{{avatar}}">
											</span>
                                                <span class="member-name">{{name}}</span>
                                            </a>
                                        </li>
                                        {{/orgs}}
                                    </script>
                                    <ul id="panel_orgs" class="member-list clearfix">
                                        <li class="col-md-6 member-list-item">
                                            <a href="http://pm.masterlab.vip/org/detail/1">
											<span class="g-avatar g-avatar-sm member-avatar">
												<img src="http://pm.masterlab.vip/attachment/all/20180826/20180826140421_58245.jpg">
											</span>
                                                <span class="member-name">Default</span>
                                            </a>
                                        </li>
                                        <li class="col-md-6 member-list-item">
                                            <a href="http://pm.masterlab.vip/org/detail/2">
											<span class="g-avatar g-avatar-sm member-avatar">
												<img src="http://pm.masterlab.vip/attachment/all/20180826/20180826140446_89680.jpg">
											</span>
                                                <span class="member-name">Agile</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-layout">
        <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_add"
              action="<?=ROOT_URL?>admin/issue_type/add"
              accept-charset="UTF-8"
              method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                        <h3 class="modal-header-title">版式布局</h3>
                    </div>

                    <div class="modal-body" id="layout-dialog">
                        <p><strong>选择仪表板布局</strong></p>
                        <ul>
                            <li><a onclick="doLayout('a')" id="layout-a"><strong>A</strong></a></li>
                            <li><a onclick="doLayout('aa')" id="layout-aa"><strong>AA</strong></a></li>
                            <li><a onclick="doLayout('ba')" id="layout-ba"><strong>BA</strong></a></li>
                            <li><a onclick="doLayout('ab')" id="layout-ab"><strong>AB</strong></a></li>
                            <li><a onclick="doLayout('aaa')" id="layout-aaa"><strong>AAA</strong></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/panel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>

<script type="text/javascript">

    var _widgets = <?=json_encode($widgets)?>;
    var $panel = null;
    var _cur_page = 1;

    (function () {
        'use strict';

        var byId = function (id) {
                return document.getElementById(id);
            },

            console = window.console;

        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el) {
            Sortable.create(el, {
                group: 'photo',
                animation: 150,
                onStart: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var index = $(evt.item).parent().children().index($(evt.item));
                    console.log(evt.item.title+"拖动前位置：",index);
                },
                onEnd: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var index = $(evt.item).parent().children().index($(evt.item));
                    console.log(evt.item.title+"拖动后位置：",index);
                },
                onUpdate: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    //debugger;
                    var index = $(evt.item).parent().children().index($(evt.item));
                    console.log(evt.item.title+"拖动后位置：",index);
                }
            });
        });

    })();

    function doLayout(layoutType)
    {
        //alert(layoutType);
        var $list = $("#module_list");
        //移除现有的控制列宽的样式
        $list.children(".panel-info").each(function() {
                $(this).toggleClass("flex",false);
        });
        switch(layoutType)
        {
            case "a":
                $list.children(".panel-info").each(function() {
                    $(this).css("flex","0 1 100%");
                });
                break;
            case "aa":
                $list.children(".panel-info").each(function(index) {
                    $(this).css("flex","0 1 50%");
                });
                break;
            case "ba":
                $list.children(".panel-info").each(function(index) {
                    if(index%2==0)
                    {
                        $(this).css("flex","0 1 34%");
                    }
                    else
                    {
                        $(this).css("flex","0 1 66%");
                    }
                });
                break;
            case "ab":
                $list.children(".panel-info").each(function(index) {
                    if(index%2==0)
                    {
                        $(this).css("flex","0 1 66%");
                    }
                    else
                    {
                        $(this).css("flex","0 1 34%");
                    }
                });
                break;
            case "aaa":
                $list.children(".panel-info").each(function(index) {
                    $(this).css("flex","0 1 33.3%");
                });
                break;
        }
        $("#modal-layout").modal('hide');
    }

</script>
</body>
</html>