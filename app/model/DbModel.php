<?php

namespace main\app\model;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Events;
use Exception;
use main\lib\SlowLog;
use PDOException;


/**
 *  数据库操作模型基类
 */
class DbModel extends BaseModel
{

    /**
     * 数据库配置名，即数据库配置项$GLOBALS['database']['default'] 中的default
     * @var array
     */
    public $dbConfig = [];

    /**
     * 数据库配置索引
     * @var  string
     */
    public $configName = 'default';

    /**
     * 是否持久连接
     * @var bool
     */
    private $persistent = false;


    /**
     * @var \Doctrine\DBAL\Connection|mixed
     */
    public $db;


    /**
     * 表名称
     * @var string
     */
    public $table = '';

    /**
     * 默认获取的字段列表
     * @var string
     */
    public $fields = ' * ';

    /**
     * 默认的主键字段名称
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * 表前缀
     * @var string
     */
    public $prefix = 'main_';

    /**
     * 最后执行的sql语句
     * @var string
     */
    public $sql = '';

    /**
     * 请求生命周期的sql数组
     * @var array
     */
    public static $sqlLogs = [];

    /**
     * 当前表的字段信息
     * @var array
     */
    public $fieldFnfo = [];

    /**
     * 是否记录请求上下文的sql
     * @var bool
     */
    public $enableSqlLog = false;

