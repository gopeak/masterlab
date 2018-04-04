<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/origin/origin.js" type="text/javascript" charset="utf-8"></script>
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
                <div class="container-fluid"  >
                    <div class="top-area">

                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 0px">
                            <form id="filter_form" action="/admin/user/filter" accept-charset="UTF-8" method="get">

                                Organizations

                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">

                            <div class="project-item-select-holder">

                                <a class="btn btn-new btn_issue_type_add" href="/origin/create">
                                    <i class="fa fa-plus"></i>
                                    New Organization
                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="content-list pipelines">

                            <div class="table-holder">
                                <table class="table ci-table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">Key</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="js-pipeline-date pipeline-date">项目</th>
                                        <th   style=" float: right" >操作</th>
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



<script type="text/html"  id="list_tpl">
    {{#origins}}
        <tr class="commit">
            <td>
                <span class="list-item-name">
                    <img class="avatar s40" alt="" src="{{avatar}}">
                    <strong>
                    <a href="/{{path}}">{{name}}</a>
                            {{#if_eq scope '1'}}
                                <span class="visibility-icon has-tooltip" data-container="body" data-placement="right" title=""
                                      data-original-title="Private - The group and its projects can only be viewed by members.">
                                <i class="fa fa-lock"></i>
                                </span>
                            {{/if_eq}}
                            {{#if_eq scope '2'}}
                                    <span class="visibility-icon has-tooltip" data-container="body" data-placement="right" title=""
                                          data-original-title="Internal - The project can be cloned by any logged in user..">
                                    <i class="fa fa-shield "></i>
                                    </span>
                            {{/if_eq}}
                            {{#if_eq scope '3'}}
                                <span class="visibility-icon has-tooltip" data-container="body" data-placement="right" title=""
                                      data-original-title="Public - The project can be cloned without any authentication.">
                                <i class="fa fa-globe"></i>
                                </span>
                            {{/if_eq}}


                    </strong>
                 </span>
            </td>
            <td>
                {{path}}
            </td>
            <td>
                {{description}}
            </td>
            <td>
                {{#each projects}}
                    <div class="branch-commit">· <a class="commit-id monospace" href="/{{../path}}/{{key}}">{{name}}</a></div>
                {{/each}}
                {{#if is_more}}
                    <div class="branch-commit">· <a class="commit-id monospace" href="/{{path}}"><strong>More</strong></a></div>
                {{/if}}
            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    <a class="list_for_edit btn btn-transparent " href="/origin/edit/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="list_for_delete btn btn-transparent  "  href="javascript:;" data-id="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                </div>

            </td>
        </tr>
    {{/origins}}

</script>



<script type="text/javascript">

    var $origin = null;
    $(function() {

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/origin/fetch_all",
            get_url:"/origin/get",
            update_url:"/origin/update",
            add_url:"/origin/add",
            delete_url:"/origin/delete",
            pagination_id:"pagination"
        }
        window.$origin = new Origin( options );
        window.$origin.fetchAll( );

    });

</script>
</body>
</html>