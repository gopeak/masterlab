<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="<? if($scrolling_tabs=='home') echo 'active';?>">
                <a title="Project home" class="shortcuts-project" href="/project/main/home"><span>Home</span></a>
            </li>
            <li class="<? if($scrolling_tabs=='activity') echo 'active';?>">
                <a title="Activity" class="shortcuts-project-activity" href="/project/main/activity"><span>Activity</span>
                </a>
            </li>
            <li class="<? if($scrolling_tabs=='cycle_analytics') echo 'active';?>">
                <a title="Cycle Analytics" class="shortcuts-project-cycle-analytics" href="/project/main/cycle_analytics"><span>Cycle Analytics</span>
                </a>
            </li>
        </ul>
    </div>
</div>