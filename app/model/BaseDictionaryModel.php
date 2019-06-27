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
     * @throws \Exception
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
     * 根据id获取一整行配置项
     * @param $id
     * @return array 一条查询数据
     * @throws \Exception
     */
    public function getItemById($id)
    {
        $key = 'dict/' . $this->table . '/' . __FUNCTION__ . '/' . $id;
        $cacheRet = $this->cache->get($key);
        if ($cacheRet !== false) {
            return $cacheRet;
        }
        $row = parent::getRowById($id);
        CacheKeyModel::getInstance()->saveCache('dict/' . $this->table, $key, $row);
        return $row;
    }

    /** 通过名称获取
     * @param $name
     * @param string $fields
     * @return array
     * @throws \Exception
     */
    public function getItemByName($name, $fields = '')
    {
        $key = 'dict/' . $this->table . '/' . __FUNCTION__ . '/' . $name . ',' . $fields;
        $cacheRet = $this->cache->get($key);
        if ($cacheRet !== false) {
            return $cacheRet;
        }

        if ($fields == '') {
            $fields = $this->fields;
        }
        $row = $this->getRow($fields, ['name' => $name]);
        CacheKeyModel::getInstance()->saveCache('dict/' . $this->table, $key, $row);
        return $row;
    }

    /**
     * 获取所有数据
     * @param bool $primaryKey
     * @param string $fields
     * @return array
     * @throws \Exception
     */
    public function getAll($primaryKey = true, $fields = '*')
    {
        $key = 'dict/' . $this->table . '/' . __FUNCTION__ . '/' . strval(intval($primaryKey)) . ',' . $fields;
        $cacheRet = $this->cache->get($key);
        if ($cacheRet !== false) {
            return $cacheRet;
        }

        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        $rows = $this->getRows($fields, [], null, $this->primaryKey, 'asc', null, $primaryKey);
        CacheKeyModel::getInstance()->saveCache('dict/' . $this->table, $key, $rows);
        return $rows;
    }

    /**
     * @param bool $primaryKey
     * @param string $fields
     * @return array
     * @throws \Exception
     */
    public function getAllItems($primaryKey = true, $fields = '*')
    {
        return $this->getAll($primaryKey, $fields);
    }

    /**
     * 新增数据
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($info)
    {
        list($ret) = $insertRet = parent::insert($info);
        if ($ret) {
            CacheKeyModel::getInstance()->clearCache('dict/' . $this->table);
        }
        return $insertRet;
    }

    /**
     * 更新一条记录
     * @param $id
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItem($id, $info)
    {
        list($ret) = $updateRet = parent::updateById($id, $info);
        if ($ret) {
            CacheKeyModel::getInstance()->clearCache('dict/' . $this->table);
        }
        return $updateRet;
    }

    /**
     * 删除
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteItem($id)
    {
        $deleteRet = parent::deleteById($id);
        if ($deleteRet) {
            CacheKeyModel::getInstance()->clearCache('dict/' . $this->table);
        }
        return $deleteRet;
    }

    /**
     * 通过名称删除c
     * @param $name
     * @return int
     * @throws \Exception
     */
    public function deleteItemByName($name)
    {
        $deleteRet = $this->delete(['name' => $name]);
        if ($deleteRet) {
            CacheKeyModel::getInstance()->clearCache('dict/' . $this->table);
        }
        return $deleteRet;
    }
}
