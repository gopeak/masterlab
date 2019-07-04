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
        $workflowBlockTable = $workflowBlockModel->getTable();

        $sql = "Select t.* ,COUNT(b.workflow_id ) as workflow_count  From {$issueStatusTable} t 
                Left join {$workflowBlockTable} b on b.status_id=t.id 
                Group by t.id 
                Order by t.id ASC ";
        return  $issueStatusModel->db->getRows($sql);
    }

    public function getStatus()
    {
        $issueStatusModel = new IssueStatusModel();
        $issueStatusTable = $issueStatusModel->getTable();
        $sql = "Select *  From {$issueStatusTable}   Order by sequence DESC, id ASC ";
        return  $issueStatusModel->db->getRows($sql);
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
