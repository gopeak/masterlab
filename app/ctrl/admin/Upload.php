<?php

namespace main\app\ctrl\admin;

use \main\app\ctrl\BaseAdminCtrl;
use \main\app\classes\UploadLogic;
use main\lib\FileUtil;
use ZipArchive;

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
     * 上传图片接口
     * @throws \Exception
     */
    public function img()
    {
        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('imgFile', 'image');
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($ret);
        exit;
    }

    public function plugin()
    {
        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('qqfile', 'image');
        if($ret['error']==0){
            $ret['error'] = '';
            $ret['success'] = true;
        }
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($ret);
        exit;
    }

    public function pluginZip()
    {
        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->movePluginZip('qqfile');
        if($ret['error']==0){
            $ret['error'] = '';
            $ret['success'] = true;
            $ret['plugin_arr'] = [];
            $ret['name'] = '';
            $filePath = STORAGE_PATH . "plugin_zip/".$ret['relate_path'];
            if (!extension_loaded('zip')) {
                $ret['error'] = -1;
                $ret['success'] = false;
                $ret['message'] = 'zip扩展没有安装';
            }
            @mkdir($filePath.'-unzip');
            $zip = new ZipArchive;
            $res = $zip->open($filePath);
            if ($res) {
                $zip->extractTo($filePath.'-unzip');
                $zip->close();
                $dirNum = 0;
                $dir = $filePath.'-unzip/plugin/';
                $pluginDirName = '';
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if( $file == '.' || $file == '..'){
                            continue;
                        }
                        if(is_dir($dir.$file)){
                            $pluginDirName = $file;
                            $dirNum++;
                        }
                    }
                    closedir($dh);
                }
                if($dirNum>1){
                    $ret['error'] = -3;
                    $ret['success'] = false;
                    $ret['message'] = 'plugin目录下只应该存在一个文件';
                }
                $ret['name'] = $pluginDirName;
                $pluginArr = json_decode(file_get_contents($dir."/{$pluginDirName}/plugin.json"), true);
                $ret['plugin_arr'] = $pluginArr;
                //rrmdir($dir);
                FileUtil::unlinkDir($filePath.'-unzip');
            }else{
                $ret['error'] = -2;
                $ret['success'] = false;
                $ret['message'] = 'zip打开失败';
            }
        }
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($ret);
        exit;
    }
    /**
     * 上传头像
     * @throws \Exception
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
