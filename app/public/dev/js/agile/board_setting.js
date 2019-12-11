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

var BoardSetting = (function () {

    var _options = {};

    var _sprint_id = null;

    // constructor
    function BoardSetting(options) {
        _options = options;
        this.editHandler()
    };

    BoardSetting.prototype.getOptions = function () {
        return _options;
    };

    BoardSetting.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    BoardSetting.prototype.editHandler = function(){
        $(".boards-list").on('mouseover', '.board-item', function(){
            $(this).find('.board-item-edit').show()
        })
        $(".boards-list").on('mouseout', '.board-item', function(){
            $(this).find('.board-item-edit').hide()
        })
    }


    BoardSetting.prototype.fetchBoards = function () {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardByProject',
            data: {project_id:project_id},
            success: function (resp) {
                auth_check(resp);
                var source = $('#board_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#board_list_render_id').html(result);

                $(".list_for_set_active").click(function(){

                });

                $(".list_for_delete").click(function(){
                    BoardSetting.prototype.delete( $(this).data("id"));
                });

                $(".list_for_edit").bind("click", function () {
                    BoardSetting.prototype.showEditBoardById($(this).data('id'));
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    BoardSetting.prototype.rangeOnChange = function (board_id) {

        $("#board_range").bind("change", function () {
            console.log($(this).val())
            let range_value = $(this).val();
            $('#range_container div').addClass('hide');
            $('#range-'+range_value).removeClass(('hide'));
            /*
            $('#range_container div').each(function (el) {

            });
            */
        });
    }

    BoardSetting.prototype.initBoardFormSprint = function (sprints, id_arr) {
        //console.log(sprints, id_arr)
        var range_sprints = $('#range_sprints');
        range_sprints.empty();
        for (var _key in  sprints) {
            var row = sprints[_key];
            var id = row.id;
            var title = row.name;
            let selected = '';
            var opt = "<option  value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            range_sprints.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    BoardSetting.prototype.initBoardFormModule= function (modules, id_arr) {
        console.log(modules, id_arr)
        let range_modules = $('#range_modules');
        range_modules.empty();
        for (var _key in  modules) {
            let row = modules[_key];
            let id = row.k;
            let title = row.name;
            let selected = '';
            let opt = "<option  value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            range_modules.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    BoardSetting.prototype.initBoardFormIssueType= function (issue_types, id_arr) {
        console.log(issue_types, id_arr)
        let range_issue_type = $('#range_issue_type');
        range_issue_type.empty();
        for (var _key in  issue_types) {
            let row = issue_types[_key];
            let id = row._key;
            let title = row.name;
            let selected = '';
            let opt = "<option  value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            range_issue_type.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    BoardSetting.prototype.initBoardFormAssignee= function (users, id_arr) {
        console.log(users, id_arr)
        let range_assignees = $('#range_assignees');
        range_assignees.empty();
        for (var _key in  users) {
            let row = users[_key];
            let uid = row.k;
            let title = row.display_name;
            let selected = '';
            let content = "<img width='26px' height='26px' class=' float-none' style='border-radius: 50%;' src='/attachment/avatar/"+uid+".png' > "+title;
            let opt  ='<option value="'+uid+'"  data-content="'+content+'"  '+selected+'>'+title+'</option>';
            console.log(opt)
            range_assignees.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }


    BoardSetting.prototype.fetchBoards = function () {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardByProject',
            data: {project_id:project_id},
            success: function (resp) {
                auth_check(resp);
                var source = $('#board_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#board_list_render_id').html(result);

                $(".list_for_set_active").click(function(){

                });

                $(".list_for_delete").click(function(){
                    // BoardSetting.prototype.delete( $(this).data("id"));
                });

                $(".list_for_edit").bind("click", function () {
                    BoardSetting.prototype.showEditBoardById($(this).data('id'));
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    BoardSetting.prototype.showEditBoardById = function (board_id) {

        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardInfoById',
            data: {id: board_id, project_id: project_id},
            success: function (resp) {
                auth_check(resp);
                $('#board_table').hide();
                $('#action-board_list').hide();
                $('#board_add_form').show();
                $('#action-board_form').show();

                var source = $('#board_column_tpl').html();
                var template = Handlebars.compile(source);
                let board_data = {
                    columns:[
                        {i:1, name:"xxxxxx1", source_status:[], source_resolve:[],source_label:[],source_assignee:[]},
                        {i:2, name:"xxxxxx2", source_status:[], source_resolve:[],source_label:[],source_assignee:[]},
                        {i:3, name:"xxxxxx3", source_status:[], source_resolve:[],source_label:[],source_assignee:[]}
                    ]
                }
                //var result = template( columns_data);
                //$('#xxxxxxxxx').html(result);

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    BoardSetting.prototype.showCreateBoardById = function (board_id) {

        $('#board_table').hide();
        $('#action-board_list').hide();
        $('#board_add_form').show();
        $('#action-board_form').show();

        var source = $('#board_column_tpl').html();
        var template = Handlebars.compile(source);
        let board_data = {
            name:"",

            columns:[
                {i:1, name:"xxxxxx1", data:{status:[], resolve:[],label:[],assignee:[]}},
                {i:2, name:"xxxxxx2", data:{status:[], resolve:[],label:[],assignee:[]}},
                {i:3, name:"xxxxxx3", data:{status:[], resolve:[],label:[],assignee:[]}}
            ]
        }
        let result = template( board_data);
        //$('#xxxxxxxxx').html(result);
    }


    return BoardSetting;
})();

