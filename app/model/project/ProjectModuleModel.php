<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 *   项目模块模型
 */
class ProjectModuleModel extends CacheModel
{
    public $prefix = 'project_';

    public $table = 'module';

    const   DATA_KEY = 'project_module/';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);

        $this->uid = $uid;
    }

    /**
     * @param bool $primaryKey
     * @return array
     */
    public function getAll($primaryKey = true)
    {
        $table = $this->getTable();
        return $this->getRows($fields = "id as k,{$table}.*", $conditions = [], $append = null, $ordryBy = 'id',
            $sort = 'asc', $limit = null, $primaryKey);
    }

    /**
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     */
    public function getByProject($projectId, $primaryKey = false)
    {
        $fields = "*,{$this->primaryKey} as k";
        $params = ['project_id' => (int)$projectId];
        $rows = $this->getRows( $fields, $params,$append = null, $orderBy = null, $sort = null, $limit = null, $primaryKey );
        return $rows;
    }

    public function deleteByProject($projectId)
    {
        $where = ['project_id' => $projectId];
        $row = $this->delete($where);
        return $row;
    }

    public function removeById($projectId, $id)
    {
        $where = ['project_id' => $projectId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    public function getAllCount($projectId)
    {
        return $this->getCount(array('project_id' => $projectId));
    }

    /**
     * 检查名称是否已经存在
     * @param $projectId
     * @param $name
     * @return bool
     */
    public function checkNameExist($projectId, $name)
    {
        $table = $this->getTable();
        $conditions['project_id'] = $projectId;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where project_id=:project_id AND name=:name  ";
        $count = (int)$this->db->getOne($sql, $conditions);
        return $count > 0;
    }

    /**
     * 检查名称是否已经存在，除了指定的记录id
     * @param $id
     * @param $projectId
     * @param $name
     * @return bool
     */
    public function checkNameExistExcludeCurrent($id, $projectId, $name)
    {
        $table = $this->getTable();
        $conditions['id'] = $id;
        $conditions['project_id'] = $projectId;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND  project_id=:project_id AND name=:name  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count > 0;
    }

    /**
     * 通过id获取记录
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 通过名称获取记录
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        $conditions['name'] = trim($name);
        $row = $this->getRow('*', $conditions);
        return $row;
    }

    /**
     * 通过项目id和名称获取记录
     * @param $projectId
     * @param $name
     * @return array
     */
    public function getByProjectAndName($projectId, $name)
    {
        $conditions = [];
        if (!empty($projectId)) {
            $conditions['project_id'] = $projectId;
        }
        $conditions['name'] = trim($name);
        $row = $this->getRow('*', $conditions);
        return $row;
    }
}
