<link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/sidebar-left.css"/>

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
                <i class="fa fa-cubes"></i>
                <span>组织</span>
            </a>
        </li>
        <li class="menu-item <? if($top_menu_active=='project') echo 'menu-open';?>">
            <a href="/projects">
                <i class="fa fa-product-hunt"></i> <span>项目</span>
            </a>
        </li>
<!--        <li class="menu-item <?/* if($top_menu_active=='issue') echo 'menu-open';*/?>">
            <a>
                <i class="fa fa-pie-chart"></i>
                <span>事项</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-down pull-right"></i>
                </span>
            </a>
            <ul class="sub-menu" style="<?/* if($top_menu_active=='issue') echo 'display:block';*/?>">
                <li><a href="<?/*=ROOT_URL*/?>issue/main">事项</a></li>
            </ul>
        </li>-->
        <li class="menu-item <? if($top_menu_active=='system') echo 'menu-open';?>">
            <a href="/admin/system">
                <i class="fa fa-wrench"></i> <span>管 理</span>
            </a>
        </li>

        <li class="menu-item <? if($top_menu_active=='help') echo 'menu-open';?>">
            <a href="https://github.com/gopeak/masterlab/wiki">
                <i class="fa fa-question-circle"></i> <span>帮助</span>
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
        $(document).on("click", ".max-sidebar .sidebar-menu .menu-item a", function () {
            $(this).siblings(".sub-menu").slideToggle("normal","swing");
        });

        $("#sidebar-control").on("click", function () {
            $(".sub-menu").attr("style", "");
            $(".has-sidebar").toggleClass("min-sidebar");
            $(".has-sidebar").toggleClass("max-sidebar");
            localStorage["minSidebar"] = !isMin;
        });
    });
</script>