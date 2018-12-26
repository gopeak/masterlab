<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">


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

                    <div class="panel"  style="margin-left:160px;">
                        <form class="edit-project" action="<?=ROOT_URL?>admin/system/basic_setting_update"  method="post">

                        <div class="row prepend-top-default">
                            <div class="col-lg-3 profile-settings-sidebar">
                                <h4 class="prepend-top-0">
                                    标识
                                </h4>
                            </div>

                            <div class="col-lg-9">
                                <div class="clearfix avatar-image append-bottom-default">
                                    <a target="_blank" rel="noopener noreferrer" href="#">
                                        <img  id="setting_banner_view" alt="" class="avatar s160" src="">
                                    </a></div>
                                <h5 class="prepend-top-0">
                                    上传
                                </h5>
                                <div class="prepend-top-5 append-bottom-10">
                                    <input type="hidden" value="" name="params[banner]" id="setting_banner" />
                                    <a id="file_upload" class="btn js-choose-user-avatar-button file_upload" to_url_id="setting_banner" to_url_view_id="setting_banner_view">
                                        Browse file...
                                    </a>
                                    <span class="avatar-file-name prepend-left-default js-avatar-filename">No file chosen</span>
                                    <input class="js-user-avatar-input hidden" accept="image/*" type="file" name="user[avatar]-trigger" id="user_avatar-trigger">
                                </div>
                                <div class="help-block">
                                    The maximum file size allowed is 200KB.
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row prepend-top-default">
                            <div class="col-lg-3 profile-settings-sidebar">
                                <h4 class="prepend-top-0">
                                    自定义logo
                                </h4>
                            </div>
                            <div class="col-lg-9">
                                <div class="project-edit-errors"></div>
                                <div class="clearfix avatar-image append-bottom-default">
                                    <a target="_blank" rel="noopener noreferrer" href="#">
                                        <img  id="setting_logo_view" alt="" class="avatar s160" src="">
                                    </a></div>
                                <h5 class="prepend-top-0">
                                    上传
                                </h5>
                                <div class="prepend-top-5 append-bottom-10">
                                    <input type="hidden" value="" name="params[logo]" id="setting_logo" />
                                    <a id="file_upload" class="btn js-choose-user-avatar-button file_upload" to_url_id="setting_logo" to_url_view_id="setting_logo_view">
                                        Browse file...
                                    </a>
                                    <span class="avatar-file-name prepend-left-default js-avatar-filename">No file chosen</span>
                                    <input class="js-user-avatar-input hidden" accept="image/*" type="file" name="user[avatar]-trigger" id="user_avatar-trigger">
                                </div>
                                <div class="help-block">
                                    The maximum file size allowed is 200KB.
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row prepend-top-default">
                            <div class="col-lg-3 profile-settings-sidebar">
                                <h4 class="prepend-top-0">
                                    颜色
                                </h4>
                            </div>
                            <div class="col-lg-9">
                                <div class="project-edit-errors"></div>

                                    <fieldset>
                                        <h5 class="prepend-top-0">
                                            要应用一个与您的logo匹配的颜色方案
                                        </h5>
                                        <div class="form_group prepend-top-20 sharing-and-permissions">

                                            <fieldset class="features" id="form_color_id">


                                            </fieldset>

                                    </fieldset>




                            </div>
                        </div>
                        <hr>

                        <input type="button" name="commit" value="Save changes" class="btn btn-save ">
                     </form>
                 </div>


            </div>
            
        </div>
    </div>
</div>

    </div>
</section>

<script type="text/html"  id="settings_tpl">
    {{#settings}}
    <div class="row">
        <div class="col-md-9 project-feature">
            <label class="label-light" for="">{{title}}</label>
        </div>
        <div class="col-md-3 js-repo-access-level">
            <div id="page_header_hover" class="input-group colorpicker-component sample-selector">
                <input type="text" name="params[{{_key}}]" id="id_{{_key}}"  value="{{_value}}" class="form-control" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>
    {{/settings}}

</script>


<script>
    var editor = null;
    var hidden_input_id = '';
    var img_view_id = '';


    function fetchColorSetting( url, module, tpl_id, parent_id ) {

        var params = {  module:module, format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (res) {
                auth_check(res);
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(res.data);
                $('#' + parent_id).html(result);

                $('.colorpicker-component').colorpicker({ /*options...*/ });
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    function fetchUISetting( url, module, tpl_id, parent_id ) {

        var params = {  module:module, format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (res) {

                auth_check(res);
                for(var i in res.data.settings) {
                        var setting = res.data.settings[i];
                        if( setting._key=='banner'){
                            $('#setting_banner').val(setting._value);
                            $('#setting_banner_view').attr( 'src',window.root_url+setting._value);
                        }
                        if( setting._key=='logo'){
                            $('#setting_logo').val(setting._value);
                            $('#setting_logo_view').attr( 'src',window.root_url+setting._value);
                        }
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    $(document).on("ready", function() {

        fetchColorSetting('/admin/system/setting_fetch','color','settings_tpl', 'form_color_id');
        fetchUISetting('/admin/system/setting_fetch','ui','settings_tpl', 'form_color_id');

    });
    $(document).off('page:restore').on('page:restore', function (event) {
        if (gl.FilteredSearchManager) {
            new gl.FilteredSearchManager();
        }
        Issuable.init();
        new gl.IssuableBulkActions({
            prefixId: 'issue_',
        });
    });


</script>





</body>
</html>


</div>