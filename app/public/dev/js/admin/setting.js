

function fetchSetting( url, module, tpl_id, parent_id ) {
    var params = {  module:module, format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if(resp.data.settings.length){
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);

                Handlebars.registerHelper("equal", function(v1, v2, options) {
                    if (v1 == v2) {
                        return options.fn(this);
                    } else {
                        return options.inverse(this);
                    }
                });

                var result = template(resp.data);

                $('#' + parent_id).html(result);
            }else{
                var emptyHtml = defineStatusHtml({
                    wrap: '#' + parent_id,
                    message : '数据为空',
                    type: 'image'
                })
            }
        },
        error: function (resp) {
            notify_error("请求数据错误" + resp);
        }
    });
}

function fetchNotifySchemeData(url, tpl_id, parent_id) {

    var params = {format:'json'};
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (res) {

            auth_check(res);

            var source = $('#'+tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(res.data);

            $('#' + parent_id).html(result);
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function fetchProjectRoles( url,  tpl_id, parent_id ) {

    var params = {   format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (res) {

            auth_check(res);
            var source = $('#'+tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(res.data);

            $('#' + parent_id).html(result);
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


function projectRolesAdd(  ) {

    var method = 'post';
    var url = root_url+'admin/system/project_role_add';
    var params = $('#form_add').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
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

function projectRolesDelete( id ) {

    var method = 'GET';
    var url = root_url+'admin/system/project_role_delete/'+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
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

function fetchPermissionGlobal( url,  tpl_id, parent_id ) {

    var params = {   format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if(resp.data.groups.length){
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);

                var select_perm_tpl = $('#select_perm_tpl').html();
                template = Handlebars.compile(select_perm_tpl);
                result = template(resp.data);
                $('#select_perm').html(result);

                var select_group_tpl = $('#select_group_tpl').html();
                template = Handlebars.compile(select_group_tpl);
                result = template(resp.data);
                $('#select_group').html(result);
            }else{
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    type: 'image',
                    wrap: '#render'
                })
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


function permissionGlobalAdd(  ) {

    var method = 'post';
    var url = root_url+'admin/system/global_permission_group_add';
    var params = $('#form_add').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
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

function permissionGlobalDelete( id ) {

    if  (!window.confirm('您确认删除该项吗?')) {
        return false;
    }

    var method = 'GET';
    var url = root_url+'admin/system/global_permission_group_delete/?id='+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
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


$(function() {

    if("undefined" != typeof Handlebars.registerHelper){
        Handlebars.registerHelper('if_eq', function(v1, v2, opts) {
            if(v1 == v2)
                return opts.fn(this);
            else
                return opts.inverse(this);
        });

        // 是否在数组中
        Handlebars.registerHelper('if_in_array', function (element, arr, options) {
            for(v of arr) {
                if(v === element) {
                    //则包含该元素
                    return options.fn(this);
                }
            }
            return options.inverse(this);
        });
    }

    if("undefined" != typeof $('.colorpicker-component').colorpicker){
        $('.colorpicker-component').colorpicker({ /*options...*/ });
    }

    $(".btn-save").click(function(){

        var method = 'post';
        var url = '';

        method =  $(this).closest('form').attr('method') ;
        url =  $(this).closest('form').attr('action') ;
        var params = $(this).closest('form').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg );
                window.reload();
            },
            error: function (resp) {
                notify_error("请求数据错误" + resp);
            }
        });

    });



    $(".btn-remove").click(function(){

        var method = 'post';
        var url = '';

        method =  $(this).closest('form').attr('method') ;
        url =  $(this).closest('form').attr('action') ;
        var params = $(this).closest('form').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (resp) {
                notify_error("请求数据错误" + resp);
            }
        });

    });

    $("#submit-all").on("click", function () {
        setTimeout(function () {
            window.location.reload();
        }, 300);
    });

});

