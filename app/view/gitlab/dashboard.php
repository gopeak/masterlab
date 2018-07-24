<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/ply/ply.css" rel="stylesheet" type="text/css"/>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->

    <link href="<?=ROOT_URL?>dev/lib/sortable/st/app2.css" rel="stylesheet" type="text/css"/>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid"  >
                    <div class="container">
                        <div id="multi" style="margin-left: 30px">
                            <div class="layer tile2" data-force="30">
                                <div class="tile__name">Group A</div>
                                <div class="tile__list">
                                    <img class="sortable-img" src="<?=ROOT_URL?>dev/lib/sortable/st/face-01.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-02.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-03.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-04.jpg">
                                </div>
                            </div>

                        </div>
                        <div id="multi2" style="margin-left: 30px">
                            <div class="layer tile2" data-force="30">
                                <div class="tile__name">Group A</div>
                                <div class="tile__list">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-01.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-02.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-03.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-04.jpg">
                                </div>
                            </div>

                            <div class="layer tile2" data-force="25">
                                <div class="tile__name">Group B</div>
                                <div class="tile__list">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-05.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-06.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-07.jpg">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/st/app2.js"></script>



<script src="//yandex.st/highlightjs/7.5/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<script type="text/javascript">



</script>
</body>
</html>