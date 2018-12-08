

function fetchLogs( url,  filename, tpl_id, parent_id ) {

    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: 'filename='+filename,
        success: function (resp) {

            auth_check(resp);

            var source = $('#'+tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(resp.data);
            $('#' + parent_id).html(result);

            $(".item-display").click(function () {
                index = $(this).data('index');
                $(".stack-data-tr").not(".item-display-data-"+index).hide();
                $(".item-display-data-"+index).toggle();
            });
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}



