<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">

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
            <div class="content padding-0" id="content-body">
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
                        <?php
                        if(empty($other_user)){
                            $other_user = $user;
                        }
                        ?>
                        <div class="profile-header">
                            <div class="avatar-holder">
                                <a target="_blank" rel="noopener noreferrer" href="<?=$other_user['avatar']?>">
                                    <img class="avatar s90" alt="" src="<?=$other_user['avatar']?>" /></a>
                            </div>
                            <div class="user-info">
                                <div class="cover-title"><?=$other_user['display_name']?></div>
                                <div class="cover-desc member-date">
                                    <span class="middle-dot-divider"><?=$other_user['username']?></span>
                                    <span class="middle-dot-divider"><?=$other_user['create_time_text']?></span></div>
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
                            <?php
                            $profile_nav = 'activity';
                            include_once VIEW_PATH.'gitlab/user/common-profile-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="container-fluid container-limited">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity">

                                <div id="user-calendar" class="calendar-container user-calendar">

                                </div>
                                <div  id="activity_list" data-href="/sven">

                                </div>
                                <div id="more_activity" class="loading hide">
                                    <a class="text-plain" href="#" style="font-size: 14px">更多</a>
                                </div>
                                <div class="loading hide">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="tab-pane" id="groups"></div>
                            <div class="tab-pane" id="projects">
                            </div>
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

    </div>
</section>
<script id="activity_tpl" type="text/html" >
    <ul class="projects-list">
    {{#activity_list}}
        <li class="project-row">
            <div class="project-details">
                <h3 class="prepend-top-0 append-bottom-0"><span class="label btn-success" style="padding: 4px;">{{action}}</span> {{type}}</h3>
                <div class="description prepend-top-5">
                    <p dir="auto" style="color:#999;">{{title}}</p>
                </div>
            </div>
            <div class="event-title">
                <span class="author_name">
                    <a title="Abby Matthews" href="/amatthews">{{display}}</a>
                </span>
                <span class="pushed"></span>
            </div>
            <div class="event-body">
                <div class="commit-row-title">
                    {{detail}}
                </div>
            </div>
            <div class="controls">
                <time class="js-timeago js-timeago-render-my" title=""
                      datetime="{{time_full}}"
                      data-toggle="tooltip"
                      data-placement="top"
                      data-container="body"
                      data-original-title="{{time_full}}"
                      data-tid="449">{{time_text}}</time>
            </div>
        </li>
    {{/activity_list}}
    </ul>
</script>
<style>
    text.month-name,
    text.calendar-heatmap-legend-text,
    text.day-initial {
        font-size: 10px;
        fill: #aaaaaa;
        font-family: Helvetica, arial, 'Open Sans', sans-serif
    }
    .day-cell {
        border: 1px solid gray;
    }
    rect.day-cell:hover {
        stroke: #555555;
        stroke-width: 1px;
    }
    .day-cell-tooltip {
        position: absolute;
        z-index: 9999;
        padding: 5px 9px;
        color: #bbbbbb;
        font-size: 12px;
        background: rgba(0, 0, 0, 0.85);
        border-radius: 3px;
        text-align: center;
    }
    .day-cell-tooltip > span {
        font-family: Helvetica, arial, 'Open Sans', sans-serif
    }
    .calendar-heatmap {
        box-sizing: initial;
    }
</style>

<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/activity.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/moment.js" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/d3-v5/d3.v3.min.js" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/lib/calendar-heatmap/src/calendar-heatmap.js"></script>
<script type="text/javascript">

    var $activity = null;
    var _cur_page = 1;
    var _user_id = '<?=$user_id?>';
    $(function() {


        var options = {
            user_id:_user_id
        }
        window.$activity = new Activity( options );
        window.$activity.fetchByUser( window._cur_page );
        window.$activity.fetchCalendarHeatmap( );

        $('#more_activity').bind('click', function(){
            window.$activity.fetchByUser( window._cur_page +1 );
        })
    });
</script>

</body>
</html>

