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
};

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
};

var BoardSetting = (function () {

    var _options = {};

    // constructor
    function BoardSetting(options) {
        _options = options;
        this.editHandler();
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
        let boards = $(".boards-list");
        boards.on('mouseover', '.board-item', function(){
            $(this).find('.board-item-edit').show()
        })
        boards.on('mouseout', '.board-item', function(){
            $(this).find('.board-item-edit').hide()
        })
    };


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
    };

    BoardSetting.prototype.initBoardFormSprint = function (sprints, id_arr) {
        //console.log(sprints, id_arr)
        var range_sprints = $('#range_sprints');
        range_sprints.empty();
        for (let i=0;i<sprints.length;i++) {
            var row = sprints[i];
            var id = row.id;
            var title = row.name;
            let selected = '';
            if(isInArray(id_arr, id) ){
                selected = 'selected';
            }
            var opt = "<option  value='"+id+"' "+selected+">"+title+"</option>";
            //console.log(opt)
            range_sprints.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    BoardSetting.prototype.initBoardFormModule= function (modules, id_arr) {
        //console.log(modules, id_arr)
        let range_modules = $('#range_modules');
        range_modules.empty();
        for (let i=0;i<modules.length;i++) {
            let row = modules[_key];
            let id = row.k;
            let title = row.name;
            let selected = '';
            let opt = "<option  value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            range_modules.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    };

    BoardSetting.prototype.initBoardFormIssueType= function (issue_types, id_arr) {
        //console.log(issue_types, id_arr)
        let range_issue_type = $('#range_issue_type');
        range_issue_type.empty();
        for (let i=0;i<issue_types.length;i++) {
            let row = issue_types[_key];
            let id = row._key;
            let title = row.name;
            let selected = '';
            let opt = "<option  value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            range_issue_type.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    };

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
    };


    BoardSetting.prototype.fetchBoards = function () {
        loading.show('#board_table', '正在加载看板列表');
        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardsByProject',
            data: {project_id:project_id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                var source = $('#board_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#board_list_render_id').html(result);

                $(".list_for_delete").bind("click", function () {
                    BoardSetting.prototype.delete($(this).data('id'));
                });

                $(".list_for_edit").bind("click", function () {
                    BoardSetting.prototype.showEditBoardById($(this).data('id'));
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    BoardSetting.prototype.showEditBoardById = function (board_id) {
        $('#board-header-title').html('看板编辑');
        $('#board_name').focus();
        $('#board_id').val(board_id);
        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        loading.show('#board_add_form', '正在加载看板数据');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'agile/fetchBoardInfoById',
            data: {id: board_id, project_id: project_id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                $('#board_table').hide();
                $('#action-board_list').hide();
                $('#board_add_form').show();
                $('#action-board_form').show();
                var source = $('#board_column_tpl').html();
                var template = Handlebars.compile(source);
                let board_data =  resp.data.board;
                $("#range_type").val(board_data.range_type);
                if(board_data.range_type!=='all'){
                    $("#range_"+board_data.range_type).val([board_data.range_data]);
                }
                $('#range_container div').addClass('hide');
                $('#range-'+board_data.range_type).removeClass(('hide'));
                let result = template( board_data);
                $('#board_swim_render').html(result);
                BoardSetting.prototype.renderSwims(board_data);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    BoardSetting.prototype.showCreateBoardById = function () {

        $('#board-header-title').html('看板新增');
        $('#board_name').focus();
        $('#form_board_id').val('');
        $('#board_table').hide();
        $('#action-board_list').hide();
        $('#board_add_form').show();
        $('#action-board_form').show();
        let range_type = 'all';
        $("#range_type").val(range_type);
        BoardSetting.prototype.initBoardFormSprint(window._issueConfig.project_sprints,[]);
        BoardSetting.prototype.initBoardFormModule(window._issueConfig.issue_module,[]);
        BoardSetting.prototype.initBoardFormIssueType(window._issueConfig.issue_types,[]);
        $('#range_container div').addClass('hide');
        $('#range-'+range_type).removeClass(('hide'));

        let source = $('#board_column_tpl').html();
        let template = Handlebars.compile(source);
        let board_data = {
            name:"",
            range_type:range_type,
            range_data:"",
            is_filter_backlog:"0",
            is_filter_closed:"0",
            columns:[
                {i:0, name:"准备中", data:{status:['open','reopen','in_review','delay'], resolve:[],label:[],assignee:[]}},
                {i:1, name:"进行中", data:{status:['in_progress'], resolve:[],label:[],assignee:[]}},
                {i:2, name:"已解决", data:{status:['closed','done'], resolve:[],label:[],assignee:[]}}
            ]
        };

        let result = template( board_data);
        $('#board_swim_render').html(result);
        BoardSetting.prototype.renderSwims(board_data);

    };

    BoardSetting.prototype.addSwim = function (el) {

        let source = $('#board_column_tpl').html();
        let template = Handlebars.compile(source);
        var timestamp = Date.parse( new Date());
        let board_data = {
            columns:[
                {i:timestamp, name:"", data:{status:[], resolve:[],label:[],assignee:[]}}
            ]
        }
        let swim_html = template( board_data);
        console.log(swim_html);
        var target = el.parents(".board-setting-line-item")
        var parent = el.parents(".board-setting-line")
        var nextNode = target.next()

        if(target.attr("class") === "board-setting-line-item"){
            if(nextNode.length) {
                target.after(swim_html)
            }else{
                if(target.parents(".board-setting-line-active").length){
                    target.after(swim_html)
                }
            }
        }else{
            parent.find(".board-setting-line-active").prepend(swim_html)
        }
        BoardSetting.prototype.renderSwimSelect(board_data.columns[0].data,timestamp);
        $('.selectpicker').selectpicker('refresh');
    };


    BoardSetting.prototype.renderSwims = function (board_data) {
        // console.log(board_data)
        let board_name = board_data.name;
        $('#board_name').val(board_name);
        let columns = board_data.columns;
        let is_display_backlog = board_data.is_filter_backlog;
        let is_display_closed = board_data.is_filter_closed;

        if(is_display_backlog==='1'){
            $('#checkbox_is_filter_backlog').attr("checked", true);
        }else{
            $('#checkbox_is_filter_backlog').removeAttr("checked");
        }
        if(is_display_closed==='1'){
            $('#checkbox_is_filter_closed').attr("checked", true);
        }else{
            $('#checkbox_is_filter_closed').removeAttr("checked");
        }

        for (let i = 0; i < columns.length; i++) {
            console.log(columns[i].name)
            let name = columns[i].name;
            let swim_data = columns[i].data;
            $('#name_column_'+columns[i].i).val(name);
            $('#title_column_'+columns[i].i).html(name);
            BoardSetting.prototype.renderSwimSelect(swim_data, i);
        }
        $('.selectpicker').selectpicker('refresh');
    };

    BoardSetting.prototype.renderSingleSwim = function (name, swim_data, i) {
        //console.log(name, swim_data, i)
        $('#name_column_'+i).val(name);
        $('#title_column_'+i).html(name);
        BoardSetting.prototype.renderSwimSelect(swim_data, i);
        $('.selectpicker').selectpicker('refresh');
    };

    BoardSetting.prototype.renderSwimSelect = function (swim_data, i ) {
        //console.log(swim_data)
        if(swim_data){
            let selects = {};
            for (let source in  swim_data) {
                if(source==='status'){
                    let source_data = swim_data[source];
                    selects[source] = $('#select_'+source+'_column_' + i);
                    selects[source].empty();
                    let select_datas = window._issueConfig.issue_status;
                    for (let _k in  select_datas) {
                        let row = select_datas[_k];
                        let value = row._key;
                        let title = row.name;
                        let selected = '';
                        if (("undefined" !== typeof swim_data[source]) && isInArray(source_data, value)) {
                            selected = 'selected';
                        }
                        let opt = "<option  value='" + value + "' "+selected+" >" + title + "</option>";
                        //console.log(opt)
                        selects[source].append(opt);
                    }
                }
                if(source==='resolve'){
                    let source_data = swim_data[source];
                    selects[source] = $('#select_'+source+'_column_' + i);
                    selects[source].empty();
                    let select_datas = window._issueConfig.issue_resolve;
                    for (let _k in  select_datas) {
                        let row = select_datas[_k];
                        let value = row._key;
                        let title = row.name;
                        let selected = '';
                        if (("undefined" !== typeof swim_data[source]) && isInArray(source_data, value)) {
                            selected = 'selected';
                        }
                        let opt = "<option  value='" + value + "' "+selected+" >" + title + "</option>";
                        //console.log(opt)
                        selects[source].append(opt);
                    }
                }
                if(source==='label'){
                    let source_data = swim_data.label;
                    selects[source] = $('#select_'+source+'_column_' + i);
                    selects[source].empty();
                    let select_datas = window._issueConfig.issue_labels;
                    for (let _k in  select_datas) {
                        let row = select_datas[_k];
                        let value = _k;
                        let title = row.title;
                        let selected = '';
                        if (("undefined" !== typeof swim_data[source]) && isInArray(source_data, value)) {
                            selected = 'selected';
                        }
                        let opt = "<option  value='" + value + "' "+selected+" >" + title + "</option>";
                        //console.log(opt)
                        selects[source].append(opt);
                    }
                }
                if(source==='assignee'){
                    let source_data = swim_data[source];
                    selects[source] = $('#select_'+source+'_column_' + i);
                    selects[source].empty();
                    let select_datas = window._issueConfig.users;
                    for (let _k in  select_datas) {
                        let row = select_datas[_k];
                        let value = row.uid;
                        let title = row.display_name;
                        let avatar = row.avatar;
                        let selected = '';
                        if (!source_data && ("undefined" !== typeof swim_data[source]) && isInArray(source_data, value)) {
                            selected = 'selected';
                        }
                        let content = "<img width='26px' height='26px' class=' float-none' style='border-radius: 50%;' src='"+avatar+"' > "+title;
                        let opt  ='<option value="'+value+'"  data-content="'+content+'"  '+selected+'>'+title+'</option>';
                        //console.log(opt)
                        selects[source].append(opt);
                    }
                }
            }
        }
    };

    /**
     * 保存看板数据
     */
    BoardSetting.prototype.saveSetting = function ( ) {
        let board_id = $('#form_board_id').val();
        let board_name = $('#board_name').val();
        let range_type = $('#range_type').val();
        let is_filter_backlog = $('#checkbox_is_filter_backlog').is(':checked') ? '0':'1';
        let is_filter_closed = $('#checkbox_is_filter_closed').is(':checked') ? '0':'1';
        let columns_data = [];
        let i = 0;
        $('.board_swim_item').each(function(el){
            let filter_data = {};
            let seq = $(this).data('seq');
            filter_data.status = $('#select_status_column_'+seq).val();
            filter_data.resolve = $('#select_resolve_column_'+seq).val();
            filter_data.label = $('#select_label_column_'+seq).val();
            filter_data.assignee = $('#select_assignee_column_'+seq).val();
            let column_name = $('#name_column_'+seq).val();
            let column_data = {i:i, name:column_name, data: filter_data };
            columns_data.push(column_data);
            i++;
        });
        let columns_data_str = JSON.stringify(columns_data);
        let board_data = {
            project_id:window._cur_project_id,
            id:board_id,
            name:board_name,
            weight:$('#board_weight').val(),
            range_type:range_type,
            range_data:$('range-'+range_type).val(),
            is_filter_backlog:is_filter_backlog,
            is_filter_closed:is_filter_closed,
            columns:columns_data_str
        };
        // console.log($(board_data)) ;
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'agile/saveBoardSetting',
            data: board_data,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                $('#btn-back_board_list').click();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    BoardSetting.prototype.delete = function( id ) {
        swal({
                title: "您是否确认删除该看板？",
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
                    swal.close();
                    loading.show('#board_table');
                    $.ajax({
                        type: 'get',
                        dataType: "json",
                        async: false,
                        url:  '/agile/deleteBoard/'+id,
                        success: function (resp) {
                            loading.closeAll();
                            auth_check(resp);
                            if(resp.ret==='200'){
                                notify_success(resp.msg, resp.data);
                                BoardSetting.prototype.fetchBoards();
                            }else{
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                } else {
                    swal.close();
                }
            });


    };

    return BoardSetting;
})();

