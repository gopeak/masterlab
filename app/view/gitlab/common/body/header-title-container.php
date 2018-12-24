<div class="title-container">
    <?php
    if (isset($G_project) && !empty($G_project)) {
        if(isset($G_project['avatar_exist'])&& $G_project['avatar_exist']){?>
            <span class="project-logo"><img style="max-height: 24px;" src="<?= $G_project['avatar'] ?>" alt=''></span>
         <?php  } else{ ?>
        <div class="avatar-container s40" style="display: block;width: 24px;height: 24px;">
            <div class="avatar project-avatar s40 identicon"
                 style="background-color: #E0F2F1; color: #555;line-height: 22px;"><?= $G_project['first_word']?></div>
        </div>
    <?php }?>
    <span class="group-title project-name"><?= $G_project['name']?></span>
    <?php } ?>

    <h1 class="title">
        <?php
        $header_title = '首 页';
        $header_title_link = ROOT_URL;
        if (isset($project_id)) {
            $header_title = $org_name;
            $header_title_link = $project_root_url;
        }
        if (@$_GET['_target'][0] == 'projects') {
            $header_title = '项目列表';
            $header_title_link = ROOT_URL.'projects';
        }
        if (@$_GET['_target'][0] == 'org') {
            $header_title = '组 织';
            $header_title_link = ROOT_URL.'org';
        }
        if (@$_GET['_target'][0] == 'issue' && $_GET['_target'][1] == 'main') {
            $header_title = '所有事项';
            $header_title_link = ROOT_URL.'issue/main';
        }
        if (@$_GET['_target'][0] == 'admin') {
            $header_title = '管 理';
            $header_title_link = ROOT_URL.'admin/system';
        }
        ?>

            <span class="group-title">
                <a class="group-path" href="<?= $header_title_link ?>">
                    <?= $header_title ?>
                </a>
            </span>
        <?php
        if (isset($project_root_url) && isset($pro_key)) {
            echo '/<a class="project-item-select-holder" href="' . $project_root_url . '">' . $pro_key . '</a>';
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
