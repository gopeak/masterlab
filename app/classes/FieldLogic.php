<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueTypeSchemeItemsModel;

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
}
