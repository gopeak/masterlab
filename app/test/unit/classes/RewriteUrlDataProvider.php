<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\project\ProjectModel;
use main\app\model\OrgModel;
use main\app\test\BaseDataProvider;

/**
 *  为 RewriteUrl 逻辑类提供测试数据
 */
class RewriteUrlDataProvider
{
    public static $insertProjectIdArr = [];

    public static $insertOrgIdArr = [];

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
    public static function initOrg($info = [])
    {
        $row = BaseDataProvider::createOrg($info);
        self::$insertOrgIdArr[] = $row['id'];
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
    public static function clearOrg()
    {
        if (!empty(self::$insertOrgIdArr)) {
            $model = new OrgModel();
            foreach (self::$insertOrgIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clear()
    {
        self::clearProject();
        self::clearOrg();
    }
}
