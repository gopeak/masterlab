<!DOCTYPE html>
<html class="" lang="en">
<head prefix="og: http://ogp.me/ns#">

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <link rel="shortcut icon" type="image/x-icon" href="https://assets.gitlab-static.net/assets/favicon-075eba76312e8421991a0c1f89a89ee81678bcde72319dd3e8047e2a47cd3a42.ico" id="favicon" />
    <link rel="stylesheet" media="all" href="https://assets.gitlab-static.net/assets/application-654dfd2c02876008b12bdf4fdda62e2e95999c6a4a8af19ad88acf5608caf75d.css" />
    <link rel="stylesheet" media="print" href="https://assets.gitlab-static.net/assets/print-74b3d49adeaada27337e759b75a34af7cf3d80051de91d60d40570f5a382e132.css" />


    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/admin/issue_ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/form.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="https://assets.gitlab-static.net/assets/webpack/raven.6b398e5f9261c2c6e468.bundle.js" defer="defer"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <script src="<?= ROOT_URL ?>dev/lib/simplemde/dist/simplemde.min.js"></script>
    <link rel="stylesheet" href="<?=ROOT_URL?>dev/lib//simplemde/dist/simplemde.min.css">

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

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
    <? require_once VIEW_PATH . 'gitlab/issue/common-filter-nav-links-sub-nav.php'; ?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class=" ">

            <div class="content" id="content-body">
                <div data-board-id="80" data-boards-endpoint="/gitlab-org/gitlab-runner/boards" data-bulk-update-path="/gitlab-org/gitlab-runner/issues/bulk_update" data-default-avatar="https://assets.gitlab-static.net/assets/no_avatar-849f9c04a3a0d0cea2424ae97b27447dc64a7dbfae83c036c45b403392f0e8ba.png" data-disabled="true" data-focus-mode-available="" data-issue-link-base="/gitlab-org/gitlab-runner/issues" data-label-ids="[]" data-labels="[]" data-lists-endpoint="/-/boards/80/lists" data-root-path="/" id="board-app" class="boards-app"><div class="hidden-xs hidden-sm"><div class="issues-filters"><div class="filtered-search-block issues-details-filters row-content-block second-block"><div id="js-multiple-boards-switcher" class="inline boards-switcher"><span class="boards-selector-wrapper js-boards-selector-wrapper js-boards-selector"><div class="dropdown"><button data-toggle="dropdown" class="dropdown-menu-toggle js-dropdown-toggle">
Development
<i aria-hidden="true" data-hidden="true" class="fa fa-chevron-down"></i></button> <div class="dropdown-menu is-loading"><div class="dropdown-content-faded-mask js-scroll-fade fade-out"><!----></div> <div class="dropdown-loading"><i aria-hidden="true" data-hidden="true" class="fa fa-spin fa-spinner"></i></div></div></div> <!----></span></div> <form class="filter-form js-filter-form" action="/gitlab-org/gitlab-runner/boards/80?" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="issues-other-filters filtered-search-wrapper"><div class="filtered-search-box"><div class="filtered-search-box-input-container droplab-dropdown"><div class="scroll-container"><ul class="tokens-container list-unstyled"><li class="input-token"><input autocomplete="off" class="form-control filtered-search" data-base-endpoint="/gitlab-org/gitlab-runner" data-project-id="250833" id="filtered-search-boards" placeholder="Search or filter results..." data-dropdown-trigger="#js-dropdown-hint"></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu hint-dropdown" id="js-dropdown-hint" data-dropdown-active="true" style="left: 12px; display: none;"><ul data-dropdown=""><li class="filter-dropdown-item" data-action="submit"><button class="btn btn-link"><i aria-hidden="true" data-hidden="true" class="fa fa-search"></i> <span>
Press Enter or click to search
</span></button></li></ul> <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-pencil"></i> <span class="js-filter-hint">
author
</span> <span class="js-filter-tag dropdown-light-content">
:@author
</span></button></li><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-user"></i> <span class="js-filter-hint">
assignee
</span> <span class="js-filter-tag dropdown-light-content">
:@assignee
</span></button></li><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-clock-o"></i> <span class="js-filter-hint">
milestone
</span> <span class="js-filter-tag dropdown-light-content">
:%milestone
</span></button></li><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-tag"></i> <span class="js-filter-hint">
label
</span> <span class="js-filter-tag dropdown-light-content">
:~label
</span></button></li><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-thumbs-up"></i> <span class="js-filter-hint">
my-reaction
</span> <span class="js-filter-tag dropdown-light-content">
:emoji
</span></button></li><li class="filter-dropdown-item" style="display: block;"><button class="btn btn-link"><i class="fa fa-balance-scale"></i> <span class="js-filter-hint">
weight
</span> <span class="js-filter-tag dropdown-light-content">
:weight
</span></button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-author"><ul data-dropdown=""><li class="filter-dropdown-item js-current-user"><button class="btn btn-link dropdown-user" type="button"><div class="avatar-container s40"><img alt="sven's avatar" src="/uploads/-/system/user/avatar/1538587/avatar.png" class="avatar s40" title="sven"></div> <div class="dropdown-user-details"><span>
sven
</span> <span class="dropdown-light-content">
@weichaoduo
</span></div></button></li></ul> <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item"><button class="btn btn-link dropdown-user" type="button"><div class="avatar-container s40"><img alt="{{name}}'s avatar" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{avatar_url}}" class="avatar s40 lazy" title="{{name}}"></div> <div class="dropdown-user-details"><span>
{{name}}
</span> <span class="dropdown-light-content">
@{{username}}
</span></div></button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-assignee"><ul data-dropdown=""><li class="filter-dropdown-item" data-value="none"><button class="btn btn-link">
                                                                No Assignee
                                                            </button></li> <li class="divider droplab-item-ignore"></li> <li class="filter-dropdown-item js-current-user"><button class="btn btn-link dropdown-user" type="button"><div class="avatar-container s40"><img alt="sven's avatar" src="/uploads/-/system/user/avatar/1538587/avatar.png" class="avatar s40" title="sven"></div> <div class="dropdown-user-details"><span>
