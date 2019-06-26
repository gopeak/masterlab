<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <!-- Fine Uploader jQuery JS file-->
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/e-smart-zoom-jquery.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/editor.md/css/editormd.css">
    <script src="<?=ROOT_URL?>dev/lib/editor.md/editormd.js"></script>
</head>
<body class="" data-group="" data-page="projects:issues:new" data-project="xphp" >
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid container-limited">
            <div class="content" id="content-body">
                <div class="row prepend-top-default">
                    <div class="col-lg-3">
                        <h4 class="prepend-top-0">项目基础设置</h4>
                        <p>将事项分为不同的类型, 例如 缺陷或任务等。 每个事项类型都可以分别配置不同的选项。

事项类型方案用于定义这个项目使用哪几种事项类型。 要改变项目的事项类型, 可以选择另一个事项类型方案, 或编辑当前的事项类型界面方案。</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>基础设置</strong>
                            </div>
                            <div class="panel-body">
                                <div>
                                    <form id="save_project" action="<?=ROOT_URL?>project/setting/save_settings_profile?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post" class="form-horizontal">
                                        <input name="utf8" type="hidden" value="✓">
                                        <input type="hidden" name="authenticity_token" value="">

                                        <div class="form-group">
                                            <label class="control-label" for="project_namespace_id">
                                                <span>项目名称</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <input value="<?=$info['name']?>" placeholder="请输入名称,最多64字符" class="form-control" tabindex="1" autofocus="autofocus" required="required" type="text" name="params[name]" id="project_name" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="project_namespace_id">
                                                <span>组织</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <?   if(!$is_admin){ ?>
                                                    <input value="<?= $info['org_name'] ?>" class="form-control" type="text" disabled>
                                                <?   }else { ?>
                                                    <div class="select2-container">
                                                        <select class="selectpicker" data-live-search="true" name="params[org_id]">
                                                            <?php foreach ($org_list as $org){ ?>
                                                                <option data-tokens="<?=$org['name']?>" value="<?=$org['id']?>"><?=$org['name']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?  }  ?>
                                            </div>
                                        </div>
                                        <div class="form-group project-path">
                                            <label class="control-label" for="project_namespace_id">
                                                <span>项目Key</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <input value="<?= $info['key']?>" placeholder="必须英文字符,最大长度20" class="form-control" tabindex="3"required="required" type="text" name="params[key]" id="project_key" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label class="control-label" for="project_visibility_level">
                                                项目类型
                                            </label>
                                            <div class="col-sm-10 radio-with">
                                                <?php foreach ($full_type as $type_id => $type_item) { ?>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="params[type]" value="<?=$type_id?>" <?php if($type_id==$info['type']){echo 'checked';}?> >
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
                                            <label class="control-label" for="project_description">项目描述</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" maxlength="250" name="params[description]" id="project_description"><?=$info['description']?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="project_detail">项目详情</label>
                                            <div class="col-sm-10">
                                                <div id="editor_md">
                                                    <textarea style="display:none;" name="params[detail]" id="project_detail"><?=$info['detail']?></textarea>
                                                </div>
                                                <div class="help-block"><a href="#">help</a></div>
                                            </div>
                                        </div>

                                        <div class="form-group issue-assignee">
                                            <label class="control-label" for="issue_assignee_id">项目负责人</label>
                                            <div class="col-sm-10">
                                                <div class="issuable-form-select-holder">
                                                    <input type="hidden" name="params[lead]" id="issue_assignee_id" value="<?=$info['lead']?>"/>
                                                    <div class="dropdown ">
                                                        <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search" type="button"
                                                                data-first-user="sven"
                                                                data-null-user="true"
                                                                data-current-user="true"
                                                                data-project-id=""
                                                                data-selected="null"
                                                                data-field-name="params[lead]"
                                                                data-default-label="Assignee"
                                                                data-toggle="dropdown">
                                                            <span class="dropdown-toggle-text is-default"><?=$lead_display_name?></span>
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                                            <div class="dropdown-title">
                                                                <span>选择负责人</span>
                                                                <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                    <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                </button>
                                                            </div>
                                                            <div class="dropdown-input">
                                                                <input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" />
                                                                <i class="fa fa-search dropdown-input-search"></i>
                                                                <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                            </div>
                                                            <div class="dropdown-content "></div>
                                                            <div class="dropdown-loading">
                                                                <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="assign-to-me-link " href="#">赋予给我</a></div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label" for="project_url">
                                                <span>URL</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <input value="<?=$info['url']?>" placeholder="URL" class="form-control"  type="text" name="params[url]" id="project_url">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label" for="project_avatar">
                                                <span>头像</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <img id="avatar_display" class="avatar s40" alt="" src="<?=ATTACHMENT_URL?><?=$info['avatar']?>">
                                                <input type="hidden"  name="params[avatar_relate_path]" id="avatar"  value="<?=$info['avatar']?>" />
                                                <div id="fine-uploader-gallery"></div>
                                                <div class="help-block">图片大小被限制为500KB.</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <div class="col-sm-10">
                                                <input type="submit" name="commit" value="保存" class="btn btn-create project-submit js-key-enter" tabindex="4">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>重命名KEY</strong>
                            </div>
                            <div class="panel-body">
                                <div>
                                    <form id="update_key_from" action="<?=ROOT_URL?>project/setting/update_project_key?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post" class="form-horizontal">
                                        <input name="utf8" type="hidden" value="✓">
                                        <input type="hidden" name="_method" value="patch">
                                        <input type="hidden" name="authenticity_token" value="qGi0NPGi5k0taFq/z4qSkPLv23LTIN8106xSE+XR0JfrqvSBZINwUkRX3DTB+12SGo41k/n2lqBcZ2oiLkbTSQ==">
                                        <div class="form-group project_name_holder">
                                            <label class="control-label" for="project_name">原KEY</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?= $info['key']?>" name="params[key]">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="project_path"><span>新KEY</span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="" name="params[new_key]">
                                                <ul style="color: #999;">
                                                    <li>注意，重命名KEY可能会产生意想不到的副作用。</li>
                                                    <li>您需要更新本地KEY以指向新的位置。</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <div class="col-sm-10">
                                                <input type="submit" name="commit" value="重命名KEY" class="btn btn-warning">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div-->

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

    </div>
</section>

<!-- Fine Uploader Gallery template
    ====================================================================== -->
<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="将文件拖放到此处以上传项目图标">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>选择图片</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <div class="qq-thumbnail-wrapper">
                    <a href="javascript:;" class="qq-file-link qq-upload-file-url">
                    <img class="qq-thumbnail-selector" qq-max-size="198" qq-server-scale>
                    </a>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    重试
                </button>

                <div class="qq-file-info">
                    <div class="qq-file-name">
                        <span class="qq-upload-file-selector qq-upload-file"></span>
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    </div>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                    </button>
                </div>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Close</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">否</button>
                <button type="button" class="qq-ok-button-selector">是</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>


<script>
    // 初始化组织值
    $(".selectpicker").selectpicker('val', <?=$project['org_id']?>);

    var editor = editormd({
        id   : "editor_md",
        placeholder : "填写项目说明...",
        width: "100%",
        height: 240,
        markdown: "",
        path: '<?=ROOT_URL?>dev/lib/editor.md/lib/',
        imageUpload: true,
        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
        imageUploadURL: "<?=ROOT_URL?>issue/detail/editormd_upload",
        tocm: true,    // Using [TOCM]
        emoji: true,
        saveHTMLToTextarea: true,
        toolbarIcons      : "custom",
        autoFocus : false
    });


    $('#fine-uploader-gallery').fineUploader({
        template: 'qq-template-gallery',
        multiple : false,
        request: {
            endpoint: '/projects/upload' +'?_csrftoken='+encodeURIComponent(document.getElementById('csrf_token').value)
        },
        deleteFile: {
            enabled: false
        },
        retry: {
            enableAuto: true
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
            sizeLimit: 1024*500
        },
        callbacks:{
            onComplete:  function(id,  fileName,  responseJSON)  {
                //console.log(responseJSON);
                if(responseJSON.error == ''){
                    $('#avatar').val(responseJSON.relate_path);
                }
            }
        }
    });

    var options = {
        beforeSubmit:  function (arr, $form, options) {
            return true;
        },
        success:       function (data, textStatus, jqXHR, $form) {
            if(data.ret == 200){
                notify_success('操作成功');
            }else{
                notify_error('保存失败: ' + data.msg);
            }
            console.log(data);
        },

        // other available options:
        //url:       url         // override for form's 'action' attribute
        type:      "post",        // 'get' or 'post', override for form's 'method' attribute
        dataType:  "json",        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        timeout:   3000
    };

    $('#save_project').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });


    var update_key_options = {
        beforeSubmit:  function (arr, $form, options) {
            return true;
        },
        success:       function (data, textStatus, jqXHR, $form) {
            if(data.ret == 200){
                notify_success('KEY修改成功');
                window.location.href="/projects";
            }else{
                notify_error('KEY修改失败: ' + data.msg);
            }
            //console.log(data);
        },
        type:      "post",
        dataType:  "json",
        timeout:   3000
    };

    $('#update_key_from').submit(function() {
        $(this).ajaxSubmit(update_key_options);
        return false;
    });
</script>
</body>

</html>