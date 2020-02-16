

function fetchUsers(url, tpl_id, parent_id) {

    var params = { format: 'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: $('#user_filter_form').serialize(),
        success: function (resp) {
            auth_check(resp);
            //console.log(resp.data.users);

            if("undefined" != typeof resp.data.groups){
                if(resp.data.cur_group_id <= 0){
                    $('#select_group_view').html("所属用户组");
                } else {
                    $('#select_group_view').html(resp.data.groups[resp.data.cur_group_id - 1].name);
                }
            }

            if (resp.data.users.length) {
                var source = $('#' + tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);

                var select_group_tpl = $('#select_group_tpl').html();
                template = Handlebars.compile(select_group_tpl);
                result = template(resp.data);
                $('#select_group').html(result);

                $(".user_for_edit").click(function () {
                    userEdit($(this).attr("data-uid"));
                });

                /*$(".user_for_delete").click(function(){
                    userDelete( $(this).attr("data-uid") );
                });*/

                $(".user_for_active").click(function () {
                    userActive($(this).attr("data-uid"));
                });

                $(".user_for_group").click(function () {
                    userGroup($(this).attr("data-uid"));
                });

                $(".select_group_li").click(function () {
                    $('#filter_group').val($(this).attr('data-group'));
                    $('#select_group_view').html($(this).attr('data-title'));
                });
                $(".order_by_li").click(function () {
                    $('#filter_order_by').val($(this).attr('data-order-by'));
                    $('#filter_sort').val($(this).attr('data-sort'));
                    $('#order_view').html($(this).attr('data-title'));
                });

                var options = {
                    currentPage: resp.data.page,
                    totalPages: resp.data.pages,
                    onPageClicked: function (e, originalEvent, type, page) {
                        console.log("Page item clicked, type: " + type + " page: " + page);
                        $("#filter_page").val(page);
                        fetchUsers(root_url + 'admin/user/filter', 'user_tpl', 'render_id');
                    }
                }
                $('#ampagination-bootstrap').bootstrapPaginator(options);
            } else {
                var emptyHtml = defineStatusHtml({
                    message: '暂无用户信息',
                    type: 'id',
                    handleHtml: ''
                })
                $('#render_id').html($('<tr><td colspan="7" id="render_id_wrap"></td></tr>'))
                $('#render_id_wrap').append(emptyHtml.html)
            }


        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });

    return false;
}


function userFormReset() {

    $("#filter_page").val("1");
    $("#filter_status").val("");
    $("#filter_group").val("0");
    $("#filter_status").val("");
    $("#filter_sort").val("desc");
    $("#filter_username").val("");
    $('#order_view').html($('#order_view').attr("data-title-origin"));
    $("#select_group_view").html($('#select_group_view').attr("data-title-origin"));
}

var cropBoxData;
var canvasData;
var cropper;

