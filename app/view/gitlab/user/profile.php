<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/calendar-heatmap/src/calendar-heatmap.css">
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>


<header class="navbar navbar-gitlab">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>

<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="user-profile">
                    <div class="cover-block user-cover-block">
                        <div class="cover-controls">
                            <a class="btn btn-gray has-tooltip" title="Edit profile" aria-label="Edit profile" href="<?=ROOT_URL?>user/profile_edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!--<a class="btn btn-gray has-tooltip" title="Subscribe" aria-label="Subscribe" href="/sven.atom?private_token=vyxEf937XeWRN9gDqyXk">
                                <i class="fa fa-rss"></i>
                            </a>-->
                        </div>
                        <div class="profile-header">
                            <div class="avatar-holder">
                                <a target="_blank" rel="noopener noreferrer" href="<?=$user['avatar']?>">
                                    <img class="avatar s90" alt="" src="<?=$user['avatar']?>" /></a>
                            </div>
                            <div class="user-info">
                                <div class="cover-title"><?=$user['display_name']?></div>
                                <div class="cover-desc member-date">
                                    <span class="middle-dot-divider"><?=$user['username']?></span>
                                    <span class="middle-dot-divider"><?=$user['create_time_text']?></span></div>
                                <div class="cover-desc"></div>
                            </div>
                        </div>
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <ul class="nav-links center user-profile-nav scrolling-tabs">
                                <li class="js-activity-tab active">
                                    <a data-target="div#activity" data-action="activity" data-toggle="tab" href="/sven">Activity</a></li>
                                <li class="js-groups-tab">
                                    <a data-target="div#groups" data-action="groups" data-toggle="tab" href="<?=ROOT_URL?>users/sven/groups">Groups</a></li>
                                <li class="js-contributed-tab">
                                    <a data-target="div#contributed" data-action="contributed" data-toggle="tab" href="<?=ROOT_URL?>users/sven/contributed">Contributed projects</a></li>
                                <li class="js-projects-tab">
                                    <a data-target="div#projects" data-action="projects" data-toggle="tab" href="<?=ROOT_URL?>users/sven/projects">Personal projects</a></li>
                                <li class="js-snippets-tab">
                                    <a data-target="div#snippets" data-action="snippets" data-toggle="tab" href="<?=ROOT_URL?>users/sven/snippets">Snippets</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity">

                                <div class="calendar-container user-calendar">

                                </div>
                                <h4 class="prepend-top-20">Most Recent Activity</h4>
                                <div id="activity_list" class="content_list" data-href="/sven">


                                </div>
                                <div class="loading hide">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="tab-pane" id="groups"></div>
                            <div class="tab-pane" id="contributed"></div>
                            <div class="tab-pane" id="projects"></div>
                            <div class="tab-pane" id="snippets"></div>
                        </div>
                        <div class="loading-status">
                            <div class="loading hide">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script id="activity_tpl" type="text/html" >
{{#activity_list}}
    <div class="event-block event-item">
        <div class="event-item-timestamp">
            <time class="js-timeago js-timeago-render" title=""
                  datetime="{{time_full}}"
                  data-toggle="tooltip"
                  data-placement="top"
                  data-container="body"
                  data-original-title="{{time_full}}"
                  data-tid="449">{{time_text}}</time>
        </div>
        <div class="system-note-image pushed-to-icon">
            icon
        </div>
        <div class="event-title">
            <span class="author_name">
                <a title="Abby Matthews" href="/amatthews">{{display}}</a>
            </span>
            <span class="pushed">{{title}}</span>
        </div>
        <div class="event-body">
            <div class="commit-row-title">
                {{detail}}
            </div>
        </div>

    </div>
    {{/activity_list}}

</script>
<script src="<?=ROOT_URL?>dev/js/activity.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/moment.js" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/d3-v5/d3.v3.min.js" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/calendar-heatmap/src/calendar-heatmap.js"></script>
<script type="text/javascript">
    var now = moment().endOf('day').toDate();
    var yearAgo = moment().startOf('day').subtract(1, 'year').toDate();
    var chartData = d3.time.days(yearAgo, now).map(function (dateElement) {
        return {
            date: dateElement,
            count: (dateElement.getDay() !== 0 && dateElement.getDay() !== 6) ? Math.floor(Math.random() * 60) : Math.floor(Math.random() * 10)
        };
    });

    var heatmap = calendarHeatmap()
        .data(chartData)
        .selector('.calendar-container')
        .tooltipEnabled(true)
        .colorRange(['#f4f7f7', '#79a8a9'])
        .onClick(function (data) {
            console.log('data', data);
        });
    heatmap();  // render the chart

    var $activity = null;
    $(function() {
        var options = {
        }
        window.$activity = new Activity( options );
        window.$activity.fetchByUser( );
    });
</script>

</body>
</html>

