<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <!--<script src="<?=ROOT_URL?>dev/lib/kindeditor/kindeditor-all-min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/kindeditor/themes/default/default.css" rel="stylesheet">-->
    <script src="<?=ROOT_URL?>dev/vendor/define-validate.js"></script>
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

    <style type="text/css">
        .radio-with{
            display: flex;
        }
        .radio-with .radio{
            padding: 8px 12px;
            border-radius: 2px;
            box-sizing: border-box;
            flex: 1;
        }
        .radio-with .radio:focus-within{
            background-color: #eee;
        }
    </style>
</head>
<body class="" data-group="" data-page="projects:issues:new" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
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
                    创建项目
                </h3>
                <hr>
                <form id="form_add_action" class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form" action="<?=ROOT_URL?>project/main/create" accept-charset="UTF-8" method="post">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <div class="form-group">
                        <label class="control-label" for="">项目名称</label>
                        <div class="col-sm-10">
                            <input placeholder="请输入名称,最多<?=$project_name_max_length?>字符" class="form-control" tabindex="1" autofocus="autofocus"
                                    type="text" name="params[name]" id="project_name" maxlength="<?=$project_name_max_length?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">
                            <span>项目Key</span>
                        </label>
                        <div class="col-sm-10">
                            <input placeholder="必须英文字符,最大长度<?=$project_key_max_length?>,创建后不可修改" class="form-control" tabindex="3"
                                    type="text" name="params[key]" id="project_key" maxlength="<?=$project_key_max_length?>">
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
                            项目类型
                        </label>
                        <div class="col-sm-10 radio-with">
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
                            <span class="light"></span>
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" maxlength="250" name="params[description]" id="project_description"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="project_detail">项目详情</label>
                        <div class="col-sm-10">
                            <div id="editor_md">
                                <textarea style="display:none;" name="params[detail]" id="project_detail"></textarea>
                            </div>
                            <div class="help-block"><a href="#">help</a></div>
                        </div>
                    </div>

                    <!--div class="form-group">
                        <label class="control-label" for="project_lead">
                            <span>项目负责人</span>
                        </label>
                        <div class="col-sm-10">
                            <div class="select2-container">
                                <select class="selectpicker" data-live-search="true" name="params[lead]" id="project_lead">
                                    <option data-tokens="请选择" value="0">请选择</option>
                                    <?php foreach ($users as $user){ ?>
                                        <option data-tokens="<?=$user['display_name']?>" value="<?= $user['uid']?>"><?= $user['display_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div-->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group issue-assignee">
                                <label class="control-label col-lg-4" for="project_lead">项目负责人</label>
                                <div class="col-lg-8 col-sm-10">
                                    <div class="issuable-form-select-holder">
                                        <input type="hidden" name="params[lead]" id="project_lead" />
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
                                                <span class="dropdown-toggle-text is-default">项目负责人</span>
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
                                    <a class="assign-to-me-link " href="#">赋予给我</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
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
                            <input type="hidden"  name="params[avatar_relate_path]" id="avatar"  value=""  />
                            <div id="fine-uploader-gallery"></div>
                            <div class="help-block">图片大小被限制为200KB.</div>
                        </div>
                    </div>


                    <div class="form-actions text-right">
                        <input type="submit" name="commit" value="创建项目" class="btn btn-create disabled js-key-enter">
                        <a class="btn btn-cancel" href="javascript:history.go(-1)" style="float: none">取消</a>
                    </div>
                </form>


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
                <button type="button" class="qq-cancel-button-selector">取消</button>
                <button type="button" class="qq-ok-button-selector">好的</button>
            </div>
        </dialog>
    </div>
</script>



<script>


    $(function() {
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


        $("input[name='params[type]']:eq(0)").attr("checked",'checked');

        $('#fine-uploader-gallery').fineUploader({
            template: 'qq-template-gallery',
            multiple : false,
            request: {
                endpoint: '<?=ROOT_URL?>projects/upload' +'?_csrftoken='+encodeURIComponent(document.getElementById('csrf_token').value)
            },
            deleteFile: {
                enabled: false // defaults to false
                //endpoint: '/my/delete/endpoint'
            },
            retry: {
                enableAuto: true
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
                sizeLimit: 1024*200
            },
            callbacks:{
                onComplete:  function(id,  fileName,  responseJSON)  {
                    // console.log(responseJSON);
                    if(responseJSON.error == ''){
                        $('#avatar').val(responseJSON.relate_path);
                    }
                }
            }
        });

        var add_options = {
            beforeSubmit: function (arr, $form, options) {

                return true;
            },
            success: function (resp, textStatus, jqXHR, $form) {
                if(resp.ret == '200'){
                    //console.log(resp)
                    notify_error(resp.msg);
                    location.href = '<?=ROOT_URL?>'+resp.data.path;
                }else{
                    // console.log(resp);
                    for (var Key in resp.data){
                        //console.log(Key+'='+resp.data[Key]);
                    }
                    notify_error(resp.msg);
                }
            },
            type:      "post",
            dataType:  "json",
            clearForm: false,
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