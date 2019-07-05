<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/workflow_scheme.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
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
                                    <a href="#">工作流方案</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-new btn_workflow_scheme_add js-key-create" data-target="#modal-workflow_scheme_add" data-toggle="modal" href="#modal-workflow_scheme_add">
                                        <i class="fa fa-plus"></i>
                                        新增工作流方案
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">项目</th>
                                        <th class="js-pipeline-date pipeline-info">关联工作流</th>
                                        <th>操作</th>
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

<div class="modal" id="modal-workflow_scheme_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add"
          action="<?=ROOT_URL?>admin/workflow_scheme/create"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增工作流方案</h3>
                </div>

                <div class="modal-body overflow-x-hidden">
                    <div class="row">
                        <div class="col-lg-12">
                        <input type="hidden" name="params[issue_type_workflow]" id="add_issue_type_workflow">
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

                        <hr>
                        <div class="form-group ">
                            <label class="control-label" >工作流定义:</label>
                            <div class="row">
                                <div class="btn-group">
                                    <div class="btn-group">
                                        <select id="issue_type_ids" name="params[issue_type_ids][]" class="selectpicker  " showTick="true"   multiple title="选择事项类型"   ></select>
                                    </div>
                                    <div class="btn-group">
                                        <select id="workflow_id" name="params[workflow_id]" class="selectpicker  " showTick="true" title="选择工作流"   ></select>
                                    </div>
                                    <button name="btn-issue_type_workflow_add" type="button" class="btn" id="btn-issue_type_workflow_add" >添加</button>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" ></label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <table class="table ci-table">
                                        <tbody id="add_list_render_id">
                                        <tr class="commit">
                                            <td  ><strong>未分配的事项类型</strong></td>
                                            <td>--></td>
                                            <td>默认工作流</td>
                                            <td  ></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="form-actions modal-footer">
                    <a class="btn btn-cancel" data-dismiss="modal" href="#"  >取消</a>
                    <button name="btn-next" type="button" class="btn btn-create js-key-modal-enter1" id="btn-workflow_scheme_add" >保存</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-workflow_scheme_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/workflow_scheme/edit"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑工作流方案</h3>
                </div>

                <div class="modal-body overflow-x-hidden">
                    <input type="hidden" name="params[issue_type_workflow]" id="edit_issue_type_workflow">
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
                    <hr>
                    <div class="form-group ">
                        <label class="control-label" >工作流定义:</label>
                        <div class="row">
                            <div class="btn-group">
                                
                            
                            <div class="btn-group">
                                <select   id="edit_issue_type_ids" name="params[issue_type_ids][]" class="selectpicker  " showTick="true"   multiple title="选择事项类型"   >

                                </select>
                            </div>
                            <div class="btn-group">
                                <select   id="edit_workflow_id" name="params[workflow_id]" class="selectpicker  " showTick="true" title="选择工作流"   >

                                </select>
                            </div>
                                <button name="btn-issue_type_workflow_add" type="button" class="btn" id="btn-issue_type_workflow_edit" >添加</button>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label" ></label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <table class="table ci-table">
                                    <tbody id="edit_list_render_id">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="edit_issue_type_workflow_save" type="button" class="btn btn-create js-key-modal-enter2" id="btn-workflow_scheme_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#workflow_scheme}}
        <tr class="commit">
            <td style="width:40%">
                <strong>{{name}}</strong><br>
                <span>{{description}}</span>
            </td>
            <td> 

            </td>
            <td>
                {{make_relation relation}}
            </td>
            <td  >
                <a class="list_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>

                {{#if_eq is_system '0'}}
                <a class="list_for_delete btn btn-transparent "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                    <i class="fa fa-trash"></i>
                    <span class="sr-only">删除</span>
                </a>
                {{/if_eq}}

            </td>
        </tr>
    {{/workflow_scheme}}

</script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $WorkflowScheme = null;
    $(function() {

        Handlebars.registerHelper('make_relation', function(relations ) {

            var html = '';
            for(var i=0;i<relations.length;i++ ){
                var issue_type_name = relations[i].issue_name;
                var workflow_name = relations[i].workflow_name;
                html += "<div class=\"branch-commit\">"+issue_type_name+"--><a class=\"commit-id monospace\" href=\"#\">"+workflow_name+"</a></div>";
            }
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/workflow_scheme/fetch_all",
            get_url:"<?=ROOT_URL?>admin/workflow_scheme/get",
            update_url:"<?=ROOT_URL?>admin/workflow_scheme/update",
            add_url:"<?=ROOT_URL?>admin/workflow_scheme/add",
            delete_url:"<?=ROOT_URL?>admin/workflow_scheme/delete",
            pagination_id:"pagination"

        }
        window.$WorkflowScheme = new WorkflowScheme( options );
        window.$WorkflowScheme.fetchWorkflowSchemes( );

        $("#modal-workflow_scheme_add").on('show.bs.modal', function (e) {
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

        $("#modal-workflow_scheme_edit").on('show.bs.modal', function (e) {
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