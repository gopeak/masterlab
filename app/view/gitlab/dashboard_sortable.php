<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/ply/ply.css" rel="stylesheet" type="text/css"/>
    <!--<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css"/>-->

   <style>


       .container {
           width: 90%;
           margin: auto;
           min-width: 1100px;
           max-width: 1300px;
           position: relative;
       }


       .container_title {
           color: #fff;
           padding: 3px 10px;
           display: inline-block;
           position: relative;
           background-color: #FF7373;
           z-index: 1000;
       }
       .sortable-ghost {
           opacity: .2;
       }

       .sortable-img {
           border: 0;
           vertical-align: middle;
           cursor: move;
           margin: 10px;
           border-radius: 100%;
       }

       .title_xl {
           padding: 3px 15px;
           font-size: 40px;
       }

       .tile {
           min-width: 245px;
           color: #FF7270;
           padding: 10px 30px;
           text-align: center;
           margin-top: 15px;
           margin-left: 5px;
           margin-right: 30px;
           background-color: #fff;
           display: inline-block;
           vertical-align: top;
       }

       .tile_40 {
           width: 40%;
       }

       .tile_60 {
           width: 60%;
       }

       .tile__name {
           cursor: move;
           padding-bottom: 10px;
           border-bottom: 1px solid #FF7373;
       }

       .tile__list {
           margin-top: 10px;
       }

       .tile__list:last-child {
           margin-right: 0;
           min-height: 80px;
       }



       .block {
           opacity: 1;
           position: absolute;
       }

       .block__list {
           padding: 20px 0;
           max-width: 360px;
           margin-top: -8px;
           margin-left: 5px;
           background-color: #fff;
       }

       .block__list-title {
           margin: -20px 0 0;
           padding: 10px;
           text-align: center;
           background: #5F9EDF;
       }

       .block__list li {
           cursor: move;
       }

       .block__list_words li {
           background-color: #fff;
           padding: 10px 40px;
       }

       .block__list_words .sortable-ghost {
           opacity: 0.4;
           background-color: #F4E2C9;
       }

       .block__list_words li:first-letter {
           text-transform: uppercase;
       }

       .block__list_tags {
           padding-left: 30px;
       }

       .block__list_tags:after {
           clear: both;
           content: '';
           display: block;
       }

       .block__list_tags li {
           color: #fff;
           float: left;
           margin: 8px 20px 10px 0;
           padding: 5px 10px;
           min-width: 10px;
           background-color: #5F9EDF;
           text-align: center;
       }

       .block__list_tags li:first-child:first-letter {
           text-transform: uppercase;
       }

   </style>
</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
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
                        <div id="multi" style="margin-left: 0px">
                            <!--<div>
                                <div data-force="5" class="layer container_title title_xl">Multi</div>
                            </div>-->
                            <div class="layer tile tile_40" data-force="25" draggable="false" style="">
                                <div class="tile__name">Group B</div>
                                <div class="tile__list">
                                    <img class="sortable-img" src="<?=ROOT_URL?>dev/lib/sortable/st/face-01.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-02.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-03.jpg">
                                    <img class="sortable-img"  src="<?=ROOT_URL?>dev/lib/sortable/st/face-04.jpg">
                                </div>
                            </div>

                            <div class="layer tile tile_40" data-force="20" style="" draggable="false">
                                <div class="tile__name">Group C</div>
                                <div class="tile__list">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-05.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-06.jpg">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-07.jpg">
                                </div>
                            </div><div class="layer tile tile_60" data-force="30" style="" draggable="false">
                                <div class="tile__name">Group A</div>
                                <div class="tile__list">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-01.jpg" draggable="false">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-03.jpg" draggable="false">
                                    <img src="<?=ROOT_URL?>dev/lib/sortable/st/face-04.jpg" draggable="false">
                                </div>
                            </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</section>

<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>

<script type="text/javascript">

    (function () {
        'use strict';

        var byId = function (id) { return document.getElementById(id); },

            loadScripts = function (desc, callback) {
                var deps = [], key, idx = 0;

                for (key in desc) {
                    deps.push(key);
                }

                (function _next() {
                    var pid,
                        name = deps[idx],
                        script = document.createElement('script');

                    script.type = 'text/javascript';
                    script.src = desc[deps[idx]];

                    pid = setInterval(function () {
                        if (window[name]) {
                            clearTimeout(pid);

                            deps[idx++] = window[name];

                            if (deps[idx]) {
                                _next();
                            } else {
                                callback.apply(null, deps);
                            }
                        }
                    }, 30);

                    document.getElementsByTagName('head')[0].appendChild(script);
                })()
            },

            console = window.console;

        if (!console.log) {
            console.log = function () {
                alert([].join.apply(arguments, ' '));
            };
        }

        // Multi groups
        Sortable.create(byId('multi'), {
            animation: 150,
            draggable: '.tile',
            handle: '.tile__name',
            onUpdate: function (evt){
                var item = evt.item; // the current dragged HTMLElement
                console.log(item)
            }
        });

        [].forEach.call(byId('multi').getElementsByClassName('tile__list'), function (el){
            Sortable.create(el, {
                animation: 150
            });
        });



    })();


</script>
</body>
</html>