<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\WorkflowBlockModel;

class IssueStatusLogic
{
    public function getAdminIssueStatus()
    {
        $issueStatusModel = new IssueStatusModel();
        $issueStatusTable = $issueStatusModel->getTable();

        $workflowBlockModel = new WorkflowBlockModel();

        $sql = "Select t.*  From {$issueStatusTable} t 
                Group by t.id 
                Order by t.id ASC ";
        return  $issueStatusModel->db->fetchAll($sql);
    }

    public function getStatus()
    {
        $issueStatusModel = new IssueStatusModel();
        $issueStatusTable = $issueStatusModel->getTable();
        $sql = "Select *  From {$issueStatusTable}   Order by sequence DESC, id ASC ";
        return  $issueStatusModel->db->fetchAll($sql);
    }

    /**
     * 获取所有事项的Status的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @return array
     * @throws \Exception
     */
    public static function getAllIssueStatusNameAndId()
    {
        $model = new IssueStatusModel();
        $originalRes = $model->getAllItem(false);
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }

}
