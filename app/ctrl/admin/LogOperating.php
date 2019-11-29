<?php

namespace main\app\ctrl\admin;


use main\app\classes\LogOperatingLogic;
use main\app\classes\SlowLogLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\LogOperatingModel;
use main\lib\SlowLog;


/**
 * 系统操作日志控制器
 */
class LogOperating extends BaseAdminCtrl
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
        $data['left_nav_active'] = 'log_operating';
        $data['actions'] = LogOperatingModel::getActions();
        $this->render('gitlab/admin/log_operating_list.php', $data);
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

        $logLogic = new LogOperatingLogic();
        $ret = $logLogic->filter($username, $action, $remark, $page, $pageSize);
        list($logs, $total) = $ret;

        unset($logLogic);

        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['logs'] = array_values($logs);
        $this->ajaxSuccess('', $data);
    }

    /**
     * 获取日志详情
     * @param $id
     * @throws \Exception
     */
    public function get($id)
    {
        if (empty($id)) {
            $this->ajaxFailed(' 参数错误 ', 'id不能为空');
        }

        $logModel = new LogOperatingModel();
        $log = $logModel->getById((int)$id);

        $preData = $log['pre_data'];
        $curData = $log['cur_data'];

        $detail = [];

        if (empty($curData)) {
            $this->ajaxSuccess('当前数据为空', []);
        }

        $i = 0;
        foreach ($curData as $key => $val) {
            $detail[$i]['field'] = $key;
            $detail[$i]['before'] = isset($preData[$key]) ? $preData[$key] : '';
            $detail[$i]['now'] = $val;
            if (isset($preData[$key])) {
                $detail[$i]['code'] = ($val != $preData[$key]) ? 1 : 0;
            } else {
                $detail[$i]['code'] = 1;
            }
            $i++;
        }

        $data['detail'] = $detail;
        $this->ajaxSuccess('操作成功', $data);
    }

    /**
     * sql慢查询日志页面
     */
    public function pageSlowSql()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'log';
        $data['left_nav_active'] = 'log_slow_sql';
        $data['actions'] = LogOperatingModel::getActions();

        $slowLog = SlowLog::getInstance();
        $files = $slowLog->getFolderFiles();
        $filesNameArr = array();
        if (!empty($files)) {
            foreach ($files as $file) {
                $filesNameArr[] = basename($file);
            }
        }

        arsort($filesNameArr);
        $data['log_files'] = $filesNameArr;

        $this->render('gitlab/admin/log_slow_sql_list.php', $data);
    }

    /**
     * @param $filename
     * @throws \Exception
     */
    public function fetchSlowSqlList($filename)
    {
        $slowLog = SlowLog::getInstance();
        $filelist = $slowLog->getFiles(true);
        if (in_array($filename, $filelist)) {
            $data['list'] = $slowLog->getView($filename);
            $this->ajaxSuccess('操作成功', $data);
        } else {
            $this->ajaxFailed('操作失败');
        }
    }
}
