<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:11
 */

namespace main\app\classes;

use main\app\model\LogBaseModel;

/**
 * 日志业务逻辑
 *
 */
class LogLogic
{
    /**
     * 每页显示数
     * @var int
     */
    public $pageSize = 20;

    public function __construct($pageSize = 20)
    {
        $this->pageSize = $pageSize;
    }

    public function getPageHtml($conditions, $page)
    {
        $logModel = LogBaseModel::getInstance();
        $total = $logModel->getCount($conditions);
        $pages = ceil($total / $this->pageSize);
        return getPageStrByAjax($pages, $page, $this->pageSize);
    }


    /**
     * 根据条件获取日志内容,并按照视图需要格式化数据
     * @param $conditions
     * @param $page
     * @param $remark
     * @param $order_by
     * @param $sort
     * @return array
     */
    public function query($conditions, $page, $remark, $order_by, $sort)
    {
        $start = $this->pageSize * ($page - 1);
        $order = empty($order_by) ? '' : " $order_by ";
        $limit = " $start, " . $this->pageSize;
        $append_sql = null;
        if ($remark != '') {
            $append_sql = "  locate( '{$remark}',remark) > 0 ";
        }
        $logModel = LogBaseModel::getInstance();

        $logs = $logModel->getRows($logModel->fields, $conditions, $append_sql, $order, $sort, $limit);

        $i = max(0, ($page - 1) * $this->pageSize);
        foreach ($logs as &$log) {
            $i++;
            $log['i'] = $i;
            $log['time_str'] = format_unix_time($log['time']);
        }

        return $logs;
    }
}
