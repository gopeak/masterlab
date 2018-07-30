var Panel = (function () {

    var _options = {};

    // constructor
    function Panel(options) {
        _options = options;
    };

    Panel.prototype.getOptions = function () {
        return _options;
    };

    Panel.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };


    Panel.prototype.fetchPanelAssigneeIssues = function (page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/dashboard/fetchPanelAssigneeIssues',
            data: {page: page},
            success: function (resp) {

                var source = $('#assignee_issue_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#panel_assignee_issues').html(result);

                window._cur_page = parseInt(page);
                var pages = parseInt(resp.data.pages);
                if (pages > 1) {
                    $('#panel_assignee_issues').append($('#assignee_more').html());
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Panel.prototype.fetchPanelActivity = function (page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/dashboard/fetchPanelActivity',
            data: {page: page},
            success: function (resp) {

                var activitys = [];
                for(var i=0; i<resp.data.activity.length;  i++) {
                    var user_id = resp.data.activity[i].user_id;
                    resp.data.activity[i].user = getValueByKey(_issueConfig.users,user_id);
                }

                var source = $('#activity_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#panel_activity').append(result);

                window._cur_page = parseInt(page);
                var pages = parseInt(resp.data.pages);
                if(window._cur_page<pages){
                    $('#panel_activity_more').removeClass('hide');
                }else{
                    $('#panel_activity_more').addClass('hide');
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Panel.prototype.fetchPanelJoinProjects = function () {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/user/fetchUserHaveJoinProjects',
            data: {},
            success: function (resp) {
                var source = $('#join_project_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#panel_join_projects').html(result);

                var pages = parseInt(resp.data.pages);
                if (pages > 1) {
                    $('#panel_join_projects').append($('#panel_join_projects_more').html());
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Panel.prototype.fetchProjectStat = function (project_id) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/stat/fetchIssue',
            data: {project_id:project_id},
            success: function (resp) {

                $('#issues_count').html(resp.data.count);
                $('#no_done_count').html(resp.data.no_done_count);
                $('#closed_count').html(resp.data.closed_count);
                $('#sprint_count').html(resp.data.sprint_count);

                var source = $('#priority_stat_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#priority_stat').html(result);

                source = $('#status_stat_tpl').html();
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#status_stat').html(result);

                source = $('#type_stat_tpl').html();
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#type_stat').html(result);

                source = $('#assignee_stat_tpl').html();
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#assignee_stat').html(result);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }


    return Panel;
})();

