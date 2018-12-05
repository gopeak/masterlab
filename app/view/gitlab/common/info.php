<?php
$link = '';

if ($_links['type'] == 'back') {
    $link = 'javascript:history.go(-1);';
} else {
    $link = $_links['link'];
}

$siteName = (new \main\app\classes\SettingsLogic())->showSysTitle();
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title><?= $siteName ?></title>
    <script src="<?= ROOT_URL ?>dev/js/logo.js"></script>
    <link rel="stylesheet" media="all" href="<?= ROOT_URL ?>gitlab/assets/application.css"/>
    <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/not_found.css">
</head>

<body>
<div class="not-found vertical">
    <div class="inner">
        <div class="img">
            <img src="<?=ROOT_URL?>gitlab/images/logo.png" />
        </div>
        <div class="text">
            <div class="type"></div>
            <div class="info"><?= $_title ?></div>
            <div class="detail"><?= $_content ?></div>
            <!-- <?
            if (isset($message)) {
                echo $message;
            } ?> -->
            <div class="you-can">
                您可以：
                <a class="btn btn-success" onclick="history.back()">返回上一页</a>
                <a class="btn btn-default" href="<?= $link ?>"><?= $_links['title'] ?></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
