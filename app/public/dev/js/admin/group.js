
var Group = (function() {

    var _options = {};

    // constructor
    function Group(  options  ) {
        _options = options;

        $("#btn-group_add").click(function(){
            Group.prototype.add();
        });

        $("#btn-group_update").click(function(){
            Group.prototype.update();
        });

        $("#btn-group-add-user").click(function(){
            Group.prototype.groupAddUser();
        });


        $("#btn-group_filter").click(function(){
            Group.prototype.fetchGroups( );
        });

        $("#btn-group_reset").click(function(){
            Group.prototype.formReset( );
            Group.prototype.fetchGroups();
        });

        $(".filter_page_size").click(function () {
            $(".filter_page_size").each(function () {
                $(this).removeClass("active");
            });
            $(this).addClass("active");

            $('#filter_page_size').val( $(this).attr('data-value') );
            Group.prototype.fetchGroups();

        });
    };

    Group.prototype.getOptions = function() {
        return _options;
    };

    Group.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    Group.prototype.fetchGroups = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#'+_options.filter_form_id).serialize() ,
            success: function (resp) {
                auth_check(resp);
                if(resp.data.groups.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".group_for_edit").click(function(){
                        Group.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".group_for_delete").click(function(){
                        Group.prototype._delete( $(this).attr("data-value") );
                    });

                    var page_options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function(e,originalEvent,type,page){
                            console.log("Page item clicked, type: "+type+" page: "+page);
                            $("#filter_page").val( page );
                            Group.prototype.fetchGroups( );
                        }
                    }
                    $('#'+_options.pagination_id).bootstrapPaginator( page_options );
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        type: 'error',
                        handleHtml: ''
                    })
                    $('#list_render_id').append($('<tr><td colspan="7" id="list_render_id_wrap"></td></tr>'))
                    $('#list_render_id_wrap').append(emptyHtml.html)
                }
                

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.fetchUsers = function( group_id ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            url: _options.fetch_users_url,
            data: {group_id:group_id},
            success: function (resp) {

                auth_check(resp);
                $("#group_name").html( resp.data.group.name);

                if(resp.data.users.length){
                    var source = $('#'+_options.group_users_list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.group_users_list_render_id).html(result);

                    $("#users_count").html( resp.data.count);

                    $(".group_users_for_delete").click(function(){
                        Group.prototype.groupRemoveUser( $("#user_group_id").val(), $(this).attr("data-value") );
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        type: 'image',
                        name: 'computer'
                    })
                    $('#list_render_id').append($('<tr><td colspan="2" id="list_render_id_wrap"></td></tr>'))
                    $('#list_render_id').append(emptyHtml.html)
                }



            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.groupAddUser = function(  ) {

        var method = 'post';
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.group_users_add_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.formReset = function(  ) {

        $("#filter_page").val("1");
        $("#filter_page_size").val("20");
        $("#filter_name").val("");
        $('#filter_page_view').html( $('#filter_page_view').attr("data-title-origin") );
    }
    Group.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url+"?id="+id,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-group_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_description").val(resp.data.description);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.add = function(  ) {

        var method = 'post';
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.update = function(  ) {

        var method = 'post';
        var params = $('#form_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype._delete = function(id ) {

        if  (!window.confirm('您确认删除该项吗?')) {
            return false;
        }

        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Group.prototype.groupRemoveUser = function( group_id,uid ) {

        if  (!window.confirm('您确认删除该项吗?')) {
            return false;
        }

        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data:{group_id:group_id, uid:uid },
            url: _options.group_users_delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }



    return Group;
})();


