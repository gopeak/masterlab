<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserLogic;
use main\app\classes\UserAuth;
use main\app\model\permission\PermissionModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\ActivityModel;

/**
 * 项目成员控制器
 */
class Member extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目成员';
        parent::addGVar('top_menu_active', 'project');
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'project_member';
        $data = RewriteUrl::setProjectData($data);

        $data['current_uid'] = UserAuth::getId();

        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($data['project_id']);

        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
        }
        $data['project_users'] = $projectUsers;

        $projectRolemodel = new ProjectRoleModel();
        $data['roles'] = $projectRolemodel->getsByProject($data['project_id']);

        $this->render('gitlab/project/setting_member.php', $data);
    }
}
