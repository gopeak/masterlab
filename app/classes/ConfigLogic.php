<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueLabelModel;
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
        $issueStatusTable = $issueStatusModel->getTable();
        $sql = "Select *  From {$issueStatusTable}    Order by sequence DESC, id ASC ";
        return $issueStatusModel->db->getRows($sql);
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
        foreach( $rows as &$row ){
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

    public function getResovels()
    {
        $model = new IssueResolveModel();
        $table = $model->getTable();
        $sql = "Select *  From {$table}    Order by sequence DESC, id ASC ";
        return $model->db->getRows($sql);
    }
    public function getPrioritys()
    {
        $model = new IssuePriorityModel();
        $table = $model->getTable();
        $sql = "Select *  From {$table}    Order by sequence DESC, id ASC ";
        return $model->db->getRows($sql);
    }

    public function getLabels()
    {
        $model = new IssueLabelModel();
        $table = $model->getTable();
        $sql = "Select *  From {$table}    Order by  id  ASC ";
        return $model->db->getRows($sql);
    }

    public function getVersions( $projectId )
    {
        $model = new ProjectVersionModel();
        $table = $model->getTable();
        $sql = "Select *  From {$table}   Where project_id=:project_id  Order by sequence DESC, id  ASC ";
        $params['project_id'] = $projectId;
        $rows =  $model->db->getRows($sql,$params);
        foreach( $rows as &$row ){
            $row['color'] = '';
            $row['title'] = $row['name'];
        }
        return $rows;
    }

}
