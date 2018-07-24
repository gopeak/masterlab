<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
   <style>

       .container {
           width: 100%;
           margin: auto;
           min-width: 1100px;
           position: relative;
           padding: 10px;
       }

       .tile_40 {
           width: 40%;
       }

       .tile_60 {
           width: 60%;
       }

       .tile__name {
           cursor: move;
           padding-bottom: 10px;
           border-bottom: 1px solid #FF7373;
       }

       .tile__list {
           margin-top: 10px;
       }


   </style>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid"  >

                    <div id="multi" class="container row">

                            <div class="col-md-4 group_panel">
                                <div class="panel panel-info">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading tile__name " data-force="25" draggable="false" >分配给我的问题</div>
                                    <div class="panel-body">
                                        <!-- Table -->
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel panel-info">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading tile__name " data-force="25" draggable="false" >我参与的项目</div>
                                    <div class="panel-body">
                                        <!-- Table -->
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        <div class="col-md-8 group_panel">
                            <div class="panel panel-info">
                                <!-- Default panel contents -->
                                <div class="panel-heading tile__name " data-force="25" draggable="false" >活动动态</div>
                                <div class="panel-body">
                                    <div class="content_list">
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-24T02:05:13Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 24, 2018 10:05am GMT+0800">about an hour ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/huqiang"><img class="avatar has-tooltip s32 hidden-xs" alt="胡强's avatar" title="胡强" data-container="body" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="胡强" href="/huqiang">胡强</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/ismondjxc/commits/master">master</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="ismondjxc" href="/ismond/ismondjxc"><span class="namespace-name">ismond / </span><span class="project-name">ismondjxc</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="5bc93b56" href="/ismond/ismondjxc/commit/5bc93b567748155fea5b87bb467be1a07cac4ab1">5bc93b56</a>
                                                            ·
                                                            Excel 客户信息
                                                        </div>
                                                    </li>

                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="188c86fd" href="/ismond/ismondjxc/commit/188c86fde938d5f21d6fb07da89fb17ad22994aa">188c86fd</a>
                                                            ·
                                                            excel 款式信息
                                                        </div>
                                                    </li>

                                                    <li class="commits-stat">
                                                        <a href="/ismond/ismondjxc/compare/c9ec7b74700613e06ac15576144627e38b0684ed...5bc93b567748155fea5b87bb467be1a07cac4ab1">Compare c9ec7b74...5bc93b56
                                                        </a></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-24T02:04:20Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 24, 2018 10:04am GMT+0800">about an hour ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/huqiang"><img class="avatar has-tooltip s32 hidden-xs" alt="胡强's avatar" title="胡强" data-container="body" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="胡强" href="/huqiang">胡强</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/ismondjxc/commits/test">test</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="ismondjxc" href="/ismond/ismondjxc"><span class="namespace-name">ismond / </span><span class="project-name">ismondjxc</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="5bc93b56" href="/ismond/ismondjxc/commit/5bc93b567748155fea5b87bb467be1a07cac4ab1">5bc93b56</a>
                                                            ·
                                                            Excel 客户信息
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-23T10:29:09Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 23, 2018 6:29pm GMT+0800">about 17 hours ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/platform/commits/feature_model">feature_model</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="platform" href="/ismond/platform"><span class="namespace-name">ismond / </span><span class="project-name">platform</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="05778578" href="/ismond/platform/commit/05778578202143a48079625a7bb144a3e34c7ca4">05778578</a>
                                                            ·
                                                            add: 服务授权
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-23T08:29:41Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 23, 2018 4:29pm GMT+0800">about 19 hours ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/huqiang"><img class="avatar has-tooltip s32 hidden-xs" alt="胡强's avatar" title="胡强" data-container="body" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="胡强" href="/huqiang">胡强</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/ismondjxc/commits/test">test</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="ismondjxc" href="/ismond/ismondjxc"><span class="namespace-name">ismond / </span><span class="project-name">ismondjxc</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="188c86fd" href="/ismond/ismondjxc/commit/188c86fde938d5f21d6fb07da89fb17ad22994aa">188c86fd</a>
                                                            ·
                                                            excel 款式信息
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T09:12:26Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 5:12pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/platform/commits/feature_model">feature_model</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="platform" href="/ismond/platform"><span class="namespace-name">ismond / </span><span class="project-name">platform</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="61f6d54a" href="/ismond/platform/commit/61f6d54ab6da980759202daf5dec06fcfae01aa9">61f6d54a</a>
                                                            ·
                                                            add: user log module
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T08:48:30Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 4:48pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed new tag</span>
                                                <strong>
                                                    v1.7.1
                                                </strong>
                                                <span class="event-scope">
