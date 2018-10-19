<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/org/org.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>

</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

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
                                <a title="组织" href="#"><span>组织</span>
                                </a>
                            </li>
                        </ul>
                        <div class="nav-controls">
                            <div class="project-item-select-holder">

                                <a class="btn btn-new btn_issue_type_add js-key-create" data-key-mode="new-page" href="/org/create">
                                    <i class="fa fa-plus"></i>
                                    新 增
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="content-list pipelines">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">Key</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="js-pipeline-date pipeline-date">项目</th>
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



<script type="text/html"  id="list_tpl">
    {{#orgs}}
        <tr class="commit">
            <td>
                <span class="list-item-name">
                    <img class="avatar s40" alt="" src="{{avatar}}">
                    <strong>
                    <a href="/org/detail/{{id}}">{{name}}</a>
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
                <a class="btn btn-transparent " href="/org/detail/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">详情 </a>
            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    {{#if_eq path 'default'}}

                    {{^}}
                    <a class="list_for_edit btn btn-transparent " href="/org/edit/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="list_for_delete btn btn-transparent  "  href="javascript:;" data-id="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
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