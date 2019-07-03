<?php

namespace main\app\ctrl;

use main\app\classes\ConfigLogic;
use main\app\classes\SettingsLogic;

/**
 * 获取基础配置信息
 * @package main\app\ctrl
 */
class Config extends BaseCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {
        header("location:/");
    }

    /**
     * 返回所有的配置信息
     * @throws \Exception
     */
    public function all()
    {
        $data = [];
        $projectId = null;
        if (isset($data['project_id'])) {
            $projectId = $data['project_id'];
        }
        $primaryKey = false;
        if (isset($data['primary_key'])) {
            $primaryKey = $data['primary_key'];
        }

        list(, $data['settings']) = SettingsLogic::getsByModule();
        $unsetKeyArr = ['mail_password', 'company_phone', 'socket_server_host', 'socket_server_port'];
        if (!empty($data['settings'])) {
            foreach ($unsetKeyArr as $kk) {
                if (isset($data['settings'][$kk])) {
                    unset($data['settings'][$kk]);
                }
            }
        }
        $data['priority'] = ConfigLogic::getPriority($primaryKey);
        $data['issue_types'] = ConfigLogic::getTypes($primaryKey);
        $data['issue_status'] = ConfigLogic::getStatus($primaryKey);
        $data['issue_resolve'] = ConfigLogic::getResolves($primaryKey);
        $data['users'] = ConfigLogic::getAllUser($primaryKey);
        $data['projects'] = ConfigLogic::getAllProjects($primaryKey);
        $data['project_modules'] = ConfigLogic::getModules($projectId, $primaryKey);
        $data['project_versions'] = ConfigLogic::getVersions($projectId, $primaryKey);
        $data['project_labels'] = ConfigLogic::getLabels($projectId, $primaryKey);
        header('Content-Type:application/json');
        $this->ajaxSuccess('ok', $data);
        die;
    }

    /**
     * 获取所有的用户信息
     * @throws \Exception
     */
    public function users()
    {
        $configLogic = new ConfigLogic();
        $users = $configLogic->getUsers();
        sort($users);
        header('Content-Type:application/json');
        echo json_encode($users);
        die;
    }

    /**
     * 获取所有的状态信息
     * @throws \Exception
     */
    public function status()
    {
        $configLogic = new ConfigLogic();
        $status = $configLogic->getStatus();
        header('Content-Type:application/json');
        echo json_encode($status);
        die;
    }

    /**
     * 获取所有的项目模块信息，可指定项目id进行筛选
     * @throws \Exception
     */
    public function module()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = $_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }
        if ($projectId == null) {
            echo json_encode([]);
            die;
        }
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getModules($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取所有的迭代信息，可指定项目id进行筛选
     * @throws \Exception
     */
    public function sprint()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = $_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }
        if ($projectId == null) {
            echo json_encode([]);
            die;
        }
        $rows = ConfigLogic::getSprints($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取所有的解决结果信息
     * @throws \Exception
     */
    public function resolve()
    {
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getResolves();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取素有的优先级信息
     * @throws \Exception
     */
    public function priority()
    {
        $rows = ConfigLogic::getPriority();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取所有的标签信息，可指定项目id进行筛选
     * @throws \Exception
     */
    public function labels()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = $_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getLabels($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取所有的版本信息，可指定项目id进行筛选
     * @throws \Exception
     */
    public function version()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = $_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }
        if ($projectId == null) {
            echo json_encode([]);
            die;
        }
        $rows = ConfigLogic::getVersions($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    /**
     * 获取所有事项数据
     * @throws \Exception
     */
    public function issueType()
    {
        $rows = ConfigLogic::getTypes();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }
}
