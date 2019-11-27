<?
$layout = 'left';
if (isset($G_Preferences['scheme_style']) && !empty($G_Preferences['scheme_style'])) {
    $layout = $G_Preferences['scheme_style'];
}
if($layout=='left'){
    require_once VIEW_PATH . 'gitlab/common/body/layout/' . $layout . '/page-left.php';
}
?>


