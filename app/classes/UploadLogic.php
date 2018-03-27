<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;


use main\app\model\issue\IssueFileAttachmentModel;

class UploadLogic
{

    /**
     * @param $fieldName 上传的参数名称
     * @param $fileType  文件类型定义 有 image media file
     * @return array
     */
    public function move( $fieldName ,$fileType ,$uuid='', $originName='',$originFileSize=0)
    {
        //文件保存目录路径
        $savePath = PUBLIC_PATH . 'attached/';
        //文件保存目录URL
        $saveUrl = ROOT_URL . 'attached/';

        $relatePath = 'attached/';

        //定义允许上传的文件扩展名
        $extArr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        $extArr['all'] = $extArr['image']+$extArr['media']+$extArr['file'];
        //最大文件大小
        $max_size = 1000000;

        //PHP上传失败
        if (!empty($_FILES[$fieldName]['error'])) {
            switch($_FILES[$fieldName]['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension.';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            $this->upload_error( $error );
        }

        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $fileName = $_FILES[$fieldName]['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES[$fieldName]['tmp_name'];
            //文件大小
            $fileSize = $_FILES[$fieldName]['size'];
            //检查文件名
            if (!$fileName) {
                $this->upload_error('请选择文件');
            }
            //检查目录
            if (@is_dir($savePath) === false) {
                $this->upload_error("上传目录不存在");
            }
            //检查目录写权限
            if (@is_writable($savePath) === false) {
                $this->upload_error("上传目录没有写权限");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                $this->upload_error("上传失败。");
            }
            //检查文件大小
            if ($fileSize > $max_size) {
                $this->upload_error("上传文件大小超过限制");
            }
            //检查目录名
            if (empty($extArr[$fileType])) {
                $this->upload_error("目录名不正确");
            }

            //获得文件扩展名
            $tempArr = explode(".", $fileName);
            $fileExt = array_pop($tempArr);
            $fileExt = trim($fileExt);
            $fileExt = strtolower($fileExt);

            $allowType = $fileType;
            if($fileType=='all'){
                   foreach($extArr as $type =>$r ){
                       if( $type!='all' && in_array( $fileExt,$r)){
                           $allowType = $type;
                       }
                   }
            }

            //检查扩展名
            if (in_array($fileExt, $extArr[$allowType]) === false) {
                $this->upload_error("上传文件扩展名是不允许的扩展名.\n只允许" . implode(",", $extArr[$fileType]) . "格式.");
            }


            //创建文件夹
            if ($fileType !== '') {
                $savePath .= $fileType . "/";
                $saveUrl .= $fileType . "/";
                $relatePath .= $fileType . "/";
                if (!file_exists($savePath)) {
                    mkdir($savePath);
                }
            }
            $ymd = date("Ymd");
            $savePath .= $ymd . "/";
            $saveUrl .= $ymd . "/";
            $relatePath .= $ymd . "/";
            if (!file_exists($savePath)) {
                mkdir($savePath);
            }
            //新文件名
            $newFileName = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $fileExt;

            //移动文件
            $filePath = $savePath . $newFileName;
            if (move_uploaded_file($tmp_name, $filePath) === false) {
                $this->upload_error("上传文件失败.");
            }
            @chmod($filePath, 0644);
            $file_url =  $saveUrl . $newFileName;
            $relatePath  .= $newFileName;

            $model = new IssueFileAttachmentModel();
            $fileInsert = [];
            $fileInsert['uuid'] = $uuid;
            $fileInsert['mime_type'] = $_FILES[$fieldName]['type'];
            $fileInsert['file_name'] = $relatePath;
            $fileInsert['origin_name'] = $originName;
            $fileInsert['file_size'] =  $originFileSize;
            $fileInsert['file_ext'] =  $fileExt;
            $userAuthLogic = new UserAuth();
            $fileInsert['author'] = $userAuthLogic->getId();
            $fileInsert['created'] = time();
            $ret = $model->insert($fileInsert);
            if( !$ret[0] ){
                $this->upload_error("服务器错误");
            }
            return array('message' => '上传成功',  'error'=>0, 'url' => $file_url,'filename'=>$originName);
        }

        return $this->upload_error('上传失败',4);

    }

    public function upload_error( $msg ,$code=4)
    {
        return  json_encode(array('message' => $msg,'error'=>$code, 'url' => '','filename'=>''));
    }

}
