
var Org = (function() {

    var _options = {};
 

    var _active_tab = 'create_default_tab';

    // constructor
    function Org(  options  ) {
        _options = options;


    };

    Org.prototype.getOptions = function() {
        return _options;
    };

    Org.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Org.prototype.fetch = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/org/get/"+id,
            data: {} ,
            success: function (resp) {
                console.log(resp)
                var origin  = resp.data.org;
                $('#path').val(origin.path);
                $('#name').val(origin.name);
                $('#description').val(origin.description);
                $('#avatar_display').attr('src',origin.avatar);
                $('#avatar_display').removeClass('hidden');
                $('input:radio[name="params[scope]"]').removeAttr('checked');
                $('#origin_scope'+origin.scope).attr("checked","checked");

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Org.prototype.add = function(  ) {

        var url = $('#origin_form').attr('action')
        var uploads = _fineUploader.getUploads({
            status: qq.status.UPLOAD_SUCCESSFUL
        });
        $('#fine_uploader_json').val(JSON.stringify(uploads))
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#origin_form').serialize(),
            success: function (resp) {

                if( resp.ret=='200'){
                    window.location.href = '/origin';
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.update = function(  ) {

        var url =  '/org/update';
        var uploads = _fineUploader.getUploads({
            status: qq.status.UPLOAD_SUCCESSFUL
        });
        $('#fine_uploader_json').val(JSON.stringify(uploads))
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#origin_form').serialize(),
            success: function (resp) {

                //notify_error(resp.msg);
                if( resp.ret=='200'){
                    window.location.reload();
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.delete = function( id ) {

        var url =  '/org/delete/'+id;
 
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            success: function (resp) {

                //notify_error(resp.msg);
                if( resp.ret=='200'){
                    window.location.reload();
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.fetchAll = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {
                if(resp.data.orgs.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_delete").click(function(){
                        Org.prototype.delete( $(this).data("id"));
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        type: 'search',
                        handleHtml: '<a class="btn btn-default" href="#"><svg class="logo" style="font-size: 20px; opacity: .6"><use xlink:href="#logo-svg"></use></svg>返回首页</a><a class="btn btn-success" href="/project/main/_new">创建项目</a>'
                    })
                    $('#list_render_id').append($('<tr><td colspan="5" id="list_render_id_wrap"></td></tr>'))
                    $('#list_render_id_wrap').append(emptyHtml.html)
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return Org;
})();

