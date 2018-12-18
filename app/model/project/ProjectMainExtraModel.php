<?php

namespace main\app\model\project;

use main\app\classes\ProjectLogic;
use main\app\model\CacheModel;

/**
 *   项目信息扩展表模型
 */
class ProjectMainExtraModel extends CacheModel
{
    public $prefix = 'project_';
    public $table = 'main_extra';
    const   DATA_KEY = 'project_main_extra/';

    protected static $instance;

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    public function updateByProjectId($updateInfo, $projectId)
    {
        $where = ['project_id' => $projectId];
        $flag = $this->update($updateInfo, $where);
        return $flag;
    }

    public function getByProjectId($projectId)
    {
        $fields = "*";
        $where = ['project_id' => $projectId];
        $row = $this->getRow($fields, $where);
        return $row;
    }

}
