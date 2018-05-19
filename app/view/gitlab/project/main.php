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
                <div class="container-fluid">
                    <div class="top-area">
                        <ul class="nav-links issues-state-filters">
                            <li class="active">
                                <a title="Filter by issues that are currently opened."
                                   href="/projects"><span> All </span>
                                    <span class="badge">tab操作待优化</span>
                                </a>
                            </li>
                            <?php
                            foreach ($type_list as $key=>$count){
                            ?>
                            <li class="">
                                <a title="Filter by issues that are currently closed."
                                   href="/projects"><span> <?= $key ?> </span>
                                    <span class="badge"><?= $count ?></span>
                                </a>
                            </li>
                            <?php } ?>
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
                                    <th class="js-pipeline-stages pipeline-info">键值</th>
                                    <th class="js-pipeline-commit pipeline-commit">项目</th>
                                    <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">负责人</span></th>
                                    <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">网址</span></th>
                                    <th class="js-pipeline-date pipeline-date">创建时间</th>
                                </tr>
                                </thead>

                                <tbody id="list_render_id">

                                </tbody>


                            </table>
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
            <a href="#"  class="commit-id monospace">{{type_name}}</a>
        </td>
        <td>
            <a href="#" class="commit-id monospace">{{key}}</a>
        </td>
        <td>
            <div class="branch-commit">
                <p class="commit-title">
                    <strong>
                        <span>
                            <a href="#" class="avatar-image-container">
                                <img src="<?=ATTACHMENT_URL?>{{avatar}}"  class="avatar has-tooltip s20">
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
            <span class="list-item-name">
                <img class="avatar s40" alt="" src="">
                {{make_user lead ../users}}
                <strong>
                <a href="/sven">{{leader_display}}</a>
                </strong>

             </span>

        </td>
        <td  >
            <a href="<?=ROOT_URL?>{{path}}/{{key}}" class="commit-id monospace"><?=ROOT_URL?>{{path}}/{{key}}</a>

        </td>
        <td class="pipelines-time-ago">
            <!---->
            <p class="finished-at">
                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="{{create_time_origin}}">
                    {{create_time_text}}
                </time>
            </p>
        </td>
    </tr>
    {{/projects}}
</script>

<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
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
