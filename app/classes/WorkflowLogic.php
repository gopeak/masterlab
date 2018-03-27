<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\WorkflowModel;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\issue\WorkflowSchemeDataModel;
use main\app\model\user\UserModel;

class WorkflowLogic
{
    public function getAdminWorkflow()
    {
        $workflowModel = new WorkflowModel();
        $workflowTable = $workflowModel->getTable();

        $workflowSchemeDataModel = new WorkflowSchemeDataModel();
        $workflowSchemeDataTable = $workflowSchemeDataModel->getTable();

        $userModel = new UserModel();
        $userTable = $userModel->getTable();

        $sql = "Select w.* ,GROUP_CONCAT(s.scheme_id ) as scheme_ids ,u.display_name From {$workflowTable} w 
                Left join {$workflowSchemeDataTable} s on s.workflow_id=w.id 
                Left join {$userTable} u on w.update_uid=u.uid 
                Group by w.id 
                Order by w.id ASC ";

        $rows = $workflowModel->db->getRows($sql);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['update_time_text'] = format_unix_time($row['update_time']);
                $row['create_time_text'] = format_unix_time($row['create_time']);
            }
        }
        return $rows;
    }


    public function getAdminWorkflowSchemes()
    {
        $workflowSchemeModel = new WorkflowSchemeModel();
        $workflowSchemeTable = $workflowSchemeModel->getTable();

        $workflowSchemeDataModel = new WorkflowSchemeDataModel();
        $workflowSchemeDataTable = $workflowSchemeDataModel->getTable();

        $sql = "SELECT
                    ws.*,
                    GROUP_CONCAT(CONCAT('->',wsd.issue_type_id,wsd.workflow_id,wsd) AS workflow_ids
                FROM
                    {$workflowSchemeTable} ws
                LEFT JOIN {$workflowSchemeDataTable} wsd ON ws.id = wsd.scheme_id 
                GROUP BY ws.id";

        return $workflowSchemeModel->db->getRows($sql);
    }

    public function updateSchemeTypesWorkflow($scheme_id, $json)
    {
        // var_dump($json);
        if (empty($json)) {
            return [false,'data_is_empty'];
        }
        $model = new WorkflowSchemeDataModel();
        try {
            $model->db->beginTransaction();
            $model->deleteBySchemeId($scheme_id);
            $rowsAffected = 0;
            if (!empty($json)) {
                $data = [];
                foreach ($json as $arr) {
                    $info = [];
                    $info['scheme_id'] = $scheme_id;
                    $info['issue_type_id'] = $arr['issue_type_id'];
                    $info['workflow_id'] = $arr['workflow_id'];
                    $data [] = $info;
                }
                $rowsAffected = $model->insertRows($data);
            }
            $model->db->commit();
            return [true,$rowsAffected];
        } catch (\PDOException $e) {
            $model->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true,'ok'];
    }
}
