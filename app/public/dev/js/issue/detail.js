
var IssueDetail = (function() {

    var _options = {};

    var _create_configs = [];
    var _tabs = [];
    var _edit_configs = [];
    var _edit_tabs = [];
    var _fields = [];
    var _field_types = [];

    var _edit_issue = {};

    var _active_tab = 'create_default_tab';

    // constructor
    function IssueDetail(  options  ) {
        _options = options;


    };

    IssueDetail.prototype.getOptions = function() {
        return _options;
    };

    IssueDetail.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };


    IssueDetail.prototype.fetchIssue = function(id ) {

        $('#issue_id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/detail/get/"+id,
            data: {} ,
            success: function (resp) {

                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = resp.issue_types;
                _edit_issue = resp.data.issue;

                _issueConfig.priority =  resp.data.priority;
                _issueConfig.issue_types =   resp.data.issue_types;
                _issueConfig.issue_status =   resp.data.issue_status;
                _issueConfig.issue_resolve =   resp.data.issue_resolve;
                _issueConfig.issue_module =  resp.data.project_module;
                _issueConfig.issue_version =  resp.data.project_version;
                _issueConfig.issue_labels =  resp.data.issue_labels;
                _issueConfig.users =  resp.data.users;

                IssueDetail.prototype.fetchTimeline(_issue_id);

                var source = $('#issuable-header_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#issuable-header').html(result);

                var source = $('#issue_fields_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#issue_fields').html(result);

                var source = $('#detail-page-description_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#detail-page-description').html(result);


            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.fetchTimeline = function(id ) {

        $('#issue_id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/detail/fetch_timeline/"+id,
            data: {} ,
            success: function (resp) {

                for(i=0;i<resp.data.timelines.length;i++){
                    var obj = resp.data.timelines[i]
                    var uid = obj.uid;
                    var type = obj.type;
                    var action = obj.action;

                    obj['user'] = _issueConfig.users[uid];
                    obj['is_cur_user'] = false;
                    if(uid==_cur_uid){
                        obj['is_cur_user'] = true;
                    }
                    obj['is_issue_commented'] = false;
                    if(type='issue' && action=='commented'){
                        obj['is_issue_commented'] = true;
                    }
                    resp.data.timelines[i] = obj;
                }

                var source = $('#timeline_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#timelines_list').html(result);

                $(".js-note-edit2").bind("click",function(){

                    var id = $(this).data('id')
                    var editormd_div_id = "timeline-div-editormd_"+id;
                    _timelineEditormd = editormd(editormd_div_id, {
                            width: "100%",
                            height: 240,
                            path : ROOT_URL+'dev/lib/editor.md/lib/',
                            imageUpload : true,
                            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                            imageUploadURL : "/issue/detail/editormd_upload",
                            htmlDecode      : "style,script,iframe",  // you can filter tags decode
                            tocm            : true,    // Using [TOCM]
                            emoji           : true,
                            saveHTMLToTextarea:true
                        });
                    $('#timeline-text_'+id).hide();
                    $('#note-actions_'+id).hide();
                    $('#timeline-footer-action_'+id).removeClass('hidden')
                    $('#timeline-footer-action_'+id).show();
                    $('#timeline-div-editormd_'+id).removeClass('hidden')
                    $('#timeline-div-editormd_'+id).show();

                });

                $(".btn-timeline-update").bind("click",function(){

                    var timeline_id = $(this).data('id')
                    var editormd_div_id = "timeline-div-editormd_"+timeline_id;

                    var content = _timelineEditormd.getMarkdown();
                    var content_html = _timelineEditormd.getHTML();

                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: "/issue/detail/update_timeline/",
                        data: {id:timeline_id,content:content,content_html:content_html} ,
                        success: function (resp) {
                            //alert(resp.msg);
                            if( resp.ret=='200'){
                                IssueDetail.prototype.fetchTimeline($('#issue_id').val());
                            }else {
                                alert(resp.msg);
                            }
                        },
                        error: function (res) {
                            alert("请求数据错误" + res);
                        }
                    });

                });
                $(".note-edit-cancel").bind("click",function(){

                    var id = $(this).data('id')

                    $('#timeline-text_'+id).show();
                    $('#note-actions_'+id).show();

                    $('#timeline-div-editormd_'+id).addClass('hidden')
                    $('#timeline-div-editormd_'+id).hide();

                    $('#timeline-footer-action_'+id).addClass('hidden')
                    $('#timeline-footer-action_'+id).hide();

                });

                $(".js-note-remove").bind("click",function(){

                    var msg = $(this).data('confirm2');
                     if( window.confirm( msg ) ){
                         $.ajax({
                             type: 'get',
                             dataType: "json",
                             async: true,
                             url: $(this).data('url'),
                             data:{id:$(this).data('id')},
                             success: function (resp) {

                                 //alert(resp.msg);
                                 if( resp.ret=='200'){
                                     IssueDetail.prototype.fetchTimeline($('#issue_id').val());
                                 }else {
                                     alert(resp.msg);
                                 }
                             },
                             error: function (res) {
                                 alert("请求数据错误" + res);
                             }
                         });
                     }
                });

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.addTimeline = function( is_reopen ) {

        var issue_id = $('#issue_id').val( );
        var reopen = '0';
        if( is_reopen=='1' ){
            reopen = '1';
        }
        var content = _editor_md.getMarkdown();
        var content_html = _editor_md.getHTML();
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/detail/add_timeline/",
            data: {issue_id:issue_id,content:content,content_html:content_html,reopen:reopen} ,
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

    return IssueDetail;
})();