sven
</span> <span class="dropdown-light-content">
@weichaoduo
</span></div></button></li></ul> <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item"><button class="btn btn-link dropdown-user" type="button"><div class="avatar-container s40"><img alt="{{name}}'s avatar" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{avatar_url}}" class="avatar s40 lazy" title="{{name}}"></div> <div class="dropdown-user-details"><span>
{{name}}
</span> <span class="dropdown-light-content">
@{{username}}
</span></div></button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-milestone"><ul data-dropdown=""><li class="filter-dropdown-item" data-value="none"><button class="btn btn-link">
                                                                No Milestone
                                                            </button></li> <li class="filter-dropdown-item" data-value="upcoming"><button class="btn btn-link">
                                                                Upcoming
                                                            </button></li> <li class="filter-dropdown-item" data-value="started"><button class="btn btn-link">
                                                                Started
                                                            </button></li> <li class="divider droplab-item-ignore"></li></ul> <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item"><button class="btn btn-link js-data-value">
                                                                {{title}}
                                                            </button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-label"><ul data-dropdown=""><li class="filter-dropdown-item" data-value="none"><button class="btn btn-link">
                                                                No Label
                                                            </button></li> <li class="divider droplab-item-ignore"></li></ul> <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item"><button class="btn btn-link"><span class="dropdown-label-box" style="background: {{color}}"></span> <span class="label-title js-data-value">
{{title}}
</span></button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-my-reaction"><ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item"><button class="btn btn-link"><gl-emoji></gl-emoji> <span class="js-data-value prepend-left-10">
{{name}}
</span></button></li></ul></div> <div class="filtered-search-input-dropdown-menu dropdown-menu" id="js-dropdown-weight"><ul data-dropdown=""><li class="filter-dropdown-item" data-value="none"><button class="btn btn-link">
                                                                No Weight
                                                            </button></li> <li class="filter-dropdown-item" data-value="any"><button class="btn btn-link">
                                                                Any Weight
                                                            </button></li> <li class="divider droplab-item-ignore"></li></ul> <ul class="filter-dropdown" data-dropdown=""><li class="filter-dropdown-item" data-value="1"><button class="btn btn-link">1</button></li> <li class="filter-dropdown-item" data-value="2"><button class="btn btn-link">2</button></li> <li class="filter-dropdown-item" data-value="3"><button class="btn btn-link">3</button></li> <li class="filter-dropdown-item" data-value="4"><button class="btn btn-link">4</button></li> <li class="filter-dropdown-item" data-value="5"><button class="btn btn-link">5</button></li> <li class="filter-dropdown-item" data-value="6"><button class="btn btn-link">6</button></li> <li class="filter-dropdown-item" data-value="7"><button class="btn btn-link">7</button></li> <li class="filter-dropdown-item" data-value="8"><button class="btn btn-link">8</button></li> <li class="filter-dropdown-item" data-value="9"><button class="btn btn-link">9</button></li></ul></div></div> <button class="clear-search hidden" type="button"><i aria-hidden="true" data-hidden="true" class="fa fa-times"></i></button></div> <div class="filter-dropdown-container"><div class="prepend-left-10"><button title="" type="button" class="btn btn-inverted" data-original-title="">
                                                    View scope
                                                </button></div> <div class="board-extra-actions"><a href="#" role="button" aria-label="Toggle focus mode" title="" class="btn btn-default has-tooltip prepend-left-10 js-focus-mode-btn" data-original-title="Toggle focus mode"><span style=""><svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg"><path d="M.147 15.496l2.146-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.146-1.428-1.428zM14.996.646l1.428 1.43-2.146 2.145 1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125l1.286 1.286L14.996.647zm-13.42 0L3.72 2.794l1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286L.147 2.075 1.575.647zm14.848 14.85l-1.428 1.428-2.146-2.146-1.286 1.286c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616l-1.286 1.286 2.146 2.146z" fill-rule="evenodd"></path></svg></span> <span style="display: none;"><svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M8.591 5.056l2.147-2.146-1.286-1.286a.55.55 0 0 1-.125-.616c.101-.238.277-.357.527-.357h4a.55.55 0 0 1 .402.17.55.55 0 0 1 .17.401v4c0 .25-.12.426-.358.527-.232.101-.437.06-.616-.125l-1.286-1.286-2.146 2.147-1.429-1.43zM5.018 8.553l1.429 1.43L4.3 12.127l1.286 1.286c.185.179.226.384.125.616-.101.238-.277.357-.527.357h-4a.55.55 0 0 1-.402-.17.55.55 0 0 1-.17-.401v-4c0-.25.12-.426.358-.527a.553.553 0 0 1 .616.125L2.872 10.7l2.146-2.147zm4.964 0l2.146 2.147 1.286-1.286a.55.55 0 0 1 .616-.125c.238.101.357.277.357.527v4a.55.55 0 0 1-.17.402.55.55 0 0 1-.401.17h-4c-.25 0-.426-.12-.527-.358-.101-.232-.06-.437.125-.616l1.286-1.286-2.147-2.146 1.43-1.429zM6.447 5.018l-1.43 1.429L2.873 4.3 1.586 5.586c-.179.185-.384.226-.616.125-.238-.101-.357-.277-.357-.527v-4a.55.55 0 0 1 .17-.402.55.55 0 0 1 .401-.17h4c.25 0 .426.12.527.358a.553.553 0 0 1-.125.616L4.3 2.872l2.147 2.146z" fill-rule="evenodd"></path></svg></span></a></div></div></div></form></div></div></div> <div class="boards-list"><!----> <div data-id="650944" class="board is-expandable is-collapsed"><div class="board-inner"><header class="board-header"><h3 class="board-title js-board-handle"><i aria-hidden="true" class="fa fa-fw board-title-expandable-toggle fa-caret-right"></i> <span title="" data-container="body" class="board-title-text has-tooltip" data-original-title="">
