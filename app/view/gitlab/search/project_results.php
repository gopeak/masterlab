<div class="term">
    <div class="js-projects-list-holder">
        <ul class="projects-list">
            <?php
            foreach ($projects as $project) {

                $replace = '<span style="background:#cfc;">'.$keyword.'</span>';
                $project['name'] = str_replace($keyword,$replace, $project['name']);
                ?>
                <li class="project-row">

                    <?php
                    if ($project['avatar_exist']) {
                        ?>
                        <a href="#" class="avatar-image-container">
                            <img src="<?= $project['avatar'] ?>" class="avatar has-tooltip s40">
                        </a>
                        <?php
                    } else {
                        ?>
                        <div class="avatar-container s40" style="display: block">
                            <a class="project" href="<?= ROOT_URL ?><?= $project['path'] ?>/<?= $project['key'] ?>">
                                <div class="avatar project-avatar s40 identicon"
                                     style="background-color: #E0F2F1; color: #555"><?= $project['first_word'] ?></div>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="project-details">
                        <h3 class="prepend-top-0 append-bottom-0">
                            <a class="text-plain" href="/<?= $project['path'] ?>/<?= $project['key'] ?>">
                                <span class="project-full-name">
                                    <span class="namespace-name"><?= $project['path'] ?>/</span>
                                    <span class="project-name"><?= $project['name'] ?></span>
                                    <code><?= $project['type_name'] ?></code>
                                </span>
                            </a>

                        </h3>
                        <div class="description prepend-top-5">

                            <p dir="auto"><?= $project['description'] ?></p>
                        </div>
                    </div>
                    <div class="controls">

                        <div class="prepend-top-0">
                            创建于
                            <time class="js-timeago js-timeago-render-my" title="" datetime="<?= $project['create_time_origin'] ?>"
                                  data-toggle="tooltip" data-placement="top" data-container="body"
                                  data-original-title="<?= $project['create_time_origin'] ?>"  ><?= $project['create_time_text'] ?>
                            </time>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>

        </ul>

    </div>

</div>

<div class="gl-pagination prepend-top-default">
    <ul class="pagination justify-content-center">
        <li class="page-item prev">
            <a rel="prev" class="page-link" href="/search?scope=<?=$scope?>&amp;search=<?=$keyword?>">Prev</a>
        </li>
        <li class="page-item next">
            <a rel="next" class="page-link" href="/search?scope=<?=$scope?>&amp;search=<?=$keyword?>">Next</a>
        </li>
    </ul>
</div>


<div class="gl-pagination prepend-top-default">
    <ul class="pagination justify-content-center">
        <?php
        $pages = $project_pages;
        $pre_page = 1;
        if ($page > 1) {
            $pre_page = max(1, $page - 1);
            ?>
            <li class="page-item prev">
                <a rel="prev" class="page-link"
                   href="/search?page=<?= $pre_page ?>&scope=<?= $scope ?>&amp;keyword=<?= $keyword ?>">上一页</a>
            </li>
            <?php
        }
        $next_page = 1;
        if (  $page < $pages) {
            $next_page = min($pages, $page + 1);
            ?>
            <li class="page-item next">
                <a rel="next" class="page-link"
                   href="/search?page=<?= $next_page ?>&scope=<?= $scope ?>&amp;keyword=<?= $keyword ?>">下一页</a>
            </li>
            <?php

        }
        ?>

    </ul>
</div>