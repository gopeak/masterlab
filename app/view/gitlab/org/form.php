<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php';?>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/issuable.bundle.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/origin/origin.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>


</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php';?>
    </div>
</header>

<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav ">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">
            <div class="content" id="content-body">
                        <h4 class="prepend-top-0">
                            New Origin
                        </h4>
                        <p>
                            Create  your group from popular Git services
                        </p>
                <hr>
                <form class="group-form form-horizontal gl-show-field-errors" id="origin_form"
                      enctype="multipart/form-data" action="/org/add" accept-charset="UTF-8" method="post">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="form-group">
                        <label class="control-label" for="group_path">Origin path
                        </label><div class="col-sm-10">
                            <div class="input-group gl-field-error-anchor">
                                <div class="group-root-path input-group-addon has-tooltip" data-placement="bottom" title=""
                                     data-groupal-title="/"><span>/</span>
                                </div>
                                <input type="hidden" name="params[parent_id]" id="group_parent_id">
                                <input placeholder="open-source" class="form-control" autofocus="autofocus" required="required"
                                       pattern="[a-zA-Z0-9_\.][a-zA-Z0-9_\-\.]*[a-zA-Z0-9_\-]|[a-zA-Z0-9_]" title="Please choose a group path with no special characters."
                                       data-bind-in="" type="text" name="params[path]" id="path" value="">
                            </div><p class="gl-field-error hide">Please choose a group path with no special characters.</p>
                        </div>
                    </div>
                    <div class="form-group group-name-holder">
                        <label class="control-label" for="group_name">Origin name
                        </label><div class="col-sm-10">
                            <input class="form-control" required="required" title="You can choose a descriptive name different from the path."
                                   type="text"
                                   name="params[name]" id="name" value="">
                            <p class="gl-field-error hide">You can choose a descriptive name different from the path.</p>
                        </div>
                    </div>
                    <div class="form-group group-description-holder">
                        <label class="control-label" for="group_description">Description</label>
                        <div class="col-sm-10">
                            <textarea maxlength="250" class="form-control js-gfm-input" rows="4" name="params[description]" id="description"></textarea>
                        </div>
                    </div>

                    <div class="form-group group-description-holder">
                        <label class="control-label" for="group_avatar">Origin avatar</label>
                        <div class="col-sm-10">
                            <input type="hidden"  name="params[avatar]" id="avatar"  value=""  />
                            <input type="hidden"  name="params[fine_uploader_json]" id="fine_uploader_json"  value=""  />
                            <img id="avatar_display" class="avatar s40 hidden" alt="" src="/">
                            <div id="avatar_uploder" class="fine_uploader_img"></div>
                        </div>
                    </div>
                    <div class="form-group visibility-level-setting">
                        <label class="control-label" for="group_visibility_level">Visibility Level
                            <a href="/help/public_access/public_access"><i aria-hidden="true" data-hidden="true" class="fa fa-question-circle"></i></a>
                        </label><div class="col-sm-10">
                            <div class="radio">
                                <label for="origin_scope_1"><input type="radio"   checked="checked" name="params[scope]" id="origin_scope_1" value="1">
                                    <i aria-hidden="true" data-hidden="true" class="fa fa-lock fa-fw"></i>
                                    <div class="option-title">
                                        Private
                                    </div>
                                    <div class="option-description">
                                        The group and its projects can only be viewed by members.
                                    </div>
                                    <div class="option-disabled-reason">
                                    </div>
                                </label></div>
                            <div class="radio">
                                <label for="origin_scope_2">
                                    <input type="radio"   name="params[scope]" id="origin_scope_2" value="2">
                                    <i aria-hidden="true" data-hidden="true" class="fa fa-shield fa-fw"></i>
                                    <div class="option-title">
                                        Internal
                                    </div>
                                    <div class="option-description">
                                        The group and any internal projects can be viewed by any logged in user.
                                    </div>
                                    <div class="option-disabled-reason">
                                    </div>
                                </label></div>
                            <div class="radio">
                                <label for="origin_scope_3">
                                    <input type="radio"  name="params[scope]" id="origin_scope_3" value="3">
                                    <i aria-hidden="true" data-hidden="true" class="fa fa-globe fa-fw"></i>
                                    <div class="option-title">
                                        Public
                                    </div>
                                    <div class="option-description">
                                        The group and any public projects can be viewed without any authentication.
                                    </div>
                                    <div class="option-disabled-reason">
                                    </div>
                                </label></div>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <ul>
                                <li>A group is a collection of several projects</li>
                                <li>Members of a group may only view projects they have permission to access</li>
                                <li>Origin project URLs are prefixed with the group namespace</li>
                                <li>Existing projects may be moved into a group</li>
                            </ul>

                        </div>
                    </div>
                    <div class="form-actions">
                        <input id="btn-save" type="button" name="commit" value="Create" class="btn btn-create">
                        <a class="btn btn-cancel" href="/org">Cancel</a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>


<!-- Fine Uploader Gallery template
   ====================================================================== -->
<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here" >
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>Upload a file</div>
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
                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    Retry
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
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
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

<script type="text/javascript">

    var _issueConfig = {
    };

    var _fineUploader = null;
    var _cur_uid = '<?=$user['uid']?>';
    var $origin = null;


    var action = '<?=$action?>';
    $(function () {

        window.$origin = new Origin( {} );

        if( action=='edit'){
            window.$origin.fetch( <?=$id?> );
        }


        $('#btn-save').bind('click',function () {
            if( action=='edit'){
                window.$origin.update();
            }else{
                window.$origin.add();
            }

        });

        _fineUploader =  new qq.FineUploader({
            element: document.getElementById('avatar_uploder'),
            template: 'qq-template-gallery',
            multiple:false,
            request: {
                endpoint: '/issue/main/upload'
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
            }
        });
    });


</script>


</body>
</html>