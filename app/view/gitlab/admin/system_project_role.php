<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>

                <div class="prepend-top-default" style="margin-left: 160px">
                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">
                            <h4 class="prepend-top-0">
                                项目角色
                            </h4>

                        </div>
                        <div class="col-lg-10">

                            <form id="form_add" class="js-requires-input" action="<?=ROOT_URL?>admin/system/project_role_add" accept-charset="UTF-8" method="post">

                                <div class="form-group  col-md-2">
                                    <input style="margin-left: -15px;" type="text" name="params[name]" id="role_name" placeholder="角色名称" required="required" tabindex="1" class="form-control">

                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="params[description]" id="description" placeholder="描 述" required="required" tabindex="2"  class="form-control">

                                </div>
                                <div class="form-group col-md-2">
                                    <input type="button" name="commit" id="commit" value="添加" class="btn  " >

                                </div>


                            </form>

                        </div>


                    </div>

                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">

                           <!-- <p>
                                你可以使用项目角色来将用户或用户组关联到指定项目中。 下面表格显示JIRA中所有可用的项目角色。 这个页面可以添加,编辑以及删除项目角色。 你可以通过点击 '查看方案应用' 聊查看每个项目中项目角色的权限 方案以及通知方案。
                            </p>-->
                        </div>
                        <div class="col-lg-10">

                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <strong>项目角色</strong>
                                    <form class="form-inline member-search-form"
                                          action="#" accept-charset="UTF-8" method="get">
                                        <div class="form-group">

                                        </div>
                                    </form></div>
                                <ul class="content-list" id="render_id">


                                </ul>
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

<script type="text/html"  id="roles_tpl">
    {{#roles}}
    <li class="member project_member" id="project_role_{{id}}">

        <span class="list-item-name">
            <strong>
                <a href="#">{{name}}</a>
            </strong>
            <div class="hidden-xs cgray">
                {{description}}
            </div>
        </span>

        <div class="controls member-controls ">

            <a   class="btn btn-transparent" href="#">所属权限方案 </a>
            <a   class="btn btn-transparent"  style="margin-left: 10px" href="#">管理默认成员 </a>
            <a   class="btn btn-transparent"  style="margin-left: 10px" href="#">编辑 </a>

            {{#if_eq is_system 0}}
            <a data-confirm="Are you sure?" class="btn btn-transparent prepend-left-10" rel="nofollow" data-method="delete" href="javascript:projectRolesDelete({{id}});"><span class="sr-only">Remove</span>
                <i class="fa fa-trash"></i>
            </a>
            {{/if_eq}}
        </div>
    </li>
    {{/roles}}

</script>

<script type="text/javascript">

    $(function() {
        fetchProjectRoles('/admin/system/project_role_fetch','roles_tpl','render_id');
        $("#commit").click(function(){
            projectRolesAdd();

        });
    });

</script>

</body>
</html>


</div>