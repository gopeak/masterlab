<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ROOT_URL ?>dev/css/dashboard.css" rel="stylesheet" type="text/css"/>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js" type="text/javascript"></script>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/profile.56fab56f950907c5b67a.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>

</head>
<body class="dashboard" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

        <script>
            var findFileURL = "";
        </script>
        <div class="page-with-sidebar">
            <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
                <div class="alert-wrapper">
                    <div class="flash-container flash-container-page">
                    </div>
                </div>

                <div class="content padding-0" id="content-body1">
                    <div class="cover-block user-cover-block">
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <?php
                            $profile_nav='custom_index';
                            include_once VIEW_PATH.'gitlab/user/common-setting-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="nav-controls">
                        <div class="btn-group" role="group">
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-tools-add" data-toggle="modal" href="#modal-tools-add">
                                <i class="fa fa-plus"></i>
                                添加小工具
                            </a>
                            <a class="btn btn_issue_type_add js-key-create" data-target="#modal-layout" data-toggle="modal" href="#modal-layout">
                                <i class="fa fa-th-large"></i>
                                版式布局
                            </a>
                        </div>
                    </div>
                </div>

                <div class="content container-fluid" id="content-body">
                    <div id="multi" class="container layout-panel layout-aa row">
                        <div class="group_panel panel-first">

                        </div>

                        <div class="group_panel panel-second">

                        </div>

                        <div class="group_panel panel-third">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal home-modal" id="modal-layout">
        <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_add"
              action="<?=ROOT_URL?>admin/issue_type/add"
              accept-charset="UTF-8"
              method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                        <h3 class="modal-header-title">版式布局</h3>
                    </div>

                    <div class="modal-body layout-dialog" id="layout-dialog">
                        <p><strong>选择仪表板布局</strong></p>
                        <ul>
                            <li><a onclick="doLayout('a')" id="layout-a"><strong>A</strong></a></li>
                            <li><a onclick="doLayout('aa')" id="layout-aa"><strong>AA</strong></a></li>
                            <li><a onclick="doLayout('ba')" id="layout-ba"><strong>BA</strong></a></li>
                            <li><a onclick="doLayout('ab')" id="layout-ab"><strong>AB</strong></a></li>
                            <li><a onclick="doLayout('aaa')" id="layout-aaa"><strong>AAA</strong></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="modal home-modal" id="modal-tools-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close js-key-modal-close1" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">添加小工具</h3>
                </div>
                <div class="modal-body" id="tools-dialog">

                </div>
            </div>
        </div>
    </div>
</section>

