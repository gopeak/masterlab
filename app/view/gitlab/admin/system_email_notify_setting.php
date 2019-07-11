<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

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
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">通知配置</a>
                                </li>
                                <li>
                                    <span class="hint">配置通知的目标</span>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <a class="hidden-xs hidden-sm btn btn-grouped issuable-edit" data-target="#modal-edit_datetime" data-toggle="modal" href="#modal-edit_datetime">
                                        <i class="fa fa-edit"></i> 修改
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="table-holder">
                                <table class="table ci-table">
                                    <tbody id="tbody_id">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal" id="modal-edit_datetime">
                <form class="js-quick-submit js-upload-blob-form form-horizontal" action="/admin/system/update_notify_scheme_data" accept-charset="UTF-8" method="post">
                    <div class="modal-dialog">
                        <div class="modal-content modal-middle">
                            <div class="modal-header">
                                <a class="close js-key-modal-close2" data-dismiss="modal" href="#">×</a>
                                <h3 class="modal-header-title">修改配置</h3>
                            </div>
                            <div class="modal-body">
                                <div id="form_id">

                                </div>
                            </div>

                            <div class="modal-footer form-actions">
                                <button name="submit" type="button" class="btn btn-save js-key-modal-enter2" data-dismiss="modal"  id="submit-all">保存</button>
                                <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>
</section>

<script type="text/html"  id="datetime_settings_tpl">
    {{#settings}}
    <tr class="commit">
        <td>
            <div class="branch-commit">
                <strong>
                    {{name}}:
                </strong>
            </div>
        </td>
        <td>
            {{#user_role_name}}
            <span class="label label-info">{{this}}</span>
            {{/user_role_name}}
        </td>
        <td> </td>
    </tr>
    {{/settings}}
</script>
<script type="text/html" id="datetime_settings_form_tpl">
    {{#settings}}
    <div class="form-group">
        <label class="control-label" for="date_format">{{name}}:</label>
        <div class="col-sm-5">

            <div class="form-group">
                <fieldset>
                    <input type="checkbox" name="user_role_list[{{flag}}][]" value="assigee"
                           {{#if_in_array 'assigee' user}}checked{{else}}{{/if_in_array}}>
                    <label>经办人</label>
                    <span>assigee</span>
                </fieldset>
                <fieldset>
                    <input type="checkbox" name="user_role_list[{{flag}}][]" value="reporter"
                           {{#if_in_array 'reporter' user}}checked{{else}}{{/if_in_array}}>
                    <label>报告人</label>
                    <span>reporter</span>
                </fieldset>
                <fieldset>
                    <input type="checkbox" name="user_role_list[{{flag}}][]" value="follow"
                           {{#if_in_array 'follow' user}}checked{{else}}{{/if_in_array}}>
                    <label>关注人</label>
                    <span>follow</span>
                </fieldset>
                <fieldset>
                    <input type="checkbox" name="user_role_list[{{flag}}][]" value="project"
                           {{#if_in_array 'project' user}}checked{{else}}{{/if_in_array}}>
                    <label>项目成员</label>
                    <span>project</span>
                </fieldset>
            </div>

        </div>
    </div>

    {{/settings}}

</script>


<script type="text/javascript">

    $(function() {
        fetchNotifySchemeData('/admin/system/fetch_notify_scheme_data','datetime_settings_tpl','tbody_id');
        fetchNotifySchemeData('/admin/system/fetch_notify_scheme_data', 'datetime_settings_form_tpl', 'form_id');

        $('#modal-mail_test').on('show.bs.modal', function (e) {
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
        

        $('#modal-edit_datetime').on('show.bs.modal', function (e) {
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

        $('#modal-mail_test').on('hidden.bs.modal', function (e) {
            keyMaster.delKeys([['command+enter', 'ctrl+enter'], 'esc'])
        })
        $('#modal-edit_datetime').on('hidden.bs.modal', function (e) {
            keyMaster.delKeys([['command+enter', 'ctrl+enter'], 'esc'])
        })


    });

</script>


</body>
</html>