
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
                return;
                var source = $('#issue_user_infos_tpl').html();
                var template = Handlebars.compile(source);
                var result = template( resp.data );
                $('#issue_user_infos').html(result);


            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return IssueDetail;
})();


