<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:11
 */

namespace main\app\classes;

use main\app\model\system\MailQueueModel;
use main\app\model\UserModel;

/**
 * 邮件队列逻辑
 *
 */
class MailQueueLogic
{
    /**
     * 每页显示数
     * @var int
     */
    public $pageSize = 50;

    public function __construct($pageSize = 50)
    {
        $this->pageSize = $pageSize;
    }

    public function getPageInfo($conditions, $page)
    {
        $logModel = MailQueueModel::getInstance();
        $total = $logModel->getCount($conditions);
        $pages = (int)ceil($total / $this->pageSize);
        return [$total, $pages, $page, getPageStrByAjax($pages, $page, $this->pageSize), $this->pageSize];
    }

    /**
     * 根据条件获取队列内容,并按照视图需要格式化数据
     * @param $conditions
     * @param $page
     * @param $orderBy
     * @param $sort
     * @return array
     */
    public function query($conditions, $page, $orderBy, $sort)
    {
        $start = $this->pageSize * ($page - 1);
        $order = empty($orderBy) ? '' : " $orderBy ";
        $limit = " $start, " . $this->pageSize;
        $append_sql = null;
        $logModel = MailQueueModel::getInstance();

        $logs = $logModel->getRows($logModel->fields, $conditions, $append_sql, $order, $sort, $limit);

        $i = max(0, ($page - 1) * $this->pageSize);
        foreach ($logs as &$log) {
            $i++;
            $log['i'] = $i;
            $log['time_text'] = format_unix_time($log['create_time']);
        }
        return $logs;
    }

    /**
     * 添加队列
     * @param string $address
     * @param string $title
     * @param null $status
     * @param string $error
     * @return array
     */
    public static function add($address, $title, $status = null, $error = '')
    {
        //组装日志内容
        $log = new \stdClass();
        $log->address = $address;
        $log->title = $title;
        $log->status = $status;
        $log->error = $error;
        $log->create_time = time();

        //初始化日志model
        $logModel = new MailQueueModel();
        return $logModel->add($log);
    }

    /**
     * 更新队列
     * @param $id
     * @param null $status
     * @param string $error
     * @return array
     */
    public static function updateQueue($id, $status = null, $error = '')
    {
        $info = [];
        if (in_array($status, MailQueueModel::getStatus())) {
            $info['status'] = $status;
        } else {
            return [false, $status . ' error'];
        }
        if (!empty($error)) {
            $info['error'] = $error;
        }

        if (empty($info)) {
            return [false, 'param_is_empty'];
        }

        //初始化日志model
        $logModel = new MailQueueModel();
        return $logModel->updateById($id, $info);
    }
}
