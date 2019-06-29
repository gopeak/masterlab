<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/group.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>"  type="text/javascript"></script>

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
        <div class=" container-fluid">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_user_left_nav.php';?>
                <div class="container-fluid row  has-side-margin-left "  >
                    <div class="top-area">
                        <ul class="nav-links">
                            <li class="active" data-value="">
                                <a id="state-opened"  title="全部用户" href="#" ><span>用户组</span>
                                </a>
                            </li>
                        </ul>
                        <div class="nav-controls margin-md-l">
                            <a class="btn btn-new btn_group_add js-key-create" data-target="#modal-group_add" data-toggle="modal" href="#modal-group_add">
                                <i class="fa fa-plus"></i> 新增用户组
                            </a>
                        </div>
                        <div class="nav-controls">
                            <form id="filter_form" action="<?=ROOT_URL?>admin/user/filter" accept-charset="UTF-8" method="get">
                                <input name="params[page]" id="filter_page" type="hidden" value="1">
                                <input name="params[page_size]" id="filter_page_size" type="hidden" value="20">

                                <input type="text" name="params[name]" id="filter_name" placeholder="组名称" class="form-control search-text-input input-short" spellcheck="false" value="" />

                                <div class="dropdown inline prepend-left-10">
                                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false" >
                                        <span class="light" id="filter_page_size_view" data-title-origin="20"> 20</span>
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-sort" style="min-width: 50px">
                                        <li class="filter_page_size"  data-value="20"><a href="#">20</a></li>
                                        <li class="filter_page_size"  data-value="50"><a href="#">50</a></li>
                                        <li class="filter_page_size"  data-value="100"><a href="#">100</a></li>

                                    </ul>
                                </div>
                            </form>
                            <div class="btn-group">
                                <a class="btn btn-gray btn-search " id="btn-group_filter" href="#">
                                     <i class="fa fa-filter"></i>
                                </a>
                                <a class="btn"  href="#"  class="filter_group_reset" id="btn-group_reset" >
                                     <i class="fa fa-undo"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="content-list pipelines">

                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">名称</th>
                                        <th class="js-pipeline-stages pipeline-info">描述</th>
                                        <th class="pipeline-info" style="text-align: right;">操作</th>
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


<div class="modal" id="modal-group_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"  id="form_add"
          action="<?=ROOT_URL?>admin/group/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">新增用户组</h3>
                </div>
                <div class="modal-body">
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
                            <label class="control-label" for="id_description">描述:</label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[description]" id="id_description"  value="" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer form-actions">
                    <button name="submit" type="button" class="btn btn-create js-key-modal-enter1" id="btn-group_add">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-group_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/group/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑用户组</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="id_name">显示名称:<span class="required"> *</span></label>
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
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save js-key-modal-enter2" id="btn-group_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#groups}}

        <tr class="commit">
            <td>
                <strong class="prepend-left-5">{{name}}</strong>
            </td>
            <td>
                {{description}}
            </td>
            <td  >
                <div class="controls member-controls " style="float: right">

                    <a class="group_for_users btn btn-transparent " href="<?=ROOT_URL?>admin/user/index/?group_id={{id}}" data-value="{{id}}" style="padding: 6px 2px;">所属成员 </a>
                    <a class="group_for_edit_users btn btn-transparent " href="<?=ROOT_URL?>admin/group/edit_users/{{id}}" data-value="{{id}}" style="padding: 6px 2px;">编辑成员 </a>
                    <a class="group_for_edit btn btn-transparent " href="#" data-value="{{id}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="group_for_delete btn btn-transparent  "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                </div>

            </td>
        </tr>
    {{/groups}}

</script>



<script type="text/javascript">

    var $group = null;
    $(function() {

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>admin/group/filter",
            get_url:"<?=ROOT_URL?>admin/group/get",
            update_url:"<?=ROOT_URL?>admin/group/update",
            add_url:"<?=ROOT_URL?>admin/group/add",
            delete_url:"<?=ROOT_URL?>admin/group/delete",
            pagination_id:"pagination"

        }
        window.$group = new Group( options );
        window.$group.fetchGroups( );

        $("#modal-group_add").on('show.bs.modal', function (e) {
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

        $('#modal-group_add').on('hidden.bs.modal', function (e) {
            keyMaster.delKeys([['command+enter', 'ctrl+enter'], 'esc'])
        })

        $("#modal-group_edit").on('show.bs.modal', function (e) {
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

        $('#modal-group_edit').on('hidden.bs.modal', function (e) {
            keyMaster.delKeys([['command+enter', 'ctrl+enter'], 'esc'])
        })
    });

</script>
</body>
</html>