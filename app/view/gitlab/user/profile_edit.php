<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/js/user/profile.js" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="profiles:show" data-project="">
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

    <? require_once VIEW_PATH.'gitlab/user/common-page-nav.php';?>
    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">
                <form class="edit-user prepend-top-default" id="edit_user" enctype="multipart/form-data" action="/user/set_profile" accept-charset="UTF-8" method="post">
                    <input type="hidden" name="_method" value="put" />
                    <input type="hidden" name="authenticity_token" value="" />
                    <input type="hidden" name="image" id="image" value="" />
                    <div class="row">
                        <div class="col-lg-3 profile-settings-sidebar">
                            <h4 class="prepend-top-0">Public Avatar</h4>
                            <p>You can change your avatar here or remove the current avatar to revert to
                                <a href="http://gravatar.com">gravatar.com</a></p>
                        </div>
                        <div class="col-lg-9">
                            <div class="clearfix avatar-image append-bottom-default">
                                <a target="_blank" rel="noopener noreferrer" href="#">
                                    <img id="avatar_display" alt="" class="avatar s160" src="" /></a>
                            </div>
                            <h5 class="prepend-top-0">Upload new avatar</h5>
                            <div class="prepend-top-5 append-bottom-10">
                                <a class="btn js-choose-user-avatar-button">Browse file...</a>
                                <span class="avatar-file-name prepend-left-default js-avatar-filename">No file chosen</span>
                                <input class="js-user-avatar-input hidden" accept="image/*" type="file" name="user[avatar]" id="user_avatar" /></div>
                            <div class="help-block">The maximum file size allowed is 200KB.</div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 profile-settings-sidebar">
                            <h4 class="prepend-top-0">Main settings</h4>
                            <p>This information will appear on your profile.</p>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="display_name">Display Name:</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" required="required" type="text" value="" name="user[display_name]" id="display_name" />
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="help-block">Enter your name, so people you know can recognize you.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="user_birthday">Birthday:</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" required="required" type="text" value="" name="params[birthday]" id="user_birthday" />
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            birthday
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="user_sex">Sex:</label>
                                    </div>
                                    <div class="col-lg-6">
                                            <div class="">
                                                <div class="radio">
                                                    <label for="sex_0"><input type="radio" value="0"  name="params[sex]" id="sex_0">
                                                        <div class="option-title">
                                                            <i class="fa fa-lock fa-fw"></i>
                                                            Private
                                                        </div>
                                                        <div class="option-descr">
                                                        </div>
                                                    </label></div>
                                                <div class="radio">
                                                    <label for="sex_1"><input type="radio" value="1" name="params[sex]" id="sex_1">
                                                        <div class="option-title">
                                                            <i class="fa fa-venus  fa-fw"></i>
                                                            男
                                                        </div>
                                                        <div class="option-descr">

                                                        </div>
                                                    </label></div>
                                                <div class="radio">
                                                    <label for="sex_2"><input type="radio" value="2" name="params[sex]" id="sex_2">
                                                        <div class="option-title">
                                                            <i class="fa fa-mercury fa-fw"></i>
                                                            女
                                                        </div>
                                                        <div class="option-descr">

                                                        </div>
                                                    </label>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="description">Introduction:</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <textarea rows="4" class="form-control" maxlength="250" name="params[description]" id="description"></textarea>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="help-block">Tell us about yourself in fewer than 250 characters.</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="row prepend-top-default append-bottom-default">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3">
                            <input type="button" name="commit" id="commit" value="Update profile settings" class="btn btn-success" />
                        </div>
                        <div class="col-lg-3">
                            <a class="btn btn-cancel" href="/user/profile">Cancel</a>
                        </div>
                        <div class="col-lg-3">
                        </div>
                    </div>
                </form>
                <div class="modal modal-profile-crop">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    <span>&times;</span></button>
                                <h4 class="modal-title">Position and size your new avatar</h4></div>
                            <div class="modal-body">
                                <div class="profile-crop-image-container">
                                    <img alt="Avatar cropper" class="modal-profile-crop-image"></div>
                                <div class="crop-controls">
                                    <div class="btn-group">
                                        <button class="btn btn-primary" data-method="zoom" data-option="0.1">
                                            <span class="fa fa-search-plus"></span>
                                        </button>
                                        <button class="btn btn-primary" data-method="zoom" data-option="-0.1">
                                            <span class="fa fa-search-minus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary js-upload-user-avatar" type="button">Set new profile picture</button></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

    laydate.render({
        elem: '#user_birthday'
    });
</script>

<script type="text/javascript">

    var $profile = null;
    $(function() {
        laydate.render({
            elem: '#user_birthday'
        });
        var options = {
            uid:window.current_uid,
            get_url:"/user/get",
            update_url:"/user/setProfile",
        }

        $('#commit').bind('click',function(){
            window.$profile.update();
        })
        window.$profile = new Profile( options );
        window.$profile.fetch( window.current_uid );
    });



</script>


</body>
</html>

