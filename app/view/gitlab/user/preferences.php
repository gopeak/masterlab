<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="profiles:show" data-project="">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
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

            <div class="content padding-0" id="content-body">
                <div class="cover-block user-cover-block">
                    <div class="scrolling-tabs-container">
                        <div class="fade-left">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="fade-right">
                            <i class="fa fa-angle-right"></i>
                        </div>
                        <?php
                        $profile_nav='preferences';
                        include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                        ?>
                    </div>
                </div>
                <div class="container-fluid container-limited">
                    <form class="row prepend-top-default js-preferences-form" id="user_setting"
                          action="/user/setPreferences" accept-charset="UTF-8" data-remote="true" method="post">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="_method" value="post">
                        <!--<div class="col-lg-4 application-theme">
                            <h4 class="prepend-top-0">
                                Navigation theme
                            </h4>
                            <p>Customize the appearance of the application header and navigation sidebar.</p>
                        </div>
                        <div class="col-lg-8 application-theme">
                            <label><div class="preview ui-indigo"></div>
                                <input type="radio" value="1" checked="checked" name="user[theme_id]" id="user_theme_id_1">
                                Indigo
                            </label><label><div class="preview ui-light-indigo"></div>
                                <input type="radio" value="6" name="user[theme_id]" id="user_theme_id_6">
                                Light Indigo
                            </label><label><div class="preview ui-blue"></div>
                                <input type="radio" value="4" name="user[theme_id]" id="user_theme_id_4">
                                Blue
                            </label><label><div class="preview ui-light-blue"></div>
                                <input type="radio" value="7" name="user[theme_id]" id="user_theme_id_7">
                                Light Blue
                            </label><label><div class="preview ui-green"></div>
                                <input type="radio" value="5" name="user[theme_id]" id="user_theme_id_5">
                                Green
                            </label><label><div class="preview ui-light-green"></div>
                                <input type="radio" value="8" name="user[theme_id]" id="user_theme_id_8">
                                Light Green
                            </label><label><div class="preview ui-red"></div>
                                <input type="radio" value="9" name="user[theme_id]" id="user_theme_id_9">
                                Red
                            </label><label><div class="preview ui-light-red"></div>
                                <input type="radio" value="10" name="user[theme_id]" id="user_theme_id_10">
                                Light Red
                            </label><label><div class="preview ui-dark"></div>
                                <input type="radio" value="2" name="user[theme_id]" id="user_theme_id_2">
                                Dark
                            </label><label><div class="preview ui-light"></div>
                                <input type="radio" value="3" name="user[theme_id]" id="user_theme_id_3">
                                Light
                            </label></div>
                        <div class="col-sm-12">
                            <hr>
                        </div>-->
                        <div class="col-lg-4 profile-settings-sidebar">
                            <h4 class="prepend-top-0">
                                导航风格
                            </h4>
                            <p>
                                此设置允许您自定义导航风格
                            </p>
                        </div>
                        <div class="col-lg-8 syntax-theme">
                            <label><div class="preview"><img class="js-lazy-loaded" src="<?=ROOT_URL?>gitlab/images/white-scheme-preview.png"></div>
                                <input type="radio" value="top" checked="checked" name="params[scheme_style]" id="scheme_top">
                                极简风格
                            </label><label><div class="preview"><img class="js-lazy-loaded" src="<?=ROOT_URL?>gitlab/images/solarized-light-scheme-preview.png"></div>
                                <input type="radio" value="left" name="params[scheme_style]" id="scheme_left">
                                左侧菜单
                            </label>
                        </div>
                        <div class="col-sm-12">
                            <hr>
                        </div>
                        <div class="col-lg-3 profile-settings-sidebar">
                            <h4 class="prepend-top-0">
                                布局界面
                            </h4>
                            <p>
                                此设置允许您自定义系统布局和默认视图的行为。
                            </p>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="layout">页面布局:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="params[layout]" id="layout">
                                            <option selected="selected" value="fixed">固定</option>
                                            <option value="fluid">自适应</option></select>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="help-block">在固定（最大1200 px）和自适应（100%）应用程序布局之间进行选择。</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="project_view">项目首页显示:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="params[project_view]" id="project_view">
                                            <option selected="selected" value="issues">事项列表</option>
                                            <option value="summary">项目概要</option>
                                            <option value="backlog">待办事项</option>
                                            <option value="sprints">迭代列表</option>
                                            <option value="board">迭代看板</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="help-block">在项目概览页面中选择您希望看到的内容。</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="label-light" for="issue_view">事项显示:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="params[issue_view]" id="issue_view">
                                            <option selected="selected" value="list">表格视图</option>
                                            <option value="detail">左右视图</option>
                                            <option value="responsive">响应式视图</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="help-block">在项目概览页面中选择您希望看到的内容。</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input id="commit" type="button" name="commit" value="保存" class="btn btn-save js-key-enter">
                            </div>

                        </div>

                    </form>
                </div>
            </div>

    </div>
</div>

    </div>
</section>
<script src="<?=ROOT_URL?>dev/js/user/preferences.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    var $userSetting = null;
    $(function() {
        var options = {
            form_id:'user_setting',
            uid:window.current_uid,
            get_url:"<?=ROOT_URL?>user/getPreferences",
            update_url:"<?=ROOT_URL?>user/setPreferences",
        }

        $('#commit').bind('click',function(){
            window.$userSetting.update();
        })
        window.$userSetting = new UserSetting( options );
        window.$userSetting.fetch( window.current_uid );
    });



</script>


</body>
</html>

