<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_type.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" media="print" href="<?=ROOT_URL?>dev/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css" />

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
                                    <a href="#">事项类型</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-new btn_issue_type_add js-key-create" data-target="#modal-issue_type_add" data-toggle="modal" href="#modal-issue_type_add">
                                        <i class="fa fa-plus"></i>
                                        新增事项类型
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
                                        <th class="js-pipeline-stages pipeline-info">类型</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="js-pipeline-date pipeline-date">关联方案</th>
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
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增事项类型</h3>
                </div>

                <div class="modal-body min-height400">
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
                        <label class="control-label" for="id_key">唯一标识符:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[key]" id="id_key"  value="" />
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
                        <label class="control-label" for="id_font_awesome">图标:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control fontawesome-iconpicker" name="params[font_awesome]" id="id_font_awesome"  value="" >
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
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑事项类型</h3>
                </div>

                <div class="modal-body min-height400">
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
                        <label class="control-label" for="edit_key">唯一标识符:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[key]" id="edit_key"  value="" readonly />
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

                    <div class="form-group">
                        <label class="control-label" for="edit_font_awesome">图标:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control fontawesome-iconpicker " name="params[font_awesome]" id="edit_font_awesome"  value="" />
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
                {{description}}
            </td>
            <td>
                {{make_scheme scheme_ids ../issue_type_schemes}}
            </td>
            <td  >

                    <a class="list_for_edit btn btn-transparent btn-sm-self" href="#" data-value="{{id}}">编辑 </a>
                    {{#if_eq is_system '0'}}
                    <a class="list_for_delete btn btn-transparent btn-sm-self"  href="javascript:;" data-value="{{id}}">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">删除</span>
                    </a>
                    {{/if_eq}}

            </td>
        </tr>
    {{/issue_types}}

</script>


<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var $issueType = null;
    $(function() {

        $('.fontawesome-iconpicker').iconpicker();

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
                html += "<div class=\"branch-commit\">· <span class=\"\" href=\"#/"+scheme_id+"\">"+scheme_name+"</span></div>";
            });
            return new Handlebars.SafeString( html );

        });

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/issue_type/fetch_all",
            get_url:"<?=ROOT_URL?>admin/issue_type/get",
            update_url:"<?=ROOT_URL?>admin/issue_type/update",
            add_url:"<?=ROOT_URL?>admin/issue_type/add",
            delete_url:"<?=ROOT_URL?>admin/issue_type/delete",
            pagination_id:"pagination"
        }
        window.$issueType = new IssueType( options );
        window.$issueType.fetchIssueTypes( );

        $('#btn-issue_type_add').bind('click', function () {
            IssueType.prototype.add();
        });

/*        $("#modal-issue_type_add").on('show.bs.modal', function (e) {
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
        })*/

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