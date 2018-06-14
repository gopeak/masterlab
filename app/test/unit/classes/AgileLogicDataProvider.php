<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

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

    public static function initIssue($info)
    {
        if (!isset($info['summary'])) {
            $info['summary'] = 'testSummary-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['creator'])) {
            $info['creator'] = 0;
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

        $model = new IssueModel();
        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            parent::fail(__CLASS__ . '/initIssue  failed,' . $issueId);
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
            parent::fail(__CLASS__ . '/initIssue  failed,' . $insertId);
            return;
        }
        self::$insertSprintIdArr[] = $insertId;
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
