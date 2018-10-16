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

<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
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
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            标签
                        </h4>
                        <p>
                            星号标签，使其成为优先标签。通过拖动对优先级标签进行排序，以更改相对优先级。
                            <strong></strong>
                        </p>
                    </div>
                    <div class="col-lg-9">
                        <div class="top-area adjust setting-form">
                            <div class="nav-text">
                                标签可以应用于问题和合并请求
                            </div>
                            <div class="nav-controls">
                                <a class="btn btn-new" href="<?=$project_root_url?>/settings_label_new">添加标签
                                </a>
                            </div>
                        </div>

                        <div class="panel panel-default margin-t">
                            <div class="panel-heading">
                                <strong>标签</strong>
                            </div>

                            <ul class="flex-list content-list manage-labels-list js-other-labels" id="list_render_id">

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
                项目标签
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
            filter_url:"<?=ROOT_URL?>project/label/list_data?project_id=<?=$project_id?>"
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
