
var Origin = (function() {

    var _options = {};
 

    var _active_tab = 'create_default_tab';

    // constructor
    function Origin(  options  ) {
        _options = options;


    };

    Origin.prototype.getOptions = function() {
        return _options;
    };

    Origin.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Origin.prototype.fetch = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/origin/get/"+id,
            data: {} ,
            success: function (resp) {

                var origin  = resp.data.origin;
                $('#path').val(origin.path);
                $('#name').val(origin.name);
                $('#description').val(origin.description);
                $('#avatar_display').attr('src',origin.avatar);
                $('#avatar_display').removeClass('hidden');
                $('input:radio[name="params[scope]"]').removeAttr('checked');
                $('#origin_scope'+origin.scope).attr("checked","checked");

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }


    Origin.prototype.add = function(  ) {

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

                //alert(resp.msg);
                if( resp.data.ret=='200'){
                    window.location.href = '/origin';
                }else {
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Origin.prototype.update = function(  ) {

        var url =  '/origin/update';
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

                //alert(resp.msg);
                if( resp.data.ret=='200'){
                    window.location.reload();
                }else {
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Origin.prototype.delete = function( id ) {

        var url =  '/origin/delete/'+id;
        var uploads = _fineUploader.getUploads({
            status: qq.status.UPLOAD_SUCCESSFUL
        });
        $('#fine_uploader_json').val(JSON.stringify(uploads))
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            success: function (resp) {

                //alert(resp.msg);
                if( resp.data.ret=='200'){
                    window.location.reload();
                }else {
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    Origin.prototype.fetchAll = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {

                var source = $('#'+_options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_delete").click(function(){
                    Origin.prototype.delete( $(this).data("id"));
                });

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return Origin;
})();

