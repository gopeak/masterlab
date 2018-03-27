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
 * 用户业务逻辑
 *
 */
class LogLogic
{
    /**
     * 每页显示数
     * @var int
     */
    public $page_size = 20;

    public function __construct(int $page_size=20)
    {
        $this->page_size = $page_size;
    }

    public function getPageHtml($conditions, $page)
    {
        $logModel = LogBaseModel::getInstance();
        $total = $logModel->getCount($conditions);
        $pages = ceil($total / $this->page_size);
        return  getPageStrByAjax($pages, $page, $this->page_size);
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
        $start = $this->page_size*($page-1);
        $order  = empty($order_by) ? '' : " $order_by $sort";
        $limit = " $start, ".$this->page_size;
        $append_sql = null;
        if ($remark!='') {
            $append_sql = "  locate( '{$remark}',remark) > 0 ";
        }
        $logModel = LogBaseModel::getInstance();

        $logs    = $logModel->getRows($logModel->fields, $conditions, $append_sql, $order, $sort, $limit);

        $i = max(0, ($page-1)*$this->page_size);
        foreach ($logs as &$log) {
            $i++;
            $log['i'] = $i;
            $log['time_str'] = format_unix_time($log['time']);
        }

        return $logs;
    }
}
