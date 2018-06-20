
var IssueUi = (function() {

    var _options = {};

    var _create_configs = [];
    var _create_tabs = [];
    var _edit_configs = [];
    var _edit_tabs = [];
    var _fields = [];
    var _field_types = [];

    var _active_tab = 'create_default_tab';

    // constructor
    function IssueUi(  options  ) {
        _options = options;

    };

    IssueUi.prototype.getOptions = function() {
        return _options;
    };

    IssueUi.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    IssueUi.prototype.fetchIssueTypeUi  = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#'+_options.filter_form_id).serialize() ,
            success: function (resp) {

                var source = $('#'+_options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_config_create").click(function(){
                    IssueUi.prototype.getCreateConfigs($(this).attr("data-issue_type_id"), 'create');
                });

                $(".list_for_config_edit").click(function(){
                    IssueUi.prototype.getEditConfigs($(this).attr("data-issue_type_id"), 'edit');
                });

                $(".list_for_config_view").click(function(){
                    IssueUi.prototype.getViewConfigs($(this).attr("data-issue_type_id"), 'view');
                });

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueUi.prototype.isExistOption = function(id,value) {
        var isExist = false;
        var count = $('#'+id).find('option').length;
        for(var i=0;i<count;i++)
        {
            if($('#'+id).get(0).options[i].value == value)
            {
                isExist = true;
                break;
            }
        }
        return isExist;
    }

    IssueUi.prototype.getCreateConfigs = function(issue_type_id,type ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_config_url,
            data: { issue_type_id:issue_type_id,type:type} ,
            success: function (resp) {

                $("#edit_type").val(type);
                $("#modal-config_create").modal();

                var create_field_select = document.getElementById('create_field_select');
                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _create_tabs = resp.data.tabs;
                _field_types = resp.data.field_types;

                // create default tab
                var default_tab_id = 0;
                var html = IssueUi.prototype.makeCreatePreview( _create_configs, _fields, default_tab_id);
                $('#create_ui_config-default_tab').html(html);
                $('#create_ui-nestable_default').nestable().on('change', IssueUi.prototype.updateOutput);

                // create other tab
                for(var i = 0; i < _create_tabs.length; i++){
                    var order_weight = parseInt(_create_tabs[i].order_weight)+1
                    IssueUi.prototype.uiAddTab(type,_create_tabs[i].name,order_weight);
                    var html = IssueUi.prototype.makeCreatePreview( _create_configs, _fields, order_weight);
                    var id = '#create_ui_config-create_tab-'+order_weight
                    $(id).html(html);
                    $('#nestable_create_tab-'+order_weight).nestable().on('change', IssueUi.prototype.updateOutput);

                }

                for(var i = 0; i < _fields.length; i++){
                    if( IssueUi.prototype.checkFieldInUi(_create_configs,_fields[i].id)){
                        continue;
                    }
                    create_field_select.options.add(new Option( _fields[i].name, _fields[i].id ));
                }
                $("#create_field_select").bind("change", function () {
                    var field = IssueUi.prototype.getField(_fields,$(this).val());
                    IssueUi.prototype.addUiField(field);
                })
                $('.selectpicker').selectpicker('refresh');
                $(".create_li_remove").click(function(){
                    IssueUi.prototype.removeCreateField($(this).attr("data-field_id") );
                });
                IssueUi.prototype.bindNavTabClick();

                $('.fa-pencil').each(function (e) {
                    IssueUi.prototype.showEditTab($(this), $(this).parent().text());
                });
                $('#create_issue_type_id').val(issue_type_id);
                $('#a_create_default_tab').click();

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueUi.prototype.getEditConfigs = function(issue_type_id,type ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_config_url,
            data: { issue_type_id:issue_type_id,type:type} ,
            success: function (resp) {

                $("#edit_type").val(type);
                $("#modal-config_edit").modal();

                var create_field_select = document.getElementById('edit_field_select');
                _fields = resp.data.fields
                _edit_configs = resp.data.configs;
                _edit_tabs = resp.data.tabs;
                _field_types = resp.data.fieldtypes;

                // create default tab
                var default_tab_id = 0;
                var html = IssueUi.prototype.makeCreatePreview( _edit_configs, _fields, default_tab_id);
                $('#edit_ui_config-default_tab').html(html);
                $('#edit_ui-nestable_default').nestable().on('change', IssueUi.prototype.updateOutput);

                // create other tab
                for(var i = 0; i < _edit_tabs.length; i++){
                    var order_weight = parseInt(_edit_tabs[i].order_weight)+1
                    IssueUi.prototype.uiAddTab(type,_edit_tabs[i].name,order_weight);
                    var html = IssueUi.prototype.makeCreatePreview( _edit_configs, _fields, order_weight);
                    var id = '#edit_ui_config-edit_tab-'+order_weight
                    $(id).html(html);
                    $('#nestable_edit_tab-'+order_weight).nestable().on('change', IssueUi.prototype.updateOutput);

                }

                for(var i = 0; i < _fields.length; i++){
                    if( IssueUi.prototype.checkFieldInUi(_edit_configs,_fields[i].id)){
                        continue;
                    }
                    create_field_select.options.add(new Option( _fields[i].name, _fields[i].id ));
                }
                $("#edit_field_select").bind("change", function () {
                    var field = IssueUi.prototype.getField(_fields,$(this).val());
                    IssueUi.prototype.addUiField(field);
                })
                $('.selectpicker').selectpicker('refresh');
                $(".edit_li_remove").click(function(){
                    IssueUi.prototype.removeEditField($(this).attr("data-field_id") );
                });
                IssueUi.prototype.bindNavTabClick();

                $('.fa-pencil').each(function (e) {
                    IssueUi.prototype.showEditTab($(this), $(this).parent().text());
                });
                $('#edit_issue_type_id').val(issue_type_id);
                $('#a_edit_default_tab').click();

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueUi.prototype.saveCreateConfig = function(   ) {
        var tabs = []
        $('#create_tabs li a').each(function(){
            var id = $(this).attr('id').replace('a_','');
            if( id!="new_tab") {

                var text = $(this).text();
                var fields = [];
                $('#create_ui_config-' + id + ' li').each(function () {
                    fields.push($(this).attr('id').replace('create_warp_', ''));
                });
                tabs.push({id: id, display: text, fields: fields});
            }
        });
        $('#create_data').val(JSON.stringify(tabs) );
        var ui_data = JSON.stringify(tabs);
        var issue_type_id = $('#create_issue_type_id').val();
        var post_data = {data:ui_data ,issue_type_id:issue_type_id, ui_type:'create'};
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '/admin/issue_ui/saveCreateConfig',
            data: post_data,
            success: function (resp) {

                if(resp.ret=='200'){
                    alert('ok');
                }else{
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
        console.log( tabs );
    }


    IssueUi.prototype.saveEditConfig = function(   ) {
        var tabs = []
        $('#edit_tabs li a').each(function(){
            var id = $(this).attr('id').replace('a_','');
            if( id!="edit_new_tab") {

                var text = $(this).text();
                var fields = [];
                $('#edit_ui_config-' + id + ' li').each(function () {
                    fields.push($(this).attr('id').replace('create_warp_', ''));
                });
                tabs.push({id: id, display: text, fields: fields});
            }
        });
        $('#create_data').val(JSON.stringify(tabs) );
        var ui_data = JSON.stringify(tabs);
        var issue_type_id = $('#edit_issue_type_id').val();
        var post_data = {data:ui_data ,issue_type_id:issue_type_id,type:'edit'};
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '/admin/issue_ui/saveCreateConfig',
            data: post_data,
            success: function (resp) {

                if(resp.ret=='200'){
                    alert('ok');
                }else{
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
        console.log( tabs );
    }
    IssueUi.prototype.bindNavTabClick = function(e)
    {
        $('.nav-tabs a').click(function (e) {
            if($(this).attr('id')!='new_tab'){
                e.preventDefault()
                _active_tab = $(this).attr('id').replace('a_','');
                $(this).tab('show')
            }
        });
        $('.fa-times-circle').click(function (e) {

            if(!window.confirm('Are sure delete this tab?')){
                return;
            }

            var id = $(this).attr('data');
            $('#create_ui_config-'+id).children('li').each(function(e){

                var  field_id = $(this).attr('id').replace('create_warp_','');
                console.log( field_id );
                var create_field_select = document.getElementById('create_field_select');
                //if( !IssueUi.prototype.checkFieldInUi(_create_configs,field_id)){
                    var  field = IssueUi.prototype.getField(_fields,field_id);
                    create_field_select.options.add(new Option(field.name, field.id ));
                //}
            });
            $('.selectpicker').selectpicker('refresh');

            $('#'+id).remove();
            $('#a_'+id).parent().remove();
            $('#a_create_default_tab').click();
        });
    };

    IssueUi.prototype.updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target);
         console.log(window.JSON.stringify(list.nestable('serialize')));
    };

    IssueUi.prototype.checkFieldInUi = function(configs,field_id)
    {
        for(var j = 0; j < configs.length; j++){
            if(configs[j].field_id==field_id){
                return true;
            }
        }
        return false;
    };

    IssueUi.prototype.makeCreatePreview = function( configs, fields, tab_id ) {

        var html = '';
        for (var i = 0; i < configs.length; i++) {
            var config = configs[i];
            if(config.tab_id!=tab_id){
                continue;
            }
            var field = IssueUi.prototype.getField(fields,config.field_id);
            if(field.default_value==null){
                field.default_value = '';
            }
            html += IssueUi.prototype.createField(config,field);
        }
        console.log(html);
        return html;

    }

    IssueUi.prototype.uiAddTab = function(type, title , tab_id){

        if( typeof (tab_id)=='undefined' || tab_id==0 || tab_id==null ){
            var tab_last_index = $("#master_tabs").children().length;
        }else{
            var tab_last_index = tab_id;
        }
        //alert( tab_last_index );
        var id = type+"_tab-" + tab_last_index;

        var tpl = $('#nav_tab_li_tpl').html();
        var template = Handlebars.compile(tpl);
        var li = template({id:id,title:title});
        var existing=$("#"+type+"_master_tabs").find("[id='"+id+"']");
        if(existing.length==0){
            $( "#"+type+"_ui-new_tab_li" ).before( li );
            var source = $('#content_tab_tpl').html();
            var template = Handlebars.compile(source);
            var result = template({id:id});
            $("#"+type+"_master_tabs").append( result );
        }
        _active_tab = id;
        $( ".nav-tabs li" ).removeClass('active');
        $(".tab-pane").removeClass('active');
        IssueUi.prototype.bindNavTabClick();
        $('#'+type+'_new_tab_text').val('');
        $('#a_'+id).tab('show');
        $('#a_'+id).click();
        $('#'+type+'new_tab').qtip().hide();

        $('.fa-pencil').each(function (e) {
            IssueUi.prototype.showEditTab($(this), title);
        });

        return;
    }

    IssueUi.prototype.showEditTab = function( type, el, show_text ) {
        el.qtip({
            content: {
                text: $('#'+type+'_ui-edit_tab_tpl').html().replace("{{id}}",el.attr("data")),
                title: "编辑Tab",
                button: "关闭"
            },
            show: 'click',
            hide: 'click',
            style:{
                classes:"qtip-bootstrap"
            },
            position: {
                my: 'top left',  // Position my top left...
                at: 'bottom center', // at the bottom right of...
            },
            events: {
                show: function( event, api ) {
                    $('#'+type+'_ui-edit_tab_text').val(show_text);
                    var t=setTimeout("$('#'+type+'_ui-edit_tab_text').focus();",500)
                }
            }
        });
    }

    IssueUi.prototype.createUiSaveEditTab = function(  id, show_text ) {
        $('#span_'+id).text(show_text);
    }

    IssueUi.prototype.editUiSaveEditTab = function(  id, show_text ) {
        $('#span_'+id).text(show_text);
    }

    IssueUi.prototype.addUiField = function(  field ) {

        var config0  = _create_configs[0];
        var order_weight = $('#create_ui_config-'+_active_tab).children().length+1;
        var config = {id:0,issue_type_id:config0.issue_type_id,project_id:config0.project_id,field_id:field.id,order_weight:order_weight}
        var html = IssueUi.prototype.createField(config,field);

        console.log(field);
        if( IssueUi.prototype.checkFieldInUi(_create_configs,field.id)){
            return;
        }
        _create_configs.push(config)
        $("#create_field_select option[value="+field.id+"]").remove();
        $('.selectpicker').selectpicker('refresh');

        $('#create_ui_config-'+_active_tab).append(html);
        $(".create_li_remove").click(function(){
            IssueUi.prototype.removeCreateField($(this).attr("data-field_id") );
        });
        //alert($('#nestable_'+_active_tab).html());
        $('#create_ui-nestable_default').nestable();
        $('#nestable_create_tab-'+_active_tab).nestable();

    }

    IssueUi.prototype.removeCreateField = function(  field_id ) {

        if  (!window.confirm('Are you sure delete this item?')) {
            return false;
        }
        var config0  = _create_configs[0];

        // 删除数组
        var delete_index = false;
        for (var i = 0; i < _create_configs.length; i++) {
            if(_create_configs[i].field_id==field_id){
                delete_index = i;
            }
        }
        //if( delete_index ){
            _create_configs.splice(delete_index,1);
        //}
        console.log(_create_configs);

        // 下拉菜单新增项
        if( !IssueUi.prototype.isExistOption('create_field_select',field_id)){
            var create_field_select = document.getElementById('create_field_select');
            var field = IssueUi.prototype.getField(_fields,field_id );
            create_field_select.options.add(new Option( field.name, field.id ));
            $('.selectpicker').selectpicker('refresh');
        }
        // 删除元素
        $('#create_warp_'+field_id).remove();
        $('#create_ui-nestable_default').nestable();
        $('#nestable_create_tab-'+_active_tab).nestable();


    }


    IssueUi.prototype.createField = function( config,  field ) {

        var html = '';
        if( field.default_value==null){
            field.default_value = '';
        }
        switch(field.type)
        {
            case "TEXT":
                html += IssueUi.prototype.makeFieldText( config,field );
                break;
            case "TEXT_MULTI_LINE":
                html += IssueUi.prototype.makeFieldTextMulti( config,field );
                break;
            case "TEXTAREA":
                html += IssueUi.prototype.makeFieldTextarea( config,field );
                break;
            case "TEXT_MULTI_LINE":
                html += IssueUi.prototype.makeFieldTextMulti( config,field );
                break;
            case "RADIO":
                html += IssueUi.prototype.makeFieldRadio( config,field );
                break;
            case "CHECKBOX":
                html += IssueUi.prototype.makeFieldCheckbox( config,field );
                break;
            case "SELECT":
                html += IssueUi.prototype.makeFieldSelect( config,field ,false);
                break;
            case "SELECT_MULTI":
                html += IssueUi.prototype.makeFieldSelect( config,field ,true);
                break;
            case "DATE":
                html += IssueUi.prototype.makeFieldDate( config,field );
                break;
            default:
                html += IssueUi.prototype.makeFieldText( config,field );
        }

        return html;
    }

    IssueUi.prototype.wrapField = function( config, field , field_html) {

        var display_name = field.name;
        var required_html = '';
        if(config.order_weight=="" ||config.order_weight==null){
            config.order_weight = 0;
        }
        var order_weight = parseInt(config.order_weight);
        if( config.required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var data = {config:config,field:field,display_name:display_name,order_weight:order_weight,required_html:required_html};
        var source = $('#wrap_field').html();
        var template = Handlebars.compile(source);
        var html = template(data).replace("{field_html}",field_html);

        return html;
    }

    IssueUi.prototype.makeFieldTextMulti = function( config, field ) {

        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        html += '<input type="text" multiple class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'" readonly="readonly" />';

        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldText = function( config, field ) {

        var display_name = field.name;
        var required = config.required;
        var type = field.type;
        var name = 'preview_'+type+"_"+display_name;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'" readonly="readonly" />';

        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldDate = function( config, field ) {

        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        html += '<input type="text" class="form-control date" name="'+name+'" id="'+name+'"  value="'+default_value+'" readonly="readonly" />';

        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldTextarea = function( config, field ) {

        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        html += '<textarea placeholder="" class="form-control" rows="3" maxlength="250" name="'+name+'" id="'+name+'" >'+default_value+'</textarea>';
        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldRadio = function( config, field ) {
        console.log(field.options);
        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';

        if(field.options){
            for (var Key in field.options){
                var selected = '';
                if(Key==default_value){
                    selected = 'checked=true';
                }
                html += '<div class="radio"><label><input '+selected+'  type="radio" name="'+name+'" id="'+name+Key+'"  value="'+Key+'" disabled >'+field.options[Key]+'</label></div>';
            }
        }
    //<div class="radio"> <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Option two  </label></div>
        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldCheckbox = function( config, field ) {

        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        if(field.options){
            for (var Key in field.options){
                var selected = '';
                if(Key==default_value){
                    selected = 'checked=true';
                }
                html += '<input '+selected+'  type="checkbox" class="form-control" name="'+name+'" id="'+name+Key+'"  value="'+Key+'" readonly="readonly" />'+field.options[Key];
            }
        }
        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.makeFieldSelect = function( config, field ,isMulti) {

        var display_name = field.name;
        var required = config.required;
        var type = config.type;
        var name = 'preview_'+type;
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var multi = '';
        if(isMulti){
            multi = 'multiple ';
        }
        var html = '';
        html += '<select '+multi+' class="form-control" name="'+name+'" id="'+name+'"   readonly="readonly" />';
        if(field.options){
            for (var Key in field.options){
                var selected = '';
                if(Key==default_value){
                    selected = 'selected';
                }
                html += '<option value="'+Key+'">'+field.options[Key]+'</option>';
            }
        }
        html += '</select>';
        return IssueUi.prototype.wrapField(config, field,html);
    }

    IssueUi.prototype.getField = function( fields, field_id ) {

        var field = {};
        for (var i = 0; i < fields.length; i++) {
            if(fields[i].id==field_id){
                return fields[i];
            }
        }
        return field;
    }



    return IssueUi;
})();


