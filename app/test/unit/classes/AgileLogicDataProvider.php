<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\ctrl\project\Base;
use main\app\model\project\ProjectModel;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;

/**
 * 为敏捷逻辑类提供测试数据
 */
class AgileLogicDataProvider
{
    public static $insertProjectIdArr = [];

    public static $insertIssueIdArr = [];

    public static $insertSprintIdArr = [];

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
     * @param array $info
     * @return array
     */
    public static function initIssue($info=[])
    {
        $row = BaseDataProvider::createIssue($info);
        self::$insertIssueIdArr[] = $row['id'];
        return $row;
    }

    /**
     * @param array $info
     * @return array
     */
    public static function initSprint($info=[])
    {
        $row = BaseDataProvider::createSprint($info);
        self::$insertSprintIdArr[] = $row['id'];
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
     * 清除issue记录
     */
    public static function clearIssue()
    {
        if (!empty(self::$insertIssueIdArr)) {
            $model = new IssueModel();
            foreach (self::$insertIssueIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 清除sprint记录
     */
    public static function clearSprint()
    {
        if (!empty(self::$insertSprintIdArr)) {
            $model = new SprintModel();
            foreach (self::$insertSprintIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clear()
    {
        self::clearProject();
        self::clearSprint();
        self::clearIssue();
    }
}