<script id="tools_list_tpl" type="text/html">
    <ul class="tools-list">
        {{#widgets}}
        <li>
        <div class="tool-img">
            <img src="{{pic}}" alt="">
        </div>

        <div class="tool-info">
            <h3 class="tool-title">
            {{name}}
            </h3>
            <p class="tool-content">
            {{description}}
            </p>
        </div>

        <div class="tool-action">
            {{#if isExist}}
            <span>已添加</span>
            {{^}}
            <a href="javascript:;" onclick="addNewTool('{{id}}')">添加小工具</a>
            {{/if}}
        </div>
        </li>
        {{/widgets}}
    </ul>
</script>

<script id="tool_form_tpl" type="text/html">
    <form class="form-horizontal" id="tool_form_{{_key}}">
        {{#parameter}}
        <div class="form-group">
            <div class="col-sm-2 form-label text-right">{{name}}：</div>
            <div class="col-sm-8" id="{{field}}_{{../id}}">
            </div>
        </div>
        {{/parameter}}
        <div class="form-group">
            <div class="col-sm-8 col-md-offset-2">
                <a href="javascript:;" class="btn btn-save" onclick="saveForm({{id}}, '{{_key}}')">保存</a>
            </div>
        </div>
    </form>
</script>

<script id="my_projects_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="assignee_my_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="activity_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="nav_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="org_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_abs_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_priority_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_developer_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_status_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_issue_type_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="project_pie_tpl" type="text/html">
    <div>

    </div>
</script>


<script id="sprint_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_countdown_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_burndown_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_speed_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_pie_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_abs_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_priority_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_status_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_developer_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="sprint_issue_type_stat_tpl" type="text/html">
    <div>

    </div>
</script>

<script id="form_select_tpl" type="text/html">
    <select name="{{name}}" class="form-control">
        {{#list}}
        <option value="{{id}}">
            {{name}}
        </option>
        {{/list}}
    </select>
</script>

<script id="form_group_select_tpl" type="text/html">
    <select name="{{name}}" class="form-control">
        {{#list}}
        <optgroup label="{{name}}">
            {{#sprints}}
            <option value="{{id}}">{{name}}</option>
            {{/sprints}}
        </optgroup>
        {{/list}}
    </select>
</script>

<script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/js/panel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>

<script type="text/javascript">

    // 可用的工具列表
    var _widgets = <?=json_encode($widgets)?>;
    console.log(_widgets);

    // 用户布局方式
    var _layout = '<?=$user_layout?>';

    // 用户自定义布局配置
    var _user_widgets = <?=json_encode($user_widgets)?>;
    console.log(_user_widgets);

    // 用户参与的项目列表
    var _user_in_projects = <?=json_encode($user_in_projects)?>;
    console.log(_user_in_projects);

    // 用户可选的迭代列表
    var _user_in_sprints = <?=json_encode($user_in_sprints)?>;
    console.log(_user_in_sprints);

    var $panel = null;
    var _cur_page = 1;
    var temp_obj = {};
    var layout = "aa";

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

            movePanel(parent_index, index, false);
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
                onStart: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();

                    movePanel(parent_index, index, false, true);
                },
                onEnd: function (evt) { //拖拽完毕之后发生该事件
                    //所在位置
                    var $parent = $(evt.item).parent();
                    var index = $parent.children().index($(evt.item));
                    var parent_index = $parent.index();

                    movePanel(parent_index, index, true);
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
        layout = layoutType;
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

        panel_data.forEach(function (widget) {
            data = getWidgetData(widget.widget_id);
            addTool(data, widget.panel, true);
        });
    }

    //根据id获取相应的widgets数据
    function getWidgetData (id) {
        var temp = _widgets.filter(function (val) {
            return val.id == id;
        })[0];
        var data = {
            id: id,
            title: temp.name,
            _key: temp._key,
            required_param: temp.required_param,
            parameter: temp.parameter
        };
        return data;
    }

    //添加新工具
    function addNewTool(id) {
        var data = getWidgetData(id);

        addTool(data, 'first');

        var obj = {
            panel: "first",
            _key: data._key,
            parameter: data.parameter,
            widget_id: id
        };
        _user_widgets.first.unshift(obj);

        filterHasTool();

        $("#modal-tools-add").modal('hide');
    }

    // 增加工具通用方法
    function addTool(data, panel, isList) {
        var html = `<div class="panel panel-info" data-column="${panel}">
            <div class="panel-heading tile__name " data-force="25" draggable="false">
            <h3 class="panel-heading-title">${data.title}</h3>
            <div class="panel-heading-extra">
                <div class="panel-action">
                    <i class="fa fa-angle-down"></i>
                    <ul>
                        ${data.required_param ? '<li class="panel-edit">编辑</li>' : ''}
                        <li class="panel-delete">删除</li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="panel-body" id="tool_${data._key}">

            </div>
            </div>`;

        if (isList) {
            $(`.panel-${panel}`).append(html);
        } else {
            $(`.panel-${panel}`).prepend(html);
        }

        if (data.required_param) {
            source = $('#tool_form_tpl').html();
            template = Handlebars.compile(source);
            result = template(data);
            $(`#tool_${data._key}`).html(result);
            makeFormHtml(data.id, data.parameter);
        } else {
            source = $(`#${data._key}_tpl`).html();
            template = Handlebars.compile(source);
            result = template(data);
            $(`#tool_${data._key}`).html(result);
        }
    }

    //移动pannel
    function movePanel(parent_index, index, add, obj) {
        var parent_text = "first";
        if (parent_index === 1) {
            parent_text = "second";
        } else if (parent_index === 2) {
            parent_text = "third";
        }

        if (!add) {
            if (obj) {
                temp_obj = _user_widgets[parent_text][index];
            }
            _user_widgets[parent_text].splice(index, 1);
        } else {
            _user_widgets[parent_text].splice(index, 0, temp_obj);
        }
        console.log(_user_widgets);
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
        template = Handlebars.compile(source);
        result = template({widgets: _widgets});
        $("#tools-dialog").html(result);
    }

    function makeFormHtml(id, parameter) {
        parameter.forEach(function (val) {
           if (val.type.indexOf("select") >= 0 ) {
               makeSelectHtml(id, val.field, val.type, val.value);
           } else if (val.type === "date") {
               makeDateSelectHtml(id, val.field);
           } else {
               $(`#${val.field}_${id}`).html(`<input type="text" class="form-control" name="${val.field}" value=""  />`);
           }
        });
    }

    function makeSelectHtml(id, field, type, value) {
        var data = {
            name: field,
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

        template = Handlebars.compile(source);
        result = template(data);
        $(`#${field}_${id}`).html(result);
    }

//    function makeGroupSelectHtml(id, field, type) {
//        var data = {
//            name: field,
//            list: []
//        };
//
//        if (type === "my_projects_sprint_select") {
//            data.list = _user_in_sprints;
//        }
//
//        source = $("#form_group_select_tpl").html();
//        template = Handlebars.compile(source);
//        result = template(data);
//        $(`#${field}_${id}`).html(result);
//    }
    
    function makeDateSelectHtml(id, field) {
        var html = `<input type="text" class="laydate_input_date form-control" name="${field}" id="${field}_date_${id}"  value=""  />`;

        $(`#${field}_${id}`).html(html);

        laydate.render({
            elem: `#${field}_date_${id}`
        });
    }
    
    function saveForm(id, key) {
        var configs = $(`#tool_form_${key}`).serializeArray();
        console.log(configs);
    }
    
    //提交数据
    function submitData() {
        console.log()
    }

</script>
</body>
</html>