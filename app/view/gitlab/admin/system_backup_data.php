<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

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
                                    <a href="#">备份系统数据</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="bs-callout bs-callout-warning shared-runners-description">
                                <p>附件不会被备份。需要你手动备份。</p>
                                <p>由于数据会比较复杂，可能会延迟一段时间才能完成。</p>
                                <hr>
                                <p>你可以通过备份将MasterLab数据转移到不同的数据库或其他MasterLab实例。备份文件保存在服务器上</p>
                                <p>备份路径为 masterlab/app/storage/backup 请确保该路径有写入权限</p>
                            </div>
                            <form action="" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="✓">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="authenticity_token" value="">
                                <!--div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            /var/tmp/masterlab/backup/
                                        </div>
                                        <input required="required" class="form-control" type="text" value="lijian" name="user[username]" id="user_username">
                                    </div>
                                </div-->
                                <div class="help-block">

                                </div>
                                <hr>
                                <div class="prepend-top-default">
                                    <a class="btn btn-warning" id="backup_btn" href="javascript:void(0);">开始备份数据
                                    </a>&nbsp; for this MasterLab
                                </div>
                            </form>
                            <div class="prepend-top-default">
                            <iframe class="backup-box" id="iframe_load" src="" width="100%">
                            </iframe>
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
<script>
    $('#backup_btn').one("click", function(){
        $(this).addClass('disabled');
        $(this).text('正在备份，请稍后');
        $(this).unbind();
        $('#iframe_load').attr("src", "<?=ROOT_URL?>admin/data_backup/iframe_backup");
        var s = setInterval(function(){
            var idoc = document.getElementById("iframe_load").contentWindow.document;
            var body = $(idoc).find('body');
            $(idoc).scrollTop(body.height());
            if(body.html().indexOf('FINISHED') != -1){
                $(this).text('备份完成');
                clearInterval(s);
            }
        }, 10);
    });

</script>





</body>
</html>
