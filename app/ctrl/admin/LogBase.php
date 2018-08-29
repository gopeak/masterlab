<?php

namespace main\app\ctrl\admin;


use main\app\ctrl\BaseAdminCtrl;
use main\app\model\LogBaseModel;
use main\app\classes\LogLogic;


/**
 * 系统操作日志控制器
 */
class LogBase extends BaseAdminCtrl
{

    /**
     * 操作日志入口页面
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'log';
        $data['left_nav_active'] = 'log_base';
        $data['actions'] = LogBaseModel::getActions();
        $this->render('gitlab/admin/log_base_list.php', $data);
    }

    /**
     * 过滤数据
     * @param string $username
     * @param string $action
     * @param string $remark
     * @param int $page
     * @param int $page_size
     * @throws \Exception
     */
    public function filter($username = '', $action = '', $remark = '', $page = 1, $page_size = 20)
    {
        $pageSize = intval($page_size);
        $username = trimStr($username);

        $logLogic = new LogLogic();
        $ret = $logLogic->filter($username, $action, $remark, $page, $pageSize);
        list($logs, $total) = $ret;
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['logs'] = array_values($logs);
        $this->ajaxSuccess('', $data);
    }

    /**
     * 日志详情
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function get($id)
    {
        if (empty($id)) {
            $this->ajaxFailed(' 参数错误 ', 'id不能为空');
        }

        $logModel = new LogBaseModel();
        $log = $logModel->getById((int)$id);

        $preData = $log['pre_data'];
        $curData = $log['cur_data'];

        $detail = [];

        if (empty($preData) || empty($curData)) {
            return $detail;
        }

        $i = 0;
        foreach ($preData as $key => $val) {
            $detail[$i]['field'] = $key;
            $detail[$i]['before'] = $val;
            $detail[$i]['now'] = $curData[$key];
            $detail[$i]['code'] = $val != $curData[$key] ? 1 : 0;
            $i++;
        }

        $data['detail'] = $detail;
        $this->ajaxSuccess('', $data);
    }

}
