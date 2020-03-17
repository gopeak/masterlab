
var MsgSystem = (function() {

    var _options = {};
 


    // constructor
    function MsgSystem(  options  ) {
        _options = options;


    };

    MsgSystem.prototype.getOptions = function() {
        return _options;
    };

    MsgSystem.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    MsgSystem.prototype.filter = function( url, tpl_id, container_id ) {

        var params = { format: 'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: $('#msg_filter_form').serialize(),
            success: function (resp) {
                auth_check(resp);
                //console.log(resp.data.users);
                if (resp.data.msgs.length) {
                    var source = $('#' + tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + container_id).html(result);

                    /*$(".user_for_delete").click(function(){
                        userDelete( $(this).attr("data-uid") );
                    });*/

                    $(".for_readed").click(function () {
                        //setRead($(this).data("id"));
                    });

                    var options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function (e, originalEvent, type, page) {
                            console.log("Page item clicked, type: " + type + " page: " + page);
                            $("#filter_page").val(page);
                            MsgSystem.prototype.filter( url, tpl_id, container_id);
                        }
                    }
                    $('#pagination').bootstrapPaginator(options);
                } else {
                    var emptyHtml = defineStatusHtml({
                        message: '暂无数据',
                        type: 'id',
                        handleHtml: ''
                    })
                    $('#'+container_id).html($('<div id="render_id_wrap"></div>'));
                    $('#render_id_wrap').append(emptyHtml.html)
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    }

    MsgSystem.prototype.update = function(  ) {

        var url = _options.update_url;
        var method = 'post';
        /*
        var img = document.getElementById('avatar_display');
        var image = MsgSystem.prototype.getBase64Image(img);
        $('#image').val(image);
        */
        // jugg fix 图片裁剪大小与预期显示不一致的问题
        var avatar_display_src = $('#avatar_display').attr('src');
        $('#image').val(avatar_display_src);


        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $("#edit_user").serialize(),
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    notify_success('保存成功');
                    //window.location.reload();
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    MsgSystem.prototype.updatePassword = function(  ) {

        var url = _options.update_password_url;
        var method = 'post';

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $("#edit_password").serialize(),
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    //window.location.reload();
                    notify_success(resp.msg);
                }else {
                    notify_error(resp.msg, resp.data);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }



    return MsgSystem;
})();