Backlog
</span> <!----> <div class="issue-count-badge clearfix"><span class="issue-count-badge-count pull-left">
583
</span></div></h3></header> <div class="board-list-component"><!----> <!----> <ul data-board="650944" class="board-list" style=""><li index="0" data-issue-id="4712378" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2235" title="Expose build performance data to Prometheus" class="js-no-trigger">Expose build performance data to Prometheus</a> <span class="card-number">
            #2235
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry">
                                                        CI/CD
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the Monitoring team. Covers everything related to prometheus monitoring, including GitLab instances and user-applications">
                                                        Monitoring
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);" data-original-title="Workflow: issues waiting to be picked for work in a release">
                                                        To Do
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="1" data-issue-id="3321419" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1829" title="Run GitLab Runner integration tests on all supported platforms and in all supported configurations" class="js-no-trigger">Run GitLab Runner integration tests on all supported platforms and in all supported configurations</a> <span class="card-number">
            #1829
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Workflow: ongoing issues in a release" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">
                                                        Doing
                                                    </button></div></div></li><li index="2" data-issue-id="4747432" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2251" title="&quot;Failed to update executor docker+machine for XXXXXXXX No free machines that can process builds&quot;" class="js-no-trigger">"Failed to update executor docker+machine for XXXXXXXX No free machines that can process builds"</a> <span class="card-number">
            #2251
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button></div></div></li><li index="3" data-issue-id="4807561" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2262" title="Random issues with `HTTP Basic: Access denied` on repo cloning" class="js-no-trigger">Random issues with `HTTP Basic: Access denied` on repo cloning</a> <span class="card-number">
            #2262
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button></div></div></li><li index="4" data-issue-id="4830890" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2275" title="Better messages when a the versions of gitlab and gitlab-runner are incompatible" class="js-no-trigger">Better messages when a the versions of gitlab and gitlab-runner are incompatible</a> <span class="card-number">
            #2275
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="5" data-issue-id="4851792" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2290" title="Shallow cloning of sub modules" class="js-no-trigger">Shallow cloning of sub modules</a> <span class="card-number">
            #2290
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="6" data-issue-id="4868036" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2296" title="Automatically retry N times when clone fails" class="js-no-trigger">Automatically retry N times when clone fails</a> <span class="card-number">
            #2296
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="7" data-issue-id="4881911" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2302" title="extra_hosts should be added to services" class="js-no-trigger">extra_hosts should be added to services</a> <span class="card-number">
            #2302
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button></div></div></li><li index="8" data-issue-id="4985042" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2338" title="Kubernetes executor does not invoke the ENTRYPOINT script of the defined image in  .gitlab-ci.yml" class="js-no-trigger">Kubernetes executor does not invoke the ENTRYPOINT script of the defined image in  .gitlab-ci.yml</a> <span class="card-number">
            #2338
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button></div></div></li><li index="9" data-issue-id="4986172" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2340" title="Build artifacts appear to be successfully uploaded to coordinator but are unavailable to download" class="js-no-trigger">Build artifacts appear to be successfully uploaded to coordinator but are unavailable to download</a> <span class="card-number">
            #2340
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues related to GitLab CI build artifacts: http://doc.gitlab.com/ce/ci/build_artifacts/README.html" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        artifacts
                                                    </button><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button><button type="button" title="Issues with this label are regressions from the previous non-patch release" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(217, 83, 79); color: rgb(255, 255, 255);">
                                                        regression
                                                    </button><button type="button" title="Issue or Merge Request is waiting for reporter's feedback" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(52, 73, 94); color: rgb(255, 255, 255);">
                                                        waiting for feedback
                                                    </button></div></div></li><li index="10" data-issue-id="4989358" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2341" title="Environment variables to services from a .env file" class="js-no-trigger">Environment variables to services from a .env file</a> <span class="card-number">
            #2341
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="11" data-issue-id="4989631" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2342" title="Docker+machine executor creating too many instances" class="js-no-trigger">Docker+machine executor creating too many instances</a> <span class="card-number">
            #2342
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues and changes related to docker-machine executor" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(168, 214, 149); color: rgb(51, 51, 51);">
                                                        executor::docker-machine
                                                    </button><button type="button" title="Relates to issues raised by the community that need further investigation to triage. Please feel free to help investigate!" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(105, 209, 0); color: rgb(255, 255, 255);">
                                                        needs investigation
                                                    </button></div></div></li><li index="12" data-issue-id="4998511" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2345" title="Cache not available depending of the runner id" class="js-no-trigger">Cache not available depending of the runner id</a> <span class="card-number">
            #2345
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues for the Documentation team. Covers our efforts to continuously improve and maintain the quality of GitLab documentation" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        Documentation
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="13" data-issue-id="5016758" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2351" title="Registering runners - status=couldn't execute POST against...." class="js-no-trigger">Registering runners - status=couldn't execute POST against....</a> <span class="card-number">
            #2351
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Requests for help (questions of type &quot;How can I ...?&quot;)" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        support
                                                    </button></div></div></li><li index="14" data-issue-id="5032162" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2357" title="Artifact upload to gitlab POST missing HTTP Content-Length header" class="js-no-trigger">Artifact upload to gitlab POST missing HTTP Content-Length header</a> <span class="card-number">
            #2357
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues related to GitLab CI build artifacts: http://doc.gitlab.com/ce/ci/build_artifacts/README.html" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        artifacts
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="15" data-issue-id="5068626" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2365" title="How to deploy cleanly with GitLab-CI and SSH?" class="js-no-trigger">How to deploy cleanly with GitLab-CI and SSH?</a> <span class="card-number">
            #2365
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Used for tracking the number of Support Request on the Issue Tracker" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 141, 67); color: rgb(255, 255, 255);">
                                                        support request
                                                    </button></div></div></li><li index="16" data-issue-id="5108043" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2375" title="Improve docker images pulling" class="js-no-trigger">Improve docker images pulling</a> <span class="card-number">
            #2375
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues and changes related to docker executor" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(168, 214, 149); color: rgb(51, 51, 51);">
                                                        executor::docker
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="17" data-issue-id="5139841" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2387" title="Display gitlab-runner-helper version in CI output" class="js-no-trigger">Display gitlab-runner-helper version in CI output</a> <span class="card-number">
            #2387
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues opened for contribution from the Community. Issue's weight is an estimation of complexity. Please mention @markglenfletcher if you have any questions :)" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(105, 209, 0); color: rgb(255, 255, 255);">
                                                        Accepting Merge Requests
                                                    </button><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="18" data-issue-id="5176219" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2396" title="document graceful kubernetes executor upgrade/update" class="js-no-trigger">document graceful kubernetes executor upgrade/update</a> <span class="card-number">
            #2396
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues for the Documentation team. Covers our efforts to continuously improve and maintain the quality of GitLab documentation" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        Documentation
                                                    </button><button type="button" title="Issues and changes related to kubernetes executor " data-container="body" class="label color-label has-tooltip" style="background-color: rgb(168, 214, 149); color: rgb(51, 51, 51);">
                                                        executor::kubernetes
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="19" data-issue-id="5180692" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2400" title="Error response from daemon: endpoint with name XXX already exists in network bridge" class="js-no-trigger">Error response from daemon: endpoint with name XXX already exists in network bridge</a> <span class="card-number">
            #2400
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li> <li data-issue-id="-1" class="board-list-count text-center"><div class="loading-container text-center" style="display: none;"><i aria-hidden="true" aria-label="Loading more issues" class="fa fa-spin fa-spinner fa-1x"></i></div> <span>
        Showing 20 of 583 issues
      </span></li></ul></div> <!----></div></div><div data-id="546331" class="board is-draggable"><div class="board-inner"><header class="board-header has-border" style="border-top-color: rgb(66, 139, 202);"><h3 class="board-title js-board-handle"><!----> <!----> <span title="" data-container="body" data-placement="bottom" class="board-title-text color-label has-tooltip label title" style="background-color: rgb(66, 139, 202);" data-original-title="Issues that are expected to be delivered in the current milestone.">
