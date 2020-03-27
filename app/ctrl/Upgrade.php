<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/6
 * Time: 1:36
 */

namespace main\app\ctrl;


class Upgrade extends BaseUserCtrl
{
    /**
     * 构造方法
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检查升级，本地测试用的
     */
    public function check_upgrade()
    {
        $currentVersion = isset($_GET['current_version']) ? trim($_GET['current_version']) : '';
        if ($currentVersion == '2.0') {
            $data = [
                'last_version' => [
                    'version' => '2.0.1',
                    'release_url' => 'https://github.com/gopeak/masterlab/releases/tag/v2.0.1'
                ],
                'url' => 'http://www.masterlab20.cn/versions/packages/2.0-2.0.1-upgrade.zip'
            ];
            $msg = '升级可用';
            $this->ajaxSuccess($msg, $data);
        } else {
            $data = null;
            $msg = '已经是最新版本,无需升级!';
            $this->ajaxFailed($msg);
        }
    }

    /**
     * 自动升级脚本
     */
    public function run()
    {
        if (!$this->isAdmin) {
            $this->showLine('权限不足，请联系管理员！');
            die;
        }

        set_time_limit(0);
        $curl = new \Curl\Curl();
        $curl->setTimeout(10);

        $host = isset($_GET['source']) ? trim($_GET['source']) : 'http://www.masterlab.vip/';
        if (!preg_match('/\/$/', $host)) {
            $host .= '/';
        }
        $url = $host . 'upgrade.php?action=get_patch_info&current_version=' . MASTERLAB_VERSION;

        $curl->get($url);
        $response = $curl->rawResponse;
        $response = json_decode($response);
        if (json_last_error() != JSON_ERROR_NONE) {
            $this->showLine('获取升级信息失败，请重试！');
            die;
        }

        if ($response->ret !== '200') {
            $this->showLine($response->msg);
            die;
        }

        // 版本和补丁包URL
        $data = $response->data;
        $url = $data->url;
        $latestVersion = $data->last_version->version;

        // Masterlab 项目目录
        $projectDir = realpath(PRE_APP_PATH) . DS;
        $upgradePath = $projectDir . 'upgrade' . DS;

        $filename = pathinfo($url, PATHINFO_BASENAME);
        $filePath = $upgradePath . $filename;
        $folder = pathinfo($url, PATHINFO_FILENAME);
        $path = $upgradePath . $folder . DS;
        // 数据库补丁文件路径，要求sql格式
        $sqlFile = $path . 'database.sql';
        $ddlFile = $path . 'ddl.sql';
        $dataFile = $path . 'data.sql';

        // 索引操作语句SQL文件
        $indexSqlFile = $path . 'index.sql';
        // 代码补丁压缩包路径，要求zip格式
        $patchFile = $path . 'patch.zip';
        // vendor目录压缩包，要求zip格式
        $vendorFile = $path . 'vendor.zip';
        // lock文件
        $lockFile = $path . 'upgrade.lock';


        // 先检查补丁文件和所需扩展是否存在
        $checkOk = true;

        if (!extension_loaded('zip')) {
            $this->showLine('错误：PHP 扩展 zip 未安装！');
            $checkOk = false;
        }
        if (!$this->isPathWritable($upgradePath)) {
            $this->showLine('错误：' . $upgradePath . ' 目录权限不足，无法写入。');
            $checkOk = false;
        }
        $appConfigPath = realpath(APP_PATH . 'config' . DS . APP_STATUS . DS . 'app.cfg.php');
        if (!$this->isPathWritable($appConfigPath)) {
            $this->showLine('错误：' . $appConfigPath . ' 文件权限不足，无法写入。');
            $checkOk = false;
        }
        if (file_exists($lockFile)) {
            $this->showLine('错误：Masterlab 已经进行过此版本的升级. 若要强制升级请删除文件:'.$lockFile);
            $checkOk = false;
        }
        if (!$checkOk) {
            $this->showLine('升级失败！');
            die;
        }

        $this->showLine('您正在升级 Masterlab ' . $latestVersion);
        $this->showLine('正在下载升级包......');
        if(file_exists($filePath . '.pccdownload') && is_file($filePath . '.pccdownload') ){
            unlink($filePath . '.pccdownload');
        }
        if(file_exists($filePath) && is_file($filePath) ){
            unlink($filePath);
        }
        if(file_exists($filePath) && is_dir($filePath) ){
            rmDirectory($filePath);
        }
        if (!$curl->download($url, $filePath)) {
            $this->showLine('升级失败：补丁包下载失败！' . $curl->errorMessage . ', ' . $curl->curlErrorMessage);
            die;
        }
        if (file_exists($filePath . '.pccdownload')) {
            rename($filePath . '.pccdownload', $filePath);
        }
        $this->showLine('下载完成，升级包保存在：' . $filePath);
        $this->showLine('正在解压缩......');
        $this->unzip($filePath, $path);

        try {
            $model = new \main\app\model\CacheModel();
            $db = $model->db;
            $db->connect();
        } catch (\Exception $e) {
            $this->showLine($e->getMessage());
            $this->showLine('');
            $this->showLine('数据库连接失败, 放弃升级！');
            die;
        }

        try {
            if (file_exists($ddlFile)) {
                $this->showLine('');
                $this->showLine('正在升级数据库结构......');
                $sql = file_get_contents($ddlFile);
                $this->runSql($sql, $db);
                $this->showLine('数据库结构升级完成！');
            }

            if (file_exists($dataFile)) {
                $this->showLine('');
                $this->showLine('正在升级数据......');
                $sql = file_get_contents($dataFile);
                $this->runSql($sql, $db);
                $this->showLine('数据升级完成！');
            }

            if (file_exists($sqlFile)) {
                $this->showLine('');
                $this->showLine('正在升级数据库......');
                $sql = file_get_contents($sqlFile);
                $this->runSql($sql, $db);
                $this->showLine('数据库升级完成！');
            }
        } catch (\Exception $e) {
            $this->showLine('数据库升级失败，已忽略，请手动升级。错误信息:' . $e->getMessage());
            $this->showLine('');
        }

        try {
            $this->showLine('');
            $this->showLine('正在升级代码......');

            // 解压缩代码补丁
            if (file_exists($patchFile)) {
                $this->unzip($patchFile, $projectDir);
            }

            // 解压缩vendor补丁
            if (file_exists($vendorFile)) {
                $this->unzip($vendorFile, $projectDir);
                $this->showLine('代码升级完成！');
                $this->showLine('');
            }
            $this->showLine('');
        } catch (\Exception $e) {
            $this->showLine('代码升级失败，放弃升级。错误信息：' . $e->getMessage());
            $this->showLine('');
        }

        // 清除缓存数据
        try {
            $model->cache->connect();
            $model->cache->flush();
            $this->showLine('缓存已清除');
        } catch (\Exception $e) {
            $this->showLine('清理缓存失败，请手工执行缓存清理。');
        }
        if (file_exists($indexSqlFile)) {
            $this->showLine('');
            $this->showLine('正在修改数据库表索引......');
            // 操作数据表索引
            $sql = file_get_contents($indexSqlFile);
            $queries = $this->parseSql($sql);
            foreach ($queries as $query) {
                try {
                    $db->exec($query);
                } catch (\Exception $e) {
                    $this->showLine('数据库表索引修改失败，已忽略: ' . $query);
                }
            }
            $this->showLine('数据库表索引修改完成！');
            $this->showLine('');
        }
        // 更新版本号
        $this->writeVersionConfig($latestVersion);

        // 生成锁文件
        touch($lockFile);

        $this->showLine('');
        $this->showLine('升级成功！');
    }

