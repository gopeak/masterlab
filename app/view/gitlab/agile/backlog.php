<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>dev/lib/moment.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/agile/backlog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>


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
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>

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
                            </a></div>
                        <ul class="nav-links event-filter scrolling-tabs is-initialized">
                            <li class="active"><a class="event-filter-link" id="all_event_filter" title="Filter by all" href="/ismond/b2b"><span> All</span></a></li>
                            <li class=""><a class="event-filter-link" id="push_event_filter" title="Filter by push events" href="/ismond/b2b"><span> Push events</span></a></li>
                            <li class=""><a class="event-filter-link" id="merged_event_filter" title="Filter by merge events" href="/ismond/b2b"><span> Merge events</span></a></li>
                            <li class=""><a class="event-filter-link" id="issue_event_filter" title="Filter by issue events" href="/ismond/b2b"><span> Issue events</span></a></li>
                            <li class=""><a class="event-filter-link" id="comments_event_filter" title="Filter by comments" href="/ismond/b2b"><span> Comments</span></a></li>
                            <li><a class="event-filter-link" id="team_event_filter" title="Filter by team" href="/ismond/b2b"><span> Team</span></a></li>
                        </ul>

                    </div>
                    <div class="issues-holder">
                        <div class="table-holder">
                            <table class="table  tree-table" id="tree-slider">

                                <tbody id="list_render_id">

                                </tbody>
                            </table>
                        </div>
                        <div class="gl-pagination" id="ampagination-bootstrap">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/html" id="list_tpl">
    {{#backlogs}}
        <tr class="tree-item" data-id="{{id}}">
            <td>
                {{make_backlog_issue_type issue_type ../issue_types }}
                {{make_priority priority ../priority }}
                {{pkey}}{{id}}
                <a href="/issue/detail/index/{{id}}" class="commit-row-message">
                    {{summary}}
                </a>
            </td>
            <td>
                {{make_user assignee ../users }}
            </td>  
        </tr>
    {{/backlogs}}

</script>




<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">

    var $backlog = null;
    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/agile/fetchAllBacklogIssues/<?=$project_id?>",
            get_url:"/agile/get",
            pagination_id:"pagination"
        }
        window.$backlog = new Backlog( options );
        window.$backlog.fetchAll( );
    });

</script>

</body>
</html>

