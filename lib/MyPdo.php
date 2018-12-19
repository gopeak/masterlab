<?php

namespace main\lib;

/**
 * pdo封装类
 */
class MyPdo
{

    /**
     * PDO预处理类的保存变量
     *
     * @var \pdoStatement
     * @access private
     */
    public $pdoStatement = null;

    /**
     * 保存PDO数据连接的唯一实例，避免重复连接
     *
     * @var \PDO
     * @access public
     */
    public $pdo;

    /**
     * 当前执行的SQL语句
     * @var string
     * @access private
     */
    public $queryStr = '';

    /**
     * 执行的历史SQL
     * @var array
     */
    public static $sqlLogs = [];

    /**
     * 是否记录请求上下文的sql
     * @var bool
     */
    public $enableSqlLog = false;

    /**
     * 数据库配置数组，在PdoDriver构造函数中初始化
     *
     * @var array
     * @access private
     */
    private $config = [];

    /**
     * in 语句中数据类型：整型
     */
    const CREATE_IN_DATA_INT = 1;

    /**
     * in 语句中数据类型：浮点型
     */
    const CREATE_IN_DATA_FLOAT = 2;

    /**
     * in 语句中数据类型：字符串
     */
    const CREATE_IN_DATA_STRING = 3;

    /**
     * PdoDriver类构造函数
     *
     * @param array $dbConfig 数据库连接配置，在app.cfg.php中配置
     * @param boolean $persistent 是否持久连接，BaseModel调用时传入
     * @throws \PDOException 抛出的PDO错误
     * @access public
     */
    public function __construct($dbConfig, $persistent = false, $enableSqlLog = false)
    {
        $this->config = $dbConfig;
        $this->enableSqlLog = $enableSqlLog;

        // 判断服务器环境是否支持PDO
        if (!class_exists('PDO')) {
            throw new \PDOException("当前服务器环境不支持PDO，访问数据库失败。", 3000);
        }

        // 判断是传入了正确的数据库配置参数
        if (empty($this->config['host'])) {
            throw new \PDOException("没有定义数据库配置，请在配置文件中配置。", 3001);
        }

        $names = (isset($this->config['charset']) && !empty($this->config['charset'])) ? $this->config['charset'] : 'utf8';

        // 生成数据库配置
        $driver = $this->config['driver'];
        $host = $this->config['host'];
        $port = $this->config['port'];
        $dbName = $this->config['db_name'];
        $this->config['dsn'] = sprintf("%s:host=%s;port=%s;dbname=%s", $driver, $host, $port, $dbName);
        $this->config['params'] = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$names}",
            \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            \PDO::ATTR_PERSISTENT => $persistent,
            \PDO::ATTR_TIMEOUT => isset($this->config['timeout']) ? $this->config['timeout'] : 10
        ];
    }

    /**
     * 数据库预连接，保存到$pdo变量中
     *
     * @throws \PDOException
     * @access public
     */
    public function connect()
    {
        if (!isset($this->pdo)) {
            try {
                $dsn = $this->config['dsn'];
                $user = $this->config['user'];
                $password = $this->config['password'];
                $params = $this->config['params'];
                $this->pdo = new \PDO($dsn, $user, $password, $params);
                $sqlMode = "SET SQL_MODE='IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
                $this->pdo->query($sqlMode);
            } catch (\PDOException $e) {
                $message = $e->getMessage();
                $message = mb_convert_encoding($message, 'UTF-8', 'GBK');
                //Mylog::error("数据库连接失败" . $message, 'db/error');
                throw new \PDOException($message, 3002);
            }

            if (!$this->pdo) {
                throw new \PDOException('PDO CONNECT ERROR', 3003);
            }
        }
        return $this->pdo;
    }

    /**
     *  执行查询性的SQL查询，准备pdoStatement
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function query($sql, $params = array())
    {
        return $this->exec($sql, $params);
    }


    /**
     * 执行查询性的SQL查询，准备pdoStatement
     * @param string $sql 要执行的SQL指令。
     * @param array $params 参数化的数据
     * @return bool 返回true或者false
     */
    public function exec($sql = '', $params = array())
    {
        if (empty($sql)) {
            throw new \PDOException('Sql is empty', 3002);
        }
        $this->connect();

        if (empty($this->pdo)) {
            throw new \PDOException('Server connect failed', 3005);
        }

        $this->queryStr = $sql;

        // 释放前次的查询结果
        if (!empty($this->pdoStatement)) {
            $this->pdoStatement = null;
        }
        try {
            $this->pdoStatement = $this->pdo->prepare($sql);
            if (empty($this->pdoStatement)) {
                return false;
            }

            if (is_array($params) && !empty($params)) {
                foreach ($params as $k => &$v) {
                    $this->pdoStatement->bindParam($k, $v);
                }
            }

            $log_index = count(self::$sqlLogs);
            if ($this->enableSqlLog) {
                self::$sqlLogs[$log_index]['sql'] = $sql;
                self::$sqlLogs[$log_index]['time'] = time();
                self::$sqlLogs[$log_index]['result'] = '';
            }

            $start_time = array_sum(explode(' ', microtime()));
            $result = $this->pdoStatement->execute();
            $end_time = array_sum(explode(' ', microtime()));
            $diff = $end_time - $start_time;
            SlowLog::getInstance()->write($sql, $diff);

            if ($this->enableSqlLog) {
                self::$sqlLogs[$log_index]['result'] = boolval($result);
            }
        } catch (\PDOException $e) {
            // @todo 记录日志
            if (isset($_SERVER['argv'])) {
                var_dump($sql, $params, $e->getMessage(), $e->getTrace());
            }
            // print_r($e->getTrace());
            throw new \PDOException($e->getMessage() . "\n" . json_encode($e->getTrace(), true), (int)$e->getCode());
        }
        return $result;
    }

    /**
     * 执行查询性的SQL查询，准备pdoStatement
     * @param string $sql 要执行的SQL指令。
     * @param array $params 参数化的数据
     * @return bool 返回true或者false
     */
    public function execPrepare($sql = '', $params = array())
    {
        if (empty($sql)) {
            throw new \PDOException('要执行的SQL语句为空。', 3002);
        }
        $this->connect();

        if (empty($this->pdo)) {
            throw new \PDOException('无法连接数据库。', 3005);
        }

        $this->queryStr = $sql;

        // 释放前次的查询结果
        if (!empty($this->pdoStatement)) {
            $this->pdoStatement = null;
        }

        $this->pdoStatement = $this->pdo->prepare($sql);
        if (empty($this->pdoStatement)) {
            return false;
        }

        $log_index = count(self::$sqlLogs);
        if ($this->enableSqlLog) {
            self::$sqlLogs[$log_index]['sql'] = $sql;
            self::$sqlLogs[$log_index]['time'] = time();
            self::$sqlLogs[$log_index]['result'] = '';
        }

        $start_time = array_sum(explode(' ', microtime()));
        $result = $this->pdoStatement->execute($params);
        $end_time = array_sum(explode(' ', microtime()));
        $diff = $end_time - $start_time;
        SlowLog::getInstance()->write($sql, $diff);


        if ($this->enableSqlLog) {
            self::$sqlLogs[$log_index]['result'] = boolval($result);
        }
        return $result;
    }

    /**
     * 获得所有的查询数据
     * @param string $sql 要执行的SQL指令,查询得到的数据集，失败返回false
     * @param array $params 是否以主键为下标。使用主键下标，可以返回以数据库主键的值为下标的二维数组
     * @param bool $primaryKey
     * @return array
     */
    public function getRows($sql, $params = array(), $primaryKey = false)
    {
        $this->query($sql, $params);
        if ($primaryKey) {
            $result = $this->pdoStatement->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_ASSOC);
            $result = array_map('reset', $result);
        } else {
            $result = $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
        }
        $this->pdoStatement = null;
        return $result;
    }

    /**
     * 获得所有的查询数据
     * @param string $sql 要执行的SQL指令,查询得到的数据集，失败返回false
     * @param array $params 是否以主键为下标。使用主键下标，可以返回以数据库主键的值为下标的二维数组
     * @param bool $primaryKey
     * @return array
     */
    public function getLists($sql, $params = array(), $primaryKey = false)
    {
        $this->execPrepare($sql, $params);
        if ($primaryKey) {
            $result = $this->pdoStatement->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_ASSOC);
            $result = array_map('reset', $result);
        } else {
            $result = $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
        }
        $this->pdoStatement = null;
        return $result;
    }


    /**
     * 获得一条查询数据
     * @param string $sql 要执行的SQL指令
     * @param array $params
     * @return array 一条查询数据，失败返回空数组。
     */
    public function getRow($sql, $params = array())
    {
        $this->query($sql, $params);
        $result = $this->pdoStatement->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT);
        $this->pdoStatement = null;
        if ($result === false) {
            return [];
        }
        return $result;
    }

    /**
     * 获得一条查询结果一列的一个值，没有数据则返回false
     * @param string $sql 要执行的SQL指令
     * @param array $params 参数化数组
     * @return mixed  获得一条查询结果一列的一个值，没有数据则返回false
     */
    public function getOne($sql, $params = array())
    {
        $this->query($sql, $params);
        $result = $this->pdoStatement->fetchColumn();
        $this->pdoStatement = null;
        return $result;
    }


    /**
     * @param $table
     * @param $primaryKey
     * @param $conditions
     * @return int
     */
    public function getCount($table, $primaryKey, $conditions)
    {
        $conditions = $this->buildWhereSqlByParam($conditions);
        $field = "count({$primaryKey}) as cc";
        $sql = 'SELECT ' . $field . ' FROM ' . $table . $conditions["_where"];
        return intval($this->getOne($sql, $conditions["_bindParams"]));
    }


    /**
     * 获取最近一次查询的sql语句
     * @return string
     * @access public
     */
    public function getLastSql()
    {
        return $this->queryStr;
    }

    /**
     * 获取最后插入的ID
     *
     * @return integer 最后插入时的数据ID
     */
    public function getLastInsId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }


    /**
     * 构造插入的SQL语句目的利于缓存,能够同步缓存的数据
     * 该函数用于缓存中数据是一维数组的情况
     * @param $table
     * @param $info
     * @return array
     */
    public function replace($table, $info)
    {
        if (empty($table) || empty($info)) {
            return [false, 'replace data is null'];
        }
        $sql = " Replace  into  {$table} Set  ";
        $sql .= $this->parsePrepareSql($info);
        //echo $sql;
        return $this->execInsertPrepareSql($sql, $info);
    }

    /**
     * 参数化插入数据
     * @param string $table
     * @param array $row
     * @return array [ boolean,number|string]
     */
    public function insert($table, $row)
    {
        if (empty($table) || empty($row)) {
            return [false, 'insert data is null'];
        }
        $sql = "Insert  into  {$table} Set  ";
        $sql .= $this->parsePrepareSql($row);

        return $this->execInsertPrepareSql($sql, $row);
    }

    /**
     * 插入一行数据（重复则忽略）
     * @param string $table 数据表名
     * @param array $row 插入数据的键值对数组
     * @return array  [ boolean,number|string]
     */
    public function insertIgnore($table, $row)
    {
        if (empty($table) || empty($row)) {
            return [false, 'insert data is null'];
        }
        $sql = "INSERT IGNORE INTO {$table} SET ";
        $sql .= $this->parsePrepareSql($row);
        //echo $sql;
        return $this->execInsertPrepareSql($sql, $row);
    }

    /**
     * 通过条件删除
     * @param string $table
     * @param array $conditions
     * @return int
     */
    public function delete($table, $conditions)
    {
        $conditions = $this->buildWhereSqlByParam($conditions);
        $sql = " Delete from $table " . $conditions["_where"];
        $ret = $this->exec($sql, $conditions["_bindParams"]);
        // var_dump($ret);
        return intval($ret);
    }

    /**
     * 执行更新操作
     * @param $table
     * @param $row
     * @param $conditions
     * @return  array [bool, int|string]
     */
    public function update($table, $row, $conditions)
    {
        if (!is_array($conditions)) {
            return [false, 0];
        }
        $conditions = $this->buildWhereAndSqlByQuestion($conditions);
        $sql = " UPDATE {$table} SET ";
        $sql .= $this->parsePrepareSql($row, true);
        $sql .= ' ' . $conditions["_where"];
        return $this->execUpdatePrepareSql($sql, $row, $conditions['_bindParams']);
    }


    /**
     * 参数化的方式执行update语句
     * @param string $sql
     * @param array $row
     * @param array $bind_params
     * @return  array [boolean ,number|string] 返回包含两个元素的数组,两个数组元素分别为执行是否成功和影响行数
     */
    private function execUpdatePrepareSql($sql, $row, $bind_params)
    {
        $this->connect();
        $sth = $this->pdo->prepare($sql);
        $i = 0;
        if (!empty($row)) {
            foreach ($row as &$v) {
                $i++;
                $sth->bindValue($i, $v);
            }
        }
        if (!empty($bind_params)) {
            foreach ($bind_params as &$vw) {
                $i++;
                $sth->bindValue($i, $vw);
            }
        }
        try {
            $start_time = array_sum(explode(' ', microtime()));
            $ret = $sth->execute();
            $end_time = array_sum(explode(' ', microtime()));
            $diff = $end_time - $start_time;
            SlowLog::getInstance()->write($sql, $diff);
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }

        return [$ret, $sth->rowCount()];
    }


    /**
     * 构建预编译的UPDATE SQL语句
     * @param  array $arr
     * @param bool $is_index
     * @return string
     */
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
     * 返回插入成功后的自增id
     * @return int
     */
    public function lastInsertId()
    {
        return $this->getLastInsId();
    }

    /**
     * 开始一个事务
     *
     * @access public
     */
    public function beginTransaction()
    {
        $this->connect();
        return $this->pdo->beginTransaction();
    }

    /**
     * 回滚一个事务
     *
     * @access public
     */
    public function rollBack()
    {
        $this->connect();
        return $this->pdo->rollBack();
    }

    /**
     * 提交一个事务
     *
     * @access public
     */
    public function commit()
    {
        $this->connect();
        return $this->pdo->commit();
    }

    /**
     * 关闭数据库PDO连接
     *
     * @access public
     */
    public function close()
    {
        $this->pdo = null;
    }


    /**
     * 参数化的方式执行insert语句
     * @param string $sql
     * @param array $row
     * @return array  [ boolean,number|string]
     */
    private function execInsertPrepareSql($sql, $row)
    {

        $this->connect();
        $sth = $this->pdo->prepare($sql);
        if (!empty($row) && is_array($row)) {
            foreach ($row as $k => &$v) {
                $sth->bindValue($k, $v);
            }
        }
        try {
            $start_time = array_sum(explode(' ', microtime()));
            $ret = $sth->execute();
            $end_time = array_sum(explode(' ', microtime()));
            $diff = $end_time - $start_time;
            SlowLog::getInstance()->write($sql, $diff);
        } catch (\PDOException $e) {
            //echo $e->getMessage();
            return [false, $e->getMessage()];
        }

        return [$ret, $this->lastInsertId()];
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
     * 参数化条件语句
     * @param array $conditions
     * @return array
     */
    private function buildWhereAndSqlByQuestion($conditions = array())
    {
        $result = array("_where" => " ", "_bindParams" => array());
        if (is_array($conditions) && !empty($conditions)) {
            $sql = null;
            $join = array();
            if (isset($conditions[0]) && $sql = $conditions[0]) {
                unset($conditions[0]);
            }
            foreach ($conditions as $key => $value) {
                $join[] = $this->backquoteColumn($key) . ' = ?';
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
     * 参数绑定时反引查询字段，避免安全字符事项.
     * @param $column
     * @return string 如果是别名引用字段，将把别名和字段名分别用反引号括起来，否则在执行SQL时将报字段名无效错误.
     */
    private function backquoteColumn($column)
    {
        // 考虑到点号只会在别名引用时出现一次，所以直接用字符串替换中间的点号，而不用判断是否存在点号再拆分拼凑方式处理
        return '`' . str_replace('.', '`.`', $column) . '`';
    }


    public function safeReplace($string)
    {
        $string = str_replace('%20', '', $string);
        $string = str_replace('%27', '', $string);
        $string = str_replace('%2527', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace(';', '', $string);
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace("{", '', $string);
        $string = str_replace('}', '', $string);
        return $string;
    }

    public function unSafeReplace($string)
    {
        $string = str_replace('&quot;', '"', $string);
        $string = str_replace('&lt;', '<', $string);
        $string = str_replace('&gt;', '>', $string);
        return $string;
    }

    /**
     * 创建IN子句.
     * @param $list
     * @param int $data_type
     * @return string
     */
    public function createIn($list, $data_type = self::CREATE_IN_DATA_STRING)
    {
        if (empty($list)) {
            return "";
        } else {
            if (!is_array($list)) {
                $list = explode(',', trim($list));
            }
            $list = array_unique($list);

            if (count($list)) {
                foreach ($list as &$content) {
                    if ($data_type == self::CREATE_IN_DATA_INT) {
                        $content = (int)$content;
                    } elseif ($data_type == self::CREATE_IN_DATA_FLOAT) {
                        $content = (float)$content;
                    } else {
                        $content = addslashes(trim($content));
                    }
                }
                return " IN ('" . implode("','", $list) . "') ";
            } else {
                return "";
            }
        }
    }


    /**
     * 组成sql语句的in方法
     * @param $list
     * @param null $attribute
     * @return string
     */
    public function buildInSql($list, $attribute = null)
    {
        if (count($list) == 0) {
            return "";
        }

        $arr = array();
        foreach ($list as $item) {
            if ($attribute == null && is_string($item)) {
                $arr[] = $item;
            } elseif (array_key_exists($attribute, $item)) {
                $arr[] = $item[$attribute];
            } else {
                return "";
            }
        }

        return (count($arr) == 1) ? "='" . $arr[0] . "'" : " IN(" . implode(",", $arr) . ")";
    }

    /**
     * 读取一个表的字段数据
     * @param string $table 表名，默认本实例的table属性
     * @param array $excepts 要剔除的字段名列表
     * @return  array 字段名数组
     */
    public function getFields($table = '', $excepts = array())
    {
        $table = $table ?: $this->getTable();
        $sql = "describe `$table`";
        $fields = $this->getRows($sql, 'Field');
        $fields = array_keys($fields);

        if ($excepts) {
            foreach ($excepts as $value) {
                $key = array_search($value, $fields);
                if ($key) {
                    array_splice($fields, $key, 1);
                }
            }
        }

        return $fields;
    }

    /**
     * 获取一个表的全部字段信息
     * @param $table
     * @return array
     */
    public function getFullFields($table)
    {
        $sql = "show full fields from  {$table} ";
        $fields = $this->getRows($sql, [], true);
        return $fields;
    }


    /**
     * 获取表字段
     * @param $table
     * @return array 一维数组
     */
    public function getTableFields($table)
    {
        $sql = "DESC {$table} ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $tableFields = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $tableFields;
    }


}
