<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/org/org.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>

    <link href="<?=ROOT_URL?>dev/css/dashboard.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/css/statistics.css" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/css/organizations.css" rel="stylesheet">

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

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid container-limited"  >

                    <div class="content-block padding-lg margin-b-lg content-block-header">
                        <h3 class="header-title">
						<span class="g-avatar g-avatar-md">
							<img src="https://gw.alipayobjects.com/zos/rmsportal/WdGqmHpayyMjiEhcKoVE.png" alt="">
						</span>
                            <span class="org-title">xxxxx</span>
                        </h3>
                        <ul class="header-desc clearfix">
                            <li><span class="desc-label">关键字：</span> <span>用户姓名</span></li>
                            <li><span class="desc-label">用户姓名：</span> <span>用户姓名</span></li>
                            <li><span class="desc-label">用户姓名：</span> <span>用户姓名</span></li>
                        </ul>
                    </div>

                    <div class="content-block padding-lg margin-b-lg content-block-body">
                        <h3 class="body-title">项目列表</h3>

                        <div class="body-content">
                            <!-- Table -->
                            <table class="table">
                                <!--<thead>-->
                                <!--<tr>-->
                                <!--<th>项目名称</th>-->
                                <!--<th>基本信息</th>-->
                                <!--<th>百分比</th>-->
                                <!--</tr>-->
                                <!--</thead>-->

                                <tbody id="projects_list">

                                </tbody>
                            </table>
                        </div>

                        <div class="gl-pagination" id="ampagination-bootstrap">
                            <ul class="pagination clearfix ">
                                <li class="active"><a title="Current page is 1">1</a></li>
                                <li><a title="Go to page 2">2</a></li>
                                <li><a title="Go to page 3">3</a></li>
                                <li><a title="Go to page 4">4</a></li>
                                <li><a title="Go to page 5">5</a></li>
                                <li><a title="Go to next page">&gt;</a></li>
                                <li><a title="Go to last page">&gt;&gt;</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/html"  id="list_tpl">
    {{#projects}}
        <tr>
            <td>
                <span class="list-item-name">
                    <a href="#">
                        <img class="header-user-avatar has-tooltip"
                             data-original-title="{{name}}"
                             src="https://cn.gravatar.com/avatar/7bb5e88f72b82e8d27b0b99e56ff5441?s=80&amp;d=mm&amp;r=g">
                    </a>
                </span>

                <p class="list-item-text"><a href="#">{{name}}</a></p>
                <p class="list-item-text">{{description}}</p>
            </td>
            <td>
                <p>Owner</p>
                <p>傅萧萧</p>
            </td>
            <td>
                <p>开始时间</p>
                <p>2018-08-27 10:43</p>
            </td>
            <td>
                <div class="progress">
                    <div class="progress-outer">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width:12%">
                        </div>
                    </div>

                    <span class="progress-text">12%</span>
                </div>
            </td>

            <td>
                <ul class="list-item-action clearfix">
                    <li>
                        <a>详情</a>
                    </li>
                    <li class="dropdown-trigger">
                        <a>
                            更多
                            <i class="fa fa-down"></i>
                        </a>

                        <div class="dropdown-content">
                            <a href="#">设置</a>
                            <a href="#">移除</a>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
    {{/projects}}

</script>

<script type="text/javascript">

    var $org = null;
    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            filter_url:"/org/fetch_all",
            get_url:"/org/get",
            update_url:"/org/update",
            add_url:"/org/add",
            delete_url:"/org/delete",
            pagination_id:"pagination"
        }
        window.$org = new Org( options );
        window.$org.fetch( '<?=$id?>');
    });

</script>
</body>
</html>