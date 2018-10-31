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

class ConfigLogic
{
    /**
     * @param $data
     * @throws \Exception
     */
    public static function getAllConfigs(&$data)
    {
        $model = new IssuePriorityModel();
        $data['priority'] = $model->getAll();
        unset($model);

        $issueTypeModel = new IssueTypeModel();
        $data['issue_types'] = $issueTypeModel->getAll();
        unset($issueTypeModel);

        $model = new IssueStatusModel();
        $data['issue_status'] = $model->getAll();
        unset($model);

        $model = new IssueResolveModel();
        $data['issue_resolve'] = $model->getAll();
        unset($model);

        $userModel = new UserModel();
        $users = $userModel->getAll();
        foreach ($users as &$user) {
            unset($user['password']);
            $user = UserLogic::format($user);
        }
        $data['users'] = $users;

        $projectModel = new ProjectModel();
        $data['projects'] = $projectModel->getAll(false);
        unset($projectModel);

        $projectModuleModel = new ProjectModuleModel();
        $data['project_modules'] = $projectModuleModel->getAll();
        unset($projectModuleModel);

        // @TODO 只获取某一个项目的
        $projectVersionModel = new ProjectVersionModel();
        $data['project_versions'] = $projectVersionModel->getAll();
        unset($projectModuleModel);

        $projectLabelModel = new ProjectLabelModel();
        $data['project_labels'] = $projectLabelModel->getAll();
        unset($projectLabelModel);
    }

    public function getStatus()
    {
        $issueStatusModel = new IssueStatusModel();
        return $issueStatusModel->getAllItem(false);
    }

    public function getUsers()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        return $users;
    }

    public function getModules($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new ProjectModuleModel();
        $rows = $model->getByProject($projectId);
        foreach ($rows as &$row) {
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

    public function getSprints($projectId)
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

    public function getResolves()
    {
        $model = new IssueResolveModel();
        return $model->getAllItem(false);
    }

    public function getPriority()
    {
        $model = new IssuePriorityModel();
        return $model->getAllItem(false);
    }

    public function getLabels()
    {
        $model = new ProjectLabelModel();
        return $model->getAllItems(false);
    }

    public function getVersions($projectId)
    {
        $model = new ProjectVersionModel();
        $table = $model->getTable();
        $sql = "Select *  From {$table}   Where project_id=:project_id  Order by sequence DESC, id  ASC ";
        $params['project_id'] = $projectId;
        $rows = $model->db->getRows($sql, $params);
        foreach ($rows as &$row) {
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }
}
