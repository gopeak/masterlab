<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>dev/lib/moment.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>

    <script src="<?=ROOT_URL?>dev/lib/mousetrap/mousetrap.min.js"></script>
    <link href="/<?=ROOT_URL?>gitlab/assets/application.css">
    <style>
        .classification{
            position: relative;
            min-height: 400px;
            height: 100%;
        }
        .classification-main{
            margin-left: 15%;
        }
        .classification-side{
            width: 15%;
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            border-right: 1px solid #ddd;
            overflow-y: scroll;
        }
        .classification-title{
            font-size: 12px;
            font-weight: bolder;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .classification-item{
            padding: 12px 8px;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
        }
        .classification-item.open{
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
        }
        .classification-item.open .classification-item-inner{
            height: auto;
        }
        .classification-item-inner{
            height: 30px;
            overflow: hidden;
        }
        .classification-item:hover{
            background-color: #f5f5f5;
        }
        .classification-item-header{
            cursor: pointer;
        }
        .classification-item-header h3{
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        .classification-item-line{
            background: #e5e5e5;
            margin-top: 5px;
            height: 5px;
        }
        .classification-item-expanded{

        }
        .classification-item-expanded ul{
            padding: 0;
            margin: 0;
        }
        .classification-item-expanded li{
            list-style: none;
            color: #666;
            font-size: inherit;
        }
        .classification-item-group{
            display: table;
            table-layout: fixed;
            width: 100%;
            margin-top: 10px;
        }
        .classification-item-group-cell{
            display: table-cell;
        }
        .classification-backlog-header{
            padding: 8px;
            border-bottom: 1px solid #ddd;
            display: flex;
            font-size: 12px;
        }
        .classification-backlog-name{
            font-weight: bolder;
        }
        .classification-backlog-issue-count{
            padding: 0 0 0 12px;
            color: #999;
        }
        .classification-backlog-inner{
            padding: 8px;
        }
        .classification-backlog-item{
            font-size: 14px;
            border: 1px solid #ddd;
            padding: 6px;
            border-left: 4px solid #ddd;
            cursor: move;
            margin: 0 0 -1px 0;
            background-color: #fff;
        }
        .classification-backlog-item:hover{
            border-left-color: #009900;
            background-color: #f5f5f5;
        }
        .classification-out-line{
            border: 2px dashed #999 !important;
        }
        .classification-none{
            display: none;
        }
        .classification-inner .classification-backlog-item{
            display: none;
        }
        .chosen-item{
            border: 2px solid #ec0044;
        }
        /*.classification-item .sortable-chosen{
            display: none;
        }*/
    </style>

</head>

<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">

<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>
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
        <div class=" ">
            <div class="content" id="content-body">
                <div class="container-fluid">
                    <div class="nav-block activity-filter-block">
                        <div class="controls">
                            <a title="Subscribe" class="btn rss-btn has-tooltip" href="/ismond/b2b.atom?private_token=vyxEf937XeWRN9gDqyXk"><i class="fa fa-rss"></i>
                            </a>
                        </div>

                    </div>
                    <div class="issues-holder">
                        <div class="table-holder">

                            <div class="classification">
                                <div class="classification-side">
                                    <div class="classification-title">VERSIONS</div>
                                    <div class="classification-inner" id="classification-inner">
                                        <div class="classification-item" data-id="1">
                                            <div class="classification-item-inner">
                                                <div class="classification-item-header">
                                                    <h3>1.0.1</h3>
                                                    <div class="classification-item-line"></div>
                                                </div>
                                                <div class="classification-item-expanded">
                                                    <ul>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Start Date</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Release Date</div>
                                                            <div>none</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">问题</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Completed</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Unestimated</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="classification-item" data-id="2">
                                            <div class="classification-item-inner">
                                                <div class="classification-item-header">
                                                    <h3>1.0.2</h3>
                                                    <div class="classification-item-line"></div>
                                                </div>
                                                <div class="classification-item-expanded">
                                                    <ul>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Start Date</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Release Date</div>
                                                            <div>none</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">问题</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Completed</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Unestimated</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="classification-item" data-id="3">
                                            <div class="classification-item-inner">
                                                <div class="classification-item-header">
                                                    <h3>1.0.1</h3>
                                                    <div class="classification-item-line"></div>
                                                </div>
                                                <div class="classification-item-expanded">
                                                    <ul>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Start Date</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Release Date</div>
                                                            <div>none</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">问题</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Completed</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                        <li class="classification-item-group">
                                                            <div class="classification-item-group-cell">Unestimated</div>
                                                            <div>2/二月/18</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="classification-main">
                                    <div class="classification-backlog">
                                        <div class="classification-backlog-header">
                                            <div class="classification-backlog-name">WE5 Sprint 2.2</div>
                                            <div class="classification-backlog-issue-count">48 issues</div>
                                        </div>
                                        <div class="classification-backlog-inner">
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="classification-backlog">
                                        <div class="classification-backlog-header">
                                            <div class="classification-backlog-name">WE5 Sprint 2.2</div>
                                            <div class="classification-backlog-issue-count">48 issues</div>
                                        </div>
                                        <div class="classification-backlog-inner">
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                            <div class="js-sortable classification-backlog-item">
                                                <a href="#">BTOB-2245</a>
                                                <span>金价配置-自动调价</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?=ROOT_URL?>dev/js/jquery.min.js"></script>
<script src="<?=ROOT_URL?>dev/lib/sortable/sortable.js"></script>
<script type="text/javascript">
    $(function(){
        var id = ''

        $(".classification-side").on('click', '.classification-item', function(){
            if($(this).hasClass('open')){
                $(this).removeClass('open');
            }else{
                $(this).addClass('open');
            }
        })

        $(".classification-item")
            .on('dragenter', function(event){
                event.preventDefault();
                $(this).addClass("classification-out-line");
                console.log('enter')
            })
            .on('dragover', function(event){
                event.preventDefault();
                $(this).addClass("classification-out-line");
            })
            .on('drop', function(event){
                event.preventDefault();
                id = $(this).data('id');
                $(this).removeClass("classification-out-line");
                console.log('drop')
            })
            .on('dragleave', function(event){
                event.preventDefault();
                console.log('dragleave')
                $(this).removeClass("classification-out-line");
            })
            .on('mouseleave', function(event){
                $(this).removeClass("classification-out-line");
            })


        var items = document.getElementsByClassName('classification-backlog-inner');
        [].forEach.call(items, function (el){
            Sortable.create(el, {
                group: 'item',
                animation: 150,
                ghostClass: 'classification-out-line',
                onEnd: function(evt){
                    console.log('end', evt.item)
                    if(id){
                        // ajax
                        // ret == '200'
                        // $(evt.item).remove()
                    }
                }
            })
        })
    })
</script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">

    var $backlog = null;
    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/agile/fetch_backlog_issues/<?=$project_id?>",
            get_url:"/agile/get",
            pagination_id:"pagination"
        }
        window.$backlog = new Backlog( options );
        //window.$backlog.fetchAll( );
    });

</script>

</body>
</html>
