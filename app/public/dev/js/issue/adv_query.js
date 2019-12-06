var IssueAdvQuery = (function () {
    // constructor
    function IssueAdvQuery() {

    };

    IssueAdvQuery.prototype.renderAdvQuery = function (details) {
        var source = $('#content_table_adv_tpl').html();
        var template = Handlebars.compile(source);
        var result = template({tableList: details});

        $("#adv-tbody").html(result);
    }

    IssueAdvQuery.prototype.renderTableAdvQuery = function (field_name, dataType, data, index) {
        var html = '';

        switch (dataType) {
            case "andor":
                html = IssueAdvQuery.prototype.makeFieldAndor(data, index, field_name);
                break;
            case "field":
                html = IssueAdvQuery.prototype.makeFieldField(data, index, field_name);
                break;
            case "opt":
                html = IssueAdvQuery.prototype.makeFieldOpt(data, index, field_name);
                break;
            case "text":
                html = IssueAdvQuery.prototype.makeFieldText(data, index, field_name);
                break;
            case "select":
                html = IssueAdvQuery.prototype.makeFieldSelect(data, index, field_name);
                break;
            case "date":
                html = IssueAdvQuery.prototype.makeFieldDate(data, index, field_name);
                break;
            case "datetime":
                html = IssueAdvQuery.prototype.makeFieldDatetime(data, index, field_name);
                break;
            case "braces":
                html = IssueAdvQuery.prototype.makeFieldBraces(data, index, field_name);
                break;
        }

        return html;
    }

    IssueAdvQuery.prototype.makeFieldText = function (data, index, field_name) {
        var html = '';
        html += '<input type="text" class="form-control" name="' + field_name + ' - ' + index + '" data-index="' + index + '" data-name="' + field_name + '"  value="' + data + '" />';

        return html;
    }

    IssueAdvQuery.prototype.makeFieldAndor = function (data, index, field_name) {
        var html = '<select name="' + field_name + '-' + index + '" data-index="' + index + '" data-name="' + field_name + '" class="selectpicker" dropdownAlignRight="true" title="关系">';
            if (data == "and") {
                html += '<option value="and" selected="selected"> 并且</option><option value="or"> 或者</option>';
            } else {
                html += '<option value="and"> 并且</option><option value="or" selected="selected"> 或者</option>'
            }

        html += "</select>";
        return html;
    }

    IssueAdvQuery.prototype.makeFieldField = function (data, index, field_name) {
        var html = '<select name="' + field_name + '-' + index + '" data-index="' + index + '" data-name="' + field_name + '" class="selectpicker" dropdownAlignRight="true" title="字段">';
        if (data == "and") {
            html += '<option value="and" selected="selected"> 并且</option><option value="or"> 或者</option>';
        } else {
            html += '<option value="and"> 并且</option><option value="or" selected="selected"> 或者</option>'
        }

        html += "</select>";
        return html;
    }

    IssueAdvQuery.prototype.makeFieldOpt = function (data, index, field_name) {
        var options = ["LIKE", "LIKE %...%", "NOT LIKE", "=", "!=", "REGEXP", "REGEXP ^...$", "NOT REGEXP", "= ''", "!= ''", "IN (...)", "NOT IN (...)", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        var html = '<select name="' + field_name + '-' + index + '" data-index="' + index + '" data-name="' + field_name + '" class="selectpicker" dropdownAlignRight="true" title="操作符">';

        options.forEach(function (n, i) {
            if (n == data) {
                html += '<option value="' + n + '" selected="selected">' + n + '</option>';
            } else {
                html += '<option value="' + n + '">' + n + '</option>';
            }
        });

        html += "</select>";

        return html;
    }

    IssueAdvQuery.prototype.makeFieldBraces = function (data, index, field_name) {
        var options = ["(", ")", "{", "}"];
        var html = '<select name="' + field_name + '-' + index + '" data-index="' + index + '" data-name="' + field_name + '" class="selectpicker" dropdownAlignRight="true" title="请选择">';

        options.forEach(function (n, i) {
            if (n == data) {
                html += '<option value="' + n + '" selected="selected">' + n + '</option>';
            } else {
                html += '<option value="' + n + '">' + n + '</option>';
            }
        });

        html += "</select>";

        return html;
    }

    IssueAdvQuery.prototype.makeFieldSelect = function (data, index, field_name) {
        var html = '<select name="' + field_name + '-' + index + '" class="selectpicker" data-index="' + index + '" data-name="' + field_name + '" dropdownAlignRight="true" title="关系">';
        if (data == "and") {
            html += '<option value="and" selected="selected"> 并且</option><option value="or"> 或者</option>';
        } else {
            html += '<option value="and"> 并且</option><option value="or" selected="selected"> 或者</option>'
        }

        html += "</select>";
        return html;
    }

    IssueAdvQuery.prototype.makeFieldDate = function (data, index, field_name) {
        var html = '';
        html += '<input type="text" class="laydate_input_date" name="' + field_name + ' - ' + index + '" placeholder="yyyy-MM-dd" value="' + data + '">';

        return html;
    }

    IssueAdvQuery.prototype.makeFieldDatetime = function (data, index, field_name) {
        var html = '';
        html += '<input type="text" class="laydate_input_datetime" name="' + field_name + ' - ' + index + '" placeholder="yyyy-MM-dd HH:mm:ss" value="' + data + '">';

        return html;
    }

    return IssueAdvQuery;
})();
