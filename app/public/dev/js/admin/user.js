

function fetchUsers( url,  tpl_id, parent_id ) {

    var params = {  format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: $('#user_filter_form').serialize() ,
        success: function (resp) {
            auth_check(resp);
            console.log(resp.data.users);
            if(resp.data.users.length){
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);

                var select_group_tpl = $('#select_group_tpl').html();
                template = Handlebars.compile(select_group_tpl);
                result = template(resp.data);
                $('#select_group').html(result);

                $(".user_for_edit ").click(function(){
                    userEdit( $(this).attr("data-uid") );
                });

                /*$(".user_for_delete").click(function(){
                    userDelete( $(this).attr("data-uid") );
                });*/

                $(".user_for_active").click(function(){
                    userActive( $(this).attr("data-uid") );
                });

                $(".user_for_group ").click(function(){
                    userGroup( $(this).attr("data-uid") );
                });

                $(".select_group_li").click(function () {
                      $('#filter_group').val( $(this).attr('data-group') );
                      $('#select_group_view').html($(this).attr('data-title') );
                });
                $(".order_by_li").click(function () {
                    $('#filter_order_by').val( $(this).attr('data-order-by') );
                    $('#filter_sort').html($(this).attr('data-sort') );
                    $('#order_view').html($(this).attr('data-title') );
                });

                var options = {
                    currentPage: resp.data.page,
                    totalPages: resp.data.pages,
                    onPageClicked: function(e,originalEvent,type,page){
                        console.log("Page item clicked, type: "+type+" page: "+page);
                        $("#filter_page").val( page );
                        fetchUsers(root_url+'admin/user/filter','user_tpl','render_id');
                    }
                }
                $('#ampagination-bootstrap').bootstrapPaginator(options);
            }else{
                var emptyHtml = defineStatusHtml({
                    message : '暂无用户信息',
                    type: 'id',
                    handleHtml: ''
                })
                $('#render_id').html($('<tr><td colspan="7" id="render_id_wrap"></td></tr>'))
                $('#render_id_wrap').append(emptyHtml.html)
            }
            

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });

    return false;
}


function userFormReset(){

    $("#filter_page").val("1");
    $("#filter_status").val("");
    $("#filter_group").val("0");
    $("#filter_status").val("");
    $("#filter_sort").val("desc");
    $("#filter_username").val("");
    $('#order_view').html( $('#order_view').attr("data-title-origin") );
    $("#select_group_view").html( $('#select_group_view').attr("data-title-origin") );
}

function userEdit( uid) {

    var method = 'get';
    var url = '/admin/user/get/?uid='+uid;
    $('#edit_id').val(uid);
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {} ,
        success: function (resp) {
            auth_check(resp);
            $("#modal-user_edit").modal();
            $("#edit_uid").val(resp.data.uid);
            $("#edit_email").val(resp.data.email);
            $("#edit_display_name").val(resp.data.display_name);
            $("#edit_username").val(resp.data.username);
            $("#edit_title").val(resp.data.title);
            if( resp.data.is_cur=="1" ){
                $("#edit_disable").attr("disabled","disabled");
                $('#edit_disable_wrap').addClass('hidden')
            }else{
                $("#edit_disable").removeAttr("disabled");
                $('#edit_disable_wrap').removeClass('hidden')
            }
            if( resp.data.status=='2'){
                $('#edit_disable').attr("checked", true);
            }else{
                $('#edit_disable').attr("checked", false);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userGroup( uid) {

    var method = 'get';
    var url = '/admin/user/user_group/?uid='+uid;
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {} ,
        success: function (resp) {

            auth_check(resp);
            $("#modal-user_group").modal();
            $("#group_for_uid").val( uid );

            var obj3 = document.getElementById('for_group');
            obj3.options.length = 0;
            for(var i = 0; i < resp.data.groups.length; i++){
                obj3.options.add(new Option( resp.data.groups[i].name, resp.data.groups[i].id ));
            }
            $('.selectpicker').selectpicker('refresh');
            $('#for_group').selectpicker('refresh');
            $('#for_group').selectpicker('val', resp.data.user_groups);
            $('.selectpicker').selectpicker();

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}



function userAdd(  ) {

    var method = 'post';
    var url = '/admin/user/add';
    var params = $('#form-user_add').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if(!form_check(resp)){
                return;
            }
            if( resp.ret == 200 ){
                window.location.reload();
            }else{
                notify_error( '添加失败,'+resp.msg );
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userUpdate(  ) {

    var method = 'post';
    var url = '/admin/user/update';
    var params = $('#form-user_edit').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if(!form_check(resp)){
                return;
            }
            if( resp.ret == 200 ){
                window.location.reload();
            }else{
                notify_error( '更新失败,'+resp.msg );
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userJoinGroup(  ) {

    var method = 'post';
    var url = '/admin/user/updateUserGroup';
    var params = $('#form-update_user_group').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if( resp.ret == 200 ){
                window.location.reload();
            }else{
                notify_success( resp.msg );
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userDelete( id ) {

    if  (!window.confirm('您确认删除该项吗?')) {
        return false;
    }

    var method = 'GET';
    var url = '/admin/user/delete/?uid='+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
        success: function (resp) {
            auth_check(resp);
            if( resp.ret == 200 ){
                window.location.reload();
            }else{
                notify_error( resp.msg );
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userActive( id ) {


    var method = 'GET';
    var url = '/admin/user/active/?uid='+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
        success: function (resp) {
            auth_check(resp);
            if( resp.ret == 200 ){
                window.location.reload();
            }else{
                notify_error( resp.msg );
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

