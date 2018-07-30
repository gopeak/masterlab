<?php
namespace main\lib;

class MySqlImport
{
    public $onProgress;
    private $pdo;

    public function __construct($dbConfig)
    {
        // 判断服务器环境是否支持PDO
        if (!class_exists('PDO')) {
            throw new \PDOException("当前服务器环境不支持PDO，访问数据库失败。", 3000);
        }

        // 判断是传入了正确的数据库配置参数
        if (empty($dbConfig['host'])) {
            throw new \PDOException("没有定义数据库配置，请在配置文件中配置。", 3001);
        }

        try {
            $names = (isset($dbConfig['charset']) && !empty($dbConfig['charset'])) ? $dbConfig['charset'] : 'utf8';
            $driver = $dbConfig['driver'];
            $host = $dbConfig['host'];
            $port = $dbConfig['port'];
            $dbName = $dbConfig['db_name'];
            $user = $dbConfig['user'];
            $password = $dbConfig['password'];
            $params = [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$names}",
                \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
                \PDO::ATTR_TIMEOUT => 3600
            ];
            $dsn = sprintf("%s:host=%s;port=%s;dbname=%s", $driver, $host, $port, $dbName);
            $this->pdo = new \PDO($dsn, $user, $password, $params);
        } catch (\PDOException $e) {
            $message = $e->getMessage() . PHP_EOL;
            throw new \PDOException($message, 3002);
        }

    }


    public function load($file)
    {
        $handle = strcasecmp(substr($file, -3), '.gz') ? fopen($file, 'rb') : gzopen($file, 'rb');
        if (!$handle) {
            throw new \Exception("ERROR: Cannot open file '$file'.");
        }
        return $this->read($handle);
    }


    public function read($handle)
    {
        if (!is_resource($handle) || get_resource_type($handle) !== 'stream') {
            throw new \Exception('Argument must be stream resource.');
        }

        $stat = fstat($handle);

        $sql = '';
        $delimiter = ';';
        $count = $size = 0;

        while (!feof($handle)) {
            $s = fgets($handle);
            $size += strlen($s);

            if(substr(trim($s), 0, strlen('-- #TABLE-COMPLETE')) === '-- #TABLE-COMPLETE'){
                if ($this->onProgress) {
                    call_user_func($this->onProgress, substr(trim($s), strlen('-- #TABLE-COMPLETE')+1));
                }
            }

            if (strtoupper(substr($s, 0, 10)) === 'DELIMITER ') {
                $delimiter = trim(substr($s, 10));
            } elseif (substr($ts = rtrim($s), -strlen($delimiter)) === $delimiter) {
                $sql .= substr($ts, 0, -strlen($delimiter));
                if (!$this->pdo->query($sql)) {
                    throw new \Exception('databackup-error: '.var_export($this->pdo->errorInfo(), true));
                }
                $sql = '';
            } else {
                $sql .= $s;
            }
        }

        if (rtrim($sql) !== '') {
            if (!$this->pdo->query($sql)) {
                throw new \Exception('databackup-error: '.var_export($this->pdo->errorInfo(), true));
            }
        }
        return true;
    }
}