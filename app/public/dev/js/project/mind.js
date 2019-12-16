let MindAjax = (function() {

    let _options = {};

    // constructor
    function MindAjax(  options  ) {
        _options = options;
    };

    MindAjax.prototype.getOptions = function() {
        return _options;
    };


    MindAjax.prototype.fetchAll = function(project_id, params) {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/mind/fetchMindIssues/'+project_id,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.length) {

                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    return MindAjax;
})();

