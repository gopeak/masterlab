<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/role.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL ?>dev/js/admin/jstree/dist/jstree.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/js/admin/jstree/dist/themes/default/style.min.css"/>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/i18n/defaults-zh_CN.min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <script src="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.css"/>

    <style>
        .text-muted {
            color: #777777;
        }
        label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .modal .modal-content .modal-body {
            padding: 15px 30px 0;
        }

        .role-table {
            padding: 0 20px;
        }
    </style>
</head>
<body class="" data-group="" data-page="projects:members:show" data-project="">
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
        <div class="container-fluid container-limited">

            <div class="content" id="content-body">

                <div class="row prepend-top-default">


                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            项目成员
                        </h4>
                        <p>
                            添加一个新成员到
                            <strong><?=$project['name']?></strong>
                        </p>
                    </div>


                    <div class="col-lg-9">
                        <div class="light prepend-top-default">
                            <form class="users-project-form" id="new_project_member" action="<?=ROOT_URL?>project/role/add_project_member_roles" accept-charset="UTF-8" method="post">

                                <div class="form-group">
                                    <div class="issuable-form-select-holder">
                                        <input type="hidden" name="user_id" />
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search" type="button"
                                                    data-first-user="sven"
                                                    data-null-user="true"
                                                    data-current-user="true"
                                                    data-project-id=""
                                                    data-selected="null"
                                                    data-field-name="user_id"
                                                    data-default-label="Assignee"
                                                    data-toggle="dropdown">
                                                <span class="dropdown-toggle-text is-default">选择项目成员</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                                <div class="dropdown-title">
                                                    <span>选择用户</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" />
                                                    <i class="fa fa-search dropdown-input-search"></i>
                                                    <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                </div>
                                                <div class="dropdown-content "></div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="assign-to-me-link " href="#">赋予给我</a>

                                </div>


                                <div class="form-group">

                                    <select class="selectpicker form-control" id="role_select" multiple name="role_id[]">
                                        <?php foreach ($roles as $role) { ?>
                                            <option value="<?=$role['id']?>"><?=$role['name']?></option>
                                        <?php } ?>
                                    </select>

                                    <div class="help-block append-bottom-10">
                                        <a class="vlink" href="<?=$project_root_url?>/settings_project_role">权限管理</a>
                                    </div>
                                </div>


                                <input type="submit" value="添加到项目" class="btn btn-create">
                            </form>

                            <div class="append-bottom-default clearfix">
                                <h5 class="member existing-title">
                                    项目成员
                                </h5>
                            </div>
                        </div>
                        <div class="panel panel-default">

                            <ul class="content-list">
                                <?php foreach ($project_users as $user) { ?>
                                <li class="group_member member" id="group_member_1">
                                    <span class="list-item-name">
                                        <img class="avatar s40" alt="" src="<?=$user['avatar']?>">
                                        <strong>
                                        <a href="<?=ROOT_URL?>user/profile/<?=$user['uid']?>"><?=$user['display_name']?></a>
                                        </strong>
                                        <span class="cgray">@<?=$user['username']?></span>
                                        <?php if ($current_uid == $user['uid']) { ?>
                                        <span class="label label-success prepend-left-5">It's you</span>
                                        <?php } ?>
                                        ·
                                        <span><?=$user['title']?></span>
                                        <div class="hidden-xs cgray">
                                            <?php if (!empty($user['create_time_text'])) { ?>
                                                <time><?=$user['create_time_text']?></time>

                                            <?php } ?>
                                        </div>
                                    </span>
                                    <div class="controls member-controls">
                                        <select class="selectpicker form-control select-item-for-user" multiple id="selectpicker_uid_<?=$user['uid']?>" data-select_id="selectpicker_uid_<?=$user['uid']?>" data-ids="<?=$user['have_roles_ids']?>">
                                            <?php foreach ($roles as $role) { ?>
                                                <option value="<?=$role['id']?>"><?=$role['name']?></option>
                                            <?php } ?>
                                        </select>

                                        <a class="btn btn-transparent btn-actionprepend-left-10" href='javascript:saveMemberRole(<?=$user['uid']?>, <?=$project_id?>);'>
                                            <span class="visible-xs-block">保存</span>
                                            <i class="fa fa-floppy-o hidden-xs"></i>
                                        </a>
                                        <a title="移出项目" class="btn btn-transparent btn-action remove-row"   href='javascript:delMember(<?=$user['uid']?>, <?=$project_id?>, "<?=$user['display_name']?>", "<?=$project['name']?>");'>
                                            <span class="sr-only">移出</span>
                                            <i class="fa fa-trash-o"></i>
                                        </a>

                                    </div>

                                </li>
                                <?php } ?>
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

<!-- -->

<script type="text/javascript">
    $("#role_select").selectpicker({title: "请选择角色", width: "30%", showTick: true, iconBase: "fa", tickIcon: "fa-check"});

    $(".select-item-for-user").selectpicker({ title: "请选择角色", showTick: true, iconBase: "fa", tickIcon: "fa-check"});

    $("select.select-item-for-user").each(function () {
        var $self = $(this);
        var ids = $self.data("ids") + "";
        var val = ids.split(",");
        var id = $self.data("select_id");

        $("#" + id).selectpicker("val", val);
    });

    var formOptions = {
        beforeSubmit: beforeSubmit,
        success: success,
        type:      "post",
        dataType:  "json",
        timeout: 3000
    };

    function beforeSubmit(formData, jqForm, options) {

        var roleSelected = $("#role_select").val();

        if(roleSelected == null) {
            notify_error('请选择项目角色');
            return false;
        }

        for (var i=0; i < formData.length; i++) {
            if (!formData[i].value) {
                if (formData[i].name == 'user_id' ) {
                    notify_error('请选择用户!');
                }
                return false;
            }
        }

        console.log(formData);

        return true;
    };

    function success(resp, textStatus, jqXHR, $form) {
        auth_check(resp);
        if (resp.ret == 200) {
            window.location.reload();
        } else {
            notify_error("请求数据错误:" + resp.msg);
        }
    };
    $('#new_project_member').submit(function() {
        $(this).ajaxSubmit(formOptions);
        return false;
    });

    function saveMemberRole(user_id, project_id) {
        var role_id = $("#selectpicker_uid_" + user_id).val();
        var method = 'POST';
        var url = '<?=ROOT_URL?>project/role/modify_project_user_has_roles';
        $.ajax({
            type: method,
            dataType: "json",
            data: {user_id:user_id, project_id:project_id, role_id:role_id},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret == 200 ){
                    //window.location.reload();
                    notify_success(resp.msg);
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    function delMember(user_id, project_id, displayname,projectname) {

        swal({
                title: '您确认移除 ' + projectname + ' 的成员 '+ displayname +' 吗?',
                text: "该用户将不能访问此项目",
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确 定",
                cancelButtonText: "取 消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    var method = 'POST';
                    var url = '<?=ROOT_URL?>project/role/delete_project_user';
                    $.ajax({
                        type: method,
                        dataType: "json",
                        data: {user_id:user_id, project_id:project_id},
                        url: url,
                        success: function (resp) {
                            auth_check(resp);
                            if( resp.ret == 200 ){
                                window.location.reload();
                            } else {
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }else{
                    swal.close();
                }
            }
        );



    }
</script>


</body>
</html>
