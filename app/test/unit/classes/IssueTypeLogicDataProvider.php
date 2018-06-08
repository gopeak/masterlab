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
        // 表单数据 $post_data
        if (!isset($info['name'])) {
            $info['name'] = 'project-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['key'])) {
            $info['key'] = $info['name'];
        }
        if (!isset($info['origin_id'])) {
            $info['origin_id'] = 0;
        }
        if (!isset($info['create_uid'])) {
            $info['create_uid'] = 0;
        }
        if (!isset($info['type'])) {
            $info['type'] = 1;
        }

        $model = new ProjectModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            parent::fail(__CLASS__.'/initProject  failed,' . $insertId);
            return [];
        }
        self::$insertProjectIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
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
