<?php

namespace main\app\ctrl\admin;

use main\app\classes\PermissionGlobal;
use main\app\classes\SettingsLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\service\ProjectService;

/**
 * 后台的项目管理模块
 */
class Project extends BaseAdminCtrl
{
    public static $page_sizes = [10, 20, 50, 100];

    /**
     * 后台的项目管理的构造函数
     * Project constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $userId = UserAuth::getId();
        $this->addGVar('top_menu_active', 'system');
        $check = PermissionGlobal::check($userId, PermissionGlobal::MANAGER_PROJECT_PERM_ID);

        if (!$check) {
            $this->error('权限错误', '您还未获取此模块的权限！');
            exit;
        }
    }

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'list';
        $this->render('twig/admin/project/project_list.twig', $data);
    }

    public function pageArchived()
    {
        $data = [];
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'archived';
        $this->render('twig/admin/project/project_list_archived.twig', $data);
    }

    /**
     * 获取关联用户的项目数据
     * @throws \Exception
     */
    public function gets()
    {
        $projectLogic = new ProjectLogic();
        $rows = $projectLogic->projectListJoinUser();
        $this->ajaxSuccess('ok', $rows);
    }

    /**
     * 管理后台查询项目信息
     * @param $project_id
     * @throws \Exception
     */
    public function get($project_id)
    {
        $projectLogic = new ProjectLogic();
        $project = $projectLogic->info($project_id);

        $this->ajaxSuccess('ok', $project);
    }

    /**
     * 项目查询
     * @param int $page
     * @param int $is_archived
     * @throws \Exception
     */
    public function filterData($page = 1, $is_archived = 0)
    {
        $is_archived = intval($is_archived);
        $pageLength = 30;

        $projectLogic = new ProjectLogic();

        if ($is_archived) {
            $projects = $projectLogic->projectListJoinUserArchived();
        } else {
            $projects = $projectLogic->projectListJoinUser();
        }

        foreach ($projects as &$item) {
            $item = ProjectLogic::formatProject($item);
            if ($item['archived'] == 'Y') {
                $item['name'] = $item['name'] . ' [已归档]';
            }
        }
        unset($item);

        $data['total'] = count($projects);
        $data['page'] = $page;
        $data['pages'] = $pageLength;
        $data['rows'] = array_slice($projects, $page - 1, $pageLength); //$projects;

        $this->ajaxSuccess('操作成功', $data);
    }


