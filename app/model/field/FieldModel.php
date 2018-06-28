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

    public function getCustomFields()
    {
        $allFields = $this->getAllItems(false);
        $fields = [];
        foreach ($allFields as $field) {
            if ($field['is_system'] == '0') {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getAllItems($primaryKey = true, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        return $this->getRows($fields, array(), null, 'order_weight', 'desc', null, $primaryKey);
    }
}
