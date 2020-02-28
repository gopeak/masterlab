<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\project\ProjectModuleModel;

class FieldLogic
{
    public function updateSchemeTypes($schemeId, $types)
    {
        if (empty($types)) {
            return [false,'data_is_empty'];
        }
        $model = new IssueTypeSchemeItemsModel();
        try {
            $model->db->beginTransaction();
            $model->deleteBySchemeId($schemeId);
            $rowsAffected = 0;
            if (!empty($types)) {
                $infoArr = [];
                foreach ($types as $gid) {
                    $info = [];
                    $info['scheme_id'] = $schemeId;
                    $info['type_id'] = $gid;
                    $infoArr [] = $info;
                }
                $rowsAffected = $model->insertRows($infoArr);
            }
            $model->db->commit();
            return [true,$rowsAffected];
        } catch (\PDOException $e) {
            $model->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true,'ok'];
    }

    /**
     * 返回ID和name的映射
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getSprintMapByProjectID($projectId)
    {
        $sprintMap = [];
        $sprintModel = new SprintModel();
        $rows = $sprintModel->getItemsByProject($projectId, true);
        if (!empty($rows)) {
            foreach ($rows as $key => $row) {
                $sprintMap[$key] = $row['name'];
            }
        }
        return $sprintMap;
    }

    /**
     * 返回ID和name的映射
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getModuleMapByProjectID($projectId)
    {
        $moduleMap = [];
        $projectModuleModel = new ProjectModuleModel();
        $rows = $projectModuleModel->getByProject($projectId, true);
        if (!empty($rows)) {
            foreach ($rows as $key => $row) {
                $moduleMap[$key] = $row['name'];
            }
        }
        return $moduleMap;
    }
}
