<div class="modal modal-middle" id="modal-join_sprint">
    <form class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
          action="<?= ROOT_URL ?>issue/main/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog issue-modal-dialog">
            <form class="" id="form_add" action="<?= ROOT_URL ?>issue/main/join_sprint" accept-charset="UTF-8"
                  method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal" href="#">×</a>
                        <h3 class="modal-header-title">加入到Sprint</h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="issue_id" id="join_sprint_issue_id" value="">
                        <input type="hidden" name="format" id="format" value="json">

                        <div class="project-visibility-level-holder">

                            <script type="text/html" id="sprint_list_tpl">
                                {{#sprints}}
                                <div class="radio">
                                    <input type="radio" value="{{id}}" name="join_sprint" id="join_sprint_{{id}}">

                                    <label for="join_sprint_{{id}}">
                                        <i class="fa fa-circle-o"></i>
                                        <i class="fa fa-dot-circle-o"></i>
                                        <div class="option-title ">
                                            {{name}}
                                        </div>
                                        <div class="option-descr">
                                        </div>
                                    </label>
                                </div>
                                {{/sprints}}
                            </script>

                            <div id="sprint_list_div" class="sprint-list-div clearfix">

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer issue-modal-footer footer-block row-content-block">
                        <button name="submit" type="button" class="btn btn-create" id="btn-join_sprint">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>
                </div>
            </form>
        </div>
    </form>
</div>

<div class="modal" id="modal-children_list">
    <form class="form-horizontal issue-form" id="form_add"
          action="<?= ROOT_URL ?>issue/main/delete"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog issue-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">删除事项</h3>
                </div>

                <div class="modal-body issue-modal-body">
                    <input type="hidden" name="issue_id" id="children_list_issue_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group project-visibility-level-holder padding-20">
                        <script type="text/html" id="children_list_tpl">
                            {{#children}}
                            <div class="radio">
                                <label for="join_sprint_{{id}}">
                                    <div class="option-title">
                                        <a href="/issue/detail/index/{{id}}" target="_blank">#{{id}} {{summary}}</a>
                                    </div>
                                    <div class="option-descr">
                                        {{description}}
                                    </div>
                                </label>
                            </div>
                            {{/children}}
                        </script>
                        <label id="children_list_title" class="label-light" for="children_list_div">
                            该实现还包含如下子任务,您确定要删除吗?
                        </label>
                        <div id="children_list_div" class="">

                        </div>

                        <label id="children_empty_state_title" class="label-light" for="empty_children_state">
                            您确认要删除该事项吗?
                        </label>
                        <div id="empty_children_state" class="">
                            <img src="/gitlab/images/no_group_avatar.png">
                        </div>
                    </div>
                </div>

                <div class="modal-footer issue-modal-footer footer-block row-content-block">
                    <button name="submit" type="button" class="btn btn-remove" id="btn-modal_delete">删除</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-choose_parent">
    <div class="modal-dialog issue-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="modal-header-title">选择父任务</h3>
            </div>

            <div class="modal-body issue-modal-body">
                <input type="hidden" name="issue_id" id="current_issue_id" value="">
                <input type="hidden" name="format" id="format" value="json">
                <div class="padding-20">
                    <div class="form-group project-visibility-level-holder margin-b-m">
                        <div class="filter-item inline">
                            <div class="dropdown">
                                <button id="btn-parent_select_issue"
                                        class="dropdown-menu-toggle js-user-search"
                                        type="button"
                                        data-copy-id="btn-parent_select_issue"
                                        data-current-user="false"
                                        data-project-id="<?= $project_id ?>"
                                        data-selected=""
                                        data-field-name="parent_select_issue_id"
                                        data-default-label="请选择事项"
                                        data-field-type="issue"
                                        data-issue-id=""
                                        data-toggle="dropdown">
                                    <span class="dropdown-toggle-text is-default">请选择事项</span>
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author js-filter-submit">
                                    <div class="dropdown-title">
                                        <span>查找事项</span>
                                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close"
                                                type="button">
                                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                                        </button>
                                    </div>
                                    <div class="dropdown-input">
                                        <input type="search" id="" class="dropdown-input-field"
                                               placeholder="可输入事项键值或主题的关键词" autocomplete="off"/>
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

                    <div class="form-group">
                        <span>注:</span><br>
                        <span>输入事项键值或主题的关键词来得到可能匹配的事项列表</span><br>
                        <span>只能在当前事项的项目内操作</span><br>
                    </div>
                </div>
            </div>

            <div class="modal-footer issue-modal-footer footer-block row-content-block">
                <button name="submit" type="button" class="btn btn-create" id="btn-convertChild">确定</button>
                <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
            </div>
        </div>
    </div>
</div>

<div class="modal height100" id="modal-create-issue">
    <form class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
          id="create_issue"
          action="<?= ROOT_URL ?>issue/main/add"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog issue-modal-dialog">
            <div class="modal-content issue-modal-content">
                <div class="modal-header issue-modal-header">
                    <!--                <div class="modal-header-action">-->
                    <!--                    <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">-->
                    <!--                        <div class="js-notification-toggle-btns">-->
                    <!--                            <a class="dropdown-new notifications-btn" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">-->
                    <!--                                <i class="fa fa-cog"></i> 配置字段-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                </div>-->

                    <h3 class="modal-header-title">创建事项</h3>

                    <a class="close" data-dismiss="modal" href="#">×</a>
                </div>
                <div class="modal-body issue-modal-body">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="params[project_id]" id="project_id" value="<?= $project_id ?>"/>
					<input type="hidden" name="params[master_issue_id]" id="master_issue_id" value=""/>
                    <input type="hidden" name="authenticity_token" value="">
                    <?php
                    $projectSeelctTitle = '请选择项目';
                    if (!empty($project_id)) {
                        $projectSeelctTitle = $project_name;
                    }
                    ?>
                    <div class="form-group">
                        <label class="control-label" for="issue_project_id">项目:</label>
                        <div class="col-sm-10">
                            <div class="filter-item inline">
                                <div class="dropdown ">
                                    <button class="dropdown-menu-toggle js-user-search "
                                            type="button"
                                            data-onSelectedFnc="IssueMain.prototype.onChangeCreateProjectSelected"
                                            data-type="user"
                                            data-first-user=""
                                            data-current-user="false"
                                            data-project-id="null"
                                            data-selected="null"
                                            data-field-name="project_id"
                                            data-field-type="project"
                                            data-default-label="<?= $projectSeelctTitle ?>"
                                            data-toggle="dropdown">
                                        <span class="dropdown-toggle-text is-default"><?= $projectSeelctTitle ?></span><i
                                                class="fa fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author js-filter-submit">
                                        <div class="dropdown-title"><span>按名称过滤</span>
                                            <button class="dropdown-title-button dropdown-menu-close" aria-label="Close"
                                                    type="button">
                                                <i class="fa fa-times dropdown-menu-close-icon"></i>
                                            </button>
                                        </div>
                                        <div class="dropdown-input">
                                            <input type="search" id="" class="dropdown-input-field" placeholder="搜索项目"
                                                   autocomplete="off"/>
                                            <i class="fa fa-search dropdown-input-search"></i>
                                            <i role="button"
                                               class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                        </div>
                                        <div class="dropdown-content "></div>
                                        <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="issue_type">事项类型:</label>
                        <div class="col-sm-10">
                            <select id="create_issue_types_select" name="params[issue_type]" class="selectpicker"
                                    dropdownAlignRight="true" data-live-search="true" title="">
                                <option value="">请选择类型</option>
                            </select>
                        </div>
                    </div>

                    <hr id="create_header_hr">

                    <ul class="nav nav-tabs hide" id="create_tabs">
                        <li role="presentation" class="active">
                            <a id="a_create_default_tab" href="#create_default_tab" role="tab" data-toggle="tab">默认</a>
                        </li>
                    </ul>
                    <div id="create_master_tabs" class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="create_default_tab">

                        </div>
                    </div>
                </div>
                <div class="modal-footer issue-modal-footer footer-block row-content-block">
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    <span class="append-right-10">
                    <input id="btn-add" type="button" name="commit" value="保存" class="btn btn-save">
                </span>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-edit-issue">
    <form class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
          id="edit_issue"
          action="<?= ROOT_URL ?>issue/main/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog issue-modal-dialog">
            <div class="modal-content issue-modal-content">
                <div class="modal-header">
                    <!--                    <div class="modal-header-action">-->
                    <!--                        <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">-->
                    <!--                            <div class="js-notification-toggle-btns">-->
                    <!--                                <a class="dropdown-new notifications-btn" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">-->
                    <!--                                    <i class="fa fa-cog"></i> 配置字段-->
                    <!--                                </a>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                    <h3 id="modal-edit-issue_title" class="modal-header-title">编辑事项 </h3>

                    <a class="close" data-dismiss="modal" href="#">×</a>
                </div>
                <div class="modal-body issue-modal-body">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="form_type" id="form_type" value="update"/> 

                    <input type="hidden" name="issue_id" id="edit_issue_id" value=""/>
                    <input type="hidden" name="params[project_id]" id="edit_project_id" value=""/>
                    <input type="hidden" name="params[issue_type]" id="edit_issue_type" value=""/>

                    <input type="hidden" name="authenticity_token" value="">
                    <div class="form-group">
                        <label class="control-label" for="issue_project_id">项目:</label>
                        <div class="col-sm-10">
                            <div class="filter-item project-selected" id="project-selected">
                                选择项目
                            </div>
                        </div>
                    </div>
                    <script type="text/html" id="project-selected_tpl">
                        <span>{{name}}</span>
                    </script>
                    <div class="form-group">
                        <label class="control-label" for="issue_type">事项类型:</label>
                        <div class="col-sm-10">
                            <select id="edit_issue_types_select" name="params[issue_type]" class="selectpicker"
                                     >

                            </select>
                        </div>
                    </div>

                    <ul class="nav nav-tabs hide" id="edit_tabs">
                        <li role="presentation" class="active">
                            <a id="a_edit_default_tab" href="#edit_default_tab" role="tab" data-toggle="tab">默认</a>
                        </li>
                    </ul>
                    <div id="edit_master_tabs" class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="edit_default_tab">

                        </div>
                    </div>
                </div>

                <div class="modal-footer issue-modal-footer footer-block row-content-block">
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    <span class="append-right-10">
                        <input type="button" name="commit" id="btn-update" value="保存"
                                                         class="btn btn-save"></span>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/html" id="user_tpl">
    <div class="issuable-form-select-holder">
        <input type="hidden" value="{{default_value}}" name="{{field_name}}" id="{{id}}"/>
        <div class="dropdown ">
            <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search"
                    type="button" data-first-user="sven"
                    data-null-user="true"
                    data-current-user="true"
                    data-project-id="{{project_id}}"
                    data-selected="null"
                    data-field-name="params[{{name}}]"
                    data-default-label="{{display_name}}"
                    data-selected="{{default_value}}"
                    data-toggle="dropdown">
                <span class="dropdown-toggle-text is-default">{{display_name}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                <div class="dropdown-title">
                    <span>选择经办人</span>
                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                    </button>
                </div>
                <div class="dropdown-input">
                    <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee"
                           autocomplete="off"/>
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
    <a class="assign-to-me-link " href="#">赋予给我</a>
</script>


<script type="text/html" id="multi_user_tpl">
    <div class="issuable-form-select-holder">
        {{#edit_data}}
        <input type="hidden" name="{{../field_name}}" value="{{id}}"/>
        {{/edit_data}}
        <div class="dropdown ">
            <button class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search js-multiselect"
                    type="button"
                    data-null-user="true"
                    data-current-user="true"
                    data-project-id="{{project_id}}"
                    data-field-name="params[{{name}}][]"
                    data-default-label="{{display_name}}"
                    data-selected="{{default_value}}"
                    data-multi-select="true"
                    data-toggle="dropdown">
                <span class="dropdown-toggle-text is-default">{{display_name}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable  dropdown-menu-assignee js-filter-submit">
                <div class="dropdown-title">
                    <span>选择协助人</span>
                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                    </button>
                </div>
                <div class="dropdown-input">
                    <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee"
                           autocomplete="off"/>
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
</script>

<script type="text/html" id="module_tpl">
    <input type="hidden" name="{{field_name}}" id="hidden_{{id}}" value="{{default_value}}"/>
    <div class="issuable-form-select-holder">
        <div class="dropdown ">
            <button class="dropdown-menu-toggle js-label-select js-filter-submit js-issuable-form-dropdown js-extra-options"
                    type="button"
                    data-show-no="true"
                    data-show-menu-above="false"
                    data-show-any="false"
                    data-show-upcoming="true"
                    data-show-started="false"
                    data-field-name="{{field_name}}"
                    data-selected="{{module_title}}"
                    data-project-id="{{project_id}}"
                    data-labels="<?= ROOT_URL ?>config/module/{{project_id}}"
                    data-default-label="Modules"
                    data-toggle="dropdown">
                <span class="dropdown-toggle-text is-default">{{module_title}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable js-multiselect">
                <div class="dropdown-page-one">
                    <div class="dropdown-title">
                        <span>选择模块</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>

                    <div class="dropdown-input">
                        <input type="search" id="" class="dropdown-input-field" placeholder="" autocomplete="off"/>
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content "></div>
                    <div class="dropdown-footer">
                        <ul class="dropdown-footer-list">
                            <li>
                                <a class="dropdown-toggle-page" href="#">创建新模块</a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>default/{{project_key}}/settings_module">管理模块</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown-loading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
                <div class="dropdown-page-two dropdown-new-label">
                    <div class="dropdown-title">
                        <button class="dropdown-title-button dropdown-menu-back" aria-label="Go back" type="button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <span>创建新模块</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-content js-module-content">
                        <div class="dropdown-labels-error js-label-error"></div>
                        <div class="dropdown-label-color-input">
                            <input class="default-dropdown-input" id="new_module_name" name="module_name" placeholder="名称"  type="text">
                        </div>
                        <div class="dropdown-label-color-input">
                        <input class="default-dropdown-input" id="new_module_description" name="description" placeholder="说明"
                               type="text">
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary pull-left js-new-module-btn" type="button">创建</button>
                            <button class="btn btn-default pull-right js-cancel-label-btn" type="button">取消</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</script>

<script type="text/html" id="labels_tpl">
    <div class="issuable-form-select-holder">
        {{#edit_data}}
        <input type="hidden" name="{{../field_name}}[]" value="{{id}}"/>
        {{/edit_data}}

        <div class="dropdown">
            <button class="dropdown-menu-toggle js-extra-options js-filter-submit js-issuable-form-dropdown js-label-select js-multiselect"
                    data-default-label="Labels"
                    data-field-name="{{field_name}}[]"
                    data-labels="/config/labels/{{project_id}}"
                    data-namespace-path=""
                    data-project-path=""
                    data-show-no="true"
                    data-toggle="dropdown"
                    data-multiselect="true"
                    type="button">
                <span class="dropdown-toggle-text {{is_default}}">{{value_title}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
                <div class="dropdown-page-one">
                    <div class="dropdown-title">
                        <span>选择标签</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-input">
                        <input type="search" id="" class="dropdown-input-field" placeholder="Search"
                               autocomplete="off"/>
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content"></div>
                    <div class="dropdown-footer">
                        <ul class="dropdown-footer-list">
                            <li>
                                <a class="dropdown-toggle-page" href="#">创建新标签</a></li>
                            <li>
                                <a data-is-link="true" href="<?= ROOT_URL ?>default/{{project_key}}/settings_label"">管理标签</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-loading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
                <div class="dropdown-page-two dropdown-new-label">
                    <div class="dropdown-title">
                        <button class="dropdown-title-button dropdown-menu-back" aria-label="Go back" type="button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <span>创建新标签</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-labels-error js-label-error"></div>
                        <input class="default-dropdown-input" id="new_label_name" placeholder="Name new label"
                               type="text">
                        <div class="suggest-colors suggest-colors-dropdown">
                            <a style="background-color: #0033CC" data-color="#0033CC" href="#">&nbsp</a>
                            <a style="background-color: #428BCA" data-color="#428BCA" href="#">&nbsp</a>
                            <a style="background-color: #44AD8E" data-color="#44AD8E" href="#">&nbsp</a>
                            <a style="background-color: #A8D695" data-color="#A8D695" href="#">&nbsp</a>
                            <a style="background-color: #5CB85C" data-color="#5CB85C" href="#">&nbsp</a>
                            <a style="background-color: #69D100" data-color="#69D100" href="#">&nbsp</a>
                            <a style="background-color: #004E00" data-color="#004E00" href="#">&nbsp</a>
                            <a style="background-color: #34495E" data-color="#34495E" href="#">&nbsp</a>
                            <a style="background-color: #7F8C8D" data-color="#7F8C8D" href="#">&nbsp</a>
                            <a style="background-color: #A295D6" data-color="#A295D6" href="#">&nbsp</a>
                            <a style="background-color: #5843AD" data-color="#5843AD" href="#">&nbsp</a>
                            <a style="background-color: #8E44AD" data-color="#8E44AD" href="#">&nbsp</a>
                            <a style="background-color: #FFECDB" data-color="#FFECDB" href="#">&nbsp</a>
                            <a style="background-color: #AD4363" data-color="#AD4363" href="#">&nbsp</a>
                            <a style="background-color: #D10069" data-color="#D10069" href="#">&nbsp</a>
                            <a style="background-color: #CC0033" data-color="#CC0033" href="#">&nbsp</a>
                            <a style="background-color: #FF0000" data-color="#FF0000" href="#">&nbsp</a>
                            <a style="background-color: #D9534F" data-color="#D9534F" href="#">&nbsp</a>
                            <a style="background-color: #D1D100" data-color="#D1D100" href="#">&nbsp</a>
                            <a style="background-color: #F0AD4E" data-color="#F0AD4E" href="#">&nbsp</a>
                            <a style="background-color: #AD8D43" data-color="#AD8D43" href="#">&nbsp</a></div>
                        <div class="dropdown-label-color-input">
                            <div class="dropdown-label-color-preview js-dropdown-label-color-preview"></div>
                            <input class="default-dropdown-input" id="new_label_color"
                                   placeholder="Assign custom color like #FF0000" type="text"></div>
                        <div class="clearfix">
                            <button class="btn btn-primary pull-left js-new-label-btn" id="create-label" type="button">创建</button>
                            <button class="btn btn-default pull-right js-cancel-label-btn" type="button">取消</button>
                        </div>
                    </div>
                </div>
                <div class="dropdown-loading">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="version_tpl">
    <div class="issuable-form-select-holder">
        {{#edit_data}}
        <input type="hidden" name="{{../field_name}}[]" value="{{id}}"/>
        {{/edit_data}}

        <div class="dropdown">
            <button class="dropdown-menu-toggle js-extra-options js-filter-submit js-issuable-form-dropdown js-label-select"
                    data-default-label="Versons"
                    data-field-name="{{field_name}}[]"
                    data-labels="/config/version/{{project_id}}"
                    data-namespace-path=""
                    data-project-path=""
                    data-show-no="true"
                    data-toggle="dropdown"
                    data-multiselect="true"
                    type="button">
                <span class="dropdown-toggle-text {{is_default}}">{{value_title}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>

            <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
                <div class="dropdown-page-one">
                    <div class="dropdown-title">
                        <span>选择版本</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-input">
                        <input type="search" id="" class="dropdown-input-field" placeholder="Search"
                               autocomplete="off"/>
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content"></div>
<!--                    <div class="dropdown-footer">-->
<!--                        <ul class="dropdown-footer-list">-->
<!--                            <li>-->
<!--                                <a class="dropdown-toggle-page" href="#">创建新版本</a></li>-->
<!--                            <li>-->
<!--                                <a data-is-link="true" href="/project/version">管理版本</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
                    <div class="dropdown-loading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
                <div class="dropdown-page-two dropdown-new-label">
                    <div class="dropdown-title">
                        <button class="dropdown-title-button dropdown-menu-back" aria-label="Go back" type="button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <span>创建新版本</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-labels-error js-label-error"></div>
                        <input class="default-dropdown-input" id="new_version_name" placeholder="Name new version"
                               type="text">
                        <div class="suggest-colors suggest-colors-dropdown">

                        </div>
                        <div class="dropdown-label-color-input">
                            <div class="dropdown-label-color-preview js-dropdown-label-color-preview"></div>
                            <input class="default-dropdown-input" id="new_version_color"
                                   placeholder="Assign description" type="text"></div>
                        <div class="clearfix">
                            <button class="btn btn-primary pull-left js-new-label-btn" type="button">创建</button>
                            <button class="btn btn-default pull-right js-cancel-label-btn" type="button">取消</button>
                        </div>
                    </div>
                </div>
                <div class="dropdown-loading">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</script>


<!-- Fine Uploader Gallery template
   ====================================================================== -->
<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="将文件拖放到此处以添加附件">
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
                    <a href="javascript:;" class="qq-file-link qq-upload-file-url">
                        <img class="qq-thumbnail-selector" qq-max-size="198" qq-server-scale>
                    </a>
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
                <button type="button" class="qq-cancel-button-selector">关闭</button>
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
                <button type="button" class="qq-ok-button-selector">确定</button>
            </div>
        </dialog>
    </div>
</script>

<script>
</script>
