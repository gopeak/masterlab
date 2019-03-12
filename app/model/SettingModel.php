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
     *  表前缀
     * @var string
     */
    public $prefix = 'main_';

    /**
     * 表名称
     * @var string
     */
    public $table = 'setting';

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
        list($ret) = $execRet = parent::insert($info);
        if ($ret) {
            CacheKeyModel::getInstance()->clearCache( $this->table);
        }
        return $execRet;
    }

    /**
     * 更新配置项
     * @param $_key
     * @param $_value
     * @param bool $module
     * @param bool $title
     * @param bool $format
     * @return mixed
     * @throws \Exception
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
        list($ret) =  parent::update($info, $where);
        if ($ret) {
            $cacheKey = $this->table . '/getSettingByKey/' . $_key;
            CacheKeyModel::getInstance()->deleteCache($cacheKey);
            $cacheKey = $this->table . '/getSettingRow/' . $_key;
            CacheKeyModel::getInstance()->deleteCache($cacheKey);
        }
        return $ret;
    }

    /**
     * 通过关键字删除配置项
     * @param $key
     * @return bool
     * @throws \Exception
     */
    public function delSetting($key)
    {
        $where = ['_key' => $key];//" Where _key='$key'  ";
        $flag = parent::delete($where);
        if ($flag) {
            $cacheKey = $this->table . '/getSettingByKey/' . $key;
            CacheKeyModel::getInstance()->deleteCache($cacheKey);
            $cacheKey = $this->table . '/getSettingRow/' . $key;
            CacheKeyModel::getInstance()->deleteCache($cacheKey);
        }
        return $flag;
    }

    /**
     * 通过模块获取
     * @param string $module
     * @param bool $primaryKey
     * @return array|mixed
     * @throws \Exception
     */
    public function getSettingByModule($module = '', $primaryKey = false)
    {
        $condition = [];
        if (!empty($module)) {
            $condition['module'] = $module;
        }
        $rows = $this->getRows("*", $condition, null, 'order_weight', 'desc', null, $primaryKey);
        return $rows;
    }

    /**
     * 通过_key获取设置
     * @param $key
     * @return array|mixed
     * @throws \Exception
     */
    public function getSettingByKey($key)
    {
        $cacheKey = $this->table . '/' . __FUNCTION__ . '/' . $key;
        $cacheRet = $this->cache->get($cacheKey);

        if ($cacheRet !== false) {
            return $cacheRet;
        }
        $condition = [];
        $condition['_key'] = $key;
        $fields = "_key,title,module,_value,default_value,format";
        $item = $this->getRow($fields, $condition);
        if (empty($item['_value']) && $item['_value'] != 0) {
            $item['_value'] = $item['default_value'];
        }
        unset($item['default_value']);
        CacheKeyModel::getInstance()->saveCache($this->table, $cacheKey, $item);
        return $item;
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     * @throws \Exception
     */
    public function getSettingValue($key)
    {
        $row = $this->getSettingRow($key);
        $row = $this->formatValue($row);
        return $row;
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
     * @throws \Exception
     */
    public function getSettingRow($key)
    {
        $cacheKey = $this->table . '/' . __FUNCTION__ . '/' . $key;
        $cacheRet = $this->cache->get($cacheKey);
        if ($cacheRet !== false) {
            return $cacheRet;
        }
        $fields = "*";
        $where = ['_key' => $key]; //" Where _key='$key'  ";
        $row = parent::getRow($fields, $where);
        CacheKeyModel::getInstance()->saveCache($this->table, $cacheKey, $row);
        return $row;
    }

    /**
     * 根据id获取一整行配置项
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function getSettingById($id)
    {
        $cacheKey = $this->table . '/' . __FUNCTION__ . '/' . $id;
        $cacheRet = $this->cache->get($cacheKey);
        if ($cacheRet !== false) {
            return $cacheRet;
        }
        $fields = "*";
        $where = ['id' => $id];//" Where `id` =".$id;
        $row = parent::getRow($fields, $where);
        CacheKeyModel::getInstance()->saveCache($this->table, $cacheKey, $row);
        return $row;
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     * @throws \Exception
     */
    public function getValue($key)
    {
        return $this->getSettingValue($key);
    }

}

