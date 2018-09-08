<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

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
        $row = BaseDataProvider::createTypeScheme($info);
        self::$insertSchemeIdArr[] = $row['id'];
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
