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

function getArrayValue(arr, $key, value ) {
    for (var i = 0; i < arr.length; i++) {
        if (value === arr[i][$key]) {
            return arr[i];
        }
    }
    return null;
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
            if (!is_empty(i)) {
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

function randomString(len) {
    len = len || 32;
    var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
    var maxPos = $chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}

function get_msg_text( message ) {
    var msg = '';
    var typeMsg = typeof(message);
    if (typeMsg == 'number' || typeMsg == 'string' || typeMsg == 'boolean') {
        msg = message;
    }
    if (typeMsg == 'undefined') {
        msg = '';
    }
    if (typeMsg == 'object') {
        for (var kk in message) {
            msg = msg + "<br>\n" + message[kk]
        }
    }
    return msg;

}


function notify_info(title, message, setting) {

    $.notify({
        icon: 'fa fa-info-info',
        title: title,
        message: get_msg_text(message)
    }, {
        type: 'pastel-info',
        delay: 3000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'+
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '</div>'
    });
}

function notify_success(title, message, setting) {
    $.notify({
        icon: 'fa fa-info-info',
        title: title,
        message: get_msg_text(message)
    }, {
        type: 'pastel-success',
        delay: 3000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'+
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '</div>'
    });
}


function notify_warn(title, message, setting) {

    $.notify({
        icon: 'fa fa-info-circle',
        title: title,
        message: get_msg_text(message)
    }, {
        type: 'pastel-warning',
        delay: 5000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'+
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '</div>'
    });
}

function notify_error(title, message, setting) {
    $.notify({
        icon: 'fa  fa-exclamation-triangle',
        title: title,
        message:  get_msg_text(message)
    },{
        type: 'pastel-danger',
        delay: 5000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'+
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '</div>'
    });
}

/**
 * 使用循环的方式判断一个元素是否存在于一个数组中
 * @param {Object} arr 数组
 * @param {Object} value 元素值
 */
function isInArray(arr, value) {
    for (var i = 0; i < arr.length; i++) {
        if (value === arr[i]) {
            return true;
        }
    }
    return false;
}

function auth_check(resp) {
    if (resp.ret == '401') {
        notify_warn(resp.msg, resp.data);
        setTimeout("window.location.href = window.root_url + 'passport/login';", 3000)
    }
}


function form_check(resp) {
    // 表单验证错误，将错误呈现到tip上
    if (resp.ret == '104') {
        $('.gl-field-error').addClass('hide');
        for (var kk in resp.data) {
            var seelctor = $('#tip-' + kk);
            seelctor.html(resp.data[kk]);
            seelctor.removeClass('hide');
        }
        notify_warn(resp.msg, resp.data);
        return false;
    }
    return true;
}
