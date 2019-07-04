<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_ui.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>

</head>

<body class="">

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
                                    <a href="#">事项类型界面方案</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">类型</th>
                                        <th class="pipeline-info">操作</th>
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

<div class="modal" id="modal-config_create">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="create_form"
          action="<?=ROOT_URL?>admin/issue_ui/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">创建界面配置</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="type" id="type" value="">
                    <input type="hidden" name="type" name="params[issue_type_id]" id="create_issue_type_id" value="">
                    <input type="hidden" name="type" name="params[data]" id="create_data" value="">

                    <ul class="nav nav-tabs" id="create_tabs" >
                        <li role="presentation" class="active">
                            <a id="a_create_default_tab" href="#create_default_tab" role="tab" data-toggle="tab" data-id="create_default_tab">默认标签页</a>
                        </li>
                        <li   id="create-new_tab_li"><a href="#" id="create-new_tab" data-id="-1"><i class="fa fa-plus"></i>新增标签页</a></li>
                    </ul>
                    <div id="create_master_tabs" class="tab-content">
                        <div role="tabpanel"  class="tab-pane active" id="create_default_tab">
                            <div   class="block__list_words">
                                <ul id="ul-create_default_tab" class="margin-t">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class=" form-group">
                        <div class="col-sm-3 margin-t">
                            选择一个字段添加到此界面
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="min-height: 300px;">
                                <select id="create_field_select" name="create_field_select" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"   title=""   >
                                        <option value="">请选择字段</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-create" id="btn-issue_type_add" onclick="IssueUi.prototype.saveCreateConfig();">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-config_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="edit_form"
          action="<?=ROOT_URL?>admin/issue_ui/edit_ui_update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑界面配置</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="format" value="json">
                    <input type="hidden" name="type" id="edit_type" value="">
                    <input type="hidden" name="type" name="params[issue_type_id]" id="edit_issue_type_id" value="">
                    <input type="hidden" name="type" name="params[data]" id="edit_data" value="">

                    <ul class="nav nav-tabs" id="edit_tabs" >
                        <li role="presentation" class="active">
                            <a id="a_edit_default_tab" href="#edit_default_tab" role="tab" data-toggle="tab" data-id="edit_default_tab">默认标签页</a>
                        </li>
                        <li   id="edit-new_tab_li"><a href="#" id="edit-new_tab" data-id="-1"><i class="fa fa-plus"></i>新增标签页</a></li>
                    </ul>

                    <div id="edit_master_tabs" class="tab-content">
                        <div role="tabpanel"  class="tab-pane active" id="edit_default_tab">
                            <div   class="block__list_words">
                                <ul id="ul-edit_default_tab" class="margin-t">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class=" form-group">
                        <div class="col-sm-3 margin-t">
                            选择一个字段添加到此界面
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="min-height: 300px;">
                                <select id="edit_field_select" name="edit_field_select" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"   title=""   >
                                    <option value="">请选择字段</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-create js-key-modal-enter" id="btn-edit_save" onclick="IssueUi.prototype.saveEditConfig();">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#issue_types}}
        <tr class="commit">
            <td>
                <strong><i class="fa {{font_awesome}}"></i> {{name}}</strong>
            </td>
            <td>
                {{catalog}}
            </td>
            <td>
                <div class="branch-commit">· <a class="commit-id monospace list_for_config_create" href="#"  data-issue_type_id="{{id}}">创建界面配置</a></div>
                <div class="branch-commit">· <a class="commit-id monospace list_for_config_edit" href="#"  data-issue_type_id="{{id}}" >编辑界面配置</a></div>
                <!--<div class="branch-commit">· <a class="commit-id monospace list_for_config_view" href="#"  data-issue_type_id="{{id}}" >查看界面配置</a></div>-->
            </td>
        </tr>
    {{/issue_types}}

</script>

