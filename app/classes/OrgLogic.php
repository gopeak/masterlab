<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\OrgModel;

class OrgLogic
{
    /**
     * 获取所有的组织信息
     * @return array
     */
    public function getOrigins()
    {
        $model = new OrgModel();
        $rows = $model->getAllItems();
        foreach ($rows as &$row) {
            if (strpos($row['avatar'], 'http://') === false) {
                $row['avatar'] = ROOT_URL . $row['avatar'];
            }
        }
        return $rows;
    }
}
