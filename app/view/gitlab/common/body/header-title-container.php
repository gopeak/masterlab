<div class="title-container">
    <h1 class="title">
            <span class="group-title">
                <?php

                if (!isset($org_name)) {
                    $org_name = 'Issues';
                    $org_name_link = '/issue/main';
                } else {
                    $org_name_link = $org_name;
                }
                ?>
                <a class="group-path" href="/<?=$org_name_link?>"><?=$org_name?></a>

            </span>
            <?php if(isset($project_root_url) && isset($pro_key) ){
            ?>
                / <a class="project-item-select-holder" href="<?=$project_root_url?>"><?=$pro_key?></a>
            <?php
            }
            ?>
        <button name="button" type="button" class="dropdown-toggle-caret js-projects-dropdown-toggle"
                aria-label="Toggle switch project dropdown" data-target=".js-dropdown-menu-projects"
                data-toggle="dropdown" data-order-by="last_activity_at">
            <i class="fa fa-chevron-down"></i>
        </button>
    </h1>
</div>