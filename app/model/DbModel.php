<?php

namespace main\app\model;

use \main\lib\MyPdo;

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
     * MyPDO封装对象
     * @see \PDO
     * @var MyPdo
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
     * 实现单例模式
     * @var \PDO
     */
    public static $pdoDriverInstances;


    /**
     * DbModel构造函数，读取系统配置的分库设置，确定要连接的数据库，然后进行DB和db数据库预连接，创建缓存预连接
     * @throws \Exception
     * @param bool $persistent 是否使用持久连接，子类继承时在构造函数中传入
     */
    public function __construct($persistent = false)
    {
        $this->dbConfig = getConfigVar('database');

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

        if (isset($this->dbConfig['config_map_class'])) {
            foreach ($this->dbConfig['config_map_class'] as $key => $row) {
                if (in_array($child_class_name, $row)) {
                    $this->configName = $key;
                    break;
                }
            }
        }
        $this->persistent = $persistent;
        if (empty($this->db)) {
            $this->db = $this->prepareConnect(); // 数据库预连接
        }
        $dbConfig = $this->dbConfig['database'][$this->configName];
        if (isset($dbConfig['show_field_info'])
            && $dbConfig['show_field_info']
            && !empty($this->table)
        ) {
            $db_name = $dbConfig['db_name'];
            $table = str_replace("`", "", $this->getTable());
            $cacheFile = STORAGE_PATH . '/cache/tables/' . $db_name . '-' . $table . '-field_info.php';
            if (file_exists($cacheFile)) {
                $field_info = [];
                include $cacheFile;
                $this->fieldFnfo = $field_info;
            } else {
                $this->fieldFnfo = $this->db->getFullFields($this->getTable());
                $saveSource = "<?php \n\n\n  " . ' $field_info = ' . var_export($this->fieldFnfo, true) . ";\n\n";
                file_put_contents($cacheFile, $saveSource);
            }
        }
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
     * 预连接数据库,并没有真正的进行连接
     * @return MyPdo
     * @throws \Exception
     */
    public function prepareConnect()
    {
        $index = $this->configName . '_' . strval($this->persistent);
        if (empty(self::$pdoDriverInstances[$index])) {
            $dbConfig = $this->dbConfig['database'][$this->configName];
            if (!$dbConfig) {
                $msg = '[CORE] 数据库配置错误';
                throw new \Exception($msg, 500);
            }
            self::$pdoDriverInstances[$index] = new  MyPdo($dbConfig, $this->persistent, $this->enableSqlLog);
        }
        return self::$pdoDriverInstances[$index];
    }


    /**
     * 真正的连接数据库
     * @throws \Exception
     * @return MyPdo
     */
    public function realConnect()
    {
        if (empty($this->db)) {
            $this->db = $this->prepareConnect(); // 数据库预连接
        }
        $this->db->connect();
        if (!isset($GLOBALS['global_pdo']) || !in_array($this->db->pdo, $GLOBALS['global_pdo'])) {
            $GLOBALS['global_pdo'][] = $this->db;
        }

        return $this->db;
    }


    /**
     * 执行更新性的SQL语句 ,返回受修改或删除 SQL语句影响的行数。如果没有受影响的行，则返回 0。失败返回false
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function exec($sql = '', $params = [])
    {
        return $this->db->exec($sql, $params);
    }

    /**
     * 通过主键id返回一条记录
     * @param string $id
     * @param string $fields
     * @return array
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
     */
    public function getFieldById($field, $id)
    {
        return $this->getOne($field, [$this->primaryKey => $id]);
    }


    /**
     * @param $conditions
     * @param string $order
     * @param string $sort
     * @param int $page
     * @param int $pageSize
     * @param string $fields
     * @return array
     */
    public function getRowsByPage($conditions, $order = 'id', $sort = 'desc', $page = 1, $pageSize = 10, $fields = '*')
    {
        $start = $pageSize * ($page - 1);

        $limit = "$start, $pageSize";

        $lists = $this->getRows($fields, $conditions, null, $order,$sort, $limit, "");
        //    var_dump($shops);
        return $lists;
    }


    /**
     * 通过条件获取总数
     * @param array $conditions
     * @return number
     */
    public function getCount($conditions)
    {
        return $this->db->getCount($this->getTable(), $this->primaryKey, $conditions);
    }

    /**
     * 更新记录
     * @param $id
     * @param $row
     * @return array
     * @throws \Exception
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
     * @return mixed
     */
    public function getOne($field, $conditions)
    {
        $conditions = $this->db->buildWhereSqlByParam($conditions);
        $table = $this->getTable();
        $sql = 'SELECT ' . $field . ' FROM ' . $table . $conditions["_where"];
        return $this->db->getOne($sql, $conditions["_bindParams"]);
    }


    /**
     * 获取一条记录
     * @param $fields
     * @param $conditions
     * @return array 一条查询数据
     */
    public function getRow($fields, $conditions)
    {
        $table = $this->getTable();
        $conditions = $this->db->buildWhereSqlByParam($conditions);
        $sql = 'SELECT ' . $fields . ' FROM ' . $table . $conditions["_where"];
        $row = $this->db->getRow($sql, $conditions["_bindParams"]);
        return $row;
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
        $conditions = $this->db->buildWhereSqlByParam($conditions);
        $append = !empty($append) ? (empty(trim($conditions['_where'])) ? ' WHERE ' . $append : ' AND ' . $append) : '';
        $where = $conditions["_where"];
        $sql = "SELECT {$fields} FROM {$table}  {$where} {$append}  {$orderBy}  {$sort}  {$limit}";
        // echo $sql;
        return $this->db->getRows($sql, $conditions["_bindParams"], $primaryKey);
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
     * 获取最后执行的SQL
     *
     * @return string  获取最后执行的SQL
     */
    public function getLastSql()
    {
        return $this->db->getLastSql();
    }

    /**
     * 参数化插入数据
     * @param $row
     * @return array
     * @throws \Exception
     */
    public function insert($row)
    {
        $this->checkField($row);
        return $this->db->insert($this->getTable(), $row);
    }

    /**
     * 检查字段是否正确
     * @param $arr
     * @throws \Exception
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
            throw new  \PDOException($err_field . ' insert data field incorrect', 500);
        }
    }

    /**
     * 插入一行数据（重复则忽略）
     * @param $row array 插入数据的键值对数组
     * @return array
     * @throws \Exception
     */
    public function insertIgnore($row)
    {
        $this->checkField($row);
        return $this->db->insertIgnore($this->getTable(), $row);
    }

    /**
     * 插入多行数据
     * @param array $rows 插入数据的二维键值对数组
     * @return bool 执行是否成功
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
     * @throws \Exception
     */
    public function replace($info)
    {
        $this->checkField($info);
        return $this->db->replace($this->getTable(), $info);
    }

    /**
     * 通过条件删除
     * @param array $conditions
     * @return int
     */
    public function delete($conditions)
    {
        return $this->db->delete($this->getTable(), $conditions);
    }

    /**
     * @param $row
     * @param $conditions
     * @return array
     * @throws \Exception
     */
    public function update($row, $conditions)
    {
        $this->checkField($row);
        return $this->db->update($this->getTable(), $row, $conditions);
    }

    /**
     * 字段值自增并更新缓存
     * @param string $field 要自增的字段名
     * @param integer $id 要自增的行id
     * @param string $primaryKey 主键字段名称
     * @param int $incValue 自增值
     * @return boolean
     */
    public function inc($field, $id, $primaryKey = 'id', $incValue = 1)
    {
        $conditions = $this->db->buildWhereSqlByParam(array($primaryKey => $id));
        $sql = "UPDATE " . $this->getTable() . "  SET $field= {$field} + {$incValue} " . $conditions["_where"];
        $ret = $this->db->exec($sql, $conditions["_bindParams"]);
        return $ret;
    }

    /**
     * 字段值自减并更新缓存
     * @param string $field 要自减的字段名
     * @param integer $id 要自减的行id
     * @param string $primaryKey 主键字段名称
     * @param int $decValue 自减值
     * @return boolean
     */
    public function dec($field, $id, $primaryKey = 'id', $decValue = 1)
    {
        $conditions = $this->db->buildWhereSqlByParam(array($primaryKey => $id));
        $sql = "UPDATE " . $this->getTable() . "  SET $field=IF($field>0, {$field} - {$decValue} ,0) " . $conditions["_where"];
        $ret = $this->exec($sql, $conditions["_bindParams"]);
        return $ret;
    }


    /**
     *  将字符串转义为安全的
     * @param $str
     * @param int $type
     * @return string
     * @throws \Exception
     */
    public function quote($str, $type = \PDO::PARAM_STR)
    {
        $this->realConnect();
        return $this->db->pdo->quote($str, $type);
    }
}
