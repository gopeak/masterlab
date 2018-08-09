<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/version.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
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
                    <div class="col-lg-3 profile-settings-sidebar">
                        <h4 class="prepend-top-0">
                            项目角色设置
                        </h4>
                        <p>
                            Deploy keys allow read-only or read-write (if enabled) access to your repository. Deploy keys can be used for CI, staging or production servers. You can create a deploy key or add an existing one.
                        </p>
                    </div>
                    <div class="col-lg-9">
                        <h5 class="prepend-top-0">
                            创建一个属于当前项目的角色
                        </h5>
                        <form class="js-requires-input" id="new_deploy_key" action="/diamond/forever/deploy_keys" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="JfkrJLbm1hJmb2GK0ZMXe2GiXNVZ8vTPqk3l+rPix9drO9VQEu3BDVyaTxdautRbKJYSr2Ibxf8zAu2zF5pN3A==">
                            <div class="form-group">
                                <label class="label-light" for="deploy_key_title">角色名</label>
                                <input class="form-control" autofocus="autofocus" required="required" type="text" name="deploy_key[title]" id="deploy_key_title">
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="deploy_key_key">描述</label>
                                <textarea class="form-control" rows="5" required="required" name="deploy_key[key]" id="deploy_key_key"></textarea>
                            </div>
                            <div class="form-group">
                                <p class="light append-bottom-0">
                                    项目描述
                                    <a href="/help/ssh/README">here</a>
                                </p>
                            </div>
                            <div class="form-group">
                                <p class="light append-bottom-0">
                                    <a href="/help/ssh/README">选择权限</a>
                                </p>
                            </div>
                            <input type="submit" name="commit" value="添加项目角色" class="btn-create btn disabled" disabled="disabled">
                        </form>
                    </div>
                    <div class="col-lg-9 col-lg-offset-3">
                        <hr>
                    </div>
                    <div class="col-lg-9 col-lg-offset-3 append-bottom-default deploy-keys">
                        <h5 class="prepend-top-default">
                            项目角色列表
                        </h5>
                        <ul class="well-list">
                            <li>
                                <div class="pull-left append-right-10 hidden-xs">
                                    <i class="fa fa-key key-icon"></i>
                                </div>
                                <div class="deploy-key-content key-list-item-info">
                                    <strong class="title">
                                        Users
                                    </strong>
                                    <div class="description">
                                        A project role that represents users in a project
                                    </div>
                                </div>

                                <div class="deploy-key-content">
                                    <span class="key-created-at">
                                        系统默认
                                    </span>
                                    <div class="visible-xs-block visible-sm-block"></div>
                                    <a class="btn btn-sm prepend-left-10" rel="nofollow" data-method="put" href="/diamond/forever/deploy_keys/21/enable">
                                        编辑权限
                                    </a>
                                    <a class="btn btn-sm prepend-left-10" rel="nofollow" data-method="put" href="/diamond/forever/deploy_keys/21/enable">
                                        添加用户
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left append-right-10 hidden-xs">
                                    <i class="fa fa-key key-icon"></i>
                                </div>
                                <div class="deploy-key-content key-list-item-info">
                                    <strong class="title">
                                        Developers
                                    </strong>
                                    <div class="description">
                                        A project role that represents developers in a project
                                    </div>
                                    <div class="write-access-allowed">
                                        Write access allowed
                                    </div>
                                </div>

                                <div class="deploy-key-content">
                                    <span class="key-created-at">
                                        系统默认
                                    </span>
                                    <div class="visible-xs-block visible-sm-block"></div>
                                    <a class="btn btn-sm prepend-left-10" rel="nofollow" data-method="put" href="/diamond/forever/deploy_keys/21/enable">
                                        编辑权限
                                    </a>
                                    <a class="btn btn-sm prepend-left-10" rel="nofollow" data-method="put" href="/diamond/forever/deploy_keys/21/enable">
                                        添加用户
                                    </a>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>




<script>

</script>
</body>
</html>
