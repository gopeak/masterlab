<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\project\ProjectLabelModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\user\UserModel;
use main\app\model\agile\SprintModel;

/**
 * 基础配置信息逻辑类
 * @package main\app\classes
 */
class ConfigLogic
{
    /**
     * 获取所有的配置项
     * @param $data
     * @throws \Exception
     */
    public static function getAllConfigs(&$data)
    {
        $projectId = null;
        if (isset($data['project_id'])) {
            $projectId = $data['project_id'];
        }

        $data['priority'] = self::getPriority(true);
        $data['issue_types'] = self::getTypes(true);
        $data['issue_status'] = self::getStatus(true);
        $data['issue_resolve'] = self::getResolves(true);
        $data['users'] = self::getAllUser(true);
        $data['projects'] = self::getAllProjects();
        $data['project_modules'] = self::getModules($projectId, true);
        $data['project_versions'] = self::getVersions($projectId, true);
        $data['project_labels'] = self::getLabels($projectId, true);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getUsers()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        return $users;
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getAllUser($primaryKey = false)
    {
        $userModel = new UserModel();
        $users = $userModel->getAll($primaryKey);
        foreach ($users as &$user) {
            unset($user['password']);
            $user = UserLogic::format($user);
        }
        return $users;
    }

    /**
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getModules($projectId, $primaryKey = false)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new ProjectModuleModel();
        $rows = $model->getByProject($projectId, $primaryKey);
        foreach ($rows as &$row) {
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

    /**
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getVersions($projectId, $primaryKey = false)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new ProjectVersionModel();
        $rows = $model->getByProject($projectId, $primaryKey);
        //print_r($rows);
        foreach ($rows as $k => &$row) {
            if (!isset($row['id'])) {
                $row['id'] = $k;
            }
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

    /**
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getLabels($projectId = null, $primaryKey = false)
    {
        $model = new ProjectLabelModel();
        $rows = $model->getByProject($projectId, $primaryKey);
        return $rows;
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getAllProjects($primaryKey = false)
    {
        $projectModel = new ProjectModel();
        return $projectModel->getAll($primaryKey);
    }

    /**
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function getSprints($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new SprintModel();
        $rows = $model->getItemsByProject($projectId);
        foreach ($rows as &$row) {
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getResolves($primaryKey = false)
    {
        $model = new IssueResolveModel();
        return $model->getAllItem($primaryKey);
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getTypes($primaryKey = false)
    {
        $model = new IssueTypeModel();
        return $model->getAllItem($primaryKey);
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getStatus($primaryKey = false)
    {
        $model = new IssueStatusModel();
        return $model->getAllItem($primaryKey);
    }

    /**
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getPriority($primaryKey = false)
    {
        $model = new IssuePriorityModel();
        return $model->getAllItem($primaryKey);
    }

}
