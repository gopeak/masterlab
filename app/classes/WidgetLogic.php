<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\WidgetModel;

/**
 * 面板逻辑类
 * Class WidgetLogic
 * @package main\app\classes
 */
class WidgetLogic
{
    /**
     * 获取可用的面板列表
     * @return array
     */
    public function getAvailableWidget()
    {
        $model = new WidgetModel();
        $rows = $model->getAllItems();
        $widgetArr = [];
        foreach ($rows as $row) {
            if ($row['status'] == '1') {
                $row['pic'] = ROOT_URL.'gitlab/images/widget/'.$row['pic'];
                $row['parameter'] = json_decode($row['parameter']);
                $widgetArr[] = $row;
            }
        }
        return $widgetArr;
    }
}