Deliverable
</span> <div class="issue-count-badge clearfix"><span class="issue-count-badge-count pull-left">
4
</span></div></h3></header> <div class="board-list-component"><!----> <!----> <ul data-board="546331" class="board-list" style=""><li index="0" data-issue-id="3950176" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2045" title="allow access at registration time  to be able to the runner active: false" class="js-no-trigger">allow access at registration time  to be able to the runner active: false</a> <span class="card-number">
            #2045
          </span> <span data-container="body" data-placement="bottom" title="" class="card-weight card-number prepend-left-5" data-original-title="Weight"><svg class="s16"><use xlink:href="https://gitlab.com/assets/icons-a0901715baf53dcd3ff0250a08419a8d13d1a11dbe359ca821a52563eec56aa7.svg#scale"></use></svg>
  2
</span></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);" data-original-title="Issues that propose new features">
                                                        feature proposal
                                                    </button></div></div></li><li index="1" data-issue-id="9396713" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/3114" title="Fix metric names" class="js-no-trigger">Fix metric names</a> <span class="card-number">
            #3114
          </span> <!----></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);" data-original-title="Issues that are expected to be delivered in the current milestone.">
                                                        Deliverable
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the Monitoring team. Covers everything related to prometheus monitoring, including GitLab instances and user-applications">
                                                        Monitoring
                                                    </button></div></div></li><li index="2" data-issue-id="10683185" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/3275" title="Content-Range is badly formatted" class="js-no-trigger">Content-Range is badly formatted</a> <span class="card-number">
            #3275
          </span> <!----></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);" data-original-title="Issues that report undesirable or incorrect behavior">
                                                        bug
                                                    </button></div></div></li><li index="3" data-issue-id="10692381" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/3276" title="GitLab Runner 10.8 release checklist" class="js-no-trigger">GitLab Runner 10.8 release checklist</a> <span class="card-number">
            #3276
          </span> <!----></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button><button type="button" title="Issues and changes related to release process, tools and workflows itself" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        release
                                                    </button></div></div></li> <!----></ul></div> <!----></div></div><div data-id="748694" class="board is-draggable"><div class="board-inner"><header class="board-header has-border" style="border-top-color: rgb(66, 139, 202);"><h3 class="board-title js-board-handle"><!----> <!----> <span title="" data-container="body" data-placement="bottom" class="board-title-text color-label has-tooltip label title" style="background-color: rgb(66, 139, 202);" data-original-title="Issues that are a stretch goal for delivering in the current milestone. If these issues are not done in the current release, they will strongly be considered for the next release.">
