<?php

namespace main\plugin\webhook;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\DBAL\ParameterType;
use main\app\ctrl\BaseCtrl;
use main\app\event\Events;
use main\app\model\PluginModel;
use main\plugin\BasePluginCtrl;
use main\plugin\webhook\model\WebHookLogModel;
use main\plugin\webhook\model\WebHookModel;

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

    public $eventArr = [];

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

        $data['default_hook_event_arr'] = [
            Events::onIssueCreateAfter,
            Events::onIssueUpdateAfter,
            Events::onIssueDelete,
            Events::onIssueClose,
            Events::onIssueAddComment
            ];
        $data['hook_event_arr'] =  $this->getEventArr();
        $this->twigRender('index.twig', $data);
    }

    public function log()
    {
        $data = [];
        $data['title'] = 'Webhook执行日志';
        $data['nav_links_active'] = 'webhook';
        $data['sub_nav_active'] = 'plugin';
        $data['plugin_name'] = $this->dirName;
        $data['hook_event_arr'] =  $this->getEventArr();
        $model = new WebHookModel();
        $webhooks = $model->getAllItem();
        $data = [];
        $data['webhook_arr'] = $webhooks;
        $data['hook_event_arr'] =  $this->getEventArr();
        $this->twigRender('log.twig', $data);
    }

    /**
     * 获取事件名称
     * @return mixed
     */
    private function getEventArr()
    {
        $arr['事项'] = [
            Events::onIssueCreateBefore=>'创建事项之前',
            Events::onIssueCreateAfter=>'创建事项之后',
            Events::onIssueCreateChild=>'创建子任务之后',
            Events::onIssueUpdateBefore=>'更新事项之前',
            Events::onIssueUpdateAfter=>'更新事项之后',
            Events::onIssueDelete=>'删除事项',
            Events::onIssueClose=>'关闭事项',
            Events::onIssueFollow=>'关注事项',
            Events::onIssueUnFollow=>'取消关注事项',
            Events::onIssueConvertChild=>'转换子任务事项',
            Events::onIssueBatchDelete=>'批量删除事项',
            Events::onIssueBatchUpdate=>'批量更新事项',
            Events::onIssueImportByExcel=>'导入事项',
            Events::onIssueRemoveChild=>'移除子任务',
            Events::onIssueUpload=>'附件上传',
            Events::onIssueMobileUpload=>'移动端附件上传',
            Events::onIssueDeleteUpload=>'删除附件',
        ];

        $arr['事项迭代'] = [
            Events::onIssueJoinSprint=>'事项加入迭代',
            Events::onIssueJoinClose=>'事项移动到关闭事项',
            Events::onIssueJoinBacklog=>'事项移动到待办事项',
        ];

        $arr['过滤器'] = [
            Events::onIssueAddAdvFilter=>'添加高级查询过滤器',
            Events::onIssueAddFilter=>'添加过滤器',
        ];

        $arr['评论'] = [
            Events::onIssueAddComment=>'添加评论',
            Events::onIssueDeleteComment=>'删除评论',
            Events::onIssueUpdateComment=>'编辑评论',
        ];

        $arr['项目'] = [
            Events::onProjectCreate=>'创建项目',
            Events::onProjectUpdate=>'编辑项目',
            Events::onProjectDelete=>'删除项目',
            Events::onProjectArchive=>'归档项目',
            Events::onProjectRecover=>'恢复项目',
        ];

        $arr['迭代管理'] = [
            Events::onSprintCreate=>'创建迭代',
            Events::onSprintUpdate=>'编辑迭代',
            Events::onSprintSetActive=>'设置迭代为进行时',
            Events::onSprintDelete=>'删除迭代',
        ];

        $arr['版本管理'] = [
            Events::onVersionCreate=>'创建版本',
            Events::onVersionUpdate=>'编辑版本',
            Events::onVersionDelete=>'删除办法',
            Events::onVersionRelease=>'发布版本',
        ];
        $arr['模块管理'] = [
            Events::onModuleCreate=>'创建模块',
            Events::onModuleUpdate=>'编辑模块',
            Events::onModuleDelete=>'删除模块',
        ];
        $arr['标签管理'] = [
            Events::onLabelCreate=>'标签模块',
            Events::onLabelUpdate=>'标签模块',
            Events::onLabelDelete=>'标签模块',
        ];
        $arr['分类管理'] = [
            Events::onCataloglCreate=>'分类模块',
            Events::onCatalogUpdate=>'分类模块',
            Events::onCatalogDelete=>'分类模块',
        ];
        $arr['项目成员'] = [
            Events::onProjectUserAdd=>'添加项目成员',
            Events::onProjectUserUpdateRoles=>'更新角色成员',
            Events::onProjectUserRemove=>'移除用户',
        ];
        $arr['项目角色'] = [
            Events::onProjectRoleAdd=>'添加项目角色',
            Events::onProjectRoleUpdate=>'编辑项目角色',
            Events::onProjectRoleRemove=>'删除项目角色',
            Events::onProjectRolePermUpdate=>'编辑角色权限',
            Events::onProjectRoleAddUser=>'角色添加用户',
            Events::onProjectRoleRemoveUser=>'角色移除用户',
        ];
        $arr['用户管理'] = [
            Events::onUserAddByAdmin=>'添加用户',
            Events::onUserUpdateByAdmin=>'编辑用户',
            Events::onUserActiveByAdmin=>'激活用户',
            Events::onUserDeleteByAdmin=>'删除用户',
            Events::onUserDisableByAdmin=>'禁用用户',
            Events::onUserBatchDisableByAdmin=>'批量禁用用户',
            Events::onUserBatchRecoveryByAdmin=>'批量恢复用户',
        ];
        $arr['用户相关'] = [
            Events::onUserRegister=>'用户注册',
            Events::onUserLogin=>'用户登录',
            Events::onUserlogout=>'用户注销',
            Events::onUserUpdateProfile=>'编辑资料',
        ];
        $arr['组织'] = [
            Events::onOrgCreate=>'创建组织',
            Events::onOrgUpdate=>'编辑组织',
            Events::onOrgDelete=>'删除组织',
        ];
        return $arr;
    }

    /**
     * 获取webhook执行日志
     * @throws \Exception
     */
    public function fetchLogs()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        list($logsArr, $total) = self::filterLogs($projectId, $page, $pageSize);
        $model = new WebHookModel();
        $webhooks = $model->getAllItem();
        $webhooksArr = array_column($webhooks, 'name','id');
        $labelArr = [];
        $labelArr[WebHookLogModel::STATUS_READY] = 'label-info';
        $labelArr[WebHookLogModel::STATUS_SUCCESS] = 'label-success';
        $labelArr[WebHookLogModel::STATUS_ASYNC_FAILED] = 'label-danger';
        $labelArr[WebHookLogModel::STATUS_FAILED] = 'label-danger';
        $labelArr[WebHookLogModel::STATUS_PENDING] = 'label-warning';
        foreach ($logsArr as &$row) {
            $row['webhook_name'] = $webhooksArr[$row['webhook_id']];
            $row['status_text'] = WebHookLogModel::$statusArr[$row['status']];
            $row['time_text'] = format_unix_time($row['time']);
            $row['time_full'] = format_unix_time($row['time'], time(), 'full_datetime_format');
            $row['status_bg'] = $labelArr[$row['status']];

        }
        $data['total'] = $total;
        $data['logs_arr'] = $logsArr;
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }

    public static function filterLogs($projectId, $page = 1, $pageSize = 50)
    {
        $start = $pageSize * ($page - 1);

        $model = new WebHookLogModel();
        $table = $model->getTable();
        $queryBuilder = $model->db->createQueryBuilder();
        $queryBuilder->select('*')->from($table);
        if(!empty($projectId)){
            $queryBuilder->andWhere('project_id =:project_id')->setParameter('project_id', $projectId,ParameterType::INTEGER);
        }

        if (isset($_GET['event_name'])  && !empty($_GET['event_name'])) {
            $queryBuilder->andWhere('event_name =:event_name')->setParameter('event_name', strval($_GET['event_name']),ParameterType::STRING);
        }
        if (isset($_GET['webhook_id']) && !empty($_GET['webhook_id'])) {
            $queryBuilder->andWhere('webhook_id =:webhook_id')->setParameter('webhook_id', intval($_GET['webhook_id']),ParameterType::INTEGER);
        }
        if (isset($_GET['start_datetime']) && !empty($_GET['start_datetime']) ) {
            $queryBuilder->andWhere('time >=:start_time')->setParameter('start_time', strtotime($_GET['start_datetime']),ParameterType::INTEGER);
        }
        if (isset($_GET['end_datetime'])  && !empty($_GET['end_datetime'])) {
            $queryBuilder->andWhere('time <=:end_time')->setParameter('end_time', strtotime($_GET['end_datetime']),ParameterType::INTEGER);
        }

        $count = (int)$queryBuilder->select('count(*) as cc')->execute()->fetchColumn();

        $queryBuilder->select('*');
        $orderBy = 'id';
        if (isset($_GET['sort_field'])) {
            $orderBy = trimStr($_GET['sort_field']);
        }
        $sortBy = 'DESC';
        if (isset($_GET['sort_by'])) {
            $sortBy = trimStr($_GET['sort_by']);
        }

        $queryBuilder->orderBy($orderBy, $sortBy)->setFirstResult($start)->setMaxResults($pageSize);
        // echo $queryBuilder->getSQL();
        $rows =  $queryBuilder->execute()->fetchAll();

        return [$rows, $count];
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
        $plugin['hook_event_arr'] = json_decode($plugin['hook_event_json'], true);

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
        $info['hook_event_json'] = "[]";
        if (isset($_POST['hook_events'])) {
            $info['hook_event_json'] =  json_encode($_POST['hook_events']);
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
        if (isset($_POST['hook_events'])) {
            $info['hook_event_json'] =  json_encode($_POST['hook_events']);
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
