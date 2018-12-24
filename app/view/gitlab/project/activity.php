<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js?v=<?=$_version?>"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <? require_once VIEW_PATH.'gitlab/project/common-home-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">


            <div class="flash-container flash-container-page">
            </div>


        </div>
        <div class="container-fluid ">
            <div class="content" id="content-body">


                <div class="container-fluid">
                    <div class="nav-block activity-filter-block">
                        <div class="controls">
                            <a title="Subscribe" class="btn rss-btn has-tooltip" href="/ismond/xphp.atom?private_token=vyxEf937XeWRN9gDqyXk"><i class="fa fa-rss"></i>
                            </a></div>
                        <ul class="nav-links event-filter scrolling-tabs is-initialized">
                            <li class="active"><a class="event-filter-link" id="all_event_filter" title="Filter by all" href="/ismond/xphp/activity"><span> All</span></a></li>
                            <li><a class="event-filter-link" id="push_event_filter" title="Filter by push events" href="/ismond/xphp/activity"><span> Push events</span></a></li>
                            <li><a class="event-filter-link" id="merged_event_filter" title="Filter by merge events" href="/ismond/xphp/activity"><span> Merge events</span></a></li>
                            <li><a class="event-filter-link" id="issue_event_filter" title="Filter by issue events" href="/ismond/xphp/activity"><span> Issue events</span></a></li>
                            <li><a class="event-filter-link" id="comments_event_filter" title="Filter by comments" href="/ismond/xphp/activity"><span> Comments</span></a></li>
                            <li><a class="event-filter-link" id="team_event_filter" title="Filter by team" href="/ismond/xphp/activity"><span> Team</span></a></li>
                        </ul>

                    </div>
                    <div class="content_list project-activity" data-href="/ismond/xphp/activity">























                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 28, 2017 3:58pm GMT+0800" datetime="2017-07-28T07:58:17Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 28, 2017 3:58pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed to branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/master">master</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="16fb7e9b" href="/ismond/xphp/commit/16fb7e9bef98dc1d47bdf7fc12b7059981bd045e">16fb7e9b</a>
                                            ·
                                            Update .gitlab-ci.yml
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>




                        <div class="event-inline event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 8:12pm GMT+0800" datetime="2017-07-27T12:12:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 8:12pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/yangwenjie"><img class="avatar has-tooltip s32 hidden-xs" alt="杨文杰's avatar" title="杨文杰" data-container="body" src="http://www.gravatar.com/avatar/e5baff75af01ef5b66fbaa1435f89330?s=64&amp;d=identicon"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="杨文杰" href="/yangwenjie">杨文杰</a></span>
                                <span class="joined"></span>
                                joined project
                                <span class="event-scope">

<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 7:13pm GMT+0800" datetime="2017-07-27T11:13:37Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 7:13pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed to branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/master">master</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="051cf7bf" href="/ismond/xphp/commit/051cf7bfd5f8cfb58c733f3ec5df22107f2e5a65">051cf7bf</a>
                                            ·
                                            重新使用测试数据库的sql;删除main\lib\phpcurl改用vendor
                                        </div>
                                    </li>

                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="cf1825cb" href="/ismond/xphp/commit/cf1825cb1b1e0f730c2fe61ac855ac040a1cec9a">cf1825cb</a>
                                            ·
                                            调整代码显示方式
                                        </div>
                                    </li>

                                    <li class="commits-stat">
                                        <span>... and 2 more commits.</span>
                                        <a href="/ismond/xphp/compare/7dfd47bdc0ede0deb0c011d28979bd051dd2e699...051cf7bfd5f8cfb58c733f3ec5df22107f2e5a65">Compare 7dfd47bd...051cf7bf
                                        </a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 7:12pm GMT+0800" datetime="2017-07-27T11:12:10Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 7:12pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed to branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/dev">dev</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="051cf7bf" href="/ismond/xphp/commit/051cf7bfd5f8cfb58c733f3ec5df22107f2e5a65">051cf7bf</a>
                                            ·
                                            重新使用测试数据库的sql;删除main\lib\phpcurl改用vendor
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 7:08pm GMT+0800" datetime="2017-07-27T11:08:54Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 7:08pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed to branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/dev">dev</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="cf1825cb" href="/ismond/xphp/commit/cf1825cb1b1e0f730c2fe61ac855ac040a1cec9a">cf1825cb</a>
                                            ·
                                            调整代码显示方式
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 5:13pm GMT+0800" datetime="2017-07-27T09:13:55Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 5:13pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed to branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/dev">dev</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="9fb67bbb" href="/ismond/xphp/commit/9fb67bbbb0a24925e637b86e6cd40d53ec74c748">9fb67bbb</a>
                                            ·
                                            add source
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 5:12pm GMT+0800" datetime="2017-07-27T09:12:59Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 5:12pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed new branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/dev">dev</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="08d48905" href="/ismond/xphp/commit/08d489051c9e04ba13d1946bc296802893672517">08d48905</a>
                                            ·
                                            add basic file
                                        </div>
                                    </li>

                                    <li class="commits-stat">
                                        <a href="/ismond/xphp/merge_requests/new?merge_request%5Bsource_branch%5D=dev&amp;merge_request%5Btarget_branch%5D=master">Create Merge Request
                                        </a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="event-block event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 4:06pm GMT+0800" datetime="2017-07-27T08:06:45Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 4:06pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="pushed">pushed new branch</span>
                                <strong>
                                    <a href="/ismond/xphp/commits/master">master</a>
                                </strong>
                                <span class="event-scope">