    /**
     * 执行SQL
     *
     * @param $sql
     * @param \main\lib\MyPdo $db
     * @return bool
     */
    private function runSql($sql, $db)
    {
        $sql = trim($sql);

        if (!$sql) {
            return false;
        }

        $queries = $this->parseSql($sql);

        foreach ($queries as $query) {
            $query = trim($query);
            if ($query) {
                if (substr($query, 0, 12) == 'CREATE TABLE') {
                    $line = explode('`', $query);
                    $tableName = $line[1];
                    $db->exec($this->makeDropTableSql($tableName));
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
    private function parseSql($sql) {
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
    private function makeDropTableSql($tableName)
    {
        return "DROP TABLE IF EXISTS `" . $tableName . "`;";
    }

    /**
     * 向浏览器输出信息
     *
     * @param $message
     */
    private function showLine($message)
    {
        echo $message . '<br>';
        ob_flush();
        //flush();
    }

    /**
     * 文件或目录是否可写
     *
     * @param $path
     * @return bool
     */
    private function isPathWritable($path)
    {
        if (is_dir($path)) {
            $dir = $path;
            $template = $dir . DS . randString(10);
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
    private function unzip($filename, $path)
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
                $zipEntryPath = str_replace('/', DS, $zipEntryPath);
                $zipEntryPath = str_replace('\\', DS, $zipEntryPath);

                if (substr($zipEntryPath, -1) == DS) {
                    // 是一个目录
                    $dir = $zipEntryPath;
                } else {
                    // 是一个文件，取出路径部分
                    $dir = substr($zipEntryPath, 0, strrpos($zipEntryPath, DS));
                }

                // 如果路径不存在，则创建一个目录
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                // 如果不是目录，则写入文件
                if (!is_dir($zipEntryPath)) {
                    // 读取这个文件
                    $fileSize = zip_entry_filesize($dirResource);
                    //最大读取100M，如果文件过大，跳过解压，继续下一个
                    if ($fileSize < (1024 * 1024 * 100)) {
                        $content = zip_entry_read($dirResource, $fileSize);
                        // showLine('Unpacking: ' . $zipEntryPath);
                        file_put_contents($zipEntryPath, $content);
                    } else {
                        if ($isWindows) {
                            $this->showLine('错误: 文件过大，解压缩失败，已忽略。 ' . iconv('gb2312', 'utf-8', $zipEntryPath));
                        } else {
                            $this->showLine('错误: 文件过大，解压缩失败，已忽略。 ' . $zipEntryPath);
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
     * 复制文件夹
     *
     * @param $sourceDir
     * @param $destinationDir
     */
    private function copyDir($sourceDir, $destinationDir)
    {
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir);
        };

        $handle = opendir($sourceDir);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') {
                continue;
            };

            $source = $sourceDir . DS . $item;
            $destination = $destinationDir . DS . $item;

            if (is_file($source)) {
                copy($source, $destination);
            } elseif (is_dir($source)) {
                $this->copyDir($source, $destination);
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
    private function rmDirectory($path)
    {
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') {
                continue;
            };

            $item = $path . DS . $item;
            if (is_file($item)) {
                unlink($item);
            };

            if (is_dir($item)) {
                $this->rmDirectory($item);
            };
        }
        closedir($handle);
        return rmdir($path);
    }

    /**
     * 更改版本号
     * @param $version
     */
    private function writeVersionConfig($version)
    {
        $appFile = APP_PATH . 'config' . DS . APP_STATUS . DS . 'app.cfg.php';
        $appContent = file_get_contents($appFile);
        $appContent = preg_replace('/define\s*\(\s*\'MASTERLAB_VERSION\'\s*,\s*\'([^\']*)\'\);/m', "define('MASTERLAB_VERSION', '" . $version . "');", $appContent);
        $ret = file_put_contents($appFile, $appContent);
        $result = $ret === false ? '失败' : '成功';
        $this->showLine("主配置文件写入" . $result);
    }
}