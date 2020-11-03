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
use main\app\model\project\ProjectRoleModel;
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

        $data['priority'] = self::getPriority();
        $data['issue_types'] = self::getTypes();
        $data['issue_status'] = self::getStatus();
        $data['issue_resolve'] = self::getResolves();
        $data['users'] = self::getAllUser();
        $data['projects'] = self::getJoinProjects();
        $data['project_users'] = self::getProjectUsers($projectId);
        $data['project_modules'] = self::getModules($projectId );
        $data['project_versions'] = self::getVersions($projectId);
        $data['project_labels'] = self::getLabels($projectId);
        $data['project_sprints'] = self::getSprints($projectId);

        $logic = new IssueTypeLogic();
        $data['project_issue_types'] = $logic->getIssueType($projectId);
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
     * 加入到项目的成员
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function getProjectUsers($projectId){
        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);
        $ret = [];
        foreach ($projectUsers as $user) {
            $ret[] = UserLogic::format($user);
        }
        return $ret;
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
        $model = new ProjectModuleModel();
        if (empty($projectId)) {
            $rows = $model->getAll($primaryKey);
        }else{
            $rows = $model->getByProject($projectId, $primaryKey);
        }

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
     * @param null $projectId
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getProjectRoles($projectId = null, $primaryKey = false)
    {
        $model = new ProjectRoleModel();
        $rows = $model->getsByProject($projectId, $primaryKey);
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
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getJoinProjects($primaryKey = false)
    {
        $widgetLogic = new WidgetLogic();
        return $widgetLogic->getUserHaveJoinProjects(1000);
    }

    /**
     * @param null $projectId
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public static function getSprints($projectId = null, $primaryKey = false)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new SprintModel();
        $rows = $model->getItemsByProject($projectId, $primaryKey);
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
