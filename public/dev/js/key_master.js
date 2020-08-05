$(function(){
    moment().format();
    // 通用快捷键 .addKeys 新增快捷键 .delKeys 解绑快捷键 参数: 数组
    // m: 打开导航菜单
    // h: 帮助
    // s: 焦点搜索框
    // r: 刷新
    // c: 创建
    // ctrl+enter: 提交
    keyMaster.addKeys([
        {
            key: 'm',
            'trigger-element': '.js-key-nav',
            trigger: 'click'
        },
        {
            key: 'h',
            'trigger-element': '.js-key-help',
            trigger: 'click'
        },
        {
            key: 's',
            'trigger-element': '.js-key-search',
            trigger: 'input'
        },
        {
            key: 'r',
            handle: function(){
                location.reload()
            }
        },
        {
            key: 'c',
            'trigger-element': '.js-key-create',
            trigger: 'click'
        },
        {
            key: ['command+enter', 'ctrl+enter'],
            'trigger-element': '.js-key-enter',
            trigger: 'click'
        },
        {
            key: 'b',
            'trigger-element': '.js-key-back',
            trigger: 'click'
        }
    ])

    // 监听所有modal，关闭后解绑提交快捷键
    $('*').on('hidden.bs.modal', function (e) {
        keyMaster.delKeys(['command+enter', 'ctrl+enter', 'esc'])
    })

});