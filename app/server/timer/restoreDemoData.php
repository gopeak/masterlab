<?php
/**
 * 每隔一个小时还原demo数据
 * crontab 命令 1 * * * * /usr/bin/php /data/www/masterlab_demo/app/server/timer/restoreDemoData.php
 */

$currentDir = realpath(dirname(__FILE__). DIRECTORY_SEPARATOR) ;

require $currentDir. DIRECTORY_SEPARATOR . 'bootstrap.php';
use \main\app\model\user\UserModel;

try{
    $model = new UserModel();
    $model->db->connect();

    // 判断当前数据库是否演示项目数据库
    $database = $model->getFieldBySql('select database()');
    if (strpos($database, 'demo') === false) {
        showLine('Not masterlab demo project, restore abandoned!');
        die;
    }

    $tables = $model->db->fetchAll('show tables');
    foreach ( $tables as $row) {
        $table = current($row);
        $sql = "DROP  table $table ;";
        showLine('数据表  ' . $table . ' ...删除成功');
        $ret = $model->db->executeUpdate($sql);
        //var_dump($ret);
    }
    $demoSqlFile = realpath(PRE_APP_PATH . 'public/install/data/main.sql');
    $sql = file_get_contents($demoSqlFile);
    $sql .= file_get_contents(realpath(PRE_APP_PATH . 'public/install/data/demo.sql'));
    $sql .= file_get_contents(realpath(PRE_APP_PATH . 'public/install/data/fulltext-5.7.sql'));
    runSql($sql, $model->db);
    showLine('OK');
}catch (Exception $exception){
    print $exception->getMessage();
}

function runSql($sql,   $db)
{
    if (!isset($sql) || empty($sql)) {
        return;
    }
    $sql = str_replace("\r", "\n",  $sql);
    $ret = array();
    $num = 0;
    foreach (explode(";\n", trim($sql)) as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        foreach ($queries as $query) {
            $ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0] . $query[1] == '--') ? '' : $query;
        }
        $num++;
    }
    unset($sql);
    foreach ($ret as $query) {
        $query = trim($query);
        if ($query) {
            if (substr($query, 0, 12) == 'CREATE TABLE') {
                $line = explode('`', $query);
                $data_name = $line[1];
                showLine('数据表  ' . $data_name . ' ... 创建成功');
                $db->exec(droptable($data_name));
                $db->exec($query);
                unset($line, $data_name);
            } else {
                $db->exec($query);
            }
        }
    }
}

function droptable($table_name)
{
    return "DROP TABLE IF EXISTS `" . $table_name . "`;";
}

/**
 * 控制台显示信息
 *
 * @param $message
 */
function showLine($message)
{
    echo $message . PHP_EOL;
    flush();
}