Stretch
</span> <div class="issue-count-badge clearfix"><span class="issue-count-badge-count pull-left">
3
</span></div></h3></header> <div class="board-list-component"><!----> <!----> <ul data-board="748694" class="board-list" style=""><li index="0" data-issue-id="6395715" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2667" title="Jobs fail Randomly with Docker executor" class="js-no-trigger">Jobs fail Randomly with Docker executor</a> <span class="card-number">
            #2667
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry">
                                                        CI/CD
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);" data-original-title="For internal Support team use.">
                                                        SP2
                                                    </button><button type="button" title="Issues that are a stretch goal for delivering in the current milestone. If these issues are not done in the current release, they will strongly be considered for the next release." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Stretch
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);" data-original-title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label">
                                                        customer
                                                    </button></div></div></li><li index="1" data-issue-id="6969665" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2797" title="Implement a proper way to replace 'exec' functionality" class="js-no-trigger">Implement a proper way to replace 'exec' functionality</a> <span class="card-number">
            #2797
          </span> <!----></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry">
                                                        CI/CD
                                                    </button><button type="button" title="Issues for the Documentation team. Covers our efforts to continuously improve and maintain the quality of GitLab documentation" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        Documentation
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);" data-original-title="Issues that are a stretch goal for delivering in the current milestone. If these issues are not done in the current release, they will strongly be considered for the next release.">
                                                        Stretch
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 141, 67); color: rgb(255, 255, 255);" data-original-title="Issues for important features that are on our roadmap: https://about.gitlab.com/direction/">
                                                        direction
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);" data-original-title="Issues that propose new features">
                                                        feature proposal
                                                    </button></div></div></li><li index="2" data-issue-id="9286131" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/3096" title="Fix miss-named metrics flag/config" class="js-no-trigger">Fix miss-named metrics flag/config</a> <span class="card-number">
            #3096
          </span> <!----></h4> <div class="card-assignee"><a href="/bjk-gitlab" class="user-avatar-link js-no-trigger"><img src="/uploads/-/system/user/avatar/928230/avatar.png" width="20" height="20" alt="Avatar for Ben Kochie" data-src="/uploads/-/system/user/avatar/928230/avatar.png" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Ben Kochie"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the Monitoring team. Covers everything related to prometheus monitoring, including GitLab instances and user-applications">
                                                        Monitoring
                                                    </button><button type="button" title="Issues that are a stretch goal for delivering in the current milestone. If these issues are not done in the current release, they will strongly be considered for the next release." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Stretch
                                                    </button></div></div></li> <!----></ul></div> <!----></div></div><div data-id="775509" class="board is-draggable"><div class="board-inner"><header class="board-header has-border" style="border-top-color: rgb(204, 37, 0);"><h3 class="board-title js-board-handle"><!----> <!----> <span title="" data-container="body" data-placement="bottom" class="board-title-text color-label has-tooltip label title" style="background-color: rgb(204, 37, 0);" data-original-title="Issues to put in the next patch release. Work on these first, and add the Pick Into Stable label to the merge request, along with the appropriate milestone.">
Next Patch Release
</span> <div class="issue-count-badge clearfix"><span class="issue-count-badge-count pull-left">
0
</span></div></h3></header> <div class="board-list-component"><!----> <!----> <ul data-board="775509" class="board-list" style=""> <!----></ul></div> <!----></div></div><div data-id="270" class="board is-expandable is-collapsed"><div class="board-inner"><header class="board-header"><h3 class="board-title js-board-handle"><i aria-hidden="true" class="fa fa-fw board-title-expandable-toggle fa-caret-right"></i> <span title="" data-container="body" class="board-title-text has-tooltip">
Closed
</span> <!----> <div class="issue-count-badge clearfix"><span class="issue-count-badge-count pull-left">
2058
</span></div></h3></header> <div class="board-list-component"><!----> <!----> <ul data-board="270" class="board-list" style=""><li index="0" data-issue-id="4449512" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2162" title="Document Docker `network_mode` configuration option" class="js-no-trigger">Document Docker `network_mode` configuration option</a> <span class="card-number">
            #2162
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);" data-original-title="Issues for the Documentation team. Covers our efforts to continuously improve and maintain the quality of GitLab documentation">
                                                        Documentation
                                                    </button><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="1" data-issue-id="4352171" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2141" title="Switch from `/ci/api/v1` to `/api/v4/`  for Runner 9.0" class="js-no-trigger">Switch from `/ci/api/v1` to `/api/v4/`  for Runner 9.0</a> <span class="card-number">
            #2141
          </span> <!----></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);" data-original-title="Workflow: ongoing issues in a release">
                                                        Doing
                                                    </button><button type="button" title="" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);" data-original-title="Issues and changes related to Runner <-> GitLab API">
                                                        GitLab API
                                                    </button></div></div></li><li index="2" data-issue-id="3734774" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1965" title="Runner says &quot;Cache extracted successfully&quot; if cache-extractor gets 404 response for cache URL" class="js-no-trigger">Runner says "Cache extracted successfully" if cache-extractor gets 404 response for cache URL</a> <span class="card-number">
            #1965
          </span> <!----></h4> <div class="card-assignee"><a href="/MrTrustor" class="user-avatar-link js-no-trigger"><img src="/uploads/-/system/user/avatar/527833/avatar.png" width="20" height="20" alt="Avatar for Théo Chamley" data-src="/uploads/-/system/user/avatar/527833/avatar.png" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Théo Chamley"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Workflow: issues waiting to be picked for work in a release" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        To Do
                                                    </button><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues and changes related to Runner's caching mechanism " data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        cache
                                                    </button></div></div></li><li index="3" data-issue-id="3847575" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/2011" title="GIT_STRATEGY no-checkout" class="js-no-trigger">GIT_STRATEGY no-checkout</a> <span class="card-number">
            #2011
          </span> <!----></h4> <div class="card-assignee"><a href="/cpallares" class="user-avatar-link js-no-trigger"><img src="/uploads/-/system/user/avatar/136229/avatar.png" width="20" height="20" alt="Avatar for Cindy Pallares 🦉" data-src="/uploads/-/system/user/avatar/136229/avatar.png" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Cindy Pallares 🦉"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Workflow: issues waiting to be picked for work in a release" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        To Do
                                                    </button><button type="button" title="Improvement proposals" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">
                                                        improvement
                                                    </button></div></div></li><li index="4" data-issue-id="2554342" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1466" title="Aliases for services docker images" class="js-no-trigger">Aliases for services docker images</a> <span class="card-number">
            #1466
          </span> <span data-container="body" data-placement="bottom" title="" class="card-weight card-number prepend-left-5" data-original-title="Weight"><svg class="s16"><use xlink:href="https://gitlab.com/assets/icons-a0901715baf53dcd3ff0250a08419a8d13d1a11dbe359ca821a52563eec56aa7.svg#scale"></use></svg>
  9
