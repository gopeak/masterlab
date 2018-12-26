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
<div class="page-with-sidebar system-page">

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
                                    <a href="#">设置</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    <!--<a data-no-turbolink="true" class="hidden-xs hidden-sm btn btn-grouped btn-reopen" title="Reopen issue" href="#"><i class="fa fa-adjust"></i>  高级设置</a>-->
                                    <a class="hidden-xs hidden-sm btn btn-grouped issuable-edit" href="<?=ROOT_URL?>admin/system/basic_setting_edit"><i class="fa fa-edit"></i> 修改</a>
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
            
        </div>
    </div>
</div>

    </div>
</section>

<script type="text/html"  id="settings_tpl">
    {{#settings}}
    <tr class="commit">
        <td>
            <div class="branch-commit">
                <strong>
                    {{title}}:
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