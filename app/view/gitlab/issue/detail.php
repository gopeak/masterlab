<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>

    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/common_vue.bundle.js"></script>
    <script src="<?= ROOT_URL ?>gitlab/assets/webpack/issuable.bundle.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/url_param.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/main.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/form.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/issue/detail.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>" type="text/javascript"></script>
    <link href="<?= ROOT_URL ?>dev/lib/video-js/video-js.min.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/video-js/video.min.js"></script>
    <script>
        window.project_uploads_path = "/issue/main/upload";
        window.preview_markdown_path = "/issue/main/preview_markdown";
    </script>

    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

    <script type="text/javascript" src="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/lib/qtip/dist/jquery.qtip.min.css"/>

    <script src="<?= ROOT_URL ?>dev/lib/simplemde/dist/simplemde.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib//simplemde/dist/simplemde.min.css">

    <!-- Fine Uploader jQuery JS file-->
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dev/lib/fine-uploader/fine-uploader-gallery.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/e-smart-zoom-jquery.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/fine-uploader/jquery.fine-uploader.js"></script>

    <link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/mousetrap/mousetrap.min.js"></script>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/editor.md/css/editormd.css"/>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/marked.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/prettify.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="<?= ROOT_URL ?>dev/lib/editor.md/editormd.js"></script>

    <script src="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.css"/>

    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/issue/detail.css?v=<?=$_version?>"/>

    <style>

        .event-list .event-list-item {
            padding: 16px 0;
            border-bottom: 1px solid #e8e8e8;
            align-items: flex-start;
            display: -ms-flexbox;
            display: flex;
            -ms-flex: 1 1;
            flex: 1 1;
        }

        .event-list .event-list-item:last-child {
            border-bottom: 0;
        }

        .event-list .event-list-item .event-list-item-avatar {
            margin-right: 16px;
        }

        .event-list-item .event-list-item-content {
            -ms-flex: 1 0;
            flex: 1 0;
        }

        .event-list-item-content .event-list-item-title {
            color: rgba(0,0,0,.65);
            margin-bottom: 4px;
            margin-top: 0;
            font-size: 14px;
            line-height: 22px;
            font-weight: normal;
        }

        /*.event-list-item-content .event-list-item-title a {*/
        /*color: #1890ff;*/
        /*}*/

        .event-list-item-content .event-list-item-title a.username {
            color: rgba(0,0,0,.65);
        }

        .event-list-item-content .event-time {
            font-size: 14px;
            line-height: 22px;
            color: rgba(0,0,0,.25);
        }

        .event-list-item-content .event-list-item-title a.item-title {
            font-weight: 300;
            color: #333;
            cursor: pointer;
        }

        .event-list-item-content .event-list-item-title a.item-title:hover{
            text-decoration: none;
            color: #1890ff;
        }

        .event-list-item-content .event-item-info .info-item + .info-item{
            margin-left: 12px;
        }

        .event-list-item-content .event-item-info .info-item.gray {
            color: #999;
        }

        .event-list-item-content .event-list-item-title a.item-name {
            font-size: 14px;
        }

        .member-list {
            margin-left: -12px;
            margin-right: -12px;
        }

        .member-list .member-list-item {
            padding: 12px 24px;
            display: block;
        }

        .member-list .member-list-item a {
            line-height: 24px;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-all;
            white-space: nowrap;
            align-items: flex-start;
            display: -ms-flexbox;
            display: flex;
            -ms-flex: 1 1;
            flex: 1 1;
            height: 24px;
        }

        .member-list-item .member-avatar {
            display: block;
            margin-right: 16px;
        }
    </style>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
<? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

