<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\user\UserModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;

/**
 *  为 UploadLogic 逻辑类提供测试数据
 */
class UploadLogicDataProvider
{
    public static $insertUserIdArr = [];

    public static $fileAttachmentIdArr = [];

    public static $fileName = '';

    /**
     * 初始化用户
     * @throws \Exception
     */
    public static function initLoginUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);

        // 表单数据 $post_data
        $postData = [];
        $postData['username'] = $username;
        $postData['phone'] = $username;
        $postData['email'] = $username . '@masterlab.org';
        $postData['display_name'] = $username;
        $postData['status'] = UserModel::STATUS_NORMAL;
        $postData['openid'] = UserAuth::createOpenid($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            var_dump(__CLASS__ . '/initUser  failed,' . $msg);
            return [];
        }
        self::$insertUserIdArr[] = $msg;
        $user = $userModel->getRowById($msg);
        $_SESSION[UserAuth::SESSION_UID_KEY] = $user['uid'];
        return $user;
    }

    /**
     * 构建一个文件对象
     * @param $fieldName
     * @param null $name
     * @param null $type
     * @param null $error
     * @return mixed
     */
    public static function providerFileObject($fieldName, $name = null, $type = null, $error = null, $size = null)
    {

        $_FILES[$fieldName] = [];
        $_FILES[$fieldName]['name'] = $name;
        if (empty($name)) {
            $_FILES[$fieldName]['name'] = 'test-name.png';
        }
        $_FILES[$fieldName]['type'] = $type;
        if (empty($type)) {
            $_FILES[$fieldName]['type'] = 'image/png';
        }

        $_FILES[$fieldName]['error'] = $error;
        if (empty($error)) {
            $_FILES[$fieldName]['error'] = UPLOAD_ERR_OK;
        }
        $fileName = STORAGE_PATH . 'tmp/test-name.png';
        if (!file_exists(STORAGE_PATH . 'tmp/10000.png')) {
            copy(APP_PATH . 'public/gitlab/images/10000.png', STORAGE_PATH . 'tmp/10000.png');
        }
        $ret = copy(STORAGE_PATH . 'tmp/10000.png', $fileName);
        if ($ret) {
            self::$fileName = $fileName;
        } else {
            return [false, 'file_put_contents tmp_file failed'];
        }
        $_FILES[$fieldName]['tmp_name'] = $fileName;
        $_FILES[$fieldName]['size'] = filesize($fileName);
        if (!empty($size)) {
            $_FILES[$fieldName]['size'] = $size;
        }
        /*  [name] => MyFile.jpg
            [type] => image/jpeg
            [tmp_name] => /tmp/php/php6hst32
            [error] => UPLOAD_ERR_OK
            [size] => 98174
                */
        $_FILES[$fieldName]['is_phpunit'] = true;
        return [true, $_FILES];
    }

    /**
     * 清除测试数据
     * @throws \Exception
     */
    public static function clear()
    {
        if (!empty(self::$insertUserIdArr)) {
            $model = new UserModel();
            foreach (self::$insertUserIdArr as $id) {
                $model->deleteById($id);
            }
        }
        if (!empty(self::$fileAttachmentIdArr)) {
            $model = new IssueFileAttachmentModel();
            foreach (self::$fileAttachmentIdArr as $id) {
                $model->deleteById($id);
            }
        }


        if (!empty(self::$fileName)) {
            @unlink(self::$fileName);
        }
    }
}
