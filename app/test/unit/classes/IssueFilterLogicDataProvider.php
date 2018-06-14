<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\issue\IssueModel;
use main\app\model\user\UserModel;
use main\app\model\agile\SprintModel;
use main\app\test\BaseDataProvider;

/**
 * 为 issue查询逻辑类提供测试数据
 */
class IssueFilterLogicDataProvider
{
    public static $insertProjectIdArr = [];

    public static $insertUserIdArr = [];

    public static $insertIssueIdArr = [];

    public static $insertSprintIdArr = [];

    public static $insertModuleIdArr = [];

    public static $insertVersionIdArr = [];


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
     * 初始化用户
     */
    public static function initUser($info)
    {
        $user = BaseDataProvider::createUser($info);
        self::$insertUserIdArr[] = $user['uid'];
        return $user;
    }

    public static function initIssue($info)
    {
        if (!isset($info['summary'])) {
            $info['summary'] = 'test-summary-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }
        if (!isset($info['environment'])) {
            $info['environment'] = 'test-environment';
        }
        if (!isset($info['creator'])) {
            $info['creator'] = 0;
        }
        if (!isset($info['modifier'])) {
            $info['modifier'] = 0;
        }
        if (!isset($info['reporter'])) {
            $info['reporter'] = 0;
        }
        if (!isset($info['assignee'])) {
            $info['assignee'] = 0;
        }
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['sprint'])) {
            $info['sprint'] = 0;
        }
        if (!isset($info['issue_type'])) {
            $info['issue_type'] = 1;
        }
        if (!isset($info['priority'])) {
            $info['priority'] = 1;
        }
        if (!isset($info['resolve'])) {
            $info['resolve'] = 1;
        }
        if (!isset($info['status'])) {
            $info['status'] = 1;
        }
        if (!isset($info['created'])) {
            $info['created'] = time();
        }
        if (!isset($info['updated'])) {
            $info['updated'] = 0;
        }
        if (!isset($info['start_date'])) {
            $info['start_date'] = date('Y-m-d');
        }
        if (!isset($info['due_date'])) {
            $info['due_date'] = '';
        }
        if (!isset($info['resolve_date'])) {
            $info['resolve_date'] = '';
        }
        if (!isset($info['module'])) {
            $info['module'] = 0;
        }
        if (!isset($info['sprint'])) {
            $info['sprint'] = 0;
        }

        $model = new IssueModel();
        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initIssue  failed,' . $issueId);
            return;
        }
        self::$insertIssueIdArr[] = $issueId;
        $issue = $model->getRowById($issueId);
        return $issue;
    }

    public static function initSprint($info)
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name';
        }
        if (!isset($info['active'])) {
            $info['active'] = 0;
        }
        if (!isset($info['status'])) {
            $info['status'] = 0;
        }
        if (!isset($info['order_weight'])) {
            $info['order_weight'] = 0;
        }

        $model = new SprintModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initIssue  failed,' . $insertId);
            return;
        }
        self::$insertSprintIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function initModule($info)
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name';
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        if (!isset($info['lead'])) {
            $info['lead'] = 0;
        }
        if (!isset($info['default_assignee'])) {
            $info['default_assignee'] = 0;
        }

        $model = new ProjectModuleModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initModule  failed,' . $insertId);
            return;
        }
        self::$insertModuleIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function initVersion($info)
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name';
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }
        if (!isset($info['sequence'])) {
            $info['sequence'] = 0;
        }
        if (!isset($info['released'])) {
            $info['released'] = 0;
        }

        $model = new ProjectVersionModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initVersion  failed,' . $insertId);
            return;
        }
        self::$insertVersionIdArr[] = $insertId;
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

    public static function clearUser()
    {
        if (!empty(self::$insertUserIdArr)) {
            $model = new UserModel();
            foreach (self::$insertUserIdArr as $id) {
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
    public static function clearModule()
    {
        if (!empty(self::$insertModuleIdArr)) {
            $model = new ProjectModuleModel();
            foreach (self::$insertModuleIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }
    public static function clearVersion()
    {
        if (!empty(self::$insertVersionIdArr)) {
            $model = new ProjectVersionModel();
            foreach (self::$insertVersionIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }
    public static function clear()
    {
        self::clearProject();
        self::clearSprint();
        self::clearIssue();
        self::clearVersion();
        self::clearModule();

    }
}
