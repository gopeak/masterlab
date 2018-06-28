<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/kindeditor/kindeditor-all-min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/kindeditor/themes/default/default.css" rel="stylesheet">
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
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid">

                    <div class="content" id="content-body">
                        <div class="project-edit-container">
                            <div class="project-edit-errors">


                            </div>
                            <div class="row prepend-top-default">
                                <div class="col-lg-3 profile-settings-sidebar">
                                    <h4 class="prepend-top-0">
                                        New project
                                    </h4>
                                    <p>
                                        Create or Import your project from popular Git services
                                    </p>
                                </div>
                                <div class="col-lg-9">
                                    <form class="new_project" id="new_project" action="<?=ROOT_URL?>project/main/add" accept-charset="UTF-8" method="post">
                                        <input name="utf8" type="hidden" value="✓">
                                        <input type="hidden" name="authenticity_token" value="">

                                        <div class="form-group ">
                                            <label class="label-light" for="project_namespace_id">
                                                <span>项目名称</span>
                                            </label>
                                            <input placeholder="请输入名称,最多<?=$project_name_max_length?>字符" class="form-control" tabindex="1" autofocus="autofocus"
                                                   required="required" type="text" name="params[name]" id="project_name" maxlength="<?=$project_name_max_length?>">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-sm-6">
                                                <label class="label-light" for="project_namespace_id"><span>Project path</span>
                                                </label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            http://192.168.3.213/
                                                        </div>
                                                        <div class="select2-container select2 js-select-namespace" id="s2id_project_namespace_id" style="width: 85px;">
                                                            <a href="javascript:void(0)" class="select2-choice" tabindex="-1">
                                                                <span class="select2-chosen" id="select2-chosen-1">sven</span>
                                                                <abbr class="select2-search-choice-close"></abbr>
                                                                <span class="select2-arrow" role="presentation">
                                                                    <b role="presentation"></b>
                                                                </span>
                                                            </a>
                                                            <label for="s2id_autogen1" class="select2-offscreen">
                                                                Project path
                                                                项目名称
                                                            </label>
                                                            <input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true"
                                                                   role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1" tabindex="1">
                                                        </div>
                                                        <select class="select2 js-select-namespace" tabindex="-1" name="params[namespace_id]" id="project_namespace_id"
                                                                title="Project path Project name" style="display: none;">
                                                            <optgroup label="Groups"><option data-options-parent="groups" value="9">ismond</option></optgroup>
                                                            <optgroup label="Users"><option data-options-parent="users" selected="selected" value="18">sven</option></optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12 col-sm-6 project-path">
                                                <label class="label-light" for="project_namespace_id">
                                                    <span>项目Key</span>
                                                </label>
                                                <input placeholder="必须英文字符,最大长度<?=$project_key_max_length?>" class="form-control" tabindex="3"
                                                       required="required" type="text" name="params[key]" id="project_key" maxlength="<?=$project_key_max_length?>">
                                            </div>
                                        </div>
                                        <div class="project-import js-toggle-container">
                                            <div class="form-group clearfix">
                                                <label class="label-light" for="project_visibility_level">
                                                    项目类型
                                                </label>
                                                <div class="col-sm-12">
                                                    <?php foreach ($full_type as $type_id => $type_item) { ?>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="params[type]" value="<?=$type_id?>" <?php if($type_id==10){echo 'checked';}?> >
                                                            <i class="<?=$type_item['type_face']?>"></i> <?=$type_item['type_name']?>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="js-toggle-content hide">
                                                <div class="form-group import-url-data">
                                                    <label class="control-label" for="project_import_url"><span>Git repository URL</span>
                                                    </label><div class="col-sm-10">
                                                        <input autocomplete="off" class="form-control" placeholder="https://username:password@gitlab.company.com/group/project.git" disabled="disabled" type="text" name="project[import_url]" id="project_import_url">
                                                        <div class="well prepend-top-20">
                                                            <ul>
                                                                <li>
                                                                    The repository must be accessible over <code>http://</code>, <code>https://</code> or <code>git://</code>.
                                                                </li>
                                                                <li>
                                                                    If your HTTP repository is not publicly accessible, add authentication information to the URL: <code>https://username:password@gitlab.company.com/group/project.git</code>.
                                                                </li>
                                                                <li>
                                                                    The import will time out after 15 minutes. For repositories that take longer, use a clone/push combination.
                                                                </li>
                                                                <li>
                                                                    To migrate an SVN repository, check out <a href="/help/workflow/importing/migrating_from_svn">this document</a>.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="label-light" for="project_description">项目描述
                                                <span class="light">(optional)</span>
                                            </label><textarea placeholder="Description format" class="form-control" rows="3" maxlength="250" name="params[description]" id="projectDescription"></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <label class="label-light" for="project_lead">
                                                <span>项目负责人</span>
                                            </label>
                                            <select class="form-control" name="params[lead]" id="projectLead">
                                                <option>请选择</option>
                                                <?php foreach ($users as $user){ ?>
                                                <option value="<?= $user['uid']?>"><?= $user['display_name']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label class="label-light" for="project_url">
                                                <span>URL</span>
                                            </label>
                                            <input placeholder="URL" class="form-control"    type="text" name="params[url]" id="projectUrl">
                                        </div>
                                        <div class="form-group">
                                            <label class="label-light" for="project_avatar">
                                                <span>Avatar</span>
                                            </label>

                                            <input type="hidden" value="" name="params[logo]" id="setting_logo" />
                                            <a  id="file_upload" class="choose-btn btn js-choose-project-avatar-button file_upload"  to_url_id="setting_logo" to_url_view_id="setting_logo_view">
                                                Browse file...
                                            </a>
                                            <span class="file_name prepend-left-default js-avatar-filename">No file chosen</span>
                                            <input class="js-project-avatar-input hidden" type="file" name="params[avatar]" id="project_avatar">
                                            <div class="help-block">The maximum file size allowed is 200KB.</div>
                                        </div>

                                        <input type="submit" name="commit" value="Create project" class="btn btn-create project-submit" tabindex="4">
                                        <a class="btn btn-cancel" href="/dashboard/projects">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="save-project-loader hide">
                            <div class="center">
                                <h2>
                                    <i class="fa fa-spinner fa-spin"></i>
                                    Creating project &amp; repository.
                                </h2>
                                <p>Please wait a moment, this page will automatically refresh when ready.</p>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var editor = null;
    var hidden_input_id = '';
    var img_view_id = '';


    KindEditor.ready(function(K) {

        window.editor = K.editor({
            allowFileManager : true,
            uploadJson:  '/admin/upload/img'
        });
        $('.file_upload').click(function() {
            window.hidden_input_id = $(this).attr('to_url_id');
            window.img_view_id = $(this).attr('to_url_view_id');

            window.editor.loadPlugin('image', function() {
                window.editor.plugin.imageDialog({
                    imageUrl : K('#'+window.img_view_id).val(),
                    clickFn : function(url, title, width, height, border, align) {
                        $('#'+window.img_view_id).attr('src',url);
                        $('#'+window.hidden_input_id).val(url);
                        window.editor.hideDialog();
                    }
                });
            });
        });

    });


</script>
</html>