    /**
     * @var
     */
    public static $dalDriverInstances;

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $dbInstance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @return self
     * @throws \Exception
     */
    public static function getDbInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$dbInstance[$index]) || !is_object(self::$dbInstance[$index])) {
            self::$dbInstance[$index] = new self($persistent);
        }
        return self::$dbInstance[$index];
    }


    /**
     * DbModel构造函数，读取系统配置的分库设置，确定要连接的数据库，然后进行DB和db数据库预连接，创建缓存预连接
     * @param bool $persistent 是否使用持久连接，子类继承时在构造函数中传入
     * @throws Exception
     */
    public function __construct($persistent = false)
    {
        parent::__construct();
        $this->dbConfig = getYamlConfigByModule('database');
        if (defined('XPHP_DEBUG')) {
            $this->enableSqlLog = XPHP_DEBUG;
        }
        $child_class_name = get_class($this);
        if (strpos($child_class_name, '\\') !== false) {
            $arr = explode('\\', $child_class_name);
            if (!empty($arr)) {
                $child_class_name = end($arr);
            }
            unset($arr);
        }
        if (getYamlConfigByModule('config_map_model')) {
            foreach (getYamlConfigByModule('config_map_model') as $key => $row) {
                if (in_array($child_class_name, $row)) {
                    $this->configName = $key;
                    break;
                }
            }
        }
        $this->persistent = $persistent;
        $this->connect();
    }


    /**
     * 获取数据库表前缀
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * 获取数据库表名.
     * @return string
     */
    public function getTable()
    {
        if (empty($this->table) && strpos(__CLASS__, '\DbModel') === false) {
            return '';
            // throw new \Exception('Please specify the table name for ' . __CLASS__);
        }
        $table = $this->getPrefix() . $this->table;
        $table = "`" . str_replace("`", "", trimStr($table)) . "`";
        return $table;
    }

    /**
     * @param $config
     * @return \Doctrine\DBAL\Connection|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function connect()
    {
        $index = $this->configName . '_' . strval($this->persistent);
        if (empty(self::$dalDriverInstances[$index])) {
            $dbConfig = $this->dbConfig[$this->configName];
            if (!$dbConfig) {
                $msg = '[CORE] 数据库配置错误';
                throw new Exception($msg, 500);
            }
            $connectionParams = array(
                'dbname' => $dbConfig['db_name'],
                'user' => $dbConfig['user'],
                'password' => $dbConfig['password'],
                'host' => $dbConfig['host'],
                'charset' => $dbConfig['charset'],
                'driver' => 'pdo_mysql',
            );
            $db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            $sqlMode = "SET SQL_MODE='IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
            $db->exec($sqlMode);
            self::$dalDriverInstances[$index] = $db;
        }
        $this->db = self::$dalDriverInstances[$index];

    }


    /**
     * 开始一个事务
     * @access public
     * @throws \Doctrine\DBAL\DBALException
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * 回滚一个事务
     * @access public
     * @throws \Doctrine\DBAL\DBALException
     */
    public function rollBack()
    {
        return $this->db->rollBack();
    }

    /**
     * 提交一个事务
     * @access public
     * @throws \Doctrine\DBAL\DBALException
     */
    public function commit()
    {
        return $this->db->commit();
    }


    /**
     * 执行更新性的SQL语句 ,返回受修改或删除 SQL语句影响的行数。如果没有受影响的行，则返回 0。失败返回false
     * @param string $sql
     * @param array $params
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function exec($sql = '', $params = [])
    {
        $this->sql = $sql;
        //echo $sql;
        //print_r($params);
        return $this->db->executeUpdate($sql, $params);
    }

    /**
     * 通过主键id返回一条记录
     * @param string $id
     * @param string $fields
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getRowById($id, $fields = '*')
    {
        if ($fields == '') {
            $fields = $this->fields;
        }
        $row = $this->getRow($fields, [$this->primaryKey => $id]);
        return $row;
    }


    /**
     * 获取某个字段值
     * @param string $field
     * @param int $id
     * @return mixed:
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getFieldById($field, $id)
    {
        return $this->getField($field, [$this->primaryKey => $id]);
    }

    /**
     * 通过条件获取总数
     * @param $conditions
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCount($conditions)
    {
        $field = "count({$this->primaryKey}) as cc";
        $sql = 'SELECT ' . $field . ' FROM ' . $this->getTable();
        $this->sql = $sql;
        return (int)$this->db->fetchColumn($sql, $conditions);
    }

    /**
     * 更新记录
     * @param $id
     * @param $row
     * @return array
     * @throws Exception
     */
    public function updateById($id, $row)
    {
        $where = [$this->primaryKey => $id];
        //$row['updated'] = time();
        $ret = $this->update($row, $where);
        return $ret;
    }

    /**
     * 删除记录
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $flag = $this->delete([$this->primaryKey => $id]);
        return $flag;
    }

    /**
     * 获取某个字段的值
     * @param $field
     * @param $conditions
     * @return false|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getField($field, $conditions)
    {
        $table = $this->getTable();
        $conditions = $this->buildWhereSqlByParam($conditions);
        $sql = 'SELECT ' . $field . ' FROM ' . $table . $conditions["_where"];
        $this->sql = $sql;
        return $this->db->fetchColumn($sql, $conditions["_bindParams"]);
    }

    /**
     * 获得一条查询结果一列的一个值，没有数据则返回false
     * @param string $sql 要执行的SQL指令
     * @param array $params 参数化数组
     * @return mixed  获得一条查询结果一列的一个值，没有数据则返回false
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getFieldBySql($sql, $params = array())
    {
        $result = $this->db->fetchColumn($sql, $params);
        return $result;
    }


    /**
     * 获取一条记录
     * @param $fields
     * @param $conditions
     * @return array 一条查询数据
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getRow($fields, $conditions)
    {
        $table = $this->getTable();
        $conditions = $this->buildWhereSqlByParam($conditions);
        $sql = 'SELECT ' . $fields . ' FROM ' . $table . $conditions["_where"];
        $this->sql = $sql;
        $row = $this->db->fetchAssoc($sql, $conditions["_bindParams"]);
        if ($row === false) {
            return [];
        }
        return $row;
    }

    /**
     * 处理参数绑定的健，避免别名引用字段时错误.
     * @param $key
     * @return string 如果是别名引用字段，例如main_user.uid将被替换成:main_user_uid，其中的点号被替换成下换线 ,因为PDO在执行绑定参数后SQL时报无效参数错误.
     */
    private function processBindKey($key)
    {
        if (strpos($key, '.') !== false) {
            $key = str_replace('.', '_', $key);
        }
        return ':' . $key;
    }


    /**
     * 参数化条件语句
     * @param $conditions
     * @return array
     */
    public function buildWhereSqlByParam($conditions = array())
    {
        $result = array("_where" => " ", "_bindParams" => array());
        if (is_array($conditions) && !empty($conditions)) {
            $sql = null;
            $join = array();
            if (isset($conditions[0]) && $sql = $conditions[0]) {
                unset($conditions[0]);
            }
            foreach ($conditions as $key => $condition) {
                $bindKey = $this->processBindKey($key);
                if (substr($key, 0, 1) != ":") {
                    unset($conditions[$key]);
                    $conditions[$bindKey] = $condition;
                }
                $join[] = $this->backquoteColumn($key) . ' = ' . $bindKey;
            }
            if (!$sql) {
                $sql = join(" AND ", $join);
            }

            $result["_where"] = " WHERE " . $sql;
            $result["_bindParams"] = $conditions;
        }
        return $result;
    }

    /**
     * 通过条件获取多条记录
     * @param string $fields
     * @param array $conditions
     * @param null $append
     * @param null $orderBy
     * @param null $sort
     * @param null $limit
     * @param bool $primaryKey
     * @return array
     */
    public function getRows($fields = "*", $conditions = [], $append = null, $orderBy = null, $sort = null, $limit = null, $primaryKey = false)
    {
        $table = $this->getTable();
        $orderBy = !empty($orderBy) ? ' ORDER BY ' . $orderBy . ' ' : '';
        $sort = !empty($sort) ? ' ' . $sort . ' ' : '';
        $limit = !empty($limit) ? ' LIMIT ' . $limit : '';
        $conditions = $this->buildWhereSqlByParam($conditions);
        $append = !empty($append) ? (empty(trim($conditions['_where'])) ? ' WHERE ' . $append : ' AND ' . $append) : '';
        $where = $conditions["_where"];
        $sql = "SELECT {$fields} FROM {$table}  {$where} {$append}  {$orderBy}  {$sort}  {$limit}";
        $this->sql = $sql;
        //  echo $sql;
        $rowsArr = $this->db->fetchAll($sql, $conditions['_bindParams']);
        if ($rowsArr === false) {
            return [];
        }
        if (empty($rowsArr)) {
            return [];
        }
        if ($primaryKey) {
            $key = array_keys(current($rowsArr));
            $rowsArr = array_column($rowsArr, null, $key[0]);
        }

        return $rowsArr;
    }

    /**
     * @param $sql
     * @param array $conditions
     * @param $primaryKey
     * @return array|mixed[]
     */
    public function fetchALLForGroup($sql, $conditions = [], $primaryKey = false)
    {
        $rowsArr = $this->db->fetchAll($sql, $conditions);
        if (!$rowsArr) {
            return [];
        }
        if ($primaryKey) {
            $key = array_keys(current($rowsArr));
            $rowsArr = array_column($rowsArr, null, $key[0]);
        }

        return $rowsArr;

    }

    /**
     * 获取最后插入的ID
     *
     * @return int 最后插入的ID
     */
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * lastInsertId 的别名
     * @return string
     */
    public function getLastInsId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * 获取最后执行的SQL
     *
     * @return string  获取最后执行的SQL
     */
    public function getLastSql()
    {
        return $this->sql;
    }

    /**
     * 参数化插入数据
     * @param $row
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insert($row)
    {
        $this->checkField($row);
        $sql = "Insert  into  {$this->getTable()} Set  ";
        $sql .= $this->parsePrepareSql($row);
        $this->sql = $sql;
        $ret = $this->db->insert($this->getTable(), $row);
        if (!$ret) {
            return [false, 'db insert err:' . print_r($row, true)];
        }
        return [true, $this->db->lastInsertId()];
    }

    /**
     * 检查字段是否正确
     * @param $arr
     * @throws Exception
     */
    protected function checkField($arr)
    {
        $err_field = '';
        if (!empty($this->fieldFnfo)) {
            foreach ($arr as $k => $item) {
                if (!array_key_exists($k, $this->fieldFnfo)) {
                    $err_field .= $k . ',';
                }
            }
        }
        if ($err_field != '') {
            throw new  PDOException($err_field . ' insert data field incorrect', 500);
        }
    }


    public function parsePrepareSql($arr, $is_index = false)
    {
        $setsStr = '';
        if (is_array($arr) && !empty($arr)) {
            foreach ($arr as $key => $val) {
                $key = trimStr(str_replace('`', '', $key));

                $bind_key = ":{$key}";
                if ($is_index) {
                    $bind_key = '?';
                }

                $_key = "`{$key}`";
                $setsStr .= "$_key={$bind_key},";
            }
            $setsStr = substr($setsStr, 0, -1);
        } elseif (is_string($arr)) {
            $setsStr = $arr;
        }
        return $setsStr;
    }

    /**
     * 插入一行数据（重复则忽略）
     * @param array $row 插入数据的键值对数组
     * @return array
     * @throws Exception
     */
    public function insertIgnore($row)
    {
        $this->checkField($row);
        $table = $this->getTable();
        if (empty($table) || empty($row)) {
            return [false, 'insert data is null'];
        }
        $sql = "INSERT IGNORE INTO {$table} SET ";
        $sql .= $this->parsePrepareSql($row);
        $this->sql = $sql;
        //echo $sql;
        try {
            $this->db->executeUpdate($sql, $row);
            return [true, $this->db->lastInsertId()];
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return [false, 'db insertIgnore err:' . $e->getMessage()];
        }
    }

    /**
     * 插入多行数据
     * @param array $rows 插入数据的二维键值对数组
     * @return bool 执行是否成功
     */
    /**
     * @param array $rows $rows 插入数据的二维键值对数组
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insertRows($rows)
    {
        $table = $this->getTable();
        $sql = makeMultiInsertSql($table, $rows);
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $rowsAffected = $this->exec($sql);
        return $rowsAffected;
    }

    /**
     * 构造插入的SQL语句目的利于缓存,能够同步缓存的数据,该函数用于缓存中数据是一维数组的情况
     * @param $info
     * @return array
     * @throws Exception
     */
    public function replace($info)
    {
        $this->checkField($info);
        $table = $this->getTable();
        if (empty($table) || empty($info)) {
            return [false, 'replace data is null'];
        }
        $sql = " Replace  into  {$table} Set  ";
        $sql .= $this->parsePrepareSql($info);
        try {
            $this->exec($sql, $info);
            return [true, $this->db->lastInsertId()];
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return [false, 'db replace err:' . $sql . print_r($info, true) . $e->getMessage()];
        }
    }


    /**
     * 通过条件删除
     * @param array $conditions
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete($conditions)
    {
        return $this->db->delete($this->getTable(), $conditions);
    }

    /**
     * 清空当前数据库的表
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function truncate($table)
    {
        $sql = " Truncate  $table";
        $ret = $this->exec($sql);
        return intval($ret);
    }

    /**
     * 参数绑定时反引查询字段，避免安全字符事项.
     * @param $column
     * @return string 如果是别名引用字段，将把别名和字段名分别用反引号括起来，否则在执行SQL时将报字段名无效错误.
     */
    private function backquoteColumn($column)
    {
        // 考虑到点号只会在别名引用时出现一次，所以直接用字符串替换中间的点号，而不用判断是否存在点号再拆分拼凑方式处理
        return '`' . str_replace('.', '`.`', $column) . '`';
    }

    /**
     * @param $row
     * @param $conditions
     * @return array
     * @throws Exception
     */
    public function update($row, $conditions)
    {
        if (!is_array($conditions)) {
            return [false, 0];
        }
        $table = $this->getTable();
        $sql = " UPDATE {$table} SET ";
        $sql .= $this->parsePrepareSql($row, true);
        $this->sql = $sql;
        $ret = $this->db->update($table, $row, $conditions);
        if ($ret===false) {
            return [false, 'db update err:' . print_r($row, true) . print_r($conditions, true)];
        }
        return [true, $ret];
    }

    /**
     * 字段值自增并更新缓存
     * @param string $field 要自增的字段名
     * @param integer $id 要自增的行id
     * @param string $primaryKey 主键字段名称
     * @param int $incValue 自增值
     * @return boolean
     * @throws \Doctrine\DBAL\DBALException
     */
    public function inc($field, $id, $primaryKey = 'id', $incValue = 1)
    {
        $conditions = [$primaryKey => $id];
        $where = "WHERE {$primaryKey}=:{$primaryKey}";
        $sql = "UPDATE " . $this->getTable() . "  SET $field= {$field} + {$incValue} " . $where;
        $ret = $this->exec($sql, $conditions);
        return (boolean)$ret;
    }

    /**
     * 字段值自减并更新缓存
     * @param string $field 要自减的字段名
     * @param integer $id 要自减的行id
     * @param string $primaryKey 主键字段名称
     * @param int $decValue 自减值
     * @return boolean
     * @throws \Doctrine\DBAL\DBALException
     */
    public function dec($field, $id, $primaryKey = 'id', $decValue = 1)
    {
        $conditions = [$primaryKey => $id];
        $where = "WHERE {$primaryKey}=:{$primaryKey}";
        $sql = "UPDATE " . $this->getTable() . "  SET $field=IF($field>0, {$field} - {$decValue} ,0) " . $where;
        $ret = $this->exec($sql, $conditions);
        return (boolean)$ret;
    }


    /**
     *  将字符串转义为安全的
     * @param $str
     * @param int $type
     * @return string
     * @throws Exception
     */
    public function quote($str, $type = \PDO::PARAM_STR)
    {
        return $this->db->quote($str, $type);
    }


    /**
     * 获取一个表的全部字段信息
     * @param $table
     * @return array
     */
    public function getFullFields($table)
    {
        $sql = "show full fields from  {$table} ";
        $this->sql = $sql;
        $fields = $this->db->fetchAll($sql);
        return $fields;
    }
}
