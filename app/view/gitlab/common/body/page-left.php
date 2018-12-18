<?
    $layout = 'left';
    if (isset($G_Preferences) && !empty($G_Preferences)) {
        $layout=$G_Preferences['scheme_style'];
    }
    if($layout==='left')
    {
        require_once VIEW_PATH.'gitlab/common/body/layout/'.$layout.'/page-left.php';
    }

?>


