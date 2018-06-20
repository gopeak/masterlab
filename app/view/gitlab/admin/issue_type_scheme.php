<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="/dev/js/admin/issue_type_scheme.js" type="text/javascript" charset="utf-8"></script>
    <script src="/dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="/dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="/dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

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
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_issue_left_nav.php';?>
                <div class="container-fluid"  style="margin-left: 160px">
                    <div class="top-area">

                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 0px">
                            <form id="filter_form" action="/admin/user/filter" accept-charset="UTF-8" method="get">

                                问题类型方案

                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">

                            <div class="project-item-select-holder">

                                <a class="btn btn-new btn_issue_type_scheme_add" data-target="#modal-issue_type_scheme_add" data-toggle="modal" href="#modal-issue_type_scheme_add">
                                    <i class="fa fa-plus"></i>
                                    New Issue Type Scheme
                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="content-list pipelines">

                            <div class="table-holder">
                                <table class="table ci-table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">方案</th>
                                        <th class="js-pipeline-stages pipeline-info">问题类型</th>
                                        <th class="js-pipeline-date pipeline-info">项目</th>
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



<div class="modal" id="modal-issue_type_scheme_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">新增问题类型方案</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add" action="/admin/issue_type_scheme/add"   accept-charset="UTF-8" method="post">

                    <input type="hidden" name="format" id="format" value="json">
                    <div class="form-group">
                            <label class="control-label" for="id_name">名称:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[name]" id="id_name"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_description">描述:</label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[description]" id="id_description"  value="" />
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="control-label" for="id_font_icon">问题:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="id_issue_types" name="params[issue_types][]" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"  multiple title="选择拥有的问题类型&nbsp;&nbsp;&nbsp;"   ></select>


                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-create" id="btn-issue_type_scheme_add">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-issue_type_scheme_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">编辑问题类型方案</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"  action="/admin/issue_type_scheme/update"   accept-charset="UTF-8" method="post">

                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="id_name">显示名称:<span style="color: red"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[description]" id="edit_description"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_issue_types">问题:</label>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <select id="edit_issue_types" name="params[issue_types][]" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"  multiple title="选择拥有的问题类型&nbsp;&nbsp;&nbsp;"   >

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-save" id="btn-issue_type_scheme_update">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/html"  id="list_tpl">
    {{#issue_type_schemes}}
        <tr class="commit">
            <td style="width:40%">
                <strong>{{name}}</strong><br>
                <span>{{description}}</span>
            </td>
            <td>
                {{make_types type_ids ../issue_types}}
            </td>
            <td>
                {{make_projects project_ids ../projects}}
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
    {{/issue_type_schemes}}

</script>



<script type="text/javascript">

    var $IssueTypeScheme = null;
    $(function() {

        Handlebars.registerHelper('make_types', function(type_ids, issue_types ) {

            var html = '';
            if (type_ids == null || type_ids == undefined || type_ids == '') {
                return html;
            }
            var scheme_ids_arr = type_ids.split(',');
            scheme_ids_arr.forEach(function(type_id) {
                console.log(type_id);
                var type_name = '';
                var type_font_icon = '';
                for(var skey in issue_types ){
                    if(issue_types[skey].id==type_id){
                        type_name = issue_types[skey].name;
                        type_font_icon = issue_types[skey].font_awesome;
                        break;
                    }
                }
                html += "<div class=\"branch-commit\"><i class='fa "+type_font_icon+"'></i> <a class=\"commit-id monospace\" href=\"#\">"+type_name+"</a></div>";
            });
            return new Handlebars.SafeString( html );

        });
        Handlebars.registerHelper('make_projects', function(project_ids, projects ) {

            var html = '';
            if (project_ids == null || project_ids == undefined || project_ids == '') {
                return html;
            }
            var project_ids_arr = project_ids.split(',');
            project_ids_arr.forEach(function(project_id) {
                console.log(project_id);
                var project_name = '';
                for(var skey in projects ){
                    if(projects[skey].id==project_id){
                        project_name = projects[skey].name;
                        break;
                    }
                }
                html += "<div class=\"branch-commit\"> <a class=\"commit-id monospace\" href=\"#\">"+project_name+"</a></div>";
            });
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/admin/issue_type_scheme/fetch_all",
            get_url:"/admin/issue_type_scheme/get",
            update_url:"/admin/issue_type_scheme/update",
            add_url:"/admin/issue_type_scheme/add",
            delete_url:"/admin/issue_type_scheme/delete",
            pagination_id:"pagination"

        }
        window.$IssueTypeScheme = new IssueTypeScheme( options );
        window.$IssueTypeScheme.fetchIssueTypeSchemes( );

    });

</script>
</body>
</html>