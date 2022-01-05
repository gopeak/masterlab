var IssueAdvQuery = (function () {
    // constructor
    var adv_options = {
        modules: [],
        resolves: [],
        status: [],
        issueTypes: [],
        priority: [],
        sprints: [],
        users: [],
        logics: [
            {
                name: "并且",
                value: "and"
            },
            {
                name: "或者",
                value: "or"
            }
        ],
        opts: [
            { value: "LIKE" },
            { value: "LIKE %...%" },
            //{ value: "NOT LIKE" },
            { value: "=" },
            { value: "!=" },
            { value: ">" },
            { value: ">=" },
            { value: "<" },
            { value: "<=" },
            { value: "REGEXP" },
            { value: "REGEXP ^...$" }
            //{ value: "NOT REGEXP" },
            //{ value: "= ''" },
            //{ value: "!= ''" },
            //{ value: "IN (...)" },
            //{ value: "NOT IN (...)" },
            //{ value: "BETWEEN" },
            //{ value: "NOT BETWEEN" },
            //{ value: "IS NULL" },
            //{ value: "IS NOT NULL" }
        ],
        braces: [
            { value: ""},
            { value: "("},
            { value: ")"}
        ],
        fields: []
    };

    function IssueAdvQuery(options) {
        var tempOptions = JSON.parse(JSON.stringify(options));
        //console.log("options", options);
        //console.log("advFields", advFields);
        for (  key in  advFields ) {
            var value = advFields[key];
            adv_options.fields.push({
                value: value.title,
                title: value.title,
                source: value.source,
                type: value.type,
                opt:value.opt,
                name:key
            });
        }
        for(var i=0; i<tempOptions.issue_module.length; i++){
            let row = tempOptions.issue_module[i];
            adv_options.modules.push({
                name: row.name,
                value: row.id
            });
        }
        for(var i=0; i<tempOptions.issue_resolve.length; i++){
            let row = tempOptions.issue_resolve[i];
            adv_options.resolves.push({
                name: row.name,
                value: row.id
            });
        }
        for(var i=0; i<tempOptions.issue_status.length; i++){
            let row = tempOptions.issue_status[i];
            adv_options.status.push({
                name: row.name,
                value: row.id
            });
        }
        for(var i=0; i<tempOptions.issue_types.length; i++){
            let row = tempOptions.issue_types[i];
            adv_options.issueTypes.push({
                name: row.name,
                value: row.id
            });
        }
        for(var i=0;  i<tempOptions.priority.length; i++){
            let row = tempOptions.priority[i];
            adv_options.priority.push({
                name: row.name,
                value: row.id
            });
        }
        //console.log(adv_options.priority)
        adv_options.sprints = tempOptions.sprint;

        for(var i=0;i<tempOptions.users.length; i++){
            let row = tempOptions.users[i];
            adv_options.users.push({
                name: row.display_name,
                value: row.uid
            });
        }
        //console.log(adv_options)
    };

    IssueAdvQuery.prototype.renderAdvQuery = function (details) {

        console.log('details:');
        console.log(details);
        var result = '<tr ><td colspan="8" style="cursor: default" >' +
            '<div class="status status-search" data-direction="vertical">\n' +
            '            <div class="img" ></div>\n' +
            '            <div class="inner">\n' +
            '            <div class="message">\n' +
            '            查询条件为空,请添加\n' +
            '            </div> \n' +
            '        </div>\n' +
            '        </div>' +
            '</td></tr>';

        if(details.length>0){
            var source = $('#content_table_adv_tpl').html();
            var template = Handlebars.compile(source);
            var result = template({tableList: details});
        }
        $("#adv-tbody").html(result);
    }

    IssueAdvQuery.prototype.renderListAdvQuery = function (details) {

        //console.log(details)
        if(is_empty(details)){
            $('#adv_query_display_container').addClass('hide');
        }else{
            $('#adv_query_display_container').removeClass('hide');
        }
        var source = $('#adv_query_display_tpl').html();
        var template = Handlebars.compile(source);
        var result = template({tableList: details,length:details.length-1});

        $("#adv_query_diplay").html(result);
    }

    IssueAdvQuery.prototype.saveAdvQuery = function (name) {

        if(is_empty(name)){
            notify_warn('提示','过滤器名称不能为空!');
            return;
        }
        // sort_by
        var filterJson =  JSON.stringify(adv_details);
        if(is_empty(adv_details)){
            notify_warn('提示','查询条件为空!');
            return;
        }
        var sort_field = $('#adv_sort_field').val();
        var sort_by = $('#adv_sort_by').val();
        var is_project_filter = $("#is_adv_project_filter").is(':checked');
        var is_project_filter_value = is_project_filter ? "1" :"0";
        var postData = {
            project_id: window._cur_project_id,
            name: name,
            filter: filterJson,
            sort_field:sort_field,
            sort_by:sort_by ,
            is_project_filter:is_project_filter_value
        };
        console.log(postData);
        //return;
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'issue/main/save_adv_filter',
            data: postData,
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == '200') {
                    notify_success('保存成功');
                    window.location.reload();
                    $('#modal-adv_query').modal('hide');
                    window.qtipApi.hide();
                    $('#btn-save_adv_filter').qtip('api').toggle(false);
                } else {
                    notify_error('保存失败,错误信息:' + resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueAdvQuery.prototype.requestAdvQuery = function (page=1, success=null) {

        var tempData = JSON.parse(JSON.stringify(adv_details));
        var temp = tempData.map(function (n) {
            return {
                logic: n.logic,
                start_braces: n.start_braces,
                field: n.field,
                opt: n.opt,
                value: n.value,
                end_braces: n.end_braces
            }
        });
        var adv_data = tempData.map(function (n) {
            return n
        });
        if (window.qtipApi) {
            window.qtipApi.hide();
            $('#btn-save_adv_filter').qtip('api').toggle(false);
        }
        if (is_empty(temp)) {
            notify_warn('提示', '查询条件为空!提示：选择查询条件后要点击"添加条件"按钮哦');
            return;
        }
        var queryData = JSON.stringify(temp);
        IssueMain.prototype.fetchIssuesByAdvQueryIssue(queryData, success, adv_data, page);
    }

    IssueAdvQuery.prototype.renderTableAdvQuery = function (field_name, dataType, data, index, title, source) {
        var html = '';

        switch (dataType) {
            case "text":
                html = IssueAdvQuery.prototype.makeFieldText(data, index, field_name);
                break;
            case "select":
                html = IssueAdvQuery.prototype.makeFieldSelect(data, index, field_name, title, source);
                break;
            case "opt":
                html = IssueAdvQuery.prototype.makeFieldOpt(data, index, field_name, title, source);
                break;
            case "date":
                html = IssueAdvQuery.prototype.makeFieldDate(data, index, field_name);
                break;
            case "datetime":
                html = IssueAdvQuery.prototype.makeFieldDatetime(data, index, field_name);
                break;
        }

        return html;
    }

    IssueAdvQuery.prototype.makeOptSelect = function (field_name) {
        var adv_opt_select = document.getElementById('adv_opt');
        $('#adv_opt').empty();

        var fields = adv_options['fields'];
        //console.log('fields:');
        //console.log(fields);
        var opt_arr = [];
        for(var i=0;i<fields.length;i++){
            if(field_name===fields[i]['name']){
                opt_arr = fields[i]['opt'].split(',');
            }
        }
        if(!opt_arr){
            opt_arr = ['='];
        }
        for(var i=0;i<opt_arr.length;i++){
            var opt_value = opt_arr[i];
            var selected = '';
            if(i==0){
                selected = 'selected';
            }
            var opt = "<option "+selected+" value='"+opt_value+"'>"+opt_value+"</option>";
            $('#adv_opt').append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    IssueAdvQuery.prototype.makeFieldText = function (data, index, field_name) {
        var html = '';
        var inputName = field_name + '-' + index;
        if (index === "") {
            inputName = field_name;
        }
        html += '<input type="text" class="form-control" name="' + inputName + '" data-index="' + index + '" data-name="' + field_name + '"  value="' + data + '" />';

        return html;
    }
    //
    IssueAdvQuery.prototype.makeFieldOpt = function (data, index, field_name, title, source) {
        var fields = adv_options['fields'];
        var opt_arr = [];
        for(var i=0;i<fields.length;i++){
            if(source===fields[i]['name']){
                opt_arr = fields[i]['opt'].split(',');
            }
        }
        if(!opt_arr){
            opt_arr = ['='];
        }
        var inputName = field_name + '-' + index;
        var html = '<select  class="form-control" name="' + inputName + '" data-index="' + index + '" data-name="' + field_name + '"   >';
        for(var i=0;i<opt_arr.length;i++){
            var opt_value = opt_arr[i];
            var selected = '';
            if(data==opt_value){
                selected = 'selected';
            }
            html += "<option "+selected+" value='"+opt_value+"'>"+opt_value+"</option>";

        }
        html += "</select>";
        return html;
    }
    IssueAdvQuery.prototype.makeFieldSelect = function (data, index, field_name, title, source) {
        var temp = {
            value: data,
            index: index,
            field_name: field_name,
            title: title,
            data: []
        }
        if(source){
            if(_.has(adv_options, source)){
                temp.data = adv_options[source]
            }else{
                source= source + "s";
                if(_.has(adv_options, source)){
                    temp.data = adv_options[source]
                }else{
                    temp.data = []
                }
            }
        }else{
            temp.data = []
        }
        //console.log(temp.data);
        if(_.isArray(temp.data)){
            for(var i=0;i++;i<temp.data.length){
                if(temp.value===temp.data[i]){
                    temp.data[i].selected = true;
                }
            }
        }else{
            temp.data.forEach(function (n) {
                if (n.value === temp.value) {
                    n.selected = true;
                }
            });
        }


        var source = $('#adv_query_form_tpl').html();
        var template = Handlebars.compile(source);
        var html = template(temp);

        return html;
    }

    IssueAdvQuery.prototype.makeFieldDate = function (data, index, field_name) {
        var html = '';
        var className = "form-control";
        var inputName = field_name + '-' + index;
        if (index === "") {
            inputName = field_name;
        }
        html += '<input type="text" class="laydate_input laydate_input_date ' + className + '" data-index="' + index + '" data-name="' + field_name + '" name="' + inputName + '" placeholder="yyyy-MM-dd" value="' + data + '">';

        return html;
    }

    IssueAdvQuery.prototype.makeFieldDatetime = function (data, index, field_name) {
        var html = '';
        var className = "form-control";
        var inputName = field_name + '-' + index;
        if (index === "") {
            inputName = field_name;
        }
        html += '<input type="text" class="laydate_input laydate_input_datetime ' + className + '" data-index="' + index + '" data-name="' + field_name + '" name="' + inputName + '" placeholder="yyyy-MM-dd HH:mm:ss" value="' + data + '">';

        return html;
    }

    return IssueAdvQuery;
})();
