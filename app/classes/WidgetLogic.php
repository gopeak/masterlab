<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\WidgetModel;

class WidgetLogic
{
    public function getAvailableWidget()
    {
        $model = new WidgetModel();
        $rows = $model->getAllItems();
        $widgetArr = [];
        foreach ($rows as $row) {
            if ($row['status'] == '1') {
                $row['pic'] = ROOT_URL.'gitlab/images/widget/'.$row['pic'];
                $widgetArr[] = $row;
            }
        }
        return $widgetArr;
    }
}
