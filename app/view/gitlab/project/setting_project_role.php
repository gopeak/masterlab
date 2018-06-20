<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
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
                            Members
                        </h4>
                        <p>
                            Add a new member to
                            <strong>xphp</strong>
                        </p>
                    </div>
                    <div class="col-lg-9">
                        <div class="light prepend-top-default">
                            <form class="users-project-form" id="new_project_member" action="/ismond/xphp/project_members" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="v3cyIWMoSPUlmZl0aR87Bq72rXtsYvv58uAayAFJsQCMYt8ld5bOqsH23T8vsNchT+iK72oqKhS1DPGvx6Sg7w=="><div class="form-group">
                                    <div class="select2-container select2-container-multi ajax-users-select multiselect input-clamp" id="s2id_user_ids"><ul class="select2-choices">  <li class="select2-search-field">    <label for="s2id_autogen2" class="select2-offscreen"></label>    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input select2-default" id="s2id_autogen2" placeholder="" style="width: 1389px;">  </li></ul><div class="select2-drop select2-drop-multi select2-display-none ajax-users-dropdown">   <ul class="select2-results">   <li class="select2-no-results">No matches found</li></ul></div></div><input type="hidden" name="user_ids" id="user_ids" value="" class="ajax-users-select multiselect input-clamp" data-placeholder="Search for members to update or invite" data-null-user="false" data-any-user="false" data-email-user="true" data-first-user="false" data-current-user="false" data-push-code-to-protected-branches="null" data-author-id="" data-skip-users="null" tabindex="-1" style="display: none;">
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
                                <a class="btn btn-default" title="Import members from another project" href="/ismond/xphp/project_members/import">Import</a>
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
                                <strong>xphp</strong>
                                <span class="badge">16</span>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="form-group">
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
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_asc">Access level, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_desc">Access level, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=last_joined">Last joined
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_joined">Oldest joined
                                                    </a></li>
                                                <li>
                                                    <a class="is-active" href="/ismond/xphp/settings/members?sort=name_asc">Name, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=name_desc">Name, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=recent_sign_in">Recent sign in
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_sign_in">Oldest sign in
                                                    </a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </form></div>
                            <ul class="content-list">
                                <li class="group_member member" id="group_member_2">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/fe9832e90a7fbb5fff87bac06a4adff4?s=80&amp;d=identicon">
