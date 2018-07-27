<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

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
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">


            <div class="flash-container flash-container-page">
            </div>


        </div>
        <div class="content" id="content-body">
            <div class="container-fluid container-limited">
                <div class="sub-header-block">
                    <div class="oneline">
                        项目的图表数据
                    </div>
                </div>
                <div class="ci-charts" id="charts">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>事项概览</h4>
                            <ul>
                                <li>
                                    总事项数:
                                    <strong> 94769 </strong>
                                </li>
                                <li>
                                    未解决:
                                    <strong> 40300 </strong>
                                </li>
                                <li>
                                    已解决:
                                    <strong> 47710 </strong>
                                </li>
                                <li>
                                   迭代次数:
                                    <strong> 2 </strong>
                                </li>
                            </ul>

                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="light">
                                    30 天内的事项报告（未解决与已解决）
                                </p>
                                <canvas height="360" id="build_timesChart" width="609" style="width: 609px; height: 360px;"></canvas>
                            </div>
                            <script id="pipelinesTimesChartsData" type="application/json">{"labels":["da36ccce","02ceea7b","56f26df5","63b2d78d","6551ae53","f46cf5d2","dec0aced","345587d7","8cbd8d43","c35ca659","079b490a","3703cc4b","8b3c7f57","3f715bb4","73f366e0","13ea4b38","fd343511","a6db285f","10d4f6b4","ec6a5d3f","e63cc957","06e09675","835bacc2","835bacc2","fda5e9bd","46a54123","a8c87544","d82844c0","bb7cd142","0db5c67d"],"values":[32,37,47,30,38,46,36,62,11,68,45,58,51,59,29,0,38,3,2,48,3,3,57,53,53,49,32,0,0,0]}</script>

                        </div>
                    </div>
                    <hr>
                    <h4>Pipelines charts</h4>
                    <p>
                        &nbsp;
                        <span class="legend-success">
<i aria-hidden="true" data-hidden="true" class="fa fa-circle"></i>
success
</span>
                        &nbsp;
                        <span class="legend-all">
<i aria-hidden="true" data-hidden="true" class="fa fa-circle"></i>
all
</span>
                    </p>
                    <div class="prepend-top-default">
                        <p class="light">
                            Pipelines for last week
                            (20 Jul - 27 Jul)
                        </p>
                        <canvas height="360" id="weekChart" width="1248" style="width: 1248px; height: 360px;"></canvas>
                    </div>
                    <div class="prepend-top-default">
                        <p class="light">
                            Pipelines for last month
                            (27 Jun - 27 Jul)
                        </p>
                        <canvas height="360" id="monthChart" width="1248" style="width: 1248px; height: 360px;"></canvas>
                    </div>
                    <div class="prepend-top-default">
                        <p class="light">
                            Pipelines for last year
                        </p>
                        <canvas class="padded" height="410" id="yearChart" width="1248" style="width: 1248px; height: 410px;"></canvas>
                    </div>
                    <script id="pipelinesChartsData" type="application/json">
                        [{"scope":"week","labels":["20 July","21 July","22 July","23 July","24 July","25 July","26 July","27 July"],"totalValues":[131,6,15,137,126,153,147,27],"successValues":[78,5,11,81,44,84,80,6]},{"scope":"month","labels":["27 June","28 June","29 June","30 June","01 July","02 July","03 July","04 July","05 July","06 July","07 July","08 July","09 July","10 July","11 July","12 July","13 July","14 July","15 July","16 July","17 July","18 July","19 July","20 July","21 July","22 July","23 July","24 July","25 July","26 July","27 July"],"totalValues":[141,147,143,13,20,134,153,199,170,215,34,13,185,139,141,129,97,12,11,113,136,152,126,131,6,15,137,126,153,147,27],"successValues":[88,90,86,11,8,77,81,81,39,87,13,8,103,81,80,88,47,8,5,54,59,92,67,78,5,11,81,44,84,80,6]},{"scope":"year","labels":["01 July 2017","01 August 2017","01 September 2017","01 October 2017","01 November 2017","01 December 2017","01 January 2018","01 February 2018","01 March 2018","01 April 2018","01 May 2018","01 June 2018","01 July 2018"],"totalValues":[3103,3651,3266,2737,2747,2392,3282,3138,3085,2935,3557,3813,2921],"successValues":[1068,1295,1310,1216,1129,852,1511,1448,1696,1329,1701,2299,1467]}]
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>


</div>