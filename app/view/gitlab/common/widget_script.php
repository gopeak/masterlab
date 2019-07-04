<script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/widget.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/jquery.countdown/jquery.countdown.js"></script>

<script type="text/javascript">

    var _issueConfig = {
        "priority":<?=json_encode($priority)?>,
        "issue_types":<?=json_encode($issue_types)?>,
        "issue_status":<?=json_encode($issue_status)?>,
        "issue_resolve":<?=json_encode($issue_resolve)?>,
        "issue_module":<?=json_encode($project_modules)?>,
        "issue_version":<?=json_encode($project_versions)?>,
        "issue_labels":<?=json_encode($project_labels)?>,
        "users":<?=json_encode($users)?>,
        "projects":<?=json_encode($projects)?>
    };


    // 可用的工具列表
    var _widgets = <?=json_encode($widgets)?>;
    console.log(_widgets);

    // 用户布局方式
    var _layout = '<?=$user_layout?>';

    // 用户自定义布局配置
    var _user_widgets = <?=json_encode($user_widgets)?>;
    var _last_widgets = <?=json_encode($user_widgets)?>;

    var _old_index = {
        parent_index: 0,
        index: 0
    };

    // 用户参与的项目列表
    var _user_in_projects = <?=json_encode($user_in_projects)?>;
    console.log(_user_in_projects);

    // 用户可选的迭代列表
    var _user_in_sprints = <?=json_encode($user_in_sprints)?>;
    console.log(_user_in_sprints);

    var $panel = null;
    var _cur_page = 1;
    var _temp_obj = {};
    var layout = "aa";

    var $widgetsAjax = null;

    // 项目图表
    var ctx_project_pie = null;//document.getElementById('project_pie').getContext('2d');
    var ctx_project_bar = null;//document.getElementById('project_bar').getContext('2d');
    var projectPie = null;
    var projectBar = null;

    // 迭代图表
    var ctx_sprint_bar = null;
    var sprintBar = null;
    var ctx_sprint_pie = null;
    var sprintPie = null;
    var ctx_sprint_speed_rate = null;
    var sprintSpeedRate = null;
    var ctx_sprint_burndown = null;
    var sprintBurndown = null;


    $(function () {
        var options = {}
        window.$widgetsAjax = new Widgets(options);
    });

    $(function () {
        initHtml();
        filterHasTool();
        $(document).on("click", ".panel-action i", function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).siblings("ul").slideDown(100);
        });

        $(document).on("click", function () {
            $(".panel-action ul").slideUp(100);
        });

        $(document).on("click", ".panel-action .panel-edit", function () {
            var $panel = $(this).parents(".panel");
        });

        $(document).on("click", ".panel-action .panel-delete", function () {
            var $panel = $(this).parents(".panel");
            var index = $panel.index;
            var parent_index = $panel.index();

            moveWidget(parent_index, index, false);
            filterHasTool();
            $panel.remove();
        });
    });

    (function () {
        'use strict';
        var byId = function (id) {
                return document.getElementById(id);
            },

            console = window.console;

        //移动panel
        [].forEach.call(byId('multi').getElementsByClassName('group_panel'), function (el) {
            Sortable.create(el, {
                group: 'photo',
                animation: 150,
                handle: ".panel-heading",
                ghostClass: 'ghost-body',
                forceFallback: true,
                fallbackClass: 'move-body',
                onStart: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();

                    console.log(evt.item.title+"拖动前位置：",index);

                    moveWidget(parent_index, index, false, true);
                },
                onEnd: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();
                    console.log(evt.item.title+"拖动到位置：",index);

                    moveWidget(parent_index, index, true);
                    saveUserWidget(_user_widgets);
                },
                onUpdate: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    //debugger;
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    console.log(evt.item.title+"拖动后位置：",index);
                }
            });
        });

    })();

    // 版式布局切换
    function doLayout(layoutType) {
        _layout =  layoutType;
        var $layout_types = ["a", "aa", "ab", "ba", "aaa"];
        var $list = $("#module_list"),
            $layout = $(".layout-panel"),
            $panel_first = $(".panel-first"),
            $panel_second = $(".panel-second"),
            $panel_third = $(".panel-third"),
            $item_first = $panel_first.find(".panel"),
            $item_second = $panel_second.find(".panel"),
            $item_third = $panel_third.find(".panel");
        var sort = 0,
            html_list = [];

        for (var val of $layout_types) {
            $layout.removeClass(`layout-${val}`);
        }

        $layout.addClass(`layout-${layoutType}`);

        var length1 = $item_first.length;
        var length2 = $item_second.length;
        var length3 = $item_third.length;

        switch(layoutType.length)
        {
            case 1:
                $panel_first.append($panel_second.html() + $panel_third.html());
                $panel_second.hide();
                $panel_third.hide();
                $panel_second.html("");
                $panel_third.html("");
                break;
            case 2:
                if (length1 > 1 && length2 === 0 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i >= length1/2) {
                            $panel_second.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                } else if (length3 > 0) {
                    $panel_second.append($panel_third.html());
                }

                $panel_third.html("");
                $panel_second.show();
                $panel_third.hide();
                break;
            case 3:
                if (length1 > 1 && length2 === 0 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i >= length1/3 && i < length1 * 2/3 ) {
                            $panel_second.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }

                        if (i >= i < length1 * 2/3) {
                            $panel_third.append($(this));
                            $(this).remove();
                        }
                    });
                } else if (length2 > 1 && length3 === 0) {
                    $item_second.each(function (i) {
                        if (i >= length2/2) {
                            $panel_third.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                } else if (length1 > 1 && length2 === 1 && length3 === 0) {
                    $item_first.each(function (i) {
                        if (i === length1-1) {
                            $panel_third.append($(this).prop('outerHTML'));
                            $(this).remove();
                        }
                    });
                }

                $panel_second.show();
                $panel_third.show();
                break;
        }
        $("#modal-layout").modal('hide');
    }

    // 初始化数据html
    function initHtml() {
        var panel_data = [];

        for([key, value] of Object.entries(_user_widgets)) {
            panel_data = panel_data.concat(value);
        }

        panel_data.forEach(function (user_widget) {
            var config_widget = getConfigWidgetData(user_widget.widget_id);
            user_widget['_key'] = config_widget._key;
            user_widget['config_widget'] = config_widget;
            console.log(user_widget);
            addTool(user_widget, user_widget.panel, true);
        });
    }

    //根据id获取相应的widgets数据
    function getConfigWidgetData (id) {
        var temp = _widgets.filter(function (val) {
            return val.id == id;
        })[0];
        var data = {
            id: id,
            title: temp.name,
            _key: temp._key,
            method:temp.method,
            required_param: temp.required_param,
            parameter: temp.parameter
        };
        return data;
    }

    //添加新工具
    function addNewTool(id) {
        var config_widget = getConfigWidgetData(id);

        var user_widget = {
            id:null,
            panel: "first",
            _key: config_widget._key,
            parameter: config_widget.parameter,
            order_weight:1,
            widget_id: id,
            required_param: config_widget.required_param,
            is_saved_parameter: false,
            user_id: current_uid
        };
        console.log(user_widget);
        user_widget['config_widget'] = config_widget;
        addTool(user_widget);

        delete user_widget['config_widget'];
        _user_widgets.first.unshift(user_widget);

        filterHasTool();
        saveUserWidget(_user_widgets);
        $("#modal-tools-add").modal('hide');
    }

    // 增加工具通用方法
    function addTool(user_widget,  isList) {
        var config_widget = user_widget.config_widget;
        var temp_widget = JSON.parse(JSON.stringify(user_widget));
        var panel = user_widget.panel;

        if(is_empty(user_widget.parameter)){
            user_widget.parameter = config_widget.parameter;
        }

        var html = `<div id="widget_${config_widget._key}" class="panel panel-info" data-column="${panel}"></div>`;

        if (isList) {
            $(`.panel-${panel}`).append(html);
        } else {
            $(`.panel-${panel}`).prepend(html);
        }

        temp_widget["is_project"] = temp_widget._key === "my_projects" ? true : false;

        var source = $('#panel_tpl').html();
        var template = Handlebars.compile(source);
        var result = template({widget: temp_widget});
        $(`#widget_${temp_widget._key}`).html(result);

        // 生成表单
        source = $('#tool_form_tpl').html();
        template = Handlebars.compile(source);
        result = template(config_widget);
        $(`#toolform_${config_widget._key}`).html(result);
        makeFormHtml(config_widget.id, config_widget.parameter, user_widget.parameter);

        // 是否显示过滤器表单
        if (config_widget.required_param && !user_widget.is_saved_parameter) {
            $(`#toolform_${config_widget._key}`).show();
            $(`#tool_${config_widget._key}`).hide();
        } else {
            render_data(config_widget, user_widget);
        }
    }

    //移动pannel
    function moveWidget(parent_index, index, add, obj) {
        console.log("parentindex：" + parent_index + " index：" + index);
        var parent_text = "first";
        if (parent_index === 1) {
            parent_text = "second";
        } else if (parent_index === 2) {
            parent_text = "third";
        }

        if (!add) {
            if (obj) {
                _temp_obj = _user_widgets[parent_text][index];
            }
            _user_widgets[parent_text].splice(index, 1);
        } else {
            _user_widgets[parent_text].splice(index, 0, _temp_obj);
        }
    }

    function removeWidget(_key) {
        var $panel = $(`#widget_${_key}`);
        var index = $panel.index;
        var parent_index = $panel.index();
        $(`#widget_${_key}`).remove();

        var parent_text = "first";
        if (parent_index === 1) {
            parent_text = "second";
        } else if (parent_index === 2) {
            parent_text = "third";
        }
        _user_widgets[parent_text].splice(index, 1);

        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/removeUserWidget',
            data: {widget_key:_key},
            success: function (resp) {
                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('删除成功');
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

        console.log(_user_widgets);
    }

    function saveUserWidget(user_widgets){
        console.log('saveUserWidget:');
        console.log(JSON.stringify(window._last_widgets),JSON.stringify(user_widgets))
        if(JSON.stringify(window._last_widgets)==JSON.stringify(user_widgets)){
            return;
        }
        var user_widgets_json = JSON.stringify(user_widgets);
        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/saveUserWidget',
            data: {panel:user_widgets_json, layout:_layout},
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    window._last_widgets = JSON.parse(JSON.stringify(user_widgets));
                    notify_success('保存成功');
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    //过滤工具是否存在
    function filterHasTool() {
        var panel_data = [];

        for(value of Object.values(_user_widgets)) {
            panel_data = panel_data.concat(value);
        }
        _widgets.forEach(function (data) {
            panel_data.forEach(function (val) {
                if (val.widget_id === data.id) {
                    data.isExist = true;
                }
            });
        });

        source = $("#tools_list_tpl").html();
        var template = Handlebars.compile(source);
        var result = template({widgets: _widgets});
        $("#tools-dialog").html(result);
    }

    function makeFormHtml(id, parameter, user_parameter) {

        if(is_empty(user_parameter)){
            return;
        }

        parameter.forEach(function (val) {

            var show_value = '';
            for ( var i = 0; i <user_parameter.length; i++){
                if(user_parameter[i].name==val.field){
                    show_value = user_parameter[i].value;
                }
            }
            if(show_value==''){
                show_value = val.value;
            }

            if (val.type.indexOf("select") >= 0 ) {
                makeSelectHtml(id, val.field, val.type, val.value, show_value);
            } else if (val.type === "date") {
                makeDateSelectHtml(id, val.field, val.value, show_value);
            } else {
                $(`#${val.field}_${id}`).html(`<input type="text" class="form-control" name="${val.field}" value="${show_value}"  />`);
            }
        });
    }

    function makeSelectHtml(id, field, type, value, selected_value) {
        var data = {
            name: field,
            id:"select_sprint_"+id,
            list: []
        };

        if (type === "my_projects_select") {
            data.list = _user_in_projects;
            source = $("#form_select_tpl").html();
        } else if (type === "my_projects_sprint_select") {
            data.list = _user_in_sprints;
            source = $("#form_group_select_tpl").html();
        } else {
            value.forEach(function (val) {
                var temp = {
                    id: val.value,
                    name: val.title
                };
                data.list.push(temp);
            });
            source = $("#form_select_tpl").html();
        }

        data.list.forEach(function (val) {
            if(val.id === selected_value) {
                val.selected = true;
            } else if (val.sprints) {
                val.sprints.forEach(function (_val) {
                    if (_val.id === selected_value) {
                        _val.selected = true;
                    } else {
                        _val.selected = false;
                    }
                });
            } else {
                val.selected = false;
            }
        });

        template = Handlebars.compile(source);
        result = template(data);
        $(`#${field}_${id}`).html(result);
    }

    function makeDateSelectHtml(id, field, value, selected_value ) {
        var html = `<input type="text" class="laydate_input_date form-control" name="${field}" id="${field}_date_${id}"  value="${selected_value}"  />`;
        $(`#${field}_${id}`).html(html);
        laydate.render({
            elem: `#${field}_date_${id}`
        });
    }

    function saveForm(id, key) {
        var configs = $(`#tool_form_${key}`).serializeArray();
        var configsJson = JSON.stringify(configs);

        $.ajax({
            type: 'post',
            dataType: "json",
            async: false,
            url: '/widget/saveUserWidgetParameter',
            data: {parameter:configsJson, widget_key:key},
            success: function (resp) {
                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('保存成功');
                    location.reload();
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    }

    /**
     * 显示过滤器表单
     * @param _key
     */
    function show_form(_key){
        $(`#toolform_${_key}`).show();
        $(`#tool_${_key}`).hide();
        $(`#widget_${_key} .panel-edit`).hide();
    }


    //渲染数据
    function render_data(data, user_widget) {
        // 渲染数据
        source = $(`#${data._key}_tpl`).html();
        template = Handlebars.compile(source);
        result = template(data);
        $(`#tool_${data._key}`).html(result);

        var body_html =$(`#${data._key}-body_tpl`).html();
        $(`#tool_${data._key}`).html(body_html);

        switch (data.method) {
            case 'fetchAssigneeIssues':
                $widgetsAjax.fetchAssigneeIssues(data._key, 1);
                break;
            case 'fetchUnResolveAssigneeIssues':
                $widgetsAjax.fetchUnResolveAssigneeIssues(data._key, 1);
                break;
            case 'fetchUserHaveJoinProjects':
                $widgetsAjax.fetchUserHaveJoinProjects(data._key);
                break;
            case 'fetchOrgs':
                $widgetsAjax.fetchOrgs(data._key, 1);
                break;
            case 'fetchNav':
                $widgetsAjax.fetchNav(data._key, 1);
                break;
            case 'fetchActivity':
                $widgetsAjax.fetchActivity(data._key, 1);
                break;
            case 'fetchProjectStat':
                $widgetsAjax.fetchProjectStat(user_widget);
                break;
            case 'fetchProjectPriorityStat':
                $widgetsAjax.fetchProjectPriorityStat(user_widget);
                break;
            case 'fetchProjectStatusStat':
                $widgetsAjax.fetchProjectStatusStat(user_widget);
                break;
            case 'fetchProjectDeveloperStat':
                $widgetsAjax.fetchProjectDeveloperStat(user_widget);
                break;
            case 'fetchProjectIssueTypeStat':
                $widgetsAjax.fetchProjectIssueTypeStat(user_widget);
                break;
            case 'fetchProjectPie':
                $widgetsAjax.fetchProjectPie(user_widget);
                break;
            case 'fetchProjectAbs':
                $widgetsAjax.fetchProjectAbs(user_widget);
                break;
            case 'fetchSprintStat':
                $widgetsAjax.fetchSprintStat(user_widget);
                break;
            case 'fetchSprintCountdown':
                $widgetsAjax.fetchSprintCountdown(user_widget);
                break;
            case 'fetchSprintBurndown':
                $widgetsAjax.fetchSprintBurndown(user_widget);
                break;
            case 'fetchSprintSpeedRate':
                $widgetsAjax.fetchSprintSpeedRate(user_widget);
                break;
            case 'fetchSprintPie':
                $widgetsAjax.fetchSprintPie(user_widget);
                break;
            case 'fetchSprintAbs':
                $widgetsAjax.fetchSprintAbs(user_widget);
                break;
            case 'fetchSprintPriorityStat':
                $widgetsAjax.fetchSprintPriorityStat(user_widget);
                break;
            case 'fetchSprintStatusStat':
                $widgetsAjax.fetchSprintStatusStat(user_widget);
                break;
            case 'fetchSprintDeveloperStat':
                $widgetsAjax.fetchSprintDeveloperStat(user_widget);
                break;
            case 'fetchSprintIssueTypeStat':
                $widgetsAjax.fetchSprintIssueTypeStat(user_widget);
                break;
        }

        $(`#toolform_${data._key}`).hide();
        $(`#tool_${data._key}`).show();
    }
</script>