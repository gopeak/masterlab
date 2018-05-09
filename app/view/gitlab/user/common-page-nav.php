<div class="layout-nav">
    <div class="container-fluid">
        <div class="scrolling-tabs-container">
            <div class="fade-left">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="fade-right">
                <i class="fa fa-angle-right"></i>
            </div>
            <ul class="nav-links scrolling-tabs">
                <li class="home <? if($nav=='profile_edit') echo 'active';?>">
                    <a title="Profile Settings" href="/user/profile_edit">
                        <span>Profile Edit</span></a>
                </li>
                <li class="<? if($nav=='applications') echo 'active';?>">
                    <a title="Applications" href="/profile/applications">
                        <span>Applications</span></a>
                </li>
                <li class="<? if($nav=='chat_names') echo 'active';?>">
                    <a title="Chat" href="/profile/chat_names">
                        <span>Chat</span></a>
                </li>
                <li class="<? if($nav=='password') echo 'active';?>">
                    <a title="Password" href="/user/password">
                        <span>Password</span></a>
                </li>
                <li class="<? if($nav=='notifications') echo 'active';?>">
                    <a title="Notifications" href="/user/notifications">
                        <span>Notifications</span></a>
                </li>
                <li class="<? if($nav=='preferences') echo 'active';?>">
                    <a title="Preferences" href="/profile/preferences">
                        <span>Preferences</span></a>
                </li>
                <li class="<? if($nav=='audit_log') echo 'active';?>">
                    <a title="Audit Log" href="/profile/audit_log">
                        <span>Audit Log</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>