var Widgets = (function () {

    var _options = {};

    // constructor
    function Widgets(options) {
        _options = options;
    };

    Widgets.prototype.getOptions = function () {
        return _options;
    };

    Widgets.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Widgets.prototype.fetchOrgs = function (_key, page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchOrgs',
            data: {page: page},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.orgs.length){
                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();
                }else{
                    defineStatusHtml({
                        wrap: '#tool_'+_key,
                        message : '数据为空'
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchNav = function (_key) {
        // url,  list_tpl_id, list_render_id
        var source = $('#'+_key+'_tpl').html();
        $('#'+_key+'_wrap').html(source);
        $(`#toolform_${_key}`).hide();
        $(`#tool_${_key}`).show();
    }

    Widgets.prototype.fetchAssigneeIssues = function (_key,page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        if(is_empty(page)){
            page = 1;
        }
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchAssigneeIssues',
            data: {page: page},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.issues.length){
                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#tool_${_key}`).find("time").each(function(i, el){
                        var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                        $(el).html(t)
                      })

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if (pages > 1) {
                        $('#assignee_my_more').show();
                    }
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();

                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        name: 'computer',
                        handleHtml: ''
                    })
                    $(`#tool_${_key}`).append(emptyHtml.html)
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchUnResolveAssigneeIssues = function (_key,page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        if(is_empty(page)){
            page = 1;
        }
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchUnResolveAssigneeIssues',
            data: {page: page},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.issues.length){
                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#tool_${_key}`).find("time").each(function(i, el){
                        var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                        $(el).html(t)
                    })

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if (pages > 1) {
                        $('#'+_key+'_more').show();
                    }
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();

                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        name: 'computer',
                        handleHtml: ''
                    })
                    $(`#tool_${_key}`).append(emptyHtml.html)
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchActivity = function (_key, page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchActivity',
            data: {page: page},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.activity.length){
                    var activitys = [];
                    for(var i=0; i<resp.data.activity.length;  i++) {
                        var user_id = resp.data.activity[i].user_id;
                        resp.data.activity[i].user = getValueByKey(_issueConfig.users,user_id);
                    }

                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#tool_${_key}`).find("time").each(function(i, el){
                        var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                        $(el).html(t)
                    })

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if (pages > 1) {
                        $('#'+_key+'_more').show();
                    }
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    var options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function (e, originalEvent, type, page) {
                            console.log("Page item clicked, type: " + type + " page: " + page);
                            $("#filter_page").val(page);
                            //_options.query_param_obj["page"] = page;
                            Widgets.prototype.fetchActivity(_key,page);
                        }
                    };
                    $('#ampagination-bootstrap').bootstrapPaginator(options);
                }else{
                    var emptyHtml = defineStatusHtml({
                        wrap: '#tool_'+_key,
                        message : '数据为空'
                    })
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchUserHaveJoinProjects = function (_key) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchUserHaveJoinProjects',
            data: {},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.projects.length){
                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#tool_${_key}`).find("time").each(function(i, el){
                        var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                        $(el).html(t)
                    })
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();
                }else{
                    defineStatusHtml({
                        wrap: '#tool_'+_key,
                        message : '数据为空',
                        handleHtml: '<a class="btn btn-new" href="/project/main/_new">创建项目</a>'
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectStat = function (user_widget) {
        // url,  list_tpl_id, list_render_id
        var params = user_widget.parameter;
        var paramObj = {};
        console.log(params);
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectStat',
            data:paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp);
                $('#'+_key+'_wrap').html($('#'+_key+'_tpl').html());
                $('#issues_count').html(resp.data.count);
                $('#no_done_count').html(resp.data.no_done_count);
                $('#closed_count').html(resp.data.closed_count);
                $('#sprint_count').html(resp.data.sprint_count);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectPriorityStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectPriorityStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectStatusStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectStatusStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectDeveloperStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectDeveloperStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectIssueTypeStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectIssueTypeStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectPie = function ( user_widget ) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectPie',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                if (window.ctx_project_pie) {
                    window.ctx_project_pie.destroy();
                }
                window.ctx_project_pie = document.getElementById(_key+'_wrap').getContext('2d');
                window.projectPie = new Chart(window.ctx_project_pie, resp.data);
            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                alert("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchProjectAbs = function ( user_widget ) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchProjectAbs',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '已解决和未解决'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
                resp.data['options'] = options;
                if (window.ctx_project_bar) {
                    window.ctx_project_bar.destroy();
                }
                window.ctx_project_bar = document.getElementById(_key+'_wrap').getContext('2d');
                window.projectBar = new Chart(window.ctx_project_bar, resp.data);
            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                alert("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintStat = function (user_widget) {
        // url,  list_tpl_id, list_render_id
        var params = user_widget.parameter;
        var _key = user_widget._key;

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintStat',
            data: params,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)

                $('#issues_count').html(resp.data.count);
                $('#no_done_count').html(resp.data.no_done_count);
                $('#closed_count').html(resp.data.closed_count);
                $('#sprint_count').html(resp.data.sprint_count);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintCountdown = function (user_widget) {
        // url,  list_tpl_id, list_render_id
        var params = user_widget.parameter;
        var _key = user_widget._key;

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintStat',
            data: params,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                var sprint_end_date = resp.data.activeSprint.end_date;
                $('#'+_key+'_wrap').countdown(sprint_end_date, function (event) {
                    $(this).html(event.strftime('%w 周 %d 天 %H:%M:%S'));
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Widgets.prototype.fetchSprintPriorityStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintPriorityStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintStatusStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintStatusStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintDeveloperStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintDeveloperStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintIssueTypeStat = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;
        loading.show('#'+_key);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintIssueTypeStat',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                loading.hide('#'+_key);
                var source = $('#'+_key+'_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+_key+'_wrap').html(result);
                $(`#toolform_${_key}`).hide();
                $(`#tool_${_key}`).show();
            },
            error: function (res) {
                loading.hide('#'+_key);
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintPie = function ( user_widget ) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintPie',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                if (window.ctx_sprint_pie) {
                    window.ctx_sprint_pie.destroy();
                }
                window.ctx_sprint_pie = document.getElementById(_key+'_wrap').getContext('2d');
                window.sprintPie = new Chart(window.ctx_sprint_pie, resp.data);
            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                alert("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintSpeedRate = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintSpeedRate',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '速率图'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }

                resp.data['options'] = options;
                if (window.ctx_sprint_speed_rate) {
                    window.ctx_sprint_speed_rate.destroy();
                }
                window.ctx_sprint_speed_rate = document.getElementById(_key+'_wrap').getContext('2d');
                window.sprintSpeedRate = new Chart(window.ctx_sprint_speed_rate, resp.data);

            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintBurndown = function (user_widget) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintBurndown',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '燃尽图'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: false,
                        }],
                        yAxes: [{
                            stacked: false
                        }]
                    }
                }

                resp.data['options'] = options;
                if (window.ctx_sprint_burndown) {
                    window.ctx_sprint_burndown.destroy();
                }
                window.ctx_sprint_burndown = document.getElementById(_key+'_wrap').getContext('2d');
                window.sprintBurndown = new Chart(window.ctx_sprint_burndown, resp.data);

            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                notify_error("请求数据错误" + res);
            }
        });
    }

    Widgets.prototype.fetchSprintAbs = function ( user_widget ) {
        var params = user_widget.parameter;
        var paramObj = {};
        for(var i=0;i<params.length;i++){
            paramObj[params[i].name] = params[i].value;
        }
        var _key = user_widget._key;

        loading.show('#'+_key+'_wrap');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchSprintAbs',
            data: paramObj,
            success: function (resp) {
                auth_check(resp);
                loading.hide('#'+_key+'_wrap');
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '已解决和未解决'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
                resp.data['options'] = options;
                if (window.ctx_sprint_bar) {
                    window.ctx_sprint_bar.destroy();
                }
                window.ctx_sprint_bar = document.getElementById(_key+'_wrap').getContext('2d');
                window.sprintBar = new Chart(window.ctx_sprint_bar, resp.data);
            },
            error: function (res) {
                loading.hide('#'+_key+'_wrap');
                alert("请求数据错误" + res);
            }
        });
    }

    return Widgets;
})();

