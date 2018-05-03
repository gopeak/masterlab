<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <script src="<?=ROOT_URL?>dev/js/project/project.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
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
                <h1 class="title"><a href="/project/main/projects">Projects</a></h1>
            </div>
            <? require_once VIEW_PATH.'gitlab/common/body/header-navbar-collapse.php';?>
            <button class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <i class="fa fa-ellipsis-v"></i> </button>
            <? require_once VIEW_PATH.'gitlab/common/body/header-js-dropdown-menu-projects.php';?>
        </div>
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
                <div class="container-fluid">
                    <div class="top-area">
                        <ul class="nav-links issues-state-filters">
                            <li class="active">
                                <a id="state-opened" title="Filter by issues that are currently opened."
                                   href="#"><span> All </span>
                                    <span class="badge">1</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="state-all" title="Filter by issues that are currently closed."
                                   href="#"><span> Software </span>
                                    <span class="badge">0</span>
                                </a></li>
                            <li class="">
                                <a id="state-all" title="Show all issues."
                                   href="#"><span>Business</span>
                                    <span class="badge">1</span> </a>
                            </li>
                        </ul>
                        <div class="nav-controls row-fixed-content">
                            <form action="/ismond/xphp/tags?sort=updated_desc" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><input type="search" name="search" id="tag-search" placeholder="Filter by tag name" class="form-control search-text-input input-short" spellcheck="false" value="">
                            </form><div class="dropdown">
                                <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
<span class="light">

</span>
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-align-right">
                                    <li>
                                        <a href="/ismond/xphp/tags?sort=name_asc">Name
                                        </a><a href="/ismond/xphp/tags?sort=updated_desc">Last updated
                                        </a><a href="/ismond/xphp/tags?sort=updated_asc">Oldest updated
                                        </a></li>
                                </ul>
                            </div>
                            <a class="btn btn-create new-tag-btn" href="/project/main/_new">
                                创建项目
                            </a></div>

                    </div>

                    <div class="content-list pipelines">

                        <div class="table-holder">
                            <table class="table ci-table">
                                <thead>
                                <tr>
                                    <th class="js-pipeline-info pipeline-info">类型</th>
                                    <th class="js-pipeline-commit pipeline-commit">项目</th>
                                    <th class="js-pipeline-stages pipeline-info">键值</th>
                                    <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">负责人</span></th>
                                    <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">网址</span></th>
                                    <th class="js-pipeline-date pipeline-date">创建时间</th>
                                    <th class="js-pipeline-actions pipeline-actions"></th>
                                </tr>
                                </thead>

                                <tbody id="list_render_id">

                                <?php if(empty($list)){ echo '无项目';?>

                                <?php } else { ?>
                                    <?php foreach ($list as $item) { ?>
                                        <tr class="commit">
                                            <td>
                                                <i class="fa fa-code-fork"></i>
                                                <a href="#"  class="commit-id monospace">Scrum</a>
                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="/project/main/home?project_id=<?=$item['id']?>&skey=<?= sprintf('%u', crc32( $item['key']))?>" class="commit-row-message">
                                                        <?php echo $item['name'];?>
                                                    </a>
                                                </span>
                                                        </strong>
                                                    </p>
                                                    <div class="icon-container">
                                                        <i class="fa fa-tag"></i>
                                                    </div>
                                                    <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                    <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <a href="#" class="commit-id monospace">ismond/xphp</a>

                                            </td>
                                            <td  >
                                        <span class="list-item-name">
                                            <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                            <strong>
                                            <a href="/sven">韦朝夺</a>
                                            </strong>
                                            <span class="cgray">@sven</span>
                                            <span class="label label-success prepend-left-5">It's you</span>
                                            ·
                                            <a class="member-group-link" href="/ismond">ismond</a>

                                         </span>

                                            </td>
                                            <td  >
                                                <a href="#" class="commit-id monospace">http://</a>


                                            </td>
                                            <td class="pipelines-time-ago">
                                                <!---->
                                                <p class="finished-at">
                                                    <i class="fa fa-calendar"></i>
                                                    <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                        4 days ago
                                                    </time>
                                                </p>
                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="pull-right btn-group">

                                                </div>
                                            </td>
                                        </tr>
                                    <?php }} ?>
                                </tbody>


                            </table>
                        </div>
                        <div class="gl-pagination" pagenum="1" count="56">
                            <ul class="pagination clearfix">
                                <li class="prev disabled">
                                    <a>Prev</a>
                                </li>
                                <li class="page active">
                                    <a>1</a>
                                </li>
                                <li class="page">
                                    <a>2</a>
                                </li>
                                <li class="page">
                                    <a>3</a>
                                </li>
                                <li class="next">
                                    <a>Next</a>
                                </li>
                                <li class="">
                                    <a>Last »</a>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


<script type="text/html"  id="list_tpl">
    {{#projects}}
    <tr class="commit">
        <td>
            <i class="fa fa-code-fork"></i>
            <a href="#"  class="commit-id monospace">Scrum</a>
        </td>
        <td>
            <div class="branch-commit">
                <p class="commit-title">
                    <strong>
                        <span>
                            <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                     title="guosheng" class="avatar has-tooltip s20">
                            </a>
                            <a href="/{{path}}/{{key}}" class="commit-row-message">
                                {{name}}
                            </a>
                        </span>
                    </strong>
                </p>

                <span href="#" class="commit-id monospace">{{description}}</span>

            </div>
        </td>
        <td>
            <a href="#" class="commit-id monospace">{{key}}</a>
        </td>
        <td>
            <span class="list-item-name">
                <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                <strong>
                <a href="/sven">{{leadername}}</a>
                </strong>
                <span class="cgray">@sven</span>
                <span class="label label-success prepend-left-5">It's you</span>
                ·
                <a class="member-group-link" href="/ismond">ismond</a>

             </span>

        </td>
        <td  >
            <a href="#" class="commit-id monospace">http://</a>

        </td>
        <td class="pipelines-time-ago">
            <!---->
            <p class="finished-at">
                <i class="fa fa-calendar"></i>
                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                    {{create_time}}
                </time>
            </p>
        </td>
        <td class="pipeline-actions">
            <div class="pull-right btn-group">

            </div>
        </td>
    </tr>
    {{/projects}}
</script>

<script>

    var $projects = null;
    $(function() {

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/projects/fetch_all"
        }
        window.$projects = new Project( options );
        window.$projects.fetchAll( );

    });

</script>
</body>
</html>