at
<a title="b2b" href="/ismond/b2b"><span class="namespace-name">ismond / </span><span class="project-name">b2b</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="35659f35" href="/ismond/b2b/commit/35659f35be4d5a0c65cd7527ca5e5383b6774fc9">35659f35</a>
                                                            ·
                                                            Merge branch 'master' into dev
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T08:46:01Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 4:46pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/b2b/commits/master">master</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="b2b" href="/ismond/b2b"><span class="namespace-name">ismond / </span><span class="project-name">b2b</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="35659f35" href="/ismond/b2b/commit/35659f35be4d5a0c65cd7527ca5e5383b6774fc9">35659f35</a>
                                                            ·
                                                            Merge branch 'master' into dev
                                                        </div>
                                                    </li>

                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="109d835a" href="/ismond/b2b/commit/109d835a78b733108ab05db27ac0fdf5389ea189">109d835a</a>
                                                            ·
                                                            Merge branch 'master' into dev
                                                        </div>
                                                    </li>

                                                    <li class="commits-stat">
                                                        <span>... and 18 more commits.</span>
                                                        <a href="/ismond/b2b/compare/5fc06945dd5c846c36304c13f09265e9d30274c5...35659f35be4d5a0c65cd7527ca5e5383b6774fc9">Compare 5fc06945...35659f35
                                                        </a></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T08:45:33Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 4:45pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/b2b/commits/test">test</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="b2b" href="/ismond/b2b"><span class="namespace-name">ismond / </span><span class="project-name">b2b</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="35659f35" href="/ismond/b2b/commit/35659f35be4d5a0c65cd7527ca5e5383b6774fc9">35659f35</a>
                                                            ·
                                                            Merge branch 'master' into dev
                                                        </div>
                                                    </li>

                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="5fc06945" href="/ismond/b2b/commit/5fc06945dd5c846c36304c13f09265e9d30274c5">5fc06945</a>
                                                            ·
                                                            upt: database cofig
                                                        </div>
                                                    </li>

                                                    <li class="commits-stat">
                                                        <span>... and 10 more commits.</span>
                                                        <a href="/ismond/b2b/compare/109d835a78b733108ab05db27ac0fdf5389ea189...35659f35be4d5a0c65cd7527ca5e5383b6774fc9">Compare 109d835a...35659f35
                                                        </a></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T08:45:20Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 4:45pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed to branch</span>
                                                <strong>
                                                    <a href="/ismond/b2b/commits/dev">dev</a>
                                                </strong>
                                                <span class="event-scope">
at
<a title="b2b" href="/ismond/b2b"><span class="namespace-name">ismond / </span><span class="project-name">b2b</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="35659f35" href="/ismond/b2b/commit/35659f35be4d5a0c65cd7527ca5e5383b6774fc9">35659f35</a>
                                                            ·
                                                            Merge branch 'master' into dev
                                                        </div>
                                                    </li>

                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="5fc06945" href="/ismond/b2b/commit/5fc06945dd5c846c36304c13f09265e9d30274c5">5fc06945</a>
                                                            ·
                                                            upt: database cofig
                                                        </div>
                                                    </li>

                                                    <li class="commits-stat">
                                                        <span>... and 10 more commits.</span>
                                                        <a href="/ismond/b2b/compare/109d835a78b733108ab05db27ac0fdf5389ea189...35659f35be4d5a0c65cd7527ca5e5383b6774fc9">Compare 109d835a...35659f35
                                                        </a></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="event-block event-item">
                                            <div class="event-item-timestamp">
                                                <time class="js-timeago js-timeago-render" title="" datetime="2018-07-20T07:11:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 20, 2018 3:11pm GMT+0800">3 days ago</time>
                                            </div>
                                            <div class="system-note-image user-avatar"><a href="/guosheng"><img class="avatar has-tooltip s32 hidden-xs" alt="郭胜's avatar" title="郭胜" data-container="body" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=64&amp;d=identicon"></a></div>
                                            <div class="event-title">
                                                <span class="author_name"><a title="郭胜" href="/guosheng">郭胜</a></span>
                                                <span class="pushed">pushed new tag</span>
                                                <strong>
                                                    v1.7.0
                                                </strong>
                                                <span class="event-scope">
at
<a title="b2b" href="/ismond/b2b"><span class="namespace-name">ismond / </span><span class="project-name">b2b</span></a>
</span>

                                            </div>
                                            <div class="event-body">
                                                <ul class="well-list event_commits">
                                                    <li class="commit">
                                                        <div class="commit-row-title">
                                                            <a class="commit_short_id" alt="" title="5fc06945" href="/ismond/b2b/commit/5fc06945dd5c846c36304c13f09265e9d30274c5">5fc06945</a>
                                                            ·
                                                            upt: database cofig
                                                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>

<script type="text/javascript">

    (function () {
        'use strict';

        var byId = function (id) { return document.getElementById(id); },

            loadScripts = function (desc, callback) {
                var deps = [], key, idx = 0;

                for (key in desc) {
                    deps.push(key);
                }

                (function _next() {
                    var pid,
                        name = deps[idx],
                        script = document.createElement('script');

                    script.type = 'text/javascript';
                    script.src = desc[deps[idx]];

                    pid = setInterval(function () {
                        if (window[name]) {
                            clearTimeout(pid);

                            deps[idx++] = window[name];

                            if (deps[idx]) {
                                _next();
                            } else {
                                callback.apply(null, deps);
                            }
                        }
                    }, 30);

                    document.getElementsByTagName('head')[0].appendChild(script);
                })()
            },

            console = window.console;

        if (!console.log) {
            console.log = function () {
                alert([].join.apply(arguments, ' '));
            };
        }

        // Multi groups


        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el){
            Sortable.create(el, {
                group: 'photo',
                animation: 150
            });
        });

    })();


</script>
</body>
</html>