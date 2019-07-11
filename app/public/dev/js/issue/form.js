var IssueForm = (function () {

    var _options = {};

    var _active_tab = 'create_default_tab';

    var _allow_update_status = [];

    var _allow_add_status = [];

    // constructor
    function IssueForm(options) {
        _options = options;

    };

    IssueForm.prototype.getOptions = function () {
        return _options;
    };

    IssueForm.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };


    IssueForm.prototype.isExistOption = function (id, value) {
        var isExist = false;
        var count = $('#' + id).find('option').length;
        for (var i = 0; i < count; i++) {
            if ($('#' + id).get(0).options[i].value == value) {
                isExist = true;
                break;
            }
        }
        return isExist;
    }

    IssueForm.prototype.makeCreateHtml = function (configs, fields, tab_id, allow_add_status, issue) {
        _allow_add_status = allow_add_status;
        var html = '';
        for (var i = 0; i < configs.length; i++) {
            var config = configs[i];
            if (config.tab_id != tab_id) {
                continue;
            }
            var field = IssueForm.prototype.getField(fields, config.field_id);
            if (field.default_value == null) {
                field.default_value = '';
            }

            if (issue && issue.hasOwnProperty(field.name)) {
                field.default_value = issue[field.name];
            }

            html += IssueForm.prototype.createField(config, field, 'create');
        }
        //console.log(html);
        return html;
    }

    IssueForm.prototype.makeEditHtml = function (configs, fields, tab_id, issue) {
        var html = '';
        _allow_update_status = issue.allow_update_status;
        for (var i = 0; i < configs.length; i++) {
            var config = configs[i];
            if (config.tab_id != tab_id) {
                continue;
            }
            var field = IssueForm.prototype.getField(fields, config.field_id);
            if (field.default_value == null) {
                field.default_value = '';
            }
            if (issue.hasOwnProperty(field.name)) {
                field.default_value = issue[field.name];
            }

            html += IssueForm.prototype.createField(config, field, 'edit');
        }
        //console.log(html);
        return html;
    }

    IssueForm.prototype.uiAddTab = function (type, title, tab_id) {
        if (typeof (tab_id) == 'undefined' || tab_id == 0 || tab_id == null) {
            var tab_last_index = $("#master_tabs").children().length;
        } else {
            var tab_last_index = tab_id;
        }

        //alert( tab_last_index );
        var id = type + "_tab-" + tab_last_index;

        var tpl = $('#nav_tab_li_tpl').html();
        var template = Handlebars.compile(tpl);
        var li = template({id: id, title: title});
        var existing = $("#" + type + "_master_tabs").find("[id='" + id + "']");

        if ($("#a_" + type + "_tab-" + tab_last_index).length === 0) {
            $("#" + type + "_tabs").append(li);
        }

        if (existing.length == 0) {
            var source = $('#content_tab_tpl').html();
            var template = Handlebars.compile(source);
            var result = template({id: id, type: type});
            $("#" + type + "_master_tabs").append(result);
        }
        _active_tab = id;
        $(".nav-tabs li").removeClass('active');
        $(".tab-pane").removeClass('active');
        $('#' + type + '_default_tab').css('display', '')
        IssueForm.prototype.bindNavTabClick();
        $('#a_' + type + '_default_tab').click();

        return;
    }

    IssueForm.prototype.bindNavTabClick = function (e) {
        $('.nav-tabs a').click(function (e) {
            if ($(this).attr('id') != 'new_tab') {
                e.preventDefault()
                _active_tab = $(this).attr('id').replace('a_', '');
                $(this).tab('show')
            }
        });
    }


    IssueForm.prototype.checkFieldInUi = function (configs, field_id) {
        for (var j = 0; j < configs.length; j++) {
            if (configs[j].field_id == field_id) {
                return true;
            }
        }
        return false;
    };

    IssueForm.prototype.makeProjectField = function (data, callback) {
        $.ajax({
            type: "get",
            dataType: "json",
            async: true,
            url: root_url + "projects/fetchAll",
            success: function (resp) {
                var projects = resp.data.projects;
                var project_data = {
                    name: ""
                };

                for (var index in projects) {
                    var value = projects[index];
                    if (value.id == data.project_id) {
                        project_data["name"] = value.name;
                        _cur_project_key = value.key;
                    }
                }

                source = $('#project-selected_tpl').html();
                template = Handlebars.compile(source);
                result = template(project_data);
                $('#project-selected').html(result);

                callback();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
                callback();
            }
        });
    };

    IssueForm.prototype.createField = function (config, field, ui_type) {

        var html = '';

        switch (field.type) {
            case "TEXT":
                html += IssueForm.prototype.makeFieldText(config, field, ui_type);
                break;
            case "TEXT_MULTI_LINE":
                html += IssueForm.prototype.makeFieldTextMulti(config, field, ui_type);
                break;
            case "PRIORITY":
                html += IssueForm.prototype.makeFieldPriority(config, field, ui_type);
                break;
            case "STATUS":
                html += IssueForm.prototype.makeFieldStatus(config, field, ui_type);
                break;
            case "RESOLUTION":
                html += IssueForm.prototype.makeFieldResolution(config, field, ui_type);
                break;
            case "MODULE":
                html += IssueForm.prototype.makeFieldModule(config, field, ui_type);
                break;
            case "LABELS":
                html += IssueForm.prototype.makeFieldLabels(config, field, ui_type);
                break;
            case "UPLOAD_IMG":
                html += IssueForm.prototype.makeFieldUploadImg(config, field, ui_type);
                break;
            case "UPLOAD_FILE":
                html += IssueForm.prototype.makeFieldUploadFile(config, field, ui_type);
                break;
            case "VERSION":
                html += IssueForm.prototype.makeFieldVersion(config, field, ui_type);
                break;
            case "USER":
                html += IssueForm.prototype.makeFieldUser(config, field, ui_type);
                break;
            case "USER_MULTI":
                html += IssueForm.prototype.makeFieldMultiUser(config, field, ui_type);
                break;
            case "MILESTONE":
                html += IssueForm.prototype.makeFieldText(config, field, ui_type);
                break;
            case "SPRINT":
                html += IssueForm.prototype.makeFieldSprint(config, field, ui_type);
                break;
            case "TEXTAREA":
                html += IssueForm.prototype.makeFieldTextarea(config, field, ui_type);
                break;
            case "MARKDOWN":
                html += IssueForm.prototype.makeFieldMarkdown(config, field, ui_type);
                break;
            case "RADIO":
                html += IssueForm.prototype.makeFieldRadio(config, field, ui_type);
                break;
            case "CHECKBOX":
                html += IssueForm.prototype.makeFieldCheckbox(config, field, ui_type);
                break;
            case "SELECT":
                html += IssueForm.prototype.makeFieldSelect(config, field, ui_type, false);
                break;
            case "SELECT_MULTI":
                html += IssueForm.prototype.makeFieldSelect(config, field, ui_type);
                break;
            case "DATE":
                html += IssueForm.prototype.makeFieldDate(config, field, ui_type);
                break;
            default:
                html += IssueForm.prototype.makeFieldText(config, field, ui_type);
        }

        return html;
    }

    IssueForm.prototype.wrapField = function (config, field, field_html) {
        var display_name = field.title;
        var required_html = '';
        if (config.order_weight == "" || config.order_weight == null) {
            config.order_weight = 0;
        }
        var order_weight = parseInt(config.order_weight);
        if (config.required) {
            required_html = new Handlebars.SafeString('<span class="required"> *</span>');
        }
        var data = {
            config: config,
            field: field,
            display_name: display_name,
            order_weight: order_weight,
            required_html: required_html,
            required:config.required
        };
        if (config.required) {
            field_html += "\n"+'<p id="tip-'+field.name+'" class="gl-field-error hide"></p>';
        }
        var source = $('#wrap_field').html();
        var template = Handlebars.compile(source);
        var html = template(data).replace("{field_html}", field_html);

        return html;
    }

    IssueForm.prototype.makeFieldTextMulti = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        if (default_value == null) {
            default_value = '';
        }

        var id = ui_type + "_issue_textmulti_" + name;
        var html = '';
        html += '<input type="text" multiple class="form-control" name="' + field_name + '" id="' + id + '"  value="' + default_value + '"   />';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldText = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value

        if (default_value == null) {
            default_value = '';
        }
        var id = ui_type + '_issue_text_' + name;
        var html = '';
        html += '<input type="text" class="form-control" name="' + field_name + '" id="' + id + '"  value="' + default_value + '"  />';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldLabels = function (config, field, ui_type) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value;
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var html = '';
        //html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'"  />';
        var edit_data = [];

        if (default_value !== null) {
            for (var i = 0; i < default_value.length; i++) {
                edit_data.push();
            }
        }

        var value_title = '';
        if (edit_data.length > 0) {
            if (edit_data.length == 1) {
                value_title = edit_data[0].title;
            }
            if (edit_data.length == 2) {
                value_title = edit_data[0].title + ',' + edit_data[1].title;
            }
            if (edit_data.length > 2) {
                value_title = value_title + '+';
            }
        }
        var is_default = 'is-default';
        if (edit_data.length > 0) {
            is_default = '';
        }
        var data = {
            project_id: _cur_form_project_id,
            project_key: _cur_project_key,
            display_name: display_name,
            default_value: default_value,
            field_name: field_name,
            edit_data: edit_data,
            value_title: value_title,
            is_default: is_default,
            name: field.name,
            id: ui_type + "_issue_labels_" + name
        };

        var source = $('#labels_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldUploadImg = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_upload_img_' + name;
        var id_uploder = id + '_uploader'
        var html = '';
        html = '<input type="hidden"  name="' + field_name + '" id="' + id + '"  value=""  /><div id="' + id_uploder + '" class="fine_uploader_img"></div>';
        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldUploadFile = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_upload_file_' + name;
        var id_uploder = id + '_uploader'
        var id_qrcoder = ui_type + '_qrcode'
        var html = '';
        var uploadHtml = '';

        if (isInArray(window._projectPermArr, 'CREATE_ATTACHMENTS')) {
            uploadHtml = '<a href="#" onclick="IssueForm.prototype.show(' + id_qrcoder + ') ">通过手机上传</a> <div ><img src="" id="' + id_qrcoder + '" style="display: none"></div>';
        }
        html = uploadHtml + '<input type="hidden"  name="' + field_name + '" id="' + id + '"  value=""  /><div id="' + id_uploder + '" class="fine_uploader_attchment"></div>';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.show = function (id) {

        var show = $(id).css('display');
        $(id).css('display', show == 'block' ? 'none' : 'block');
        var tmp_issue_id = window._curTmpIssueId;
        var issue_id = window._curIssueId;
        var url = root_url + "issue/main/qr?tmp_issue_id=" + tmp_issue_id + "&issue_id=" + issue_id;

        $(id).attr('src', url);

        if (show == 'none') {
            IssueForm.prototype.startMobileUploadInterval();
        } else {
            IssueForm.prototype.clearMobileUploadInterval();
        }

    }

    IssueForm.prototype.makeFieldVersion = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var html = '';
        var edit_data = [];
        if (default_value != null) {
            for (var i = 0; i < default_value.length; i++) {
                var item_value = IssueForm.prototype.getObjectValue(_issueConfig.issue_version, default_value[i]);
                if (item_value) {
                    edit_data.push(item_value);
                }
            }
        } else {
            default_value = '';
        }

        var value_title = '';
        if (edit_data.length > 0) {
            if (edit_data.length == 1) {
                value_title = edit_data[0].name;
            }
            if (edit_data.length == 2) {
                value_title = edit_data[0].name + ',' + edit_data[1].name;
            }
            if (edit_data.length > 2) {
                value_title = edit_data[0].name + '+';
            }
        }
        var is_default = 'is-default';
        if (edit_data.length > 0) {
            is_default = '';
        }
        console.log('edit_data:', edit_data);
        var data = {
            project_id: _cur_form_project_id,
            display_name: display_name,
            default_value: default_value,
            is_default: is_default,
            edit_data: edit_data,
            value_title: value_title,
            field_name: field_name,
            name: field.name,
            id: ui_type + "_issue_version_" + name
        };
        console.log(data);
        var source = $('#version_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);
        //console.log( html );
        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldUser = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        if (default_value == null || default_value == 'null') {
            default_value = '';
        }
        var user = null;
        if (default_value != '') {
            user = getValueByKey(_issueConfig.users, field.default_value);
            if (!objIsEmpty(user)) {
                display_name = user.display_name;
            }
        }
        var project_id = '';
        if (typeof window._cur_project_id != 'undefined') {
            project_id = _cur_project_id
        }
        var html = '';
        // html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'"  />';
        var data = {
            display_name: display_name,
            default_value: default_value,
            field_name: field_name,
            name: field.name,
            project_id: project_id,
            id: ui_type + "_issue_user_" + name
        };

        var source = $('#user_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldMultiUser = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + '][]';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        if (default_value == null || default_value == 'null') {
            default_value = '';
        }

        var edit_data = [];
        if (default_value != null) {
            for (var i = 0; i < default_value.length; i++) {
                edit_data.push({id: default_value[i]});
            }
        } else {
            default_value = '';
        }

        var html = '';
        // html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'"  />';
        var data = {
            display_name: display_name,
            default_value: default_value,
            field_name: field_name,
            name: field.name,
            id: ui_type + "_issue_user_" + name,
            edit_data: edit_data
        };

        var source = $('#multi_user_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field, html);
    }


    IssueForm.prototype.makeFieldSprint = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_' + name;

        var html = '';
        html = '<select id="' + id + '" name="' + field_name + '" class="selectpicker"  title=""   >';
        if (default_value == '0') {
            html += '<option value="0" selected>待办事项</option>';
        } else {
            html += '<option value="0">待办事项</option>';
        }


        var sprint = _issueConfig.sprint;
        console.log("sprint:");
        console.log(sprint);
        //alert(window._is_created_backlog);
        for (var i in sprint) {
            var sprint_id = sprint[i].id;
            var sprint_title = sprint[i].name;
            var selected = '';
            if (window._is_created_backlog === undefined || !window._is_created_backlog) {
                if (default_value != '0' && (sprint_id == default_value || window._active_sprint_id === sprint_id)) {
                    selected = 'selected';
                }
            }

            html += '<option data-content="<span >' + sprint_title + '</span>" value="' + sprint_id + '" ' + selected + '>' + sprint_title + '</option>';

        }
        html += '</select>';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldPriority = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_' + name;

        var html = '';
        html = '<select id="' + id + ' " name="' + field_name + '" class="selectpicker"    title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var priority = _issueConfig.priority;
        for (var i in priority) {
            var priority_id = priority[i].id;
            var priority_title = priority[i].name;
            var color = priority[i].status_color;
            var selected = '';
            if (priority_id == default_value) {
                selected = 'selected';
            }
            html += '   <option data-content="<span style=\'color:' + color + '\'>' + priority_title + '</span>" value="' + priority_id + '" ' + selected + '>' + priority_title + '</option>';

        }
        html += '</select>';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldStatus = function (config, field, ui_type) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_' + name;

        var html = '';
        html = '<select id="' + id + ' " name="' + field_name + '" class="selectpicker"    title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var statusArr = _allow_add_status;
        if (ui_type == 'edit') {
            statusArr = _allow_update_status;
        } else {
            html += '<option data-content="<span >请选择</span>" value="" >请选择</option>';
        }
        //console.log("default_value:"+default_value);
        //console.log(statusArr);
        for (var i = 0; i < statusArr.length; i++) {

            var status_id = statusArr[i].id;
            var status_title = statusArr[i].name;
            var color = statusArr[i].color;
            var selected = '';
            if (status_id == default_value) {
                selected = 'selected';
            }
            html += '   <option data-content="<span class=\'label label-' + color + ' prepend-left-5\' >' + status_title + '</span>" value="' + status_id + '" ' + selected + '>' + status_title + '</option>';

        }
        html += '</select>';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    // makeFieldSattus

    IssueForm.prototype.makeFieldResolution = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_' + name;

        var html = '';
        html = '<select id="' + id + '" name="' + field_name + '" class="selectpicker"  title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var resolve = _issueConfig.issue_resolve;

        html += '   <option  value=""  >请选择</option>';
        for (var i in resolve) {
            var resolve_id = resolve[i].id;
            var resolve__title = resolve[i].name;
            var color = resolve[i].color;
            var selected = '';
            if (resolve_id == default_value) {
                selected = 'selected';
            }
            html += '   <option data-content="<span style=\'color:' + color + '\'>' + resolve__title + '</span>" value="' + resolve_id + '" ' + selected + '>' + resolve__title + '</option>';

        }
        html += '</select>';

        return IssueForm.prototype.wrapField(config, field, html);
    }


    IssueForm.prototype.makeFieldModule = function (config, field, ui_type) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var html = '';
        var module = IssueForm.prototype.getModule(_issueConfig.issue_module, default_value);
        var module_title = display_name;
        if (module.hasOwnProperty("name")) {
            module_title = module.name;
        }
        if (default_value == null || default_value == 'null') {
            default_value = '';
        }
        var project_id = '';
        if (is_empty(_cur_form_project_id)) {
            _cur_form_project_id = _cur_project_id;
        }
        project_id = _cur_form_project_id;

        var data = {
            project_id: project_id,
            project_key: _cur_project_key,
            display_name: display_name,
            module_title: module_title,
            default_value: default_value,
            field_name: field_name,
            name: field.name,
            id: ui_type + "_issue_" + name
        };

        var source = $('#module_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldDate = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_laydate_' + name;
        if (default_value == null || default_value == 'null') {
            default_value = '';
        }
        var html = '';
        html += '<div class="form-group"><div class="col-xs-6"> <input type="text" class="laydate_input_date form-control" name="' + field_name + '" id="' + id + '"  value="' + default_value + '"  /></div></div>';

        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldTextarea = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }

        var id = ui_type + '_issue_textarea_' + name;

        var html = '';
        html += '<textarea placeholder="" class="form-control" rows="3" maxlength="250" name="' + field_name + '" id="' + id + '" >' + default_value + '</textarea>';
        return IssueForm.prototype.wrapField(config, field, html);
    }


    IssueForm.prototype.makeFieldMarkdown = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_simplemde_' + name;
        // var html = '<textarea class="simplemde_text" name="'+field_name+'" id="'+id+'">'+default_value+'</textarea>';
        var html = '<div class="simplemde_text" id="' + id + '"><textarea style="display:none;" name="' + field_name + '">' + default_value + '</textarea></div>';

        return IssueForm.prototype.wrapField(config, field, html);
    }


    IssueForm.prototype.makeFieldRadio = function (config, field, ui_type) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var html = '';

        if (field.options) {
            for (var Key in field.options) {
                var selected = '';
                if (Key == default_value) {
                    selected = 'checked=true';
                }
                var id = ui_type + '_issue_' + name + Key;
                html += '<div class="radio"><label><input ' + selected + '  type="radio" name="' + field_name + '" id="' + id + '"  value="' + Key + '" disabled >' + field.options[Key] + '</label></div>';
            }
        }
        //<div class="radio"> <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Option two  </label></div>
        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldCheckbox = function (config, field, ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';
        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var html = '';
        if (field.options) {
            for (var Key in field.options) {
                var selected = '';
                if (Key == default_value) {
                    selected = 'checked=true';
                }
                var id = ui_type + '_issue_' + name + Key;
                html += '<input ' + selected + '  type="checkbox" class="form-control" name="' + field_name + '" id="' + id + '"  value="' + Key + '" />' + field.options[Key];
            }
        }
        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.makeFieldSelect = function (config, field, ui_type, isMulti) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params[' + name + ']';
        var default_value = field.default_value
        var required_html = '';

        if (required) {
            required_html = '<span class="required"> *</span>';
        }
        var id = ui_type + '_issue_select_' + name;
        var multi = '';
        if (isMulti) {
            multi = 'multiple ';
        }
        var html = '';
        html += '<select ' + multi + ' class="form-control" name="' + field_name + '" id="' + id + '"   />';
        if (field.options) {
            for (var Key in field.options) {
                var selected = '';
                if (Key == default_value) {
                    selected = 'selected';
                }
                html += '<option value="' + Key + '">' + field.options[Key] + '</option>';
            }
        }
        html += '</select>';
        return IssueForm.prototype.wrapField(config, field, html);
    }

    IssueForm.prototype.getField = function (fields, field_id) {

        var field = {};
        for (var i = 0; i < fields.length; i++) {
            if (fields[i].id == field_id) {
                return fields[i];
            }
        }
        return field;
    }

    IssueForm.prototype.getModule = function (modules, module_id) {

        var module = {};
        for (var i = 0; i < modules.length; i++) {
            if (modules[i].id == module_id) {
                return modules[i];
            }
        }
        return module;
    }

    IssueForm.prototype.getVersion = function (versions, version_id) {

        var version = {};
        for (var i = 0; i < versions.length; i++) {
            if (versions[i].id == version_id) {
                return versions[i];
            }
        }
        return version;
    }

    IssueForm.prototype.getArrayValue = function (arrs, id) {
        var obj = null;
        var _arrs = [];
        if (!$.isArray(arrs)) {
            _arrs = Object.values(arrs);
        } else {
            _arrs = arrs;
        }

        for (var i = 0; i < _arrs.length; i++) {
            if (parseInt(_arrs[i].id) === parseInt(id)) {
                return _arrs[i];
            }
        }
        return obj;
    }

    IssueForm.prototype.getObjectValue = function (objs, id) {
        var obj = null;
        for (var i in objs) {
            if (parseInt(objs[i].id) === parseInt(id)) {
                return objs[i];
            }
        }
        return obj;
    }

    IssueForm.prototype.createLabel = function (data, e) {
        $.ajax({
            type: "post",
            dataType: "json",
            async: true,
            data: data,
            url: root_url + "project/label/add?project_id=" + _cur_form_project_id,
            success: function (resp) {
                $(e.currentTarget).parent().find(".js-cancel-label-btn").trigger("click");
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueForm.prototype.createModule = function (data, e) {
        $.ajax({
            type: "post",
            dataType: "json",
            async: true,
            data: data,
            url: root_url + "project/module/add?project_id=" + _cur_form_project_id,
            success: function (resp) {
                $(e.currentTarget).parent().find(".js-cancel-label-btn").trigger("click");
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueForm.prototype.createModule = function (data, e) {
        $.ajax({
            type: "post",
            dataType: "json",
            async: true,
            data: data,
            url: root_url + "project/module/add?project_id=" + _cur_form_project_id,
            success: function (resp) {
                $(e.currentTarget).parent().find(".js-cancel-label-btn").trigger("click");
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueForm.prototype.checkMobileUpload = function () {

        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: "/issue/main/fetchMobileAttachment",
            data: {tmp_issue_id: window._curTmpIssueId, issue_id: window._curIssueId},
            success: function (resp) {
                //alert(resp.msg);
                if (typeof(window._curFineAttachmentUploader) == 'object') {

                    var haveUploads = window._curFineAttachmentUploader.getUploads({
                        status: qq.status.UPLOAD_SUCCESSFUL
                    });
                    console.log(haveUploads);
                    for (var i = 0; i < resp.data.length; i++) {
                        var mobileFile = resp.data[i];
                        console.log(mobileFile);
                        var added = false;
                        for (var j = 0; j < haveUploads.length; j++) {
                            if (haveUploads[j].uuid == mobileFile.uuid && haveUploads[j].size == mobileFile.size) {
                                added = true;
                                break;
                            }
                        }
                        if (!added) {
                            window._curFineAttachmentUploader.addInitialFiles([mobileFile]);
                        }
                    }
                }
            },
            error: function (res) {
                console.error(res);
            }
        });
    }

    IssueForm.prototype.startMobileUploadInterval = function () {
        window.mobileUploadInterval = window.setInterval("IssueForm.prototype.checkMobileUpload()", 5000);
    }

    IssueForm.prototype.clearMobileUploadInterval = function () {
        window.clearInterval(window.mobileUploadInterval);
    }

    return IssueForm;
})();


