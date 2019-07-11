<?php


?>
<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <!--    <script src="--><? //=ROOT_URL?><!--gitlab/assets/webpack/filtered_search.bundle.js"></script>-->
    <script src="<?= ROOT_URL ?>dev/js/project/project.js?v=<?= $_version ?>" type="text/javascript"   charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?= $_version ?>" type="text/javascript" charset="utf-8"></script>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/project/main.css?v=<?= $_version ?>">
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>

        <script>
            var findFileURL = "";
        </script>
        <div class="page-with-sidebar">


            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">
                    <div class="flash-container flash-container-page">
                    </div>
                </div>
                <div class="container-fluid container-limited">
                    <div class="content" id="content-body">
                        <div class="container-fluid">
                            <div class="top-area">
                                <ul class="nav-links issues-state-filters">
                                    <?php
                                    foreach ($type_list as $key => $item) {
                                        ?>
                                        <li class="">
                                            <a title="<?= $item['display_name'] ?>"
                                               href="javascript:void(0);"
                                               onclick="selectByType(<?= $key ?>, this)"><span> <?= $item['display_name'] ?> </span>
                                                <!--span class="badge"><?= $item['count'] ?></span-->
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="nav-controls row-fixed-content">
                                    <?php
                                    if ($is_admin) {
                                        ?>
                                        <a class="btn btn-create new-tag-btn js-key-create" data-key-mode="new-page"
                                           href="<?= ROOT_URL ?>project/main/new">
                                            创建项目
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>

                            <div class="js-projects-list-holder">
                                <ul class="projects-list" id="list_render_id">

                                </ul>
                                <div class="gl-pagination">

                                </div>

                            </div>


                            <!--div class="content-list pipelines">
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
                            </div-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script type="text/html" id="list_tpl">
    {{#projects}}
    <li class="project-row">
        {{#if avatar_exist}}
        <a href="#" class="avatar-image-container s40">
            <img src="{{avatar}}" class="avatar has-tooltip s40">
        </a>
        {{^}}
        <div class="avatar-container s40" style="display: block">
            <a class="project" href="<?= ROOT_URL ?>{{path}}/{{key}}">
                <div class="avatar project-avatar s40 identicon"
                     style="background-color: #E0F2F1; color: #555">{{first_word}}
                </div>
            </a>
        </div>
        {{/if}}
        <div class="project-details">
            <h3 class="prepend-top-0 append-bottom-0">
                <a class="project" href="<?= ROOT_URL ?>{{path}}/{{key}}">
                    <span class="project-full-name" style="color:#1b69b6">
                        <span class="namespace-name">
                        {{path}}
                        /
                        </span>
                        <span class="project-name">
                        {{key}}
                        </span>
                        <span class="project-name">
                        ({{name}})
                        </span>
                    </span>
                </a>
            </h3>
            <div class="description prepend-top-5">
                <span class="label-badge label-badge-gray" style="background-color: #f2f2f2;">{{type_name}}</span>
                <p data-sourcepos="1:1-1:54" dir="auto">{{description}}</p>
            </div>


        </div>
        <div class="controls project-controls">
            <div class="users-list">
                {{#if join_user_id_arr}}
                {{#each join_user_id_arr}}
                <div class="user-item">
                    <a data-hovercard-type="user" href="<?= ROOT_URL ?>{{../path}}/{{../key}}?经办人={{this.username}}">
                        <img class="avatar avatar-small" height="28" width="28" title="{{this.display_name}}"
                             alt="{{this.username}}" src="{{this.avatar}}">
                    </a>
                    {{#if is_leader}}
                    <p class="user-name">负责人</p>
                    {{/if}}
                </div>
                {{/each}}
                <a role="button" aria-label="跳转至项目用户" href="<?= ROOT_URL ?>{{path}}/{{key}}/settings_project_member"
                   class="users-btn">
                    ...
                </a>
                {{/if}}
            </div>
            <div class="project-time">
                <!-- <i class="fa fa-calendar"></i> -->
                {{create_time_text}}
            </div>
            <!--
            <span class="prepend-left-10 visibility-icon has-tooltip" data-container="body" data-placement="left" title="Private - Project access must be granted explicitly to each user.">
                <i class="fa fa-lock fa-fw"></i>
            </span>
            -->
        </div>
    </li>
    {{/projects}}
</script>


<script>

    var $projects = null;
    var _issueConfig = {
        "priority":<?=json_encode($priority)?>,
        "issue_types":<?=json_encode($issue_types)?>,
        "issue_status":<?=json_encode($issue_status)?>,
        "issue_resolve":<?=json_encode($issue_resolve)?>,
        "issue_module":<?=json_encode($project_modules)?>,
        "issue_version":<?=json_encode($project_versions)?>,
        "issue_labels":<?=json_encode($project_labels)?>,
        "users":<?=json_encode($users)?>,
        "projects":<?=json_encode($projects)?>
    };


    $(function () {
        var options = {
            list_render_id: "list_render_id",
            list_tpl_id: "list_tpl",
            filter_url: "<?=ROOT_URL?>projects/fetch_all"
        }
        window.$projects = new Project(options);
        window.$projects.fetchAll();

        $(".issues-state-filters li").eq(0).addClass("active");

    });

    function selectByType(typeId, selector) {
        var options = {
            list_render_id: "list_render_id",
            list_tpl_id: "list_tpl",
            filter_url: "/projects/fetch_all?typeId=" + typeId
        }

        if (selector) {
            $(selector).parent().addClass("active").siblings("li").removeClass("active");
        }

        window.$projects = new Project(options);
        window.$projects.fetchAll();
    }

</script>
</body>
</html>
