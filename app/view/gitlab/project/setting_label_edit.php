<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page"></div>
        </div>
        <div class="">
            <div class="content" id="content-body">

                <div class="container-fluid container-limited">
                    <h3 class="page-title">
                        编辑标签
                    </h3>
                    <hr>
                    <form class="form-horizontal label-form js-quick-submit js-requires-input" id="form_edit_action" action="<?=ROOT_URL?>project/label/update?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="authenticity_token" value="PnuoZcfpzkVXlVTW9dc8g5AhtYYvnvkxOcEk+aApfsuTCCBRXrdeZlYJ8IZiZw8bIul1XFTzKlgj8NEPjuwesw==">
                        <input name="id" type="hidden" value="<?=$row['id']?>">
                        <div class="form-group">
                            <label class="control-label" for="label_title">名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" required="required" autofocus="autofocus" type="text" name="title" id="label_title" value="<?=$row['title']?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="label_color">颜色</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon js-label-color-preview" style="background-color: <?=$row['bg_color']?>;">&nbsp;</div>
                                    <input class="form-control" type="text" value="<?=$row['bg_color']?>" name="bg_color" id="label_color" >
                                </div>
                                <div class="help-block">
                                    Choose any color.
                                    <br>
                                    Or you can choose one of suggested colors below
                                </div>
                                <div class="suggest-colors">
                                    <a style="background-color: #0033CC" data-color="#0033CC" href="#">&nbsp;
                                    </a><a style="background-color: #428BCA" data-color="#428BCA" href="#">&nbsp;
                                    </a><a style="background-color: #44AD8E" data-color="#44AD8E" href="#">&nbsp;
                                    </a><a style="background-color: #A8D695" data-color="#A8D695" href="#">&nbsp;
                                    </a><a style="background-color: #5CB85C" data-color="#5CB85C" href="#">&nbsp;
                                    </a><a style="background-color: #69D100" data-color="#69D100" href="#">&nbsp;
                                    </a><a style="background-color: #004E00" data-color="#004E00" href="#">&nbsp;
                                    </a><a style="background-color: #34495E" data-color="#34495E" href="#">&nbsp;
                                    </a><a style="background-color: #7F8C8D" data-color="#7F8C8D" href="#">&nbsp;
                                    </a><a style="background-color: #A295D6" data-color="#A295D6" href="#">&nbsp;
                                    </a><a style="background-color: #5843AD" data-color="#5843AD" href="#">&nbsp;
                                    </a><a style="background-color: #8E44AD" data-color="#8E44AD" href="#">&nbsp;
                                    </a><a style="background-color: #FFECDB" data-color="#FFECDB" href="#">&nbsp;
                                    </a><a style="background-color: #AD4363" data-color="#AD4363" href="#">&nbsp;
                                    </a><a style="background-color: #D10069" data-color="#D10069" href="#">&nbsp;
                                    </a><a style="background-color: #CC0033" data-color="#CC0033" href="#">&nbsp;
                                    </a><a style="background-color: #FF0000" data-color="#FF0000" href="#">&nbsp;
                                    </a><a style="background-color: #D9534F" data-color="#D9534F" href="#">&nbsp;
                                    </a><a style="background-color: #D1D100" data-color="#D1D100" href="#">&nbsp;
                                    </a><a style="background-color: #F0AD4E" data-color="#F0AD4E" href="#">&nbsp;
                                    </a><a style="background-color: #AD8D43" data-color="#AD8D43" href="#">&nbsp;
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <input type="submit" name="commit" value="修改" class="btn btn-create js-save-button disabled" disabled="disabled">
                            <a class="btn btn-cancel" href="<?=$project_root_url?>/settings_label">取消</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


</div>
</section>


<script>

    $(function() {

        let add_options = {
            beforeSubmit: function (arr, $form, options) {
                return true;
            },
            success: function (data, textStatus, jqXHR, $form) {
                if(data.ret == 200){
                    location.href = "<?=$project_root_url?>/settings_label";
                }else{
                    notify_error('保存失败'+data.msg);
                }
            },
            type:      "post",
            dataType:  "json",
            clearForm: true,
            resetForm: false,
            timeout:   3000
        };

        $('#form_edit_action').submit(function() {
            $(this).ajaxSubmit(add_options);
            return false;
        });

        $('.suggest-colors a').click(function () {
            $('#label_color').val($(this).data("color"));
            $('.js-label-color-preview').attr("style", $(this).attr("style"));
        });

        $('#label_title').bind('input propertychange', function() {
            if($(this).val().length > 0){
                $('.js-save-button').removeClass("disabled");
            }
        });
    });

</script>





</body>
</html>
