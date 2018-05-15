<?php

namespace main\app\model\field;

use main\app\model\BaseDictionaryModel;

/**
 *  字段模型
 *
 */
class FieldModel extends BaseDictionaryModel
{
    public $prefix = 'field_';

    public $table = 'main';

    const   DATA_KEY = 'field_main/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws PDOException
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

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }


    /**
     * 获取所有
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     */
    public function getAll($primaryKey = true)
    {
        $table = $this->getTable();
        return $this->getRows(" id as k,{$table}.*", array(), null, 'id', 'desc', null, $primaryKey);
    }
}
