<link rel="stylesheet" media="all" href="/gitlab/assets/application.css?v={{_version}}"/>
<link rel="stylesheet" media="print" href="/gitlab/assets/print.css?v={{_version}}"/>
<link rel="stylesheet" type="text/css" href="/dev/css/loading.css?v={{_version}}"/>
<?
$floatType = 'fixed';

if ($floatType == 'fixed') {
    echo '<link rel="stylesheet"  type="text/css" href="' . ROOT_URL . 'dev/css/layout_fixed.css?v={{_version}}" />';
} else {
    echo '<link rel="stylesheet"  type="text/css" href="' . ROOT_URL . 'dev/css/layout_float.css?v={{_version}}" />';
}
?>

<link rel="stylesheet" media="all" href="/dev/css/main.css?v={{_version}}"/>
<link rel="stylesheet" type="text/css" href="/dev/css/issue/form.css?v={{_version}}"/>
