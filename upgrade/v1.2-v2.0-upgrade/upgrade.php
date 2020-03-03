<?php
/**
 * Masterlab v1.2 升级到 v2.0 升级补丁
 * 本程序是一个命令行程序，依赖masterlab项目，不能独立运行。
 * 本程序目录应部署在项目目录下，其所在路径应该为masterlab/upgrade/
 *
 * 使用方法：1、把数据库补丁文件放在当前目录下，修改$sqlFile变量的值
 *          2、把代码补丁文件以项目目录为基准，打包为zip压缩包，放在当前目录下，修改$patchFile变量的值
 *          3、把vendor目录补丁以项目目录为基准，打包为zip压缩包，放在当前目录下，修改$vendorFile变量的值
 *          4、在当前目录下执行：php upgrade.php
 *
 * 作者：杨文杰
 */

showLine('');
showLine('This program will upgrade your Masterlab v1.2 to Masterlab v2.0,');
echo 'Are you sure you want to upgrade now? (Yes, No): ';
flush();
$input = trim(fgets(STDIN));
$input = strtolower($input);
if (!(($input == 'yes') || ($input == 'y'))) {
    showLine('');
    showLine('Masterlab upgrade aborted!');
    die;
}

showLine('');

$currentDir = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
$globals = $currentDir . '../../app' . DIRECTORY_SEPARATOR . 'globals.php';
$globals = realpath($globals);
require_once $globals;

// 初始化开发框架基本设置
$config = new \stdClass();
$config->currentApp = APP_NAME;
$config->appPath = APP_PATH;
$config->appStatus = APP_STATUS;
$config->enableTrace = ENABLE_TRACE;
$config->enableXhprof = ENABLE_XHPROF;
$config->xhprofRate = XHPROF_RATE;
$config->enableWriteReqLog = WRITE_REQUEST_LOG;
$config->enableSecurityMap = SECURITY_MAP_ENABLE;
$config->exceptionPage = VIEW_PATH . 'exception.php';
$config->ajaxProtocolClass = 'ajax';
$config->enableReflectMethod = ENABLE_REFLECT_METHOD;

$config->customRewriteClass = "main\\app\\classes\\RewriteUrl";
$config->customRewriteFunction = "orgRoute";

// 实例化开发框架对象
$framework = new  framework\HornetEngine($config);

