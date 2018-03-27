<style>
    .modal-dialog {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .modal-content {
        /*overflow-y: scroll; */
        position: absolute;
        top: 0;
        bottom: 0;
        width: 100%;
    }

    .modal-body {
        overflow-y: scroll;
        position: absolute;
        top: 15px;
        bottom: 65px;
        width: 100%;
    }

    .modal-header .close {
        margin-right: 15px;
    }

    .modal-footer {
        position: absolute;
        width: 100%;
        bottom: 0;
    }

    .tab-pane{
        margin-top: 20px;
    }

</style>
<div class="modal" id="modal-create-issue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="page-title" style="max-width: 200px;float: left;">创建问题 </h3>
                <div style="float: right;max-width: 200px; ">
                    <div style="float: left;  margin-right: 80px; margin-top: 15px" class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                        <div class="js-notification-toggle-btns">
                            <div class="">
                                <a class="dropdown-new  notifications-btn " style="color: #8b8f94;"  href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                    <i class="fa fa-cog"></i> 配置字段
                                </a>
                            </div>
                        </div>

                    </div>
                    <a class="close" data-dismiss="modal" href="#">×</a>
                </div>
            </div>
            <div class="modal-body" style="top:80px">

                <form   class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
                        id="create_issue"
                        action="/issue/main/add"
                        accept-charset="UTF-8"
                        method="post">
                    <input name="utf8" type="hidden" value="✓">

                    <input type="hidden" name="params[project_id]" id="project_id" value="<?=$project_id?>" />
                    <input type="hidden" name="authenticity_token" value="">
                    <?php
                    $projectSeelctTitle = '请选择项目';
                    if(!empty($project_id)){
                        $projectSeelctTitle = $project_name;
                    }

                    ?>
                    <div class="form-group">
                        <label class="control-label" for="issue_project_id">项目</label>
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
                                            data-default-label="<?=$projectSeelctTitle?>"
                                            data-toggle="dropdown">
                                        <span class="dropdown-toggle-text is-default"><?=$projectSeelctTitle?></span><i class="fa fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author js-filter-submit">
                                        <div class="dropdown-title"><span>Filter by Name</span>
                                            <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                <i class="fa fa-times dropdown-menu-close-icon"></i>
                                            </button>
                                        </div>
                                        <div class="dropdown-input">
                                            <input type="search" id="" class="dropdown-input-field" placeholder="Search projects" autocomplete="off" />
                                            <i class="fa fa-search dropdown-input-search"></i>
                                            <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                        </div>
                                        <div class="dropdown-content "></div>
                                        <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="issue_type">问题类型</label>
                        <div class="col-sm-10">
                                <select id="create_issue_types_select" name="params[issue_type_id]" class="selectpicker" dropdownAlignRight="true"   data-live-search="true"   title=""   >
                                    <option value="" >请选择类型</option>
                                </select>
                            </div>
                    </div>

                    <hr id="create_header_hr">

                    <ul class="nav nav-tabs hide" id="create_tabs" >
                        <li role="presentation" class="active"><a id="a_create_default_tab" href="#create_default_tab" role="tab" data-toggle="tab">默认</a></li>
                    </ul>
                    <div id="create_master_tabs" class="tab-content">
                        <div role="tabpanel"  class="tab-pane active" id="create_default_tab" >

                        </div>
                    </div>


                    <div class="footer-block row-content-block">

                        <a class="btn btn-cancel" data-dismiss="modal" href="#">Cancel</a>
                        <span class="append-right-10"><input id="btn-add" type="button" name="commit" value="Save changes" class="btn btn-save"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-edit-issue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="page-title" style="max-width: 200px;float: left;">编辑问题 </h3>
                <div style="float: right;max-width: 200px; ">
                    <div style="float: left;  margin-right: 80px; margin-top: 15px" class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                        <div class="js-notification-toggle-btns">
                            <div class="">
                                <a class="dropdown-new  notifications-btn " style="color: #8b8f94;"  href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                    <i class="fa fa-cog"></i> 配置字段
                                </a>
                            </div>
                        </div>

                    </div>
                    <a class="close" data-dismiss="modal" href="#">×</a>
                </div>
            </div>
            <div class="modal-body" style="top:80px">

                <form   class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
                        id="edit_issue"
                        action="/issue/main/update"
                        accept-charset="UTF-8"
                        method="post">
                    <input name="utf8" type="hidden" value="✓">

                    <input type="hidden" name="issue_id" id="edit_issue_id" value="" />
                    <input type="hidden" name="authenticity_token" value="">
                    <?php
                    $projectSeelctTitle = '请选择项目';
                    if(!empty($project_id)){
                        $projectSeelctTitle = $project_name;
                    }

                    ?>
                    <div class="form-group hide">
                        <label class="control-label" for="issue_project_id">项目</label>
                        <div class="col-sm-10">
                            <div class="filter-item inline">
                                <div class="dropdown ">
                                    <button class="dropdown-menu-toggle js-user-search "
                                            type="button"
                                            data-onSelectedFnc="IssueMain.prototype.onChangeEditProjectSelected"
                                            data-type="user"
                                            data-first-user=""
                                            data-current-user="false"
                                            data-project-id="null"
                                            data-selected="null"
                                            data-field-name="project_id"
                                            data-field-type="project"
                                            data-default-label="<?=$projectSeelctTitle?>"
                                            data-toggle="dropdown">
                                        <span class="dropdown-toggle-text is-default"><?=$projectSeelctTitle?></span><i class="fa fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-author js-filter-submit">
                                        <div class="dropdown-title"><span>Filter by Name</span>
                                            <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                <i class="fa fa-times dropdown-menu-close-icon"></i>
                                            </button>
                                        </div>
                                        <div class="dropdown-input">
                                            <input type="search" id="" class="dropdown-input-field" placeholder="Search projects" autocomplete="off" />
                                            <i class="fa fa-search dropdown-input-search"></i>
                                            <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                        </div>
                                        <div class="dropdown-content "></div>
                                        <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group hide">
                        <label class="control-label" for="issue_type">问题类型</label>
                        <div class="col-sm-10">
                            <select id="edit_issue_types_select" name="issue_type" class="selectpicker" dropdownAlignRight="true"   data-live-search="true"   title=""   >
                                <option value="" >请选择类型</option>
                            </select>
                        </div>
                    </div>

                    <ul class="nav nav-tabs hide" id="edit_tabs" >
                        <li role="presentation" class="active"><a id="a_edit_default_tab" href="#edit_default_tab" role="tab" data-toggle="tab">默认</a></li>
                    </ul>
                    <div id="edit_master_tabs" class="tab-content">
                        <div role="tabpanel"  class="tab-pane active" id="edit_default_tab" >

                        </div>
                    </div>


                    <div class="footer-block row-content-block">

                        <a class="btn btn-cancel" data-dismiss="modal" href="#">Cancel</a>
                        <span class="append-right-10"><input type="button" name="commit" id="btn-update" value="Save changes" class="btn btn-save"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/html" id="user_tpl">
            <div class="issuable-form-select-holder">
                <input type="hidden" value="{{default_value}}" name="{{field_name}}" id="{{id}}" />
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
                            <span>Select assignee</span>
                            <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                <i class="fa fa-times dropdown-menu-close-icon"></i>
                            </button>
                        </div>
                        <div class="dropdown-input">
                            <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee" autocomplete="off" />
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
            <a class="assign-to-me-link " href="#">Assign to me</a>

</script>

<script type="text/html" id="module_tpl">
    <input type="hidden" name="{{field_name}}" id="hidden_{{id}}" value="{{default_value}}" />
    <div class="issuable-form-select-holder">
        <div class="dropdown ">
            <button class="dropdown-menu-toggle js-milestone-select js-filter-submit js-issuable-form-dropdown js-dropdown-keep-input" type="button"
                    data-show-no="true"
                    data-show-menu-above="false"
                    data-show-any="false"
                    data-show-upcoming="false"
                    data-show-started="false"
                    data-field-name="{{field_name}}"
                    data-selected="{{module_title}}"
                    data-project-id="{{project_id}}"
                    data-milestones="/config/module/{{project_id}}"
                    data-default-label="Milestone"
                    data-toggle="dropdown">
                <span class="dropdown-toggle-text is-default">{{module_title}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-selectable dropdown-menu-milestone">
                <div class="dropdown-title">
                    <span>Select Module</span>
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
                <div class="dropdown-footer">
                    <ul class="dropdown-footer-list">
                        <li>
                            <a title="New Milestone" href="/ismond/xphp/milestones/new">Create new</a></li>
                        <li>
                            <a href="/ismond/xphp/milestones">Manage Module</a></li>
                    </ul>
                </div>
                <div class="dropdown-loading">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="labels_tpl">

<div class="issuable-form-select-holder">

    {{#edit_data}}
        `<input type="hidden" name="{{field_name}}[]" value="{{id}}" />
    {{/edit_data}}

    <div class="dropdown">
        <button class="dropdown-menu-toggle js-extra-options js-filter-submit js-issuable-form-dropdown js-label-select js-multiselect"
                data-default-label="Labels"
                data-field-name="{{field_name}}[]"
                data-labels="/config/labels/{{project_id}}"
                data-namespace-path="ismond"
                data-project-path="xphp"
                data-show-no="true"
                data-toggle="dropdown"
                type="button">
            <span class="dropdown-toggle-text {{is_default}}">{{value_title}}</span>
            <i class="fa fa-chevron-down"></i>
        </button>
        <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
            <div class="dropdown-page-one">
                <div class="dropdown-title">
                    <span>Select label</span>
                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                    </button>
                </div>
                <div class="dropdown-input">
                    <input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" />
                    <i class="fa fa-search dropdown-input-search"></i>
                    <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                </div>
                <div class="dropdown-content"></div>
                <div class="dropdown-footer">
                    <ul class="dropdown-footer-list">
                        <li>
                            <a class="dropdown-toggle-page" href="#">Create new label</a></li>
                        <li>
                            <a data-is-link="true" href="/ismond/xphp/labels">Manage labels</a></li>
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
                    <span>Create new label</span>
                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                    </button>
                </div>
                <div class="dropdown-content">
                    <div class="dropdown-labels-error js-label-error"></div>
                    <input class="default-dropdown-input" id="new_label_name" placeholder="Name new label" type="text">
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
                        <input class="default-dropdown-input" id="new_label_color" placeholder="Assign custom color like #FF0000" type="text"></div>
                    <div class="clearfix">
                        <button class="btn btn-primary pull-left js-new-label-btn" type="button">Create</button>
                        <button class="btn btn-default pull-right js-cancel-label-btn" type="button">Cancel</button></div>
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
         <input type="hidden" name="{{field_name}}[]" value="{{id}}" />
        {{/edit_data}}

        <div class="dropdown">
            <button class="dropdown-menu-toggle js-extra-options js-filter-submit js-issuable-form-dropdown js-label-select js-multiselect"
                    data-default-label="Labels"
                    data-field-name="{{field_name}}[]"
                    data-labels="/config/version/{{project_id}}"
                    data-namespace-path="ismond"
                    data-project-path="xphp"
                    data-show-no="true"
                    data-toggle="dropdown"
                    type="button">
                <span class="dropdown-toggle-text {{is_default}}">{{value_title}}</span>
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
                <div class="dropdown-page-one">
                    <div class="dropdown-title">
                        <span>Select version</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-input">
                        <input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" />
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content"></div>
                    <div class="dropdown-footer">
                        <ul class="dropdown-footer-list">
                            <li>
                                <a class="dropdown-toggle-page" href="#">Create new version</a></li>
                            <li>
                                <a data-is-link="true" href="/ismond/xphp/labels">Manage version</a></li>
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
                        <span>Create new version</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-labels-error js-label-error"></div>
                        <input class="default-dropdown-input" id="new_version_name" placeholder="Name new version" type="text">
                        <div class="suggest-colors suggest-colors-dropdown">

                        </div>
                        <div class="dropdown-label-color-input">
                            <div class="dropdown-label-color-preview js-dropdown-label-color-preview"></div>
                            <input class="default-dropdown-input" id="new_version_color" placeholder="Assign description" type="text"></div>
                        <div class="clearfix">
                            <button class="btn btn-primary pull-left js-new-label-btn" type="button">Create</button>
                            <button class="btn btn-default pull-right js-cancel-label-btn" type="button">Cancel</button></div>
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
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>Upload a file</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <div class="qq-thumbnail-wrapper">
                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    Retry
                </button>

                <div class="qq-file-info">
                    <div class="qq-file-name">
                        <span class="qq-upload-file-selector qq-upload-file"></span>
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
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
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>
