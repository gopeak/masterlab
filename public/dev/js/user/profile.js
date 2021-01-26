

var cropBoxData;
var canvasData;
var cropper;

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

    function zipBase64(base64, callback) {
        var _img = new Image();
        _img.src = base64;
        _img.onload = function () {
            var _canvas = document.createElement("canvas");
            var w = this.width / 1.5;
            var h = this.height / 1.5;
            _canvas.setAttribute("width", w);
            _canvas.setAttribute("height", h);
            _canvas.getContext("2d").drawImage(this, 0, 0, w, h);
            var base64 = _canvas.toDataURL("image/jpeg");
            _canvas.toBlob(function (blob) {
                if (blob.size > 1024 * 1024) {
                    zipBase64(base64, 1.5);
                } else {
                    callback(base64)
                }
            }, "image/jpeg");
        }
    }
    var editAvatar = document.getElementById('avatar_display');
    if(editAvatar){
        editAvatar.src = $("#avatar_display").attr("src")
        createCropper(editAvatar);
    }

    // 点击浏览按钮
    $("#js-choose-user-avatar-button").on("click", function () {

        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        cropper.destroy();
        $(".js-user-avatar-file-create").val("");
        $(".js-user-avatar-file-create").trigger("click");
    });
    // 触发 input/image
    $(".js-user-avatar-file-create").on("change", function () {
        var file = $(this).get(0).files[0];
        if (!file) return
        $("#create-avatar-modal").modal()
        var reader = new FileReader();
        reader.readAsDataURL(file)
        reader.onloadend = function (evt) {
            $("#avatar_display").attr("src", evt.target.result);
            var editAvatar = document.getElementById('create-avatar-img');
            editAvatar.src = $("#avatar_display").attr("src")
            createCropper(editAvatar)
        };
    });
    // 点击裁剪层里的保存
    $(".js-avatar-create-save").on("click", function () {
        var base64 = cropper.getCroppedCanvas().toDataURL('image/jpg', 1)
        zipBase64(base64, function (newBase64) {
            $("#avatar_display").attr("src", newBase64);
            $("#create-avatar-img").attr("src",$("#avatar_display").attr("src"))
            $("#user_avatar").val(newBase64);
            //cropper.destroy();
        })
    });

});


var Profile = (function() {

    var _options = {};
    // constructor
    function Profile(  options  ) {
        _options = options;
    };

    Profile.prototype.getOptions = function() {
        return _options;
    };

    Profile.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Profile.prototype.fetchUserById = function( user_id) {
        var user = getArrayValue(_issueConfig.users, 'uid', user_id);
        //console.log(users);
        return user;
    };

    Profile.prototype.fetch = function( ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {} ,
            success: function (resp) {
                auth_check(resp);
                var user  = resp.data.user;
                console.log(user.avatar)
                $('#display_name').val(user.display_name);
                $('#user_birthday').val(user.birthday);
                $('#user_email').val(user.email);
                $('#description').val(user.sign);
                $('#avatar_display').attr('src',user.avatar);
                $('#avatar_display').removeClass('hidden');
                $('input:radio[name="params[sex]"]').removeAttr('checked');
                //console.log($('#sex_'+user.sex));
                $('#sex_'+user.sex).attr("checked","checked");
                $('#sex_'+user.sex).prop('checked', 'checked')
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Profile.prototype.getBase64Image = function (img) {

        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        var dataURL = canvas.toDataURL("image/png");

        return dataURL;
    }

    Profile.prototype.update = function(  ) {

        var url = _options.update_url;
        var method = 'post';
        /*
        var img = document.getElementById('avatar_display');
        var image = Profile.prototype.getBase64Image(img);
        $('#image').val(image);
        */
        // jugg fix 图片裁剪大小与预期显示不一致的问题
        var avatar_display_src = $('#avatar_display').attr('src');
        $('#image').val(avatar_display_src);

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $("#edit_user").serialize(),
            success: function (resp) {
                auth_check(resp);
                //alert(resp.msg);
                if( _.toInteger(resp.ret)===200){
                    notify_success('保存成功');
                    window.location.reload();
                }else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Profile.prototype.updatePassword = function(  ) {

        var url = _options.update_password_url;
        var method = 'post';

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $("#edit_password").serialize(),
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    //window.location.reload();
                    notify_success(resp.msg);
                }else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Profile;
})();

