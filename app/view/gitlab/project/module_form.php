<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js?v=<?=$_version?>"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <div class="header-content">

            <? require_once VIEW_PATH.'gitlab/common/body/header-dropdown.php';?>
            <? require_once VIEW_PATH.'gitlab/common/body/header-logo.php';?>
            <div class="title-container">
                <h1 class="title"><a href="/dashboard/projects">Projects</a></h1>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-xs">
                        <div class="has-location-badge search search-form">
                            <form class="navbar-form" action="/search" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="✓">
                                <div class="search-input-container">
                                    <div class="location-badge">
                                        This project
                                    </div>
                                    <div class="search-input-wrap">
                                        <div class="dropdown" data-url="/search/autocomplete">
                                            <input type="search" name="search" id="search" placeholder="Search"
                                                   class="search-input dropdown-menu-toggle no-outline js-search-dashboard-options disabled"
                                                   spellcheck="false" tabindex="1" autocomplete="off" data-toggle="dropdown"
                                                   data-issues-path="/dashboard/issues"
                                                   data-mr-path="/dashboard/merge_requests">
                                            <div class="dropdown-menu dropdown-select">
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li> <a class="is-focused dropdown-menu-empty-link"> Loading... </a> </li>
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
                                <input type="hidden" name="group_id" id="group_id" class="js-search-group-options">
                                <input type="hidden" name="project_id" id="search_project_id" value="31"
                                       class="js-search-project-options" data-project-path="xphp" data-name="xphp"
                                       data-issues-path="/ismond/xphp/issues" data-mr-path="/ismond/xphp/merge_requests">
                                <input type="hidden" name="scope" id="scope" value="issues">
                                <input type="hidden" name="repository_ref" id="repository_ref">
                                <div class="search-autocomplete-opts hide" data-autocomplete-path="/search/autocomplete" data-autocomplete-project-id="31"></div>
                            </form>
                        </div> </li>

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
                            <i class="fa fa-hashtag fa-fw"></i> <span class="badge issues-count"> 1 </span>
                        </a>
                    </li>

                    <li>
                        <a title="Merge requests" aria-label="Merge requests" data-toggle="tooltip" data-placement="bottom"
                           data-container="body" href="/dashboard/merge_requests?assignee_id=15">
                            <svg width="15" height="20" viewBox="0 0 12 14" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 4.967a2.15 2.15 0 1 1 2.3 0v5.066a2.15 2.15 0 1 1-2.3 0V4.967zm7.85 5.17V5.496c0-.745-.603-1.346-1.35-1.346V6l-3-3 3-3v1.85c2.016 0 3.65 1.63 3.65 3.646v4.45a2.15 2.15 0 1 1-2.3.191z" fill-rule="nonzero"></path>
                            </svg>
                            <span class="badge hidden merge-requests-count"> 0 </span>
                        </a>
                    </li>
                    <li>
                        <a title="Todos" aria-label="Todos" class="shortcuts-todos" data-toggle="tooltip" data-placement="bottom"
                           data-container="body" href="/dashboard/todos">
                            <i class="fa fa-check-circle fa-fw"></i> <span class="badge hidden todos-count"> 0 </span>
                        </a>
                    </li>
                    <li class="header-user dropdown">
                        <a class="header-user-dropdown-toggle" data-toggle="dropdown" href="/sven">
                            <img width="26" height="26" class="header-user-avatar" src="/uploads/user/avatar/15/avatar.png" alt="Avatar"> <i class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu-nav dropdown-menu-align-right">
                            <ul>
                                <li> <a class="profile-link" aria-label="Profile" data-user="sven" href="/sven">Profile</a> </li>
                                <li> <a aria-label="Settings" href="/profile">Settings</a> </li>
                                <li class="divider"></li>
                                <li> <a class="sign-out-link" aria-label="Sign out" rel="nofollow" data-method="delete" href="<?=ROOT_URL?>users/sign_out">Sign out</a> </li>
                            </ul>
                        </div> </li>
                </ul>
            </div>

            <button class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <i class="fa fa-ellipsis-v"></i> </button>
            <div class="js-dropdown-menu-projects">
                <div class="dropdown-menu dropdown-select dropdown-menu-projects">
                    <div class="dropdown-title">
                        <span>Go to a project</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button>
                    </div>
                    <div class="dropdown-input">
                        <input type="search" id="" class="dropdown-input-field" placeholder="Search your projects" autocomplete="off">
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content"></div>
                    <div class="dropdown-loading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="container-fluid ">
            <div class="content" id="content-body">
                <h3 class="page-title">
                    New Tag
                </h3>
                <hr>
                <form id="new-tag-form" class="form-horizontal common-note-form tag-form js-quick-submit js-requires-input gfm-form" action="<?=ROOT_URL?>project/module/filter"
                      accept-charset="UTF-8" method="post">
                    <input name="utf8" type="hidden" value="">
                    <input type="hidden" name="authenticity_token" value=""><div class="form-group">
                        <label class="control-label" for="tag_name">Tag name</label>
                        <div class="col-sm-10">
                            <input type="text" name="tag_name" id="tag_name" required="required" tabindex="1" autofocus="autofocus" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ref">Create from</label>
                        <div class="col-sm-10">
                            <input type="text" name="ref" id="ref" value="master" required="required" tabindex="2" class="form-control">
                            <div class="help-block">Branch name or commit SHA</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="message">Message</label>
                        <div class="col-sm-10">
                            <textarea name="message" id="message" tabindex="3" class="form-control" rows="5"></textarea>
                            <div class="help-block">Optionally, add a message to the tag.</div>
                        </div>
                    </div>


                    <div class="form-actions text-right">
                        <button name="button" type="submit" class="btn btn-create disabled" tabindex="3" disabled="disabled">Create tag</button>
                        <a class="btn btn-cancel" href="<?=ROOT_URL?>project/module/filter">Cancel</a>
                    </div>
                </form><script>
                    var availableRefs = ["1-inword","dev","master","v1.2","v1.0"];

                    $("#ref").autocomplete({
                        source: availableRefs,
                        minLength: 1
                    });
                </script>

            </div>
        </div>

    </div>
</div>
</body>
</html>


</div>