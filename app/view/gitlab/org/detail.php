<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php';?>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/issuable.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/origin/origin.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>


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
            <div class="top-area">

                <div class="nav-controls row-fixed-content" style="float: left;margin-left: 0px">
                    <form id="filter_form" action="/admin/user/filter" accept-charset="UTF-8" method="get">
                        Organizations
                    </form>
                </div>
                <div class="nav-controls" style="right: ">

                    <div class="project-item-select-holder">

                        <a class="btn btn-new btn_issue_type_add" href="/org">
                            <i class="fa fa-plus"></i>
                            返回
                        </a>
                    </div>

                </div>

            </div>
            <div class="content" id="content-body">
                <form class="group-form form-horizontal gl-show-field-errors" id="origin_form"
                      enctype="multipart/form-data" action="/org/add" accept-charset="UTF-8" method="post">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <div class="form-group">
                        <label class="control-label" for="group_path">Origin path
                        </label>
                        <div class="col-sm-10">
                            <label class="control-label"><?=ROOT_URL?>{{path}}</label>
                        </div>
                    </div>
                    <div class="form-group group-name-holder">
                        <label class="control-label" for="group_name">Origin name
                        </label>
                        <div class="col-sm-10">
                            <label class="control-label">{{name}}</label>
                        </div>
                    </div>
                    <div class="form-group group-description-holder">
                        <label class="control-label" for="group_description">Description</label>
                        <div class="col-sm-10">
                            <label class="control-label">{{description}}</label>
                        </div>
                    </div>

                    <div class="form-group group-description-holder">
                        <label class="control-label" for="group_avatar">Origin avatar</label>
                        <div class="col-sm-10">
                            <img id="avatar_display" class="avatar s40 hidden" alt="" src="/">
                        </div>
                    </div>
                    <div class="form-group visibility-level-setting">
                        <label class="control-label" for="group_visibility_level">Visibility Level
                            <a href="/help/public_access/public_access"><i aria-hidden="true" data-hidden="true" class="fa fa-question-circle"></i></a>
                        </label>
                        <div class="col-sm-10">
                            <label class="control-label">{{visibility}}</label>

                        </div>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>


<!-- Fine Uploader Gallery template
   ====================================================================== -->

<script type="text/javascript">

    var _cur_uid = '<?=$user['uid']?>';
    var $origin = null;

    $(function () {

        window.$origin = new Origin( {} );

        window.$origin.fetch( <?=$id?> );

    });

</script>


</body>
</html>