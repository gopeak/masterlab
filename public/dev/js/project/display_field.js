let DisplayField = (function () {

    let _options = {};

    // constructor
    function DisplayField (options) {
        _options = options;
    };

    DisplayField.prototype.getOptions = function () {
        return _options;
    };

    DisplayField.prototype.fetch = function (id) {

    };

    DisplayField.prototype.update = function () {
        var displayFieldsArr = [];
        $.each($("input[name='display_fields[]']"), function () {
            if (this.checked) {
                displayFieldsArr.push($(this).val());
            }
        });
        console.log(displayFieldsArr);
        var is_user_display_field = $("#is_user_display_field").val();
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: _options.updateDisplayFieldUrl,
            data: { display_fields: displayFieldsArr, project_id: cur_project_id ,is_user_display_field:is_user_display_field},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                // window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    return DisplayField;
})();

