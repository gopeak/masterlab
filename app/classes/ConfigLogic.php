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
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\issue\IssueStatusModel;

class ConfigLogic
{
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
