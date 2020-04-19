<?php

namespace main\app\ctrl\admin;

use Doctrine\Common\Inflector\Inflector;
use main\app\classes\PermissionGlobal;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\event\Events;
use main\app\event\PluginPlacedEvent;
use main\app\model\issue\IssueStatusModel;
use main\app\classes\IssueStatusLogic;
use main\app\model\PluginModel;

/**
 * 插件管理控制器
 */
class PluginManager extends BaseAdminCtrl
{

    private $subscribersArr = [];

    /**
     * IssueStatus constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $userId = UserAuth::getId();
        $this->addGVar('top_menu_active', 'plugin');
        $check = PermissionGlobal::check($userId, PermissionGlobal::MANAGER_SYSTEM_SETTING_PERM_ID);

        if (!$check) {
            $this->error('权限错误', '您还未获取此模块的权限！');
            exit;
        }
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '插件管理';
        $data['nav_links_active'] = 'plugin';
        $data['sub_nav_active'] = 'plugin';
        $data['left_nav_active'] = 'list';

        $data['type_arr'] = PluginModel::$typeArr;

        $this->render('twig/admin/plugin/index.twig', $data);
    }


    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {
        $filterType = isset($_GET['type']) ? $_GET['type']:'all';
        $filterRange = isset($_GET['range']) ? $_GET['type']:'all';

        $conditionArr = [];
        if($filterType!='all'){
            $conditionArr['type'] = trimStr($filterType);
        }

        $plugins = [];
        $model = new PluginModel();
        $dbPluginsArr = $model->getRows('*', $conditionArr);
        foreach ($dbPluginsArr as $dbPlugin) {
            if($filterType=='all' || $dbPlugin['type']==$filterType){
                $plugins[] = $dbPlugin;
            }
        }
        //print_r($plugins);
        $uninstallPlugins  = [];
        $pluginsKeyArr = array_column($dbPluginsArr, null, 'name');
        $dirPluginArr = $this->getPluginDirArr(PLUGIN_PATH);
        foreach ($dirPluginArr as $dirName => $item) {
            if (!isset($pluginsKeyArr[$dirName])) {
                $tmp = $item;
                $tmp['status'] = PluginModel::STATUS_UNINSTALLED;
                $tmp['is_system'] = '0';
                if ($filterType == 'all' || $tmp['type'] == $filterType) {
                     $uninstallPlugins[] = $tmp;
                }
            }
        }

        if($filterRange=='all' || $filterRange=='uninstalled') {
            $plugins = $plugins + $uninstallPlugins;
        }
        // 判断目录是否存在
        if($plugins){
            foreach ($plugins as & $plugin) {
                $name = $plugin['name'];
                if (!isset($dirPluginArr[$name])) {
                    $plugin['status'] = PluginModel::STATUS_INVALID;
                }
                $plugin['status_text'] = PluginModel::$statusArr[$plugin['status']];
                $plugin['type_text'] = @PluginModel::$typeArr[$plugin['type']];
            }
        }

        $data = [];
        $data['installed_count'] = count($dbPluginsArr);
        $data['uninstalled_count'] = count($uninstallPlugins);
        $data['plugins'] = $plugins;
        $this->ajaxSuccess('', $data);
    }


    /**
     * 获取单条数据
     * @param $id
     * @throws \Exception
     */
    public function get($id)
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new PluginModel();
        $plugin = $model->getById($id);

