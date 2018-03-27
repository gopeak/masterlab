<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php';?>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/issuable.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/detail.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script>
        window.project_uploads_path = "/ismond/xphp/uploads";
        window.preview_markdown_path = "/ismond/xphp/preview_markdown";
    </script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script type="text/javascript" src="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/lib/qtip/dist/jquery.qtip.min.css" />

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/editor.md/css/editormd.css" />
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/editormd.js"></script>


</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php';?>
    </div>
</header>

<div class="page-gutter page-with-sidebar right-sidebar-expanded">
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php';?>

    <div class="content-wrapper page-with-layout-nav ">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">
            <input type="hidden" name="issue_id" id="issue_id" value="" />
            <div class="content" id="content-body">


                <div class="clearfix detail-page-header">
                    <div class="issuable-header" id="issuable-header">
                        <script type="text/html" id="issuable-header_tpl">
                            <a class="btn btn-default pull-right visible-xs-block gutter-toggle issuable-gutter-toggle js-sidebar-toggle" href="#">
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                            <div class="issuable-meta">
                                <strong class="identifier">Issue
                                    <a href="/issue/main/{{issue.id}}" id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a></strong>
                                由
                                <strong>
                                    <a class="author_link  hidden-xs" href="/sven">
                                        <img id="creator_avatar" width="24" class="avatar avatar-inline s24 " alt="" src="{{issue.creator_info.avatar}}">
                                        <span id="author" class="author has-tooltip" title="@{{issue.creator_info.username}}" data-placement="top">{{issue.creator_info.display_name}}</span></a>
                                    <a class="author_link  hidden-sm hidden-md hidden-lg" href="/sven">
                                        <span class="author">@{{issue.creator_info.username}}</span></a>
                                </strong>
                                于
                                <time class="js-timeago js-timeago-render" title="" >{{issue.create_time}}
                                </time>
                                创建
                            </div>
                        </script>
                    </div>
                    <div class="issuable-actions" id="issue-actions">
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="btn-edit" type="button" class="btn btn-default"><i class="fa fa-edit"></i> 编辑</button>
                            <button id="btn-copy" type="button" class="btn btn-default"><i class="fa fa-copy"></i> 复制</button>
                            <button id="btn-assign" type="button" class="btn btn-default"><i class="fa fa-arrow-down"></i> 分配</button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    更多
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a id="btn-vote" href="#">投票</a></li>
                                    <li><a id="btn-watch" href="#">关注</a></li>

                                </ul>
                            </div>
                        </div>
                        <div style="margin-left: 20px" class="btn-group" role="group" aria-label="...">
                            <button id="btn-start" type="button" class="btn btn-default">开始进行</button>
                            <button id="btn-over" type="button" class="btn btn-default">结束</button>
                            <button id="btn-review" type="button" class="btn btn-default">回顾</button>
                        </div>
                        <div style="margin-left: 20px" class="btn-group" role="group" aria-label="...">
                            <button id="btn-reopen" type="button" class="btn  btn-reopen">重新打开</button>
                            <button id="btn-close" type="button" class="btn btn-default">关闭</button>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    管理
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">管理关注</a></li>
                                    <li><a href="#">查看投票</a></li>
                                    <li><a id="btn-move" href="#">移动</a></li>
                                    <li><a id="btn-delete" href="#">删除</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="issue_fields">

                </div>
                <script type="text/html" id="issue_fields_tpl">
                    <h3 class="page-title">
                        问题详情
                    </h3>
                    <hr>
                    <div class="row">
                        <div class=" form-group col-lg-6">
                            <div class="form-group issue-assignee">
                                <label class="control-label col-sm-2" >类型:</label>
                                <div class=" col-sm-10">
                                    <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-2"  >解决结果:</label>
                                <div class="col-sm-10">
                                    <span style=" color: {{issue.resolve_info.color}}" >{{issue.resolve_info.name}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 ">
                            <label class="control-label col-sm-2"  >状态:</label>
                            <div class="col-sm-10">
                                <span>{{issue.status_info.name}}</span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label col-sm-2" for="issue_label_ids">优先级:</label>
                            <div class="col-sm-10">
                                <span class="label " style="color:{{issue.priority_info.status_color}}">{{issue.priority_info.name}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6 ">
                            <label class="control-label col-sm-2" for="issue_milestone_id">影响版本:</label>
                            <div class="col-sm-10">
                                {{#issue.effect_version_names}}
                                <span>{{name}}</span>&nbsp;
                                {{/issue.effect_version_names}}
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label col-sm-2" for="issue_label_ids">解决版本:</label>
                            <div class="col-sm-10">
                                {{#issue.fix_version_names}}
                                <span>{{name}}</span>&nbsp;
                                {{/issue.fix_version_names}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 ">
                            <label class="control-label col-sm-2" for="issue_milestone_id">模块:</label>
                            <div class="col-sm-10">
                                <span>{{issue.module_name}}</span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label col-sm-2" for="issue_label_ids">标签:</label>
                            <div class="col-sm-10">
                                {{#issue.labels_names}}
                                <a class="label-link" href="/issue/main/?label={{name}}">
                                    <span class="label color-label has-tooltip" style="background-color: {{bg_color}}; color: {{color}}"
                                          title="" data-container="body" data-original-title="red waring">{{title}}</span>
                                </a>
                                {{/issue.labels_names}}
                            </div>
                        </div>
                    </div>
                </script>



                <div class="issue-details issuable-details">
                    <div id="detail-page-description" class="content-block detail-page-description">
                        <div class="issue-title-data hidden" data-endpoint="/ismond/xphp/issues/1/rendered_title" data-initial-title="{{issue.summary}}"></div>
                        <script type="text/html" id="detail-page-description_tpl">
                            <div class="issue-title-data hidden" data-endpoint="/" data-initial-title="{{issue.summary}}"></div>
                            <h2 class="title">{{issue.summary}}</h2>
                            <div class="description js-task-list-container is-task-list-enabled">
                                <div class="wiki">
                                    <p dir="auto">{{issue.description}}</p></div>
                                <textarea class="hidden js-task-list-field">{{issue.description}}</textarea>
                            </div>

                            <small class="edited-text"><span>最后修改于 </span>
                                <time class="js-timeago issue_edited_ago js-timeago-render" title=""
                                      datetime="{{issue.updated_text}}" data-toggle="tooltip"
                                      data-placement="bottom" data-container="body" data-original-title="{{issue.updated}}">{{issue.updated_text}}</time>
                            </small>
                        </script>
                    </div>
                    <section class="issuable-discussion">
                        <div id="notes">
                            <ul class="notes main-notes-list timeline" id="notes-list">
                                <li class="note note-row-111 system-note timeline-entry" data-author-id="15" data-note-id="111" id="note_111">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M672 1472q0-40-28-68t-68-28-68 28-28 68 28 68 68 28 68-28 28-68zm0-1152q0-40-28-68t-68-28-68 28-28 68 28 68 68 28 68-28 28-68zm640 128q0-40-28-68t-68-28-68 28-28 68 28 68 68 28 68-28 28-68zm96 0q0 52-26 96.5t-70 69.5q-2 287-226 414-68 38-203 81-128 40-169.5 71t-41.5 100v26q44 25 70 69.5t26 96.5q0 80-56 136t-136 56-136-56-56-136q0-52 26-96.5t70-69.5v-820q-44-25-70-69.5t-26-96.5q0-80 56-136t136-56 136 56 56 136q0 52-26 96.5t-70 69.5v497q54-26 154-57 55-17 87.5-29.5t70.5-31 59-39.5 40.5-51 28-69.5 8.5-91.5q-44-25-70-69.5t-26-96.5q0-80 56-136t136-56 136 56 56 136z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">created branch
                                                                    <a href="http://192.168.3.213/ismond/xphp/compare/master...1-inword" data-original="&lt;code&gt;1-inword&lt;/code&gt;" data-link="true" data-project="31" data-commit-range="2f1269457c20e93e6a02b515384753e3ec862d24...2f1269457c20e93e6a02b515384753e3ec862d24" data-reference-type="commit_range" title="" class="gfm gfm-commit_range has-tooltip">
                                                                        <code>1-inword</code></a>
                                                                </p>
                                                            </span>
                                                    <a href="#note_111">
                                                        <time class="js-timeago note-created-ago" title="Oct 19, 2017 10:56am" datetime="2017-10-19T10:56:46Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Oct 19, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">created branch
                                                        <a href="http://192.168.3.213/ismond/xphp/compare/master...1-inword" data-original="&lt;code&gt;1-inword&lt;/code&gt;" data-link="true" data-project="31" data-commit-range="2f1269457c20e93e6a02b515384753e3ec862d24...2f1269457c20e93e6a02b515384753e3ec862d24" data-reference-type="commit_range" title="" class="gfm gfm-commit_range has-tooltip">
                                                            <code>1-inword</code></a>
                                                    </p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/111/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-112 system-note timeline-entry" data-author-id="15" data-note-id="112" id="note_112">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 7c0-3.866 3.142-7 7-7 3.866 0 7 3.142 7 7 0 3.866-3.142 7-7 7-3.866 0-7-3.142-7-7z" />
                                                <path d="M1 7c0 3.309 2.69 6 6 6 3.309 0 6-2.69 6-6 0-3.309-2.69-6-6-6-3.309 0-6 2.69-6 6z" fill="#FFF" />
                                                <rect x="3.36" y="6.16" width="7.28" height="1.68" rx=".84" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">closed</p></span>
                                                    <a href="#note_112">
                                                        <time class="js-timeago note-created-ago" title="Oct 31, 2017 4:50am" datetime="2017-10-31T04:50:26Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Oct 31, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">closed</p></div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/112/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-113 timeline-entry" data-author-id="15" data-editable data-note-id="113" id="note_113">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <a href="/sven">
                                                <img alt="" class="avatar s40" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png" /></a>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>commented
                                                    <a href="#note_113">
                                                        <time class="js-timeago note-created-ago" title="Oct 31, 2017 8:59am" datetime="2017-10-31T08:59:27Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Oct 31, 2017</time></a>
                                                </div>
                                                <div class="note-actions">
                                                    <span class="note-role">Master</span>
                                                    <a title="Award Emoji" class="note-action-button note-emoji-button js-add-award js-note-emoji" data-position="right" href="#">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                        <span class="link-highlight award-control-icon-neutral">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                </span>
                                                        <span class="link-highlight award-control-icon-positive">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                </span>
                                                        <span class="link-highlight award-control-icon-super-positive">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                </span>
                                                    </a>
                                                    <a title="Edit comment" class="note-action-button js-note-edit" href="#">
                                                        <i class="fa fa-pencil link-highlight"></i>
                                                    </a>
                                                    <a title="Remove comment" data-confirm="Are you sure you want to remove this comment?" class="note-action-button js-note-delete danger" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/notes/113">
                                                        <i class="fa fa-trash-o danger-highlight"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="js-task-list-container note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">
                                                        <a class="no-attachment-icon" href="http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg" target="_blank" rel="noopener noreferrer">
                                                            <img src="http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg" alt="28186ee2d4c9536d2e009848b96765e6"></a>
                                                    </p>
                                                </div>
                                                <div class="original-note-content hidden" data-post-url="/ismond/xphp/notes/113" data-target-id="1" data-target-type="issue">![28186ee2d4c9536d2e009848b96765e6](/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg)</div>
                                                <textarea class="hidden js-task-list-field original-task-list" data-update-url="/ismond/xphp/notes/113">![28186ee2d4c9536d2e009848b96765e6](/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg)</textarea>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/113/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-114 system-note timeline-entry" data-author-id="15" data-note-id="114" id="note_114">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M384 448q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm1067 576q0 53-37 90l-491 492q-39 37-91 37-53 0-90-37l-715-716q-38-37-64.5-101t-26.5-117v-416q0-52 38-90t90-38h416q53 0 117 26.5t102 64.5l715 714q37 39 37 91zm384 0q0 53-37 90l-491 492q-39 37-91 37-36 0-59-14t-53-45l470-470q37-37 37-90 0-52-37-91l-715-714q-38-38-102-64.5t-117-26.5h224q53 0 117 26.5t102 64.5l715 714q37 39 37 91z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">added
                                                                    <a href="/ismond/xphp/issues?label_name=Error" data-original="~9" data-link="false" data-project="31" data-label="9" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                                        <span class="label color-label has-tooltip" style="background-color: #FF0000; color: #FFFFFF" title="red waring" data-container="body">Error</span></a>
                                                                    <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                                        <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>
                                                                    <a href="/ismond/xphp/issues?label_name=Warn" data-original="~10" data-link="false" data-project="31" data-label="10" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                                        <span class="label color-label has-tooltip" style="background-color: #F0AD4E; color: #FFFFFF" title="Warning" data-container="body">Warn</span></a>labels</p>
                                                            </span>
                                                    <a href="#note_114">
                                                        <time class="js-timeago note-created-ago" title="Nov 3, 2017 6:35am" datetime="2017-11-03T06:35:34Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 03, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">added
                                                        <a href="/ismond/xphp/issues?label_name=Error" data-original="~9" data-link="false" data-project="31" data-label="9" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                            <span class="label color-label has-tooltip" style="background-color: #FF0000; color: #FFFFFF" title="red waring" data-container="body">Error</span></a>
                                                        <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                            <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>
                                                        <a href="/ismond/xphp/issues?label_name=Warn" data-original="~10" data-link="false" data-project="31" data-label="10" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                            <span class="label color-label has-tooltip" style="background-color: #F0AD4E; color: #FFFFFF" title="Warning" data-container="body">Warn</span></a>labels</p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/114/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-115 system-note timeline-entry" data-author-id="15" data-note-id="115" id="note_115">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M384 448q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm1067 576q0 53-37 90l-491 492q-39 37-91 37-53 0-90-37l-715-716q-38-37-64.5-101t-26.5-117v-416q0-52 38-90t90-38h416q53 0 117 26.5t102 64.5l715 714q37 39 37 91zm384 0q0 53-37 90l-491 492q-39 37-91 37-36 0-59-14t-53-45l470-470q37-37 37-90 0-52-37-91l-715-714q-38-38-102-64.5t-117-26.5h224q53 0 117 26.5t102 64.5l715 714q37 39 37 91z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">removed
                                                                    <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                                        <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>label</p>
                                                            </span>
                                                    <a href="#note_115">
                                                        <time class="js-timeago note-created-ago" title="Nov 3, 2017 7:08am" datetime="2017-11-03T07:08:02Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 03, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">removed
                                                        <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                            <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>label</p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/115/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-116 system-note timeline-entry" data-author-id="15" data-note-id="116" id="note_116">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M384 448q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm1067 576q0 53-37 90l-491 492q-39 37-91 37-53 0-90-37l-715-716q-38-37-64.5-101t-26.5-117v-416q0-52 38-90t90-38h416q53 0 117 26.5t102 64.5l715 714q37 39 37 91zm384 0q0 53-37 90l-491 492q-39 37-91 37-36 0-59-14t-53-45l470-470q37-37 37-90 0-52-37-91l-715-714q-38-38-102-64.5t-117-26.5h224q53 0 117 26.5t102 64.5l715 714q37 39 37 91z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">added
                                                                    <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                                        <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>label</p>
                                                            </span>
                                                    <a href="#note_116">
                                                        <time class="js-timeago note-created-ago" title="Nov 3, 2017 7:08am" datetime="2017-11-03T07:08:25Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 03, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">added
                                                        <a href="/ismond/xphp/issues?label_name=Success" data-original="~11" data-link="false" data-project="31" data-label="11" data-reference-type="label" title="" class="gfm gfm-label has-tooltip">
                                                            <span class="label color-label has-tooltip" style="background-color: #69D100; color: #FFFFFF" title="" data-container="body">Success</span></a>label</p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/116/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-120 system-note timeline-entry" data-author-id="15" data-note-id="120" id="note_120">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 7c0-3.866 3.142-7 7-7 3.866 0 7 3.142 7 7 0 3.866-3.142 7-7 7-3.866 0-7-3.142-7-7z" />
                                                <path d="M1 7c0 3.309 2.69 6 6 6 3.309 0 6-2.69 6-6 0-3.309-2.69-6-6-6-3.309 0-6 2.69-6 6z" fill="#FFF" />
                                                <path d="M7 9.219a2.218 2.218 0 1 0 0-4.436A2.218 2.218 0 0 0 7 9.22zm0 1.12a3.338 3.338 0 1 1 0-6.676 3.338 3.338 0 0 1 0 6.676z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">reopened</p></span>
                                                    <a href="#note_120">
                                                        <time class="js-timeago note-created-ago" title="Nov 22, 2017 11:01am" datetime="2017-11-22T11:01:18Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 22, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">reopened</p></div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/120/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-121 system-note timeline-entry" data-author-id="15" data-note-id="121" id="note_121">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 7c0-3.866 3.142-7 7-7 3.866 0 7 3.142 7 7 0 3.866-3.142 7-7 7-3.866 0-7-3.142-7-7z" />
                                                <path d="M1 7c0 3.309 2.69 6 6 6 3.309 0 6-2.69 6-6 0-3.309-2.69-6-6-6-3.309 0-6 2.69-6 6z" fill="#FFF" />
                                                <rect x="3.36" y="6.16" width="7.28" height="1.68" rx=".84" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">closed</p></span>
                                                    <a href="#note_121">
                                                        <time class="js-timeago note-created-ago" title="Nov 22, 2017 11:01am" datetime="2017-11-22T11:01:19Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 22, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">closed</p></div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/121/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="note note-row-122 system-note timeline-entry" data-author-id="15" data-note-id="122" id="note_122">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1024 544v448q0 14-9 23t-23 9h-320q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h224v-352q0-14 9-23t23-9h64q14 0 23 9t9 23zm416 352q0-148-73-273t-198-198-273-73-273 73-198 198-73 273 73 273 198 198 273 73 273-73 198-198 73-273zm224 0q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z" /></svg>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="note-header">
                                                <a class="visible-xs" href="/sven">@sven</a>
                                                <a class="author_link hidden-xs " href="/sven">
                                                    <span class="author ">韦朝夺</span></a>
                                                <div class="note-headline-light">
                                                    <span class="hidden-xs">@sven</span>
                                                    <span class="system-note-message">
                                                                <p dir="auto">changed milestone to
                                                                    <a href="/ismond/xphp/milestones/1" data-original="%1" data-link="false" data-project="31" data-milestone="1" data-reference-type="milestone" title="" class="gfm gfm-milestone has-tooltip">New Milestone</a></p>
                                                            </span>
                                                    <a href="#note_122">
                                                        <time class="js-timeago note-created-ago" title="Nov 22, 2017 11:03am" datetime="2017-11-22T11:03:15Z" data-toggle="tooltip" data-placement="bottom" data-container="body">Nov 22, 2017</time></a>
                                                </div>
                                            </div>
                                            <div class="note-body">
                                                <div class="note-text md">
                                                    <p dir="auto">changed milestone to
                                                        <a href="/ismond/xphp/milestones/1" data-original="%1" data-link="false" data-project="31" data-milestone="1" data-reference-type="milestone" title="" class="gfm gfm-milestone has-tooltip">New Milestone</a></p>
                                                </div>
                                                <div class="note-awards">
                                                    <div class="awards hidden js-awards-block" data-award-url="http://192.168.3.213/ismond/xphp/notes/122/toggle_award_emoji">
                                                        <div class="award-menu-holder js-award-holder">
                                                            <button aria-label="Add emoji" class="btn award-control has-tooltip js-add-award" data-placement="bottom" data-title="Add emoji" type="button">
                                                                        <span class="award-control-icon award-control-icon-neutral">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369.721.721 0 0 1 .568.047.715.715 0 0 1 .37.445c.195.625.556 1.131 1.084 1.518A2.93 2.93 0 0 0 9 12.75a2.93 2.93 0 0 0 1.775-.58 2.913 2.913 0 0 0 1.084-1.518.711.711 0 0 1 .375-.445.737.737 0 0 1 .575-.047c.195.063.34.186.433.37.094.183.11.372.047.568zM7.5 6c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06-.292.294-.646.44-1.06.44-.414 0-.768-.146-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06.292-.294.646-.44 1.06-.44.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568h.001zM7.5 6c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 6 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 4.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 6 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm6 0c0 .414-.146.768-.44 1.06A1.44 1.44 0 0 1 12 7.5a1.44 1.44 0 0 1-1.06-.44A1.445 1.445 0 0 1 10.5 6c0-.414.146-.768.44-1.06A1.44 1.44 0 0 1 12 4.5c.414 0 .768.146 1.06.44.294.292.44.646.44 1.06zm3 3a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6c.92.397 1.91.6 2.912.598a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39c.397-.92.6-1.91.598-2.912zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="nonzero" /></svg>
                                                                        </span>
                                                                <span class="award-control-icon award-control-icon-super-positive">
                                                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M13.29 11.098a4.328 4.328 0 0 1-1.618 2.285c-.79.578-1.68.867-2.672.867-.992 0-1.883-.29-2.672-.867a4.328 4.328 0 0 1-1.617-2.285.721.721 0 0 1 .047-.569.715.715 0 0 1 .445-.369c.195-.062 7.41-.062 7.606 0 .195.063.34.186.433.37.094.183.11.372.047.568zM14 6.37c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm-6.5 0c0 .398-.04.755-.513.755-.473 0-.498-.272-1.237-.272-.74 0-.74.215-1.165.215-.425 0-.585-.3-.585-.698 0-.397.17-.736.513-1.017.341-.281.754-.422 1.237-.422.483 0 .896.14 1.237.422.342.28.513.62.513 1.017zm9 2.63a7.29 7.29 0 0 0-.598-2.912 7.574 7.574 0 0 0-1.6-2.39 7.574 7.574 0 0 0-2.39-1.6A7.29 7.29 0 0 0 9 1.5a7.29 7.29 0 0 0-2.912.598 7.574 7.574 0 0 0-2.39 1.6 7.574 7.574 0 0 0-1.6 2.39A7.29 7.29 0 0 0 1.5 9c0 1.016.2 1.986.598 2.912a7.574 7.574 0 0 0 1.6 2.39 7.574 7.574 0 0 0 2.39 1.6A7.29 7.29 0 0 0 9 16.5a7.29 7.29 0 0 0 2.912-.598 7.574 7.574 0 0 0 2.39-1.6 7.574 7.574 0 0 0 1.6-2.39A7.29 7.29 0 0 0 16.5 9zM18 9a8.804 8.804 0 0 1-1.207 4.518 8.96 8.96 0 0 1-3.275 3.275A8.804 8.804 0 0 1 9 18a8.804 8.804 0 0 1-4.518-1.207 8.96 8.96 0 0 1-3.275-3.275A8.804 8.804 0 0 1 0 9c0-1.633.402-3.139 1.207-4.518a8.96 8.96 0 0 1 3.275-3.275A8.804 8.804 0 0 1 9 0c1.633 0 3.139.402 4.518 1.207a8.96 8.96 0 0 1 3.275 3.275A8.804 8.804 0 0 1 18 9z" fill-rule="evenodd" /></svg>
                                                                        </span>
                                                                <i class="fa fa-spinner fa-spin award-control-icon award-control-icon-loading"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="system-note-commit-list-toggler">Toggle commit list
                                                    <i class="fa fa-angle-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="note-edit-form">
                                <form class="edit-note common-note-form js-quick-submit" action="#" accept-charset="UTF-8" method="post">
                                    <input name="utf8" type="hidden" value="&#x2713;" />
                                    <input type="hidden" name="_method" value="put" />
                                    <input type="hidden" name="authenticity_token" value="yChspuoYPe1is883VTkD9m986+hZNxiXIekXco4arXoJmVyONgPiK8vHYJg2CZsh712fRpPpyu07ZUcmXLNSQA==" />
                                    <input type="hidden" name="target_id" id="target_id" value="" class="js-form-target-id" />
                                    <input type="hidden" name="target_type" id="target_type" value="" class="js-form-target-type" />
                                    <div class="md-area">
                                        <div class="md-header">
                                            <ul class="nav-links clearfix">
                                                <li class="active">
                                                    <a class="js-md-write-button" href="#md-write-holder" tabindex="-1">Write</a></li>
                                                <li>
                                                    <a class="js-md-preview-button" href="#md-preview-holder" tabindex="-1">Preview</a></li>
                                                <li class="pull-right">
                                                    <div class="toolbar-group">
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="**" data-container="body" title="Add bold text" aria-label="Add bold text">
                                                            <i class="fa fa-bold fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="*" data-container="body" title="Add italic text" aria-label="Add italic text">
                                                            <i class="fa fa-italic fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="&gt; " data-md-prepend="true" data-container="body" title="Insert a quote" aria-label="Insert a quote">
                                                            <i class="fa fa-quote-right fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="`" data-md-block="```" data-container="body" title="Insert code" aria-label="Insert code">
                                                            <i class="fa fa-code fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="* " data-md-prepend="true" data-container="body" title="Add a bullet list" aria-label="Add a bullet list">
                                                            <i class="fa fa-list-ul fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="1. " data-md-prepend="true" data-container="body" title="Add a numbered list" aria-label="Add a numbered list">
                                                            <i class="fa fa-list-ol fa-fw"></i>
                                                        </button>
                                                        <button type="button" class="toolbar-btn js-md has-tooltip hidden-xs" tabindex="-1" data-md-tag="* [ ] " data-md-prepend="true" data-container="body" title="Add a task list" aria-label="Add a task list">
                                                            <i class="fa fa-check-square-o fa-fw"></i>
                                                        </button>
                                                    </div>
                                                    <div class="toolbar-group">
                                                        <button aria="{:label=&gt;&quot;Go full screen&quot;}" class="toolbar-btn js-zen-enter has-tooltip" data-container="body" tabindex="-1" title="Go full screen" type="button">
                                                            <i class="fa fa-arrows-alt fa-fw"></i>
                                                        </button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="md-write-holder">
                                            <div class="zen-backdrop">
                                                <textarea name="note[note]" id="note_note" class="note-textarea js-note-text js-task-list-field js-gfm-input js-autosize markdown-area" placeholder="Write a comment or drag your files here..."></textarea>
                                                <a class="zen-control zen-control-leave js-zen-leave" href="#">
                                                    <i class="fa fa-compress"></i>
                                                </a>
                                            </div>
                                            <div class="comment-toolbar clearfix">
                                                <div class="toolbar-text">
                                                    <a target="_blank" tabindex="-1" href="/help/user/markdown">Markdown</a>is supported</div>
                                                <button class="toolbar-button markdown-selector" tabindex="-1" type="button">
                                                    <i class="fa fa-file-image-o toolbar-button-icon"></i>Attach a file</button>
                                            </div>
                                        </div>
                                        <div class="hide js-md-preview md md-preview md-preview-holder"></div>
                                        <div class="referenced-users hide">
                                                    <span>
                                                        <i class="fa fa-exclamation-triangle"></i>You are about to add
                                                        <strong>
                                                            <span class="js-referenced-users-count">0</span>people</strong>to the discussion. Proceed with caution.</span></div>
                                    </div>
                                    <div class="note-form-actions clearfix">
                                        <div class="settings-message note-edit-warning js-edit-warning">Finish editing this message first!</div>
                                        <input type="submit" name="commit" value="Save comment" class="btn btn-nr btn-save js-comment-button" />
                                        <button class="btn btn-nr btn-cancel note-edit-cancel" type="button">Cancel</button></div>
                                </form>
                            </div>
                            <ul class="notes notes-form timeline">
                                <li class="timeline-entry">
                                    <div class="flash-container timeline-content"></div>
                                    <div class="timeline-icon hidden-xs hidden-sm">
                                        <a class="author_link" href="/sven">
                                            <img alt="@sven" class="avatar s40" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png" /></a>
                                    </div>
                                    <div class="timeline-content timeline-content-form">
                                        <form data-type="json" class="new-note js-new-note-form js-quick-submit common-note-form"
                                              data-noteable-iid="1"
                                              enctype="multipart/form-data"
                                              action="/issue/main/comment"
                                              accept-charset="UTF-8" data-remote="true" method="post">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <input type="hidden" name="authenticity_token" value="ETUcTwwMUnEVanP70JYE9ht4DXrcy5fmXx5a7la+Af7QhCxn0BeNt7we3FSzppwhm1l51BYVRZxFkgq6hBf+xA==" />
                                            <input type="hidden" name="view" id="view" value="inline" />

                                            <div id="editor_md">
                                                <textarea style="display:none;"></textarea>
                                            </div>

                                            <div class="note-form-actions clearfix">
                                                <div class="pull-left btn-group append-right-10 comment-type-dropdown js-comment-type-dropdown">
                                                    <input class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button" type="submit" value="Comment">
                                                    <button name="button" type="button" class="btn btn-nr dropdown-toggle comment-btn js-note-new-discussion js-disable-on-submit" data-dropdown-trigger="#resolvable-comment-menu" aria-label="Open comment type dropdown">
                                                        <i class="fa fa-caret-down toggle-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" data-dropdown id="resolvable-comment-menu">
                                                        <li class="droplab-item-selected" data-close-text="Comment &amp; close issue" data-reopen-text="Comment &amp; reopen issue" data-submit-text="Comment" data-value="" id="comment">
                                                            <a href="#">
                                                                <i class="fa fa-check"></i>
                                                                <div class="description">
                                                                    <strong>Comment</strong>
                                                                    <p>Add a general comment to this issue.</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="divider droplab-item-ignore"></li>
                                                        <li data-close-text="Start discussion &amp; close issue" data-reopen-text="Start discussion &amp; reopen issue" data-submit-text="Start discussion" data-value="DiscussionNote" id="discussion">
                                                            <a href="#">
                                                                <i class="fa fa-check"></i>
                                                                <div class="description">
                                                                    <strong>Start discussion</strong>
                                                                    <p>Discuss a specific suggestion or question.</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a data-no-turbolink="true" data-original-text="Reopen issue" data-alternative-text="Comment &amp; reopen issue" class="btn btn-nr btn-reopen btn-comment js-note-target-reopen " title="Reopen issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=reopen">Reopen issue</a>
                                                <a data-no-turbolink="true" data-original-text="Close issue" data-alternative-text="Comment &amp; close issue" class="btn btn-nr btn-close btn-comment js-note-target-close hidden" title="Close issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close issue</a>
                                                <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel" role="button">Discard draft</a></div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                            <script>var notes = new Notes("/ismond/xphp/noteable/issue/1/notes", [111, 112, 113, 114, 115, 116, 120, 121, 122], 1521786903, "inline")</script></div>
                    </section>
                </div>
                <aside  aria-live="polite" class="js-right-sidebar right-sidebar right-sidebar-expanded" data-offset-top="102" data-spy="affix">
                    <div class="issuable-sidebar">
                        <div class="block issuable-sidebar-header">
                            <span class="issuable-header-text hide-collapsed pull-left hidden">
                                用户
                            </span>
                            <a aria-label="Toggle sidebar" class="gutter-toggle pull-right js-sidebar-toggle" href="#" role="button">
                                <i aria-hidden="true" class="fa fa-angle-double-right"></i>
                            </a>
                            <a  href="/issue/main" aria-label="Back issue list" class="btn btn-default issuable-header-btn  pull-left"   title="Back issue list"  >
                                <i aria-hidden="true" class="fa fa-arrow-left"></i><span class="issuable-todo-inner js-issuable-todo-inner">返回问题列表</span>

                            </a>

                        </div>
                        <form class="issuable-context-form inline-update js-issuable-update" id="edit_issue_1"
                              action="/issue/main/patch" accept-charset="UTF-8" data-remote="true" method="post">
                            <input name="utf8" type="hidden" value="&#x2713;" />
                            <input type="hidden" name="_method" value="post" />


                            <div class="block assignee">
                                <div class="sidebar-collapsed-icon sidebar-collapsed-user" data-container="body" data-placement="left" data-toggle="tooltip" title="<?=$issue['assignee_info']['display_name']?>">
                                    <a class="author_link  " href="/sven">
                                        <img width="24" class="avatar avatar-inline s24 " alt="" src="<?=$issue['assignee_info']['avatar']?>">
                                        <span class="author "><?=$issue['assignee_info']['display_name']?></span></a>
                                </div>
                                <div class="title hide-collapsed">Assignee
                                    <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                    <a class="edit-link pull-right" href="#">Edit</a></div>
                                <div class="value hide-collapsed" style="">
                                    <a class="author_link bold " href="/<?=$issue['assignee_info']['username']?>">
                                        <img width="32" class="avatar avatar-inline s32 " alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                        <span class="author "><?=$issue['assignee_info']['display_name']?></span>
                                        <span class="username">@<?=$issue['assignee_info']['username']?></span></a>
                                </div>
                                <div class="selectbox hide-collapsed">
                                    <input value="15" id="issue_assignee_id" type="hidden" name="issue[assignee_id]" />
                                    <div class="dropdown ">
                                        <button class="dropdown-menu-toggle js-user-search js-author-search"
                                                type="button"
                                                data-first-user="<?=$issue['assignee_info']['username']?>"
                                                data-current-user="true"
                                                data-project-id="<?=$project_id?>"
                                                data-author-id="<?=$issue['assignee_info']['uid']?>"
                                                data-field-name="assignee_id"
                                                data-issue-update="/issue/main/patch/<?=$issue_id?>"
                                                data-ability-name="issue"
                                                data-null-user="true"
                                                data-toggle="dropdown"
                                                aria-expanded="false">
                                            <span class="dropdown-toggle-text ">Select assignee</span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author">
                                            <div class="dropdown-title">
                                                <span>Assign to</span>
                                                <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                    <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                </button>
                                            </div>
                                            <div class="dropdown-input">
                                                <input type="search" id="" class="dropdown-input-field" placeholder="Search users" autocomplete="off" />
                                                <i class="fa fa-search dropdown-input-search"></i>
                                                <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                            </div>
                                            <div class="dropdown-content "></div>
                                            <div class="dropdown-loading">
                                                <i class="fa fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="block milestone">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" class="fa fa-clock-o"></i>
                                        <small>None</small></div>
                                    <div class="title hide-collapsed "><span class="bold">Milestone</span>
                                        <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                        <a class="edit-link pull-right" href="#"><small>Edit</small></a></div>
                                    <div class="value hide-collapsed">
                                        <small class="no-value">None</small></div>
                                    <div class="selectbox hide-collapsed">
                                        <input type="hidden" name="issue[milestone_id]" />
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-milestone-select js-extra-options"
                                                    type="button"
                                                    data-show-no="true"
                                                    data-field-name="issue[milestone_id]"
                                                    data-project-id="<?=$project_id?>"
                                                    data-issuable-id="<?=$issue_id?>"
                                                    data-milestones="/api/v4/milestones.json"
                                                    data-ability-name="issue"
                                                    data-issue-update="/issue/main/patch/<?=$issue_id?>"
                                                    data-use-id="true"
                                                    data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Milestone</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-selectable">
                                                <div class="dropdown-title">
                                                    <span>Assign milestone</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field" placeholder="Search milestones" autocomplete="off" />
                                                    <i class="fa fa-search dropdown-input-search"></i>
                                                    <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                </div>
                                                <div class="dropdown-content "></div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            <div class="title hide-collapsed " style="margin-top: 10px"><span class="bold">时间</span>
                            </div>
                            <div class="block due_date" style="border-bottom: 0px solid #e8e8e8;padding: 10px 0;">
                                <div class="sidebar-collapsed-icon">
                                    <i aria-hidden="true" class="fa fa-calendar"></i>
                                    <span class="js-due-date-sidebar-value"><?=$issue['start_date']?></span></div>
                                <div class="title hide-collapsed"><small  >开始时间</small>
                                    <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                    <a class="edit-link2 pull-right" href="#" style="color: rgba(0,0,0,0.85);"><small id="a_start_date_edit">Edit</small></a></div>
                                <div class="value hide-collapsed">
                                    <span class="value-content">
                                            <small class="no-value" id="small_start_date" ><?=$issue['start_date']?></small>

                                    </span>
                                    <span class="hidden js-remove-due-date-holder no-value">-
                                    <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                    </span>
                                </div>

                            </div>
                            <div class="block due_date">
                                <div class="sidebar-collapsed-icon">
                                    <i aria-hidden="true" class="fa fa-calendar"></i>
                                    <small class="js-due-date-sidebar-value"><?=$issue['due_date']?></small></div>
                                <div class="title hide-collapsed"><small>截止时间</small>
                                    <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                    <a class="edit-link2 pull-right" href="#"  style="color: rgba(0,0,0,0.85);"><small id="a_due_date_edit">Edit</small></a></div>
                                <div class="value hide-collapsed">
                                  <span class="value-content">
                                    <small class="no-value" id="small_due_date" ><?=$issue['due_date']?></small>
                                  </span>
                                    <span class="hidden js-remove-due-date-holder no-value">-
                                        <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                    </span>
                                </div>

                            </div>
                            <div class="block participants">
                                <div class="sidebar-collapsed-icon">
                                    <i class="fa fa-users"></i>
                                    <span>1</span></div>
                                <div class="title hide-collapsed"><span class="bold">敏捷看板</span></div>
                                <div class="hide-collapsed participants-list">
                                    <div class="participants-author js-participants-author">
                                        <a class="author_link has-tooltip" title="韦朝夺" data-container="body" href="/sven">
                                            <img width="24" class="avatar avatar-inline s24 " alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png" /></a>
                                    </div>
                                </div>
                            </div>

                            <div class="block light subscription" data-url="/ismond/xphp/issues/1/toggle_subscription">
                                <div class="sidebar-collapsed-icon">
                                    <i aria-hidden="true" class="fa fa-rss"></i>
                                </div>
                                <span class="issuable-header-text hide-collapsed pull-left">Notifications</span>
                                <button class="btn btn-default pull-right js-subscribe-button issuable-subscribe-button hide-collapsed" type="button">
                                    <span>Unsubscribe</span></button>
                            </div>
                            <div class="block project-reference">
                                <div class="sidebar-collapsed-icon dont-change-state">
                                    <button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="left" data-container="body" data-title="Copy reference to clipboard" data-clipboard-text="ismond/xphp#1" type="button" title="Copy reference to clipboard">
                                        <i aria-hidden="true" class="fa fa-clipboard"></i>
                                    </button>
                                </div>
                                <div class="cross-project-reference hide-collapsed">
                      <span>Reference:
                        <cite title="ismond/xphp#1">ismond/xphp#1</cite></span>
                                    <button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="left" data-container="body" data-title="Copy reference to clipboard" data-clipboard-text="ismond/xphp#1" type="button" title="Copy reference to clipboard">
                                        <i aria-hidden="true" class="fa fa-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<script>var notes = new Notes("/api/v4/notes.json", [111, 112, 113], 1509550115, "inline")</script>
        <script src="<?=ROOT_URL?>gitlab/assets/webpack/issue_show.bundle.js"></script>
        <script>IssuableContext.prototype.PARTICIPANTS_ROW_COUNT = 7;</script>

<script>
        gl.IssuableResource = new gl.SubbableResource('/api/v4/issue_1.json');
        new gl.IssuableTimeTracking("{\"id\":1,\"iid\":1,\"assignee_id\":15,\"author_id\":15,\"description\":\"拼写错误\",\"lock_version\":null,\"milestone_id\":null,\"position\":0,\"state\":\"closed\",\"title\":\"InWord\",\"updated_by_id\":15,\"created_at\":\"2017-10-19T10:56:27.764Z\",\"updated_at\":\"2017-10-31T08:59:27.604Z\",\"deleted_at\":null,\"time_estimate\":0,\"total_time_spent\":0,\"human_time_estimate\":null,\"human_total_time_spent\":null,\"branch_name\":null,\"confidential\":false,\"due_date\":null,\"moved_to_id\":null,\"project_id\":31,\"milestone\":null,\"labels\":[]}");
        new MilestoneSelect('{"full_path":"ismond/xphp"}');
        gl.Subscription.bindAll('.subscription');
        new gl.DueDateSelectors();
        new UsersSelect();
        window.sidebar = new Sidebar();
        </script>

<script>gl.GfmAutoComplete.dataSources = {
        members: "/ismond/xphp/autocomplete_sources/members?type=Issue&type_id=1",
        issues: "/ismond/xphp/autocomplete_sources/issues",
        mergeRequests: "/ismond/xphp/autocomplete_sources/merge_requests",
        labels: "/ismond/xphp/autocomplete_sources/labels",
        milestones: "/ismond/xphp/autocomplete_sources/milestones",
        commands: "/ismond/xphp/autocomplete_sources/commands?type=Issue&type_id=1"
    };

    gl.GfmAutoComplete.setup();
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
    var _issue_id = '<?=$issue_id?>';
    var _cur_project_id = '<?=$project_id?>';

    var $IssueDetail = null;
    var $IssueMain = null;
    var query_str = '<?=$query_str?>';
    var urls = parseURL(window.location.href);
    $(function () {

        $IssueDetail = new IssueDetail({});
        $IssueDetail.fetchIssue(_issue_id);

        $('#btn-copy').bind('click',function () {
            IssueDetail.prototype.copy();
        });

        laydate.render({
            elem: '#small_start_date'
            ,eventElem: '#a_start_date_edit'
            ,trigger: 'click'
            ,done: function(value, date){
                 alert('你选择的日期是：' + value + '\n获得的对象是' + JSON.stringify(date));
             }
        });

        laydate.render({
            elem: '#small_due_date'
            ,eventElem: '#a_due_date_edit'
            ,trigger: 'click'
            ,done: function(value, date){
                alert('你选择的日期是：' + value + '\n获得的对象是' + JSON.stringify(date));
            }
        });

        var testEditor = editormd("editor_md", {
            width: "100%",
            height: 220,
            markdown : "",
            path : '<?= ROOT_URL ?>dev/lib/editor.md/lib/',
            //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为 true
            //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为 true
            //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为 true
            //dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为 0.1
            //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为 #fff
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "/issue/detail/editormd_upload",

            /*
             上传的后台只需要返回一个 JSON 数据，结构如下：
             {
                success : 0 | 1,           // 0 表示上传失败，1 表示上传成功
                message : "提示的信息，上传成功或上传失败及错误信息等。",
                url     : "图片地址"        // 上传成功时才返回
             }
             */
        });



    });



</script>
<style>

    .CodeMirror, .CodeMirror-scroll {
        min-height: 100px;
        max-height: 200px;
    }
</style>


</body>
</html>


</div>