<div class="dropdown global-dropdown">
    <button class="global-dropdown-toggle js-key-nav" data-toggle="dropdown" type="button" aria-expanded="true">
        <span class="sr-only">Toggle navigation</span> <i class="fa fa-bars"></i>
    </button>
    <div class="dropdown-menu-nav global-dropdown-menu">
        <ul>
            <li class="<? if($top_menu_active=='index') echo 'active';?> home"><a title="Index" class="dashboard-shortcuts-projects" href="/dashboard">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> H
                        </div>
                    </div>
                    <span> 首页 </span> </a>
            </li>
           <!-- <li class="<? if($top_menu_active=='time_line') echo 'active';?> "><a class="dashboard-shortcuts-milestones" title="TimeLine" href="<?=ROOT_URL?>project/main/activity">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> L
                        </div>
                    </div> <span> 动  态 </span> </a>
            </li>-->
            <li class="<? if($top_menu_active=='org') echo 'active';?> ">
                <a class="dashboard-shortcuts-activity" title="Organization" href="/org">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> O
                        </div>
                    </div> <span> 组  织 </span> </a>
            </li>
            <li class="<? if($top_menu_active=='project') echo 'active';?> ">
                <a class="dashboard-shortcuts-activity" title="Projects" href="/projects">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> P
                        </div>
                    </div> <span> 项  目 </span> </a>
            </li>
            <!--<li class="<? if($top_menu_active=='issue') echo 'active';?> "><a class="dashboard-shortcuts-groups" title="Issues" href="<?=ROOT_URL?>issue/main">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> S
                        </div>
                    </div> <span> 事  项 </span> </a>
            </li>-->
            <li class="<? if($top_menu_active=='system') echo 'active';?> "><a class="dashboard-shortcuts-snippets" title="System" href="/admin/system">
                    <div class="shortcut-mappings">
                        <div class="key">
                            <i aria-label="hidden" class="fa fa-arrow-up"></i> M
                        </div>
                    </div> <span> 管 理 </span> </a></li>
            <li class="divider"></li>
            <li class="<? if($top_menu_active=='help') echo 'active';?> ">
                <a title="Help" class="about-gitlab" target="_blank" href="http://www.masterlab.vip/help.php">帮助</a>
            </li>
        </ul>
    </div>
</div>