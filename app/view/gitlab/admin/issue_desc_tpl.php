<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_type_tpl.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/editor.md/css/editormd.css">
    <script src="<?=ROOT_URL?>dev/lib/editor.md/editormd.js"></script>

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
<div class="page-with-sidebar system-page">
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
                                    <a href="#">事项描述模板</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-new btn_issue_type_add js-key-create" data-target="#modal-issue_type_add" data-toggle="modal" href="#modal-issue_type_add">
                                        <i class="fa fa-plus"></i>
                                        新增模板
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
                                        <th class="js-pipeline-stages pipeline-info">创建时间</th>
                                        <th class="js-pipeline-stages pipeline-info">更新时间</th>
                                        <th class="js-pipeline-date pipeline-date">关联的事项类型</th>
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



<div class="modal" id="modal-issue_type_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_add"
          action="<?=ROOT_URL?>admin/issue_type/add"
          accept-charset="UTF-8"
          method="post">
        <input type="hidden"  name="params[content]" id="add_content"  value="" />
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增模板</h3>
                </div>

                <div class="modal-body min-height400">
                    <input type="hidden" name="format" id="format" value="json">
                    <div class="form-group">
                        <label class="control-label" for="id_name">名称:<span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <div class="form-group" style="    margin: 0px auto 15px;">
                                <input type="text" class="form-control" name="params[name]" id="id_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_description">内容:</label>
                        <div class="col-sm-8">
                            <div id="id_description">
                                <textarea class="hide"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-actions modal-footer">
                    <button name="submit" type="button" class="btn btn-create js-key-modal-enter1" id="btn-issue_type_add" ">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-issue_type_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/issue_type/update"
          accept-charset="UTF-8"
          method="post">
        <input type="hidden"  name="id" id="edit_id"  value="" />
        <input type="hidden"  name="params[content]" id="edit_content"  value="" />
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑模板</h3>
                </div>

                <div class="modal-body min-height400">
                    <input type="hidden" name="format" id="edit_format" value="json">
                    <div class="form-group">
                        <label class="control-label" for="edit_name">名称:<span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <div class="form-group" style="    margin: 0px auto 15px;">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_description">内容:</label>
                        <div class="col-sm-8">
                            <div id="edit_description">
                                <textarea class="hide"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save js-key-modal-enter2" id="btn-issue_type_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>


<div class="modal" id="modal-bind_issue_types">
    <form id="form-for_issue_types"
          class="js-quick-submit js-upload-blob-form form-horizontal"
          action="<?=ROOT_URL?>admin/user/bind_issue_types"
          accept-charset="UTF-8"
          method="post">
        <input type="hidden" name="id" id="bind_tpl_id" value="">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">绑定事项类型</h3>
                </div>
                <div class="modal-body overflow-visible">
                    <div class="form-group">
                        <label class="control-label" for="id_display_name">勾选绑定的事项:</label>
                        <div class="col-sm-10">
                            <select id="for_issue_types" name="params[for_issue_types][]" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"  multiple title="选择事项类型">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save" id="btn-bind_issue_types">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/html"  id="list_tpl">
    {{#tpls}}
        <tr class="commit">
            <td>
                <strong><i class="fa {{font_awesome}}"></i> {{name}}</strong>
            </td>
            <td>
                {{created_text}}
            </td>
            <td>
                {{updated_text}}
            </td>
            <td>
                {{make_types type_id_arr ../issue_types}}
            </td>
            <td  >
                    <a class="list_for_bind btn btn-transparent btn-sm-self" href="#" data-value="{{id}}">关联 </a>
                    <a class="list_for_edit btn btn-transparent btn-sm-self" href="#" data-value="{{id}}">编辑 </a>
                    <a class="list_for_delete btn btn-transparent btn-sm-self"  href="javascript:;" data-value="{{id}}">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">删除</span>
                    </a>


            </td>
        </tr>
    {{/tpls}}

</script>


<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $obj = null;
    var _editor_add = null;
    var _editor_edit = null;
    $(function() {
        Handlebars.registerHelper('make_types', function(type_ids_arr, issue_types ) {

            var html = '';
            if (type_ids_arr == null || type_ids_arr == undefined || type_ids_arr == '') {
                return html;
            }
            type_ids_arr.forEach(function(type_id) {
                console.log(type_id);
                var type_name = '';
                for(var skey in issue_types ){
                    if(issue_types[skey].id==type_id){
                        type_name = issue_types[skey].name;
                        break;
                    }
                }
                html += "<a style='color:#1b69b6' class=\"branch-commit \" href=\"#/"+type_id+"\"> · "+type_name+"</a>";
            });
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/issue_desc_tpl/fetch_all",
            get_url:"<?=ROOT_URL?>admin/issue_desc_tpl/get",
            update_url:"<?=ROOT_URL?>admin/issue_desc_tpl/update",
            add_url:"<?=ROOT_URL?>admin/issue_desc_tpl/add",
            delete_url:"<?=ROOT_URL?>admin/issue_desc_tpl/delete",
            get_bind_url:"<?=ROOT_URL?>admin/issue_desc_tpl/fetchBindIssueTypes",
            bind_url:"<?=ROOT_URL?>admin/issue_desc_tpl/bindIssueTypes",
            pagination_id:"pagination"
        }
        window.$obj = new IssueTypeTpl( options );
        window.$obj.fetchAll( );

        $('#btn-issue_type_add').bind('click', function () {
            IssueTypeTpl.prototype.add();
        });

        $('#btn-bind_issue_types').bind('click', function () {
            IssueTypeTpl.prototype.bindIssueTypes();
        });

       $("#modal-issue_type_add").on('show.bs.modal', function (e) {
           _editor_add = editormd("id_description", {
               width: "100%",
               height: 300,
               markdown: "",
               watch: false,
               lineNumbers: false,
               path: '<?=ROOT_URL?>dev/lib/editor.md/lib/',
               imageUpload: true,
               imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
               imageUploadURL: "<?=ROOT_URL?>issue/detail/editormd_upload",
               tocm: true,    // Using [TOCM]
               emoji: true,
               saveHTMLToTextarea: true,
               toolbarIcons: "custom",
               placeholder: "",
               autoFocus: false
           });

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

        $("#modal-issue_type_edit").on('show.bs.modal', function (e) {

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