<strong>
<a href="/root">Administrator</a>
</strong>
<span class="cgray">@root</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-04-25T06:50:15Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Apr 25, 2017 2:50pm GMT+0800">6 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Owner</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_73">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
<strong>
<a href="/gitlab-runner">gitlab-runner</a>
</strong>
<span class="cgray">@gitlab-runner</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T08:06:25Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 4:06pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_73" action="/ismond/xphp/project_members/73" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_73" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_73" data-el-id="project_member_73" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/73"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_65">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/d59a94a888bff71ec46c6dc9299d2752?s=80&amp;d=identicon">
<strong>
<a href="/zhouzhicong">周智聪</a>
</strong>
<span class="cgray">@zhouzhicong</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_65" action="/ismond/xphp/project_members/65" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_65" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_65" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_65" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_65" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_65" data-el-id="project_member_65" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 周智聪 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/65"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_71">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/991fac7b338428d9df4c83da0ae18468?s=80&amp;d=identicon">
<strong>
<a href="/songweiping">宋卫平</a>
</strong>
<span class="cgray">@songweiping</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_71" action="/ismond/xphp/project_members/71" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_71" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_71" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_71" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_71" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_71" data-el-id="project_member_71" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 宋卫平 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/71"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_67">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/c88ecf5162619f8e6baf2f47ac7c9930?s=80&amp;d=identicon">
<strong>
<a href="/pengzhenglu">彭振陆</a>
</strong>
<span class="cgray">@pengzhenglu</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_67" action="/ismond/xphp/project_members/67" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_67" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_67" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_67" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_67" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_67" data-el-id="project_member_67" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 彭振陆 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/67"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_66">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/10/avatar.png">
<strong>
<a href="/lijian">李健</a>
</strong>
<span class="cgray">@lijian</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_66" action="/ismond/xphp/project_members/66" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_66" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_66" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_66" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_66" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_66" data-el-id="project_member_66" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 李健 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/66"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_72">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/e5baff75af01ef5b66fbaa1435f89330?s=80&amp;d=identicon">
<strong>
<a href="/yangwenjie">杨文杰</a>
</strong>
<span class="cgray">@yangwenjie</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T12:12:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 8:12pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_72" action="/ismond/xphp/project_members/72" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_72" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_72" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_72" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_72" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_72" data-el-id="project_member_72" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 杨文杰 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/72"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_68">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/53bbf5f63aa1fef75870d3ef2160f66a?s=80&amp;d=identicon">
<strong>
<a href="/oushuquan">欧树权</a>
</strong>
<span class="cgray">@oushuquan</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_68" action="/ismond/xphp/project_members/68" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_68" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_68" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_68" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_68" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_68" data-el-id="project_member_68" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 欧树权 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/68"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_64">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/3333f73983020f51aaa42c2887f9174d?s=80&amp;d=identicon">
<strong>
<a href="/shenzebiao">沈泽彪</a>
</strong>
<span class="cgray">@shenzebiao</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_64" action="/ismond/xphp/project_members/64" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_64" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_64" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_64" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_64" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_64" data-el-id="project_member_64" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 沈泽彪 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/64"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_69">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/90aad2acd7cdc5d19faaf4a6f6e4cac5?s=80&amp;d=identicon">
<strong>
<a href="/luoshengxin">罗胜欣</a>
</strong>
<span class="cgray">@luoshengxin</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_69" action="/ismond/xphp/project_members/69" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_69" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_69" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_69" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_69" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_69" data-el-id="project_member_69" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 罗胜欣 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/69"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="group_member member" id="group_member_24">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=80&amp;d=identicon">
<strong>
<a href="/huqiang">胡强</a>
</strong>
<span class="cgray">@huqiang</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:07:23Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:07am GMT+0800">4 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Master</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_86">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/36fd844cd09775f2d326556d02d5e3f6?s=80&amp;d=identicon">
<strong>
<a href="/hurong">胡熔</a>
</strong>
<span class="cgray">@hurong</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-08-07T07:30:46Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Aug 7, 2017 3:30pm GMT+0800">2 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_86" action="/ismond/xphp/project_members/86" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_86" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_86" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_86" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_86" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_86" data-el-id="project_member_86" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 胡熔 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/86"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="group_member member" id="group_member_23">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon">
<strong>
<a href="/guosheng">郭胜</a>
</strong>
<span class="cgray">@guosheng</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:07:11Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:07am GMT+0800">4 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Master</span>
                                    </div>
                                </li>
                                <li class="group_member member" id="group_member_46">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
<strong>
<a href="/sven">韦朝夺</a>
</strong>
<span class="cgray">@sven</span>
<span class="label label-success prepend-left-5">It's you</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-10T07:25:45Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 10, 2017 3:25pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <span class="member-access-text">Master</span>
                                    </div>
                                </li>
                                <li class="member project_member" id="project_member_74">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/1b4a748ddcb785cc327def5af752ea67?s=80&amp;d=identicon">
<strong>
<a href="/weiyulin">魏玉林</a>
</strong>
<span class="cgray">@weiyulin</span>
<label class="label label-danger">
<strong>Blocked</strong>
</label>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-08-01T10:29:27Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Aug 1, 2017 6:29pm GMT+0800">2 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_74" action="/ismond/xphp/project_members/74" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_74" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_74" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_74" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_74" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_74" data-el-id="project_member_74" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 魏玉林 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/74"><span class="visible-xs-block">
Delete
</span>
                                            <i class="fa fa-trash hidden-xs"></i>
                                        </a></div>
                                </li>
                                <li class="member project_member" id="project_member_70">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/56c8883b6c05ed54889df0aedfc9d47d?s=80&amp;d=identicon">
<strong>
<a href="/huangjie">黄杰</a>
</strong>
<span class="cgray">@huangjie</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">3 months ago</time>
</div>
</span>
                                    <div class="controls member-controls">
                                        <form class="form-horizontal js-edit-member-form" id="edit_project_member_70" action="/ismond/xphp/project_members/70" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
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
                                                                <a data-id="10" data-el-id="project_member_70" href="javascript:void(0)">Guest</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="20" data-el-id="project_member_70" href="javascript:void(0)">Reporter</a>
                                                            </li>
                                                            <li>
                                                                <a class="is-active" data-id="30" data-el-id="project_member_70" href="javascript:void(0)">Developer</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="40" data-el-id="project_member_70" href="javascript:void(0)">Master</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="prepend-left-5 clearable-input member-form-control">
                                                <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_70" data-el-id="project_member_70" type="text" name="project_member[expires_at]">
                                                <i class="clear-icon js-clear-input"></i>
                                            </div>
                                        </form><a data-confirm="Are you sure you want to remove 黄杰 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/70"><span class="visible-xs-block">
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
</body>
</html>


</div>