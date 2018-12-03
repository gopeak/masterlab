<link rel="stylesheet" media="all" href="<?= ROOT_URL ?>gitlab/assets/application.css"/>
<link rel="stylesheet" media="print" href="<?= ROOT_URL ?>gitlab/assets/print.css"/>
<link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/loading.css"/>
<?
$floatType = 'fixed';

if ($floatType == 'fixed') {
    echo '<link rel="stylesheet"  type="text/css" href="' . ROOT_URL . 'dev/css/layout_fixed.css" />';
} else {
    echo '<link rel="stylesheet"  type="text/css" href="' . ROOT_URL . 'dev/css/layout_float.css" />';
}
?>

<link rel="stylesheet" media="all" href="<?= ROOT_URL ?>dev/css/main.css"/>
<link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/left.css"/>
<link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>dev/css/issue/form.css"/>
