<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/origin/origin.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

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
                                        <th class="js-pipeline-date pipeline-date">所属项目</th>
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
                <strong>{{name}}</strong>
            </td>
            <td>
                {{path}}
            </td>
            <td>
                {{description}}
            </td>
            <td>
                {{make_project project_ids ../projects}}
            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    <a class="list_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="list_for_delete btn btn-transparent  "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
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

        Handlebars.registerHelper('make_project', function(project_ids, projects ) {

            var html = '';
            if (project_ids == null || project_ids == undefined || project_ids == '') {
                return html;
            }
            var project_ids_arr = project_ids.split(',');
            project_ids_arr.forEach(function(project_id) {
                console.log(project_id);
                var project_name = '';
                for(var skey in schemes ){
                    if(projects[skey].id==project_id){
                        project_name = projects[skey].name;
                        break;
                    }
                }
                html += "<div class=\"branch-commit\">· <a class=\"commit-id monospace\" href=\"admin/issue_type/scheme/"+project_id+"\">"+project_name+"</a></div>";
            });
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/orgin/fetch_all",
            get_url:"/orgin/get",
            update_url:"/orgin/update",
            add_url:"/orgin/add",
            delete_url:"/orgin/delete",
            pagination_id:"pagination"
        }
        window.$origin = new Origin( options );
        window.$origin.fetchOrigins( );

    });

</script>
</body>
</html>