        $this->ajaxSuccess('操作成功', (object)$plugin);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function install()
    {
        // 发布安装事件
        if (empty($_POST)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $_POST['name'] = trimStr($_POST['name']);
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        $model = new PluginModel();
        if (isset($model->getByName($_POST['name'])['id'])) {
            $errorMsg['name'] = '名称已经被使用或已经安装了';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $pluginName = $_POST['name'];
        $jsonFile = PLUGIN_PATH . $pluginName . '/plugin.json';
        if (!file_exists($jsonFile)) {
            $this->ajaxFailed('提示', '参数错误,配置文件plugin.json缺失');
        }

        $jsonArr = json_decode(file_get_contents($jsonFile), true);
        $info = [];
        $info['name'] = $pluginName;
        $info['title'] = $jsonArr['title'];
        $info['type'] = $jsonArr['type'];
        $info['url'] = $jsonArr['url'];
        $info['version'] = $jsonArr['version'];
        $info['icon_file'] = $jsonArr['icon_file'];
        $info['icon_file'] = $jsonArr['icon_file'];
        $info['company'] = $jsonArr['company'];
        $info['description'] = $jsonArr['description'];
        $info['status'] = PluginModel::STATUS_INSTALLED;
        $info['is_system'] = '0';

        list($ret, $msg) = $model->replace($info);
        if ($ret) {
            // 发布安装事件
            $event = new PluginPlacedEvent($this, $info);
            $this->dispatcher->dispatch($event, $pluginName.'@'.Events::onPluginInstall);
            $this->ajaxSuccess('提示', '安装成功');
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function unInstall()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new PluginModel();
        $plugin = $model->getById($id);
        if (empty($plugin)) {
            $errorMsg['name'] = '插件已卸载或不存在';
        }

        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除操作失败了');
        } else {
            // 发布卸载事件
            $event = new PluginPlacedEvent($this, $plugin);
            $this->dispatcher->dispatch($event, $plugin['name'].'@'.Events::onPluginUnInstall);
            $this->ajaxSuccess('操作成功');
        }
    }


    /**
     * 创建插件
     * @throws \Exception
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $_POST['name'] = trimStr($_POST['name']);
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        if (isset($_POST['title']) && empty($_POST['title'])) {
            $errorMsg['title'] = '标题不能为空';
        }
        if (isset($_POST['type']) && empty($_POST['type'])) {
            $errorMsg['type'] = '类型不能为空';
        }

        if (!preg_match('/^[a-zA-Z]+[0-9]*[a-zA-Z]*$/u', $_POST['name'])) {
            $errorMsg['name'] = '名称只能以英文字母开始，不能包含特殊字符和中文';
        }
        $model = new PluginModel();
        if (isset($model->getByName($_POST['name'])['id']) || file_exists(PLUGIN_PATH . $_POST['name'])) {
            $errorMsg['name'] = '名称已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $name = trimStr($_POST['name']);
        $info = [];
        $info['name'] = $name;
        $info['title'] = $_POST['title'];
        $info['type'] = $_POST['type'];
        $info['url'] = $_POST['url'];
        $info['version'] = $_POST['version'];
        $info['status'] = PluginModel::STATUS_UNINSTALLED;
        $info['is_system'] = '0';
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['icon'])) {
            $info['icon_file'] = $_POST['icon'];
        }
        if (isset($_POST['company'])) {
            $info['company'] = $_POST['company'];
        }

        // 生成插件目录
        $pluginDirName = PLUGIN_PATH . $name;
        if (!file_exists($pluginDirName)) {
            mkdir($pluginDirName);
        }
        $this->rcopy(PLUGIN_PATH . 'plugin_tpl', $pluginDirName);
        $pluginClassName = Inflector::classify($name.'_plugin');
        $pluginClassFile = $pluginDirName."/PluginSubscriber.php";
        $pluginSrc = str_replace(["plugin_tpl","TplPlugin"],[$name,$pluginClassName], file_get_contents($pluginClassFile));
        file_put_contents($pluginClassFile, $pluginSrc);

        $pluginIndexFile = $pluginDirName."/index.php";
        file_put_contents($pluginIndexFile, str_replace(["plugin_tpl"],[$name], file_get_contents($pluginIndexFile)));
        rename($pluginDirName . '/plugin.json.tpl', $pluginDirName . '/plugin.json');

        $replaceArr = [];
        foreach ($info as $key =>$item) {
            $replaceArr['{{'.$key.'}}'] = $item;
        }
        $replaceArr['{{main_class}}'] = $pluginClassName;
        $jsonFile = $pluginDirName . '/plugin.json';
        $jsonSrc = str_replace(array_keys($replaceArr),array_values($replaceArr), file_get_contents($jsonFile));
        file_put_contents($jsonFile, $jsonSrc);

        //list($ret, $msg) = $model->insert($info);
        $ret = true;
        $msg = '';
        if ($ret) {
            $this->ajaxSuccess('操作成功', $pluginDirName);
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }


    /**
     * 删除目录和文件
     * @param $dir
     */
    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        } else if (file_exists($dir)) unlink($dir);
    }

    // copies files and non-empty directories

    /**
     * 复制目录和文件
     * @param $src
     * @param $dst
     */
    private function rcopy($src, $dst)
    {
        if (file_exists($dst)) $this->rrmdir($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
                if ($file != "." && $file != "..") {
                    $this->rcopy("$src/$file", "$dst/$file");
                }
        } else {
            if (file_exists($src)) {
                copy($src, $dst);
            }
        }
    }


    /**
     * 更新插件数据
     * @param $id
     * @param $params
     * @throws \Exception
     */
    public function update()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $errorMsg = [];
        if (isset($_POST['title']) && empty($_POST['title'])) {
            $errorMsg['title'] = '标题不能为空';
        }
        if (isset($_POST['type']) && empty($_POST['type'])) {
            $errorMsg['type'] = '类型不能为空';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }


        $id = (int)$id;
        $model = new PluginModel();
        $row = $model->getById($id);
        if (!isset($row['id'])) {
            $this->ajaxFailed('参数错误,数据不存在');
        }
        unset($row);

        $info = [];
        if (isset($_POST['title'])) {
            $info['title'] = $_POST['title'];
        }
        if (isset($_POST['type'])) {
            $info['type'] = $_POST['type'];
        }
        if (isset($_POST['url'])) {
            $info['url'] = $_POST['url'];
        }
        if (isset($_POST['version'])) {
            $info['version'] = $_POST['version'];
        }
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['icon'])) {
            $info['icon_file'] = $_POST['icon'];
        }
        if (isset($_POST['company'])) {
            $info['company'] = $_POST['company'];
        }
        if (!empty($info)) {
            $model->updateById($id, $info);
        }
        $this->ajaxSuccess('操作成功');
    }

    /**
     * 删除插件，包括插件目录,谨慎操作
     * @param $id
     * @throws \Exception
     */
    public function delete()
    {
        $name = null;
        if (isset($_POST['name'])) {
            $name = trimStr($_POST['name']);
        }
        if (!$name) {
            $this->ajaxFailed('参数错误', '名称不能为空');
        }
        $model = new PluginModel();
        $pluginRow = $model->getByName($name);
        if (!empty($pluginRow)) {
            //$errorMsg['name'] = '插件已卸载或不存在';
            if($pluginRow['is_system']=='1'){
                $this->ajaxFailed('参数错误', '系统自带的插件不能删除');
            }

            $model->deleteById($pluginRow['id']);
        }
        $pluginDirName = PLUGIN_PATH . $name;
        $this->rrmdir($pluginDirName);


        $this->ajaxSuccess('操作成功');

    }
}
