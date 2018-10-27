function getValueByKey($map, $key) {

    var value = null;
    for (var skey in $map) {
        if (skey == $key) {
            value = $map[skey];
            break;
        }
    }
    return value;
}

/**
 * @author kenhins
 * @param param
 * @param key
 * @returns {string}
 */
function parseParam(param, key) {
    var paramStr = "";
    if (param instanceof String || param instanceof Number || param instanceof Boolean) {
        paramStr += "&" + key + "=" + encodeURIComponent(param);
    } else {
        $.each(param, function (i) {
            if(!is_empty(i) ){
                var k = key == null ? i : key + (param instanceof Array ? "[" + i + "]" : "." + i);
                paramStr += '&' + parseParam(this, k);
            }
        });
    }
    return paramStr.substr(1);
}

function objIsEmpty(obj) {
    for (var key in obj) {
        return false;
    }
    return true;
}

function is_empty(a) {
    if (a === undefined) { // 只能用 === 运算来测试某个值是否是未定义的
        return true;
    }
    if (a == null) { // 等同于 a === undefined || a === null
        return true;
    }
    // String
    if (a == "" || a == null || a == undefined) { // "",null,undefined
        return true;
    }
    if (!a) { // "",null,undefined,NaN
        return true;
    }
    if (!$.trim(a)) { // "",null,undefined
        return true;
    }
    // Array
    if (a.length == 0) { // "",[]
        return true;
    }
    if (!a.length) { // "",[]
        return true;
    }
    // Object {}
    if (objIsEmpty(a)) {
        return true;
    }
    return false;
}



function notify_success(title, message, setting)
{
    if (is_empty(message)) {
        message = '';
    }

    var options = {
        // options
        icon: 'fa fa-check',
        title: title,
        message: message,
        url: window.root_url,
        target: '_blank'
    }
    if (is_empty(setting)) {
        $.notify(options,{type: 'success'});
    } else {
        setting.type = 'success';
        $.notify(options, setting);
    }
}

function notify_info(title, message, setting)
{
    if (is_empty(message)) {
        message = '';
    }
    var options = {
        // options
        icon: 'fa fa-info-circle',
        title: title,
        message: message,
        url: window.root_url,
        target: '_blank'
    }
    if (is_empty(setting)) {
        $.notify(options);
    } else {
        $.notify(options, setting);
    }
}

function notify_error(title, message, setting)
{
    if (is_empty(message)) {
        message = '';
    }
    var options = {
        // options
        icon: 'fa  fa-exclamation-triangle',
        title: title,
        message: message,
        url: window.root_url,
        target: '_blank'
    }
    if (is_empty(setting)) {
        $.notify(options,{type: 'warning'});
    } else {
        setting.type = 'warning';
        $.notify(options, setting);
    }
}