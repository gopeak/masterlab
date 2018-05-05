
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

    Profile.prototype.fetch = function( ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {} ,
            success: function (resp) {

                var user  = resp.data.user;
                $('#display_name').val(user.display_name);
                $('#user_email').val(user.email);
                $('#description').val(user.description);
                $('#avatar_display').attr('src',user.avatar);
                $('#avatar_display').removeClass('hidden');
                $('input:radio[name="params[sex]"]').removeAttr('checked');
                $('#user_sex'+user.sex).attr("checked","checked");

            },
            error: function (res) {
                alert("请求数据错误" + res);
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

        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    }

    Profile.prototype.update = function(  ) {

        var url = _options.update_url;
        var method = 'post';
        //var img = document.getElementById('avatar_display');
        //var image= Profile.prototype.getBase64Image(img);
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#edit_user').serialize(),
            success: function (resp) {

                //alert(resp.msg);
                if( resp.data.ret=='200'){
                    window.location.reload();
                }else {
                    alert(resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });



    }


    return Profile;
})();

