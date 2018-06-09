<?php
namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class IssueTypeModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'type';
    
    const   DATA_KEY = 'issue_type/';

    public $fields = '*';

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
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    public function getAllItem($primaryKey = true)
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, [], null, 'sequence', 'desc', null, $primaryKey);
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }

    public function getByKey($key)
    {
        $where = ['_key' => trim($key)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getIdByKey($key)
    {
        $where = ['_key' => trim($key)];
        $id = $this->getOne("id", $where);
        return $id;
    }
}
