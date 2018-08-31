<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

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
                <div class="row prepend-top-default margin-l-160">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>backup data</strong>
                        </div>
                        <div class="panel-body">
                        <div class="bs-callout bs-callout-warning shared-runners-description">
                            <p>附件不会被备份。需要你手动备份。</p>
                            <p>由于数据会比较复杂，可能会延迟一段时间才能完成。</p>
                            <hr>
                            <p>你可以通过备份将MasterLab数据转移到不同的数据库或其他MasterLab实例。备份文件保存在服务器上，请在下方输入完整的备份路径及文件名</p>
                        </div>
                        <form class="update-username" id="edit_user_10" action="/profile/update_username" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="put"><input type="hidden" name="authenticity_token" value="y3hZV7vhywSOxg6qEAz+mw3mdUJn/5R53Sd6PqX/IFGFuqcjH+rcG7QzIDebJT27RNI7OFwWpUlEaHJ3AYeqWg=="><div class="form-group">

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        /var/tmp/masterlab/backup/
                                    </div>
                                    <input required="required" class="form-control" type="text" value="lijian" name="user[username]" id="user_username">
                                </div>
                            </div>
                            <div class="help-block">

                            </div>
                            <hr>
                            <div class="prepend-top-default">
                                <a class="btn btn-warning" href="javascript:void(0);" onclick="backup()">开始备份数据
                                </a>&nbsp; for this MasterLab
                            </div>
                        </form>
                        <div class="prepend-top-default">
                        <iframe id="iframe_load" src="" width="100%" height="500px;">
                        </iframe>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function backup() {
        $('#iframe_load').attr("src", "<?=ROOT_URL?>admin/data_backup/iframe_backup");
    }

</script>





</body>
</html>
