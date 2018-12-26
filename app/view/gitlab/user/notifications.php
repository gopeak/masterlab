<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/js/user/profile.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="profiles:show" data-project="">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>


<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">
                <div>
                    <input type="hidden" name="notification_type" id="notification_type" value="global">
                    <div class="row">
                        <div class="col-lg-3 profile-settings-sidebar">
                            <h4>Notifications</h4>
                            <p>You can specify notification level per group or per project.</p>
                            <p>By default, all projects and groups will use the global notifications setting.</p>
                        </div>
                        <div class="col-lg-9">
                            <h5>Global notification settings</h5>
                            <form class="update-notifications prepend-top-default" id="edit_user_15" action="/profile/notifications" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="✓">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="authenticity_token" value="Zs4uJqJ6mC4/2wUkUF/bF2cH+FKHdvnac2XV93hIVoT4qqtDunJMCGC5V6Wyv9K+v1VputJEymPsmTQdDKBALg==">
                                <div class="form-group">
                                    <label class="label-light" for="user_notification_email">Notification email</label>
                                    <div class="select2-container select2" id="s2id_user_notification_email" style="width: 152px;">
                                        <a href="javascript:void(0)" class="select2-choice" tabindex="-1">
                                            <span class="select2-chosen" id="select2-chosen-1">121642038@qq.com</span>
                                            <abbr class="select2-search-choice-close"></abbr>
                                            <span class="select2-arrow" role="presentation">
                                    <b role="presentation"></b>
                                </span>
                                        </a>
                                        <label for="s2id_autogen1" class="select2-offscreen">Notification email</label>
                                        <input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1">
                                        <div class="select2-drop select2-display-none select2-with-searchbox">
                                            <div class="select2-search">
                                                <label for="s2id_autogen1_search" class="select2-offscreen">Notification email</label>
                                                <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-1" id="s2id_autogen1_search" placeholder=""></div>
                                            <ul class="select2-results" role="listbox" id="select2-results-1"></ul>
                                        </div>
                                    </div>
                                    <select class="select2" name="user[notification_email]" id="user_notification_email" tabindex="-1" title="Notification email" style="display: none;">
                                        <option selected="selected" value="121642038@qq.com">121642038@qq.com</option></select>
                                </div>
                            </form>
                            <label class="label-light" for="global_notification_level">Global notification level</label>
                            <br>
                            <div class="clearfix"></div>
                            <div class="form-group pull-left global-notification-setting">
                                <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
                                    <form class="inline notification-form" id="edit_notification_setting_58" action="/notification_settings/58" accept-charset="UTF-8" data-remote="true" method="post">
                                        <input name="utf8" type="hidden" value="✓">
                                        <input type="hidden" name="_method" value="patch">
                                        <input class="notification_setting_level" type="hidden" value="participating" name="notification_setting[level]" id="notification_setting_level">
                                        <div class="js-notification-toggle-btns">
                                            <div class="">
                                                <button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15--" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                                    <i class="fa fa-bell js-notification-loading"></i>Participate
                                                    <i class="fa fa-caret-down"></i></button>
                                                <ul class="dropdown-15-- dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                                    <li role="menuitem">
                                                        <a class="update-notification " data-notification-level="watch" data-notification-title="Watch" href="#">
                                                            <strong class="dropdown-menu-inner-title">Watch</strong>
                                                            <span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a>
                                                    </li>
                                                    <li role="menuitem">
                                                        <a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#">
                                                            <strong class="dropdown-menu-inner-title">On mention</strong>
                                                            <span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a>
                                                    </li>
                                                    <li role="menuitem">
                                                        <a class="update-notification is-active" data-notification-level="participating" data-notification-title="Participate" href="#">
                                                            <strong class="dropdown-menu-inner-title">Participate</strong>
                                                            <span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a>
                                                    </li>
                                                    <li role="menuitem">
                                                        <a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#">
                                                            <strong class="dropdown-menu-inner-title">Disabled</strong>
                                                            <span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15--" data-toggle="modal" href="#" role="button">
                                                            <strong class="dropdown-menu-inner-title">Custom</strong>
                                                            <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <form class="edit_user" id="edit_user_15" action="/profile/notifications" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="✓">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="authenticity_token" value="Zs4uJqJ6mC4/2wUkUF/bF2cH+FKHdvnac2XV93hIVoT4qqtDunJMCGC5V6Wyv9K+v1VputJEymPsmTQdDKBALg==">
                                <label for="user_notified_of_own_activity">
                                    <input name="user[notified_of_own_activity]" type="hidden" value="0">
                                    <input type="checkbox" value="1" name="user[notified_of_own_activity]" id="user_notified_of_own_activity">
                                    <span>Receive notifications about your own activity</span></label>
                            </form>
                            <hr>
                            <h5>Groups (1)</h5>
                            <div>
                                <ul class="bordered-list">
                                    <li class="notification-list-item">
                            <span class="notification fa fa-holder append-right-5">
                                <i class="fa fa-eye fa-fw"></i>
                            </span>
                                        <span class="str-truncated">
                                <a href="/ismond">ismond</a></span>
                                        <div class="pull-right">
                                            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
                                                <form class="inline notification-form" id="edit_notification_setting_50" action="/notification_settings/50" accept-charset="UTF-8" data-remote="true" method="post">
                                                    <input name="utf8" type="hidden" value="✓">
                                                    <input type="hidden" name="_method" value="patch">
                                                    <input type="hidden" name="namespace_id" id="namespace_id" value="9">
                                                    <input class="notification_setting_level" type="hidden" value="watch" name="notification_setting[level]" id="notification_setting_level">
                                                    <div class="js-notification-toggle-btns">
                                                        <div class="">
                                                            <button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15-9-Namespace" data-toggle="dropdown" id="notifications-button" type="button">
                                                                <i class="fa fa-bell js-notification-loading"></i>Watch
                                                                <i class="fa fa-caret-down"></i></button>
                                                            <ul class="dropdown-15-9-Namespace dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="global" data-notification-title="Global" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Global</strong>
                                                                        <span class="dropdown-menu-inner-content">Use your global notification setting</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification is-active" data-notification-level="watch" data-notification-title="Watch" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Watch</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#">
                                                                        <strong class="dropdown-menu-inner-title">On mention</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Participate</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Disabled</strong>
                                                                        <span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-9-Namespace" data-toggle="modal" href="#" role="button">
                                                                        <strong class="dropdown-menu-inner-title">Custom</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <h5>Projects (3)</h5>
                            <p class="account-well">To specify the notification level per project of a group you belong to, you need to visit project page and change notification level there.</p>
                            <div class="append-bottom-default">
                                <ul class="bordered-list">
                                    <li class="notification-list-item">
                            <span class="notification fa fa-holder append-right-5">
                                <i class="fa fa-volume-up fa-fw"></i>
                            </span>
                                        <span class="str-truncated">
                                <a title="b2badmin" href="/ismond/b2badmin">
                                    <span class="namespace-name">ismond /</span>
                                    <span class="project-name">b2badmin</span></a>
                            </span>
                                        <div class="pull-right">
                                            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
                                                <form class="inline notification-form" id="edit_notification_setting_15" action="/notification_settings/15" accept-charset="UTF-8" data-remote="true" method="post">
                                                    <input name="utf8" type="hidden" value="✓">
                                                    <input type="hidden" name="_method" value="patch">
                                                    <input type="hidden" name="project_id" id="project_id" value="6">
                                                    <input class="notification_setting_level" type="hidden" value="global" name="notification_setting[level]" id="notification_setting_level">
                                                    <div class="js-notification-toggle-btns">
                                                        <div class="">
                                                            <button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15-6-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                                                <i class="fa fa-bell js-notification-loading"></i>Global
                                                                <i class="fa fa-caret-down"></i></button>
                                                            <ul class="dropdown-15-6-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                                                <li role="menuitem">
                                                                    <a class="update-notification is-active" data-notification-level="global" data-notification-title="Global" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Global</strong>
                                                                        <span class="dropdown-menu-inner-content">Use your global notification setting</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="watch" data-notification-title="Watch" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Watch</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#">
                                                                        <strong class="dropdown-menu-inner-title">On mention</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Participate</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Disabled</strong>
                                                                        <span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-6-Project" data-toggle="modal" href="#" role="button">
                                                                        <strong class="dropdown-menu-inner-title">Custom</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="notification-list-item">
                            <span class="notification fa fa-holder append-right-5">
                                <i class="fa fa-eye fa-fw"></i>
                            </span>
                                        <span class="str-truncated">
                                <a title="xphp" href="/ismond/xphp">
                                    <span class="namespace-name">ismond /</span>
                                    <span class="project-name">xphp</span></a>
                            </span>
                                        <div class="pull-right">
                                            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
                                                <form class="inline notification-form" id="edit_notification_setting_133" action="/notification_settings/133" accept-charset="UTF-8" data-remote="true" method="post">
                                                    <input name="utf8" type="hidden" value="✓">
                                                    <input type="hidden" name="_method" value="patch">
                                                    <input type="hidden" name="project_id" id="project_id" value="31">
                                                    <input class="notification_setting_level" type="hidden" value="watch" name="notification_setting[level]" id="notification_setting_level">
                                                    <div class="js-notification-toggle-btns">
                                                        <div class="">
                                                            <button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button">
                                                                <i class="fa fa-bell js-notification-loading"></i>Watch
                                                                <i class="fa fa-caret-down"></i></button>
                                                            <ul class="dropdown-15-31-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="global" data-notification-title="Global" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Global</strong>
                                                                        <span class="dropdown-menu-inner-content">Use your global notification setting</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification is-active" data-notification-level="watch" data-notification-title="Watch" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Watch</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#">
                                                                        <strong class="dropdown-menu-inner-title">On mention</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Participate</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Disabled</strong>
                                                                        <span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-31-Project" data-toggle="modal" href="#" role="button">
                                                                        <strong class="dropdown-menu-inner-title">Custom</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="notification-list-item">
                            <span class="notification fa fa-holder append-right-5">
                                <i class="fa fa-volume-up fa-fw"></i>
                            </span>
                                        <span class="str-truncated">
                                <a title="server" href="/we5/server">
                                    <span class="namespace-name">we5 /</span>
                                    <span class="project-name">server</span></a>
                            </span>
                                        <div class="pull-right">
                                            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">
                                                <form class="inline notification-form" id="edit_notification_setting_175" action="/notification_settings/175" accept-charset="UTF-8" data-remote="true" method="post">
                                                    <input name="utf8" type="hidden" value="✓">
                                                    <input type="hidden" name="_method" value="patch">
                                                    <input type="hidden" name="project_id" id="project_id" value="49">
                                                    <input class="notification_setting_level" type="hidden" value="global" name="notification_setting[level]" id="notification_setting_level">
                                                    <div class="js-notification-toggle-btns">
                                                        <div class="">
                                                            <button class="dropdown-new btn btn-default notifications-btn" data-target="dropdown-15-49-Project" data-toggle="dropdown" id="notifications-button" type="button">
                                                                <i class="fa fa-bell js-notification-loading"></i>Global
                                                                <i class="fa fa-caret-down"></i></button>
                                                            <ul class="dropdown-15-49-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                                                <li role="menuitem">
                                                                    <a class="update-notification is-active" data-notification-level="global" data-notification-title="Global" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Global</strong>
                                                                        <span class="dropdown-menu-inner-content">Use your global notification setting</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="watch" data-notification-title="Watch" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Watch</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#">
                                                                        <strong class="dropdown-menu-inner-title">On mention</strong>
                                                                        <span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Participate</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a>
                                                                </li>
                                                                <li role="menuitem">
                                                                    <a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#">
                                                                        <strong class="dropdown-menu-inner-title">Disabled</strong>
                                                                        <span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-49-Project" data-toggle="modal" href="#" role="button">
                                                                        <strong class="dropdown-menu-inner-title">Custom</strong>
                                                                        <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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

    </div>

<script>

    laydate.render({
        elem: '#user_birthday'
    });
</script>

<script type="text/javascript">

    var $profile = null;
    $(function() {
        laydate.render({
            elem: '#user_birthday'
        });
        var options = {
            uid:window.current_uid,
            get_url:"<?=ROOT_URL?>user/get",
            update_url:"<?=ROOT_URL?>user/setProfile",
        }

        $('#commit').bind('click',function(){
            window.$profile.update();
        })
        window.$profile = new Profile( options );
        window.$profile.fetch( window.current_uid );
    });



</script>


</body>
</html>

