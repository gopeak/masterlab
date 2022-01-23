$(function () {

    if ("undefined" != typeof Handlebars.registerHelper) {
        Handlebars.registerHelper('if_eq', function (v1, v2, opts) {
            if (v1 == v2)
                return opts.fn(this);
            else
                return opts.inverse(this);
        });
    }

    Handlebars.registerHelper('if_in_array', function (value, arr, opts) {
        //console.log(value,arr );
        var ret = false;
        if(arr){
            for (i = 0; i < arr.length; i++) {
                if (value == arr[i]) {
                    ret = true;
                    break;
                }
            }
        }

        if (ret) {
            return opts.fn(this);
        } else {
            return opts.inverse(this);
        }
    });

    Handlebars.registerHelper("compare", function (x1, x2, options) {

        if (x1 > x2) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });
    Handlebars.registerHelper("lessThan", function (var1, var2, options) {

        if (var1 < var2) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });
    Handlebars.registerHelper("greaterThan", function (var1, var2, options) {

        if (var1 > var2) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    Handlebars.registerHelper("between", function (value, min, max, options) {

        if (value > min && min < max) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    Handlebars.registerHelper('lightSearch', function (summary, search) {
        return new Handlebars.SafeString(lightSearch(summary, search));
    });

    Handlebars.registerHelper('make_types', function (type_ids, issue_types) {
        return new Handlebars.SafeString(make_types(type_ids, issue_types));
    });

    Handlebars.registerHelper('make_projects', function (project_ids, projects) {
        return new Handlebars.SafeString(make_projects(project_ids, projects));
    });

    Handlebars.registerHelper('make_project', function (project_id) {
        return new Handlebars.SafeString(make_project(project_id));
    });

    Handlebars.registerHelper('make_user', function (uid, users) {
        return new Handlebars.SafeString(make_user(uid, users));
    });

    Handlebars.registerHelper('user_html', function (uid) {
        return new Handlebars.SafeString(user_html(uid));
    });

    Handlebars.registerHelper('user_html_display_name', function (uid) {
        return new Handlebars.SafeString(user_html_display_name(uid));
    });

    Handlebars.registerHelper('user_text_display_name', function (uid) {
        return new Handlebars.SafeString(user_text_display_name(uid));
    });

    Handlebars.registerHelper('org_user_html', function (uid) {
        return new Handlebars.SafeString(org_user_html(uid));
    });

    Handlebars.registerHelper('issue_assistants_avatar', function (uid_arr) {
        return new Handlebars.SafeString(issue_assistants_avatar(uid_arr));
    });

    Handlebars.registerHelper('issue_assistants_display_name', function (uid_arr) {
        return new Handlebars.SafeString(issue_assistants_display_name(uid_arr));
    });

    Handlebars.registerHelper('user_account_str', function (uid) {
        return new Handlebars.SafeString(user_account_str(uid));
    });

    Handlebars.registerHelper('make_assistants', function (uid_arr) {
        //console.log(uid_arr);
        return new Handlebars.SafeString(make_assistants(uid_arr));
    });

    Handlebars.registerHelper('assistants_html', function (uid_arr) {
        //console.log(uid_arr);
        return new Handlebars.SafeString(assistants_html(uid_arr));
    });

    Handlebars.registerHelper('make_label_html', function (label_id_arr) {
        //console.log(label_id_arr);
        return new Handlebars.SafeString(make_label_html(label_id_arr));
    });

    Handlebars.registerHelper('version_html', function (version_id) {
        return new Handlebars.SafeString(version_html(version_id));
    });

    Handlebars.registerHelper('priority_html', function (priority_id) {
        return new Handlebars.SafeString(priority_html(priority_id));
    });

    Handlebars.registerHelper('status_html', function (status_id) {
        return new Handlebars.SafeString(status_html(status_id));
    });

    Handlebars.registerHelper('resolve_html', function (resolve_id) {
        return new Handlebars.SafeString(resolve_html(resolve_id));
    });

    Handlebars.registerHelper('module_html', function (module_id) {
        return new Handlebars.SafeString(module_html(module_id));
    });

    Handlebars.registerHelper('make_issue_sprint', function (sprint_id) {
        return new Handlebars.SafeString(make_issue_sprint(sprint_id));
    });

    Handlebars.registerHelper('make_issue_type', function (issue_type_id, issue_types) {
        return new Handlebars.SafeString(make_issue_type(issue_type_id, issue_types));
    });

    Handlebars.registerHelper('issue_type_html', function (issue_type_id) {
        return new Handlebars.SafeString(issue_type_html(issue_type_id));
    });

    Handlebars.registerHelper('issue_type_short_html', function (issue_type_id) {
        return new Handlebars.SafeString(issue_type_short_html(issue_type_id));
    });

    Handlebars.registerHelper('issue_type_icon', function (issue_type_id) {
        return new Handlebars.SafeString(issue_type_icon(issue_type_id));
    });

    Handlebars.registerHelper('make_backlog_issue_type', function (issue_type_id) {
        return new Handlebars.SafeString(make_backlog_issue_type(issue_type_id));
    });

    Handlebars.registerHelper('user_name_html', function (uid) {
        return new Handlebars.SafeString(user_name_html(uid));
    });
    Handlebars.registerHelper('updated_text_html', function (updated_text) {
        return new Handlebars.SafeString(updated_text_html(updated_text));
    });


    Handlebars.registerHelper('created_text_html', function (created, created_text, created_full) {
        return new Handlebars.SafeString(created_text_html(created, created_text, created_full));
    });

});