    /**
     * 项目归档
     * @throws \Exception
     */
    public function doArchived()
    {
        $projectId = null;
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '参数错误');
        }

        $model = new ProjectModel();
        $ret = $model->updateById(['archived' => 'Y'], $projectId);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        } else {
            // 分发事件
            $event = new CommonPlacedEvent($this, $project=$model->getById($projectId));
            $this->dispatcher->dispatch($event,  Events::onProjectArchive);
            $this->ajaxSuccess('归档成功');
        }
    }

    /**
     * 删除项目
     * @throws \Exception
     */
    public function delete()
    {
        $projectId = null;
        $projectTypeId = null;

        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }


        if (isset($_REQUEST['project_type_id'])) {
            $projectTypeId = (int)$_REQUEST['project_type_id'];
        }
        if (empty($projectTypeId)) {
            $this->ajaxFailed('参数错误', '项目类型id不能为空');
        }

        $currentUid = $uid = UserAuth::getId();
        $model = $projectModel = new ProjectModel($uid);
        $project = $projectModel->getById($projectId);

        $model->db->beginTransaction();

        $retDelProject = $model->deleteById($projectId);
        if ($retDelProject) {
            // 删除对应的事项
            $issueModel = new IssueModel();
            $issueModel->deleteItemsByProjectId($projectId);

            // 删除版本
            $projectVersionModel = new ProjectVersionModel($uid);
            $projectVersionModel->deleteByProject($projectId);

            // 删除模块
            $projectModuleModel = new ProjectModuleModel($uid);
            $projectModuleModel->deleteByProject($projectId);

            // 删除标签
            $projectLabelModel = new ProjectLabelModel();
            $projectLabelModel->deleteByProject($projectId);

            // 删除分类
            $projectCatalogLabelModel = new ProjectCatalogLabelModel();
            $projectCatalogLabelModel->deleteByProject($projectId);

            // 删除初始化的角色
            $projectUserRoleModel = new ProjectUserRoleModel();
            $projectUserRoleModel->deleteByProject($projectId);

            // 分发事件
            $event = new CommonPlacedEvent($this, $project);
            $this->dispatcher->dispatch($event,  Events::onProjectDelete);
        }

        $model->db->commit();
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 克隆项目接口
     * @throws \Exception
     */
    public function clone()
    {
        $projectId = null;

        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $uid = UserAuth::getId();
        $projectModel = new ProjectModel($uid);
        $settingLogic = new SettingsLogic;
        $maxLengthProjectName = $settingLogic->maxLengthProjectName();
        $maxLengthProjectKey = $settingLogic->maxLengthProjectKey();

        $projectName = '';
        if (isset($_POST['project_name']) && !empty($_POST['project_name'])) {
            $projectName = trim($_POST['project_name']);
            if (strlen($projectName) == 0) {
                $this->ajaxFailed('参数错误', '项目名不能为空');
            }
            if (strlen($projectName) > $maxLengthProjectName) {
                $this->ajaxFailed('参数错误', '项目名长度太长,长度应该小于' . $maxLengthProjectName);
            }
            if ($projectModel->checkNameExist($projectName)) {
                $this->ajaxFailed('参数错误', '项目名已存在，请还一个。');
            }
        } else {
            $this->ajaxFailed('参数错误', '需要项目名称');
        }

        $projectKey = '';
        if (isset($_POST['project_key']) && !empty($_POST['project_key'])) {
            $projectKey = trim($_POST['project_key']);
            if (empty(trimStr($projectKey))) {
                $this->ajaxFailed('参数错误', '项目KEY不能为空');
            }
            if (strlen($projectKey) > $maxLengthProjectKey) {
                $this->ajaxFailed('参数错误', '项目KEY长度太长,长度应该小于' . $maxLengthProjectKey);
            }
            if (!preg_match("/^[a-zA-Z]+$/", $projectKey)) {
                $this->ajaxFailed('参数错误', '项目KEY必须全部为英文字母,不能包含空格和特殊字符');
            }
            if ($projectModel->checkKeyExist($projectKey)) {
                $this->ajaxFailed('参数错误', '项目KEY已经被使用了,请更换一个吧');
            }
        } else {
            $this->ajaxFailed('参数错误', '需要项目KEY');
        }

        $projectModel = new ProjectModel($uid);
        //$projectModel->beginTransaction();

        $cloneRawData = ProjectLogic::getRawProjectRelatedRows($projectId);

        unset($cloneRawData['project_row']['id']);
        $cloneRawData['project_row']['name'] = $projectName;
        $cloneRawData['project_row']['key'] = $projectKey;
        $cloneRawData['project_row']['description'] =  $projectName . ' 是一个克隆项目';
        $cloneRawData['project_row']['create_time'] = time();
        $cloneRawData['project_row']['un_done_count'] = 0;
        $cloneRawData['project_row']['done_count'] = 0;
        $cloneRawData['project_row']['closed_count'] = 0;

        list($ret, $newProjectId) = $projectModel->insert($cloneRawData['project_row']);

        if (!$ret) {
            $this->ajaxFailed('异常', '克隆项目失败.');
        }

        if (isset($_POST['sprint_selected']) && $_POST['sprint_selected'] == 1) {
            if (!empty($cloneRawData['sprint_rows'])) {
                foreach ($cloneRawData['sprint_rows'] as $key=>$item) {
                    unset($cloneRawData['sprint_rows'][$key]['id']);
                    $cloneRawData['sprint_rows'][$key]['project_id'] = $newProjectId;
                }
                $model = new SprintModel();
                $model->insertRows($cloneRawData['sprint_rows']);
            }
        }

        if (isset($_POST['version_selected']) && $_POST['version_selected'] == 1) {
            if (!empty($cloneRawData['version_rows'])) {
                foreach ($cloneRawData['version_rows'] as $key=>$item) {
                    unset($cloneRawData['version_rows'][$key]['id']);
                    $cloneRawData['version_rows'][$key]['project_id'] = $newProjectId;
                }
                $model = new ProjectVersionModel();
                $model->insertRows($cloneRawData['version_rows']);
            }
        }

        if (isset($_POST['module_selected']) && $_POST['module_selected'] == 1) {
            if (!empty($cloneRawData['module_rows'])) {
                foreach ($cloneRawData['module_rows'] as $key=>$item) {
                    unset($cloneRawData['module_rows'][$key]['id']);
                    unset($cloneRawData['module_rows'][$key]['k']);
                    $cloneRawData['module_rows'][$key]['project_id'] = $newProjectId;
                }
                $model = new ProjectModuleModel();
                $model->insertRows($cloneRawData['module_rows']);
            }
        }

        if (isset($_POST['label_selected']) && $_POST['label_selected'] == 1) {
            if (!empty($cloneRawData['label_rows'])) {
                foreach ($cloneRawData['label_rows'] as $key=>$item) {
                    unset($cloneRawData['label_rows'][$key]['id']);
                    $cloneRawData['label_rows'][$key]['project_id'] = $newProjectId;
                }
                $model = new ProjectLabelModel();
                $model->insertRows($cloneRawData['label_rows']);
            }
        }

        if (isset($_POST['catalog_label_selected']) && $_POST['catalog_label_selected'] == 1) {
            if (!empty($cloneRawData['catalog_label_rows'])) {
                foreach ($cloneRawData['catalog_label_rows'] as $key=>$item) {
                    unset($cloneRawData['catalog_label_rows'][$key]['id']);
                    $cloneRawData['catalog_label_rows'][$key]['project_id'] = $newProjectId;
                }
                $model = new ProjectCatalogLabelModel();
                $model->insertRows($cloneRawData['catalog_label_rows']);
            }
        }


        if (!empty($cloneRawData['role_rows'])) {
            $projectRoleModel = new ProjectRoleModel();
            $projectRoleRelationModel = new ProjectRoleRelationModel();
            $projectUserRoleModel = new ProjectUserRoleModel();
            foreach ($cloneRawData['role_rows'] as $key=>$item) {
                $previousRoleId = $cloneRawData['role_rows'][$key]['id'];
                unset($cloneRawData['role_rows'][$key]['id']);
                $cloneRawData['role_rows'][$key]['project_id'] = $newProjectId;
                list($bool, $newRoleId) = $projectRoleModel->insert($cloneRawData['role_rows'][$key]);

                if (!empty($cloneRawData['role_relation_rows'])) {
                    $tempRoleRelationRows = [];
                    foreach ($cloneRawData['role_relation_rows'] as $roleRelationRow) {
                        if ($previousRoleId == $roleRelationRow['role_id']) {
                            $roleRelationRow['project_id'] = $newProjectId;
                            $roleRelationRow['role_id'] = $newRoleId;
                            unset($roleRelationRow['id']);
                            $tempRoleRelationRows[] = $roleRelationRow;
                        }
                    }
                    if (!empty($tempRoleRelationRows)) {
                        $projectRoleRelationModel->insertRows($tempRoleRelationRows);
                        //print_r($tempRoleRelationRows);
                    }
                }

                if (!empty($cloneRawData['user_role_rows'])) {
                    $tempUserRoleRows = [];
                    foreach ($cloneRawData['user_role_rows'] as $userRoleRow) {
                        if ($previousRoleId == $userRoleRow['role_id']) {
                            $userRoleRow['project_id'] = $newProjectId;
                            $userRoleRow['role_id'] = $newRoleId;
                            unset($userRoleRow['id']);
                            $tempUserRoleRows[] = $userRoleRow;
                        }
                    }
                    if (!empty($tempUserRoleRows)) {
                        $projectUserRoleModel->insertRows($tempUserRoleRows);
                        //print_r($tempUserRoleRows);
                    }
                }
            }
        }

        $this->ajaxSuccess('项目克隆成功', $cloneRawData);
    }
}
