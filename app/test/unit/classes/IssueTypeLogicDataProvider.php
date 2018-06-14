<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\issue\IssueTypeSchemeModel;

/**
 *  为 IssueTypeLogic 逻辑类提供测试数据
 */
class IssueTypeLogicDataProvider
{

    public static $insertProjectIdArr = [];

    public static $insertSchemeIdArr = [];

    /**
     * 生成一条项目记录
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        self::$insertProjectIdArr[] = $row['id'];
        return $row;
    }

    /**
     * 生成一条类型方案记录
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
            $info['description'] = 'test-description';
        }

        $model = new IssueTypeSchemeModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__.'/initScheme  failed,' . $insertId);
            return [];
        }
        self::$insertSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }


    /**
     * 清除项目记录
     */
    public static function clearProject()
    {
        if (!empty(self::$insertProjectIdArr)) {
            $model = new ProjectModel();
            foreach (self::$insertProjectIdArr as $id) {
                $model->deleteById($id);
            }
        }
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
        self::clearProject();
        self::clearScheme();
    }
}
