$(function(){
    function csrfSafeMethod(method) {
        // 匹配method的请求模式
        return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
    }
    $.ajaxSetup({
        beforeSend:function (xhr, settings) {
            if(!csrfSafeMethod(settings.type)){
                xhr.setRequestHeader("ML-CSRFToken", '<?= $csrf_token ?>');
                //console.log(settings)
            }

        }
    });
    $.ajaxPrefilter( function(options, originalOptions, jqXHR){
        if(Object.prototype.toString.call(options.data) == "[object FormData]"){
            options.data.append("_csrftoken","<?= $csrf_token ?>");
        }else if(Object.prototype.toString.call(options.data) == "[object String]"){
            if(Object.prototype.toString.call(originalOptions.data) == "[object Object]"){
                options.data = $.param($.extend(originalOptions.data||{}, {
                    _csrftoken: "<?= $csrf_token ?>"
                }));
            }else if(Object.prototype.toString.call(originalOptions.data) == "[object String]"){
                options.data = options.data+"&_csrftoken="+"<?= $csrf_token ?>";
            }
        }
        //console.log(options.headers);
    });
})