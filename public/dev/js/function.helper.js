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
        if (value == arr[i]) {
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
        if (value == arr[i]) {
            return true;
        }
    }
    return false;
}

function auth_check(resp) {
    if (resp.ret == '401') {
        notify_warn(resp.msg, resp.data);
        setTimeout("window.location.href = window.root_url + 'passport/login';", 3000);
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

function issue_type_short_html(issue_type_id) {
    let html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(_issueConfig.issue_types, 'id',issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '" title="' + issue_type.name + '"></i>\n' + '';
    return html;
}

function priority_html(priority_id) {
    var html = '';
    if (is_empty(priority_id)) {
        return '';
    }
    var priority_row = getArrayValue(_issueConfig.priority, 'id', priority_id);
    if (priority_row == null) {
        return '';
    }
    html += '<span style="color:' + priority_row.status_color + '">' + priority_row.name + '</span>';
    return html;
}

function make_project(project_id) {
    var html = '';
    if (project_id == null || project_id == undefined || project_id == '') {
        return html;
    }
    console.log(project_id);
    if (_issueConfig.projects == null || _issueConfig.projects == undefined) {
        return html;
    }
    var projects = _issueConfig.projects;
    var project_name = '';
    var org_path = 'default';
    var project_key = '';
    for (var skey = 0; skey < projects.length; skey++) {
        if (projects[skey].id == project_id) {
            project_name = projects[skey].name;
            org_path = projects[skey].org_path;
            project_key = projects[skey].key;
            break;
        }
    }
    var project_url = root_url + org_path + "/" + project_key;
    html += "<div class=\"branch-commit\"> <a class=\"commit-id monospace\" href='" + project_url + "' >" + project_name + "</a></div>";
    return html;
}
function make_projects(project_ids, projects) {
    var html = '';
    if (project_ids == null || project_ids == undefined || project_ids == '') {
        return html;
    }
    var project_ids_arr = project_ids.split(',');
    project_ids_arr.forEach(function (project_id) {
        console.log(project_id);
        var project_name = '';
        for (var skey in projects) {
            if (projects[skey].id == project_id) {
                project_name = projects[skey].name;
                break;
            }
        }
        html += "<div class=\"branch-commit\"> <a class=\"commit-id monospace\" href=\"#\">" + project_name + "</a></div>";
    });
    return html;
}

function module_html(module_id) {
    var html = '';
    if (is_empty(module_id)) {
        return '';
    }
    var module = getArrayValue(_issueConfig.issue_module, 'id', module_id);
    if (module == null) {
        html += '<a href="javascript:;" class="commit-id monospace"></a>';
    } else {
        html += '<a href="?state=opened&模块=' + module.name + '" class="commit-id monospace">' + module.name + '</a>';
    }
    return html;
}

function make_issue_sprint(sprint_id) {
    var html = '';
    if (is_empty(sprint_id)) {
        return '';
    }
    //console.log(_issueConfig.sprint);
    var sprint = getArrayValue(_issueConfig.sprint, 'id', sprint_id);
    //console.log(sprint);
    if (sprint == null) {
        html += '<a href="javascript:;" class="commit-id monospace"></a>';
    } else {
        html += '<a href="?state=opened&迭代=' + sprint.name + '" class="commit-id monospace">' + sprint.name + '</a>';
    }
    return html;
}

function user_html(uid) {
    var html = '';
    if (uid == null || uid == undefined || uid == '') {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    if (user == null) {
        return '';
    }
    html += '<span class="list-item-name"><a   title="'+user.display_name+'"  href="/user/profile/' + user.uid + '">' +
        '<img width="26px" height="26px" class=" float-none" style="border-radius: 50%;"   data-toggle="tooltip" data-placement="bottom"  title="' + user.username + ' ' + user.display_name + '" src="' + user.avatar + '" />' +
        '</a></span>';
    return html;
}

function user_html_display_name(uid) {
    var html = '';
    if (uid == null || typeof(uid) == "undefined" || uid == '') {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    if (user == null) {
        return '';
    }
    if (user == null || typeof(user) == "undefined" || !user ) {
        return '';
    }
    html += '<span class="list-item-name"><a   title="'+user.display_name+'"  href="/user/profile/' + user.uid + '">' +
        user.display_name +
        '</a></span>';
    return html;
}

function issue_assistants_avatar(uid_arr) {
    //console.log(users);
    var html = '';
    for (i = 0; i < uid_arr.length; i++) {
        let uid = _.toString(uid_arr[i]);
        let user = getArrayValue(_issueConfig.users, 'uid', uid);
        if (!_.has(user, 'uid')) {
            return '';
        }
        html += '<span class="list-item-name"><a title="'+user.display_name+'" href="/user/profile/' + user.uid + '"><img width="26px" height="26px" class="has-tooltip float-none" style="border-radius: 50%;" data-placement="left" data-original-title="' + user.username + ' @' + user.display_name + '" src="' + user.avatar + '" /></a></span>';
    }
    return html;
}
function issue_assistants_display_name(uid_arr) {
    //console.log(users);
    var html = '';
    for (i = 0; i < uid_arr.length; i++) {
        let uid = _.toString(uid_arr[i]);
        let user = getArrayValue(_issueConfig.users, 'uid', uid);
        if (!_.has(user, 'uid')) {
            return '';
        }
        html += '<span class="list-item-name" style="margin-right: 4px"><a title="'+user.display_name+'" href="/user/profile/' + user.uid + '">' + user.display_name + '</a></span>';
    }
    return html;
}

function status_html(status_id) {
    var html = '';
    if (is_empty(status_id)) {
        return '';
    }
    var status_row = getArrayValue(_issueConfig.issue_status, 'id', status_id);
    if (status_row == null) {
        return '';
    }
    html += '<span class="label current label-' + status_row.color + ' prepend-left-5" style="cursor:pointer;">' + status_row.name + '</span>';
    return html;
}

function resolve_html(resolve_id) {
    var html = '';
    if (is_empty(resolve_id)) {
        return '';
    }
    var resolve = getArrayValue(_issueConfig.issue_resolve, 'id',resolve_id);
    if (resolve == null) {
        html = '<span>一</span>';
        return new Handlebars.SafeString(html);
    }
    html += '<span style="color:' + resolve.color + '">' + resolve.name + '</span>';
    return html;
}

function version_html(version_id) {
    var html = '';
    if (is_empty(version_id)) {
        return '';
    }
    var version_row = getArrayValue(_issueConfig.version, 'id', version_id);
    if (version_row == null) {
        return '';
    }
    html += '<span >' + version_row.name + '</span>';
    return html;
}

function make_label_html(label_id_arr) {
    var html = '';
    if(label_id_arr){
        for (i = 0; i < label_id_arr.length; i++) {
            //var id = parseInt(label_id_arr[i]);
            var id = label_id_arr[i];
            var row = getArrayValue(_issueConfig.issue_labels, 'id',id);
            if (row == null) {
                return '';
            }
            html += '<a href="'+cur_path_key +'?sys_filter=label_'+id+'">';
            html += '<span class="label color-label " style="background-color:'+row.bg_color+'; color: '+row.color+'" title="'+row.title+'" data-container="body">'+row.title+'</span>';
            html += '</a>';
        }
    }
    return html;
}
function assistants_html(uid_arr) {
    var html = '';
    for (i = 0; i < uid_arr.length; i++) {
        let uid = parseInt(uid_arr[i]);
        let user = getArrayValue(_issueConfig.users, 'uid', uid);
        console.log(user);
        if (user == null) {
            return '';
        }
        html += '<div class="participants-author js-participants-author">';
        html += '    <a class="author_link has-tooltip"  title="'+user.display_name+'" data-container="body" href="/' + user.username + '" data-original-title="' + user.display_name + '" ><img width="24" class="avatar avatar-inline s24 " alt="" src="' + user.avatar + '"></a>';
        html += '    </div>';
    }
    return html;
}

function make_assistants(uid_arr) {
    var html = '';
    for (i = 0; i < uid_arr.length; i++) {
        let uid = _.toString(uid_arr[i]);
        let user = getArrayValue(_issueConfig.users, 'uid', uid);
        //console.log(user);
        if (user == null) {
            return '';
        }
        html += '<div class="participants-author js-participants-author">';
        html += '    <a class="author_link has-tooltip"  title="'+user.display_name+'" data-container="body" href="' + root_url + 'user/profile/' + uid + '" data-original-title="' + user.display_name + '" ><img width="24" class="avatar avatar-inline s24 " alt="" src="' + user.avatar + '"></a>';
        html += '    </div>';
    }
    return html;
}

function user_account_str(uid) {
    var html = '';
    if (uid == null || uid == undefined || uid == '') {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    //console.log(users);
    if (user == null) {
        return '';
    }
    html += '<span class="list-item-name"><a   title="'+user.display_name+'"  href="/user/profile/' + user.uid + '">' + user.username + ' ' + user.display_name + '</a></span>';
    return html;
}

function org_user_html(uid) {
    var html = '';
    if (uid == null || uid == undefined || uid == '') {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    //console.log(users);
    if (user == null) {
        return '';
    }
    html += ' <a href="/user/profile/' + user.uid + '">' +
        '<img width="26px" height="26px" class=" float-none" style="border-radius: 50%;"  ' +
        ' data-toggle="tooltip" data-placement="top"  title="负责人:' + user.username + ' @' + user.display_name + '" src="' + user.avatar + '" />' +
        ' ' + user.display_name +
        '</a>';
    return html;
}

function user_text_display_name(uid) {
    var html = '';
    if (uid == null || typeof(uid) == "undefined" || uid == '') {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    if (user == null) {
        return '';
    }
    if (user == null || typeof(user) == "undefined" || !user ) {
        return '';
    }
    html += '<span class="list-item-name">' +
        user.display_name +
        '</span>';
    return html;
}

function make_user(uid, users) {
    var html = '';
    if (uid == null || uid == undefined || uid == '') {
        return '';
    }
    var user = getValueByKey(users, uid);
    //console.log(users);
    if (user == null) {
        return '';
    }
    html += '<span class="list-item-name"><a   title="'+user.display_name+'"  href="/' + user.username + '"><image width="26px" height="26px" class="header-user-avatar has-tooltip float-none" data-placement="left" data-original-title="' + user.username + ' @' + user.display_name + '" src="' + user.avatar + '" /></a></span>';
    return html;
}


function make_types(type_ids, issue_types) {
    var html = '';
    if (type_ids == null || type_ids == undefined || type_ids == '') {
        return html;
    }
    var scheme_ids_arr = type_ids.split(',');
    scheme_ids_arr.forEach(function (type_id) {
        console.log(type_id);
        var type_name = '';
        var type_font_icon = '';
        for (var skey in issue_types) {
            if (issue_types[skey].id == type_id) {
                type_name = issue_types[skey].name;
                type_font_icon = issue_types[skey].font_awesome;
                break;
            }
        }
        html += "<div class=\"branch-commit\"><i class='fa " + type_font_icon + "'></i> <a class=\"commit-id monospace\" href=\"#\">" + type_name + "</a></div>";
    });
    return html;
}

function lightSearch(summary, search) {
    var html = '';
    if (search == '') {
        return summary;
    }
    var fen = summary.split(search);
    html = fen.join('<span style="background:#cfc;">' + search + '</span> ');
    return html;
}

function make_issue_type(issue_type_id, issue_types) {
    var html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(issue_types, 'id',issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '"></i>\n' +
        '            <a href="#"  class="commit-id monospace">' + issue_type.name + '</a>';
    return html;
}

function issue_type_html(issue_type_id) {
    var html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(_issueConfig.issue_types, 'id', issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '"></i>\n' +
        '            <a href="#"  class="commit-id monospace">' + issue_type.name + '</a>';
    return html;
}

function issue_type_short_html(issue_type_id) {
    var html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(_issueConfig.issue_types, 'id',issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '" title="' + issue_type.name + '"></i>\n' +  '';
    return html;
}
function issue_type_icon(issue_type_id) {
    var html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(_issueConfig.issue_types, 'id', issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '"></i>';
    return html;
}
function make_backlog_issue_type(issue_type_id) {
    var html = '';
    if (is_empty(issue_type_id)) {
        return '';
    }
    var issue_type = getArrayValue(_issueConfig.issue_types, 'id',issue_type_id);
    if (issue_type == null) {
        return '';
    }
    html += '<i class="fa ' + issue_type.font_awesome + '"></i>\n'
    return html;
}
function user_name_html(uid) {
    var html = '';
    if (is_empty(uid)) {
        return '';
    }
    var user = getArrayValue(_issueConfig.users, 'uid', uid);
    //console.log(users);
    if (user == null) {
        return '';
    }
    html += '<span class="list-item-name">by ' + user.display_name + '</span>';
    return html;
}

function updated_text_html(updated_text) {
    var html = '';
    if (is_empty(updated_text)) {
        return '';
    }
    html += '<span   style="color:#707070">更新于 ' + updated_text + '</span>';
    return html;
}
function created_text_html(created, created_text, created_full) {
    var html = '';
    if (is_empty(created_text)) {
        return '';
    }
    html += '·创建于<span  datetime="' + created + '" data-toggle="tooltip" data-placement="top" title="' + created_full + '">' + created_text + '</span>';

    return html;
}

