<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js?v=<?=$_version?>"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>


<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
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
        <div class="container-fluid ">
            <div class="content" id="content-body">


                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            权限
                        </h4>

                        <p>项目权限允许你控制谁可以访问这个项目, 以及他们可以执行哪些操作, 例如 "编辑事项", "创建事项"等。要限制用户访问某一个事项，需要在事项权限中设置。</p>
                        <p>权限方案定义了这个项目的权限是如何配置的。修改权限,您可以选择一个不同的许可方案,或修改当前选中的方案。</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <!--事项类型-->
                                <strong>Default Permission Scheme</strong>

                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                    <input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">


                                        <div class="nav-controls">
                                            <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Subscribe">
                                                <i class="fa fa-question"></i> Permission helper
                                            </a>
                                            <a class="btn " title="New issue" id="new_issue_link" href="#">
                                                <i class="fa fa-edit"></i> 修改权限
                                            </a>

                                        </div>
                                    </div>
                                </form>


                            </div>

                            <div class="content-list pipelines">
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                                <div class="table-holder">
                                    <table class="table ci-table">

                                        <tr class="commit-header">
                                            <td>

                                            </td>
                                            <td>
                                                <h4 >项目权限</h4>
                                            </td>
                                            <td  >

                                            </td>
                                            <td class="pipeline-actions">

                                            </td>
                                            <td class="pipeline-actions">

                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="js-pipeline-info pipeline-info"></th>
                                            <th class="js-pipeline-commit pipeline-commit">权限</th>
                                            <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">授权给</span></th>
                                            <th class="js-pipeline-actions pipeline-actions"></th>
                                        </tr>

                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">管理项目</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许在JIRA中管理项目。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">浏览项目</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许浏览项目和项目所属的事项。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">Manage Sprints</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">Ability to manage sprints.</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">View Development Tools</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >Allows users in a software project to view development-related information on the issue </span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">查看工作流</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >拥有这个权限的用户可以查看工作流。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">Manage Sprints</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">Ability to manage sprints.</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>

                                        <tr class="commit-header">
                                            <td>

                                            </td>
                                            <td>
                                                <h4 >事项权限</h4>
                                            </td>
                                            <td  >

                                            </td>
                                            <td class="pipeline-actions">

                                            </td>
                                            <td class="pipeline-actions">

                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="js-pipeline-info pipeline-info"></th>
                                            <th class="js-pipeline-commit pipeline-commit">权限</th>
                                            <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">授权给</span></th>
                                            <th class="js-pipeline-actions pipeline-actions"></th>
                                        </tr>

                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">被分配</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许其他用户把事项分配给这个权限的用户。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">分配事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许分配事项给其他用户。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">关闭事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许关闭事项。通常是开发人员解决事项，质检部门负责关闭。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">创建事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许创建事项</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">删除事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span >允许删除事项。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">链接事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许将多个事项建立联系。只有当链接事项功能打开后才能使用。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">修改报告人</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许在创建和编辑事项时修改报告人。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">移动事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许在不同项目之间或同一个项目不同工作流之间移动事项。请注意，用户必须具有目标项目的创建事项权限才能将事项移动到目标项目中。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">解决事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许解决和重新打开事项。包括可以设置'解决版本'。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">规划事项日程</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许查看或编辑事项的到期日。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">设置安全级别</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许设置一个事项的安全级别，来决定哪些用户可以浏览这个事项。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">执行工作流</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许执行工作流。</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="commit">
                                            <td>

                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong>
                                                            <span>
                                                                <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                                    <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                                         title="guosheng" class="avatar has-tooltip s20">
                                                                </a>
                                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">编辑事项</a>
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <span href="#" class="commit-id monospace">允许编辑事项</span>

                                                </div>
                                            </td>
                                            <td  >
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">项目角色:</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">Administrator</a>
                                                     </span>
                                                </p>
                                                <p>
                                                    <span class="list-item-name">
                                                        <strong>
                                                            <a href="/sven">用 户 组  :</a>
                                                        </strong>
                                                        <a class="member-group-link" href="/ismond">qa</a>
                                                     </span>
                                                </p>

                                            </td>
                                            <td class="pipeline-actions">
                                                <div class="controls member-controls">
                                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73"
                                                          action="#" accept-charset="UTF-8" data-remote="true" method="post">
                                                        <div class="member-form-control dropdown append-right-5">
                                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown"
                                                                    data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
                                                                <span class="dropdown-toggle-text">Developer</span>
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                                <div class="dropdown-title">
                                                                    <span>Change permissions</span>
                                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <ul>
                                                                        <li>
                                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a></li>
                                                                        <li>
                                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a></li>
                                                                        <li>
                                                                            <a class="is-active" data-id="30" data-el-id="project_member_73"
                                                                               href="javascript:void(0)">Developer</a></li>
                                                                        <li>
                                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="pipeline-actions">

                                                <a class="btn append-right-10 has-tooltip" title="" href="#" data-original-title="Remove">
                                                    <i class="fa fa-remove"></i> Remove
                                                </a>
                                            </td>
                                        </tr>


                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    </div>
</body>
</html>