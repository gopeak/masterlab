<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\admin;

use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserLogic;
use main\app\classes\UserAuth;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\CacheKeyModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\ProjectPermissionModel;
use main\app\model\ProjectTplLabelModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\ActivityModel;

/**
 * 项目模板的模块控制器
 */
class ProjectTplLabel extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function get($id = null)
    {
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $model = new ProjectTplLabelModel();
        $data = $model->getById($id);
        if (empty($data)) {
            $this->ajaxFailed('参数错误', '数据为空');
        }
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取项目的所有角色
     * @throws \Exception
     */
    public function fetchAll()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_tpl_id'])) {
            $projectId = (int)$_GET['project_tpl_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new ProjectTplLabelModel();
        $data['labels'] = $model->getByProject($projectId);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 新增一个自定义的角色
     * @param null $params
     * @throws \Exception
     */
    public function add()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_tpl_id'])) {
            $projectId = (int)$_GET['project_tpl_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $params = $_POST;
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $errorMsg = [];
        if (!isset($params['title']) || empty($params['title'])) {
            $errorMsg['title'] = '标题不能为空';
        }

        if (isset($params['title']) && empty($params['title'])) {
            $errorMsg['title'] = '名称不能为空';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['project_tpl_id'] = $projectId;
        $info['title'] = $params['title'];
        $info['color'] = '#FFFFFF';

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['bg_color'])) {
            $info['bg_color'] = $params['bg_color'];
        }

        $model = new ProjectTplLabelModel();
        if (isset($model->getByName($info['title'])['id'])) {
            $this->ajaxFailed('提示', '名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误:', '数据库插入失败,详情 :' . $msg);
        }
    }

    /**
     * 更新一个自定义的角色
     * @param array $params
     * @throws \Exception
     */
    public function update($params = [])
    {
        $id = null;
        $uid = $this->getCurrentUid();
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $errorMsg = [];
        if (empty($_POST)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        $model = new ProjectTplLabelModel();
        $currentRow = $model->getById($id);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'id错误,找不到对应的数据');
        }
        $row = $model->getByName($_POST['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $id = (int)$id;
        $info = [];
        $info['name'] = $_POST['name'];
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }


    /**
     * 删除用户角色
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $id = null;
        $uid = $this->getCurrentUid();
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = intval($id);
        $model = new ProjectTplLabelModel();
        $role = $model->getRowById($id);
        if (!isset($role['id'])) {
            $this->ajaxFailed('参数错误', '找不到对应的用户角色');
        }
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
        $this->ajaxSuccess('操作成功');
    }

}
