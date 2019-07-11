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
                        $profile_nav='filters';
                        include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                        ?>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="content" id="content-body">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">保存的过滤器</a>
                                </li>
                            </ul>
                        </div>
                        <div class="content-list">
                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">过滤器名称</th>
                                        <th class="js-pipeline-info pipeline-info">所属项目</th>
                                        <th class="js-pipeline-stages pipeline-info">过滤条件</th>
                                        <th class="pipeline-info" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="list_render_id">
                                    </tbody>
                                </table>
                            </div>
                            <div class="gl-pagination" id="pagination">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>

</div>

</section>

<script type="text/html"  id="list_tpl">
    {{#filters}}
        <tr class="commit">
            <td>
                <strong><a style="color: #1890ff;" href="/issue/main?fav_filter={{id}}">{{name}}</a> </strong>
            </td>
            <td>
                {{make_project projectid}}
            </td>
            <td>
                <a style="color: #1890ff;" href="/issue/main?fav_filter={{id}}">{{filter}}</a>
            </td>
            <td  >
                <a class="list_for_delete btn btn-transparent  "  href="javascript:;" data-value="{{id}}" style="padding: 6px 2px;">
                    <i class="fa fa-trash"></i>
                    <span class="sr-only">删除</span>
                </a>

            </td>
        </tr>
    {{/filters}}
</script>

<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
<script src="<?= ROOT_URL ?>dev/js/user/filters.js?v=<?=$_version?>"></script>
<script type="text/javascript">

    var _issueConfig = {
        "projects":<?=json_encode($projects)?>
    };

    var $obi = null;
    $(function() {

        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"<?=ROOT_URL?>user/fetch_filters",
            delete_url:"<?=ROOT_URL?>user/delete_filter",
            pagination_id:"pagination"

        }
        window.$obi = new UserFilters( options );
        window.$obi.fetchUserFilterss( );

    });

</script>

</body>
</html>

