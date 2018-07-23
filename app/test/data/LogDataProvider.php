<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/26 0026
 * Time: 下午 5:57
 */

namespace main\app\test\data;

use main\app\model\LogBaseModel;

/**
 * 为日志模块提供测试数据
 * Class LogDataProvider
 */
class LogDataProvider
{
    const UID = 9999999;

    const OBJ_ID = 888888;

    const USER_NAME = 'unit_username';

    /**
     * 初始化日志数据
     * @return  array
     */
    public static function initLogs($pageSize, $uid = 0, $companyId = 0)
    {
        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time() - 10;
        $pre_data['f3'] = 'google';

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';

        $obj_id = static::OBJ_ID;
        if ($uid == 0) {
            $uid = static::UID;
        }


        $logs = [];

        $logModel = LogBaseModel::getInstance();
        for ($i = 0; $i < 3 * $pageSize; $i++) {
            $log = new \stdClass();
            $log->uid = $uid;
            $log->user_name = self::USER_NAME;
            $log->real_name = self::USER_NAME;
            $log->obj_id = $obj_id;
            $log->module = '日志';
            $log->page = '操作日志';
            $log->action = LogBaseModel::ACT_ADD;
            $log->remark = '日志插入测试';
            $log->pre_data = $pre_data;
            $log->cur_data = $cur_data;

            list($ret, $insert_id) = $logModel->add($log);
            if ($ret) {
                $log->id = $insert_id;
                $logs[] = $log;
            } else {
                echo $insert_id . "\n";
            }
        }
        return $logs;
    }

    /**
     * 清除日志
     */
    public static function clearLogs($uid = 0)
    {
        if ($uid == 0) {
            $uid = static::UID;
        }
        $logModel = LogBaseModel::getInstance();
        $conditions['uid'] = $uid;
        $logModel->delete($conditions);
    }
}
