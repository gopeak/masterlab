<?php

namespace main\app\ctrl;

use main\app\classes\ConfigLogic;

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

    public function users()
    {
        $configLogic = new ConfigLogic();
        $users = $configLogic->getUsers();
        sort($users);
        header('Content-Type:application/json');
        echo json_encode($users);
        die;
    }

    public function status()
    {
        $configLogic = new ConfigLogic();
        $status = $configLogic->getStatus();
        header('Content-Type:application/json');
        echo json_encode($status);
        die;
    }

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
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getSprints($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    public function resolve()
    {
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getResolves();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    public function priority()
    {
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getPriority();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

    public function labels()
    {
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getLabels();
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }

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
        $configLogic = new ConfigLogic();
        $rows = $configLogic->getVersions($projectId);
        header('Content-Type:application/json');
        echo json_encode($rows);
        die;
    }
}

