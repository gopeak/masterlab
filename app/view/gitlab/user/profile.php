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
        <div class="header-content">
            <div class="dropdown global-dropdown">
                <button class="global-dropdown-toggle" data-toggle="dropdown" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>

            </div>
            <div class="header-logo">
                <a class="home" title="Dashboard" id="logo" href="/">
                    <svg width="28" height="28" class="tanuki-logo" viewBox="0 0 36 36">
                        <path class="tanuki-shape tanuki-left-ear" fill="#e24329" d="M2 14l9.38 9v-9l-4-12.28c-.205-.632-1.176-.632-1.38 0z" />
                        <path class="tanuki-shape tanuki-right-ear" fill="#e24329" d="M34 14l-9.38 9v-9l4-12.28c.205-.632 1.176-.632 1.38 0z" />
                        <path class="tanuki-shape tanuki-nose" fill="#e24329" d="M18,34.38 3,14 33,14 Z" />
                        <path class="tanuki-shape tanuki-left-eye" fill="#fc6d26" d="M18,34.38 11.38,14 2,14 6,25Z" />
                        <path class="tanuki-shape tanuki-right-eye" fill="#fc6d26" d="M18,34.38 24.62,14 34,14 30,25Z" />
                        <path class="tanuki-shape tanuki-left-cheek" fill="#fca326" d="M2 14L.1 20.16c-.18.565 0 1.2.5 1.56l17.42 12.66z" />
                        <path class="tanuki-shape tanuki-right-cheek" fill="#fca326" d="M34 14l1.9 6.16c.18.565 0 1.2-.5 1.56L18 34.38z" /></svg>
                </a>
            </div>
            <div class="title-container">
                <h1 class="title">
                    <a href="/sven">韦朝夺</a></h1>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-xs">
                        <div class="search search-form">
                            <form class="navbar-form" action="/search" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="&#x2713;" />
                                <div class="search-input-container">
                                    <div class="search-input-wrap">
                                        <div class="dropdown" data-url="/search/autocomplete">
                                            <input type="search" name="search" id="search" placeholder="Search" class="search-input dropdown-menu-toggle no-outline js-search-dashboard-options" spellcheck="false" tabindex="1" autocomplete="off" data-toggle="dropdown" data-issues-path="http://192.168.3.213/dashboard/issues" data-mr-path="http://192.168.3.213/dashboard/merge_requests" />
                                            <div class="dropdown-menu dropdown-select">
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a class="is-focused dropdown-menu-empty-link">Loading...</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                            <i class="search-icon"></i>
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="group_id" id="group_id" class="js-search-group-options" />
                                <input type="hidden" name="project_id" id="search_project_id" value="" class="js-search-project-options" />
                                <input type="hidden" name="repository_ref" id="repository_ref" />
                                <div class="search-autocomplete-opts hide" data-autocomplete-path="/search/autocomplete"></div>
                            </form>
                        </div>
                    </li>
                    <li class="visible-sm-inline-block visible-xs-inline-block">
                        <a title="Search" aria-label="Search" data-toggle="tooltip" data-placement="bottom" data-container="body" href="/search">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li>
                        <a title="New project" aria-label="New project" data-toggle="tooltip" data-placement="bottom" data-container="body" href="/projects/new">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </li>
                    <li>
                        <a title="Issues" aria-label="Issues" data-toggle="tooltip" data-placement="bottom" data-container="body" href="/dashboard/issues?assignee_id=15">
                            <i class="fa fa-hashtag fa-fw"></i>
                            <span class="badge hidden issues-count">0</span></a>
                    </li>
                    <li>
                        <a title="Merge requests" aria-label="Merge requests" data-toggle="tooltip" data-placement="bottom" data-container="body" href="/dashboard/merge_requests?assignee_id=15">
                            <svg width="15" height="20" viewBox="0 0 12 14" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 4.967a2.15 2.15 0 1 1 2.3 0v5.066a2.15 2.15 0 1 1-2.3 0V4.967zm7.85 5.17V5.496c0-.745-.603-1.346-1.35-1.346V6l-3-3 3-3v1.85c2.016 0 3.65 1.63 3.65 3.646v4.45a2.15 2.15 0 1 1-2.3.191z" fill-rule="nonzero" /></svg>
                            <span class="badge hidden merge-requests-count">0</span></a>
                    </li>
                    <li>
                        <a title="Todos" aria-label="Todos" class="shortcuts-todos" data-toggle="tooltip" data-placement="bottom" data-container="body" href="/dashboard/todos">
                            <i class="fa fa-check-circle fa-fw"></i>
                            <span class="badge hidden todos-count">0</span></a>
                    </li>
                    <li class="header-user dropdown">
                        <a class="header-user-dropdown-toggle" data-toggle="dropdown" href="/sven">
                            <img width="26" height="26" class="header-user-avatar" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png" alt="Avatar" />
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu-nav dropdown-menu-align-right">
                            <ul>
                                <li>
                                    <a class="profile-link" aria-label="Profile" data-user="sven" href="/sven">Profile</a></li>
                                <li>
                                    <a aria-label="Settings" href="/profile">Settings</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a class="sign-out-link" aria-label="Sign out" rel="nofollow" data-method="delete" href="/users/sign_out">Sign out</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggle" type="button">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-ellipsis-v"></i>
            </button>
        </div>
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
                            <a class="btn btn-gray has-tooltip" title="Edit profile" aria-label="Edit profile" href="/user/profile_edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn btn-gray has-tooltip" title="Subscribe" aria-label="Subscribe" href="/sven.atom?private_token=vyxEf937XeWRN9gDqyXk">
                                <i class="fa fa-rss"></i>
                            </a>
                        </div>
                        <div class="profile-header">
                            <div class="avatar-holder">
                                <a target="_blank" rel="noopener noreferrer" href="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                    <img class="avatar s90" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png" /></a>
                            </div>
                            <div class="user-info">
                                <div class="cover-title">韦朝夺</div>
                                <div class="cover-desc member-date">
                                    <span class="middle-dot-divider">@sven</span>
                                    <span class="middle-dot-divider">Member since June 2, 2017</span></div>
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
                                    <a data-target="div#groups" data-action="groups" data-toggle="tab" href="/users/sven/groups">Groups</a></li>
                                <li class="js-contributed-tab">
                                    <a data-target="div#contributed" data-action="contributed" data-toggle="tab" href="/users/sven/contributed">Contributed projects</a></li>
                                <li class="js-projects-tab">
                                    <a data-target="div#projects" data-action="projects" data-toggle="tab" href="/users/sven/projects">Personal projects</a></li>
                                <li class="js-snippets-tab">
                                    <a data-target="div#snippets" data-action="snippets" data-toggle="tab" href="/users/sven/snippets">Snippets</a></li>
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
                                    <div class="user-calendar" data-href="/users/sven/calendar">
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