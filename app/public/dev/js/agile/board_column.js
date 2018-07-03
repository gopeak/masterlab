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
            alert('服务器错误:'.resp.msg);
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
            onUpdate: function (evt) {
                var item = evt.item;
            }
        })
        var items = document.getElementsByClassName('board-list');
        [].forEach.call(items, function (el) {
            Sortable.create(el, {
                group: 'item',
                animation: 150
            })
        })

    }

    BoardColumn.prototype.fetchBoardBySprint = function (sprint_id) {

        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/agile/fetchBoardBySprint',
            data: {id: sprint_id},
            success: function (resp) {
                BoardColumn.prototype.handlerResponse(resp);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    BoardColumn.prototype.fetchBoardById = function (board_id) {

        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/agile/fetchBoardById',
            data: {id: board_id},
            success: function (resp) {
                BoardColumn.prototype.handlerResponse(resp);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return BoardColumn;
})();

