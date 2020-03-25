let Upgrade = (function () {

    let _current_version = null;

    let $versionDescription = null;
    let $btnUpgrade = null;
    let $spanNewVersion = null;
    let $btnCancelUpgrade = null;
    let $btnCheckAgain = null;
    let $checkMessage = null;
    let $btnModalClose = null;

    let $upgradeMessageBox = null;
    let $modalUpgrade = null;
    let $modalAbout = null;

    // constructor
    function Upgrade(current_version) {
        _current_version = current_version;
        $versionDescription = $('#version-description');
        $btnUpgrade = $('#btn-do-upgrade');
        $spanNewVersion = $('#new-version');
        $btnCancelUpgrade = $('#btn-cancel-upgrade');
        $btnCheckAgain = $('#btn-check-again');
        $checkMessage = $('#check-message');
        $btnModalClose = $('#btn-modal-close');

        $upgradeMessageBox = $('#upgrade-message');
        $modalUpgrade = $('#modal-upgrade');
        $modalAbout = $('#modal-about');

        // 弹出层事件
        $modalUpgrade.on('shown.bs.modal', function () {
            $('.modal-backdrop').hide();
            Upgrade.prototype.checkUpgrade();
        });
        $modalUpgrade.on('hide.bs.modal', function () {
            $upgradeMessageBox.empty();
        });

        // 点击立即升级链接或升级菜单
        $(document).on('click', '#btn-upgrade, #menu-upgrade, #btn-do-daily-update', function () {
            $modalAbout.modal('hide');
            $modalUpgrade.modal({backdrop: 'static', keyboard: false});
        });

        // 开始升级
        $(document).on('click', '#btn-do-upgrade', function () {
            $btnUpgrade.addClass('disabled');
            $btnCancelUpgrade.addClass('disabled');
            $btnCheckAgain.addClass('hidden');
            $btnModalClose.addClass('disabled');
            Upgrade.prototype.run();
        });

        // 重新检测升级
        $(document).on('click', '#btn-check-again', function () {
            Upgrade.prototype.checkUpgrade();
        });

        // 点击升级对话框右上角的关闭按钮
        $(document).on('click', '#btn-modal-close', function () {
            if ($btnModalClose.hasClass('disabled')) {
                return false;
            }
            $modalUpgrade.modal('hide');
        });

        // 自动检查更新
        Upgrade.prototype.dailyCheck();

        // 关闭升级提示条幅
        $('#upgrade-msg').on('closed.bs.alert', function () {
            upgradeMsgViewed();
        });
    }

    Upgrade.prototype.getOptions = function () {
        return _options;
    };

    Upgrade.prototype.run = function (sprint_id) {

        if (window.confirm('确认要执行升级？请务必手动执行备份数据库和代码')) {
            Upgrade.prototype.postServer();
        } else {
            $btnUpgrade.removeClass('disabled');
            $btnCancelUpgrade.removeClass('disabled');
            $btnCheckAgain.removeClass('hidden');
            $btnModalClose.removeClass('disabled');
        }
    };

    Upgrade.prototype.postServer = function (sprint_id) {
        let url = '/upgrade/run';
        let source = $('#upgrade-source').val();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            data: {source: source},
            cache: false,
            xhr: function () {
                let xhr;
                if (window.XMLHttpRequest) {
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }

                if (!xhr) {
                    $versionDescription.addClass('hidden');
                    $btnUpgrade.addClass('disabled');
                    $spanNewVersion.text('检测失败');
                    $btnCancelUpgrade.removeClass('disabled');
                    $btnCheckAgain.removeClass('hidden');
                    $checkMessage.addClass('hidden');
                    $btnModalClose.removeClass('disabled');

                    html = '<p style="color: #ff0000; font-weight: bold;">浏览器不支持！请使用谷歌核心的浏览器再试一次</p>';
                    $upgradeMessageBox.html(html);
                    return false;
                }

                xhr.onreadystatechange = function () {
                    let html = '';
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        $btnCancelUpgrade.removeClass('disabled');
                        $btnModalClose.removeClass('disabled');
                        upgradeMsgViewed();
                        $('#upgrade-msg').alert('close');
                        //html = '<p style="color: #ff0000; font-weight: bold;">升级完成！</p>';
                        //$upgradeMessageBox.append($(html));
                    } else if (xhr.readyState === 3) {
                        html = xhr.responseText;
                        $upgradeMessageBox.html(html);
                    }

                    let scrollHeight = $upgradeMessageBox.prop('scrollHeight');
                    $upgradeMessageBox.scrollTop(scrollHeight, 200);
                };

                return xhr;
            }
        });
    };

    // 检测升级
    Upgrade.prototype.checkUpgrade = function () {
        $versionDescription.addClass('hidden');
        $btnUpgrade.addClass('disabled');
        $spanNewVersion.text('正在检测...');
        $btnCancelUpgrade.addClass('disabled');
        $btnCheckAgain.addClass('hidden');
        $checkMessage.addClass('hidden');
        $btnModalClose.addClass('disabled');

        loading.show('#modal-upgrade-body');

        let url = 'http://www.masterlab.vip/upgrade.php?action=get_patch_info';
        $.ajax({
            type: 'get',
            dataType: "json",
            data: {current_version: _current_version},
            url: url,
            success: function (resp) {
                loading.hide('#modal-upgrade-body');
                if (resp.ret !== '200') {
                    $spanNewVersion.text('');
                    $btnCancelUpgrade.removeClass('disabled');
                    $btnCheckAgain.removeClass('hidden');
                    $checkMessage.removeClass('hidden').text(resp.msg);
                    $checkMessage.addClass('text-danger');
                    $btnModalClose.removeClass('disabled');
                    loading.hide('#modal-upgrade-body');
                    return false;
                }
                let data = resp.data;
                let latestVersion = data.last_version.version;
                let releaseUrl = data.last_version.release_url;

                $versionDescription.attr('href', releaseUrl).removeClass('hidden');
                $btnUpgrade.removeClass('disabled');
                $spanNewVersion.text(latestVersion);
                $checkMessage.removeClass('hidden').text(resp.msg);
                $checkMessage.addClass('text-success');
                $btnModalClose.removeClass('disabled');
                $btnCancelUpgrade.removeClass('disabled');
            },
            error: function (resp) {
                loading.hide('#modal-upgrade-body');
                $btnCancelUpgrade.removeClass('disabled');
                $btnCheckAgain.removeClass('hidden');
                $btnModalClose.removeClass('disabled');
                $spanNewVersion.text('版本检测失败:' + resp.responseText);
                return false;
            }
        });
    };

    // 每日检测升级
    Upgrade.prototype.dailyCheck = function () {
        let checked = cookie('upgrade-checked') == '1';
        if (!checked) {
            let url = 'http://www.masterlab.vip/upgrade.php?action=get_patch_info';
            $.ajax({
                type: 'get',
                dataType: "json",
                data: {current_version: _current_version},
                url: url,
                success: function (resp) {
                    cookie('upgrade-checked', '1', {expires: 1, path: '/'});
                    if (resp.ret === '200') {
                        upgradeMsg = JSON.stringify(resp.data);
                        localStorage.setItem('upgrade-msg', upgradeMsg);
                        showUpgradeMsg(upgradeMsg);
                    } else {
                        localStorage.removeItem('upgrade-msg');
                    }
                }
            });
        } else {
            upgradeMsg = localStorage.getItem('upgrade-msg');
            if (upgradeMsg) {
                showUpgradeMsg(upgradeMsg);
            }
        }
    };

    // 显示更新提示横幅
    function showUpgradeMsg(upgradeMsg) {
        upgradeMsg = JSON.parse(upgradeMsg);
        let latestVersion = upgradeMsg.last_version.version;
        let releaseUrl = upgradeMsg.last_version.release_url;
        $('#update-new-version').text(latestVersion);
        $('#update-release_url').attr('href', releaseUrl);
        $('#upgrade-msg').removeClass('hidden');
    }

    // 关闭更新提示横幅
    function upgradeMsgViewed() {
        localStorage.removeItem('upgrade-msg');
    }

    // 设置和读取cookie
    function cookie(key, value, options) {
        if (value !== undefined) {
            if (typeof options.expires === 'number') {
                let days = options.expires, t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }

            return (document.cookie = [
                encodeURIComponent(key), '=', value,
                options.expires ? '; expires=' + options.expires.toUTCString() : '',
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        let result = undefined;
        let cookies = document.cookie ? document.cookie.split('; ') : [];
        let pluses = /\+/g;

        for (let i = 0, l = cookies.length; i < l; i++) {
            let parts = cookies[i].split('=');
            let name = decodeURIComponent(parts.shift());
            let cookie = parts.join('=');

            if (key && key === name) {
                if (cookie.indexOf('"') === 0) {
                    cookie = cookie.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
                }
                result = decodeURIComponent(cookie.replace(pluses, ' '));
                break;
            }
        }

        return result;
    }

    // 删除cookie
    function removeCookie(key) {
        if (cookie(key) === undefined) {
            return false;
        }

        cookie(key, '', {expires: -1});
        return !$.cookie(key);
    }

    return Upgrade;
})();