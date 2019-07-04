<link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/issue/detail-list.css?v=<?=$_version?>"/>
<div class="float-right-side">
    <div class="issuable-header clearfix" id="issuable-header">

    </div>

    <div class="detail-pager">
        <span class="showing">第 <span id="issue_current">1</span>个事项, 共 <span id="issue_total">1</span></span>
        <span class="previous"><i class="fa fa-caret-up"></i></span>
        <span class="next"><i class="fa fa-caret-down"></i></span>
    </div>
    <script type="text/html" id="issuable-header_tpl">
        <h3 class="page-title">
            <span>{{issue.summary}}</span><a href="<?= ROOT_URL ?>issue/detail/index/{{issue.id}}" id="a_issue_key">#{{issue.pkey}}{{issue.id}}</a>
        </h3>

        <div class="issuable-meta">
            由
            <strong>
                <a class="author_link  hidden-xs" href="/sven">
                    <img id="creator_avatar" width="24" class="avatar avatar-inline s24 " alt=""
                         src="{{issue.creator_info.avatar}}">
                    <span id="author" class="author has-tooltip"
                          title="@{{issue.creator_info.username}}" data-placement="top">{{issue.creator_info.display_name}}</span></a>
                <a class="author_link  hidden-sm hidden-md hidden-lg" href="/sven">
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
        <span class="close-float-panel float-right">
            <i class="fa fa-times"></i>
        </span>
    </script>

    <div class="issuable-actions clearfix" id="issue-actions">
        <div class="btn-group" role="group" aria-label="...">
            <button id="btn-edit" type="button" class="btn btn-default"><i class="fa fa-edit"></i>
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

                <script type="text/html" id="allow_update_status_tpl">
                    {{#allow_update_status}}
                    <li><a id="btn-{{_key}}" data-status_id="{{id}}" class="allow_update_status" href="#">
                            <span class="label label-{{color}} prepend-left-5">{{name}}</span></a></li>
                    {{/allow_update_status}}
                </script>
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    更多
                    <i class="fa fa-caret-down"></i>
                </button>

                <ul class="dropdown-menu">
                    <li><a id="btn-watch" data-followed="" href="#">关注</a></li>
                    <li><a id="btn-create_subtask"  class="js-key-create1"
                           data-target="#modal-create-issue" data-toggle="modal"  href="#modal-create-issue">创建子任务</a>
                    </li>
                    <!--<li><a id="btn-convert_subtask" href="#">转化为子任务</a></li>-->
                </ul>
            </div>
        </div>
        <div class="btn-group margin-l-xl" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    解决结果
                    <i class="fa fa-caret-down"></i>
                </button>

                <ul class="dropdown-menu" id="allow_update_resolves">
                </ul>

                <script type="text/html"  id="allow_update_resolves_tpl">
                    {{#allow_update_resolves}}
                    <li>
                        <a id="btn-{{_key}}" data-resolve_id="{{id}}" class="allow_update_resolve"
                           href="#" style="color:{{color}}">{{name}}</a>
                    </li>
                    {{/allow_update_resolves}}
                </script>
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    管理
                    <i class="fa fa-caret-down"></i>
                </button>

                <ul class="dropdown-menu">
                    <li><a id="btn-close" data-issue_id="" href="#">关闭</a></li>
                    <li><a id="btn-delete" data-issue_id=""  href="#">删除</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="issue-detail issue-fields">
        <h3 class="issue-detail-title">事项详情</h3>

        <div id="issue_fields">

        </div>
        <script type="text/html" id="issue_fields_tpl">
            <div class="row">
                <div class=" form-group col-lg-6">
                    <div class="form-group issue-assignee">
                        <label class="control-label col-sm-3">类型:</label>
                        <div class=" col-sm-9">
                            <span><i class="fa {{issue.issue_type_info.font_awesome}}"></i> {{issue.issue_type_info.name}}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">解决结果:</label>
                        <div class="col-sm-9">
                            <span style=" color: {{issue.resolve_info.color}}">{{issue.resolve_info.name}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6 ">
                    <label class="control-label col-sm-3">状态:</label>
                    <div class="col-sm-9">
                        <span class="label label-{{issue.status_info.color}} prepend-left-5">{{issue.status_info.name}}</span>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="control-label col-sm-3" for="issue_label_ids">优先级:</label>
                    <div class="col-sm-9">
                        <span class="label " style="color:{{issue.priority_info.status_color}}">{{issue.priority_info.name}}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6 ">
                    <label class="control-label col-sm-3" for="issue_milestone_id">影响版本:</label>
                    <div class="col-sm-9">
                        {{#issue.effect_version_names}}
                        <span>{{name}}</span>&nbsp;
                        {{/issue.effect_version_names}}
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="control-label col-sm-3" for="issue_label_ids">解决版本:</label>
                    <div class="col-sm-9">
                        {{#issue.fix_version_names}}
                        <span>{{name}}</span>&nbsp;
                        {{/issue.fix_version_names}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6 ">
                    <label class="control-label col-sm-3" for="issue_milestone_id">模块:</label>
                    <div class="col-sm-9">
                        <span>{{issue.module_name}}</span>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="control-label col-sm-3" for="issue_label_ids">标签:</label>
                    <div class="col-sm-9">
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
    </div>

    <div class="issue-detail detail-page-description">
        <!--                            <div class="issue-title-data hidden" data-endpoint="#" data-initial-title="{{issue.summary}}"></div>-->
        <div id="detail-page-description">

        </div>
        <script type="text/html" id="detail-page-description_tpl">
            <h3 class="issue-detail-title">描述</h3>

            {{#if issue.description}}
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

            {{/if}}
        </script>
    </div>

    <div id="detail-page-attachments" class="issue-detail issue-attachments">
        <h3 class="issue-detail-title">附件</h3>

        <input type="hidden"  name="params[attachments]" id="attachments"  value=""  />
        <input type="hidden"  name="params[fine_uploader_json]" id="fine_uploader_json"  value=""  />
        <div id="issue_right_attachments_uploder" class="fine_uploader_img"></div>
    </div>

    <div class="issue-detail issue-users">
        <h3 class="issue-detail-title">用户</h3>

        <div id="detail-page-users">

        </div>


        <script type="text/html" id="detail-page-users_tpl">
            <div class="row">
                <div class=" form-group col-lg-6">
                    <div class="form-group issue-assignee">
                        <label class="control-label col-sm-3">经办人:</label>
                        <div class=" col-sm-9">
                            <div class="sidebar-collapsed-icon sidebar-collapsed-user" data-container="body" data-placement="left" data-toggle="tooltip" title="{{assignee_info.display_name}}">
                                <a class="author_link" href="/{{assignee_info.username}}">
                                    <img width="24" class="avatar avatar-inline s24 " alt="" src="{{assignee_info.avatar}}">
                                    <span class="author">{{assignee_info.display_name}}</span></a>
                            </div>
                            {{assignee_info.username}}
                        </div>
                    </div>
                </div>

                <div class="form-group col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">协助人:</label>
                        <div class="col-sm-9">
                            {{assistants}}
                        </div>
                    </div>
                </div>

            </div>
        </script>
    </div>

    <div class="issue-detail issue-start-date">
        <h3 class="issue-detail-title">时间</h3>

        <div id="detail-page-date">

        </div>

        <script type="text/html" id="detail-page-date_tpl">
            <div class="row">
                <div class=" form-group col-lg-6">
                    <div class="form-group issue-assignee">
                        <label class="control-label col-sm-3">开始日期:</label>
                        <div class=" col-sm-9">
                            {{start_date}}
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">结束日期:</label>
                        <div class="col-sm-9">
                            {{due_date}}
                        </div>
                    </div>
                </div>
            </div>
        </script>
    </div>

    <div id="parent_block" class="issue-detail issue-parent-block hide">
        <h3 class="issue-detail-title">父任务</h3>

        <div id="parent_issue_div" class="cross-project-reference hide-collapsed">

        </div>

        <script type="text/html" id="parent_issue_tpl">
            <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
        </script>
    </div>

    <div class="issue-detail issue-child-block">
        <h3 class="issue-detail-title">子任务</h3>

        <ul id="child_issues_div" class="cross-project-reference hide-collapsed">

        </ul>

        <script type="text/html" id="child_issues_tpl">
            {{#child_issues}}
            <li>
                <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{show_title}}</a>
            </li>
            {{/child_issues}}
        </script>
    </div>

    <div id="custom_field_values_block" class="issue-detail issue-project-reference hide">
        <h3 class="issue-detail-title">自定义字段</h3>

        <div id="custom_field_values_div" class="cross-project-reference hide-collapsed">

        </div>

        <script type="text/html" id="custom_field_values_tpl">
            {{#custom_field_values}}
            <span>
                                    <cite title="{{field.description}}">{{field_title}}:{{show_value}}</cite>
                                </span>
            <button class="btn btn--map-pin btn-transparent" data-toggle="tooltip" data-placement="left"
                    data-container="body" data-title="{{show_value}}" data-body="{{value}}"
                    data-clipboard-text="{{value}}" type="button" title="{{value}}">
                <i aria-hidden="true" class="fa fa-map-pin"></i>
            </button>
            {{/custom_field_values}}
        </script>
    </div>

    <div class="issue-detail issue-discussion">
        <h3 class="issue-detail-title">评论</h3>

        <input type="hidden" name="issue_id" id="issue_id" value="" />

        <div id="notes">
            <ul class="notes main-notes-list timeline" id="timelines_list">

            </ul>
            <div class="note-edit-form">

            </div>

            <ul class="notes notes-form timeline">
                <li class="timeline-entry">
                    <div class="flash-container timeline-content"></div>
                    <div class="timeline-icon hidden-xs hidden-sm">
                        <a class="author_link" href="/<?=$user['username']?>">
                            <img alt="@<?=$user['username']?>" class="avatar s40" src="<?=$user['avatar']?>" /></a>
                    </div>

                    <div class="timeline-content timeline-content-form">
                        <form data-type="json" class="new-note js-quick-submit common-note-form gfm-form js-main-target-form show" enctype="multipart/form-data" action="<?=ROOT_URL?>issue/main/comment" accept-charset="UTF-8" data-remote="true" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                            <input type="hidden" name="view" id="view" value="inline">

                            <div id="editor_md">
                                <textarea class="hide"></textarea>
                            </div>

                            <div class="note-form-actions clearfix">
                                <input id="btn-comment" class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button" type="button" value="评论">
                                <!--<a id="btn-comment-reopen"  class="btn btn-nr btn-reopen btn-comment js-note-target-reopen " title="重新打开" href="#">重新打开</a>-->
                                <a data-no-turbolink="true" data-original-text="Close issue" data-alternative-text="Comment &amp; close issue" class="btn btn-nr btn-close btn-comment js-note-target-close hidden" title="Close issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close issue</a>
                                <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel" role="button">弃稿</a>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>

            <div id="timeline-edit">

            </div>
        </div>

        <script type="text/html"  id="timeline_tpl">
            {{#timelines}}
            <li id="timeline_{{id}}" name="timeline_{{id}}" class="note note-row-{{id}} timeline-entry" data-author-id="{{uid}}" >
                <div class="timeline-entry-inner">
                    <div class="timeline-icon">
                        <a href="/{{user.username}}">
                            <img alt="" class="avatar s40" src="{{user.avatar}}" /></a>
                    </div>
                    <div class="timeline-content">
                        <div class="note-header">
                            <a class="visible-xs" href="/sven">@{{user.username}}</a>
                            <a class="author_link hidden-xs " href="/sven">
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
                                <a id="btn-timeline-edit_{{id}}" data-id="{{id}}" title="Edit comment"
                                   class="note-action-button js-note-edit2" href="#timeline_{{id}}">
                                    <i class="fa fa-pencil link-highlight"></i>
                                </a>
                                <a id="btn-timeline-remove_{{id}}" data-id="{{id}}"
                                   class="note-action-button js-note-remove danger"
                                   data-title="Remove comment"
                                   data-confirm2="Are you sure you want to remove this comment?"
                                   data-url="<?=ROOT_URL?>issue/detail/delete_timeline/{{id}}"
                                   href="#timeline_{{id}}" >
                                    <i class="fa fa-trash-o danger-highlight"></i>
                                </a>
                                {{/if}}
                                {{/if}}
                            </div>
                        </div>
                        {{#if is_issue_commented}}
                        <div class="js-task-list-container note-body is-task-list-enabled">
                            <form class="edit-note common-note-form js-quick-submit gfm-form" action="<?=ROOT_URL?>issue/detail/update_timeline/{{id}}" accept-charset="UTF-8" method="post" data-remote="true">

                                <div id="timeline-text_{{id}}" class="note-text md ">
                                    <p dir="auto">
                                        {{{content_html}}}
                                    </p>
                                </div>

                                <div id="timeline-div-editormd_{{id}}" class="note-awards" >
                                    <textarea  id="timeline-textarea_{{id}}" name="content" class="hidden js-task-list-field original-task-list">{{content}}</textarea>
                                </div>
                                <div id="timeline-footer-action_{{id}}" class="note-form-actions hidden clearfix">
                                    <div class="settings-message note-edit-warning js-edit-warning">
                                        Finish editing this message first!
                                    </div>
                                    <input data-id="{{id}}"  type="button" name="comment_commit" value="Save comment" class="btn btn-nr btn-save js-comment-button btn-timeline-update">
                                    <button data-id="{{id}}"  class="btn btn-nr btn-cancel note-edit-cancel" type="button">
                                        Cancel
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
                                <div class="awards hidden js-awards-block" data-award-url="<?=ROOT_URL?>issue/detail/timeline/{{id}}">
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

        <script type="text/html"  id="timeline-edit_tpl">
            <ul class="notes notes-form timeline">
                <li class="timeline-entry">
                    <div class="flash-container timeline-content"></div>
                    <div class="timeline-icon hidden-xs hidden-sm">
                        <a class="author_link" href="/<?=$user['username']?>">
                            <img alt="@<?=$user['username']?>" class="avatar s40" src="<?=$user['avatar']?>" /></a>
                    </div>

                    <div class="timeline-content timeline-content-form">
                        <form data-type="json" class="new-note js-quick-submit common-note-form gfm-form js-main-target-form show" enctype="multipart/form-data" action="<?=ROOT_URL?>issue/main/comment" accept-charset="UTF-8" data-remote="true" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                            <input type="hidden" name="view" id="view" value="inline">

                            <div id="editor_md">
                                <textarea class="hide"></textarea>
                            </div>

                            <div class="note-form-actions clearfix">
                                <input id="btn-comment" class="btn btn-nr btn-create comment-btn js-comment-button js-comment-submit-button" type="button" value="评论">
                                <!--<a id="btn-comment-reopen"  class="btn btn-nr btn-reopen btn-comment js-note-target-reopen " title="Reopen issue" href="#">重新打开</a>-->
                                <a data-no-turbolink="true" data-original-text="Close issue" data-alternative-text="Comment &amp; close issue" class="btn btn-nr btn-close btn-comment js-note-target-close hidden" title="Close issue" href="/ismond/xphp/issues/1.json?issue%5Bstate_event%5D=close">Close issue</a>
                                <a class="btn btn-cancel js-note-discard" data-cancel-text="Cancel" role="button">弃稿</a>
                            </div>
                        </form>
                    </div>

                </li>
            </ul>
        </script>
    </div>
</div>

<script type="text/template" id="btn-fine-uploader">
    <div class="qq-uploader-selector " qq-drop-area-text="将文件拖放到此处以添加附件">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container" >
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area hide" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector ">
            <div><i class="fa fa-file-image-o"></i> 附件</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing hide">
            <span>处理拖放文件...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list hide" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
            </li>
        </ul>
    </div>
</script>
