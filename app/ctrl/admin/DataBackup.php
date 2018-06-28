<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;


/**
 * 数据库备份与恢复
 */
class DataBackup extends BaseAdminCtrl
{
    public function index()
    {
        $data = [];
        $data['title'] = 'backup';
        $data['nav_links_active'] = 'backup';
        $data['sub_nav_active'] = 'backup';
        $data['left_nav_active'] = 'backup';
        $this->render('gitlab/admin/system_basic_setting.php', $data);
    }

    public function backup()
    {
        set_time_limit(0);
        ignore_user_abort(true);

        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $time = -microtime(true);

        $dump = new \main\lib\MySqlDump($dbConfig);
        $dumpFile = STORAGE_PATH .'dump ' . date('Y-m-d H-i') . '.sql.gz';
        $dumpFile = STORAGE_PATH .'dump_test.sql.gz';
        $dump->save($dumpFile);

        $time += microtime(true);
        echo "FINISHED (in $time s)";
    }

    public function recover()
    {
        set_time_limit(0);
        ignore_user_abort(true);

        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $dumpFile = STORAGE_PATH .'dump_test.sql.gz';

        $time = -microtime(true);

        $import = new \main\lib\MySqlImport($dbConfig);

        $import->onProgress = function ($count, $percent) {
            echo $percent."+";
            if ($percent !== null) {
                echo (int) $percent . " %\r";
            } elseif ($count % 10 === 0) {
                echo '.';
            }
        };

        $import->load($dumpFile);


        $time += microtime(true);
        echo "FINISHED (in $time s)";
    }

}
