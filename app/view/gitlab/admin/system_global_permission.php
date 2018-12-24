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
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">全局权限</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="bs-callout bs-callout-warning shared-runners-description hidden">
                              p>你可以使用项目角色来将用户或用户组关联到指定项目中。 下面表格显示JIRA中所有可用的项目角色。 这个页面可以添加,编辑以及删除项目角色。 你可以通过点击 '查看方案应用' 来查看每个项目中项目角色的权限 方案以及通知方案。</p>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <form id="form_add" class="js-requires-input" action="<?=ROOT_URL?>admin/system/global_permission_group_add"
                                      accept-charset="UTF-8" method="post">

                                    <div class="form-group col-md-1">
                                        <a class="btn btn-transparent" style="cursor:default">
                                        <strong class=" append-right-5" >添加权限:</strong>
                                        </a>
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <select name="params[perm_id]" id="select_perm" class="form-control project-access-select">
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <select name="params[group_id]" id="select_group" class="form-control ">
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="button" name="commit" id="commit" value="添加" class="btn "  >
                                    </div>
                                </form>
                            </div>
                            <div class="content">
                                <form class="member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                    <input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">
                                    </div>
                                </form>
                            </div>
                            <hr />
                            <ul id="render" class="projects-list brd-bottom">
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

<script type="text/html"  id="render_tpl">
    {{#items}}
    <li class="member project_member" id="{{id}}">
        <span class="list-item-name">
            <strong>
                <a href="#">{{name}}</a>
            </strong>
          <div class="hidden-xs cgray">{{description}} </div>
        </span>
        <div class="controls member-controls ">
            <ul>
                {{#each groups }}
                <li>
                    <strong>
                            {{name}}
                    </strong>
                    <a href="#{{group_id}}">查看用户</a>
                    {{#if_eq is_system '0'}}
                        <a id="#" href="javascript:permissionGlobalDelete({{perm_group_id}})">删除</a>
                    {{/if_eq}}
                </li>
                {{/each}}
            </ul>
        </div>
    </li>
    {{/items}}
</script>

<script type="text/html"  id="select_perm_tpl">
    <option value="">请选择一个权限&nbsp;&nbsp;&nbsp;</option>
    {{#items}}
        <option value="{{id}}">{{name}}</option>
    {{/items}}
</script>

<script type="text/html"  id="select_group_tpl">
    <option value="">请选择授权用户组&nbsp;&nbsp;&nbsp;&nbsp;</option>
    {{#groups}}
        <option value="{{id}}">{{name}}</option>
    {{/groups}}
</script>

<script type="text/javascript">

    $(function() {
        fetchPermissionGlobal('/admin/system/global_permission_fetch','render_tpl','render');
        $("#commit").click(function(){
            permissionGlobalAdd();

        });
    });

</script>

</body>
</html>


</div>