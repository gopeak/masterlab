<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\issue\IssueTypeSchemeModel;

/**
 * 为FieldLogic逻辑类提供测试数据
 */
class FieldLogicDataProvider
{

    public static $insertSchemeIdArr = [];

    /**
     * 生成一条项目记录
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initScheme($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-name-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = $info['description'];
        }

        $model = new IssueTypeSchemeModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            parent::fail(__CLASS__.'/initScheme  failed,' . $insertId);
            return [];
        }
        self::$insertSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }


    /**
     * 清除项目记录
     */
    public static function clearScheme()
    {
        if (!empty(self::$insertSchemeIdArr)) {
            $model = new IssueTypeSchemeModel();
            foreach (self::$insertSchemeIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }


    public static function clear()
    {
        self::clearScheme();
    }
}
