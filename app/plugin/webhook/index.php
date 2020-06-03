<?php

namespace main\app\plugin\webhook;

use Doctrine\Common\Inflector\Inflector;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseCtrl;
use main\app\event\Events;
use main\app\model\PluginModel;
use main\app\model\user\UserModel;
use main\app\plugin\BasePluginCtrl;
use main\app\plugin\webhook\model\WebHookModel;

/**
 *
 *   插件的入口类
 * @package main\app\ctrl\project
 */
class Index extends BasePluginCtrl
{

    public $pluginInfo = [];

    public $dirName = '';

    public $pluginMethod = 'pageIndex';

    public function __construct()
    {
        parent::__construct();


        // 当前插件目录名
        $this->dirName = basename(pathinfo(__FILE__)['dirname']);

        // 当前插件的配置信息
        $pluginModel = new PluginModel();
        $this->pluginInfo = $pluginModel->getByName($this->dirName);

        $pluginMethod = isset($_GET['_target'][3])? $_GET['_target'][3] :'';
        if($pluginMethod=="/" || $pluginMethod=="\\" || $pluginMethod==''){
            $pluginMethod = "pageIndex";
        }
        if(method_exists($this,$pluginMethod)){
            $this->pluginMethod = $pluginMethod;
            $this->$pluginMethod();
        }

    }

    /**
     * 插件首页方法
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Webhook管理';
        $data['nav_links_active'] = 'webhook';
        $data['sub_nav_active'] = 'plugin';
        $data['plugin_name'] = $this->dirName;

        $this->twigRender('index.twig', $data);
    }


    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {

        $model = new WebHookModel();
        $webhooks = $model->getAllItem();
        $data = [];
        $data['webhooks'] = $webhooks;
        $this->ajaxSuccess('', $data);
    }


    /**
     * 获取单条数据
     * @param $id
     * @throws \Exception
     */
    public function get()
    {
        $id = null;
        if (isset($_GET['_target'][4])) {
            $id = (int)$_GET['_target'][4];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new WebHookModel();
        $plugin = $model->getById($id);

        $this->ajaxSuccess('操作成功', (object)$plugin);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function enable()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new WebhookModel();
        list($ret , $msg) = $model->updateById($id,['enable'=>'1']);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '操作失败:'.$msg);
        } else {
            $this->ajaxSuccess('提示','操作成功');
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function disable()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new WebhookModel();
        list($ret , $msg) = $model->updateById($id,['enable'=>'0']);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '操作失败:'.$msg);
        } else {
            $this->ajaxSuccess('提示','操作成功');
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
        if (isset($_POST['url']) && empty($_POST['url'])) {
            $errorMsg['url'] = 'url不能为空';
        }

        $pattern="#(http|https)://(.*\.)?.*\..*#i";
        if(!preg_match($pattern,$_POST['url'])){
            $errorMsg['url'] = 'url格式不正确';
        }

        $model = new WebHookModel();
        if (isset($model->getByName($_POST['name'])['id'])  && !empty($_POST['name'])) {
            $errorMsg['name'] = '名称已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $name = trimStr($_POST['name']);
        $info = [];
        $info['name'] = $name;
        $info['url'] = $_POST['url'];
        $info['enable'] = '1';
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['secret_token'])) {
            $info['secret_token'] = $_POST['secret_token'];
        }
        if (isset($_POST['timeout'])) {
            $info['timeout'] = (int)$_POST['timeout'];
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
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

        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (isset($_POST['url']) && empty($_POST['url'])) {
            $errorMsg['url'] = 'url不能为空';
        }

        $pattern="#(http|https)://(.*\.)?.*\..*#i";
        if(isset($_POST['url']) && !preg_match($pattern,$_POST['url'])){
            $errorMsg['url'] = 'url格式不正确';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }


        $id = (int)$id;
        $model = new WebHookModel();
        $row = $model->getById($id);
        if (!isset($row['id'])) {
            $this->ajaxFailed('参数错误,数据不存在');
        }
        unset($row);

        $info = [];
        if (isset($_POST['name'])) {
            $info['name'] = $_POST['name'];
        }

        if (isset($_POST['url'])) {
            $info['url'] = $_POST['url'];
        }
        if (isset($_POST['secret_token'])) {
            $info['secret_token'] = $_POST['secret_token'];
        }
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['timeout'])) {
            $info['timeout'] = (int)$_POST['timeout'];
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
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new WebHookModel();
        $model->deleteById($id);

        $this->ajaxSuccess("提示",'操作成功');

    }
}
