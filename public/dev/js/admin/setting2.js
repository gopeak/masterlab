var SettingV2 = (function () {

    var _module = '';

    var _options = {};

    /**
     *
     * @param module
     * @param options
     * @constructor
     */
    function SettingV2(module, options) {
        _module = module;
        _options = options;
        // 在页面加载设置数据
        SettingV2.prototype.fetchSetting(_options.fetch_url, _options.list_tpl_id, _options.list_render_id);

        // 当弹出层显示完毕后远程获取数据
        $('#modal-setting').on('shown.bs.modal', function () {
            SettingV2.prototype.fetchSetting(_options.fetch_url, _options.form_tpl, _options.form_render_id);
            keyMaster.addKeys([
                {
                    key: ['command+enter', 'ctrl+enter'],
                    'trigger-element': '.js-key-modal-enter2',
                    trigger: 'click'
                },
                {
                    key: 'esc',
                    'trigger-element': '.js-key-modal-close2',
                    trigger: 'click'
                }
            ]);
        });

        // 保存设置处理，提交服务器保存
        $(".btn-setting_save").click(function () {
            SettingV2.prototype.update();
        });

        if ("undefined" != typeof $('.colorpicker-component').colorpicker) {
            $('.colorpicker-component').colorpicker({ /*options...*/});
        }
    }

    SettingV2.prototype.getOptions = function () {
        return _options;
    };

    SettingV2.prototype.setOptions = function (options) {
        for (var _key in options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[_key] = options[_key];
            // }
        }
    };

    SettingV2.prototype.getModule = function () {
        return _module;
    };

    SettingV2.prototype.setModule = function (module) {
        _module = module
    };

    SettingV2.prototype.fetchSetting = function (url, tpl_id, parent_id) {
        var params = {module: _module, format: 'json'};
        loading.show('#' + parent_id, '数据加载中');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: params,
            success: function (resp) {
                loading.closeAll();
                auth_check(resp);
                if (resp.data.settings.length) {
                    var source = $('#' + tpl_id).html();
                    var template = Handlebars.compile(source);

                    Handlebars.registerHelper("equal", function (v1, v2, options) {
                        if (v1 == v2) {
                            return options.fn(this);
                        } else {
                            return options.inverse(this);
                        }
                    });

                    var result = template(resp.data);

                    $('#' + parent_id).html(result);
                } else {
                    var emptyHtml = defineStatusHtml({
                        wrap: '#' + parent_id,
                        message: '数据为空',
                        type: 'image'
                    });
                }
            },
            error: function (resp) {
                loading.closeAll();
                notify_error("请求数据错误" + resp);
            }
        });
    };

    SettingV2.prototype.update = function () {
        var method = 'post';
        var url = _options.update_url;
        var params = $('#form-setting').serialize();
        console.log(params);
        loading.show('#' + _options.form_render_id);
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params,
            success: function (resp) {
                loading.closeAll();
                auth_check(resp);
                //notify_success(resp.msg);
                setTimeout("window.location.reload();", 1000)
            },
            error: function (resp) {
                loading.closeAll();
                notify_error("请求数据错误" + resp);
            }
        });
    }

    return SettingV2;
})();