</span></h4> <div class="card-assignee"><a href="/tmaczukin" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Tomasz Maczukin" data-src="https://secure.gravatar.com/avatar/f3b0a936861194d8eb9411eabbdd03ee?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Tomasz Maczukin"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button><button type="button" title="Issues and changes related to docker executor" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(168, 214, 149); color: rgb(51, 51, 51);">
                                                        executor::docker
                                                    </button><button type="button" title="Other important issues" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(204, 0, 51); color: rgb(255, 255, 255);">
                                                        high priority
                                                    </button><button type="button" title="Improvement proposals" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(92, 184, 92); color: rgb(255, 255, 255);">
                                                        improvement
                                                    </button></div></div></li><li index="5" data-issue-id="3734336" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1962" title="Pipeline hangs when job is done." class="js-no-trigger">Pipeline hangs when job is done.</a> <span class="card-number">
            #1962
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button><button type="button" title="Issues and changes related to docker executor" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(168, 214, 149); color: rgb(51, 51, 51);">
                                                        executor::docker
                                                    </button><button type="button" title="Issues and changes related to executors feature (as a whole - particular executors have their own labels)" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        executors
                                                    </button></div></div></li><li index="6" data-issue-id="3486163" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1876" title="kubernetes-executor should allow specifying volumes (HostPath, Secrets)" class="js-no-trigger">kubernetes-executor should allow specifying volumes (HostPath, Secrets)</a> <span class="card-number">
            #1876
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button></div></div></li><li index="7" data-issue-id="1074105" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1016" title="Clearing the cache" class="js-no-trigger">Clearing the cache</a> <span class="card-number">
            #1016
          </span> <!----></h4> <div class="card-assignee"><a href="/matteeyah" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/8bc04cc15e0adba406cf56fecd9d910a?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Matija Čupić" data-src="https://secure.gravatar.com/avatar/8bc04cc15e0adba406cf56fecd9d910a?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Matija Čupić"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues for the CI/CD team. Covers everything related to GitLab CI, including Deploy, Pages and the container registry" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        CI/CD
                                                    </button><button type="button" title="Issues that are expected to be delivered in the current milestone." data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        Deliverable
                                                    </button><button type="button" title="Issues for the UX team. Covers new or existing functionality that needs a design proposal" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(68, 173, 142); color: rgb(255, 255, 255);">
                                                        UX
                                                    </button><button type="button" title="Issues and changes related to Runner's caching mechanism " data-container="body" class="label color-label has-tooltip" style="background-color: rgb(66, 139, 202); color: rgb(255, 255, 255);">
                                                        cache
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button><button type="button" title="Issues that propose new features" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(240, 173, 78); color: rgb(255, 255, 255);">
                                                        feature proposal
                                                    </button></div></div></li><li index="8" data-issue-id="3663274" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1937" title="User variable does not resolve in environment section" class="js-no-trigger">User variable does not resolve in environment section</a> <span class="card-number">
            #1937
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="9" data-issue-id="3573166" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1909" title="GitLab CI and hostname resolution in dind mode" class="js-no-trigger">GitLab CI and hostname resolution in dind mode</a> <span class="card-number">
            #1909
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="10" data-issue-id="3449784" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1868" title="Connection refused to port 443 using GitLab Runner with Docker and services" class="js-no-trigger">Connection refused to port 443 using GitLab Runner with Docker and services</a> <span class="card-number">
            #1868
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="11" data-issue-id="3248847" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1803" title="Build failing with HTTPS error" class="js-no-trigger">Build failing with HTTPS error</a> <span class="card-number">
            #1803
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="12" data-issue-id="3049365" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1705" title="Shell execution issues on SLES 11 SP3" class="js-no-trigger">Shell execution issues on SLES 11 SP3</a> <span class="card-number">
            #1705
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="13" data-issue-id="2881388" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1635" title="Getting Cannot connect to the Docker daemon on AWS EC2 runner" class="js-no-trigger">Getting Cannot connect to the Docker daemon on AWS EC2 runner</a> <span class="card-number">
            #1635
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="14" data-issue-id="2815890" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1616" title="gitlab-runner-service executable not found in $PATH" class="js-no-trigger">gitlab-runner-service executable not found in $PATH</a> <span class="card-number">
            #1616
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="15" data-issue-id="2655969" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1523" title="Runner fails to download artifacts.  Fails with &quot;... was unexpected at this time&quot;" class="js-no-trigger">Runner fails to download artifacts.  Fails with "... was unexpected at this time"</a> <span class="card-number">
            #1523
          </span> <!----></h4> <div class="card-assignee"><a href="/nick.thomas" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/ffef5c344b3fc4ee332a47d47ac2f42c?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Nick Thomas" data-src="https://secure.gravatar.com/avatar/ffef5c344b3fc4ee332a47d47ac2f42c?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Nick Thomas"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button><button type="button" title="Issues and changes related to only Windows OS" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(162, 149, 214); color: rgb(51, 51, 51);">
                                                        os::Windows
                                                    </button></div></div></li><li index="16" data-issue-id="2183450" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1298" title="Build task failing because of unescaped chars in title" class="js-no-trigger">Build task failing because of unescaped chars in title</a> <span class="card-number">
            #1298
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="17" data-issue-id="1448203" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1199" title="Build with lfs" class="js-no-trigger">Build with lfs</a> <span class="card-number">
            #1199
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="18" data-issue-id="1344868" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/1135" title="Runner uses strange mashup of external and ssh_host URLs" class="js-no-trigger">Runner uses strange mashup of external and ssh_host URLs</a> <span class="card-number">
            #1135
          </span> <!----></h4> <div class="card-assignee"> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li><li index="19" data-issue-id="547520" class="card is-disabled"><div><div class="card-header"><h4 class="card-title"><!----> <a href="/gitlab-org/gitlab-runner/issues/196" title="gitlab-ci-multi-runnner isn't closing the sockets to docker?" class="js-no-trigger">gitlab-ci-multi-runnner isn't closing the sockets to docker?</a> <span class="card-number">
            #196
          </span> <!----></h4> <div class="card-assignee"><a href="/nick.thomas" class="user-avatar-link js-no-trigger"><img src="https://secure.gravatar.com/avatar/ffef5c344b3fc4ee332a47d47ac2f42c?s=80&amp;d=identicon" width="20" height="20" alt="Avatar for Nick Thomas" data-src="https://secure.gravatar.com/avatar/ffef5c344b3fc4ee332a47d47ac2f42c?s=80&amp;d=identicon" data-container="body" data-placement="bottom" title="" class="avatar s20 " data-original-title="Assigned to Nick Thomas"><!----></a> <!----></div></div> <div class="card-footer"><button type="button" title="Issues that report undesirable or incorrect behavior" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
                                                        bug
                                                    </button><button type="button" title="Issues that were reported by Enterprise Edition subscribers. This label should be accompanied by either the 'bug' or 'feature proposal' label" data-container="body" class="label color-label has-tooltip" style="background-color: rgb(173, 67, 99); color: rgb(255, 255, 255);">
                                                        customer
                                                    </button></div></div></li> <li data-issue-id="-1" class="board-list-count text-center"><div class="loading-container text-center" style="display: none;"><i aria-hidden="true" aria-label="Loading more issues" class="fa fa-spin fa-spinner fa-1x"></i></div> <span>
        Showing 20 of 2058 issues
      </span></li></ul></div> <!----></div></div></div> <aside class="right-sidebar right-sidebar-expanded issue-boards-sidebar" style="display: none;"><div class="issuable-sidebar"><div class="block issuable-sidebar-header"><span class="issuable-header-text hide-collapsed pull-left"><strong>

