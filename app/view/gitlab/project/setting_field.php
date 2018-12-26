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
                            字段
                        </h4>

                        <p>不同的事项可以使用不同的字段。 字段配置定义了一个项目中字段的属性, 例如 必填项/可选项; 隐藏/显示。</p>
                        <p>字段配置方案定义了这个项目使用哪些字段。 要更改正在使用的字段, 你可以选择其他字段配置方案, 或编辑当前方案</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="light prepend-top-default">
                            <form class="users-project-form" id="new_project_member" action="#" accept-charset="UTF-8" method="post">


                                <div class="form-group">

                                    <div class="help-block append-bottom-10">

                                    </div>
                                </div>

                            </form>

                            <div class="append-bottom-default clearfix">
                                <h5 class="member existing-title">
                                    这个项目使用了如下界面方案.
                                </h5>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>编辑 Default Field Configuration &nbsp;&nbsp;&nbsp;</strong>
                                这 10 个事项类型:
                                <span title="Bug"> <i class="fa fa-bug "></i>Bug </span>
                                <span title="Task"> <i class="fa fa-tasks"></i>任务  </span>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                    <input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">
                                        <a class="btn btn-edit" title="修改Default Issue Type Screen Scheme" href="#"><i class="fa fa-edit"></i> 修改</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-holder">
                                <table class="table ci-table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-commit pipeline-commit">字段名称</th>
                                        <th class="js-pipeline-stages pipeline-info">必选项</th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">渲染界面</span></th>
                                        <th class="js-pipeline-date pipeline-date">配置</th>
                                        <th class="js-pipeline-actions pipeline-actions"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="commit">
                                        <td>
                                            <div class="branch-commit">
                                                    <strong><span>
                                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">主题</a>
                                                        </span>
                                                    </strong>
                                                <span  ></span>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>

                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>
                                        <td class="pipelines-time-ago">
                                            <!---->
                                            <p class="finished-at">
                                                <i class="fa fa-calendar"></i>
                                                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                    1 个界面
                                                </time>
                                            </p>
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="commit">
                                        <td>
                                            <div class="branch-commit">
                                                    <strong><span>
                                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">优先级 </a>
                                                        </span>
                                                    </strong>
                                                <span  ></span>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>

                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>
                                        <td class="pipelines-time-ago">
                                            <!---->
                                            <p class="finished-at">
                                                <i class="fa fa-calendar"></i>
                                                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                    1 个界面
                                                </time>
                                            </p>
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="commit">
                                        <td>
                                            <div class="branch-commit">
                                                    <strong><span>
                                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">描述</a>
                                                        </span>
                                                    </strong>
                                                <span  ></span>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>

                                        <td>
                                            <a href="#" class="commit-id monospace">默认文本渲染器</a>

                                        </td>
                                        <td class="pipelines-time-ago">
                                            <!---->
                                            <p class="finished-at">
                                                <i class="fa fa-calendar"></i>
                                                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                    1 个界面
                                                </time>
                                            </p>
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="commit">
                                        <td>
                                            <div class="branch-commit">
                                                    <strong><span>
                                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">模块 </a>
                                                        </span>
                                                    </strong>
                                                <span  >描述............................................</span>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>

                                        <td>
                                            <a href="#" class="commit-id monospace">自动完成</a>

                                        </td>
                                        <td class="pipelines-time-ago">
                                            <!---->
                                            <p class="finished-at">
                                                <i class="fa fa-calendar"></i>
                                                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                    1 个界面
                                                </time>
                                            </p>
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="commit">
                                        <td>
                                            <div class="branch-commit">

                                                    <strong><span>
                                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">经办人 </a>
                                                        </span>
                                                    </strong>
                                                    <span >描述............................................</span>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="commit-id monospace">是</a>

                                        </td>

                                        <td>
                                            <a href="#" class="commit-id monospace">自动完成</a>

                                        </td>
                                        <td class="pipelines-time-ago">
                                            <!---->
                                            <p class="finished-at">
                                                <i class="fa fa-calendar"></i>
                                                <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                    1 个界面
                                                </time>
                                            </p>
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
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
</section>
</body>
</html>