<script type="text/html"  id="create_wrap_field">
    <li id="create_warp_{{field.id}}" data-id="{{order_weight}}" data-field_id="{{field.id}}">
        <div class=" form-group">
                <div class="col-sm-2 "><i class="fa fa-arrows" aria-hidden="true"></i>&nbsp;
                    {{display_name}}:
                </div>
                <div class="col-sm-6">{field_html}</div>
                <div class="col-sm-2">
                    <div class="checkbox">
                        <label>
                            <input   type="checkbox" {{#if required}} checked  {{/if}} name="create_field_required[]"  value="{{field.id}}"> 是否必填
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a href="#"><i data-field_id="{{field.id}}" class="fa fa-trash-o create_li_remove" aria-hidden="true"></i></a>
                </div>
        </div>
    </li>
</script>

<script type="text/html"  id="edit_wrap_field">
    <li id="edit_warp_{{field.id}}" data-id="{{order_weight}}" data-field_id="{{field.id}}">
        <div class=" form-group">
            <div class="col-sm-2"><i class="fa fa-arrows" aria-hidden="true"></i>&nbsp;{{display_name}}:

            </div>
            <div class="col-sm-6">{field_html}</div>
            <div class="col-sm-2">

                <div class="checkbox">
                    <label>
                        <input   type="checkbox" {{#if required}} checked  {{/if}} name="edit_field_required[]"  value="{{field.id}}"> 是否必填
                    </label>
                </div>

            </div>
            <div class="col-sm-2">
                <a href="#"><i data-field_id="{{field.id}}" class="fa fa-trash-o edit_li_remove" aria-hidden="true"></i></a>
            </div>

        </div>
    </li>
</script>

<script type="text/html"  id="create_ui-new_tab_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="create_ui-new_tab_text" name="create_tab_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="new_tab_btn" onclick="IssueUi.prototype.uiAddTab('create',$('#create_ui-new_tab_text').val())" href="#">确定</a>
        </div>
    </div>
</script>

<script type="text/html"  id="create_ui-edit_tab_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="create_ui-edit_tab_text-{{id}}" name="create_tab_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="edit_tab_btn" onclick="IssueUi.prototype.uiUpdateTab('create', '{{id}}')"  href="#">确定</a>
        </div>
    </div>
</script>

<script type="text/html"  id="edit_ui-new_tab_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="edit_ui-new_tab_text" name="edit_tab_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="edit_ui-new_tab_btn"  onclick="IssueUi.prototype.uiAddTab('edit',$('#edit_ui-new_tab_text').val())"  href="#">确定</a>
        </div>
    </div>
</script>

<script type="text/html"  id="edit_ui-edit_tab_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="edit_ui-edit_tab_text-{{id}}" name="edit_tab_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="edit_ui-edit_tab_btn" onclick="IssueUi.prototype.uiUpdateTab('edit', '{{id}}')"  href="#">确定</a>
        </div>
    </div>
</script>

<script type="text/html"  id="li_tab_tpl">
    <div role="tabpanel"  class="tab-pane margin-t" id="{{id}}">
            <div class="dd-list min-height200" id="ul-{{id}}">

            </div>
    </div>
</script>

<script type="text/html"  id="nav_tab_li_tpl">
    <li role="presentation" class="active">
        <a id="a_{{id}}" href="#{{id}}" role="tab" data-toggle="tab" data-id="{{id}}">
            <span id="span_{{id}}">{{title}}</span>
            <i class="fa fa-pencil" data="{{id}}"></i>&nbsp;
            <i class="fa fa-times-circle"  data="{{id}}" onclick="IssueUi.prototype.uiRemoveTab('{{type}}','{{id}}')"></i>
        </a>
    </li>
</script>

<script type="text/html"  id="content_tab_tpl">
    <div role="tabpanel"  class="tab-pane margin-t" id="{{id}}">
        <div   class="block__list_words">
            <ul id="ul-{{id}}" class="margin-t">
            </ul>
        </div>
    </div>
</script>

<script type="text/javascript">

    var $issueType = null;
    $(function() {

        Handlebars.registerHelper('make_scheme', function(scheme_ids, schemes ) {

            var html = '';
            if (scheme_ids == null || scheme_ids == undefined || scheme_ids == '') {
                return html;
            }
            var scheme_ids_arr = scheme_ids.split(',');
            scheme_ids_arr.forEach(function(scheme_id) {
                console.log(scheme_id);
                var scheme_name = '';
                for(var skey in schemes ){
                    if(schemes[skey].id==scheme_id){
                        scheme_name = schemes[skey].name;
                        break;
                    }
                }
                html += "<div class=\"branch-commit\">· <a class=\"commit-id monospace\" href=\"admin/issue_ui/scheme/"+scheme_id+"\">"+scheme_name+"</a></div>";
            });
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/issue_ui/fetch_all",
            get_config_url:"<?=ROOT_URL?>admin/issue_ui/getUiConfig",
            pagination_id:"pagination"

        }
        window.$issueType = new IssueUi( options );
        window.$issueType.fetchIssueTypeUi( );

    });
    $(document).ready(function(){
        $('#create-new_tab').qtip({
            content: {
                text: $('#create_ui-new_tab_tpl').html(),
                title: "新增Tab",
                button: "关闭"
            },
            show: 'click',
            hide: 'click',
            style:{
                classes:"qtip-bootstrap"
            },
            position: {
                my: 'top left',  // Position my top left...
                at: 'bottom center', // at the bottom right of...
            },
            events: {
                show: function( event, api ) {
                    $('#create_ui-new_tab_text').val('');
                    var t=setTimeout("$('#create_ui-new_tab_text').focus();",500)
                }
            }
        });
        $('#edit-new_tab').qtip({
            content: {
                text: $('#edit_ui-new_tab_tpl').html(),
                title: "新增Tab",
                button: "关闭"
            },
            show: 'click',
            hide: 'click',
            style:{
                classes:"qtip-bootstrap"
            },
            position: {
                my: 'top left',  // Position my top left...
                at: 'bottom center', // at the bottom right of...
            },
            events: {
                show: function( event, api ) {
                    $('#edit_ui-new_tab_text').val('');
                    var t=setTimeout("$('#edit_ui-new_tab_text').focus();",200)
                }
            }
        });
        
        $("#modal-config_edit").on('show.bs.modal', function (e) {
            keyMaster.addKeys([
                {
                    key: ['command+enter', 'ctrl+enter'],
                    'trigger-element': '.js-key-modal-enter',
                    trigger: 'click'
                },
                {
                    key: 'esc',
                    'trigger-element': '.js-key-modal-close',
                    trigger: 'click'
                }
            ])
        })

    });
</script>



</body>
</html>