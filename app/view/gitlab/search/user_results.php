<div class="term">
    <div class="js-projects-list-holder">
        <ul class="projects-list">
            <?php
            foreach ($users as $user) {

                $replace = '<span style="background:#cfc;">'.$keyword.'</span>';
                $user['display_name'] = str_replace($keyword,$replace, $user['display_name']);
                $user['email'] = str_replace($keyword,$replace, $user['email']);
                $user['username'] = str_replace($keyword,$replace, $user['username']);
                ?>
                <li class="project-row">

                    <a href="#" class="avatar-image-container">
                        <img src="<?= $user['avatar'] ?>" class="avatar has-tooltip s40">
                    </a>

                    <div class="project-details">
                        <h3 class="prepend-top-0 append-bottom-0">
                            <a class="text-plain" href="/user/profile/<?= $user['uid'] ?>">
                                <span class="project-full-name">
                                    <span class="project-name"><?= $user['display_name'] ?> </span>
                                </span>
                            </a>
                        </h3>
                        <div class="description prepend-top-5">
                            <p dir="auto"><?= $user['username'] ?> <?= $user['email'] ?></p>
                        </div>
                    </div>
                    <div class="controls">

                        <div class="prepend-top-0">
                            创建于
                            <time class="js-timeago js-timeago-render-my" title=""
                                  datetime="<?= $user['create_time_origin'] ?>"
                                  data-toggle="tooltip" data-placement="top" data-container="body"
                                  data-original-title="<?= $user['create_time_origin'] ?>"
                                  data-tid="10"><?= $user['create_time_text'] ?>
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
        <?php
        $pages = $user_pages;
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