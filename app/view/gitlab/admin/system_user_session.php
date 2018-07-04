<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

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
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>

                <div class="row prepend-top-default" style="margin-left: 160px">


                    <div class="panel ">
                        <div class="panel-heading">

                            <strong>当前用户会话</strong> <span> 当前服务器时间 11:36:53 2017/11/10</span>
                            <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="✓">
                                <div class="form-group">
                                </div>
                            </form>
                        </div>
                        <div class="tree-content-holder">
                            <div class="table-holder">
                                <table class="table table_da39a3ee5e6b4b0d3255bfef95601890afd80709 tree-table" id="tree-slider">
                                    <thead>

                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">会话 Id</th>
                                        <th class="js-pipeline-info pipeline-info">用户</th>
                                        <th class="js-pipeline-info pipeline-info">类型</th>
                                        <th class="js-pipeline-commit pipeline-commit">IP 地址</th>
                                        <th class="js-pipeline-stages pipeline-info">请求</th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">上次访问</span></th>
                                        <th class="js-pipeline-date pipeline-date">会话创建于</th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>

                                            <a href="<?=ROOT_URL?>project/main/detail" class="commit-row-message">
                                                Merge branch 'test'
                                            </a>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>

                                        <td >4 days ago
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>

                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                Merge branch 'test'
                                            </a>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>

                                        <td >4 days ago
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>

                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                Merge branch 'test'
                                            </a>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>

                                        <td >4 days ago
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>

                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                Merge branch 'test'
                                            </a>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>

                                        <td >4 days ago
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>

                                            <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                Merge branch 'test'
                                            </a>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>



                </div>




            </div>
            
        </div>
    </div>
</div>
</body>
</html>


</div>