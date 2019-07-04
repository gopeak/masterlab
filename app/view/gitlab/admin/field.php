<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/field.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" media="print" href="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css" />

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="container-fluid">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_issue_left_nav.php';?>
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">字段</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-new btn_field_add js-key-create" data-target="#modal-field_add" data-toggle="modal" href="#modal-field_add">
                                        <i class="fa fa-plus"></i>
                                        新增字段
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">类型</th>
                                        <th class="js-pipeline-stages pipeline-info">标题</th>
                                        <th class="js-pipeline-date pipeline-date">关联界面</th>
                                        <th class="pipeline-info" style="text-align: center;">操作</th>
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

<div class="modal" id="modal-field_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add"
          action="<?=ROOT_URL?>admin/field/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增字段</h3>
                </div>

                <div class="modal-body overflow-x-hidden">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="params[options]" id="add_options" value="">

                    <div class="form-group">
                        <label class="control-label" for="id_name">类型:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select   id="field_type_id" name="params[field_type_id]" class="selectpicker  " showTick="true" title="选择字段类型"   >

                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label" for="id_name">字段key:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="id_name"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id_title">名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[title]" id="id_title"  value="" />
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
                </div>

                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-create js-key-modal-enter1" id="btn-field_add">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-field_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/field/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑字段</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="params[options]" id="edit_options" value="">

                    <div class="form-group">
                        <label class="control-label" for="id_name">字段key:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id_title">显示名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[title]" id="edit_title"  value="" />
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
                </div>

                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-save js-key-modal-enter2" id="btn-field_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>
    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#fields}}
        <tr class="commit">
            <td style="min-width: 60px" >
                <strong>{{name}}</strong>
            </td>
            <td style="min-width: 40px" >
                {{type}}
            </td>
            <td>
                {{title}}
            </td>
            <td style="min-width: 120px" >

            </td>
            <td style="min-width: 120px" >
                <div class="controls member-controls float-right">
                    {{#if_eq is_system '0'}}

                    <a class="list_for_edit btn btn-transparent btn-sm-self" href="#" data-value="{{id}}">编辑 </a>
                    <a class="list_for_delete btn btn-transparent btn-sm-self"  href="javascript:;" data-value="{{id}}">
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
            filter_url:"<?=ROOT_URL?>admin/field/fetch_all",
            get_url:"<?=ROOT_URL?>admin/field/get",
            update_url:"<?=ROOT_URL?>admin/field/update",
            add_url:"<?=ROOT_URL?>admin/field/add",
            delete_url:"<?=ROOT_URL?>admin/field/delete",
            pagination_id:"pagination"

        }
        window.$issueType = new Field( options );
        window.$issueType.fetchFields( );

        
        $("#modal-field_add").on('show.bs.modal', function (e) {
            keyMaster.addKeys([
                {
                    key: ['command+enter', 'ctrl+enter'],
                    'trigger-element': '.js-key-modal-enter1',
                    trigger: 'click'
                },
                {
                    key: 'esc',
                    'trigger-element': '.js-key-modal-close1',
                    trigger: 'click'
                }
            ])
        })

        $("#modal-field_edit").on('show.bs.modal', function (e) {
            keyMaster.addKeys([
                {
                    key: ['command+enter', 'ctrl+enter'],
                    'trigger-element': '.js-key-modal-enter2',
                    trigger: 'click'
                },
                {
                    key: 'esc',
                    'trigger-element': '.js-key-modal-close2',
                    trigger: 'click'
                }
            ])
        })

    });

</script>
</body>
</html>