function userEdit(uid) {

    var method = 'get';
    var url = '/admin/user/get/?uid=' + uid;
    $('#edit_id').val(uid);
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {},
        success: function (resp) {
            auth_check(resp);
            $("#modal-user_edit").modal();
            $("#edit_avatar").val(resp.data.avatar);
            $(".js-user-avatar-edit").attr("src", resp.data.avatar)
            $("#edit_uid").val(resp.data.uid);
            $("#edit_email").val(resp.data.email);
            $("#edit_display_name").val(resp.data.display_name);
            $("#edit_username").val(resp.data.username);
            $("#edit_title").val(resp.data.title);
            if (resp.data.is_cur == "1") {
                $("#edit_disable").attr("disabled", "disabled");
                $('#edit_disable_wrap').addClass('hidden')
            } else {
                $("#edit_disable").removeAttr("disabled");
                $('#edit_disable_wrap').removeClass('hidden')
            }
            if (resp.data.status == '2') {
                $('#edit_disable').attr("checked", true);
            } else {
                $('#edit_disable').attr("checked", false);
            }

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function createCropper(img) {
    cropper = new Cropper(img, {
        autoCropArea: 0.5,
        minCropBoxWidth: 150,
        minCropBoxHeight: 150,
        minContainerWidth: 500,
        minContainerHeight: 500,
        minCanvasWidth: 100,
        minCanvasHeight: 100,
        movable: true,
        dragCrop: true,
        ready: function () {
            cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });
}

$(function () {

    // 新增
    $(".js-choose-user-avatar-button-create").on("click", function () {
        $(".js-user-avatar-file-create").trigger("click")
    })

    $(".js-user-avatar-file-create").on("change", function () {
        var file = $(this).get(0).files[0];
        if (!file) return
        $("#create-avatar-modal").modal()
        var reader = new FileReader();
        reader.readAsDataURL(file)
        reader.onloadend = function (evt) {
            $(".js-user-avatar-create").attr("src", evt.target.result)
            var editAvatar = document.getElementById('create-avatar-img');
            editAvatar.src = $(".js-user-avatar-create").attr("src")
            createCropper(editAvatar)
        };
    })

    $("#create-avatar-modal").on('hidden.bs.modal', function () {
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        cropper.destroy();
        $(".js-user-avatar-file-create").val("")
    });

    $(".js-avatar-create-save").on("click", function () {
        var base64 = cropper.getCroppedCanvas().toDataURL('image/jpg', 1)
        $("#js-user-avatar-create").attr("src", base64)
        $("#id_avatar").val(base64)
    })

    $("#modal-user_add").on('hidden.bs.modal', function () {
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        cropper.destroy();
        $(".js-user-avatar-file-create").val("")
        $("#id_avatar").val("")
        $("#js-user-avatar-create").attr("src", "")
    })

    // 编辑
    $("#edit-avatar-modal").on('show.bs.modal', function () {
        var editAvatar = document.getElementById('edit-avatar-img');
        editAvatar.src = $(".js-user-avatar-edit").attr("src")
        createCropper(editAvatar)
    });

    $("#edit-avatar-modal").on('hidden.bs.modal', function () {
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        cropper.destroy();
        $(".js-avatar-file-edit").val("")
        $("#edit_avatar").val("")
    });

    $(".select-avatar").on("click", function () {
        $(".js-avatar-file-edit").trigger("click")
    })

    $(".js-avatar-file-edit").on("change", function (e) {
        var file = $(this).get(0).files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function (evt) {
            cropper.replace(evt.target.result, false)
            cropper.getCroppedCanvas()
        };
    })

    $(".js-edit-avatar-save").on("click", function () {
        var base64 = cropper.getCroppedCanvas().toDataURL('image/jpg', 1)
        $("#js-user-avatar-edit").attr("src", base64)
        $("#edit_avatar").val(base64)
    })


})

function userGroup(uid) {

    var method = 'get';
    var url = '/admin/user/user_group/?uid=' + uid;
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: {},
        success: function (resp) {

            auth_check(resp);
            $("#modal-user_group").modal();
            $("#group_for_uid").val(uid);

            var obj3 = document.getElementById('for_group');
            obj3.options.length = 0;
            for (var i = 0; i < resp.data.groups.length; i++) {
                obj3.options.add(new Option(resp.data.groups[i].name, resp.data.groups[i].id));
            }
            $('.selectpicker').selectpicker('refresh');
            $('#for_group').selectpicker('refresh');
            $('#for_group').selectpicker('val', resp.data.user_groups);
            $('.selectpicker').selectpicker();

        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}



function userAdd() {

    var method = 'post';
    var url = '/admin/user/add';
    var params = $('#form-user_add').serialize();
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
                notify_success(resp.msg, resp.data);
                //setTimeout("window.location.reload();", 2000)
                //$('#modal-user_add').modal('hide');
            } else {
                notify_error('添加失败,' + resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userUpdate() {

    var method = 'post';
    var url = '/admin/user/update';
    var params = $('#form-user_edit').serialize();
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
                notify_success(resp.msg, resp.data);
                setTimeout("window.location.reload();", 2000)
            } else {
                notify_error('更新失败,' + resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userJoinGroup() {

    var method = 'post';
    var url = '/admin/user/updateUserGroup';
    var params = $('#form-update_user_group').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params,
        success: function (resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                notify_success(resp.msg, resp.data);
                setTimeout("window.location.reload();", 2000)
            } else {
                notify_success(resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userDelete(id) {

    if (!window.confirm('您确认删除该项吗?')) {
        return false;
    }

    var method = 'GET';
    var url = '/admin/user/delete/?uid=' + id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
        success: function (resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                notify_success(resp.msg, resp.data);
                setTimeout("window.location.reload();", 2000)
            } else {
                notify_error(resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function userActive(id) {


    var method = 'GET';
    var url = '/admin/user/active/?uid=' + id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
        success: function (resp) {
            auth_check(resp);
            if (resp.ret === '200') {
                notify_success(resp.msg, resp.data);
                setTimeout("window.location.reload();", 2000)
            } else {
                notify_error(resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