<div class="page-layout page-content-body">
    <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>


    <div class="page-gutter page-with-sidebar right-sidebar-expanded">
        <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>

        <div class="content-wrapper page-with-layout-nav ">
            <div class="alert-wrapper">

                <div class="flash-container flash-container-page">
                </div>

            </div>
            <div class="container-fluid"><!--  small-side -->
                <div class="left-side">
                    <input type="hidden" name="issue_id" id="issue_id" value=""/>
                    <div class="content issue-detail" id="content-body">
                        <div class="detail-pager">
                            <!--<span class="showing">第 <span id="issue_current">1</span>个事项, 共 <span id="issue_total">1</span>个事项</span>-->
                            <a id="prev_issue_link" href="#" class="previous disabled"><i class="fa fa-caret-up"></i></a>
                            <a id="next_issue_link" href="#" class="next disabled"><i class="fa fa-caret-down"></i></a>
                        </div>

                        <div class="clearfix detail-page-header">
                            <div class="issuable-header" id="issuable-header">
                                <script type="text/html" id="issuable-header_tpl">
                                    <a class="btn btn-default pull-right visible-xs-block gutter-toggle issuable-gutter-toggle js-sidebar-toggle"
                                       href="#">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                    <div class="issuable-meta">
                                        <strong class="identifier">事项
                                            <a href="<?= ROOT_URL ?>issue/detail/index/{{issue.id}}"
                                               id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a></strong>
                                        由
                                        <strong>
                                            <a class="author_link  hidden-xs" href="<?=ROOT_URL?>user/profile/{{issue.creator_info.uid}}">
                                                <img id="creator_avatar" width="24" class="avatar avatar-inline s24 " alt=""
                                                     src="{{issue.creator_info.avatar}}">
                                                <span id="author" class="author has-tooltip"
                                                      title="@{{issue.creator_info.username}}" data-placement="top">{{issue.creator_info.display_name}}</span></a>
                                            <a class="author_link  hidden-sm hidden-md hidden-lg" href="<?=ROOT_URL?>user/profile/{{issue.creator_info.uid}}">
                                                <span class="author">@{{issue.creator_info.username}}</span></a>
                                        </strong>
                                        于
                                        <time class="js-time"
                                              datetime="{{issue.created}}"
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              data-container="body"
                                              data-original-title="{{issue.created_text}}">
                                        </time>
                                        创建
                                    </div>
                                </script>
                            </div>
                            <div class="issuable-actions" id="issue-actions">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button id="btn-edit" type="button" class="btn btn-default js-key-edit"><i class="fa fa-edit"></i>
                                        编辑
                                    </button>
                                    <button id="btn-copy" type="button" class="btn btn-default"><i class="fa fa-copy"></i>
                                        复制
                                    </button>
                                    <!--<button id="btn-attachment" type="button" class="btn btn-default"><i class="fa fa-file-image-o"></i> 附件</button>-->
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            状态
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" id="allow_update_status">
                                        </ul>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            更多
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a id="btn-watch" data-followed="" href="#">关注</a></li>
                                            <li><a id="btn-create_subtask"  class="js-key-create"
                                                   data-target="#modal-create-issue" data-toggle="modal"   href="#modal-create-issue">创建子任务</a>
                                               </li>
                                            <!--<li><a id="btn-convert_subtask" href="#">转化为子任务</a></li>-->
                                        </ul>
                                    </div>
                                </div>

                                <div style="margin-left: 20px" class="btn-group" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            解决结果
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" id="allow_update_resolves">
                                        </ul>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            管理
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a id="btn-close" href="#">关闭</a></li>
                                            <li><a id="btn-delete" href="#">删除</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 id="issue_title" class="page-title">

                        </h3>

                        <div id="issue_fields" class="content-block" style="margin-left: 15px">

                        </div>
                        <div id="detail-page-description" class="content-block detail-page-description"
                             style="margin-left: 15px">
                            <div class="issue-title-data hidden" data-endpoint="#"
                                 data-initial-title="{{issue.summary}}"></div>
                            <script type="text/html" id="detail-page-description_tpl">
                                <label>描述:</label>
                                <div class="description js-task-list-container is-task-list-enabled">
                                    <div id="description-view" class="description-view">

                                    </div>
                                    <textarea class="hidden js-task-list-field">{{{issue.description}}}</textarea>
                                </div>

                                <small class="edited-text"><span>最后修改于 </span>
                                    <time class="js-time"
                                          datetime="{{issue.created}}"
                                          data-toggle="tooltip"
                                          data-placement="top"
                                          data-container="body"
                                          data-original-title="{{issue.created_text}}">
                                    </time>
                                </small>
                            </script>
                        </div>

                        <script type="text/html" id="issue_fields_tpl">
                            <div class="row">
                                <div class=" form-group col-lg-6">
                                    <div class="form-group issue-assignee">
                                        <label class="control-label col-sm-2">类型:</label>
                                        <div class=" col-sm-10">
                                            <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">解决结果:</label>
                                        <div class="col-sm-10">
                                            <span style=" color: {{issue.resolve_info.color}}">{{issue.resolve_info.name}}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6 ">
                                    <label class="control-label col-sm-2">状态:</label>
                                    <div class="col-sm-10">
                                        <span class="label label-{{issue.status_info.color}} prepend-left-5">{{issue.status_info.name}}</span>
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
                                    <label class="control-label col-sm-2" for="issue_milestone_id">迭代:</label>
                                    <div class="col-sm-10">
                                        <span>{{issue.sprint_info.name}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label col-sm-2" for="issue_label_ids">运行环境:</label>
                                    <div class="col-sm-10">
                                        {{issue.environment}}
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
                                        <a class="label-link" href="<?= ROOT_URL ?>issue/main/?label={{name}}">
                                            <span class="label color-label has-tooltip"
                                                  style="background-color: {{bg_color}}; color: {{color}}"
                                                  title="" data-container="body"
                                                  data-original-title="red waring">{{title}}</span>
                                        </a>
                                        {{/issue.labels_names}}
                                    </div>
                                </div>
                            </div>
                        </script>


                        <div id="detail-page-attachments" class="content-block" style="border-bottom: 0px; ">
                            <div class="row">
                                <div class="form-group col-sm-10">
                                    <label style="margin-left: 15px">附件:</label>
                                    <input type="hidden" name="params[attachments]" id="attachments" value=""/>
                                    <input type="hidden" name="params[fine_uploader_json]" id="fine_uploader_json"
                                           value=""/>
                                    <div id="issue_attachments_uploder" class="detail_fine_uploader_img" style="margin-left: 20px"></div>
                                </div>
                                <div class="form-group col-sm-2">
                                </div>
                            </div>
                        </div>

                        <div class="issue-details issuable-details">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#dicussion" role="tab" data-toggle="tab">评 论</a></li>
                                <li role="presentation"><a href="#activity" role="tab" data-toggle="tab">活动日志</a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="dicussion">
                                    <section class="issuable-discussion">
                                        <div id="notes">
                                            <ul class="notes main-notes-list timeline" id="timelines_list">

                                            </ul>
                                            <div class="note-edit-form">

                                            </div>
                                            <?php
                                            $display_editor = '';
                                            if(!isset($projectPermArr[\main\app\classes\PermissionLogic::ADD_COMMENTS])){
                                                $display_editor = 'display: none';
                                            }
                                            ?>
                                            <ul class="notes notes-form timeline"  style="<?=$display_editor?>">
                                                <li class="timeline-entry">
                                                    <div class="flash-container timeline-content"></div>
                                                    <div class="timeline-icon hidden-xs hidden-sm">
                                                        <a class="author_link" href="/<?= $user['username'] ?>">
                                                            <img alt="@<?= $user['username'] ?>" class="avatar s40"
                                                                 src="<?= $user['avatar'] ?>"/></a>
                                                    </div>

                                                    <div class="timeline-content timeline-content-form">
                                                        <form data-type="json"
                                                              class="new-note js-quick-submit common-note-form gfm-form js-main-target-form show"
                                                              enctype="multipart/form-data"
                                                              action="<?= ROOT_URL ?>issue/main/comment" accept-charset="UTF-8"
                                                              data-remote="true" method="post">
                                                            <input name="utf8" type="hidden" value="✓">
                                                            <input type="hidden" name="authenticity_token"
                                                                   value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                                                            <input type="hidden" name="view" id="view" value="inline">

                                                            <div id="editor_md">
                                                                <textarea class="hide"></textarea>
                                                            </div>

                                                            <div class="note-form-actions clearfix">
                                                                <input id="btn-comment"
                                                                       class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button js-key-enter"
                                                                       type="button" value="评论">

                                                                <!--                                                    <a id="btn-comment-reopen"-->
                                                                <!--                                                       class="btn btn-nr btn-reopen btn-comment js-note-target-reopen "-->
                                                                <!--                                                       title="Reopen issue" href="#">重新打开</a>-->
                                                                <a data-no-turbolink="true" data-original-text="Close issue"
                                                                   data-alternative-text="Comment &amp; close issue"
                                                                   class="btn btn-nr btn-close btn-comment js-note-target-close hidden"
                                                                   title="Close issue"
                                                                   href="/api/v4/issue_1.json?issue%5Bstate_event%5D=close">关闭
                                                                    issue</a>
                                                                <!--                                                    <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel"-->
                                                                <!--                                                       role="button">弃稿</a>-->
                                                            </div>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </section>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="activity">

                                    <ul  id="activity_wrap" class="event-list" id="panel_activity">
                                    </ul>

                                    <script id="activity_tpl" type="text/html">
                                        {{#activity}}
                                        <li class="event-list-item">
                                            <div class="g-avatar g-avatar-lg event-list-item-avatar">
                                                {{user_html user_id}}
                                            </div>

                                            <div class="event-list-item-content">
                                                <h4 class="event-list-item-title">
                                                    <a href="<?=ROOT_URL?>user/profile/{{user_id}}" class="username">{{user.display_name}}</a>
                                                    <span class="event">
                                                        <a href="javascript:void()">{{action}}</a>
                                                        {{#if_eq type ''}}
                                                            <span href="javascript:void()">{{title}}</span>
                                                        {{/if_eq}}
                                                        {{#if_eq type 'issue'}}
                                                            <span href="javascript:void()">{{title}}</span>
                                                        {{/if_eq}}
                                                        {{#if_eq type 'issue_comment'}}
                                                            <span href="javascript:void()">{{title}}</span>
                                                        {{/if_eq}}
                                                    </span>
                                                </h4>
                                                <time class="event-time js-time" title=""
                                                      datetime="{{time}}"
                                                      data-toggle="tooltip"
                                                      data-placement="top"
                                                      data-container="body"
                                                      data-original-title="{{time_full}}"
                                                      data-tid="449">{{time_text}}
                                                </time>
                                            </div>
                                        </li>
                                        {{/activity}}
                                        <div class="text-center" style="margin-top: .8em;">
                                            <span class="text-center">
                                                    总数:<span id="issue_count">{{total}}</span> 每页显示:<span id="page_size">{{page_size}}</span>
                                            </span>
                                        </div>
                                        <div class="gl-pagination" id="ampagination-activity">

                                        </div>
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>

                    <aside aria-live="polite" class="js-right-sidebar right-sidebar right-sidebar-expanded"
                           data-offset-top="102" data-spy="affix" >
                        <div class="issuable-sidebar">
                            <div class="block issuable-sidebar-header">
                                <span class="issuable-header-text hide-collapsed pull-left hidden">
                                    用户
                                </span>
                                <a aria-label="Toggle sidebar" class="gutter-toggle pull-right js-sidebar-toggle" href="#"
                                   role="button">
                                    <i aria-hidden="true" class="fa fa-angle-double-right"></i>
                                </a>
                                <a href="<?=$project_root_url?>/issues" aria-label="Back issue list"
                                   class="btn btn-default issuable-header-btn  pull-left" title="Back issue list">
                                    <i aria-hidden="true" class="fa fa-arrow-left"></i><span
                                            class="issuable-todo-inner js-issuable-todo-inner">返回事项列表</span>
                                </a>
                            </div>
                            <form class="issuable-context-form inline-update js-issuable-update" id="edit_issue_1"
                                  action="<?= ROOT_URL ?>issue/main/patch" accept-charset="UTF-8" data-remote="true"
                                  method="post">
                                <input name="utf8" type="hidden" value="&#x2713;"/>
                                <input type="hidden" name="_method" value="post"/>

                                <div class="block assignee">

                                    <div class="sidebar-collapsed-icon sidebar-collapsed-user" data-container="body"
                                         data-placement="left" data-toggle="tooltip"
                                         title="<?= @$issue['assignee_info']['display_name'] ?>">
                                        <?php
                                        if($issue['assignee_info']){
                                        ?>
                                        <a class="author_link  " href="/user/profile/<?= $issue['assignee'] ?>">
                                            <img width="24" class="avatar avatar-inline s24 " alt=""
                                                 src="<?= @$issue['assignee_info']['avatar'] ?>">
                                            <span class="author "><?= @$issue['assignee_info']['display_name'] ?></span>
                                        </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="title hide-collapsed">经办人
                                         <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                         <a class="edit-link pull-right" href="#">编辑</a>
                                    </div>

                                    <div class="value hide-collapsed">
                                        <?php
                                         if($issue['assignee_info']){
                                        ?> <a class="author_link bold " href="/user/profile/<?= $issue['assignee'] ?>">
                                            <img width="32" class="avatar avatar-inline s32 " alt=""
                                                 src="<?= @$issue['assignee_info']['avatar'] ?>">
                                            <span class="author "><?= @$issue['assignee_info']['display_name'] ?></span>
                                            <span class="username"><?= @$issue['assignee_info']['username'] ?></span></a>
                                        <?php
                                         }
                                        ?>
                                    </div>
                                    <div class="selectbox hide-collapsed">
                                        <input value="15" id="issue_assignee_id" type="hidden" name="issue[assignee_id]"/>
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-user-search js-author-search"
                                                    type="button"
                                                    data-first-user="<?= @$issue['assignee_info']['username'] ?>"
                                                    data-current-user="true"
                                                    data-project-id="<?= $project_id ?>"
                                                    data-author-id="<?= @$issue['assignee_info']['uid'] ?>"
                                                    data-field-name="assignee_id"
                                                    data-issue-update="<?= ROOT_URL ?>issue/main/patch/<?= $issue_id ?>"
                                                    data-ability-name="issue"
                                                    data-null-user="true"
                                                    data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <span class="dropdown-toggle-text ">选择经办人</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author">
                                                <div class="dropdown-title">
                                                    <span>分配给</span>
                                                    <button class="dropdown-title-button dropdown-menu-close"
                                                            aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field"
                                                           placeholder="Search users" autocomplete="off"/>
                                                    <i class="fa fa-search dropdown-input-search"></i>
                                                    <i role="button"
                                                       class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                </div>
                                                <div class="dropdown-content "></div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="block milestone hide">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" class="fa fa-clock-o"></i>
                                        <small>None</small>
                                    </div>
                                    <div class="title hide-collapsed "><span class="bold">Milestone</span>
                                        <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                        <a class="edit-link pull-right" href="#">
                                            编辑
                                        </a></div>
                                    <div class="value hide-collapsed">
                                        <small class="no-value">None</small>
                                    </div>
                                    <div class="selectbox hide-collapsed">
                                        <input type="hidden" name="issue[milestone_id]"/>
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-milestone-select js-extra-options"
                                                    type="button"
                                                    data-show-no="true"
                                                    data-field-name="issue[milestone_id]"
                                                    data-project-id="<?= $project_id ?>"
                                                    data-issuable-id="<?= $issue_id ?>"
                                                    data-milestones="/api/v4/milestones.json"
                                                    data-ability-name="issue"
                                                    data-issue-update="<?= ROOT_URL ?>issue/main/patch/<?= $issue_id ?>"
                                                    data-use-id="true"
                                                    data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Milestone</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-selectable">
                                                <div class="dropdown-title">
                                                    <span>Assign milestone</span>
                                                    <button class="dropdown-title-button dropdown-menu-close"
                                                            aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field"
                                                           placeholder="Search milestones" autocomplete="off"/>
                                                    <i class="fa fa-search dropdown-input-search"></i>
                                                    <i role="button"
                                                       class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                </div>
                                                <div class="dropdown-content "></div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="title hide-collapsed margin-t"><span class="bold">时间</span>
                                </div>
                                <div class="block due_date due_date_first">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" class="fa fa-calendar"></i>
                                        <span class="js-due-date-sidebar-value"><?= $issue['start_date'] == '0000-00-00' ? '' : $issue['start_date'] ?></span></div>
                                    <div class="title hide-collapsed">
                                        <small>开始时间</small>
                                        <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                        <a class="edit-link2 pull-right" href="#">
                                            <small id="a_start_date_edit">编辑</small>
                                        </a>

                                    </div>
                                    <div class="value hide-collapsed">
                                        <span class="value-content">
                                                <small class="no-value"
                                                       id="small_start_date"><?= $issue['start_date'] == '0000-00-00' ? '' : $issue['start_date'] ?></small>

                                        </span>
                                        <span class="hidden js-remove-due-date-holder no-value">-
                                        <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                        </span>
                                    </div>

                                </div>
                                <div class="block due_date">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" class="fa fa-calendar"></i>
                                        <small class="js-due-date-sidebar-value"><?= $issue['due_date'] == '0000-00-00' ? '' : $issue['due_date'] ?></small>
                                    </div>
                                    <div class="title hide-collapsed">
                                        <small>截止时间</small>
                                        <i aria-hidden="true" class="fa fa-spinner fa-spin hidden block-loading"></i>
                                        <a class="edit-link2 pull-right" href="#">
                                            <small id="a_due_date_edit">编辑</small>
                                        </a></div>
                                    <div class="value hide-collapsed">
                                      <span class="value-content">
                                        <small class="no-value" id="small_due_date"><?= $issue['due_date'] == '0000-00-00' ? '' : $issue['due_date'] ?></small>
                                      </span>
                                        <span class="hidden js-remove-due-date-holder no-value">-
                                            <a class="js-remove-due-date" href="#" role="button">remove due date</a>
                                        </span>
                                    </div>

                                </div>
                                <div class="block participants">
                                    <div class="sidebar-collapsed-icon">
                                        <i class="fa fa-users"></i>
                                        <span></span>
                                    </div>
                                    <div class="title hide-collapsed">
                                        <span class="bold">协助人</span>
                                    </div>
                                    <div class="hide-collapsed participants-list" id="assistants_div">

                                    </div>
                                </div>

                                <div id="parent_block" class="block project-reference hide">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" title="该事项的父任务" class="fa fa-hashtag"></i>
                                        <span></span>
                                    </div>
                                    <div class="title hide-collapsed">
                                        <span class="bold">父任务</span>
                                    </div>
                                    <div id="parent_issue_div" class="cross-project-reference hide-collapsed">

                                    </div>
                                </div>

                                <div class="block project-reference">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" title="该事项的子任务" class="fa fa-tasks"></i>
                                        <span></span>
                                    </div>
                                    <div class="title hide-collapsed">
                                        <span class="bold">子任务</span>
                                    </div>
                                    <div id="child_issues_div" class="cross-project-reference hide-collapsed">

                                    </div>
                                </div>

                                <div id="custom_field_values_block" class="block project-reference hide">
                                    <div class="sidebar-collapsed-icon">
                                        <i aria-hidden="true" title="自定义字段" class="fa fa-info"></i>
                                        <span></span>
                                    </div>
                                    <div class="title hide-collapsed">
                                        <span class="bold">自定义字段</span>
                                    </div>
                                    <div id="custom_field_values_div" class="cross-project-reference hide-collapsed">

                                    </div>
                                </div>

                            </form>

                        </div>
                    </aside>
                </div>
            </div>
        </div>

    </div>
</div>
</section>

    <script type="text/html" id="timeline_tpl">

        {{#timelines}}
        <li id="timeline_{{id}}" name="timeline_{{id}}" class="note note-row-{{id}} timeline-entry"
            data-author-id="{{uid}}">

            <div class="timeline-entry-inner">
                <div class="timeline-icon">
                    <a href="/{{user.username}}">
                        <img alt="" class="avatar s40" src="{{user.avatar}}"/></a>
                </div>
                <div class="timeline-content">
                    <div class="note-header">
                        <a class="visible-xs" href="<?=ROOT_URL?>user/profile/{{user.uid}}">@{{user.username}}</a>
                        <a class="author_link hidden-xs " href="<?=ROOT_URL?>user/profile/{{user.uid}}">
                            <span class="author ">@{{user.display_name}}</span></a>
                        <div class="note-headline-light">
                            <span class="hidden-xs">@{{user.username}}</span>
                            {{#if is_issue_commented}}
                            {{{action}}}
                            {{^}}
                            <span class="system-note-message">
                                {{{content}}}
                             </span>
                            {{/if}}
                            <a href="#note_{{id}}">{{time_text}}</a>
                        </div>

                        <div id="note-actions_{{id}}" class="note-actions">
                            {{#if is_issue_commented}}
                                {{#if is_cur_user}}
                                    <a id="btn-timeline-edit_{{id}}" data-id="{{id}}" title="编辑此评论"
                                       class="note-action-button js-note-edit2" href="#timeline_{{id}}">
                                        <i class="fa fa-pencil link-highlight"></i>
                                    </a>
                                    <a id="btn-timeline-remove_{{id}}" data-id="{{id}}"
                                       class="note-action-button js-note-remove danger"
                                       data-title="删除此评论"
                                       data-confirm2="您确认删除此评论?"
                                       data-url="<?= ROOT_URL ?>issue/detail/delete_timeline/{{id}}"
                                       href="#timeline_{{id}}">
                                        <i class="fa fa-trash-o danger-highlight"></i>
                                    </a>
                                {{^}}
                                    <?php
                                    if($is_admin || isset($projectPermArr[\main\app\classes\PermissionLogic::MANAGE_COMMENTS])) {
                                        ?>
                                    <a id="btn-timeline-edit_{{id}}" data-id="{{id}}" title="编辑此评论"
                                       class="note-action-button js-note-edit2" href="#timeline_{{id}}">
                                        <i class="fa fa-pencil link-highlight"></i>
                                    </a>
                                    <a id="btn-timeline-remove_{{id}}" data-id="{{id}}"
                                       class="note-action-button js-note-remove danger"
                                       data-title="删除此评论"
                                       data-confirm2="您确认删除此评论?"
                                       data-url="<?= ROOT_URL ?>issue/detail/delete_timeline/{{id}}"
                                       href="#timeline_{{id}}">
                                        <i class="fa fa-trash-o danger-highlight"></i>
                                    </a>
                                    <?php } ?>
                                {{/if}}

                            {{/if}}

                        </div>
                    </div>
                    {{#if is_issue_commented}}
                    <div class="js-task-list-container note-body is-task-list-enabled">
                        <form class="edit-note common-note-form js-quick-submit gfm-form"
                              action="<?= ROOT_URL ?>issue/detail/update_timeline/{{id}}" accept-charset="UTF-8"
                              method="post" data-remote="true">

                            <div id="timeline-text_{{id}}" class="note-text md ">
                                <p dir="auto">
                                    {{{content_html}}}
                                </p>
                            </div>

                            <div id="timeline-div-editormd_{{id}}" class="note-awards">
                                <textarea id="timeline-textarea_{{id}}" name="content"
                                          class="hidden js-task-list-field original-task-list">{{content}}</textarea>
                            </div>
                            <div id="timeline-footer-action_{{id}}" class="note-form-actions hidden clearfix">
                                <div class="settings-message note-edit-warning js-edit-warning">
                                    先完成编辑再操作
                                </div>
                                <input data-id="{{id}}" type="button" name="comment_commit" value="保 存"
                                       class="btn btn-nr btn-save js-comment-button btn-timeline-update">
                                <button data-id="{{id}}" class="btn btn-nr btn-cancel note-edit-cancel" type="button">
                                    取消
                                </button>
                            </div>
                        </form>
                    </div>
                    {{^}}
                    <div class="note-body">
                        <div class="note-text md">
                            <p dir="auto">
                                {{{content_html}}}
                            </p>
                        </div>
                        <div class="note-awards">
                            <div class="awards hidden js-awards-block"
                                 data-award-url="<?= ROOT_URL ?>issue/detail/timeline/{{id}}">
                                <div class="award-menu-holder js-award-holder">

                                </div>
                            </div>
                        </div>

                    </div>
                    {{/if}}
                </div>
            </div>
        </li>
        {{/timelines}}
    </script>

    <script type="text/html" id="wrap_field">
        <div class=" form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">{{display_name}}:{{required_html}}</div>
            <div class="col-sm-8">{field_html}</div>
            <div class="col-sm-1"></div>
        </div>
    </script>

    <script type="text/html" id="li_tab_tpl">
        <div role="tabpanel" class="tab-pane" id="{{id}}">
            <div id="{{type}}_ui_config_{{id}}" style="min-height: 200px">

            </div>
        </div>
    </script>

    <script type="text/html" id="nav_tab_li_tpl">
        <li role="presentation" class="active">
            <a id="a_{{id}}" href="#{{id}}" role="tab" data-toggle="tab">
                <span id="span_{{id}}">{{title}}&nbsp;</span>
            </a>
        </li>
    </script>

    <script type="text/html" id="content_tab_tpl">
        <div role="tabpanel" class="tab-pane " id="{{id}}">
            <div class="dd-list" id="{{type}}_ui_config-{{id}}" style="min-height: 200px">

            </div>
        </div>
    </script>
    <script type="text/html" id="parent_issue_tpl">
        <span>
        <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
    </span>
    </script>

    <script type="text/html" id="child_issues_tpl">
        {{#child_issues}}
        <span><a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
    </span>
        {{/child_issues}}
    </script>

    <script type="text/html" id="custom_field_values_tpl">
        {{#custom_field_values}}
        <span>
        <cite title="{{field.description}}">{{field_title}}:{{show_value}}</cite>
    </span>
        <button class="btn btn--map-pin btn-transparent" data-toggle="tooltip" data-placement="left"
                data-container="body" data-title="{{show_value}}" data-body="{{value}}" data-clipboard-text="{{value}}"
                type="button" title="{{value}}">
            <i aria-hidden="true" class="fa fa-map-pin"></i>
        </button>
        {{/custom_field_values}}
    </script>

    <script type="text/html" id="allow_update_status_tpl">
        {{#allow_update_status}}
        <li><a id="btn-{{_key}}" data-status_id="{{id}}" class="allow_update_status" href="#">
                <span class="label label-{{color}} prepend-left-5">{{name}}</span></a></li>
        {{/allow_update_status}}
    </script>

    <script type="text/html" id="allow_update_resolves_tpl">
        {{#allow_update_resolves}}
        <li><a id="btn-{{_key}}" data-resolve_id="{{id}}" class="allow_update_resolve" href="#" style="color:{{color}}">{{name}}</a>
        </li>
        {{/allow_update_resolves}}
    </script>

    <script type="text/html" id="fav_filter_first_tpl">
        <li class="fav_filter_li">
            <a id="state-opened" title="清除该过滤条件" href="javascript:$IssueMain.updateFavFilter('0');"><span>所有事项</span>
                <span class="badge">0</span>
            </a>
        </li>
        {{#first_filters}}
        <li class="fav_filter_li">
            <a id="state-opened" title="{{description}}" href="javascript:$IssueMain.updateFavFilter({{id}});"><span>{{name}}</span>
                <span class="badge">0</span>
            </a>
        </li>
        {{/first_filters}}
    </script>

    <script type="text/html" id="fav_filter_hide_tpl">
        {{#hide_filters}}
        <li>
            <a class="update-notification fav_filter_a" data-notification-level="custom"
               data-notification-title="Custom" href="javascript:$IssueMain.updateFavHideFilter({{id}});" role="button">
                <strong class="dropdown-menu-inner-title">{{name}}</strong>
                <span class="dropdown-menu-inner-content">{{description}}</span>
            </a>
        </li>
        {{/hide_filters}}
    </script>

    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="将文件拖放到此处以添加附件"
             style="background-color: #ffffff"
        >
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>浏览</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
            <span>拖拽文件完成...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite"
                aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                             class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <a href="javascript:;" class="qq-file-link qq-upload-file-url"> <img class="qq-thumbnail-selector" qq-max-size="198"
                                                            qq-server-scale></a>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"
                                  aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">否</button>
                    <button type="button" class="qq-ok-button-selector">是</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">取消</button>
                    <button type="button" class="qq-ok-button-selector">好的</button>
                </div>
            </dialog>
        </div>
    </script>
    <script type="text/template" id="btn-fine-uploader">
        <div class="qq-uploader-selector " qq-drop-area-text="将文件拖放到此处以添加附件" style="display: ">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone style="display: none">
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector ">
                <div><i class="fa fa-file-image-o"></i> 附件</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing" style="display: none">
            <span>Processing dropped files...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite"
                aria-relevant="additions removals" style="display: none">
                <li>
                </li>
            </ul>
        </div>
    </script>
    <div id="fine-uploader-gallery" style="display: none"></div>
    <?php include VIEW_PATH . 'gitlab/issue/form.php'; ?>
    <script>

        //var notes = new Notes("/api/v4/notes.json", [111, 112, 113], 1509550115, "inline")
    </script>
    <script>IssuableContext.prototype.PARTICIPANTS_ROW_COUNT = 7;</script>

    <script>
        gl.IssuableResource = new gl.SubbableResource('/api/v4/issue_1.json');
        new gl.IssuableTimeTracking("{\"id\":1,\"iid\":1,\"assignee_id\":15,\"author_id\":15,\"description\":\"拼写错误\",\"lock_version\":null,\"milestone_id\":null,\"position\":0,\"state\":\"closed\",\"title\":\"InWord\",\"updated_by_id\":15,\"created_at\":\"2017-10-19T10:56:27.764Z\",\"updated_at\":\"2017-10-31T08:59:27.604Z\",\"deleted_at\":null,\"time_estimate\":0,\"total_time_spent\":0,\"human_time_estimate\":null,\"human_total_time_spent\":null,\"branch_name\":null,\"confidential\":false,\"due_date\":null,\"moved_to_id\":null,\"project_id\":31,\"milestone\":null,\"labels\":[]}");
        new MilestoneSelect('{"full_path":"ismond/xphp"}');
        gl.Subscription.bindAll('.subscription');
        new IssuableContext('{\"id\":<?=$user['uid']?>,\"name\":\"<?=$user['display_name']?>\",\"username\":\"<?=$user['username']?>\"}');
        window.sidebar = new Sidebar();
    </script>

    <script type="text/template" id="qq-simple-thumbnails-template">
        <div class="qq-uploader">
            <div class="my-custom-class">
                <div>my upload</div>
            </div>
            <span class="qq-drop-processing"><span>{dropProcessingText}</span><span
                        class="qq-drop-processing-spinner"></span></span>
            <ul class="qq-upload-list"></ul>
        </div>

    </script>
    <script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>"></script>
    <script type="text/javascript">
        var _issueConfig = {
            "priority":<?=json_encode($priority)?>,
            "issue_types":<?=json_encode($issue_types)?>,
            "issue_status":<?=json_encode($issue_status)?>,
            "issue_resolve":<?=json_encode($issue_resolve)?>,
            "issue_module":<?=json_encode($project_modules)?>,
            "issue_version":<?=json_encode($project_versions)?>,
            "issue_labels":<?=json_encode($project_labels)?>,
            "users":<?=json_encode($users)?>,
            "projects":<?=json_encode($projects)?>,
            "sprint":<?=json_encode($sprints)?>
        };

        var _simplemde = {};
        var _editor_md = null;
        var _fineUploaderFile = {};
        var _issue_id = '<?=$issue_id?>';
		var _summary='<?=$issue['summary']?>';
        var _cur_project_id = '<?=$project_id?>';
        var _active_sprint_id = '<?=@$active_sprint['id']?>';
        var _cur_uid = '<?=$user['uid']?>';
        var _timelineEditormd;
        var _description_templates = <?=json_encode($description_templates)?>;

        var _fineUploader = null;

        var $IssueDetail = null;
        var $IssueMain = null;
        var query_str = '<?=$query_str?>';
        var urls = parseURL(window.location.href);

        var temp_issues = [];
        var cur_index = 0;

        var _cur_activity_page = 1;

        _editor_md = editormd("editor_md", {
            width: "100%",
            height: 220,
            markdown: "",
            watch: false,
            lineNumbers: false,
            path: '<?=ROOT_URL?>dev/lib/editor.md/lib/',
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL: "<?=ROOT_URL?>issue/detail/editormd_upload",
            tocm: true,    // Using [TOCM]
            emoji: true,
            saveHTMLToTextarea: true,
            toolbarIcons: "custom",
            placeholder: "",
            autoFocus: false
        });

        $(function () {
            $IssueDetail = new IssueDetail({});
            $IssueDetail.fetchIssue(_issue_id);
            $IssueDetail.fetchActivity( _issue_id, 1);
            IssueMain.prototype.pasteImage();
            //IssueDetail.prototype.getDetailIssues();

            _fineUploader = new qq.FineUploader({
                element: document.getElementById('issue_attachments_uploder'),
                template: 'qq-template-gallery',
                multiple: true,
                paste: {
                    promptForName: true,
                    namePromptMessage: "Please name this image"
                },
                request: {
                    endpoint: '/issue/main/upload?project_id='+_cur_project_id+'&issue_id='+_issue_id+'&summary='+_summary+'&_csrftoken='+encodeURIComponent(document.getElementById('csrf_token').value)
                },
                placeholders: {
                    thumbnailNotAvailable: "/all/aa.png"
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    endpoint: "/issue/main/upload_delete/"+_cur_project_id
                },
                validation: {
                    allowedExtensions: ['mp3','aac','wma','avi','rm','rmvb','flv','mpg','mov','mkv','mp4','jpeg', 'jpg', 'gif', 'png', '7z', 'zip', 'rar', 'bmp', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf', 'xlt', 'xltx', 'txt'],
                }
            });

            keyMaster.addKeys([
                {
                    key: 'ctrl+enter',
                    'trigger-element': '.js-key-enter',
                    trigger: 'click'
                },
                {
                    key: 'e',
                    'trigger-element': '.js-key-edit',
                    trigger: 'click'
                }
            ]);

            $('#btn-update').bind('click', function () {
                IssueMain.prototype.update();
            });

            $('#btn-edit').bind('click', function () {
                IssueMain.prototype.fetchEditUiConfig(_issue_id, 'update');
            });

            $('#btn-delete').bind('click', function () {
                IssueMain.prototype.detailDelete(_issue_id);
            });

            $('#btn-close').bind('click', function () {
                IssueMain.prototype.detailClose(_issue_id);
            });

            $('#btn-copy').bind('click', function () {
                IssueMain.prototype.fetchEditUiConfig(_issue_id, 'copy');
            });

            $("#btn-convert_subtask").bind("click", function () {
                IssueMain.prototype.displayConvertChild(_issue_id);
            });

            $("#btn-convertChild").bind("click", function () {
                var issue_id = $('#current_issue_id').val();
                if (issue_id) {
                    IssueMain.prototype.convertChild(issue_id);
                } else {
                    notify_error('事项id传递错误');
                }
            });

            $("#btn-add").click(function () {
                IssueMain.prototype.add();
            });

            $("#btn-create_subtask").bind("click", function () {
                $('#master_issue_id').val(_issue_id);
                if (_cur_project_id != '') {
                    var issue_types = [];
                    _cur_form_project_id = _cur_project_id;
                    for (key in _issueConfig.issue_types) {
                        issue_types.push(_issueConfig.issue_types[key]);
                    }
                    IssueMain.prototype.initCreateIssueType(issue_types, true);
                } else {
                    _cur_form_project_id = "";
                }
            });

            $("#modal-create-issue").on('show.bs.modal', function (e) {

                $('#master_issue_id').val(_issue_id);
                if (_cur_project_id != '') {
                    var issue_types = [];
                    _cur_form_project_id = _cur_project_id;
                    for (key in _issueConfig.issue_types) {
                        issue_types.push(_issueConfig.issue_types[key]);
                    }
                    IssueMain.prototype.initCreateIssueType(issue_types, true);
                } else {
                    _cur_form_project_id = "";
                }
                keyMaster.addKeys([
                    {
                        key: ['command+enter', 'ctrl+enter'],
                        'trigger-element': '#modal-create-issue .btn-save',
                        trigger: 'click'
                    },
                    {
                        key: 'esc',
                        'trigger-element': '#modal-create-issue .close',
                        trigger: 'click'
                    }
                ])
            })

            $('#btn-comment').bind('click', function () {
                IssueDetail.prototype.addTimeline('0');
            });

            $('#btn-comment-reopen').bind('click', function () {
                IssueDetail.prototype.addTimeline('1');
            });

            $("#btn-attachment").fineUploader({
                request: {
                    endpoint: '/issue/main/upload'
                },
                template: 'btn-fine-uploader'
            });

            laydate.render({
                elem: '#small_start_date'
                , eventElem: '#a_start_date_edit'
                , trigger: 'click'
                , done: function (value, date) {
//                    alert('你选择的日期是：' + value + '\n获得的对象是' + JSON.stringify(date));
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url+"issue/main/update",
                        data: {issue_id: _issue_id, params: {start_date: date.year + '-' + date.month + '-' + date.date}},
                        success: function (resp) {
                            auth_check(resp);
                            if (resp.ret != '200') {
                                notify_error('操作失败:' + resp.msg);
                                return;
                            }
                            notify_success('操作成功');
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }
            });

            laydate.render({
                elem: '#small_due_date'
                , eventElem: '#a_due_date_edit'
                , trigger: 'click'
                , done: function (value, date) {
//                    alert('你选择的日期是：' + value + '\n获得的对象是' + JSON.stringify(date));
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url+"issue/main/update",
                        data: {issue_id: _issue_id, params: {due_date: date.year + '-' + date.month + '-' + date.date}},
                        success: function (resp) {
                            auth_check(resp);
                            if (resp.ret != '200') {
                                notify_error('操作失败:' + resp.msg);
                                return;
                            }
                            notify_success('操作成功');
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