</strong> <br> <span>#
</span></span> <a aria-label="Toggle sidebar" href="#" role="button" class="gutter-toggle pull-right"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9,7.5l5.83-5.91a.48.48,0,0,0,0-.69L14.11.15a.46.46,0,0,0-.68,0l-5.93,6L1.57.15a.46.46,0,0,0-.68,0L.15.9a.48.48,0,0,0,0,.69L6,7.5.15,13.41a.48.48,0,0,0,0,.69l.74.75a.46.46,0,0,0,.68,0l5.93-6,5.93,6a.46.46,0,0,0,.68,0l.74-.75a.48.48,0,0,0,0-.69Z"></path></svg></a></div> <div class="js-issuable-update"><div class="block assignee"><!----></div> <div class="block epic"><div class="title">
                                        Epic
                                        <!----></div> <!----></div> <div class="block milestone"><div class="title">
                                        Milestone
                                    </div> <div class="value"><span class="no-value">
None
</span> <!----></div></div> <div class="block due_date"><div class="title">
                                        Due date
                                    </div> <div class="value"><div class="value-content"><span class="no-value">
No due date
</span> <!----></div></div></div> <div class="block labels"><div class="title">
                                        Labels
                                    </div> <div class="value issuable-show-labels dont-hide"><!----> </div></div> <div class="block weight"><div data-container="body" data-placement="left" title="" class="sidebar-collapsed-icon js-weight-collapsed-block" data-original-title="Weight"><svg class="s16"><use xlink:href="https://gitlab.com/assets/icons-a0901715baf53dcd3ff0250a08419a8d13d1a11dbe359ca821a52563eec56aa7.svg#scale"></use></svg> <span class="js-weight-collapsed-weight-label">
      No
    </span></div> <div class="title hide-collapsed">
                                        Weight
                                        <!----> <!----></div> <div class="value hide-collapsed js-weight-weight-label"><span class="no-value">
      None
    </span></div> <div class="selectbox hide-collapsed"><div class="dropdown"><button type="button" data-toggle="dropdown" class="dropdown-menu-toggle js-gl-dropdown-refresh-on-open"><span class="dropdown-toggle-text js-weight-dropdown-toggle-text is-default">
          Weight
        </span> <i aria-hidden="true" data-hidden="true" class="fa fa-chevron-down"></i></button> <div class="dropdown-menu dropdown-select dropdown-menu-selectable dropdown-menu-weight"><div class="dropdown-title"><span>
            Change weight
          </span> <button aria-label="Close" type="button" class="dropdown-title-button dropdown-menu-close"><i aria-hidden="true" data-hidden="true" class="fa fa-times dropdown-menu-close-icon"></i></button></div> <div class="dropdown-content js-weight-dropdown-content"></div></div></div></div></div> <div class="block subscriptions"><div><div class="sidebar-collapsed-icon"><span title="" data-container="body" data-placement="left" data-original-title="Notifications off"><svg class="sidebar-item-icon is-active s16" aria-hidden="true"><use xlink:href="https://gitlab.com/assets/icons-a0901715baf53dcd3ff0250a08419a8d13d1a11dbe359ca821a52563eec56aa7.svg#notifications-off"></use></svg></span></div> <span class="issuable-header-text hide-collapsed pull-left">
    Notifications
  </span> <label class="toggle-wrapper pull-right hide-collapsed js-issuable-subscribe-button"><!----> <button type="button" aria-label="Toggle Status: OFF" class="project-feature-toggle is-loading"><div class="loading-container text-center loading-icon"><i aria-hidden="true" aria-label="Loading" class="fa fa-spin fa-spinner fa-1x"></i></div> <span class="toggle-icon"><svg class="s16 toggle-icon-svg"><use xlink:href="https://gitlab.com/assets/icons-a0901715baf53dcd3ff0250a08419a8d13d1a11dbe359ca821a52563eec56aa7.svg#status_failed_borderless"></use></svg></span></button></label></div></div> <div class="block list"><button type="button" class="btn btn-default btn-block">
                                        Remove from board
                                    </button></div></div></div></aside> <!----></div>


            </div>
        </div>
    </div>
