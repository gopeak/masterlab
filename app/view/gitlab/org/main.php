<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/org/org.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>

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
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid container-limited"  >
                    <div class="top-area">
                        <ul class="nav-links user-state-filters">
                            <li class="active" data-value="">
                                <a title="组 织" href="#"><span>组 织</span>
                                </a>
                            </li>
                        </ul>
                        <div class="nav-controls">
                            <div class="project-item-select-holder">
                                <?php
                                if($is_admin) {
                                    ?>
                                    <a class="btn btn-new btn_issue_type_add js-key-create" data-key-mode="new-page"
                                       href="/org/create">
                                        <i class="fa fa-plus"></i>
                                        新 增
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="content-list pipelines">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info" style="min-width:20%">组 织</th>
                                        <th class="js-pipeline-date pipeline-date" style="min-width:40%">包含项目</th>
                                        <th style="text-align: right;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="list_render_id">


                                    </tbody>
                                </table>
                            </div>
                            <div class="gl-pagination" id="pagination">

                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#orgs}}
        <tr class="commit">
            <td>
                <span class="list-item-name">
                    {{#if avatarExist}}
                        <img src="{{avatar}}"  class="avatar s40">
                    {{^}}
                        <div class="avatar-container s40" style="display: block">
                                <div class="avatar project-avatar s40 identicon"
                                     style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                        </div>
                    {{/if}}
                    <strong style="line-height: 40px;">
                    <a href="/org/detail/{{id}}">{{name}}</a>
                    </strong>
                     {{path}}
                 </span>
            </td>

            <td>
                {{#each projects}}
                    {{#if this.avatar_exist}}
                    <div class="user-item">
                        <a data-hovercard-type="user s26" href="/{{this.path}}/{{this.key}}">
                            <img class="avatar avatar-small s26" title="{{this.name}}"  alt="{{this.name}}" src="{{this.avatar}}">
                        </a>
                    </div>
                    {{^}}
                    <div class="avatar-container s26" style="display: block">
                        <a class="project" href="/{{this.path}}/{{this.key}}" title="{{this.name}}"  alt="{{this.name}}">
                            <div class="avatar project-avatar s26 identicon"
                                 style="background-color: #E0F2F1; color: #555;font-size: 18px">{{this.first_word}}
                            </div>
                        </a>
                    </div>
                    {{/if}}
                {{/each}}
                {{#if is_more}}
                <a role="button" aria-label="更多项目" href="/org/detail/{{id}}"
                   class="users-btn s26">
                    ...
                </a>
                {{/if}}

            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    <a class="btn btn-transparent " href="/org/detail/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">详情 </a>
                    {{#if_eq path 'default'}}
                    <span title="不可删除" style="color: grey;font-size: 12px">系统预置</span>
                    {{^}}
                    <?php
                    if($is_admin) {
                        ?>
                        <a class="list_for_edit btn btn-transparent " href="/org/edit/{{id}}" data-value="{{id}}"
                           style="padding: 6px 2px;">编辑 </a>
                        <a class="list_for_delete btn btn-transparent  " href="javascript:;" data-id="{{id}}"
                           style="padding: 6px 2px;">
                            <i class="fa fa-trash"></i>
                            <span class="sr-only">删除</span>
                        </a>
                        <?php
                    }
                    ?>
                    {{/if_eq}}
                </div>

            </td>
        </tr>
    {{/orgs}}

</script>

<script type="text/javascript">

    var $org = null;
    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/org/fetch_all",
            get_url:"/org/get",
            update_url:"/org/update",
            add_url:"/org/add",
            delete_url:"/org/delete",
            pagination_id:"pagination"
        }
        window.$org = new Org( options );
        window.$org.fetchAll( );
    });

</script>
</body>
</html>