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

        $wfSchemeDataModel = new WorkflowSchemeDataModel();
        $wfSchemeDataTable = $wfSchemeDataModel->getTable();

        $userModel = new UserModel();
        $userTable = $userModel->getTable();

        $sql = "Select w.*,GROUP_CONCAT(s.scheme_id ) as scheme_ids ,u.display_name From {$workflowTable} w 
                Left join {$wfSchemeDataTable} s on s.workflow_id=w.id 
                Left join {$userTable} u on w.update_uid=u.uid 
                Group by w.id 
                Order by w.id ASC ";
        //var_dump($sql);
        $rows = $workflowModel->db->getRows($sql);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['update_time_text'] = format_unix_time($row['update_time']);
                $row['create_time_text'] = format_unix_time($row['create_time']);
            }
        }
        return $rows;
    }

    /**
     * @param $schemeId
     * @param $json
     * @return array
     */
    public function updateSchemeTypesWorkflow($schemeId, $json)
    {
        // var_dump($json);
        if (empty($json)) {
            return [false, 'data_is_empty'];
        }
        $model = new WorkflowSchemeDataModel();
        try {
            $model->db->beginTransaction();
            $model->deleteBySchemeId($schemeId);
            $rowsAffected = 0;
            if (!empty($json)) {
                $data = [];
                foreach ($json as $arr) {
                    $info = [];
                    $info['scheme_id'] = $schemeId;
                    $info['issue_type_id'] = $arr['issue_type_id'];
                    $info['workflow_id'] = $arr['workflow_id'];
                    $data [] = $info;
                }
                $rowsAffected = $model->insertRows($data);
            }
            $model->db->commit();
            return [true, $rowsAffected];
        } catch (\PDOException $e) {
            $model->db->rollBack();
            return [false, $e->getMessage()];
        }
    }
}
