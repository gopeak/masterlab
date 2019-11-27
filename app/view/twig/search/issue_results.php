<div id="search-results" class="search-results">

    <?php
    foreach ($issues as $issue) {

        $replace = '<span style="background:#cfc;">'.$keyword.'</span>';
        $issue['summary'] = str_replace($keyword,$replace, $issue['summary']);
        ?>
        <div class="search-result-row">
            <h4>
                <a href="/issue/detail/index/<?= $issue['id'] ?>"><span
                            class="term str-truncated"><?= $issue['summary'] ?></span>
                </a>
                <div class="float-right">#<?= $issue['issue_num'] ?></div>
            </h4>
            <div class="description term">
                <p class="auto"><?= $issue['description'] ?></p>
            </div>
            <span class="light"><?= $issue['org_path'] ?>/<?= $issue['project']['key'] ?></span>
        </div>
        <?php
    }
    ?>

</div>

<div class="gl-pagination prepend-top-default">
    <ul class="pagination justify-content-center">
        <?php
        $pages = $issue_pages;
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