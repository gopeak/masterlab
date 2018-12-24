<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
<!--    <script src="--><?//=ROOT_URL?><!--gitlab/assets/webpack/filtered_search.bundle.js"></script>-->
    <script src="<?=ROOT_URL?>dev/js/project/project.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
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
                            foreach ($type_list as $key=>$item){
                            ?>
                            <li class="">
                                <a title="Filter by issues that are currently closed."
                                   href="javascript:void(0);" onclick="selectByType(<?=$key?>)"><span> <?=$item['display_name']?> </span>
                                    <span class="badge"><?=$item['count']?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="nav-controls row-fixed-content">
                            <?php
                            if($is_admin) {
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
<script type="text/html"  id="list_tpl">
    {{#projects}}
    <li class="project-row">
            {{#if avatar_exist}}
            <a href="#" class="avatar-image-container s40">
                <img src="{{avatar}}"  class="avatar has-tooltip s40">
            </a>
            {{^}}
            <div class="avatar-container s40" style="display: block">
                <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
                    <div class="avatar project-avatar s40 identicon"
                         style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                </a>
            </div>
            {{/if}}
        <div class="project-details">
            <h3 class="prepend-top-0 append-bottom-0">
                <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
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

                <a style="color:#1b69b6" href="<?=ROOT_URL?>{{path}}/{{key}}/issues?sys_filter=assignee_mine"  >分配给我的</a>
            </div>

        </div>
        <div class="controls">

            <span class="prepend-left-10">
                <i class="fa fa-star"></i>
                {{create_time_text}}
            </span>
            <!--
            <span class="prepend-left-10 visibility-icon has-tooltip" data-container="body" data-placement="left" title="Private - Project access must be granted explicitly to each user.">
                <i class="fa fa-lock fa-fw"></i>
            </span>
            -->
        </div>
    </li>
    {{/projects}}
</script>




<!--script type="text/html"  id="list_tpl">
    {{#projects}}
    <tr class="commit">
        <td>
            <i class="fa fa-code-fork"></i>
            <span class="commit-id monospace">{{type_name}}</span>
        </td>
        <td>
            <a href="<?=ROOT_URL?>{{path}}/{{key}}" class="commit-id monospace">{{key}}</a>
        </td>
        <td>
            <div class="branch-commit">
                {{#if avatar_exist}}
                    <a href="#" class="avatar-image-container">
                        <img src="{{avatar}}"  class="avatar has-tooltip s40">
                    </a>
                {{^}}
                    <div class="avatar-container s40" style="display: block">
                        <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
                            <div class="avatar project-avatar s40 identicon"
                                 style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                        </a>
                    </div>
                {{/if}}
                <p class="commit-title">
                    <strong>
                        <span>
                            <a href="<?=ROOT_URL?>{{path}}/{{key}}" class="commit-row-message">
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
                {{user_html lead }}
                <strong>
                <a href="/user/profile/{{lead}}">{{leader_display}}</a>
                </strong>

             </span>

        </td>
        <td  >
            <a href="/{{path}}/{{key}}" class="commit-id monospace">/{{path}}/{{key}}</a>

        </td>
        <td class="pipelines-time-ago">
            <p class="finished-at">
                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="{{create_time_origin}}">
                    {{create_time_text}}
                </time>
            </p>
        </td>
    </tr>
    {{/projects}}
</script-->

<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js"></script>
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


    $(function() {

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"<?=ROOT_URL?>projects/fetch_all"
        }
        window.$projects = new Project( options );
        window.$projects.fetchAll( );

    });

    function selectByType(typeId) {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/projects/fetch_all?typeId="+typeId
        }
        window.$projects = new Project( options );
        window.$projects.fetchAll( );
    }

</script>
</body>
</html>
