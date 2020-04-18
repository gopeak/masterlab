<?php

namespace main\app\plugin\webhook\model;

use main\app\model\DbModel;
/**
 * WebHookModel
 * @author sven
 *
 */
class WebHookModel extends DbModel
{

    /**
     *  表前缀
     * @var string
     */
    public $prefix = 'main_';

    /**
     * 表名称
     * @var string
     */
    public $table = 'webhook';

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
     * @return array
     */
    public function getEnableItems()
    {
        return $this->getRows('*', ['enable'=>'1']);
    }


    /**
     * 获取全部数据
     */
    public function getAllItem(){
        return $this->getRows('*');
    }

    /**
     * @param $id
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * @param $name
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }


    /**
     * @param $name
     * @return false|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIdByName($name)
    {
        $where = ['name' => trim($name)];
        $id = $this->getField("id", $where);
        return $id;
    }


}

