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
                                    <a href="#">恢复系统数据</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list prepend-top-default">
                            <button class="btn btn-save " onclick="recover()">恢复数据</button>
                            <form class="new_project" id="new_project" action="" accept-charset="UTF-8" method="post">
                                <?php if(!empty($file_list)){foreach ($file_list as $file) { ?>
                                    <div class="radio padding-md-t padding-md-b">
                                        <label>
                                            <input type="radio" name="select_file" value="<?=$file?>"><?=$file?>
                                        </label>
                                    </div>
                                <?php }}else{echo '<div class="padding-md-t padding-md-b">没有备份文件</div>';} ?>
                            </form>
                            <div>
                                <iframe class="recover-box" id="iframe_load" src="" width="100%">
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

    function recover() {
        var file = $("input[name='select_file']:checked").val();
        $('#iframe_load').attr("src", "<?=ROOT_URL?>admin/data_backup/iframe_recover?dump_file_name="+file);
        var s = setInterval(function(){
            var idoc = document.getElementById("iframe_load").contentWindow.document
            var body = $(idoc).find('body')
            $(idoc).scrollTop(body.height())
            if(body.html().indexOf('数据恢复成功') != -1){
                clearInterval(s)
            }
        }, 100)
    }

</script>





</body>
</html>
