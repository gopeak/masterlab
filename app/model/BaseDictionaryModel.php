<?php

namespace main\app\model;

/**
 *  字典模型基类
 */
class BaseDictionaryModel extends CacheModel
{
    public $prefix = '';

    public $table = '';

    const   DATA_KEY = '';

    /**
     * 要获取字段
     * @var string
     */
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


    /**
     * 新增数据
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($info)
    {
        return parent::insert($info);
    }

    /**
     * 根据id获取一整行配置项
     * @param $id
     * @return array 一条查询数据
     */
    public function getItemById($id)
    {
        $row = parent::getRowById($id);
        return $row;
    }

    /** 通过名称获取
     * @param $name
     * @param string $fields
     * @return array
     */
    public function getItemByName($name, $fields = '')
    {
        if ($fields == '') {
            $fields = $this->fields;
        }
        $row = $this->getRow($fields, ['name' => $name]);
        return $row;
    }

    /**
     * 获取所有数据
     * @param bool $primaryKey
     * @param string $fields
     * @return array
     */
    public function getAll($primaryKey = true, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        return $this->getRows($fields, [], null, $this->primaryKey, 'asc', null, $primaryKey);
    }

    public function getAllItems($primaryKey = true, $fields = '*')
    {
        return $this->getAll($primaryKey, $fields);
    }


    /**
     * 更新
     * @param $id
     * @param $info
     * @return array
     */
    public function updateItem($id, $info)
    {
        return parent::updateById($id, $info);
    }

    /**
     * 删除
     * @param $id
     * @return bool
     */
    public function deleteItem($id)
    {
        return parent::deleteById($id);
    }

    /**
     * 通过名称删除c
     * @param $name
     * @return int
     */
    public function deleteItemByName($name)
    {
        return $this->delete(['name' => $name]);
    }
}
