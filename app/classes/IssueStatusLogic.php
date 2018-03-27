<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\WorkflowSchemeDataModel;
use main\app\model\user\UserProjectRoleModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\WorkflowBlockModel;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;

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
        $sql = "Select *  From {$issueStatusTable}    Order by sequence DESC, id ASC ";
        return  $issueStatusModel->db->getRows($sql);

    }
}
