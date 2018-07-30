<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/label.js" type="text/javascript" charset="utf-8"></script>
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
        <div class="">
            <div class="content" id="content-body">




                <div class="container-fluid container-limited">
                    <div class="top-area adjust">
                        <div class="nav-text">
                            Labels can be applied to issues and merge requests. Star a label to make it a priority label. Order the prioritized labels to change their relative priority, by dragging.
                        </div>
                        <div class="nav-controls">
                            <a class="btn btn-new" href="<?=$project_root_url?>/settings_label_new">添加标签
                            </a></div>
                    </div>
                    <div class="labels">

                        <div class="other-labels">
                            <h5 class="">Labels</h5>
                            <ul class="content-list manage-labels-list js-other-labels" id="list_render_id">

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<script type="text/html" id="list_tpl">
    {{#labels}}
    <li data-id="{{id}}" id="project_label_{{id}}">
        <span class="label-row">
            <span class="label-name">
                <a href="<?=ROOT_URL?>issue/main">
                    <span class="label color-label " style="background-color: {{bg_color}}; color: {{color}}" title="" data-container="body">{{title}}</span>
                </a>
            </span>
            <span class="label-type">
                Project Label
            </span>
        </span>

        <div class="pull-right hidden-xs hidden-sm hidden-md">
            <a class="btn btn-transparent btn-action" href="<?=ROOT_URL?>issue/main">view open issues</a>
            <a title="编辑" class="btn btn-transparent btn-action" data-toggle="tooltip" href="<?=$project_root_url?>/settings_label_edit?id={{id}}">
                <span class="sr-only">编辑</span>
                <i class="fa fa-pencil-square-o"></i>
            </a>
            <a title="删除" class="btn btn-transparent btn-action remove-row" onclick="remove({{id}})" data-confirm="Remove this label? Are you sure?" data-toggle="tooltip" rel="nofollow" data-method="delete" href="javascript:void(0)">
                <span class="sr-only">删除</span>
                <i class="fa fa-trash-o"></i>
            </a>
        </div>

    </li>
    {{/labels}}
</script>

<script>
    let query_str = '<?=$query_str?>';
    let urls = parseURL(window.location.href);

    $(function() {
        let options = {
            query_str: window.query_str,
            query_param_obj: urls.searchObject,
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"<?=ROOT_URL?>project/label/list?project_id=<?=$project_id?>"
        };
        window.$labels = new Label(options);
        window.$labels.fetchAll();

    });

    function remove(label_id) {
        window.$labels.delete(<?=$project_id?>, label_id);
    }
</script>




</body>
</html>
