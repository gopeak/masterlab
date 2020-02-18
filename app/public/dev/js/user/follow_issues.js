var FollowIssues = (function () {

    var _options = {};

    // constructor
    function FollowIssues(options) {
        _options = options;
    };

    FollowIssues.prototype.getOptions = function () {
        return _options;
    };

    FollowIssues.prototype.setOptions = function (options) {
        for (var i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    FollowIssues.prototype.fetchByUser = function ( page ) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/user/fetchMyFollowedIssues',
            data: {page:page, user_id:_options.user_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.data.issues.length) {
                    var source = $('#follow_issue_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#follow_issue_list').append(result);

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if (window._cur_page < pages) {
                        $('#more_follow').removeClass('hide');
                    } else {
                        $('#more_follow').addClass('hide');
                    }
                } else {
                    var emptyHtml = defineStatusHtml({
                        wrap: '#projects_list',
                        message : '暂无数据',
                        handleHtml: ''
                    })
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });


    }

    return FollowIssues;
})();

