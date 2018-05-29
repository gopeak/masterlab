<?php

namespace main\app\model;

/**
 * SettingModel
 * @author sven
 *
 */
class SettingModel extends BaseDictionaryModel
{
    /**
     * 表名称
     * @var string
     */
    public $table = 'setting';

    /**
     * 数据的键值
     * @var string
     */
    const  DATA_KEY = "setting/";

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
     * @throws PDOException
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
     * @param $_key
     * @param $_value
     * @param string $module
     * @param string $title
     * @param string $format
     * @return array
     * @throws \Exception
     */
    public function insertSetting($_key, $_value, $module = '', $title = '', $format = 'string')
    {
        $info = [];
        $info['_key'] = $_key;
        $info['_value'] = $_value;
        $info['module'] = $module;
        $info['title'] = $title;
        $info['format'] = $format;
        $ret = parent::insert($info);
        return $ret;
    }

    /**
     * 更新配置项
     * @param $_key
     * @param $_value
     * @param bool $module
     * @param bool $title
     * @param bool $format
     * @return bool|int
     */
    public function updateSetting($_key, $_value, $module = false, $title = false, $format = false)
    {
        $info = [];
        $info['_value'] = $_value;
        if ($module !== false) {
            $info['module'] = $module;
        }
        if ($title !== false) {
            $info['title'] = $title;
        }
        if ($format !== false) {
            $info['format'] = $format;
        }

        $where = ['_key' => $_key];
        list($ret) = parent::update($info, $where);
        return $ret;
    }

    /**
     * 通过关键字删除配置项
     * @param $key
     * @return bool
     */
    public function delSetting($key)
    {
        $where = ['_key' => $key];//" Where _key='$key'  ";
        $flag = parent::delete($where);
        return $flag;
    }

    /**
     * 通过模块获取
     * @param string $module
     * @return array
     * @throws \Exception
     */
    public function getSettingByModule($module = '', $primaryKey = false)
    {
        $condition = [];
        if (!empty($module)) {
            $condition['module'] = $module;
        }
        return $this->getRows("*", $condition, null, null, null, null, $primaryKey);
    }

    /**
     * 通过_key获取设置
     * @param $key
     * @return array
     */
    public function getSettingByKey($key)
    {
        $condition = [];
        $condition['_key'] = $key;

        $item = $this->getRow($fields = "_key,title,module,_value,default_value,format", $condition);
        if (empty($item['_value']) && $item['_value'] != 0) {
            $item['_value'] = $item['default_value'];
        }
        unset($item['default_value']);
        return $item;
    }

    /**
     * 获取所有配置项(取覆盖默认值的值)
     * @param bool $primaryKey true返回以_key为键的数组
     * @return array
     * @throws \Exception
     */
    public function getAllSetting($primaryKey = true)
    {
        $fields = "_key,module,_value,default_value,format";
        if ($primaryKey == true) {
            $ret = $this->getAll($primaryKey, $fields);
            foreach ($ret as &$item) {
                if (empty($item['_value']) && $item['_value'] != 0) {
                    $item['_value'] = $item['default_value'];
                }
                unset($item['default_value']);
            }
            unset($item);
        } else {
            $ret = $this->getAll($primaryKey, $fields);
        }

        return $ret;
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     */
    public function getSetting($key)
    {
        $row = $this->getSettingRow($key);
        return $this->formatValue($row);
    }

    /**
     * 根据format字段值来返回不同的数据
     * @param $row
     * @return bool|float|int|mixed|string
     */
    public function formatValue($row)
    {
        if (!isset($row['_value'])) {
            return false;
        }
        $ret = $row['_value'];
        if ($row['format'] == 'int') {
            $ret = intval($row['_value']);
        }
        if ($row['format'] == 'string') {
            $ret = strval($row['_value']);
        }
        if ($row['format'] == 'float') {
            $ret = floatval($row['_value']);
        }
        if ($row['format'] == 'json') {
            $ret = json_decode($row['_value'], true);
        }

        return $ret;
    }

    /**
     * 获取一整行配置项
     * @param $key
     * @return array  一条查询数据
     */
    public function getSettingRow($key)
    {
        $fields = "*";
        $where = ['_key' => $key]; //" Where _key='$key'  ";
        $row = parent::getRow($fields, $where);
        return $row;
    }

    /**
     * 根据id获取一整行配置项
     * @param $id
     * @return array 一条查询数据
     */
    public function getSettingById($id)
    {
        $fields = "*";
        $where = ['id' => $id];//" Where `id` =".$id;
        $row = parent::getRow($fields, $where);
        return $row;
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     */
    public function getValue($key)
    {
        return $this->getSetting($key);
    }

}

