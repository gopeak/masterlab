<?php
/**
 * 每隔一个小时还原demo数据
 * crontab 命令 1 * * * * /usr/bin/php /data/www/masterlab_demo/app/server/timer/restoreDemoData.php
 */

$currentDir = realpath(dirname(__FILE__). '/') ;

require $currentDir.'/bootstrap.php';
use \main\app\model\user\UserModel;

try{
    $model = new UserModel();
    $model->db->connect();
    $tables = $model->db->getRows('show tables');
    foreach ( $tables   as $row) {
        $table = current($row);
        $sql = "TRUNCATE $table ;";
        $ret = $model->db->exec($sql);
        //var_dump($ret);
    }
    $sql = file_get_contents(APP_PATH.'public/install/data/demo.sql');
    runSql($sql,  $model->db);
    echo "ok\n";
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
                showJsMessage('数据表  ' . $data_name . ' ... 创建成功');
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


