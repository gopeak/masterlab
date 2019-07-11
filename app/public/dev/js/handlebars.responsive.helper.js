$(function () {

    if ("undefined" != typeof Handlebars.registerHelper) {
        Handlebars.registerHelper('if_eq', function (v1, v2, opts) {
            if (v1 == v2)
                return opts.fn(this);
            else
                return opts.inverse(this);
        });
    }

    //
    Handlebars.registerHelper('float_assistants_avatar', function (uid_arr) {
        //console.log(uid_arr);
        var users = _issueConfig.users;
        //console.log(users);
        var html = '';
        for (i = 0; i < uid_arr.length; i++) {

            var uid = parseInt(uid_arr[i]);
            var user = getValueByKey(_issueConfig.users, uid);
            console.log(user);
            if (user == null) {
                return '';
            }
            html += '<li><a class="author-link has-tooltip" title="" data-container="body" href="/user/profile/' + user.uid + '"' +
                '      data-original-title="协助人:' + user.display_name + '">' +
                '      <img width="16" class="avatar avatar-inline s16 js-lazy-loaded qa-js-lazy-loaded"  alt=""' +
                '          src="' + user.avatar + '">' +
                '   </a></li>'
        }
        return new Handlebars.SafeString(html);
    });

    Handlebars.registerHelper('float_user_account_html', function (uid) {
        var html = '';
        if (uid == null || uid == undefined || uid == '') {
            return '';
        }
        var user = getValueByKey(_issueConfig.users, uid);
        //console.log(users);
        if (user == null) {
            return '';
        }
        html += '' +
            '<a class="author-link js-user-link  " ' +
            'style="font-size: 10px;color:#707070;" ' +
            'data-user-id="'+uid+'" ' +
            'data-username="' + user.username + '" ' +
            'data-name="' +  user.display_name + '" ' +
            'href="/user/profile/' + user.uid +
            '"><span class="author">' + user.display_name + '</span>' +
            '</a>';
        return new Handlebars.SafeString(html);
    });

    Handlebars.registerHelper('float_assistants_avatar', function (uid_arr) {
        //console.log(uid_arr);
        var html = '';
        for (i = 0; i < uid_arr.length; i++) {
            var uid = parseInt(uid_arr[i]);
            var user = getValueByKey(_issueConfig.users, uid);
            console.log(user);
            if (user == null) {
                return '';
            }
            html += '<div class="participants-author js-participants-author">';
            html += '    <a class="author_link has-tooltip" title="" data-container="body" href="/' + user.username + '" data-original-title="协助人:' + user.display_name + '" ><img width="24" class="avatar avatar-inline s24 " alt="" src="' + user.avatar + '"></a>';
            html += '    </div>';
        }
        return new Handlebars.SafeString(html);
    });

    Handlebars.registerHelper('float_priority', function (priority_id) {
        var html = '';
        if ( is_empty(priority_id) ) {
            return '';
        }
        var priority_row = getValueByKey(_issueConfig.priority, priority_id);
        if (priority_row == null) {
            return '';
        }
        html += '<span style="color:' + priority_row.status_color + ';font-size: 10px">' + priority_row.name + '</span>';
        return new Handlebars.SafeString(html);
    });

    Handlebars.registerHelper('float_status', function (status_id) {
        var html = '';
        if ( is_empty(status_id) ) {
            return '';
        }
        var status_row = getValueByKey(_issueConfig.issue_status, status_id);
        if (status_row == null) {
            return '';
        }
        html += '<a class="label-link" href="?状态='+status_row.name+'">' +
            '<span style="color: #fff;" class="status_badge color-label label-' + status_row.color + ' prepend-left-5">' + status_row.name + '</span>' +
            '</a>';
        return new Handlebars.SafeString(html);
    });

    Handlebars.registerHelper('float_resolve', function (resolve_id) {
        var html = '';
        if ( is_empty(resolve_id) ) {
            return '';
        }
        var resolve = getValueByKey(_issueConfig.issue_resolve, resolve_id);
        if (resolve == null) {
            return '';
        }
        html += '<span style="color:#1aaa55;">' + resolve.name + '</span>';
        return new Handlebars.SafeString(html);
    });


    Handlebars.registerHelper('float_issue_sprint', function (sprint_id) {

        var html = '';
        if ( is_empty(sprint_id) ) {
            return '';
        }
        console.log(_issueConfig.sprint);
        var sprint = getArrayValue(_issueConfig.sprint, 'id', sprint_id  );
        console.log(sprint);
        if (sprint == null) {
            return '';
        }
        html += '<span class="issuable-milestone d-none d-sm-inline-block">' +
            '<a style="color:#707070;"   data-toggle="tooltip" data-placement="top" title="所属迭代:' + sprint.name + '" href="迭代='+sprint.name+'">' +
            '' + sprint.name +
            '</a>' +
            '</span>';

        return new Handlebars.SafeString(html);
    });


});