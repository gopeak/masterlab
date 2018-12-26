<link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/sidebar-left.css?v=<?=$_version?>"/>

<aside class="main-sidebar">
    <div class="main-logo">
        <a class="home" title="Masterlab-极致的项目管理工具!" id="logo" href="/dashboard">
        <!--    <svg class="logo" style="font-size: 32px">
                <use xlink:href="#logo-svg" />
            </svg> -->
            <span class="logo"><img src="<?= ROOT_URL ?>gitlab/images/logo.png" alt=""></span>

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
                <i class="fa fa-sitemap"></i>
                <span>组织</span>
            </a>
        </li>
        <li class="menu-item <? if($top_menu_active=='project') echo 'menu-open';?>">
            <a href="/projects">
                <i class="fa fa-product-hunt"></i> <span>项目</span>
            </a>
        </li>
        <?php
        if( $is_admin ){
        ?>
       <!--<li class="menu-item <? if($top_menu_active=='issue') echo 'menu-open';?>">
            <a  href="<?= ROOT_URL ?>issue/main">
                <i class="fa fa-tasks"></i>
                <span>所有事项</span>
            </a>
        </li>-->
        <?php } ?>
        <?php
        if( $is_admin ){
        ?>
        <li class="menu-item <? if($top_menu_active=='system') echo 'menu-open';?>">
            <a href="/admin/system">
                <i class="fa fa-wrench"></i> <span>管 理</span>
            </a>
        </li>
        <?php } ?>

        <li class="menu-item <? if($top_menu_active=='help') echo 'menu-open';?>">
            <a href="http://www.masterlab.vip/help.php" target="_blank">
                <i class="fa fa-question-circle"></i> <span>帮助</span>
            </a>
        </li>
    </ul>
	<div id="sidebar-control" class="toggle-sidebar-button" role="button" title="展开/折叠" type="button" >
		<i id="sidebar" class="fa fa-chevron-left"></i>
	</div>
</aside>

<script>
    let isMin = localStorage.minSidebar && localStorage.minSidebar === "true" ? true : false;
    if (isMin) {
        $(".has-sidebar").css("transition", "none").removeClass("max-sidebar").addClass("min-sidebar");
		$("#sidebar").toggleClass("fa-chevron-left").addClass("fa-chevron-right");
		$("#sidebar-control").css("width", "49px");
        setTimeout(function () {
            $(".has-sidebar").removeAttr("style");
        }, 300);
    }
	else{
		$("#sidebar-control").css("width", "210px");
	}

    $(function () {
        $(document).on("click", ".max-sidebar .sidebar-menu .menu-item a", function () {
            $(this).siblings(".sub-menu").slideToggle("normal","swing");
        });

        $("#sidebar-control").on("click", function () {
            $(".sub-menu").attr("style", "");
            $(".has-sidebar").toggleClass("min-sidebar");
            $(".has-sidebar").toggleClass("max-sidebar");
			isMin=!isMin;
            localStorage["minSidebar"] = isMin;
			$("#sidebar").toggleClass("fa-chevron-right").toggleClass("fa-chevron-left");
			if(!isMin)
			{
				$("#sidebar").addClass("fa-chevron-left");
				$("#sidebar-control").css("width", "210px");
			}
			else{
				$("#sidebar").addClass("fa-chevron-right");
				$("#sidebar-control").css("width", "49px");
			}
        });
    });
</script>