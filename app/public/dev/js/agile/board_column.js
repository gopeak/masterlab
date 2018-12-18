function Board(opts) {
    this.el = $(opts.el)
    this.handle = opts.handle
    this.list = this.el.find('.board-list-component')
    this.init()
}

Board.prototype.init = function () {
    if (this.el.hasClass("close")) {
        this.list.hide()
    }
    this.trigger()
}
Board.prototype.trigger = function () {
    const self = this

    this.handle.on("click", function (event) {
        var p = $(this).closest('.board')
        if (p.hasClass("close")) {
            p.removeClass("close")
            self.list.show()
        } else {
            p.addClass("close")
            self.list.hide()
        }
    })
}

var BoardColumn = (function () {

    var _options = {};

    var _sprint_id = null;

    // constructor
    function BoardColumn(options) {
        _options = options;
        this.editHandler()
    };

    BoardColumn.prototype.getOptions = function () {
        return _options;
    };

    BoardColumn.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    BoardColumn.prototype.editHandler = function(){
        $(".boards-list").on('mouseover', '.board-item', function(){
            $(this).find('.board-item-edit').show()
        })
        $(".boards-list").on('mouseout', '.board-item', function(){
            $(this).find('.board-item-edit').hide()
        })
    }

    BoardColumn.prototype.handlerResponse = function (resp) {

        if (resp.ret != '200') {
            notify_error('服务器错误:' + resp.msg);
            return;
        }

        var source = $('#backlog_list_tpl').html();
        var template = Handlebars.compile(source);
        var result = template(resp.data);
        $('#backlog_render_id').html(result);

        var source = $('#column_list_tpl').html();
        var template = Handlebars.compile(source);
        var result = template(resp.data);
        $('#columns_render_id').html(result);
        $('#backlog_count').html(resp.data.backlogs.length);

        var source = $('#closed_list_tpl').html();
        var template = Handlebars.compile(source);
        var result = template(resp.data);
        $('#closed_render_id').html(result);

        $(".is-expandable").each(function (i, el) {
            new Board({
                el: $(el),
                handle: $(el).find(".board-header")
            })
        })

        var container = document.getElementById("boards-list");
        var sort = Sortable.create(container, {
            animation: 150,
            handle: ".board-title",
            draggable: ".board",
            onEnd: function (evt) {
                //var item = evt.item;
                //console.log(item);
            }
        })
        var items = document.getElementsByClassName('board-list');
        var columnNode = null;
        if(window._perm_kanban!=0) {
            [].forEach.call(items, function (el) {
                Sortable.create(el, {
                    group: 'item',
                    animation: 150,
                    onStart: function (/**Event*/evt) {
                        columnNode = evt.item.parentNode;
                    },
                    onEnd: function (evt) {
                        var item = evt.item;
                        var columnNodeId = columnNode.getAttribute("id");
                        var issueId = item.getAttribute("data-issue_id");

                        if (columnNodeId == evt.item.parentNode.getAttribute("id")) {
                            console.log('nothing to do!');
                            return;
                        }

                        var fromBacklog = item.getAttribute("data-from-backlog");
                        var fromClosed = item.getAttribute("data-from_closed");
                        var ulData = item.parentNode.getAttribute("data");
                        if (ulData == 'backlog') {
                            Backlog.prototype.joinBacklog(issueId);
                            return;
                        }
                        if (ulData == 'closed') {
                            Backlog.prototype.joinClosed(issueId);
                            return;
                        }

                        var targetStatus = JSON.parse(ulData);
                        var issue_status = _issueConfig.issue_status;
                        var myCourse = document.createElement("select");
                        myCourse.setAttribute("className", "selectpicker");
                        for (var i = 0; i < targetStatus.length; i++) {
                            var myOption = document.createElement("option");
                            myOption.value = targetStatus[i];
                            myOption.text = targetStatus[i];
                            for (var skey in issue_status) {
                                if (issue_status[skey]._key == targetStatus[i]) {
                                    myOption.text = issue_status[skey].name;
                                    break;
                                }
                            }
                            myCourse.add(myOption);
                        }
                        swal({
                                title: "请选择变更的状态？",
                                text: myCourse.outerHTML,
                                html: true,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "确 定",
                                cancelButtonText: "取 消！",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        async: true,
                                        url: root_url + 'agile/updateIssueStatus',
                                        data: {
                                            status_key: myCourse.value,
                                            issue_id: issueId,
                                            is_backlog: fromBacklog,
                                            is_closed: fromClosed
                                        },
                                        success: function (resp) {
                                            auth_check(resp);
                                            if (resp.ret == '200') {
                                                console.log("移动事项成功");
                                                window.location.reload();
                                            } else {
                                                console.log("移动事项失败", resp)
                                            }
                                        },
                                        error: function (res) {
                                            console.log("移动事项失败", res)
                                        }
                                    });
                                } else {
                                    swal.close();
                                }
                            });
                    }
                })
            })
        }

    }

    BoardColumn.prototype.fetchBoardBySprint = function (sprint_id) {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        var urls = parseURL(window.location.href);
        urls.searchObject.id = sprint_id;
        urls.searchObject.project_id = project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardBySprint',
            data: urls.searchObject,
            success: function (resp) {
                auth_check(resp);
                BoardColumn.prototype.handlerResponse(resp);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    BoardColumn.prototype.fetchBoardById = function (board_id) {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardById',
            data: {id: board_id, project_id: project_id},
            success: function (resp) {
                auth_check(resp);
                BoardColumn.prototype.handlerResponse(resp);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return BoardColumn;
})();

