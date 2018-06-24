<div class="title-container">
    <h1 class="title">
        <?php
        $header_title = '首页';
        $header_title_link = '/';
        if (isset($project_id)) {
            $header_title = $org_name;
            $header_title_link = $project_root_url;
        }
        if ($_GET['_target'][0] == 'projects') {
            $header_title = 'Projects';
            $header_title_link = '/projects';
        }
        if ($_GET['_target'][0] == 'org') {
            $header_title = 'Organization';
            $header_title_link = '/org';
        }
        if ($_GET['_target'][0] == 'issue' && $_GET['_target'][1] == 'main') {
            $header_title = 'Issues';
            $header_title_link = '/issue/main';
        }
        if ($_GET['_target'][0] == 'admin') {
            $header_title = 'System';
            $header_title_link = '/admin/system';
        }
        ?>
            <span class="group-title">
                <a class="group-path" href="/<?= $header_title_link ?>"><?= $header_title ?></a>
            </span>
        <?php
        if (isset($project_root_url) && isset($pro_key)) {
            echo '/ <a class="project-item-select-holder" href="' . $project_root_url . '">' . $pro_key . '</a>';
        }
        ?>
        <?php
        if (isset($project_id)) {
            ?>
            <button name="button" type="button" class="dropdown-toggle-caret js-projects-dropdown-toggle"
                    aria-label="Toggle switch project dropdown" data-target=".js-dropdown-menu-projects"
                    data-toggle="dropdown" data-order-by="last_activity_at">
                <i class="fa fa-chevron-down"></i>
            </button>
            <?php
        }
        ?>
    </h1>
</div>