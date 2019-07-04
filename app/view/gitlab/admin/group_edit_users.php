<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/group.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>"  type="text/javascript"></script>

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
                <?php include VIEW_PATH.'gitlab/admin/common_user_left_nav.php';?>
                <div class="row prepend-top-default" style="margin-left: 160px">


                        <div class="light prepend-top-default" style="padding: 10px">
                            <form class="users-project-form" id="form_add" action="<?=ROOT_URL?>admin/group/add_user" accept-charset="UTF-8" method="post">
                                <input type="hidden" name="group_id" id="user_group_id" value="<?=$group_id?>">
                                <div class="form-group">
                                    <input type="hidden" name="user_ids" id="user_ids" value=""
                                           class="ajax-users-select multiselect input-clamp "
                                           data-placeholder="通过用户名,名称,Email查询用户,归属到用户组."
                                           data-group-id="-<?=$group_id?>"
                                           data-null-user="false"
                                           data-any-user="false"
                                           data-email-user="true"
                                           data-first-user="false"
                                           data-current-user="false"
                                           data-author-id=""
                                           data-skip-users="null" />
                                    <div class="help-block append-bottom-10"></div>

                                </div>


                                <input type="button" id="btn-group-add-user" name="commit" value="添加" class="btn btn-create" />
                            <div class="append-bottom-default clearfix">
                                <h5 class="member existing-title"></h5></div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">用户组:
                                <strong id="group_name"></strong>
                                <span class="badge" id="users_count"></span>

                            </div>
                            <ul class="content-list" id="list_render_id">


                            </ul>
                        </div>

                </div>

            </div>
        </div>

    </div>
</div>

    </div>
</section>

<script type="text/html"  id="list_tpl">
    {{#users}}
        <li class="group_member member" id="group_member_{{uid}}">
              <span class="list-item-name">
                <img class="avatar s40" alt="" src="{{avatar}}" />
                <strong>
                  <a href="/root">{{display_name}}</a></strong>
                <span class="cgray">{{username}}</span>&nbsp;&middot;&nbsp;
                <a class="member-group-link" href="#">{{email}}</a>
                  <div class="hidden-xs cgray">   {{create_time_text}}</div>

              </span>

                <a class="group_users_for_delete btn btn-transparent  "  href="javascript:;" data-value="{{uid}}" style="padding: 6px 2px; float: right">
                    <i class="fa fa-trash"></i>
                    <span class="sr-only">Remove</span>
                </a>

        </li>
    {{/users}}

</script>

<script>


</script>

<script type="text/javascript">
    new UsersSelect();
    var $group = null;
    $(function() {

        var options = {
            group_users_list_render_id:"list_render_id",
            group_users_list_tpl_id:"list_tpl",
            group_users_form_id:"filter_form",
            group_users_add_url:"<?=ROOT_URL?>admin/group/add_user",
            group_users_delete_url:"<?=ROOT_URL?>admin/group/remove_user",
            fetch_users_url:"<?=ROOT_URL?>admin/group/fetch_users"

        }
        window.$group = new Group( options );
        window.$group.fetchUsers('<?=$group_id?>');

    });

</script>
</body>
</html>