

function fetchLogs( url,  tpl_id, parent_id ) {

    var params = {  format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: $('#log_filter_form').serialize() ,
        success: function (resp) {
            auth_check(resp);
            if(resp.data.logs.length){
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);


                $(".log_for_edit ").click(function(){
                    detail( $(this).attr("data-id") );
                });

                $(".action_li").click(function () {
                    $('#filter_action').val( $(this).attr('data-action') );
                    $('#action_view').html($(this).attr('data-title') );
                });

                var options = {
                    currentPage: resp.data.page,
                    totalPages: resp.data.pages,
                    onPageClicked: function(e,originalEvent,type,page){
                        console.log("Page item clicked, type: "+type+" page: "+page);
                        $("#filter_page").val( page );
                        fetchLogs(root_url+'admin/log_operating/filter','log_tpl','render_id');
                    }
                }
                $('#ampagination-bootstrap').bootstrapPaginator(options);
            }else{
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    handleHtml: ''
                })
                $('#'+parent_id).append($('<tr><td colspan="9" id="' + parent_id + '_wrap"></td></tr>'))
                $('#'+parent_id + '_wrap').append(emptyHtml.html)
            }
            

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


function logFormReset(){
    $("#filter_page").val("1");
    $("#filter_username").val("");
    $("#filter_remark").val("");
    $("#filter_action").val("");
    $('#action_view').html( $('#action_view').attr("data-title-origin") );
}

function detail( id ) {

    var method = 'get';
    var url = '/admin/log_operating/get/?id='+id;
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {} ,
        success: function (resp) {

            auth_check(resp);
            var source = $('#data_tpl').html();
            var template = Handlebars.compile(source);
            var result = template(resp.data);
            $('#render_detail_id').html(result);

            $("#modal-log_edit").modal();

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


