<aside class="main-sidebar">
    <div class="main-logo">
        <a class="home" title="Masterlab-极致的项目管理工具!" id="logo" href="/dashboard">
            <svg class="logo" style="font-size: 32px">
                <use xlink:href="#logo-svg" />
            </svg>

            <h1>MasterLab</h1>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-item <? if($top_menu_active=='index') echo 'menu-open';?>">
            <a href="/dashboard">
                <i class="fa fa-dashboard"></i> <span>首页</span>
            </a>
        </li>
        <li class="menu-item <? if($top_menu_active=='org') echo 'menu-open';?>">
            <a href="/org">
                <i class="fa fa-files-o"></i>
                <span>组织</span>
            </a>
        </li>
        <li class="menu-item <? if($top_menu_active=='project') echo 'menu-open';?>">
            <a href="/projects">
                <i class="fa fa-th"></i> <span>项目</span>
            </a>
        </li>
        <!--<li class="menu-item <? if($top_menu_active=='issue') echo 'menu-open';?>">
            <a href="<?= ROOT_URL ?>issue/main">
                <i class="fa fa-th"></i> <span>所有事项</span>
            </a>
        </li>-->
        <?php
        if( $is_admin ){
        ?>
        <li class="menu-item <? if($top_menu_active=='system') echo 'menu-open';?>">
            <a href="javascript:;">
                <i class="fa fa-laptop"></i>
                <span>管理</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-down pull-right"></i>
                </span>
            </a>
            <ul class="sub-menu">
                <li><a href="/admin/system">管理</a></li>
            </ul>
        </li>
        <?php } ?>
        <li class="menu-item <? if($top_menu_active=='help') echo 'menu-open';?>">
            <a href="http://www.masterlab.vip/help.php" target="_blank">
                <i class="fa fa-edit"></i> <span>帮助</span>
            </a>
        </li>
    </ul>
</aside>

<script>
    let isMin = localStorage.minSidebar && localStorage.minSidebar === "true" ? true : false;
    if (isMin) {
        $(".has-sidebar").css("transition", "none").removeClass("max-sidebar").addClass("min-sidebar");
        setTimeout(function () {
            $(".has-sidebar").removeAttr("style");
        }, 300);
    }

    $(function () {
        $(".js-key-nav").attr("data-toggle", "");

        $(".max-sidebar .sidebar-menu .menu-item a").on("click", function () {
            $(this).siblings(".sub-menu").slideToggle("normal","swing");
        });

        $(".js-key-nav").on("click", function () {
            $(".sub-menu").attr("style", "");
            $(".has-sidebar").toggleClass("min-sidebar");
            $(".has-sidebar").toggleClass("max-sidebar");
            localStorage["minSidebar"] = !isMin;
        });
    });
</script>