<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:11
 */

namespace main\app\classes;

use main\app\model\LogBaseModel;
use main\app\model\user\UserModel;

/**
 * 日志业务逻辑
 *
 */
class LogLogic
{


    /**
     * 根据条件获取日志内容,并按照视图需要格式化数据
     * @param $username
     * @param $action
     * @param $remark
     * @param $page
     * @param $page_size
     * @return array
     */

    public function filter($username = '',$action = '',$remark = '',$page = 1,$pageSize = 20)
    {
        $field = "*";
        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = " Order By  time  DESC";

        $logModel = new LogBaseModel();

        $sql = "   WHERE 1 ";
        $params = [];


        if (!empty($username))
        {
            $params['user_name'] = $username;
            $params['real_name'] = $username;
            $sql .= " AND ( locate( :user_name,user_name) > 0  || locate( :real_name,real_name) > 0 )   ";
        }

        if (!empty($action))
        {
            $params['action'] = $action;
            $sql .= " AND ( locate( :action,action) > 0 )   ";
        }

        if (!empty($remark))
        {
            $params['remark'] = $remark;
            $sql .= " AND ( locate( :remark,remark) > 0 )   ";
        }

        $table = $logModel->getTable() . '  ';

        // 获取总数
        $sqlCount = "SELECT count(id) as cc FROM  {$table} " . $sql;
        //var_dump($sqlCount,$params);
        $count = $logModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$table} " . $sql;
        $sql .= ' ' . $order . $limit;

        $logs = $logModel->db->getRows($sql, $params);


        unset($logModel);

        if (!empty($logs)) {
            foreach ($logs as &$row)
            {
                $row['time_str'] = format_unix_time($row['time']);
            }
        }
        return [$logs, $count];
    }


    /**
     * 记录日志
     *
     * @param $remark 日志内容
     * @param array $pre_data 处理前数据
     * @param array $cur_data 处理后数据
     * @param int $obj_id 操作记录所关联的对象id,如现货id 订单id
     * @param string $module 模块
     * @param string $action 操作
     * @param string $page 页面名称
     * @param int $uid 用户id
     * @param int $company_id 企业id
     * @return array
     */
    public static function add($remark, $pre_data = [], $cur_data = [], $obj_id = 0, $module = "日志", $action = LogBaseModel::ACT_ADD, $page = '',$uid = 0, $company_id = 0)
    {
        $username = '';
        $realname = '';
        if (!empty($uid)) {
            $userModel = DB::table(UserModel::TABLE_NAME)->where('uid', $uid)->first();
            if (!empty($userModel)) {
                $username = $userModel['username'];
                $realname = $userModel['realname'];

                if (empty($company_id)) {
                    $company_id = $userModel['company_id'];
                }
            }
        }

        //组装日志内容
        $log = new \stdClass();
        $log->uid = $uid;
        $log->user_name = $username;
        $log->real_name = $realname;
        $log->obj_id = $obj_id;
        $log->module = $module;
        $log->page = $page;
        $log->action = $action;
        $log->remark = $remark;
        $log->pre_data = $pre_data;
        $log->cur_data = $cur_data;
        $log->company_id = $company_id;

        //初始化日志model
        $logModel = new LogBaseModel();
        return $logModel->add($log);
    }
}
