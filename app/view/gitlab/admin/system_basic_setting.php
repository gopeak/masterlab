<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js" type="text/javascript" charset="utf-8"></script>
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
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>

                <div class="row prepend-top-default" style="margin-left:160px;">

                        <div class="panel">

                            <div class="panel-heading">
                                <strong>设置</strong>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                    <input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">
                                        <a data-no-turbolink="true" class="hidden-xs hidden-sm btn btn-grouped btn-reopen " title="Reopen issue" href="#"><i class="fa fa-adjust"></i>  高级设置</a>
                                        <a class="hidden-xs hidden-sm btn btn-grouped issuable-edit" href="<?=ROOT_URL?>admin/system/basic_setting_edit"><i class="fa fa-edit"></i> 修改</a>
                                    </div>
                                </form>
                            </div>

                            <div class="prepend-top-default">
                                <div class="table-holder">
                                <table class="table ci-table">

                                   <!-- <thead>
                                        <th>基本设置</th>
                                        <th></th>
                                        <th></th>
                                    </thead>
                                    -->
                                    <tbody id="tbody_id">




                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                </div>




            </div>
            
        </div>
    </div>
</div>

<script type="text/html"  id="settings_tpl">
    {{#settings}}
    <tr class="commit">
        <td>
            <div class="branch-commit">
                <strong>
                    {{title}}
                </strong>
            </div>
        </td>
        <td> {{text}}</td>
        <td> </td>
    </tr>
    {{/settings}}

</script>

<script type="text/javascript">

    $(function() {
        fetchSetting('/admin/system/setting_fetch','basic','settings_tpl','tbody_id');

    });

</script>

</body>
</html>


</div>