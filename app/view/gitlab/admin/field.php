<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/field.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" media="print" href="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css" />

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

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
                                字段
                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">
                            <div class="project-item-select-holder">
                                <a class="btn btn-new btn_field_add" data-target="#modal-field_add" data-toggle="modal" href="#modal-field_add">
                                    <i class="fa fa-plus"></i>
                                    New Custom Field
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
                                        <th class="js-pipeline-stages pipeline-info">类型</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="js-pipeline-date pipeline-date">关联界面</th>
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



<div class="modal" id="modal-field_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">新增字段</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add" action="/admin/field/add"   accept-charset="UTF-8" method="post">

                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="params[options]" id="add_options" value="">

                    <div class="form-group">
                        <label class="control-label" for="id_name">类型:<span style="color: red"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select   id="field_type_id" name="params[field_type_id]" class="selectpicker  " showTick="true" title="选择字段类型"   >

                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                    <hr>
                    <div class="form-group">
                        <label class="control-label" for="id_option_value">选项</label>
                        <div class="row" >
                            <div class="col-md-3"  >
                                <input type="text" class="form-control" name="params[option_value]" id="add_option_value"  value="" placeholder="输入选项的值" >
                            </div>
                            <div class="col-md-3" >
                                <input type="text" class="form-control" name="params[option_name]" id="add_option_name"  value="" placeholder="输入选项的名称" >
                            </div>
                            <div class="col-md-2">
                                <button  type="button" class="btn" id="btn-options_add" ><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" ></label>
                        <div class="col-sm-8">
                                <table class="table ci-table">
                                    <tbody id="add_option_render_id">
                                    </tbody>
                                </table>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-create" id="btn-field_add">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-field_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">编辑字段</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"  action="/admin/field/update"   accept-charset="UTF-8" method="post">

                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="params[options]" id="edit_options" value="">

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
                    <hr>
                    <div class="form-group">
                        <label class="control-label" for="id_option_value">选项</label>
                        <div class="row" >
                            <div class="col-md-3"  >
                                <input type="text" class="form-control" name="params[option_value]" id="edit_option_value"  value="" placeholder="输入选项的值" >
                            </div>
                            <div class="col-md-3" >
                                <input type="text" class="form-control" name="params[option_name]" id="edit_option_name"  value="" placeholder="输入选项的名称" >
                            </div>
                            <div class="col-md-2">
                                <button  type="button" class="btn" id="btn-options_edit" ><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" ></label>
                        <div class="col-sm-8">
                            <table class="table ci-table">
                                <tbody id="edit_option_render_id">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-save" id="btn-field_update">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/html"  id="list_tpl">
    {{#fields}}
        <tr class="commit">
            <td  style="min-width: 60px" >
                <strong>{{name}}</strong>
            </td>
            <td  style="min-width: 40px" >
                {{type}}
            </td>
            <td>
                {{description}}
            </td>
            <td  style="min-width: 120px" >

            </td>
            <td style="min-width: 120px" >
                <div class="controls member-controls " style="float: right">
                    {{#if_eq is_system '0'}}

                    <a class="list_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="list_for_delete btn btn-transparent  "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                    {{/if_eq}}
                </div>

            </td>
        </tr>
    {{/fields}}

</script>



<script type="text/javascript">

    var $issueType = null;
    $(function() {

        if("undefined" != typeof Handlebars.registerHelper){
            Handlebars.registerHelper('if_eq', function(v1, v2, opts) {
                if(v1 == v2)
                    return opts.fn(this);
                else
                    return opts.inverse(this);
            });
        }

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/admin/field/fetch_all",
            get_url:"/admin/field/get",
            update_url:"/admin/field/update",
            add_url:"/admin/field/add",
            delete_url:"/admin/field/delete",
            pagination_id:"pagination"

        }
        window.$issueType = new Field( options );
        window.$issueType.fetchFields( );

    });

</script>
</body>
</html>