
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
                    var uid = resp.data.timelines[i].uid;
                    resp.data.timelines[i]['user'] = _issueConfig.users[uid];
                }

                var source = $('#timeline_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#timelines_list').html(result);

                for(i=0;i<resp.data.timelines.length;i++){
                    var id = resp.data.timelines[i].id;
                    var content = resp.data.timelines[i].content;

                    if(_editor_md!=null){
                        return;
                        _editor_md.markdownToHTML("editormd-view_"+id, {
                            markdown        : content ,//+ "\r\n" + $("#append-test").text(),
                            htmlDecode      : "style,script,iframe",  // you can filter tags decode
                            //toc             : false,
                            tocm            : true,    // Using [TOCM]
                            //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
                            //gfm             : false,
                            //tocDropdown     : true,
                            emoji           : true,
                            taskList        : true,
                            tex             : true,  // 默认不解析
                            flowChart       : true,  // 默认不解析
                            sequenceDiagram : true,  // 默认不解析
                        });
                    }


                }

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

