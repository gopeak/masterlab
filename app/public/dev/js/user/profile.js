
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
        var user = getValueByKey(_issueConfig.users,user_id);
        //console.log(users);
        return user;
    }

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
    }

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
                if( resp.ret=='200'){
                    notify_success('保存成功');
                    //window.location.reload();
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

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
    }



    return Profile;
})();

