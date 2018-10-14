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
    this.el.on("click", this.handle, function (event) {
        if (self.el.hasClass("close")) {
            self.el.removeClass("close")
            self.list.show()
        } else {
            self.el.addClass("close")
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
        [].forEach.call(items, function (el) {
            Sortable.create(el, {
                group: 'item',
                animation: 150,
                onEnd: function (evt) {
                    var item = evt.item;
                    console.log(item);
                    var issueId = item.getAttribute("data-issue_id");
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
                    console.log(targetStatus)
                    var myCourse = document.createElement("select");
                    myCourse.setAttribute("className", "selectpicker");
                    for (var i = 0; i < targetStatus.length; i++) {
                        var myOption = document.createElement("option");
                        myOption.value = targetStatus[i];
                        myOption.text = targetStatus[i];
                        myCourse.add(myOption);
                    }
                    $('.selectpicker').selectpicker();

                    swal({
                        title: '请选择变更的状态',
                        content: myCourse,
                        buttons: {
                            cancel: "取 消",
                            ok: true,
                        }
                    }).then((value) => {
                        switch (value) {
                            case "ok":

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
                                        if (resp.ret == '200') {
                                            console.log("移动事项成功")
                                        } else {
                                            console.log("移动事项失败", resp)
                                        }
                                    },
                                    error: function (res) {
                                        console.log("移动事项失败", res)
                                    }
                                });

                                break;
                            default:
                        }
                    });
                }
            })
        })

    }

    BoardColumn.prototype.fetchBoardBySprint = function (sprint_id) {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardBySprint',
            data: {id: sprint_id, project_id: project_id},
            success: function (resp) {
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
                BoardColumn.prototype.handlerResponse(resp);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return BoardColumn;
})();

