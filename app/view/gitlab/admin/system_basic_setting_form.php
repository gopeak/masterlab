<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<script src="<?=ROOT_URL?>dev/lib/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

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
                                    <a href="#">修改设置</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <form class="form-horizontal" action="<?=ROOT_URL?>admin/system/basic_setting_update"  method="post">
                                <div id="form_id" class="prepend-top-default">
                                </div>
                                <div class="form-actions text-right">
                                    <input type="button" name="commit" value="保存修改" class="btn btn-save js-key-enter">
                                    <a class="btn btn-cancel" href="/projects" style="float: none">取消</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

    </div>
</section>
<script type="text/html"  id="settings_form_tpl">
    {{#settings}}
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"  >{{title}}</label>
        <div class="col-sm-10">
            {{#if_eq form_input_type 'text'}}
                <input type="text" class="form-control" name="params[{{_key}}]" id="id_{{_key}}"  value="{{_value}}" />
            {{/if_eq}}

            {{#if_eq form_input_type 'radio'}}
                {{#each form_optional_value }}
                    <label style=" font-weight: 200;  ">
                        <input type="radio" value="{{@key}}"  {{#if_eq ../_value @key}}checked="checked"{{/if_eq}}
                               name="params[{{../_key}}]" id="id_{{../_key}}">
                        {{this}}
                    </label>
                {{/each}}
            {{/if_eq}}

        </div>
    </div>
    {{/settings}}

</script>

<script>

    $(function() {

        fetchSetting('/admin/system/setting_fetch','basic','settings_form_tpl', 'form_id');

    });


</script>


</body>
</html>