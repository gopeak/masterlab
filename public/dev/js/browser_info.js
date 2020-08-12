window.onload = function () {
    var alertHtml = '<div class="alert alert-define alert-warning center" role="alert"><strong>提示！</strong>建议使用Chrome或Firefox内核浏览器</div>'
    var brName = getExploreName();
    console.log('浏览器信息：'+ brName)
    if (brName === 'IE' || brName === 'Edge' || brName === 'IE>=11' || brName === 'Unkonwn'|| brName === 'Safari') {
        $('body').prepend(alertHtml)
    }
}


