
<nav class="container-fluid project-stats nav-links sub-nav">
    <ul class="nav">
        <li class="<? if($sub_nav_active=='profile') echo 'active';?>">
            <a href="<?=$project_root_url?>/profile"><span>基本信息</span></a>
        </li>
        <li class="<? if($sub_nav_active=='issue_type') echo 'active';?>">
            <a href="<?=$project_root_url?>/issue_type">事项类型</a>
        </li>
        <li class="<? if($sub_nav_active=='version') echo 'active';?>">
            <a href="<?=$project_root_url?>/version">版 本</a>
        </li>
        <li class="<? if($sub_nav_active=='module') echo 'active';?>">
            <a href="<?=$project_root_url?>/module">模 块</a>
        </li>
        <!--li class="<? if($sub_nav_active=='worker_flow') echo 'active';?>">
            <a href="#h4_worker_flow">工作流</a>
        </li-->
    </ul>
</nav>