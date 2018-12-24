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
                            界面
                        </h4>

                        <p>你可以在界面中管理事项所有需要显示的字段。 当事项创建、编辑、查看或者执行一个工作流时，可以显示不同的界面。</p>
                        <p>界面方案决定了这个项目使用哪些界面。 要改变正在使用的界面, 你可以选择其他界面方案, 或编辑当前方案。</p>
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
                                <strong>Default Issue Type Screen Scheme &nbsp;&nbsp;&nbsp;</strong>
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
                            <ul class="content-list">
                                <li class="group_member member" id="group_member_2">
                                    <span class="list-item-name">
                                        <strong>
                                            创建事项
                                        </strong>


                                    </span>
                                    <div class="controls member-controls">
                                        <a href="#"  style="color: #1b69b6;">Default Screen</a>
                                    </div>
                                </li>
                                <li class="group_member member" id="group_member_2">
                                    <span class="list-item-name">
                                        <strong>
                                            编辑事项
                                        </strong>


                                    </span>
                                    <div class="controls member-controls">
                                        <a href="#" style="color: #1b69b6;">Default Screen</a>
                                    </div>
                                </li>

                                <li class="group_member member" id="group_member_2">
                                    <span class="list-item-name">

                                        <strong>
                                            查看事项
                                        </strong>


                                    </span>
                                    <div class="controls member-controls">
                                        <a href="#" style="color: #1b69b6;">Default Screen</a>
                                    </div>
                                </li>


                            </ul>
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


</div>