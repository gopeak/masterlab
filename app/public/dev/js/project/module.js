
let Module = (function() {

    let _options = {};

    // constructor
    function Module(  options  ) {
        _options = options;
    };

    Module.prototype.getOptions = function() {
        return _options;
    };

    Module.prototype.fetch = function(id ) {

    };


    Module.prototype.add = function(  ) {

    };

    Module.prototype.update = function(  ) {

    };

    Module.prototype.delete = function( id ) {

    };

    Module.prototype.edit = function(module_id){

        let method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/project/module/fetch_module",
            data: {module_id: module_id},
            success: function (resp) {
                if(resp.ret == 200){
                    $('#mod_form_id').val(resp.data.id);
                    $('#mod_form_name').val(resp.data.name);
                    $('#mod_form_description').val(resp.data.description);
                } else {
                    alert('数据获取失败');
                }
                //$('#modal-edit-module').modal();

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });



    };

    Module.prototype.fetchAll = function(  ) {
        // url,  list_tpl_id, list_render_id
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {
                let source = $('#'+_options.list_tpl_id).html();
                let template = Handlebars.compile(source);
                let result = template(resp.data);
                //console.log(result);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_delete").click(function(){
                    Module.prototype.delete( $(this).data("id"));
                });


                $(".project_module_edit_click").bind("click", function () {
                    Module.prototype.edit($(this).data('module_id'));
                });
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    };

    return Module;
})();

