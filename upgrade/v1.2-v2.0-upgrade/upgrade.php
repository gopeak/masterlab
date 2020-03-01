<?php
/**
 * 版本 1.2 升级到版本 2.0 升级补丁
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
showLine('Please make sure you have backed up your masterlab database!');
showLine('');
echo 'Have you backed up your masterlab database? (Yes, No): ';
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

$projectDir = realpath(APP_PATH . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

// 数据库补丁文件路径，要求sql格式
$sqlFile = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'v1.2-2.0.sql';

// 代码补丁压缩包路径，要求zip格式
$patchFile = $currentDir . 'data' . DIRECTORY_SEPARATOR . 'v1.2-2.0.patch.zip';

// vendor目录压缩包，要求zip格式
$vendorFile = $currentDir . 'data'. DIRECTORY_SEPARATOR . 'vendor.zip';

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
if (!extension_loaded('zip')) {
    showLine('Error: php-extension zip not loaded');
    $checkOk = false;
}

if (!is_path_writable($projectDir)) {
    showLine('Error: Project folder is not writable, can not write patch code');
    $checkOk = false;
}

if (!is_path_writable($currentDir)) {
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
    showLine('Database config file backup to: ' . $databaseConfigBackupFile);
    copy($cacheConfigFile, $cacheConfigBackupFile);
    showLine('Cache config file backup to: ' . $cacheConfigBackupFile);

    $model = new \main\app\model\CacheModel();
    $db = $model->db;
    $db->connect();
    $sql = file_get_contents($sqlFile);
    runSql($sql, $model->db);

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
            showLine('EXECUTE SQL: ' . $sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'Developers', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的Developers角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016')";
            $db->exec($sql);
            showLine('EXECUTE SQL: ' . $sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'Administrators', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的Administrators（10002）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016'), ('{$projectId}', '{$roleId}', '10017')";
            $db->exec($sql);
            showLine('EXECUTE SQL: ' . $sql);
        }

        $projectRole = $projectRoleModel->getRow('*', ['project_id' => $projectId, 'name' => 'PO', 'is_system' => 1]);
        if ($projectRole) {
            // 把project_role_relation表中的PO（10006）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
            $roleId = $projectRole['id'];
            $sql = "INSERT INTO `project_role_relation` (`project_id`, `role_id`, `perm_id`) VALUES ('{$projectId}', '{$roleId}', '10016'), ('{$projectId}', '{$roleId}', '10017')";
            $db->exec($sql);
            showLine('EXECUTE SQL: ' . $sql);
        }
    }

    showLine('');

    // 解压缩代码补丁
    patchCode($patchFile, $projectDir);

    // 解压缩vendor补丁
    patchCode($vendorFile, $projectDir);

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

    // 清除缓存数据
    $model->cache->connect();
    $ret = $model->cache->flush();
    showLine('Cache flushed');

    // 生成锁文件
    touch($lockFile);

    showLine('');
    showLine('Upgrade completed successfully!');
} catch (Exception $exception) {
    echo $exception->getMessage();
}

/**
 * 执行SQL
 *
 * @param $sql
 * @param $db
 * @return bool
 */
function runSql($sql, $db)
{
    $sql = trim($sql);

    if (!$sql) {
        return false;
    }

    // \r\n，\r全部替换为\n
    $sql = str_replace("\r\n", "\n", $sql);
    $sql = str_replace("\r", "\n", $sql);

    $ret = [];
    $num = 0;
    $sqlRows = explode(";\n", $sql);
    unset($sql);

    foreach ($sqlRows as $sqlRow) {
        $sqlRow = trim($sqlRow);
        if (!$sqlRow) {
            continue;
        }

        $ret[$num] = '';
        $sqlLines = explode("\n", $sqlRow);
        foreach ($sqlLines as $sqlLine) {
            $ret[$num] .= (isset($sqlLine[0]) && $sqlLine[0] == '#') || (isset($sqlLine[1]) && isset($sqlLine[1]) && $sqlLine[0] . $sqlLine[1] == '--') ? '' : ' ' . $sqlLine;
        }
        $num++;
    }

    foreach ($ret as $query) {
        $query = trim($query);
        if ($query) {
            if (substr($query, 0, 12) == 'CREATE TABLE') {
                $line = explode('`', $query);
                $tableName = $line[1];
                $db->exec(makeDropTableSql($tableName));
                $db->exec($query);

                showLine('EXECUTE SQL: ' . $query);
                //showLine("Data table '" . $tableName . "' created'");
            } else {
                $db->exec($query);
                showLine('EXECUTE SQL: ' . $query);
            }
        }
    }

    return true;
}

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
 * @param $file
 * @return bool
 */
function is_path_writable($file)
{
    if (is_dir($file)) {
        $dir = $file;
        if ($fp = @fopen("$dir/test.txt", 'w')) {
            @fclose($fp);
            @unlink("$dir/test.txt");
            $writable = true;
        } else {
            $writable = false;
        }
    } else {
        if ($fp = @fopen($file, 'a+')) {
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
                showLine('Creating directory: ' . $dir);
                mkdir($dir, 0777, true);
            }

            // 如果不是目录，则写入文件
            if (!is_dir($zipEntryPath)) {
                // 读取这个文件
                $fileSize = zip_entry_filesize($dirResource);
                //最大读取6M，如果文件过大，跳过解压，继续下一个
                if ($fileSize < (1024 * 1024 * 6)) {
                    $content = zip_entry_read($dirResource, $fileSize);
                    showLine('Unpacking: ' . $zipEntryPath);
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