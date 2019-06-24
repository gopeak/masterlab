<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/role.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL ?>dev/js/admin/jstree/dist/jstree.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/js/admin/jstree/dist/themes/default/style.min.css"/>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/i18n/defaults-zh_CN.min.js"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

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
                            <form class="users-project-form" id="new_project_member" action="/diamond/ess_interna/project_members" accept-charset="UTF-8" method="post">

                                <div class="form-group">
                                    <div class="issuable-form-select-holder">
                                        <input type="hidden" name="member_id" />
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search" type="button"
                                                    data-first-user="sven"
                                                    data-null-user="true"
                                                    data-current-user="true"
                                                    data-project-id=""
                                                    data-selected="null"
                                                    data-field-name="member_id"
                                                    data-default-label="Assignee"
                                                    data-toggle="dropdown">
                                                <span class="dropdown-toggle-text is-default">选择项目成员</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                                <div class="dropdown-title">
                                                    <span>选择负责人</span>
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

                                    <select class="selectpicker form-control" id="role_select" multiple>
                                        <?php foreach ($roles as $role ) { ?>
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
                                <li class="group_member member" id="group_member_1">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/fe9832e90a7fbb5fff87bac06a4adff4?s=80&amp;d=identicon">
<strong>
<a href="/root">Administrator</a>
</strong>
<span class="cgray">@root</span>
·
<a class="member-group-link" href="/diamond">diamond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-04-25T03:00:57Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Apr 25, 2017 11:00am GMT+0800">2 years ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Owner</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_27">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/c88ecf5162619f8e6baf2f47ac7c9930?s=80&amp;d=identicon">
<strong>
<a href="/pengzhenglu">彭振陆</a>
</strong>
<span class="cgray">@pengzhenglu</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:40:54Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:40am GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_27" action="/diamond/ess_interna/project_members/27" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                            <div class="member-form-control dropdown append-right-5">
                                                <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                    <i class="fa fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                    <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                    <div class="dropdown-content">
                                                        <ul>
                                                            <li>
                                                                <a data-id="10" data-el-id="project_member_27" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_27" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_27" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_27" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_27" data-el-id="project_member_27" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 彭振陆 from the diamond / ess_interna project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/diamond/ess_interna/project_members/27"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="group_member member" id="group_member_22">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/10/avatar.png">
<strong>
<a href="/lijian">李健</a>
</strong>
<span class="cgray">@lijian</span>
<span class="label label-success prepend-left-5">It's you</span>
·
<a class="member-group-link" href="/diamond">diamond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:06:01Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:06am GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Master</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_26">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/3333f73983020f51aaa42c2887f9174d?s=80&amp;d=identicon">
<strong>
<a href="/shenzebiao">沈泽彪</a>
</strong>
<span class="cgray">@shenzebiao</span>
<label class="label label-danger">
<strong>Blocked</strong>
</label>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:40:54Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:40am GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_26" action="/diamond/ess_interna/project_members/26" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="10" name="project_member[access_level]" id="project_member_access_level">
                                            <div class="member-form-control dropdown append-right-5">
                                                <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Guest
</span>
                                                    <i class="fa fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                    <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                    <div class="dropdown-content">
                                                        <ul>
                                                            <li>
                                                                <a class="is-active" data-id="10" data-el-id="project_member_26" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_26" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="30" data-el-id="project_member_26" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_26" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_26" data-el-id="project_member_26" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 沈泽彪 from the diamond / ess_interna project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/diamond/ess_interna/project_members/26"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_106">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/05edac739df951014ab27b74166246d6?s=80&amp;d=identicon">
<strong>
<a href="/luosixin">罗斯新</a>
</strong>
<span class="cgray">@luosixin</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-10-16T09:16:26Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 16, 2017 5:16pm GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_106" action="/diamond/ess_interna/project_members/106" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="10" name="project_member[access_level]" id="project_member_access_level">
                                            <div class="member-form-control dropdown append-right-5">
                                                <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Guest
</span>
                                                    <i class="fa fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                    <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                    <div class="dropdown-content">
                                                        <ul>
                                                            <li>
                                                                <a class="is-active" data-id="10" data-el-id="project_member_106" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_106" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="30" data-el-id="project_member_106" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_106" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_106" data-el-id="project_member_106" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 罗斯新 from the diamond / ess_interna project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/diamond/ess_interna/project_members/106"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
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

<script type="text/javascript">
    $(function () {
        $("#role_select").selectpicker({ title: "请选择角色", width: "100%", showTick: true, iconBase: "fa", tickIcon: "fa-check"});

        var formOptions = {
            //target: '#output',          //把服务器返回的内容放入id为output的元素中
            beforeSubmit: beforeSubmit,  //提交前的回调函数
            success: success,      //提交后的回调函数
            //url: url,                 //默认是form的action， 如果申明，则会覆盖
            //type: type,               //默认是form的method（get or post），如果申明，则会覆盖
            //dataType: null,           //html(默认), xml, script, json...接受服务端返回的类型
            //clearForm: true,          //成功提交后，清除所有表单元素的值
            //resetForm: true,          //成功提交后，重置所有表单元素的值
            timeout: 3000               //限制请求的时间，当请求大于3秒后，跳出请求
        };

        function beforeSubmit(formData, jqForm, options){
            //formData: 数组对象，提交表单时，Form插件会以Ajax方式自动提交这些数据，格式如：[{name:user,value:val },{name:pwd,value:pwd}]
            //jqForm:   jQuery对象，封装了表单的元素
            //options:  options对象

            //var queryString = $.param(formData);   //name=1&address=2
            //var formElement = jqForm[0];              //将jqForm转换为DOM对象
            //var address = formElement.address.value;  //访问jqForm的DOM元素


            var roleSelected = $("#role_select").val();

            if(roleSelected == null) {
                notify_error('请选择项目角色');
                return false;
            }

            console.log(formData);

            return false;  //只要不返回false，表单都会提交,在这里可以对表单元素进行验证
        };

        function success(responseText, statusText){
            //dataType=xml
            //var name = $('name', responseXML).text();
            //var address = $('address', responseXML).text();
            //$("#xmlout").html(name + "  " + address);
            //dataType=json
            //$("#jsonout").html(data.name + "  " + data.address);
        };
        $('#new_project_member').submit(function() {
            $(this).ajaxSubmit(formOptions);
            return false; //阻止表单默认提交
        });


    });
</script>


</body>
</html>
