<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:11
 */

namespace main\app\classes;

use main\app\model\LogOperatingModel;
use main\app\model\user\UserModel;

/**
 * 日志业务逻辑
 *
 */
class LogOperatingLogic
{

    const ACT_ADD = '新增';
    const ACT_EDIT = '编辑';
    const ACT_DELETE = '删除';

    const MODULE_NAME_ORG = '组织';
    const MODULE_NAME_PROJECT = '项目';
    const MODULE_NAME_ISSUE = '事项';
    const MODULE_NAME_ADMIN = '系统';
    const MODULE_NAME_USER = '用户';

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

        $logOperatingModel = new LogOperatingModel();

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

        $table = $logOperatingModel->getTable() . '  ';

        // 获取总数
        $sqlCount = "SELECT count(id) as cc FROM  {$table} " . $sql;
        //var_dump($sqlCount,$params);
        $count = $logOperatingModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$table} " . $sql;
        $sql .= ' ' . $order . $limit;

        $logs = $logOperatingModel->db->getRows($sql, $params);


        unset($logOperatingModel);

        if (!empty($logs)) {
            foreach ($logs as &$row) {
                $row['time_str'] = format_unix_time($row['time'], 0, 'full_datetime_format');
            }
        }
        return [$logs, $count];
    }


    /**
     * 根据用户ID获取相关操作日志，分页模式
     * @param $uid
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public function getLogsByUid($uid = 0, $page = 1, $pageSize = 20)
    {
        $field = "*";
        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = " Order By  time  DESC";

        $logOperatingModel = new LogOperatingModel();

        $sql = "  WHERE 1 ";
        $params = [];


        if ($uid) {
            $params['uid'] = $uid;
            $sql .= " AND uid=:uid  ";
        }

        $table = $logOperatingModel->getTable() . '  ';

        // 获取总数
        $sqlCount = "SELECT count(id) as cc FROM  {$table} " . $sql;
        //var_dump($sqlCount,$params);
        $count = $logOperatingModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$table} " . $sql;
        $sql .= ' ' . $order . $limit;

        $logs = $logOperatingModel->db->getRows($sql, $params);


        unset($logOperatingModel);

        if (!empty($logs)) {
            foreach ($logs as &$row) {
                $row['show_date'] = format_unix_time($row['time'], 0);
                $row['show_date_title'] = format_unix_time($row['time'], 0, 'full_datetime_format');
            }
        }
        return [$logs, $count];
    }


    /**
     * 记录日志
     *
     * @param array $arr 处理前数据
     * @param int $uid 用户id
     * @param int $projectId 项目id
     * @return array
     */
    public static function add($uid = 0, $projectId = 0, $arr = [])
    {
        $fileds = [ 'user_name', 'real_name', 'obj_id', 'module',
                    'page', 'action', 'remark', 'pre_data', 'cur_data'];

        if (empty($uid) || empty($arr)) {
            return [false, 'uid or arr is empty'];
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
            return [false, 'user is null'];
        }

        //组装日志内容
        $log = new \stdClass();
        $log->uid = $uid;
        $log->user_name = $data['user_name'];
        $log->real_name = $data['real_name'];
        $log->obj_id = $data['obj_id'];
        $log->module = $data['module'];
        $log->page = $data['page'];
        $log->action = $data['action'];
        $log->remark = $data['remark'];
        $log->pre_data = $data['pre_data'];
        $log->cur_data = $data['cur_data'];
        $log->ip = getIp();
        $log->project_id = $projectId;

        //初始化操作日志model
        $logOperatingModel = new LogOperatingModel();
        $result = $logOperatingModel->add($log);

        unset($logOperatingModel);

        return $result;
    }
}
