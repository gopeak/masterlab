
var UserSetting = (function() {

    var _options = {};



    // constructor
    function UserSetting(  options  ) {
        _options = options;


    };

    UserSetting.prototype.getOptions = function() {
        return _options;
    };

    UserSetting.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    UserSetting.prototype.fetchUserById = function( user_id) {
        var user = getValueByKey(_issueConfig.users,user_id);
        //console.log(users);
        return user;
    }

    UserSetting.prototype.fetch = function( ) {

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
                for(var i=0;i<user.length;i++)
                {
                    if(user[i]._key==='scheme_style')
                    {
                        $('input:radio[name="user[scheme_style]"]').removeAttr('checked');
                        //console.log($('#sex_'+user.sex));
                        $('#scheme_'+user[i]._value).attr("checked","checked");
                        $('#scheme_'+user[i]._value).prop('checked', 'checked')
                    }
                    else
                    {
                        //$("#"+user[i]._key+"").attr("value",user[i]._value);
                        $("#"+user[i]._key+"").find("option[value='"+user[i]._value+"']").attr("selected",true);
                    }
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    UserSetting.prototype.update = function(  ) {

        var url = _options.update_url;
        var method = 'post';


        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $("#"+_options.form_id).serialize(),
            success: function (resp) {

                auth_check(resp);
                //alert(resp.msg);
                if( resp.ret=='200'){
                    window.location.reload();
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return UserSetting;
})();

