<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/user.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
    <style>
        .open.dropdown .dropdown-menu.dropdown-menu-align-left.dropdown-menu-sort{
            left:0;
            right:unset;
        }
    </style>
</header>
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
        <div class=" ">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_user_left_nav.php';?>
                <div class="container-fluid"  style="margin-left: 160px">
                    <div class="top-area">
                        <ul class="nav-links user-state-filters" style="float:left">
                            <li class="active" data-value="">
                                <a id="state-opened"  title="全部用户" href="#" ><span> 全部用户 </span>
                                </a>
                            </li>
                            <li class="" data-value="<?=main\app\model\user\UserModel::STATUS_NORMAL?>">
                                <a id="state-opened" title="正常用户" href="#"><span> 正常 </span>
                                </a>
                            </li>
                            <li class="" data-value="<?=main\app\model\user\UserModel::STATUS_DISABLED?>">
                                <a id="state-opened" title="已经被禁用的用户" href="#"><span>禁用</span></a>
                            </li>
                        </ul>
                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 80px">
                            <form id="user_filter_form" action="<?=ROOT_URL?>admin/user/filter" accept-charset="UTF-8" method="get">

                                <input name="page" id="filter_page" type="hidden" value="1">
                                <input name="status" id="filter_status" type="hidden" value="">
                                <input name="group_id" id="filter_group" type="hidden" value="0">
                                <input name="order_by" id="filter_order_by" type="hidden" value="uid">
                                <input name="sort" id="filter_sort" type="hidden" value="desc">
                                <input type="search" name="username" id="filter_username" placeholder="全名或用户名或邮箱地址"
                                       class="form-control search-text-input input-short" spellcheck="false" value="" />
  
                                <div class="dropdown inline">
                                    <button class="dropdown-menu-toggle" data-toggle="dropdown" type="button">
                                        <span class="light" id="select_group_view" data-title-origin="所属用户组&nbsp;&nbsp;&nbsp;&nbsp;">
                                            所属用户组&nbsp;&nbsp;&nbsp;&nbsp;
                                        </span>
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-align-left dropdown-menu-selectable" id="select_group"><!--dropdown-menu-align-right-->


                                    </ul>
                                </div>

                                <div class="dropdown inline prepend-left-10">
                                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                                        <span class="light" id="order_view" data-title-origin="排序"> 排序</span>
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-align-left dropdown-menu-sort"><!--dropdown-menu-align-right-->
                                        <li class="order_by_li" data-order-by="create_time"  data-sort="desc" data-title="创建时间↓降序"><a href="#">创建时间↓降序 </a></li>
                                        <li class="order_by_li" data-order-by="create_time"  data-sort="asc" data-title="创建时间↑升序"><a href="#">创建时间↑升序 </a></li>
                                        <li class="order_by_li" data-order-by="username"  data-sort="desc" data-title="用户名↓降序"><a href="#">用户名↓降序 </a></li>
                                        <li class="order_by_li" data-order-by="username"  data-sort="asc" data-title="用户名↑升序"><a href="#">用户名↑升序 </a></li>

                                    </ul>
                                </div>

                                <a class="btn btn-gray  " id="btn-user_filter" href="#">
                                    <i class="fa fa-filter"></i> &nbsp;查询
                                </a>

                                 <a class="btn  href="#"  onclick="userFormReset()" >
                                    &nbsp;<i class="fa fa-undo"></i> &nbsp;
                                </a>


                            </form>
                        </div>
                        <div class="nav-controls" style="right: ">
                            <a class="btn has-tooltip" title="" href="#" data-original-title="邀请用户">
                                <i class="fa fa-rss"></i>
                            </a>
                            <div class="project-item-select-holder">

                                <a class="btn btn-new new-project-item-select-button" data-target="#modal-user_add" data-toggle="modal" href="#modal-user_add">
                                    <i class="fa fa-plus"></i>
                                    新 增

                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="content-list pipelines">

                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">显示名称</th>
                                        <th class="js-pipeline-commit pipeline-commit">账号</th>
                                        <th class="js-pipeline-stages pipeline-info">登录详情</th>
                                        <th class="js-pipeline-stages pipeline-info">用户组</th>
                                        <th class="js-pipeline-date pipeline-date">创建时间</th>
                                        <th class="js-pipeline-date pipeline-date">状态</th>
                                        <th >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="render_id">


                                    </tbody>
                                </table>
                            </div>
                            <div class="gl-pagination" id="ampagination-bootstrap">

                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="modal-user_add">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"
          action="<?=ROOT_URL?>admin/user/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="page-title">新增用户</h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="id_email">Email:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[email]" id="id_email"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_display_name">显示名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[display_name]" id="id_display_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_title">职 位:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[title]" id="id_title"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_username">账号:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[username]" id="id_username"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_password">密码:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="password" class="form-control" name="params[password]" id="id_password"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_notify_email"></label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="project_printing_merge_request_link_enabled">
                                        <input type="checkbox" value="1" checked="checked" name="params[notify_email]" id="id_notify_email" >
                                        <strong>发送邮件通知</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save" id="btn-user_add">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-user_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"
          action="<?=ROOT_URL?>admin/user/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑用户</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="uid" id="edit_uid" value="">
                    <div class="form-group">
                        <label class="control-label" for="edit_username">账号:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control"  id="edit_username"  value=""  disabled />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_email">Email:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[email]" id="edit_email"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_display_name">显示名称:<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[display_name]" id="edit_display_name"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_title">职 位:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[title]" id="edit_title"  value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="edit_disable">禁用:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="project_printing_merge_request_link_enabled">
                                        <input type="checkbox" value="1"   name="params[disable]" id="edit_disable" >
                                        <strong></strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save" id="btn-user_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-user_group">
    <form class="js-quick-submit js-upload-blob-form form-horizontal"
          action="<?=ROOT_URL?>admin/user/update_user_group"
          accept-charset="UTF-8"
          method="post">
        <input type="hidden" name="uid" id="group_for_uid" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑用户组</h3>
                </div>
                <div class="modal-body">


                            <div class="form-group">

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="id_display_name">勾选所属用户组:</label>
                                <div class="col-sm-10">

                                        <select id="for_group" name="params[groups][]" class="selectpicker" dropdownAlignRight="true"  data-width="90%" data-live-search="true"  multiple title="选择用户组&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"   >

                                        </select>

                                </div>
                            </div>

                        <div class="form-group">

                        </div>
                </div>

                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save" id="submit-all">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/html"  id="user_tpl">
    {{#users}}

        <tr class="commit">
            <td>
                {{#if_eq status '2'}}
                <a href="#" class="commit-id monospace">
                   <del> {{display_name}}</del>
                </a>
                {{else}}
                <a href="#" class="commit-id monospace">
                    {{display_name}}
                </a>
                {{/if_eq}}
            </td>
            <td>
                <span class="list-item-name">
                    <img class="avatar s40" alt="" src="{{avatar}}">
                    <strong>
                        {{username}}
                    </strong>
                    {{#if_eq myself '1'}}
                        <span class="label label-success prepend-left-5">It's you</span>
                    {{/if_eq}}

                    ·
                     <a href="mailto:{{email}}">{{email}}</a>
                </span>
            </td>
            <td>
                <p class="commit-title">
                    <span>计数: {{login_counter}}</span>
                </p>
                <span  class="monospace branch-name">最近一次登录:{{last_login_time_text}}</span>
            </td>
            <td>
                <ul>
                    {{#each groups }}
                    <li>
                        <a>
                            {{name}}
                        </a>
                    </li>
                    {{/each}}
                </ul>
            </td>
            <td>
                {{create_time_text}}
            </td>
            <td>
                 <span class="label has-tooltip" style="{{status_bg}}">{{status_text}}</span>
            </td>
            <td  >
                <div class="controls member-controls " >
                    <a class="user_for_group btn btn-transparent" href="#" data-uid="{{uid}}" style="padding: 6px 2px;">用户组 </a>
                    <a class="user_for_edit btn btn-transparent " href="#" data-uid="{{uid}}" style="padding: 6px 2px;">编辑 </a>
                    <a class="user_for_delete btn btn-transparent  "   href="javascript:userDelete({{uid}});" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                </div>

            </td>
        </tr>
    {{/users}}

</script>


<script type="text/html"  id="select_group_tpl">
    <li class="select_group_li"  data-group="" data-title="用户组">
        <a  href="javascript:;"  >全部</a>
    </li>
    {{#groups}}
    <li class="select_group_li"  data-group="{{id}}" data-title="{{name}}">
        <a  href="javascript:;"  >{{name}}</a>
    </li>
    {{/groups}}
</script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    $(function() {

        fetchUsers('/admin/user/filter','user_tpl','render_id');

        $("#btn-user_add").click(function(){
            userAdd();

        });

        $("#btn-user_filter").click(function(){
            fetchUsers('/admin/user/filter','user_tpl','render_id');

        });

        $(".user-state-filters li").click(function () {

            $(".user-state-filters li").each(function () {
                $(this).removeClass("active");
            });
            $(this).addClass("active");

            userFormReset();
            $('#filter_status').val( $(this).attr('data-value') );
            $("#btn-user_filter").click();

        });

    });

</script>
</body>
</html>