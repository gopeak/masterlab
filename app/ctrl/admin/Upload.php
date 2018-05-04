<?php

namespace main\app\ctrl\admin;

use \main\app\ctrl\BaseAdminCtrl;
use \main\app\classes\UploadLogic;

/**
 *
 */
class Upload extends BaseAdminCtrl
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     *
     */
    public function img()
    {
        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('imgFile', 'image');
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($ret);
        exit;
    }


    /**
     *
     */
    public function avatar()
    {
        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('imgFile', 'avatar');
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($ret);
        exit;
    }
}