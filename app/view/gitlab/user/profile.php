<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

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
                            <a class="btn btn-gray has-tooltip" title="Subscribe" aria-label="Subscribe" href="/sven.atom?private_token=vyxEf937XeWRN9gDqyXk">
                                <i class="fa fa-rss"></i>
                            </a>
                        </div>
                        <div class="profile-header">
                            <div class="avatar-holder">
                                <a target="_blank" rel="noopener noreferrer" href="<?=$user['avatar']?>">
                                    <img class="avatar s90" alt="" src="<?=$user['avatar']?>" /></a>
                            </div>
                            <div class="user-info">
                                <div class="cover-title"><?=$user['display_name']?></div>
                                <div class="cover-desc member-date">
                                    <span class="middle-dot-divider">@<?=$user['username']?></span>
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
                                <li class="js-activity-tab">
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
                        <div class="user-callout">
                            <div class="bordered-box landing content-block">
                                <button aria-label="Dismiss customize experience box" class="btn btn-default close js-close-callout" type="button">
                                    <i aria-hidden="true" class="fa fa-times dismiss-icon"></i>
                                </button>
                                <div class="row">
                                    <div class="col-sm-3 col-xs-12 svg-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112 90" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g fill="none" fill-rule="evenodd">
                                                <rect width="112" height="90" fill="#fff" rx="6" />
                                                <path fill="#eee" fill-rule="nonzero" d="m4 6.01v77.98c0 1.11.899 2.01 2 2.01h100c1.105 0 2-.898 2-2.01v-77.98c0-1.11-.899-2.01-2-2.01h-100c-1.105 0-2 .898-2 2.01m-4 0c0-3.319 2.686-6.01 6-6.01h100c3.315 0 6 2.694 6 6.01v77.98c0 3.319-2.686 6.01-6 6.01h-100c-3.315 0-6-2.694-6-6.01v-77.98" />
                                                <g transform="translate(26 35)">
                                                    <rect width="4" height="39" x="5" fill="#eee" rx="2" id="0" />
                                                    <rect width="4" height="21" x="5" y="18" fill="#fef0ea" rx="2" />
                                                    <circle cx="7" cy="13" r="5" fill="#fff" />
                                                    <path fill="#fb722e" fill-rule="nonzero" d="m7 20c-3.866 0-7-3.134-7-7 0-3.866 3.134-7 7-7 3.866 0 7 3.134 7 7 0 3.866-3.134 7-7 7m0-4c1.657 0 3-1.343 3-3 0-1.657-1.343-3-3-3-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3" /></g>
                                                <g transform="translate(49 35)">
                                                    <use xlink:href="#0" />
                                                    <rect width="4" height="21" x="5" y="18" fill="#b5a7dd" rx="2" />
                                                    <circle cx="7" cy="25" r="5" fill="#fff" />
                                                    <path fill="#6b4fbb" fill-rule="nonzero" d="m7 32c-3.866 0-7-3.134-7-7 0-3.866 3.134-7 7-7 3.866 0 7 3.134 7 7 0 3.866-3.134 7-7 7m0-4c1.657 0 3-1.343 3-3 0-1.657-1.343-3-3-3-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3" /></g>
                                                <g transform="translate(72 33)">
                                                    <rect width="4" height="39" x="5" y="2" fill="#eee" rx="2" />
                                                    <rect width="4" height="34" x="5" y="7" fill="#fef0ea" rx="2" />
                                                    <circle cx="7" cy="7" r="5" fill="#fff" />
                                                    <path fill="#fb722e" fill-rule="nonzero" d="m7 14c-3.866 0-7-3.134-7-7 0-3.866 3.134-7 7-7 3.866 0 7 3.134 7 7 0 3.866-3.134 7-7 7m0-4c1.657 0 3-1.343 3-3 0-1.657-1.343-3-3-3-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3" /></g>
                                                <g fill="#6b4fbb">
                                                    <circle cx="13.5" cy="11.5" r="2.5" />
                                                    <circle cx="23.5" cy="11.5" r="2.5" opacity=".5" />
                                                    <circle cx="33.5" cy="11.5" r="2.5" opacity=".5" /></g>
                                                <path fill="#eee" d="m0 19h111v4h-111z" /></g>
                                        </svg>
                                    </div>
                                    <div class="col-sm-8 col-xs-12 inner-content">
                                        <h4>Customize your experience</h4>
                                        <p>Change syntax themes, default project pages, and more in preferences.</p>
                                        <a class="btn btn-default js-close-callout" href="/profile/preferences">Check it out</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
                                <div class="row-content-block calender-block white second-block hidden-xs">
                                    <div class="user-calendar" data-href="<?=ROOT_URL?>users/sven/calendar">
                                        <h4 class="center light">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </h4>
                                    </div>
                                    <div class="user-calendar-activities"></div>
                                </div>
                                <h4 class="prepend-top-20">Most Recent Activity</h4>
                                <div class="content_list" data-href="/sven"></div>
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



</body>
</html>


</div>