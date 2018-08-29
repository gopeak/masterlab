
function fetchList(url, tpl_id, render_id, page)
{
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: "page="+page,
        success: function(resp) {
            if(resp.data.rows.length){
                var source = $('#' + tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + render_id).html(result);

                var options = {
                    currentPage: resp.data.page,
                    totalPages: resp.data.pages,
                    onPageClicked: function(e,originalEvent,type,page){
                        console.log("Page item clicked, type: "+type+" page: "+page);
                        fetchList('/admin/project/filterData', tpl_id, render_id, page);
                    }
                }
                $('#ampagination-bootstrap').bootstrapPaginator(options);
            }else{
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    type: 'error',
                    handleHtml: ''
                })
                $('#'+render_id).append($('<tr><td colspan="6" id="' + render_id + '_wrap"></td></tr>'))
                $('#'+render_id + '_wrap').append(emptyHtml.html)
            }


        },
        error: function(res) {
            notify_error("请求数据错误" + res);
        }
    });
}

