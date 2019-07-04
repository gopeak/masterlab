<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/issuable.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/url_param.js?v=<?= $_version ?>" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/org/org.js?v=<?= $_version ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/issue/main/upload";
        window.preview_markdown_path = "/issue/main/preview_markdown";
    </script>

    <script type="text/javascript" src="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.css"/>

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/e-smart-zoom-jquery.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>


</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>


        <div class="page-with-sidebar">

            <div class="content-wrapper page-with-layout-nav ">
                <div class="alert-wrapper">

                    <div class="flash-container flash-container-page">
                    </div>

                </div>
                <div class="container-fluid container-limited">
                    <div class="content" id="content-body">
                        <h3 class="page-title">组织</h3>
                        <p>比如一个事业部或公司内部有多个子公司</p>
                        <hr>
                        <form class="group-form form-horizontal gl-show-field-errors" id="origin_form"
                              enctype="multipart/form-data" action="/org/add" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="form-group">
                                <label class="control-label" for="group_path">组织关键字 <span class="required"> *</span>
                                </label>
                                <div class="col-sm-10">
                                    <div class="input-group gl-field-error-anchor">
                                        <div class="group-root-path input-group-addon has-tooltip"
                                             data-placement="bottom" title=""
                                             data-groupal-title="/"><span>/</span>
                                        </div>
                                        <input type="hidden" name="params[parent_id]" id="group_parent_id">
                                        <input placeholder="英文字母,长度4-32" class="form-control" autofocus="autofocus"
                                               required="required"
                                               pattern="[a-zA-Z0-9_\.][a-zA-Z0-9_\-\.]*[a-zA-Z0-9_\-]|[a-zA-Z0-9_]"
                                               title="Please choose a group path with no special characters."
                                               data-bind-in="" type="text" name="params[path]" id="path" value="">
                                    </div>
                                    <? if ($action == 'add') { ?>
                                        <p class="gl-field-info ">
                                            以下为系统关键字，不可用:
                                            <?php
                                            foreach ($ctrlKeyArr as $unUseName) {
                                                echo "$unUseName ";
                                            }
                                            ?>
                                        </p>
                                    <? } ?>
                                    <p id="tip-path" class="gl-field-error hide"></p>
                                </div>
                            </div>
                            <div class="form-group group-name-holder">
                                <label class="control-label" for="group_name">名称 <span class="required"> *</span>
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" required="required" title="您可以选择与路径不同的描述性名称."
                                           type="text"
                                           name="params[name]" id="name" value="">
                                    <p id="tip-name" class="gl-field-error hide">您可以选择与路径不同的描述性名称.</p>
                                </div>
                            </div>
                            <div class="form-group group-description-holder">
                                <label class="control-label" for="group_description">描述</label>
                                <div class="col-sm-10">
                                    <textarea maxlength="250" class="form-control js-gfm-input" rows="4"
                                              name="params[description]" id="description"></textarea>
                                </div>
                            </div>

                            <div class="form-group group-description-holder">
                                <label class="control-label" for="group_avatar">图标</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="params[avatar]" id="avatar" value=""/>
                                    <input type="hidden" name="params[fine_uploader_json]" id="fine_uploader_json"
                                           value=""/>
                                    <img id="avatar_display" class="avatar s40 hidden" alt="" src="">
                                    <div id="avatar_uploder" class="fine_uploader_img"></div>
                                </div>
                            </div>
                            <div class="form-group visibility-level-setting" style="display: none;">
                                <label class="control-label" for="group_visibility_level">可见性</label>
                                <div class="col-sm-10 radio-with">
                                    <div class="radio">
                                        <label for="origin_scope_1"><input type="radio" checked="checked"
                                                                           name="params[scope]" id="origin_scope_1"
                                                                           value="1">
                                            <i aria-hidden="true" data-hidden="true" class="fa fa-lock fa-fw"></i>
                                            <div class="option-title">
                                                私 有
                                            </div>
                                            <div class="option-description">
                                                只有加入组织的人才可见
                                            </div>
                                            <div class="option-disabled-reason">
                                            </div>
                                        </label></div>
                                    <div class="radio">
                                        <label for="origin_scope_2">
                                            <input type="radio" name="params[scope]" id="origin_scope_2" value="2">
                                            <i aria-hidden="true" data-hidden="true" class="fa fa-shield fa-fw"></i>
                                            <div class="option-title">
                                                内 部
                                            </div>
                                            <div class="option-description">
                                                只要登录后的用户可见
                                            </div>
                                            <div class="option-disabled-reason">
                                            </div>
                                        </label></div>
                                    <div class="radio">
                                        <label for="origin_scope_3">
                                            <input type="radio" name="params[scope]" id="origin_scope_3" value="3">
                                            <i aria-hidden="true" data-hidden="true" class="fa fa-globe fa-fw"></i>
                                            <div class="option-title">
                                                公 开
                                            </div>
                                            <div class="option-description">
                                                谁都可以看到
                                            </div>
                                            <div class="option-disabled-reason">
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-actions text-right">
                                <input id="btn-save" type="button" name="commit" value="保 存"
                                       class="btn btn-create js-key-enter">
                                <a class="btn btn-cancel  prepend-left-10" href="/org">取 消</a>
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
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                 class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>点击上传</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite"
            aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                         class="qq-progress-bar-selector qq-progress-bar"></div>
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
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"
                              aria-label="Edit filename"></span>
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
                <button type="button" class="qq-cancel-button-selector">关闭</button>
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
                <button type="button" class="qq-ok-button-selector">确定</button>
            </div>
        </dialog>
    </div>
</script>

<script type="text/javascript">

    var _issueConfig = {};

    var _fineUploader = null;
    var _cur_uid = '<?=$user['uid']?>';
    var $org = null;


    var action = '<?=$action?>';
    $(function () {

        window.$org = new Org({});

        if (action == 'edit') {
            window.$org.fetch( <?=$id?> );
        }


        $('#btn-save').bind('click', function () {
            if (action == 'edit') {
                window.$org.update();
            } else {
                window.$org.add();
            }

        });

        _fineUploader = new qq.FineUploader({
            element: document.getElementById('avatar_uploder'),
            template: 'qq-template-gallery',
            multiple: false,
            request: {
                endpoint: '/issue/main/upload' + '?_csrftoken=' + encodeURIComponent(document.getElementById('csrf_token').value)
            },
            deleteFile: {
                enabled: true,
                endpoint: root_url + "issue/main/upload_delete"
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
            }
        });
    });

</script>

</body>
</html>