// Masterlab 项目目录
$projectDir = realpath(APP_PATH . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

// 数据库补丁文件路径，要求sql格式
$sqlFile = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'v1.2-2.0.sql';

// 索引操作语句SQL文件
$indexSqlFile = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'v1.2-2.0_index.sql';

// 代码补丁压缩包路径，要求zip格式
$patchFile = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'v1.2-2.0.patch.zip';

// vendor目录压缩包，要求zip格式
$vendorFile = $currentDir . 'data'. DIRECTORY_SEPARATOR . 'vendor.zip';

// storage/attachment目录迁移
$oldAttachmentDir = realpath(APP_PATH) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'attachment';
$newAttachmentDir = realpath(APP_PATH) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'attachment';

// 数据库备份文件
$databaseBackupFilename = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'masterlab.bak.sql';

// lock文件
$lockFile = $currentDir . 'upgrade.lock';

// 先检查补丁文件和所需扩展是否存在
$checkOk = true;
if (!file_exists($sqlFile)) {
    showLine('Error: Database patch file not exists!');
    $checkOk = false;
}

if (!file_exists($patchFile)) {
    showLine('Error: Code patch file not exists!');
    $checkOk = false;
}

if (!file_exists($vendorFile)) {
    showLine('Error: Vendor patch file not exists!');
    $checkOk = false;
}

if (!file_exists($indexSqlFile)) {
    showLine('Error: Database index patch file not exists!');
    $checkOk = false;
}

if (!extension_loaded('zip')) {
    showLine('Error: php-extension zip not loaded');
    $checkOk = false;
}

if (!isPathWritable($projectDir)) {
    showLine('Error: Project folder is not writable, can not write patch code');
    $checkOk = false;
}

if (!isPathWritable($currentDir)) {
    showLine('Error: current folder is not writable, can not write patch code');
    $checkOk = false;
}

if (file_exists($lockFile)) {
    showLine('Error: project had already been updated!');
    $checkOk = false;
}

$checkOk or die;

try {
    // 备份 database.cfg.php 文件
    $databaseConfigFile = APP_PATH . 'config' . DIRECTORY_SEPARATOR . 'deploy' . DIRECTORY_SEPARATOR . 'database.cfg.php';
    $databaseConfigFile = realpath($databaseConfigFile);
    $databaseConfigBackupFile = realpath(APP_PATH . 'config' . DIRECTORY_SEPARATOR . 'deploy') . DIRECTORY_SEPARATOR . 'database.cfg.php.backup';

    $cacheConfigFile = APP_PATH . 'config' . DIRECTORY_SEPARATOR . 'deploy' . DIRECTORY_SEPARATOR . 'cache.cfg.php';
    $cacheConfigFile = realpath($cacheConfigFile);
    $cacheConfigBackupFile = realpath(APP_PATH . 'config' . DIRECTORY_SEPARATOR . 'deploy') . DIRECTORY_SEPARATOR . 'cache.cfg.php.backup';

    // 备份
    copy($databaseConfigFile, $databaseConfigBackupFile);
    showLine('Database config file backed up to: ' . $databaseConfigBackupFile);
    copy($cacheConfigFile, $cacheConfigBackupFile);
    showLine('Cache config file backed up to: ' . $cacheConfigBackupFile);
} catch (Exception $e) {
    echo $e->getMessage();
    showLine('');
    showLine('Error occurred, upgrade aborted!');
    die;
}

try {
    $model = new \main\app\model\CacheModel();
    $db = $model->db;
    $db->connect();
} catch (Exception $e) {
    echo $e->getMessage();
    showLine('');
    showLine('Database connect failed, upgrade aborted!');
    die;
}

try {
    // 备份数据库
    showLine('');
    showLine('Backing up database......');
    $result = backupDatabase($db, $databaseBackupFilename);
    if ($result) {
        showLine('Done!');
        showLine('Database was backed up to ' . $databaseBackupFilename);
    } else {
        showLine('Database backup failed, upgrade aborted!');
        die;
    }

    showLine('');
    showLine('Upgrading database......');
    $sql = file_get_contents($sqlFile);
    runSql($sql, $db);

    $projectModel = new \main\app\model\project\ProjectModel();
    $projects = $projectModel->getRows();
    $projectRoleModel = new \main\app\model\project\ProjectRoleModel();

    foreach ($projects as $project) {
        $projectId = $project['id'];

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'QA', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的 QA 角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016'), ('{$projectId}', '{$roleId}', '10017')";
            $db->exec($sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'Developers', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的Developers角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016')";
            $db->exec($sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'Administrators', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的Administrators（10002）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016'), ('{$projectId}', '{$roleId}', '10017')";
            $db->exec($sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'PO', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的PO（10006）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016'), ('{$projectId}', '{$roleId}', '10017')";
            $db->exec($sql);
        }
    }

    showLine('Done!');
    showLine('');
    showLine('Upgrading code......');

    // 解压缩代码补丁
    patchCode($patchFile, $projectDir);
    // 解压缩vendor补丁
    patchCode($vendorFile, $projectDir);
    showLine('Done!');
    showLine('');

    // 恢复 database.cfg.php 文件
    copy($databaseConfigBackupFile, $databaseConfigFile);
    unlink($databaseConfigBackupFile);
    showLine('Database config file restored: ' . $databaseConfigFile);

    // 恢复 cache.cfg.php 文件
    copy($cacheConfigBackupFile, $cacheConfigFile);
    unlink($cacheConfigBackupFile);
    showLine('Cache config file restored: ' . $cacheConfigFile);
    showLine('');

    // 移动storage/attachment目录
    showLine('Copying attachment folder......');
    if (is_dir($oldAttachmentDir)) {
        rename($oldAttachmentDir, $newAttachmentDir);
        showLine('Done!');
        showLine('Attachment folder has been copied to ' . $newAttachmentDir);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    showLine('');
    showLine('Oops, there is something wrong, restoring database......');
    restoreDatabase($db, $databaseBackupFilename);
    showLine('');
    showLine('Error occurred, upgrade aborted! Database restored.');
    die;
}

showLine('');

// 清除缓存数据
try {
    $model->cache->connect();
    $model->cache->flush();
    showLine('Cache has been flushed');
} catch (Exception $e) {
    showLine('Clear cache failed, please do it manually');
    showLine('Ignored');
}

showLine('');
showLine('Processing table index......');

// 操作数据表索引
$sql = file_get_contents($indexSqlFile);
$queries = parseSql($sql);

foreach ($queries as $query) {
    try {
        $db->exec($query);
    } catch (Exception $e) {
        echo $e->getMessage();
        showLine('Table index process failed: ' . $query);
        showLine('Ignored');
    }
}

showLine('Done!');
showLine('');

// 生成锁文件
touch($lockFile);

showLine('');
showLine('Upgrade completed successfully!');

/**
 * 执行SQL
 *
 * @param $sql
 * @param \main\lib\MyPdo $db
 * @return bool
 */
function runSql($sql, $db)
{
    $sql = trim($sql);

    if (!$sql) {
        return false;
    }

    $queries = parseSql($sql);

    foreach ($queries as $query) {
        $query = trim($query);
        if ($query) {
            if (substr($query, 0, 12) == 'CREATE TABLE') {
                $line = explode('`', $query);
                $tableName = $line[1];
                $db->exec(makeDropTableSql($tableName));
                $db->exec($query);

                // showLine('EXECUTE SQL: ' . $query);
                // showLine("Data table '" . $tableName . "' created'");
            } else {
                $db->exec($query);
                // showLine('EXECUTE SQL: ' . $query);
            }
        }
    }

    return true;
}

/**
 * 解析SQL文件为SQL语句数组
 *
 * @param $sql
 * @return array
 */
function parseSql($sql) {
    $sql = trim($sql);
    // 删除/**/注释
    $sql = preg_replace('/\/\*([\s\S]*?)\*\//', '', $sql);

    // \r\n，\r全部替换为\n
    $sql = str_replace("\r\n", "\n", $sql);
    $sql = str_replace("\r", "\n", $sql);
    $sql = preg_replace('/\n+/', "\n", $sql);

    $rows = [];
    $sqlRows = explode(";\n", $sql);
    unset($sql);

    foreach ($sqlRows as $sqlRow) {
        $sqlRow = trim($sqlRow);
        if (!$sqlRow) {
            continue;
        }

        $sqlLines = explode("\n", $sqlRow);
        $lines = [];
        foreach ($sqlLines as $sqlLine) {
            if ((substr($sqlLine, 0, 1) != '#') && (substr($sqlLine, 0, 2) != '--')) {
                $lines[] = $sqlLine;
            }
        }

        if ($lines) {
            $row = join(' ', $lines);
            $rows[] = $row;
        }
    }

    return $rows;
}

/**
 * 生成删除表语句
 *
 * @param $tableName
 * @return string
 */
function makeDropTableSql($tableName)
{
    return "DROP TABLE IF EXISTS `" . $tableName . "`;";
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

/**
 * 文件或目录是否可写
 *
 * @param $path
 * @return bool
 */
function isPathWritable($path)
{
    if (is_dir($path)) {
        $dir = $path;
        $template = $dir . DIRECTORY_SEPARATOR . randString(10);
        if ($fp = @fopen($template, 'w')) {
            @fclose($fp);
            @unlink($template);
            $writable = true;
        } else {
            $writable = false;
        }
    } else {
        if ($fp = @fopen($path, 'a+')) {
            @fclose($fp);
            $writable = true;
        } else {
            $writable = false;
        }
    }

    return $writable;
}

/**
 * 代码补丁文件解压缩
 *
 * @param $filename string 代码压缩包路径
 * @param $path string 解压缩路径
 * @return bool
 */
function patchCode($filename, $path)
{
    $isWindows = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN';
    if ($isWindows) {
        $filename = iconv('utf-8', 'gb2312', $filename);
        $path = iconv('utf-8', 'gb2312', $path);
    }

    // 打开压缩包
    $resource = zip_open($filename);

    // 遍历读取压缩包里面的文件
    while ($dirResource = zip_read($resource)) {
        if (zip_entry_open($resource, $dirResource)) {
            // 获取当前项目的名称, 即压缩包里面当前对应的文件名
            $zipEntryName = zip_entry_name($dirResource);
            $zipEntryPath = $path . $zipEntryName;
            $zipEntryPath = str_replace('/', DIRECTORY_SEPARATOR, $zipEntryPath);
            $zipEntryPath = str_replace('\\', DIRECTORY_SEPARATOR, $zipEntryPath);

            if (substr($zipEntryPath, -1) == DIRECTORY_SEPARATOR) {
                // 是一个目录
                $dir = $zipEntryPath;
            } else {
                // 是一个文件，取出路径部分
                $dir = substr($zipEntryPath, 0, strrpos($zipEntryPath, DIRECTORY_SEPARATOR));
            }

            // 如果路径不存在，则创建一个目录
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            // 如果不是目录，则写入文件
            if (!is_dir($zipEntryPath)) {
                // 读取这个文件
                $fileSize = zip_entry_filesize($dirResource);
                //最大读取6M，如果文件过大，跳过解压，继续下一个
                if ($fileSize < (1024 * 1024 * 6)) {
                    $content = zip_entry_read($dirResource, $fileSize);
                    // showLine('Unpacking: ' . $zipEntryPath);
                    file_put_contents($zipEntryPath, $content);
                } else {
                    if ($isWindows) {
                        showLine('Error: File to large, skipped. ' . iconv('gb2312', 'utf-8', $zipEntryPath));
                    } else {
                        showLine('Error: File to large, skipped. ' . $zipEntryPath);
                    }
                }
            }

            // 关闭当前
            zip_entry_close($dirResource);
        }
    }

    // 关闭压缩包
    zip_close($resource);
}

/**
 * 备份数据库
 *
 * @param \main\lib\MyPdo $db
 * @param $filename
 * @return bool
 */
function backupDatabase(\main\lib\MyPdo $db, $filename) {
    $str = "/*\r\nMasterlab database backup\r\n";
    $str .= "Data:" . date('Y-m-d H:i:s', time()) . "\r\n*/\r\n";
    $str .= "SET FOREIGN_KEY_CHECKS=0;\r\n";

    $tables = getTables($db);
    foreach ($tables as $table) {
        $ddl = getDDL($db, $table);
        $data = getData($db, $table);

        $str .= "-- ----------------------------\r\n";
        $str .= "-- Table structure for {$table}\r\n";
        $str .= "-- ----------------------------\r\n";
        $str .= "DROP TABLE IF EXISTS `{$table}`;\r\n";
        $str .= $ddl . "\r\n";
        $str .= "-- ----------------------------\r\n";
        $str .= "-- Records of {$table}\r\n";
        $str .= "-- ----------------------------\r\n";
        $str .= $data . "\r\n";
    }

    $str .= "SET FOREIGN_KEY_CHECKS=1;\r\n";
    $result = file_put_contents($filename, $str);

    return $result !== false;
}

/**
 * 恢复数据库
 *
 * @param \main\lib\MyPdo $db
 * @param $filename
 */
function restoreDatabase(\main\lib\MyPdo $db, $filename) {
    dropTables($db);
    $sql = file_get_contents($filename);
    runSql($sql, $db);
}

/**
 * 获取数据库所有表名
 *
 * @param \main\lib\MyPdo $db
 * @return array
 */
function getTables(\main\lib\MyPdo $db) {
    $sql = 'SHOW TABLES';
    $rows = $db->getRows($sql);

    $tables = [];
    foreach ($rows as $row) {
        $table = current($row);
        $tables[] = $table;
    }

    return $tables;
}

/**
 * 删除表
 *
 * @param \main\lib\MyPdo $db
 * @param array $tables
 */
function dropTables(\main\lib\MyPdo $db, $tables = []) {
    if (!$tables) {
        $tables = getTables($db);
    }

    foreach ($tables as $table) {
        $sql = "DROP TABLE IF EXISTS `{$table}`";
        $db->exec($sql);
    }
}

/**
 * 生成建表DDL
 *
 * @param \main\lib\MyPdo $db
 * @param $table
 * @return string
 */
function getDDL(\main\lib\MyPdo $db, $table) {
    $sql = "SHOW CREATE TABLE `{$table}`";
    $ddl = $db->getRows($sql)[0]['Create Table'] . ';';

    return $ddl;
}

/**
 * 生成插入数据语句
 *
 * @param \main\lib\MyPdo $db
 * @param $table
 * @return string
 */
function getData(\main\lib\MyPdo $db, $table)
{
    $rows = $db->getRows("SHOW COLUMNS FROM `{$table}`");
    $columns = [];
    foreach ($rows as $row) {
        $columns[] = "`{$row['Field']}`";
    }

    $columns = join(',', $columns);

    $rows = $db->getRows("SELECT * FROM `{$table}`");
    $queries = [];
    foreach ($rows as $values) {
        $dataSqlRows = [];
        foreach ($values as $value) {
            $dataSqlRows[] = $db->pdo->quote($value);
        }
        $dataSql = join(',', $dataSqlRows);
        $queries[] = "INSERT INTO `{$table}` ({$columns}) VALUES ({$dataSql});";
    }

    $query = join("\r\n", $queries);
    return $query;
}

/**
 * 复制文件夹
 *
 * @param $sourceDir
 * @param $destinationDir
 */
function copyDir($sourceDir, $destinationDir)
{
    if (!file_exists($destinationDir)) {
        mkdir($destinationDir);
    };

    $handle = opendir($sourceDir);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') {
            continue;
        };

        $source = $sourceDir . DIRECTORY_SEPARATOR . $item;
        $destination = $destinationDir . DIRECTORY_SEPARATOR . $item;

        if (is_file($source)) {
            copy($source, $destination);
        } elseif (is_dir($source)) {
            copyDir($source, $destination);
        }
    }

    closedir($handle);
}

/**
 * 删除文件夹
 *
 * @param $path
 * @return bool
 */
function rmDirectory($path)
{
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') {
            continue;
        };

        $item = $path . DIRECTORY_SEPARATOR . $item;
        if (is_file($item)) {
            unlink($item);
        };

        if (is_dir($item)) {
            rmDirectory($item);
        };
    }
    closedir($handle);
    return rmdir($path);
}