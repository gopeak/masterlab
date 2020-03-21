
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
                    if(resp.data.unread_count>0){
                        $('#unread_count').html('('+resp.data.unread_count+')');
                    }
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

    MsgSystem.prototype.fetch = function( id ) {

        var method = 'post';
        loading.show('#setting-modal-body');
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: '/user/fetchMsg?id='+id,
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    let sender_url = '/user/profile/'+resp.data.sender_uid;
                    let sender_avatar = '/public/attachment/avatar/'+resp.data.sender_uid+'.png';
                    if(resp.data.sender_uid=='0'){
                        sender_avatar = '/gitlab/images/logo.png';
                        sender_url = '#';
                    }
                    resp.data['sender_avatar'] = sender_avatar;
                    resp.data['sender_avatar'] = sender_avatar;
                    var source = $('#right_content_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#right_content').html(result);
                    $('#msg_content').html(resp.data.content);

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

