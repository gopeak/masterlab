<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

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

    <div class="scrolling-tabs-container sub-nav-scroll">
        <div class="fade-left">
            <i class="fa fa-angle-left"></i>
        </div>
        <div class="fade-right">
            <i class="fa fa-angle-right"></i>
        </div>
        <div class="nav-links sub-nav scrolling-tabs">
            <?php include VIEW_PATH.'gitlab/project/common-main-nav-links-sub-nav.php'; ?>
        </div>
    </div>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">

                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar" >
                        <h4 class="prepend-top-0" style="margin-left: 10px">
                            项目分类
                        </h4>
                        <p style="margin-left: 10px">
                            项目分类说明
                            <span>如PC Web iOS Android</span>
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <div class="top-area adjust">
                            <div class="nav-text row-main-content" style="width: 80%;">
                                <form class="js-requires-input" action="/ismond/xphp/group_links" accept-charset="UTF-8" method="post">
                                    <input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="">
                                    <div class="form-group  col-md-2">
                                        <input style="margin-left: -15px;" type="text" name="name" id="category_name"  placeholder="名称" required="required"
                                               tabindex="1" autofocus="autofocus" class="form-control">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="description" id="description"  placeholder="描述" required="required"
                                               tabindex="2"   class="form-control">

                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="submit" name="commit" value="Add" class="btn btn-create disabled" disabled="disabled">

                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Members with access to
                                <strong>xphp</strong>
                                <span class="badge">16</span>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">
                                        <input type="search" name="search" id="search" placeholder="Find existing members by name" class="form-control" spellcheck="false" value="">
                                        <button aria-label="Submit search" class="member-search-btn" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="dropdown inline member-sort-dropdown">
                                            <button class="dropdown-menu-toggle " type="button" data-toggle="dropdown"><span class="dropdown-toggle-text ">Name, ascending</span><i class="fa fa-chevron-down"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-selectable">
                                                <li class="dropdown-header">
                                                    Sort by
                                                </li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_asc">Access level, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_desc">Access level, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=last_joined">Last joined
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_joined">Oldest joined
                                                    </a></li>
                                                <li>
                                                    <a class="is-active" href="/ismond/xphp/settings/members?sort=name_asc">Name, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=name_desc">Name, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=recent_sign_in">Recent sign in
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_sign_in">Oldest sign in
                                                    </a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </form></div>
                            <ul class="flex-list content-list">

                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">
                                        <a href="#"><strong><span class="item-title">v1.2</span></strong></a>
                                        <div class="block-truncated">
                                            <div class="branch-commit">

                                                <span   >描述........................................</span>
                                                ·
                                                <span class="str-truncated">
                                                    <a class="commit-id monospace" href="#">关联项目1</a>
                                                    <a class="commit-id monospace" href="#">关联项目2</a>
                                                </span>
                                                <time class="js-timeago js-timeago-render hidden" title="" datetime="2017-07-29T07:49:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 3:49pm GMT+0800">2 months ago</time>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-fixed-content controls">

                                        <a class="btn has-tooltip" title="Edit release notes" data-container="body" href="#"><i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-remove remove-row has-tooltip " title="Delete tag" data-confirm="Deleting the 'v1.2' tag cannot be undone. Are you sure?" data-container="body" data-remote="true" rel="nofollow" data-method="delete" href="#"><i class="fa fa-trash-o"></i>
                                        </a></div>
                                </li>


                            </ul>
                        </div>



                    </div>
                </div>


        </div>
    </div>
</div>
</body>
</html>


</div>