at
<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>
                            <div class="event-body">
                                <ul class="well-list event_commits">
                                    <li class="commit">
                                        <div class="commit-row-title">
                                            <a class="commit_short_id" alt="" title="7dfd47bd" href="/ismond/xphp/commit/7dfd47bdc0ede0deb0c011d28979bd051dd2e699">7dfd47bd</a>
                                            ·
                                            add README
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="event-inline event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 3:54pm GMT+0800" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/songweiping"><img class="avatar has-tooltip s32 hidden-xs" alt="宋卫平's avatar" title="宋卫平" data-container="body" src="http://www.gravatar.com/avatar/991fac7b338428d9df4c83da0ae18468?s=64&amp;d=identicon"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="宋卫平" href="/songweiping">宋卫平</a></span>
                                <span class="joined"></span>
                                joined project
                                <span class="event-scope">

<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>

                        </div>
                        <div class="event-inline event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 3:54pm GMT+0800" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/huangjie"><img class="avatar has-tooltip s32 hidden-xs" alt="黄杰's avatar" title="黄杰" data-container="body" src="http://www.gravatar.com/avatar/56c8883b6c05ed54889df0aedfc9d47d?s=64&amp;d=identicon"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="黄杰" href="/huangjie">黄杰</a></span>
                                <span class="joined"></span>
                                joined project
                                <span class="event-scope">

<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>

                        </div>






                        <div class="event-inline event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 3:54pm GMT+0800" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/shenzebiao"><img class="avatar has-tooltip s32 hidden-xs" alt="沈泽彪's avatar" title="沈泽彪" data-container="body" src="http://www.gravatar.com/avatar/3333f73983020f51aaa42c2887f9174d?s=64&amp;d=identicon"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="沈泽彪" href="/shenzebiao">沈泽彪</a></span>
                                <span class="joined"></span>
                                joined project
                                <span class="event-scope">

<a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
</span>

                            </div>

                        </div>
                        <div class="event-inline event-item">
                            <div class="event-item-timestamp">
                                <time class="js-timeago js-timeago-render-my" title="Jul 27, 2017 3:45pm GMT+0800" datetime="2017-07-27T07:45:13Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:45pm GMT+0800">3 months ago</time>
                            </div>
                            <div class="system-note-image user-avatar"><a href="/sven"><img class="avatar has-tooltip s32 hidden-xs" alt="韦朝夺's avatar" title="韦朝夺" data-container="body" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png"></a></div>
                            <div class="event-title">
                                <span class="author_name"><a title="韦朝夺" href="/sven">韦朝夺</a></span>
                                <span class="created">
created project
</span>
                                <a title="xphp" href="/ismond/xphp"><span class="namespace-name">ismond / </span><span class="project-name">xphp</span></a>
                            </div>

                        </div>


                    </div>
                    <div class="loading hide" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
                </div>
                <script>
                    var activity = new gl.Activities();
                    $(document).on('page:restore', function (event) {
                        activity.reloadActivities()
                    })
                </script>


            </div>
        </div>
    </div>
</div>

    </div>
</section>
</body>
</html>


</div>