</div>

<?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>

<script type="text/html"  id="save_filter_tpl">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="save_filter_text" placeholder="请输入过滤器名称" name="save_filter_text"  class="form-control" />
        </div>
        <div class="col-md-4"><a class="btn btn-sm" id="save_filter_btn"   onclick="IssueMain.prototype.saveFilter($('#save_filter_text').val())"  href="#">确定</a>
        </div>
    </div>
</script>


<script type="text/html" id="list_tpl">
    {{#issues}}

    <tr class="tree-item" data-id="{{id}}">
        <td>
            {{make_issue_type issue_type ../issue_types }}
        </td>
        <td>
            {{pkey}}
        </td>
        <td>
            {{make_module module ../issue_module }}
        </td>
        <td>

            <a href="/issue/detail/index/{{id}}" class="commit-row-message">
                {{summary}}
            </a>

        </td>
        <td>
            {{make_user assignee ../users }}

        </td>
        <td>
            {{make_user reporter ../users }}
        </td>
        <td>
            {{make_priority priority ../priority }}

        </td>
        <td>
            {{make_status status ../issue_status }}
        </td>

        <td>
            {{make_resolve resolve ../issue_resolve}}
        </td>
        <td>{{created_text}}
        </td>
        <td>{{updated_text}}
        </td>
        <td class="pipeline-actions">
            <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                <div class="js-notification-toggle-btns">
                    <div class="">
                        <a class="dropdown-new  notifications-btn "
                           style="color: #8b8f94;" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown"
                           id="notifications-button"
                           type="button" aria-expanded="false">
                            ...
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown dropdown-menu dropdown-menu-no-wrap dropdown-menu-selectable" style="left:-120px;width:160px;min-width:140px; ">

                            <li class="aui-list-item active">
                                <a   href="#modal-edit-issue" class="issue_edit_href"  data-issue_id="{{id}}">
                                    编辑
                                </a>
                            </li>
                            <li class="aui-list-item ">
                                <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Sprint</a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Kanban</a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">转换为子任务</a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="#" data-issueid="10920" data-issuekey="IP-524">移动</a>
                            </li>
                            <li class="aui-list-item">
                                <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">链接</a>
                            </li>
                            <li class="aui-list-item">
                                <a href="" class="" data-issueid="10920"  data-issuekey="IP-524">复制</a></li>
                            <li class="aui-list-item">
                                <a href="" class="" data-issueid="10920"  data-issuekey="IP-524">删除</a></li>
                            <li class="aui-list-item">
                                <a href="" class="aui-list-item-link notificationhelper-trigger" data-issueid="10920"
                                   data-issuekey="IP-524">通知方案助手</a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </td>
    </tr>
    {{/issues}}

</script>


<script type="text/html"  id="wrap_field">
        <div class=" form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">{{display_name}}:{{required_html}}</div>
            <div class="col-sm-8">{field_html}</div>
            <div class="col-sm-1"></div>
        </div>

</script>


<script type="text/html"  id="li_tab_tpl">
    <div role="tabpanel"  class="tab-pane " id="{{id}}">

        <div   id="create_ui_config_{{id}}" style="min-height: 200px">

        </div>

    </div>
</script>

<script type="text/html"  id="nav_tab_li_tpl">
    <li role="presentation" class="active">
        <a id="a_{{id}}" href="#{{id}}" role="tab" data-toggle="tab">
            <span id="span_{{id}}">{{title}}&nbsp;</span>
        </a>
    </li>
</script>

<script type="text/html"  id="content_tab_tpl">
    <div role="tabpanel"  class="tab-pane " id="{{id}}">
        <div class="dd-list" id="create_ui_config-{{id}}" style="min-height: 200px">

        </div>
    </div>
</script>

<script type="text/html"  id="fav_filter_first_tpl">
    <li class="fav_filter_li">
        <a id="state-opened" title="清除该过滤条件" href="javascript:$IssueMain.updateFavFilter('0');"><span>所有问题</span> <span class="badge">0</span>
        </a>
    </li>
    {{#first_filters}}
    <li class="fav_filter_li">
        <a id="state-opened" title="{{description}}" href="javascript:$IssueMain.updateFavFilter({{id}});"><span>{{name}}</span> <span class="badge">0</span>
        </a>
    </li>
    {{/first_filters}}

</script>
<script type="text/html"  id="fav_filter_hide_tpl">

    {{#hide_filters}}
    <li>
        <a class="update-notification fav_filter_a" data-notification-level="custom" data-notification-title="Custom"  href="javascript:$IssueMain.updateFavHideFilter({{id}});" role="button">
            <strong class="dropdown-menu-inner-title">{{name}}</strong>
            <span class="dropdown-menu-inner-content">{{description}}</span>
        </a>
    </li>
    {{/hide_filters}}

</script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js"></script>
<script type="text/javascript">

    var _issueConfig = {
        priority:null,
        issue_types:null,
        issue_status:null,
        issue_resolve:null,
        issue_module:null,
        issue_version:null,
        issue_labels:null,
        users:null,
        projects:null
    };

    var _simplemde = {};
    var _fineUploader = {};
    var _fineUploaderFile = {};
    var _issue_id = null;
    var _cur_project_id = '<?=$project_id?>';

    var $IssueMain = null;
    var query_str = '<?=$query_str?>';
    var urls = parseURL(window.location.href);
    console.log(urls);
    var qtipApi = null;
    new UsersSelect();



</script>
<style>

    .CodeMirror, .CodeMirror-scroll {
        min-height: 100px;
        max-height: 200px;
    }
</style>

</body>
</html>

