<?php

namespace main\app\model\project;

use main\app\classes\ProjectLogic;
use main\app\model\CacheModel;

/**
 *   项目模型
 */
class ProjectModel extends CacheModel
{
    public $prefix = 'project_';
    public $table = 'main';
    const   DATA_KEY = 'project_main/';

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

    /**
     * 获取项目总数
     * @return number
     */
    public function getAllCount()
    {
        $field = "count(*) as cc ";
        return (int)$this->getOne($field, []);
    }

    public function getAll($primaryKey = true, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        return $this->getRows($fields, array(), null, 'id', 'asc', null, $primaryKey);
    }

    public function filterByType($typeId, $primaryKey = false, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        return $this->getRows($fields, array('type' => $typeId), null, 'id', 'asc', null, $primaryKey);
    }

    public function filterByNameOrKey($keyword)
    {
        $table = $this->getTable();
        $params = array();
        $where = wrapBlank("WHERE `name` LIKE '%$keyword%' OR `key` LIKE '%$keyword%'");
        $sql = "SELECT * FROM " . $table . $where;
        return $this->db->getRows($sql, $params, false);
    }

    /**
     * @param $page
     * @param $page_size
     * @return array
     */
    public function getFilter($page, $page_size)
    {
        $table = $this->prefix . $this->table;
        $params = array();

        $sqlCount = "SELECT count(id) as cc FROM {$table} ";
        $total = $this->db->getOne($sqlCount, $params);

        $start = $page_size * ($page - 1);
        $limit = wrapBlank("LIMIT {$start}, " . $page_size);
        $order = wrapBlank("ORDER BY id ASC");
        $where = wrapBlank("WHERE 1");
        $where .= $order . $limit;
        $sql = "SELECT * FROM " . $table . $where;
        $rows = $this->db->getRows($sql, $params, false);

        return array($rows, $total);
    }

    public function updateById($updateInfo, $projectId)
    {
        $where = ['id' => $projectId];
        $flag = $this->update($updateInfo, $where);
        return $flag;
    }

    public function getKeyById($projectId)
    {
        $table = $this->getTable();
        $fields = "`key`";

        $sql = "SELECT {$fields}  FROM {$table} Where id= {$projectId} ";
        $key = $this->db->getOne($sql);
        return $key;
    }

    public function getById($projectId)
    {
        $fields = "*";
        $where = ['id' => $projectId];
        $row = $this->getRow($fields, $where);
        return $row;
    }

    public function getNameById($projectId)
    {
        $fields = "name";
        $where = ['id' => $projectId];
        $row = $this->getRow($fields, $where);
        return $row;
    }

    public function getByKey($key)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['key' => trim($key)];
        $row = $this->getRow($fields, $where);
        return $row;
    }

    public function getByName($name)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['name' => $name];
        $row = $this->getRow($fields, $where);
        return $row;
    }

    public function getsByOrigin($originId)
    {
        $fields = "*";
        $where = ['org_id' => $originId];
        $rows = $this->getRows($fields, $where);
        return $rows;
    }

    public function checkNameExist($name)
    {

        $fields = "count(*) as cc";
        $where = ['name' => $name];
        $count = $this->getOne($fields, $where);
        return $count > 0;
    }

    public function checkIdNameExist($id, $name)
    {
        $table = $this->getTable();
        $conditions['id'] = $id;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND name=:name  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count > 0;
    }

    public function checkKeyExist($key)
    {
        $fields = "count(*) as cc";
        $where = ['key' => $key];
        $count = $this->getOne($fields, $where);
        return $count > 0;
    }

    public function checkIdKeyExist($id, $key)
    {
        $table = $this->getTable();
        $conditions['id'] = $id;
        $conditions['key'] = $key;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND `key`=:key  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count > 0;
    }

    /**
     * 通过项目ID数组来获取项目信息
     * @param $projectIdArr
     * @return array
     */
    public function getProjectsByIdArr($projectIdArr)
    {
        $idInString = implode(",", $projectIdArr);

        $table = $this->prefix . $this->table;
        $params = array();

        $where = wrapBlank("WHERE id IN (");
        $where .= $idInString.wrapBlank(")");
        $sql = "SELECT * FROM " . $table . $where;
        $rows = $this->db->getRows($sql, $params, false);

        return $rows;
    }

    /**
     * 获取所有项目的简单信息
     * @return array
     */
    public function getAllByFields($fields)
    {
        //$fields = 'id,org_id,org_path,name,url,key';
        return $this->getRows($fields);
    }
}
