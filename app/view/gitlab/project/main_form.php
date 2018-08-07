<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <!--<script src="<?=ROOT_URL?>dev/lib/kindeditor/kindeditor-all-min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/kindeditor/themes/default/default.css" rel="stylesheet">-->
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">


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
    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="container-fluid container-limited">
            <div class="content" id="content-body">
                <h3 class="page-title">
                    New Project
                </h3>
                <hr>
                <form id="form_add_action" class="form-horizontal" action="<?=ROOT_URL?>projects/create" accept-charset="UTF-8" method="post">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <div class="form-group">
                        <label class="control-label" for="">项目名称</label>
                        <div class="col-sm-10">
                            <input placeholder="请输入名称,最多<?=$project_name_max_length?>字符" class="form-control" tabindex="1" autofocus="autofocus"
                                   required="required" type="text" name="params[name]" id="project_name" maxlength="<?=$project_name_max_length?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="">
                            <span>组织</span>
                        </label>
                        <div class="col-sm-10">
                            <div class="select2-container">
                                <select class="selectpicker" data-live-search="true" name="params[org_id]">
                                    <?php foreach ($org_list as $org){ ?>
                                        <option data-tokens="<?=$org['name']?>" value="<?=$org['id']?>"><?=$org['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="">
                            <span>项目Key</span>
                        </label>
                        <div class="col-sm-10">
                            <input placeholder="必须英文字符,最大长度<?=$project_key_max_length?>" class="form-control" tabindex="3"
                                   required="required" type="text" name="params[key]" id="project_key" maxlength="<?=$project_key_max_length?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">
                            项目类型
                        </label>
                        <div class="col-sm-10">
                            <?php foreach ($full_type as $type_id => $type_item) { ?>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="params[type]" value="<?=$type_id?>" >
                                        <i class="<?=$type_item['type_face']?>"></i> <span style="font-weight: bolder;"><?=$type_item['type_name']?></span>
                                        <div style="color:#999999;">
                                            <?=$type_item['type_desc']?>
                                        </div>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="project_description">项目描述
                            <span class="light">(optional)</span>
                        </label>
                        <div class="col-sm-10">
                            <textarea placeholder="Description format" class="form-control" rows="3" maxlength="250" name="params[description]" id="projectDescription"></textarea>
                            <div class="help-block"><a href="#">项目描述</a></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="project_lead">
                            <span>项目负责人</span>
                        </label>
                        <div class="col-sm-10">
                            <div class="select2-container">
                                <select class="selectpicker" data-live-search="true" name="params[lead]" id="projectLead">
                                    <option data-tokens="请选择" value="0">请选择</option>
                                    <?php foreach ($users as $user){ ?>
                                        <option data-tokens="<?=$user['display_name']?>" value="<?= $user['uid']?>"><?= $user['display_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group ">
                        <label class="control-label" for="project_url">
                            <span>URL</span>
                        </label>
                        <div class="col-sm-10">
                            <input placeholder="URL" class="form-control" type="text" name="params[url]" id="projectUrl">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="project_avatar">
                            <span>Avatar</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="hidden" value="" name="params[logo]" id="setting_logo" />
                            <a  id="file_upload" class="choose-btn btn js-choose-project-avatar-button file_upload"  to_url_id="setting_logo" to_url_view_id="setting_logo_view">
                                Browse file...
                            </a>
                            <span class="file_name prepend-left-default js-avatar-filename">No file chosen</span>
                            <input class="js-project-avatar-input hidden" type="file" name="params[avatar]" id="project_avatar">
                            <div class="help-block">The maximum file size allowed is 200KB.</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="submit" name="commit" value="创建项目" class="btn btn-create disabled">
                        <a class="btn btn-cancel" href="/projects">取消</a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        let add_options = {
            beforeSubmit: function (arr, $form, options) {
                return true;
            },
            success: function (data, textStatus, jqXHR, $form) {
                if(data.ret == 200){
                    location.href = '/'+data.data.path;
                }else{
                    alert('保存失败'+data.msg);
                }
            },
            type:      "post",
            dataType:  "json",
            clearForm: true,
            resetForm: false,
            timeout:   3000
        };

        $('#form_add_action').submit(function() {
            $(this).ajaxSubmit(add_options);
            return false;
        });

        $('#project_name').bind('input propertychange', function() {
            if($(this).val().length > 0){
                $("input[name='commit']").removeClass("disabled");
            }else{
                $("input[name='commit']").addClass("disabled");
            }
        });
    });


</script>
</body>

</html>