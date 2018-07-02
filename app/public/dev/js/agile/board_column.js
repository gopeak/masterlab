
function Board(opts){
    this.el = $(opts.el)
    this.handle = opts.handle
    this.list = this.el.find('.board-list-component')
    this.init()
}
Board.prototype.init = function() {
    if(this.el.hasClass("close")){
        this.list.hide()
    }
    this.trigger()
}
Board.prototype.trigger = function(){
    const self = this
    this.el.on("click", this.handle, function(event){
        if(self.el.hasClass("close")){
            self.el.removeClass("close")
            self.list.show()
        }else{
            self.el.addClass("close")
            self.list.hide()
        }
    })
}

var BoardColumn = (function() {

    var _options = {};

    var _sprint_id = null;
    // constructor
    function BoardColumn(  options  ) {
        _options = options;


    };

    BoardColumn.prototype.getOptions = function() {
        return _options;
    };

    BoardColumn.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };



    BoardColumn.prototype.fetchBoardById = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.boards_url,
            data: {} ,
            success: function (resp) {

                var source = $('#'+_options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);

                var source = $('#closed_render_id').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#closed_render_id').html(result);

                $(".is-expandable").each( function(i, el) {
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
                    onUpdate: function (evt){
                        var item = evt.item;
                    }
                })
                var items = document.getElementsByClassName('board-list');
                [].forEach.call(items, function (el){
                    Sortable.create(el, {
                        group: 'item',
                        animation: 150
                    })
                })

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    BoardColumn.prototype.fetchSprints = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.sprints_url,
            data: {} ,
            success: function (resp) {
                var source = $('#sprints_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#sprints_list_div').html(result);

                Board.prototype.dragToSprint();
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }


    return BoardColumn;
})();

