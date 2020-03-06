
let Upgrade = (function() {

    let _current_version = null;

    let $versionDescription = null;
    let $btnUpgrade = null;
    let $spanNewVersion = null;
    let $btnCancelUpgrade = null;
    let $btnCheckAgain = null;
    let $checkMessage = null
    let $btnModalClose = null;

    let $upgradeMessageBox =null;
    let $modalUpgrade = null;
    let $modalAbout = null;

    // constructor
    function Upgrade(  current_version  ) {
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
            Upgrade.prototype.checkUpgrade();
        });
        $modalUpgrade.on('hide.bs.modal', function () {
            $upgradeMessageBox.empty();
        });

        // 点击立即升级链接或升级菜单

        $(document).on('click', '#btn-upgrade, #menu-upgrade', function () {
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

    };

    Upgrade.prototype.getOptions = function() {
        return _options;
    };

    Upgrade.prototype.run = function(sprint_id) {
        swal({
                title: "确认要执行升级？",
                text: "注:请务必手动执行备份数据库或代码",
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确 定",
                cancelButtonText: "取 消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    Upgrade.prototype.postServer();
                    swal.close();
                }else{
                    swal.close();
                }
            }
        );

    };

    Upgrade.prototype.postServer = function(sprint_id){

        var url = '/upgrade/run';
        var source = $('#upgrade-source').val();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            data: {source: source},
            cache: false,
            xhr: function () {
                var xhr;
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
                    var html = '';
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        $btnCancelUpgrade.removeClass('disabled');
                        $btnModalClose.removeClass('disabled');
                        //html = '<p style="color: #ff0000; font-weight: bold;">升级完成！</p>';
                        //$upgradeMessageBox.append($(html));
                    } else if(xhr.readyState === 3){
                        html = xhr.responseText;
                        $upgradeMessageBox.html(html);
                    }

                    var scrollHeight = $upgradeMessageBox.prop('scrollHeight');
                    $upgradeMessageBox.scrollTop(scrollHeight, 200);
                };

                return xhr;
            }
        });
    };

    // 检测升级
    Upgrade.prototype.checkUpgrade  = function  () {

        $versionDescription.addClass('hidden');
        $btnUpgrade.addClass('disabled');
        $spanNewVersion.text('正在检测...');
        $btnCancelUpgrade.addClass('disabled');
        $btnCheckAgain.addClass('hidden');
        $checkMessage.addClass('hidden');
        $btnModalClose.addClass('disabled');

        loading.show('#modal-upgrade-body');

        var url = 'http://www.masterlab.vip/upgrade.php?action=get_patch_info';
        $.ajax({
            type: 'get',
            dataType: "json",
            data: {current_version: _current_version},
            url: url,
            success: function (resp) {
                loading.hide('#modal-upgrade-body');
                if( resp.ret !== '200' ){
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
                $checkMessage.removeClass('hidden').text( resp.msg);
                $checkMessage.addClass('text-success');
                $btnModalClose.removeClass('disabled');
                $btnCancelUpgrade.removeClass('disabled');
            },
            error: function (resp) {
                loading.hide('#modal-upgrade-body');
                $btnCancelUpgrade.removeClass('disabled');
                $btnCheckAgain.removeClass('hidden');
                $btnModalClose.removeClass('disabled');
                $spanNewVersion.text('版本检测失败:'+resp.responseText);
                return false;
            }
        });
    };

    return Upgrade;
})();

