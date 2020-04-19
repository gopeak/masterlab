<?php

namespace main\app\model;

/**
 * PluginModel
 * @author sven
 *
 */
class PluginModel extends DbModel
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
    public $table = 'plugin';

    /**
     * 要获取字段
     * @var string
     */
    public $fields = '*';


    const  STATUS_INVALID = 0;
    const  STATUS_INSTALLED = 1;
    const  STATUS_UNINSTALLED = 2;
    public static $statusArr = [
        self::STATUS_INVALID => '无效(插件目录不存在)',
        self::STATUS_INSTALLED => '已安装',
        self::STATUS_UNINSTALLED => '未安装',
    ];

    const  TYPE_MODULE = 'project_module';
    const  TYPE_ADMIN = 'admin_module';
    const  TYPE_THEME = 'theme';
    const  TYPE_APP = 'app';
    public static $typeArr = [
        self::TYPE_MODULE => '项目模块',
        self::TYPE_ADMIN => '管理模块',
        self::TYPE_THEME => '主题',
        self::TYPE_APP => '应用',
    ];


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
     * @param bool $primaryKey
     * @return array
     */
    public function getAllItem($primaryKey = false)
    {
        $fields = " *";
        return $this->getRows($fields, [], null, 'order_weight', 'desc', null, $primaryKey);
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

    /**
     * @param $keyArr
     * @return array
     */
    public function getIdArrByKeys($keyArr)
    {
        $idArr = [];
        $allStatusRows = $this->getAllItem();
        foreach ($allStatusRows as $row) {
            if (in_array($row['_key'], $keyArr)) {
                $idArr[] = (int)$row['id'];
            }
        }
        return $idArr;
    }
}

