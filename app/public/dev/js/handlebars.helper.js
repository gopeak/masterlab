

$(function() {

    if("undefined" != typeof Handlebars.registerHelper){
        Handlebars.registerHelper('if_eq', function(v1, v2, opts) {
            if(v1 == v2)
                return opts.fn(this);
            else
                return opts.inverse(this);
        });
    }

    Handlebars.registerHelper('make_types', function(type_ids, issue_types ) {

        var html = '';
        if (type_ids == null || type_ids == undefined || type_ids == '') {
            return html;
        }
        var scheme_ids_arr = type_ids.split(',');
        scheme_ids_arr.forEach(function(type_id) {
            console.log(type_id);
            var type_name = '';
            var type_font_icon = '';
            for(var skey in issue_types ){
                if(issue_types[skey].id==type_id){
                    type_name = issue_types[skey].name;
                    type_font_icon = issue_types[skey].font_awesome;
                    break;
                }
            }
            html += "<div class=\"branch-commit\"><i class='fa "+type_font_icon+"'></i> <a class=\"commit-id monospace\" href=\"#\">"+type_name+"</a></div>";
        });
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_projects', function(project_ids, projects ) {
        var html = '';
        if (project_ids == null || project_ids == undefined || project_ids == '') {
            return html;
        }
        var project_ids_arr = project_ids.split(',');
        project_ids_arr.forEach(function(project_id) {
            console.log(project_id);
            var project_name = '';
            for(var skey in projects ){
                if(projects[skey].id==project_id){
                    project_name = projects[skey].name;
                    break;
                }
            }
            html += "<div class=\"branch-commit\"> <a class=\"commit-id monospace\" href=\"#\">"+project_name+"</a></div>";
        });
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_user', function(uid ,users) {
        var html = '';
        if (uid == null || uid == undefined || uid == '') {
            return '';
        }
        var user = getValueByKey(users,uid);
        //console.log(users);
        if(user==null){
            return '';
        }
        html += '<span class="list-item-name"><a href="/'+user.username+'"><image width="26px" height="26px" style="float:none" class="header-user-avatar has-tooltip" data-original-title="' + user.username + ' @' + user.display_name + '" src="'+ user.avatar +'" /></a></span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('user_html', function(uid) {
        var html = '';
        if (uid == null || uid == undefined || uid == '') {
            return '';
        }
        var user = getValueByKey(_issueConfig.users,uid);
        //console.log(users);
        if(user==null){
            return '';
        }
        html += '<span class="list-item-name"><a href="/'+user.username+'"><image width="26px" height="26px" style="float:none" class="header-user-avatar has-tooltip" data-original-title="' + user.username + ' @' + user.display_name + '" src="'+ user.avatar +'" /></a></span>';
        return new Handlebars.SafeString( html );
    });


    Handlebars.registerHelper('make_assistants', function(uid_arr ,users) {
        console.log(uid_arr);
        console.log(users);
        var html = '';
        for(i=0;i<uid_arr.length;i++){

            var uid = parseInt(uid_arr[i]);
            var user = getValueByKey(_issueConfig.users,uid);
            console.log(user);
            if(user==null){
                return '';
            }
            html += '<div class="participants-author js-participants-author">';
            html += '    <a class="author_link has-tooltip" title="" data-container="body" href="/'+user.username+'" data-original-title="'+user.display_name+'" ><img width="24" class="avatar avatar-inline s24 " alt="" src="'+ user.avatar +'"></a>';
            html += '    </div>';
        }
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('assistants_html', function(uid_arr) {
        console.log(uid_arr);
        var html = '';
        for(i=0;i<uid_arr.length;i++){
            var uid = parseInt(uid_arr[i]);
            var user = getValueByKey(_issueConfig.users,uid);
            console.log(user);
            if(user==null){
                return '';
            }
            html += '<div class="participants-author js-participants-author">';
            html += '    <a class="author_link has-tooltip" title="" data-container="body" href="/'+user.username+'" data-original-title="'+user.display_name+'" ><img width="24" class="avatar avatar-inline s24 " alt="" src="'+ user.avatar +'"></a>';
            html += '    </div>';
        }
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_priority', function(priority_id ,priority) {
        var html = '';
        if (priority_id == null || priority_id == undefined || priority_id == '') {
            return '';
        }
        var priority_row = getValueByKey(priority,priority_id);
        if(priority_row==null){
            return '';
        }
        html +='<span class="label " style="color:'+priority_row.status_color+'">'+priority_row.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('priority_html', function(priority_id ) {
        var html = '';
        if (priority_id == null || priority_id == undefined || priority_id == '') {
            return '';
        }
        var priority_row = getValueByKey(_issueConfig.priority,priority_id);
        if(priority_row==null){
            return '';
        }
        html +='<span class="label " style="color:'+priority_row.status_color+'">'+priority_row.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_status', function(status ,issue_status) {
        var html = '';
        if (status == null || status == undefined || status == '') {
            return '';
        }
        var status_row = getValueByKey(issue_status,status);
        if(status_row==null){
            return '';
        }
        html +='<span class="label label-'+status_row.color+' prepend-left-5">'+status_row.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('status_html', function(status) {
        var html = '';
        if (status == null || status == undefined || status == '') {
            return '';
        }
        var status_row = getValueByKey(_issueConfig.issue_status,status);
        if(status_row==null){
            return '';
        }
        html +='<span class="label label-'+status_row.color+' prepend-left-5">'+status_row.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_resolve', function(resolve_id ,issue_resolve) {
        var html = '';
        if (resolve_id == null || resolve_id == undefined || resolve_id == '') {
            return '';
        }
        var resolve = getValueByKey(issue_resolve,resolve_id);
        if(resolve==null){
            return '';
        }
        html +='<span   style="color:#1aaa55">'+resolve.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('resolve_html', function(resolve_id ,issue_resolve) {
        var html = '';
        if (resolve_id == null || resolve_id == undefined || resolve_id == '') {
            return '';
        }
        var resolve = getValueByKey(issue_resolve,resolve_id);
        if(resolve==null){
            return '';
        }
        html +='<span   style="color:#1aaa55">'+resolve.name+'</span>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_module', function(module_id ,issue_module) {
        var html = '';
        if (module_id == null || module_id == undefined || module_id == '') {
            return '';
        }
        var module = getValueByKey(issue_module,module_id);
        if(module==null){
            return '';
        }
        html +='<a href="#" class="commit-id monospace">'+module.name+'</a>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('module_html', function(module_id) {
        var html = '';
        if (module_id == null || module_id == undefined || module_id == '') {
            return '';
        }
        var module = getValueByKey(_issueConfig.issue_module,module_id);
        if(module==null){
            return '';
        }
        html +='<a href="#" class="commit-id monospace">'+module.name+'</a>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_issue_type', function(issue_type_id ,issue_types) {
        var html = '';
        if (issue_type_id == null || issue_type_id == undefined || issue_type_id == '') {
            return '';
        }
        var issue_type = getValueByKey(issue_types,issue_type_id);
        if(issue_type==null){
            return '';
        }
        html +='<i class="fa '+issue_type.font_awesome+'"></i>\n' +
            '            <a href="#"  class="commit-id monospace">'+issue_type.name+'</a>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('issue_type_html', function(issue_type_id) {
        var html = '';
        if (issue_type_id == null || issue_type_id == undefined || issue_type_id == '') {
            return '';
        }
        var issue_type = getValueByKey(_issueConfig.issue_types,issue_type_id);
        if(issue_type==null){
            return '';
        }
        html +='<i class="fa '+issue_type.font_awesome+'"></i>\n' +
            '            <a href="#"  class="commit-id monospace">'+issue_type.name+'</a>';
        return new Handlebars.SafeString( html );
    });

    Handlebars.registerHelper('make_backlog_issue_type', function(issue_type_id) {
        var html = '';
        if (issue_type_id == null || issue_type_id == undefined || issue_type_id == '') {
            return '';
        }
        var issue_type = getValueByKey(_issueConfig.issue_types,issue_type_id);
        if(issue_type==null){
            return '';
        }
        html +='<i class="fa '+issue_type.font_awesome+'"></i>\n'
        return new Handlebars.SafeString( html );
    });

});