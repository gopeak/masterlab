<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:11
 */

namespace main\app\classes;


use main\app\ctrl\admin\User;
use main\app\model\LogBaseModel;
use main\app\model\user\UserModel;

/**
 * 日志业务逻辑
 *
 */
class LogLogic
{

    const ACT_ADD = '新增';
    const ACT_EDIT = '编辑';
    const ACT_DELETE = '删除';

    /**
     * 根据条件获取日志内容,并按照视图需要格式化数据
     * @param $username
     * @param $action
     * @param $remark
     * @param $page
     * @param $page_size
     * @return array
     */

    public function filter($username = '', $action = '', $remark = '', $page = 1, $pageSize = 20)
    {
        $field = "*";
        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = " Order By  time  DESC";

        $logModel = new LogBaseModel();

        $sql = "   WHERE 1 ";
        $params = [];


        if (!empty($username)) {
            $params['user_name'] = $username;
            $params['real_name'] = $username;
            $sql .= " AND ( locate( :user_name,user_name) > 0  || locate( :real_name,real_name) > 0 )   ";
        }

        if (!empty($action)) {
            $params['action'] = $action;
            $sql .= " AND ( locate( :action,action) > 0 )   ";
        }

        if (!empty($remark)) {
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
            foreach ($logs as &$row) {
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
     * @return array
     */
    public static function add($remark, $pre_data = [], $cur_data = [],
                               $obj_id = 0, $module = "日志", $action = LogBaseModel::ACT_ADD, $page = '',
                               $uid = 0)
    {

        if (empty($uid)) {
            return [false,'current $uid is empty'];
        }
        $userInfo = UserModel::getInstance()->getByUid($uid);
        if (empty($userInfo)) {
            return [false,'current $userInfo is empty'];
        }

        //组装日志内容
        $log = new \stdClass();
        $log->uid = $uid;
        $log->user_name = $userInfo['username'];;
        $log->real_name = $userInfo['display_name'];;
        $log->obj_id = $obj_id;
        $log->module = $module;
        $log->page = $page;
        $log->action = $action;
        $log->remark = $remark;
        $log->pre_data = $pre_data;
        $log->cur_data = $cur_data;
        $log->ip = getIp();

        //初始化日志model
        $logModel = new LogBaseModel();
        return $logModel->add($log);
    }

    /**
     * 记录日志
     *
     * @param array $data 处理前数据
     * @param int $uid 用户id
     * @param int $projectId 项目id
     * @return array
     */
    public static function addByArr($uid = 0, $projectId = 0, $arr = [])
    {
        $fileds = ['user_name', 'real_name', 'obj_id', 'module',
            'page', 'action', 'remark', 'pre_data', 'cur_data'];

        if (empty($uid) || empty($arr)) {
            return false;
        }

        $data = [];
        foreach ($fileds as $filed) {
            $data[$filed] = '';
            if (isset($arr[$filed])) {
                $data[$filed] = $arr[$filed];
            }
        }

        $userInfo = UserModel::getInstance()->getByUid($uid);

        if (empty($userInfo)) {
            return false;
        }


        //组装日志内容
        $log = new \stdClass();
        $log->uid = $uid;
        $log->user_name = $data['user_name'];
        $log->real_name = $data['real_name'];
        $log->obj_id = $data['obj_id'];
        $log->module = $data;
        $data['module'];
        $log->page = $data['page'];
        $log->action = $data['action'];
        $log->remark = $data['remark'];
        $log->pre_data = $data['pre_data'];
        $log->cur_data = $data['cur_data'];
        $log->ip = getIp();
        $log->project_id = $projectId;

        //初始化日志model
        $logModel = new LogBaseModel();
        $result = $logModel->add($log);

        unset($logModel);

        return $result;
    }
}
