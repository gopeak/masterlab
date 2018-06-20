<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/workflow.js" type="text/javascript" charset="utf-8"></script>
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
                                工作流
                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">

                            <div class="project-item-select-holder">

                                <a class="btn btn-new btn_workflow_add" data-target="#modal-workflow_add" data-toggle="modal" href="#modal-workflow_add">
                                    <i class="fa fa-plus"></i>
                                    新增工作流
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
                                        <th class="js-pipeline-stages pipeline-info">最后修改</th>
                                        <th class="js-pipeline-date pipeline-info">关联方案</th>
                                        <th class="js-pipeline-date pipeline-info">步骤</th>
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



<div class="modal" id="modal-workflow_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">新增工作流</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add" action="/admin/workflow/create"   accept-charset="UTF-8" method="post">
                    <div class="form-group">
                        <label class="control-label" >名称:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="" name="params[name]" id="input_name" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" >描述:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="params[description]" id="textarea_description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-cancel" data-dismiss="modal" href="#"  >取消</a>
                        <button name="btn-next" type="button" class="btn btn-create btn-next" id="btn-next" >下一步</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-workflow_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">编辑工作流</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"  action="/admin/workflow/edit"   accept-charset="UTF-8" method="post">

                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" >名称:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="" name="params[name]" id="edit_name" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" >描述:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="params[description]" id="edit_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-save btn-next" id="btn-edit_next">下一步</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/html"  id="list_tpl">
    {{#workflow}}
        <tr class="commit">
            <td style="width:40%">
                <strong>{{name}}</strong><br>
                <span>{{description}}</span>
            </td>
            <td>
                {{update_time_text}}<br>
                {{display_name}}

            </td>
            <td>
                {{make_schemes scheme_ids ../workflow_schemes}}
            </td>
            <td>
                {{steps}}
            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    <a class="list_for_view btn btn-transparent " href="/admin/workflow/view/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">查看 </a>
                    <a class="list_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="list_for_delete btn btn-transparent "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                </div>

            </td>
        </tr>
    {{/workflow}}

</script>



<script type="text/javascript">

    var $Workflow = null;
    $(function() {

        Handlebars.registerHelper('make_schemes', function(scheme_ids, workflow_schemes ) {

            var html = '';
            if (scheme_ids == null || scheme_ids == undefined || scheme_ids == '') {
                return html;
            }
            var scheme_ids_arr = scheme_ids.split(',');
            scheme_ids_arr.forEach(function(type_id) {
                console.log(type_id);
                var type_name = '';
                for(var skey in workflow_schemes ){
                    if(workflow_schemes[skey].id==type_id){
                        type_name = workflow_schemes[skey].name;
                        break;
                    }
                }
                html += "<div class=\"branch-commit\">.<a class=\"commit-id monospace\" href=\"#\">"+type_name+"</a></div>";
            });
            return new Handlebars.SafeString( html );

        });

        $(".btn-next").click(function(){
            // @TODO ajax检查名称是否可用
            var url = $(this).closest('form').attr('action');
            window.location.href = url+'?'+$(this).closest('form').serialize();

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/admin/workflow/fetch_all",
            get_url:"/admin/workflow/get",
            update_url:"/admin/workflow/update",
            add_url:"/admin/workflow/add",
            delete_url:"/admin/workflow/delete",
            pagination_id:"pagination"

        }
        window.$Workflow = new Workflow( options );
        window.$Workflow.fetchWorkflow( );

    });

</script>
</body>
</html>