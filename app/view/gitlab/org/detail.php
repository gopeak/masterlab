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
                    <div class="top-area">

                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 0px">

                        </div>
                        <div class="nav-controls" style="right: ">

                            <div class="project-item-select-holder">

                                <a class="btn  btn_back" href="/org">
                                    <i class="fa fa-reply "></i>
                                    返 回
                                </a>
                            </div>

                        </div>

                    </div>
                    <div class="content-block padding-lg margin-b-lg content-block-header">
                        <h3 class="header-title">
						<span class="g-avatar g-avatar-md">
							<img id="org_avatar" src="" alt="">
						</span>
                            <span id="org_name" class="org-title"></span>
                        </h3>
                        <ul class="header-desc clearfix">
                            <li><span class="desc-label">关键字：</span> <span id="org_path"></span></li>
                            <li><span class="desc-label">描述：</span> <span id="org_description"></span></li>
                        </ul>
                    </div>

                    <div class="content-block padding-lg margin-b-lg content-block-body">
                        <h3 class="body-title">所属项目</h3>

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
                    {{#if avatar_exist}}
                        <a href="<?=ROOT_URL?>{{path}}/{{key}}" class="avatar-image-container">
                            <img src="{{avatar}}"  class="avatar has-tooltip s40">
                        </a>
                    {{^}}
                        <div class="avatar-container s40" style="display: block">
                            <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
                                <div class="avatar project-avatar s40 identicon"
                                     style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                            </a>
                        </div>
                    {{/if}}
                </span>
                <p class="list-item-text"><a href="<?=ROOT_URL?>{{path}}/{{key}}">{{name}}</a></p>
                <p class="list-item-text">{{description}}</p>
            </td>
            <td>
                {{user_html lead }}
                <strong>
                    <a href="/user/profile/{{lead}}">{{leader_display}}</a>
                </strong>
            </td>
            <td>
                <p>创建时间</p>
                <p>{{create_time_text}}</p>
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
                        <a href="<?=ROOT_URL?>{{path}}/{{key}}">详情</a>
                    </li>
                </ul>
            </td>
        </tr>
    {{/projects}}

</script>

<script type="text/javascript">

    var _issueConfig = {
        priority:<?=json_encode($priority)?>,
        issue_types:<?=json_encode($issue_types)?>,
        issue_status:<?=json_encode($issue_status)?>,
        issue_resolve:<?=json_encode($issue_resolve)?>,
        issue_module:<?=json_encode($project_modules)?>,
        issue_version:<?=json_encode($project_versions)?>,
        issue_labels:<?=json_encode($project_labels)?>,
        users:<?=json_encode($users)?>,
        projects:<?=json_encode($projects)?>
    };

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
        window.$org.detail( '<?=$id?>');
        window.$org.fetchProjects( '<?=$id?>');

    });

</script>
</body>
</html>