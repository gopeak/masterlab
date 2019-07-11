<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_status.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
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
                                    <a href="#">事项状态</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-new btn_issue_status_add js-key-create" data-target="#modal-issue_status_add" data-toggle="modal" href="#modal-issue_status_add">
                                        <i class="fa fa-plus"></i>
                                        新增事项状态
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
                                        <th class="js-pipeline-stages pipeline-info">Key</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="js-pipeline-date pipeline-date">关联工作流</th>
                                        <th class="pipeline-info" >操作</th>
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

<div class="modal" id="modal-issue_status_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add"
          action="<?=ROOT_URL?>admin/issue_status/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增事项状态</h3>
                </div>
                <div class="modal-body min-height300" >
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="id_name">名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="id_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_key">Key:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[key]" id="id_key"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_color">背景颜色:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select   id="id_color" name="params[color]" class="selectpicker"  title="请选择"   >
                                    <?php foreach ($colors as $color ) { ?>
                                        <option value="<?=$color?>"  data-content="<span class='label label-<?=$color?>'><?=$color?></span>"><?=$color?></option>
                                    <?php } ?>
                                </select>
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


                    <div class="form-group" style="display: none">
                        <label class="control-label" for="id_font_awesome">图标:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control fontawesome-iconpicker" name="params[font_awesome]" id="id_font_awesome"  value="" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer footer-block row-content-block">
                    <button name="submit" type="button" class="btn btn-create js-key-modal-enter1" id="btn-issue_status_add">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-issue_status_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/issue_status/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑事项状态</h3>
                </div>

                <div class="modal-body  min-height300">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="edit_format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="edit_name">显示名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_key">Key:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[key]" id="edit_key"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_color">背景颜色:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select   id="edit_color" name="params[color]" class="selectpicker"  title="请选择"   >
                                    <?php foreach ($colors as $color ) { ?>
                                        <option value="<?=$color?>"  data-content="<span class='label label-<?=$color?>'><?=$color?></span>"><?=$color?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[description]" id="edit_description"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="display: none">
                        <label class="control-label" for="edit_font_awesome">图标:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control fontawesome-iconpicker " name="params[font_awesome]" id="edit_font_awesome"  value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-save js-key-modal-enter2" id="btn-issue_status_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#issue_status}}
        <tr class="commit">
            <td>
                <span class="label label-{{color}} prepend-left-5">{{name}}</span>
            </td>
            <td>
                {{_key}}
            </td>
            <td>
                {{description}}
            </td>
            <td>

                关联 {{workflow_count}} 项工作流

            </td>
            <td  >

                    <a class="list_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    {{#if_eq is_system '0'}}
                    <a class="list_for_delete btn btn-transparent"  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">删除</span>
                    </a>
                    {{/if_eq}}

            </td>
        </tr>
    {{/issue_status}}

</script>


<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $IssueStatus = null;
    $(function() {

        $('.fontawesome-iconpicker').iconpicker();

        $('.selectpicker').selectpicker('refresh');

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/issue_status/fetch_all",
            get_url:"<?=ROOT_URL?>admin/issue_status/get",
            update_url:"<?=ROOT_URL?>admin/issue_status/update",
            add_url:"<?=ROOT_URL?>admin/issue_status/add",
            delete_url:"<?=ROOT_URL?>admin/issue_status/delete",
            pagination_id:"pagination"

        }
        window.$IssueStatus = new IssueStatus( options );
        window.$IssueStatus.fetchIssueStatuss( );

        $("#modal-issue_status_add").on('show.bs.modal', function (e) {
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

        $("#modal-issue_status_edit").on('show.bs.modal', function (e) {
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