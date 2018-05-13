<?php
if(isset($project_id)&&!empty($project_id)){

?>
<div class="layout-nav">
    <div class="container-fluid">
        <div class="nav-control scrolling-tabs-container">
            <div class="fade-left">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="fade-right">
                <i class="fa fa-angle-right"></i>
            </div>
            <ul class="nav-links scrolling-tabs">

                <li class="<? if($nav_links_active=='home') echo 'active';?>">
                    <a title="Home" class="shortcuts-project" href="<?=$project_root_url?>"><i class="fa fa-home"></i> <span> Home </span> </a>
                </li>
                <li class="<? if($nav_links_active=='issues') echo 'active';?>">
                    <a title="Issues" class="shortcuts-issues" href="<?=$project_root_url?>/issues">
                        <i class="fa fa-bug"></i><span> 问题 <span class="badge count issue_counter">1</span> </span> </a>
                </li>
                <li class="<? if($nav_links_active=='backlog') echo 'active';?>">
                    <a title="Backlog" class="shortcuts-project" href="<?=$project_root_url?>/backlog"><i class="fa fa-modx"></i><span> Backlog </span> </a>
                </li>
                <li class="<? if($nav_links_active=='sprints') echo 'active';?>">
                    <a title="Sprints" class="shortcuts-tree" href="<?=$project_root_url?>/sprints"><i class="fa fa-columns"></i><span> Sprints </span> </a>
                </li>
                <li class="<? if($nav_links_active=='kanban') echo 'active';?>">
                     <a title="Releases" class="shortcuts-tree" href="<?=$project_root_url?>/kanban"><i class="fa fa-tags"></i><span> Kanban </span> </a>
                </li>
                <li class="<? if($nav_links_active=='report') echo 'active';?>">
                    <span> <a title="报表" class="shortcuts-tree" href="/project/main/cycle_analytics"><i class="fa fa-bar-chart"></i><span> 报表 </span> </a>
                </li>
                <li class="<? if($nav_links_active=='setting') echo 'active';?>">
                    <a title="Pipelines" class="shortcuts-pipelines" href="<?=$project_root_url?>/settings"><i class="fa fa-cogs"></i><span> 设置 </span> </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<?php
}
?>