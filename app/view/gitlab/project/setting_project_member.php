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
<body class="" data-group="" data-page="projects:issues:index" data-project="">
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
                    <div class="col-lg-3 profile-settings-sidebar">
                        <h4 class="prepend-top-0">
                            项目成员
                        </h4>
                        <p>
                            添加一个新成员到 <?=$project['name']?>
                        </p>
                    </div>



                    <div class="col-lg-9">
                        <div class="light prepend-top-default">
                            <form class="users-project-form" id="new_project_member" action="/diamond/ess_interna/project_members" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="q2Jnz6fwWnklWT8Id9mFCgqj66oN1zOtxbnGWdE3qI158Fsf4oLExAXxxaVpVAuuxTz4OLy0zwU7sxp8rh1/vQ=="><div class="form-group">
                                    <div class="select2-container select2-container-multi ajax-users-select multiselect input-clamp" id="s2id_user_ids"><ul class="select2-choices">  <li class="select2-search-field">    <label for="s2id_autogen2" class="select2-offscreen"></label>    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input select2-default" id="s2id_autogen2" style="width: 922px;" placeholder="">  </li></ul><div class="select2-drop select2-drop-multi select2-display-none ajax-users-dropdown">   <ul class="select2-results">   <li class="select2-no-results">No matches found</li></ul></div></div><input type="hidden" name="user_ids" id="user_ids" value="" class="ajax-users-select multiselect input-clamp" data-placeholder="Search for members to update or invite" data-null-user="false" data-any-user="false" data-email-user="true" data-first-user="false" data-current-user="false" data-push-code-to-protected-branches="null" data-author-id="" data-skip-users="null" tabindex="-1" style="display: none;">
                                    <div class="help-block append-bottom-10">
                                        Search for members by name, username, or email, or invite new ones using their email address.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="access_level" id="access_level" class="form-control project-access-select"><option value="10">Guest</option>
                                        <option value="20">Reporter</option>
                                        <option value="30">Developer</option>
                                        <option value="40">Master</option></select>
                                    <div class="help-block append-bottom-10">
                                        <a class="vlink" href="/help/user/permissions">Read more</a>
                                        about role permissions
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="clearable-input">
                                        <input type="text" name="expires_at" id="expires_at" class="form-control js-access-expiration-date" placeholder="Expiration date">
                                        <i class="clear-icon js-clear-input"></i>
                                    </div>
                                    <div class="help-block append-bottom-10">
                                        On this date, the member(s) will automatically lose access to this project.
                                    </div>
                                </div>
                                <input type="submit" name="commit" value="Add to project" class="btn btn-create disabled" disabled="disabled">
                                <a class="btn btn-default" title="Import members from another project" href="/diamond/ess_interna/project_members/import">Import</a>
                            </form>

                            <div class="append-bottom-default clearfix">
                                <h5 class="member existing-title">
                                    Existing members and groups
                                </h5>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Members with access to
                                <strong>ess_interna</strong>
                                <span class="badge">7</span>
                                <form class="form-inline member-search-form" action="/diamond/ess_interna/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="form-group">
                                        <input type="search" name="search" id="search" placeholder="Find existing members by name" class="form-control" spellcheck="false" value="">
                                        <button aria-label="Submit search" class="member-search-btn" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="dropdown inline member-sort-dropdown">
                                            <button class="dropdown-menu-toggle " type="button" data-toggle="dropdown"><span class="dropdown-toggle-text ">Name, ascending</span><i class="fa fa-chevron-down"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-selectable">
                                                <li class="dropdown-header">
                                                    Sort by
                                                </li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=access_level_asc">Access level, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=access_level_desc">Access level, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=last_joined">Last joined
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=oldest_joined">Oldest joined
                                                    </a></li>
                                                <li>
                                                    <a class="is-active" href="/diamond/ess_interna/settings/members?sort=name_asc">Name, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=name_desc">Name, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=recent_sign_in">Recent sign in
                                                    </a></li>
                                                <li>
                                                    <a href="/diamond/ess_interna/settings/members?sort=oldest_sign_in">Oldest sign in
                                                    </a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </form></div>
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
                                <li class="group_member member" id="group_member_25">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=80&amp;d=identicon">
<strong>
<a href="/huqiang">胡强</a>
</strong>
<span class="cgray">@huqiang</span>
·
<a class="member-group-link" href="/diamond">diamond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:25:14Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:25am GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Master</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_28">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/56c8883b6c05ed54889df0aedfc9d47d?s=80&amp;d=identicon">
<strong>
<a href="/huangjie">黄杰</a>
</strong>
<span class="cgray">@huangjie</span>
<label class="label label-danger">
<strong>Blocked</strong>
</label>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:40:54Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:40am GMT+0800">a year ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_28" action="/diamond/ess_interna/project_members/28" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="10" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a class="is-active" data-id="10" data-el-id="project_member_28" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_28" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="30" data-el-id="project_member_28" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_28" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_28" data-el-id="project_member_28" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 黄杰 from the diamond / ess_interna project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/diamond/ess_interna/project_members/28"><span class="visible-xs-block">
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



</script>


</body>
</html>
