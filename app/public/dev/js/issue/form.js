
var IssueForm = (function() {

    var _options = {};

    var _active_tab = 'create_default_tab';

    var _allow_update_status = [];

    var _allow_add_status = [];

    // constructor
    function IssueForm(  options  ) {
        _options = options;

    };

    IssueForm.prototype.getOptions = function() {
        return _options;
    };

    IssueForm.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };


    IssueForm.prototype.isExistOption = function(id,value) {
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

    IssueForm.prototype.makeCreateHtml = function( configs, fields, tab_id ) {

        var html = '';
        for (var i = 0; i < configs.length; i++) {
            var config = configs[i];
            if(config.tab_id!=tab_id){
                continue;
            }
            var field = IssueForm.prototype.getField(fields,config.field_id);
            if(field.default_value==null){
                field.default_value = '';
            }
            html += IssueForm.prototype.createField(config,field,'create');
        }
        //console.log(html);
        return html;

    }

    IssueForm.prototype.makeEditHtml = function( configs, fields, tab_id ,issue) {

        var html = '';
        console.log(issue);
        _allow_update_status = issue.allow_update_status;
        for (var i = 0; i < configs.length; i++) {
            var config = configs[i];
            if(config.tab_id!=tab_id){
                continue;
            }
            var field = IssueForm.prototype.getField(fields,config.field_id);
            if(field.default_value==null){
                field.default_value = '';
            }
            if(issue.hasOwnProperty(field.name)){
                field.default_value  = issue[field.name];
            }
            html += IssueForm.prototype.createField(config,field,'edit');
        }
        console.log(html);
        return html;
    }

    IssueForm.prototype.uiAddTab = function(type, title , tab_id){

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
        var existing = $("#"+type+"_master_tabs").find("[id='"+id+"']");
        if(existing.length==0){
            $( "#create_tabs" ).append( li );
            var source = $('#content_tab_tpl').html();
            var template = Handlebars.compile(source);
            var result = template({id:id});
            $("#"+type+"_master_tabs").append( result );
        }
        _active_tab = id;
        $( ".nav-tabs li" ).removeClass('active');
        $(".tab-pane").removeClass('active');
        IssueForm.prototype.bindNavTabClick();
        $('#a_'+id).tab('show');
        $('#a_'+id).click();

        return;
    }

    IssueForm.prototype.bindNavTabClick = function(e) {
        $('.nav-tabs a').click(function (e) {
            if ($(this).attr('id') != 'new_tab') {
                e.preventDefault()
                _active_tab = $(this).attr('id').replace('a_', '');
                $(this).tab('show')
            }
        });
    }



    IssueForm.prototype.checkFieldInUi = function(configs,field_id)
    {
        for(var j = 0; j < configs.length; j++){
            if(configs[j].field_id==field_id){
                return true;
            }
        }
        return false;
    };

    IssueForm.prototype.createField = function( config,  field ,ui_type) {

        var html = '';

        switch(field.type)
        {
            case "TEXT":
                html += IssueForm.prototype.makeFieldText( config,field ,ui_type );
                break;
            case "TEXT_MULTI_LINE":
                html += IssueForm.prototype.makeFieldTextMulti( config,field ,ui_type );
                break;
            case "PRIORITY":
                html += IssueForm.prototype.makeFieldPriority( config,field ,ui_type );
                break;
            case "STATUS":
                html += IssueForm.prototype.makeFieldStatus( config,field ,ui_type );
                break;
            case "RESOLUTION":
                html += IssueForm.prototype.makeFieldResolution( config,field ,ui_type );
                break;
            case "MODULE":
                html += IssueForm.prototype.makeFieldModule( config,field ,ui_type );
                break;
            case "LABELS":
                html += IssueForm.prototype.makeFieldLabels( config,field ,ui_type );
                break;
            case "UPLOAD_IMG":
                html += IssueForm.prototype.makeFieldUploadImg( config,field ,ui_type );
                break;
            case "UPLOAD_FILE":
                html += IssueForm.prototype.makeFieldUploadFile( config,field ,ui_type );
                break;
            case "VERSION":
                html += IssueForm.prototype.makeFieldVersion( config,field ,ui_type );
                break;
            case "USER":
                html += IssueForm.prototype.makeFieldUser( config,field ,ui_type );
                break;
            case "MILESTONE":
                html += IssueForm.prototype.makeFieldText( config,field ,ui_type );
                break;
            case "SPRINT":
                html += IssueForm.prototype.makeFieldSprint( config,field ,ui_type );
                break;
            case "TEXTAREA":
                html += IssueForm.prototype.makeFieldTextarea( config,field ,ui_type );
                break;
            case "MARKDOWN":
                html += IssueForm.prototype.makeFieldMarkdown( config,field ,ui_type );
                break;
            case "RADIO":
                html += IssueForm.prototype.makeFieldRadio( config,field ,ui_type );
                break;
            case "CHECKBOX":
                html += IssueForm.prototype.makeFieldCheckbox( config,field ,ui_type );
                break;
            case "SELECT":
                html += IssueForm.prototype.makeFieldSelect( config,field  ,ui_type,false);
                break;
            case "SELECT_MULTI":
                html += IssueForm.prototype.makeFieldSelect( config,field  ,ui_type);
                break;
            case "DATE":
                html += IssueForm.prototype.makeFieldDate( config,field  ,ui_type);
                break;
            default:
                html += IssueForm.prototype.makeFieldText( config,field  ,ui_type);
        }

        return html;
    }

    IssueForm.prototype.wrapField = function( config, field , field_html) {

        var display_name = field.title;
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

    IssueForm.prototype.makeFieldTextMulti = function( config, field ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        if(default_value==null){
            default_value = '';
        }

        var id = ui_type+"_issue_textmulti_"+name;
        var html = '';
        html += '<input type="text" multiple class="form-control" name="'+field_name+'" id="'+id+'"  value="'+default_value+'"   />';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldText = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        if(default_value==null){
            default_value = '';
        }
        var id = ui_type + '_issue_text_'+name
        var html = '';
        html += '<input type="text" class="form-control" name="'+field_name+'" id="'+id+'"  value="'+default_value+'"  />';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldLabels = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        //html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'"  />';
        var edit_data = [];
        if(default_value!=null){
            for (var i = 0; i < default_value.length; i++) {
                edit_data.push(  IssueForm.prototype.getArrayValue(_issueConfig.issue_labels, default_value[i])  )
            }
        }
        console.log(edit_data);
        var value_title = 'Labels';
        if(edit_data.length>0){
            if(edit_data.length==1){
                value_title = edit_data[0].name;
            }
            if(edit_data.length==2){
                value_title = edit_data[0].name+','+edit_data[1].name;
            }
            if(edit_data.length>2){
                value_title = edit_data[0].name+'+';
            }
        }
        var is_default = 'is-default';
        if(edit_data.length>0){
            is_default = '';
        }
        var data = {
            project_id:_cur_project_id,
            display_name:display_name,
            default_value:default_value,
            field_name:field_name,
            edit_data:edit_data,
            value_title:value_title,
            is_default:is_default,
            name:field.name,
            id:ui_type+"_issue_labels_"+name
        };

        var source = $('#labels_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldUploadImg = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_upload_img_'+name;
        var id_uploder = id+'_uploader'
        var html = '';
        html = '<input type="hidden"  name="'+field_name+'" id="'+id+'"  value=""  /><div id="'+id_uploder+'" class="fine_uploader_img"></div>';
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldUploadFile = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_upload_file_'+name;
        var id_uploder = id+'_uploader'

        var html = '';
        html = '<input type="hidden"  name="'+field_name+'" id="'+id+'"  value=""  /><div id="'+id_uploder+'" class="fine_uploader_attchment"></div>';
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldVersion = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        var edit_data = [];
        if(default_value!=null){
            for (var i = 0; i < default_value.length; i++) {
                 edit_data.push(  IssueForm.prototype.getVersion(_issueConfig.issue_version, default_value[i])  )
            }
        }else{
            default_value = '';
        }

        var value_title = 'Version';
        if(edit_data.length>0){
            if(edit_data.length==1){
                value_title = edit_data[0].name;
            }
            if(edit_data.length==2){
                value_title = edit_data[0].name+','+edit_data[1].name;
            }
            if(edit_data.length>2){
                value_title = edit_data[0].name+'+';
            }
        }
        var is_default = 'is-default';
        if(edit_data.length>0){
            is_default = '';
        }
        console.log(edit_data);
        var data = {
            project_id:_cur_project_id,
            display_name:display_name,
            default_value:default_value,
            is_default:is_default,
            edit_data:edit_data,
            value_title:value_title,
            field_name:field_name,
            name:field.name,
            id:ui_type+"_issue_version_"+name
        };

        var source = $('#version_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);
        //console.log( html );
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldUser = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        if(default_value==null || default_value=='null'){
            default_value = '';
        }

        var html = '';
       // html += '<input type="text" class="form-control" name="'+name+'" id="'+name+'"  value="'+default_value+'"  />';
        var data = {
            display_name:display_name,
            default_value:default_value,
            field_name:field_name,
            name:field.name,
            id:ui_type+"_issue_user_"+display_name
        };

        var source = $('#user_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field, html);
    }


    IssueForm.prototype.makeFieldSprint = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_'+name;

        var html = '';
        html ='<select id="'+id+'" name="'+field_name+'" class="selectpicker"    title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var sprint = _issueConfig.sprint;
        console.log(sprint);
        for (var i in sprint){
            var sprint_id = sprint[i].id;
            var sprint_title = sprint[i].name;
            var selected = '';
            if(sprint_id==default_value){
                selected = 'selected';
            }
            html +='   <option data-content="<span style=\'color:'+color+'\'>'+sprint_title+'</span>" value="'+sprint_id+'" '+selected+'>'+sprint_title+'</option>';

        }
        html +='</select>';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldPriority = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_'+name;

        var html = '';
        html ='<select id="'+id+' " name="'+field_name+'" class="selectpicker"    title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var priority = _issueConfig.priority;
        console.log(priority);
        for (var i in priority){
            var priority_id = priority[i].id;
            var priority_title = priority[i].name;
            var color = priority[i].status_color;
            var selected = '';
            if(priority_id==default_value){
                selected = 'selected';
            }
            html +='   <option data-content="<span style=\'color:'+color+'\'>'+priority_title+'</span>" value="'+priority_id+'" '+selected+'>'+priority_title+'</option>';

        }
        html +='</select>';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldStatus = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_'+name;

        var html = '';
        html ='<select id="'+id+' " name="'+field_name+'" class="selectpicker"    title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var statusArr = _allow_update_status;
        console.log(statusArr);
        for (var i=0; i<statusArr.length; i++){

            var status_id = statusArr[i].id;
            var status_title = statusArr[i].name;
            var color = statusArr[i].color;
            var selected = '';
            if(status_id==default_value){
                selected = 'selected';
            }
            html +='   <option data-content="<span class=\'label label-'+color+' prepend-left-5\' >'+status_title+'</span>" value="'+status_id+'" '+selected+'>'+status_title+'</option>';

        }
        html +='</select>';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    // makeFieldSattus

    IssueForm.prototype.makeFieldResolution = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_'+name;

        var html = '';
        html ='<select id="'+id+'" name="'+field_name+'" class="selectpicker"  title=""   >';
        //html +='   <option value="">请选择类型</option>';
        var resolve = _issueConfig.issue_resolve;
        console.log(resolve);
        html +='   <option  value=""  >请选择</option>';
        for (var i in resolve){
            var resolve_id = resolve[i].id;
            var resolve__title = resolve[i].name;
            var color = resolve[i].color;
            var selected = '';
            if(resolve_id==default_value){
                selected = 'selected';
            }
            html +='   <option data-content="<span style=\'color:'+color+'\'>'+resolve__title+'</span>" value="'+resolve_id+'" '+selected+'>'+resolve__title+'</option>';

        }
        html +='</select>';

        return IssueForm.prototype.wrapField(config, field,html);
    }


    IssueForm.prototype.makeFieldModule = function( config, field ,ui_type ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var html = '';
        var module = IssueForm.prototype.getModule(_issueConfig.issue_module,default_value);
        var module_title = display_name;
        if(module.hasOwnProperty("name")){
            module_title = module.name;
        }
        if(default_value==null || default_value=='null'){
            default_value = '';
        }
        var data = {
            project_id:_cur_project_id,
            display_name:display_name,
            module_title:module_title,
            default_value:default_value,
            field_name:field_name,
            name:field.name,
            id:ui_type+"_issue_"+name
        };

        var source = $('#module_tpl').html();
        var template = Handlebars.compile(source);
        html = template(data);

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldDate = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_laydate_'+name;
         if(default_value==null || default_value=='null'){
             default_value = '';
         }
        var html = '';
        html += '<div class="form-group"><div class="col-xs-4"> <input type="text" class="laydate_input_date form-control" name="'+field_name+'" id="'+id+'"  value="'+default_value+'"  /></div></div>';

        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldTextarea = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_textarea_'+name;

        var html = '';
        html += '<textarea placeholder="" class="form-control" rows="3" maxlength="250" name="'+field_name+'" id="'+id+'" >'+default_value+'</textarea>';
        return IssueForm.prototype.wrapField(config, field,html);
    }


    IssueForm.prototype.makeFieldMarkdown = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';
        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_simplemde_'+name;

        var html = '<textarea class="simplemde_text" name="'+field_name+'" id="'+id+'">'+default_value+'</textarea>';

        return IssueForm.prototype.wrapField(config, field,html);
    }


    IssueForm.prototype.makeFieldRadio = function( config, field  ,ui_type) {
        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
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
                var id = ui_type + '_issue_'+name+Key;
                html += '<div class="radio"><label><input '+selected+'  type="radio" name="'+field_name+'" id="'+id+'"  value="'+Key+'" disabled >'+field.options[Key]+'</label></div>';
            }
        }
    //<div class="radio"> <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Option two  </label></div>
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldCheckbox = function( config, field  ,ui_type) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
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
                var id = ui_type + '_issue_'+name+Key;
                html += '<input '+selected+'  type="checkbox" class="form-control" name="'+field_name+'" id="'+id+'"  value="'+Key+'" />'+field.options[Key];
            }
        }
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.makeFieldSelect = function( config, field ,ui_type,isMulti ) {

        var display_name = field.title;
        var name = field.name;
        var required = config.required;
        var type = config.type;
        var field_name = 'params['+name+']';
        var default_value = field.default_value
        var required_html = '';

        if( required ){
            required_html = '<span style="color: red"> *</span>';
        }
        var id = ui_type+'_issue_select_'+name;
        var multi = '';
        if(isMulti){
            multi = 'multiple ';
        }
        var html = '';
        html += '<select '+multi+' class="form-control" name="'+field_name+'" id="'+id+'"   />';
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
        return IssueForm.prototype.wrapField(config, field,html);
    }

    IssueForm.prototype.getField = function( fields, field_id ) {

        var field = {};
        for (var i = 0; i < fields.length; i++) {
            if(fields[i].id==field_id){
                return fields[i];
            }
        }
        return field;
    }

    IssueForm.prototype.getModule = function( modules, module_id ) {

        var module = {};
        for (var i = 0; i < modules.length; i++) {
            if(modules[i].id==module_id){
                return modules[i];
            }
        }
        return module;
    }

    IssueForm.prototype.getVersion = function( versions, version_id ) {

        var version = {};
        for (var i = 0; i < versions.length; i++) {
            if(versions[i].id==version_id){
                return versions[i];
            }
        }
        return version;
    }

    IssueForm.prototype.getArrayValue= function( arrs, id ) {

        var obj = null;
        for (var i = 0; i < arrs.length; i++) {
            if(arrs[i].id==id){
                return arrs[i];
            }
        }
        return obj;
    }

    return IssueForm;
})();


