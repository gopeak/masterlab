<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

</head>
<body class="" data-group="" data-page="profiles:show" data-project="">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

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

            <div class="content" id="content-body">
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
                    <form class="row prepend-top-default js-preferences-form" id="edit_user_<?=$user['uid']?>" action="/user/preferences" accept-charset="UTF-8" data-remote="true" method="post">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="_method" value="put">
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
                                此设置允许您自定义语法的外观。
                                <a target="_blank" href="/help/user/profile/preferences#syntax-highlighting-theme">了解更多</a>.
                            </p>
                        </div>
                        <div class="col-lg-8 syntax-theme">
                            <label><div class="preview"><img class="js-lazy-loaded" src="https://assets.gitlab-static.net/assets/white-scheme-preview-ce2e9957bbb5c9b6bdbb554984e1af877c89615db7e866aa9022430a6aba618f.png"></div>
                                <input type="radio" value="1" checked="checked" name="user[color_scheme_id]" id="user_color_scheme_id_1">
                                极简风格
                            </label><label><div class="preview"><img class="js-lazy-loaded" src="https://assets.gitlab-static.net/assets/dark-scheme-preview-cbefadee862bccdd68fbc5ea1e520150718425f5e0ae88c59ff1dfedc100d416.png"></div>
                                <input type="radio" value="2" name="user[color_scheme_id]" id="user_color_scheme_id_2">
                                顶部菜单
                            </label><label><div class="preview"><img class="js-lazy-loaded" src="https://assets.gitlab-static.net/assets/solarized-light-scheme-preview-c65e32b38abddf809082e2820e70eccc8fa82d4c4e17455c89f1843cd1b809ae.png"></div>
                                <input type="radio" value="3" name="user[color_scheme_id]" id="user_color_scheme_id_3">
                                左侧菜单
                            </label>
                        </div>
                        <div class="col-sm-12">
                            <hr>
                        </div>
                        <div class="col-lg-4 profile-settings-sidebar">
                            <h4 class="prepend-top-0">
                                行为
                            </h4>
                            <p>
                                此设置允许您自定义系统布局和默认视图的行为。
                                <a target="_blank" href="/help/user/profile/preferences#behavior">了解更多</a>.
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="label-light" for="user_layout">事项分页数
                                </label><select class="form-control" name="user[layout]" id="user_layout"><option selected="selected" value="fixed">固定</option>
                                    <option value="fluid">自适应</option></select>
                                <div class="form-text text-muted">
                                    在固定（最大1200 px）和自适应（100%）应用程序布局之间进行选择。
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="user_dashboard">登录后显示
                                </label>
                                <select class="form-control" name="user[dashboard]" id="user_dashboard">
                                    <option selected="selected" value="projects">项目列表</option>
                                    <option value="project_activity">活动动态</option>
                                    <option value="issues">分配给我的事项</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="user_project_view">
                                    项目首页显示
                                </label>
                                <select class="form-control" name="user[project_view]" id="user_project_view">
                                    <option selected="selected" value="files">文件和自述文件 (默认)</option>
                                    <option value="activity">活动</option>
                                    <option value="readme">自述文件</option>
                                </select>
                                <div class="form-text text-muted">
                                    在项目概览页面中选择您希望看到的内容
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
            get_url:"<?=ROOT_URL?>user/get",
            update_url:"<?=ROOT_URL?>user/setProfile",
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

