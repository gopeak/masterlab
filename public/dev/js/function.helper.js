Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};

Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

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
 * @todo
 * 从二维数组中查找某个记录
 * @param arr
 * @param $key
 * @param value
 * @returns {null|*}
 */
function getArrayValue(arr, $key, value ) {
    for (var i = 0; i < arr.length; i++) {
        if (value == arr[i][$key]) {
            return arr[i];
        }
    }
    return null;
}

function in_array(value, arr ) {
    for (var i = 0; i < arr.length; i++) {
        if (value === arr[i]) {
            return true;
        }
    }
    return false;
}

function getObjectValue(objs, id) {
    var obj = null;
    for (var i in objs) {
        if (parseInt(objs[i].id) == parseInt(id)) {
            return objs[i];
        }
    }
    return obj;
}

function getUser(users, uid) {
    var obj = null;
    for (let user of users) {
        if (parseInt(user.uid) === parseInt(uid)) {
            return user;
        }
    }
    return obj;
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

    if (typeof(a)==='undefined') { // 只能用 === 运算来测试某个值是否是未定义的
        return true;
    }
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

    if(is_empty(arr)){
        return false;
    }

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

function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

/**
 * 1. Y-m-d
 * 2. Y-m-d H:i:s
 * 3. Y年m月d日
 * 4. Y年m月d日 H时i分
 * @param timestamp
 * @param formats
 * @returns {string}
 */
function timestampToDate(timestamp, formats) {
    formats = formats || 'Y-m-d';

    var zero = function (value) {
        if (value < 10) {
            return '0' + value;
        }
        return value;
    };
    var myDate = timestamp? new Date(timestamp): new Date();

    var year = myDate.getFullYear();
    var month = zero(myDate.getMonth() + 1);
    var day = zero(myDate.getDate());

    var hour = zero(myDate.getHours());
    var minite = zero(myDate.getMinutes());
    var second = zero(myDate.getSeconds());

    return formats.replace(/Y|m|d|H|i|s/ig, function (matches) {
        return ({
            Y: year,
            m: month,
            d: day,
            H: hour,
            i: minite,
            s: second
        })[matches];
    });
};

/**
 * 去除空格
 * @param str
 * @returns {*}
 */
function trimStr(str){
    //console.log('str:',str)
    return  str.replace(/\s+/g,"");
}

/**
 * 判断是否定义变量
 * @param val
 * @returns {boolean}
 */
function isUndefined(val){
    if (typeof(val)==='undefined') { // 只能用 === 运算来测试某个值是否是未定义的
        return true;
    }
    return false;
}

function timestampToDate (timestamp) {
    const dateObj = new Date(+timestamp) // ps, 必须是数字类型，不能是字符串, +运算符把字符串转化为数字，更兼容
    const year = dateObj.getFullYear() // 获取年，
    const month = dateObj.getMonth() + 1 // 获取月，必须要加1，因为月份是从0开始计算的
    const date = dateObj.getDate() // 获取日，记得区分getDay()方法是获取星期几的。
    return year + '-' + month + '-' + date ;
}

function pad(str) {
    return +str >= 10 ? str : '0' + str
}