<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;


/**
 * 数据库备份与恢复
 */
class DataBackup extends BaseAdminCtrl
{
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'backup';
        $data['nav_links_active'] = 'backup';
        $data['sub_nav_active'] = 'backup';
        $data['left_nav_active'] = 'backup';
        $this->render('gitlab/admin/system_basic_setting.php', $data);
    }

    public function pageIframeBackup()
    {
        set_time_limit(0);
        ignore_user_abort(true);
        ob_end_flush();

        $backupPath = STORAGE_PATH.'backup';
        if(!is_dir($backupPath)){
            mkdir($backupPath,0777);
        }

        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $time = -microtime(true);

        $dump = new \main\lib\MySqlDump($dbConfig);
        $dumpFile = $backupPath .'/dump_' . date('Ymd_H_i') . '.sql.gz';
        //$dumpFile = STORAGE_PATH .'dump_test.sql.gz';

        $dump->onProgress = function ($output) {
            echo str_repeat("<div class='item' style='font-size: 12px; color:#aaa;'>",1024).$output." ✔</div>";
            flush();
        };

        $dump->save($dumpFile);

        $time += microtime(true);

        sleep(1);
        echo "FINISHED (in $time s)";
        flush();
    }

    public function pageIframeRecover($dump_file_name)
    {

        set_time_limit(0);
        ignore_user_abort(true);
        ob_end_flush();

        if(!isset($dump_file_name) || empty($dump_file_name) || $dump_file_name=='undefined'){
            echo str_repeat("<div>",1024)."没有选择恢复的文件</div>";
            flush();
            exit;
        }


        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $dumpFile = STORAGE_PATH .'dump_test.sql.gz';
        $dumpFile = STORAGE_PATH . 'backup/'.$dump_file_name;

        $time = -microtime(true);

        $import = new \main\lib\MySqlImport($dbConfig);
        $import->onProgress = function ($output) {
            echo str_repeat("<div class='item' style='font-size: 12px; color:#aaa;'>",1024).$output." ->Complete</div>";
            flush();
        };
        $import->load($dumpFile);

        $time += microtime(true);
        echo "数据恢复成功 (in $time s)";
    }
}
