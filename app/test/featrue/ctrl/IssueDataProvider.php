<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\featrue\ctrl;

use main\app\ctrl\project\Base;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\issue\IssueModel;
use main\app\model\user\UserModel;
use main\app\model\agile\SprintModel;
use main\app\test\BaseDataProvider;

/**
 * 为 issue 控制器提供测试数据
 */
class IssueDataProvider
{
    public static $insertProjectIdArr = [];

    public static $insertUserIdArr = [];

    public static $insertIssueIdArr = [];

    public static $insertSprintIdArr = [];

    public static $insertModuleIdArr = [];

    public static $insertVersionIdArr = [];


    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        self::$insertProjectIdArr[] = $row['id'];
        return $row;
    }

    /**
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initUser($info=[])
    {
        $user = BaseDataProvider::createUser($info);
        self::$insertUserIdArr[] = $user['uid'];
        return $user;
    }

    public static function initIssue($info)
    {
        $row = BaseDataProvider::createIssue($info);
        self::$insertIssueIdArr[] = $row['id'];
        return $row;
    }

    public static function initSprint($info)
    {
        $row = BaseDataProvider::createSprint($info);
        self::$insertSprintIdArr[] = $row['id'];
        return $row;
    }

    public static function initModule($info)
    {
        $row = BaseDataProvider::createProjectModule($info);
        self::$insertModuleIdArr[] = $row['id'];
        return $row;
    }

    public static function initVersion($info)
    {
        $row = BaseDataProvider::createProjectVersion($info);
        self::$insertVersionIdArr[] = $row['id'];
        return $row;
    }

    public static function clearProjectModule()
    {
        if (!empty(self::$insertModuleIdArr)) {
            $model = new ProjectModuleModel();
            foreach (self::$insertModuleIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }
    public static function clearProjectVersion()
    {
        if (!empty(self::$insertVersionIdArr)) {
            $model = new ProjectVersionModel();
            foreach (self::$insertVersionIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearProject()
    {
        if (!empty(self::$insertProjectIdArr)) {
            $model = new ProjectModel();
            foreach (self::$insertProjectIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearUser()
    {
        if (!empty(self::$insertUserIdArr)) {
            $model = new UserModel();
            foreach (self::$insertUserIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearIssue()
    {
        if (!empty(self::$insertIssueIdArr)) {
            $model = new IssueModel();
            foreach (self::$insertIssueIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

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
        self::clearProjectModule();
        self::clearProjectVersion();

    }
}
