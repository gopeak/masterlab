<?php
namespace main\lib;

class MySqlDump
{
    const MAX_SQL_SIZE = 1e7;

    const NONE = 0;
    const DROP = 1;
    const CREATE = 2;
    const DATA = 4;
    const TRIGGERS = 8;
    const ALL = 15; // DROP | CREATE | DATA | TRIGGERS

    public $onProgress;
    public $databaseName = '';

    public $tables = array(
        '*' => self::ALL,
    );

    /** pdo */
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
            $this->databaseName = $dbName = $dbConfig['db_name'];
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

    public function save($file)
    {
        $handle = strcasecmp(substr($file, -3), '.gz') ? fopen($file, 'wb') : gzopen($file, 'wb');
        if (!$handle) {
            throw new \Exception("ERROR: Cannot write file '$file'.");
        }
        $this->write($handle);
    }

    public function write($handle = null)
    {
        if ($handle === null) {
            $handle = fopen('php://output', 'wb');
        } elseif (!is_resource($handle) || get_resource_type($handle) !== 'stream') {
            throw new \Exception('Argument must be stream resource.');
        }

        $tables = $views = array();

        $res = $this->pdo->query('SHOW FULL TABLES', \PDO::FETCH_BOTH);
        foreach ($res as $row) {
            if ($row[1] === 'VIEW') {
                $views[] = $row[0];
            } else {
                $tables[] = $row[0];
            }
        }

        $tables = array_merge($tables, $views);
        $lockTableSQL = 'LOCK TABLES `' . implode('` READ, `', $tables) . '` READ';
        $this->pdo->exec($lockTableSQL);

        $db = $this->pdo->query('SELECT DATABASE()')->fetch();
        fwrite($handle, '-- Created at ' . date('Y.m.d H:i') . " using MasterLab MySQL Dump Utility\n"
            . (isset($_SERVER['HTTP_HOST']) ? "-- Host: $_SERVER[HTTP_HOST]\n" : '')
            . '-- MySQL Server: ' . \PDO::ATTR_SERVER_INFO . "\n"
            . '-- Database: ' . $db[0] . "\n"
            . "\n"
            . "SET NAMES utf8;\n"
            . "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n"
            . "SET FOREIGN_KEY_CHECKS=0;\n"
        );

        foreach ($tables as $table) {
            $this->dumpTable($handle, $table);
            fwrite($handle, "-- #TABLE-COMPLETE {$this->databaseName}.{$table}\n\n");
            if ($this->onProgress) {
                call_user_func($this->onProgress, "{$this->databaseName}.{$table} ");
            }
        }

        fwrite($handle, "-- THE END\n");

        $this->pdo->exec('UNLOCK TABLES');
    }


    public function dumpTable($handle, $table)
    {
        $delTable = $this->delimite($table);
        $row = $this->pdo->query("SHOW CREATE TABLE $delTable", \PDO::FETCH_ASSOC)->fetch();

        fwrite($handle, "-- ".str_repeat('-', 57)."\n\n");

        $mode = isset($this->tables[$table]) ? $this->tables[$table] : $this->tables['*'];
        $view = isset($row['Create View']);

        if ($mode & self::DROP) {
            fwrite($handle, 'DROP ' . ($view ? 'VIEW' : 'TABLE') . " IF EXISTS $delTable;\n\n");
        }

        if ($mode & self::CREATE) {
            fwrite($handle, $row[$view ? 'Create View' : 'Create Table'] . ";\n\n");
        }

        if (!$view && ($mode & self::DATA)) {
            $numeric = array();
            $res = $this->pdo->query("SHOW COLUMNS FROM $delTable", \PDO::FETCH_ASSOC);
            $cols = array();
            foreach ($res as $row) {
                $col = $row['Field'];
                $cols[] = $this->delimite($col);
                $numeric[$col] = (bool) preg_match('#^[^(]*(BYTE|COUNTER|SERIAL|INT|LONG$|CURRENCY|REAL|MONEY|FLOAT|DOUBLE|DECIMAL|NUMERIC|NUMBER)#i', $row['Type']);
            }

            $cols = '(' . implode(', ', $cols) . ')';

            $size = 0;
            $res = $this->pdo->query("SELECT * FROM $delTable", \PDO::FETCH_ASSOC);
            while ($row = $res->fetch()) {
                $s = '(';
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $s .= "NULL,\t";
                    } elseif ($numeric[$key]) {
                        $s .= $value . ",\t";
                    } else {
                        $s .= "'" . addslashes($value) . "',\t";
                    }
                }

                if ($size == 0) {
                    $s = "INSERT INTO $delTable $cols VALUES\n$s";
                } else {
                    $s = ",\n$s";
                }

                $len = strlen($s) - 1;
                $s[$len - 1] = ')';
                fwrite($handle, $s, $len);

                $size += $len;
                if ($size > self::MAX_SQL_SIZE) {
                    fwrite($handle, ";\n");
                    $size = 0;
                }
            }

            if ($size) {
                fwrite($handle, ";\n");
            }
            fwrite($handle, "\n");
        }

        if ($mode & self::TRIGGERS) {
            $res = $this->pdo->query("SHOW TRIGGERS LIKE '" . addslashes($table) . "'", \PDO::FETCH_ASSOC);
            if ($res->columnCount() ) {
                fwrite($handle, "DELIMITER ;;\n\n");
                while ($row = $res->fetch()) {
                    fwrite($handle, "CREATE TRIGGER {$this->delimite($row['Trigger'])} $row[Timing] $row[Event] ON $delTable FOR EACH ROW\n$row[Statement];;\n\n");
                }
                fwrite($handle, "DELIMITER ;\n\n");
            }
        }

        fwrite($handle, "\n");
    }

    private function delimite($s)
    {
        return '`' . str_replace('`', '``', $s) . '`';
    }

}