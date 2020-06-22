
function fetchList(url, tpl_id, render_id, page, is_archived)
{
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: "page="+page+"&is_archived="+is_archived,
        success: function(resp) {
            auth_check(resp);
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
                        fetchList('/admin/project/filterData', tpl_id, render_id, page, is_archived);
                    }
                };

                //取消分页
                //$('#ampagination-bootstrap').bootstrapPaginator(options);


                $(".clone_config").click(function () {

                    cloneForm($(this).data("project_id"));
                });


            } else {
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    type: 'error',
                    handleHtml: ''
                });
                $('#'+render_id).append($('<tr><td colspan="6" id="' + render_id + '_wrap"></td></tr>'));
                $('#'+render_id + '_wrap').append(emptyHtml.html);
            }
        },
        error: function(res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function cloneForm(project_id) {
    var method = 'get';
    var url = '/admin/project/get/?project_id=' + project_id;
    $('#modal_form_project_id').val(project_id);
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {},
        success: function (resp) {
            auth_check(resp);
            $("#modal-project_clone").modal();
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });

}

function doClone(project_id) {

    var method = 'post';
    var url = '/admin/project/clone/?project_id=' + project_id;
    var params = $('#form-project_clone').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params,
        success: function (resp) {
            auth_check(resp);
            if (!form_check(resp)) {
                return;
            }
            if (resp.ret === '200') {
                fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, 0);
                notify_success(resp.msg, '克隆成功');
                $('#modal-project_clone').modal('hide');
            } else {
                notify_error('克隆失败,' + resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function projectRemove(projectId, projectTypeId)
{
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: root_url+"admin/project/delete",
        data: "project_id="+projectId+"&project_type_id="+projectTypeId,
        success: function(resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                notify_success('删除成功');
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else {
                notify_error('删除失败: ' + resp.msg);
            }
        },
        error: function(res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function projectArchived(projectId)
{
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: root_url+"admin/project/doArchived",
        data: "project_id="+projectId,
        success: function(resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                notify_success('归档成功');
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else {
                notify_error('归档失败: ' + resp.msg);
            }
        },
        error: function(res) {
            notify_error("请求数据错误" + res);
        }
    });
}