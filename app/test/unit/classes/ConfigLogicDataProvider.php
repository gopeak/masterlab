<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\project\ProjectModel;

/**
 * 为敏捷逻辑类提供测试数据
 */
class ConfigLogicDataProvider
{

    public static $insertProjectIdArr = [];

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
            var_dump(__CLASS__.'/initProject  failed,' . $insertId);
            return [];
        }
        self::$insertProjectIdArr[] = $insertId;
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


    public static function clear()
    {
        self::clearProject();
    }
}
