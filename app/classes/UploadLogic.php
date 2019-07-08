<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueFileAttachmentModel;

/**
 * 上传逻辑类
 * @package main\app\classes
 */
class UploadLogic
{

    public $issueId = null;

    /**
     * UploadLogic constructor.
     * @param null $issueId
     */
    public function __construct($issueId = null)
    {
        $this->issueId = $issueId;
    }

    /**
     * 统一的上传处理逻辑,根据文件类型上传至 app/storage/attachment 下
     * @param string $fieldName
     * @param string $fileType
     * @param string $uuid
     * @param string $originName
     * @param int $originFileSize
     * @param string $tmpIssueId
     * @return array
     * @throws \Exception
     */
    public function move($fieldName, $fileType, $uuid = '', $originName = '', $originFileSize = 0, $tmpIssueId = '')
    {

        $settings = Settings::getInstance()->attachment();
        //文件保存目录路径
        $savePath = $settings['attachment_dir'];
        //最大文件大小
        $max_size = $settings['attachment_size'];

        //文件保存目录URL
        $saveUrl = ATTACHMENT_URL;

        $relatePath = '';

        //定义允许上传的文件扩展名
        $extArr = array(
            'avatar' => array('jpg', 'jpeg', 'png', 'gif'),
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb', 'mp4', 'aac'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf'),
        );
        if (!isset($extArr[$fileType])) {
            $fileType = 'all';
        }
        $extArr['all'] = $extArr['image'] + $extArr['media'] + $extArr['file'];

        //PHP上传失败
        if ($_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
            switch ($_FILES[$fieldName]['error']) {
                case '1':
                    $error = '超过php.ini允许的大小';
                    break;
                case '2':
                    $error = '超过表单允许的大小';
                    break;
                case '3':
                    $error = '图片只有部分被上传';
                    break;
                case '4':
                    $error = '请选择图片';
                    break;
                case '6':
                    $error = '找不到临时目录';
                    break;
                case '7':
                    $error = '写文件到硬盘出错';
                    break;
                case '8':
                    $error = '不允许的扩展名';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            return $this->uploadError($error);
        }

        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $fileName = $_FILES[$fieldName]['name'];
            if (empty($originName)) {
                $originName = $fileName;
            }
            //服务器上临时文件名
            $tmpName = $_FILES[$fieldName]['tmp_name'];
            //文件大小
            $fileSize = $_FILES[$fieldName]['size'];
            //检查文件名
            if (!$fileName) {
                return $this->uploadError('请选择文件');
            }
            //检查目录
            if (@is_dir($savePath) === false) {
                return $this->uploadError("上传目录不存在");
            }
            //检查目录写权限
            if (@is_writable($savePath) === false) {
                return $this->uploadError("上传目录没有写权限");
            }
            //检查是否已上传
            if (!isset($_FILES[$fieldName]['is_phpunit'])) {
                if (@is_uploaded_file($tmpName) === false) {
                    return $this->uploadError("上传失败。");
                }
            }

            //检查文件大小
            if ($fileSize > $max_size) {
                return $this->uploadError("上传文件大小超过限制");
            }
            //检查目录名
            if (empty($extArr[$fileType])) {
                return $this->uploadError("目录名不正确");
            }

            //获得文件扩展名
            $tempArr = explode(".", $fileName);
            $fileExt = array_pop($tempArr);
            $fileExt = trim($fileExt);
            $fileExt = strtolower($fileExt);

            $allowType = $fileType;
            if ($fileType == 'all') {
                foreach ($extArr as $type => $r) {
                    if ($type != 'all' && in_array($fileExt, $r)) {
                        $allowType = $type;
                    }
                }
            }

            //检查扩展名
            if (in_array($fileExt, $extArr[$allowType]) === false) {
                $msg = "上传文件的扩展名错误.只允许" . implode(",", $extArr[$fileType]) . "格式.";
                return $this->uploadError($msg);
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
            // 判断是否为单元测试构建的文件
            if (isset($_FILES[$fieldName]['is_phpunit'])) {
                if (!copy($tmpName, $filePath)) {
                    return $this->uploadError("上传文件失败(phpunit).");
                }
            } else {
                if (move_uploaded_file($tmpName, $filePath) === false) {
                    return $this->uploadError("上传文件失败.");
                }
            }

            @chmod($filePath, 0644);
            $fileUrl = $saveUrl . $newFileName;
            $relatePath .= $newFileName;
            if (empty($uuid)) {
                $uuid = quickRandom() . mt_rand(10000, 999999);
            }
            $model = new IssueFileAttachmentModel();
            $fileInsert = [];
            $fileInsert['uuid'] = $uuid;
            $fileInsert['mime_type'] = $_FILES[$fieldName]['type'];
            $fileInsert['file_name'] = $relatePath;
            $fileInsert['origin_name'] = $originName;
            $fileInsert['file_size'] = $originFileSize;
            $fileInsert['file_ext'] = $fileExt;
            $fileInsert['author'] = UserAuth::getId();
            $fileInsert['created'] = time();
            $fileInsert['tmp_issue_id'] = $tmpIssueId;
            if (!empty($this->issueId)) {
                $fileInsert['issue_id'] = $this->issueId;
            }
            $ret = $model->insert($fileInsert);
            //file_put_contents(STORAGE_PATH . '/hhh.log', var_export($fileInsert, true));
            if (!$ret[0]) {
                return $this->uploadError("服务器错误" . $ret[1]);
            }
            $msg = '上传成功';
            return [
                'message' => $msg,
                'error' => 0,
                'url' => $fileUrl,
                'filename' => $originName,
                'relate_path' => $relatePath,
                'insert_id' => $ret[1],
                'uuid' => $uuid,
                'issue_id' => $this->issueId
            ];
        }

        return $this->uploadError('上传失败', 4);
    }

    /**
     * 统一返回上传返回值
     * @param string $msg
     * @param int $code
     * @return array
     */
    public function uploadError($msg, $code = 4)
    {
        return array('message' => $msg, 'error' => $code, 'url' => '', 'filename' => '', 'insert_id' => '');
    }

    /**
     * @param $base64ImageContent
     * @param $path
     * @param $uid
     * @return bool|string
     */
    public static function base64ImageContent($base64ImageContent, $path, $uid)
    {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64ImageContent, $result)) {
            $type = $result[2];
            $newFile = $path . $uid . ".{$type}";
            //var_dump($newFile);
            if (file_put_contents($newFile, base64_decode(str_replace($result[1], '', $base64ImageContent)))) {
                return $uid . ".{$type}";
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 保存文件
     * @param $text
     * @param $path
     * @param $userId
     * @return bool|string
     */
    public static function saveFileText($text, $path, $userId)
    {
        //匹配出图片的格式
        $type = 'png';
        if (!file_exists($path)) {
            mkdir($path);
        }
        $fileName = $userId . 'cut-' . date('YmdHms') . mt_rand(1000, 9999) . ".{$type}";
        $newFile = $path . $fileName;
        // var_dump($newFile);
        if (file_put_contents($newFile, $text)) {
            return $fileName;
        } else {
            return false;
        }
    }
}
