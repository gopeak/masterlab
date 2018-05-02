<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\user\UserModel;
use main\app\classes\ProjectLogic;

/**
 * 项目
 */
class Main extends BaseUserCtrl
{

    public function test()
    {
        $this->ajaxFailed("fdddddd");
    }

    public function index()
    {

        $projectModel = new ProjectModel();
        $list = $projectModel->getAll();

        $data = [];
        $data['list'] = $list;
        $data['title'] = '浏览 项目';
        $data['sub_nav_active'] = 'project';
        $this->render('gitlab/project/main.php', $data);
    }


    public function _new()
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        $data = [];
        $data['title'] = '项目分类';
        $data['sub_nav_active'] = 'project';
        $data['users'] = $users;
        $this->render('gitlab/project/main_form.php', $data);

    }

    public function home()
    {

        $projectModel = new ProjectModel();
        $info = $projectModel->getById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['data']['info'] = $info['description'];

        $data['title'] = 'Home';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'home';

        $data['project_id'] = $_GET[ProjectLogic::PROJECT_GET_PARAM_ID];

        $this->render('gitlab/project/home.php', $data);
    }

    public function activity()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'activity';

        $this->render('gitlab/project/activity.php', $data);
    }

    public function cycleAnalytics()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'cycle_analytics';

        $this->render('gitlab/project/cycle_analytics.php', $data);
    }


    /**
     * @param $name
     * @param $key
     * @param $type
     * @param string $url
     * @param string $category
     * @param string $avatar
     * @param string $description
     */
    public function add($params)
    {
        // @todo 判断权限:全局权限和项目角色
        // dump($params);exit;
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        if ( isset($params['name']) && empty(trimStr($params['name'])) ) {
            $this->ajaxFailed('param_error:name_is_null');
        }
        if ( isset($params['key']) && empty(trimStr($params['key'])) ) {
            $this->ajaxFailed('param_error:key_is_null');
        }
        if ( isset($params['type']) && empty(trimStr($params['type'])) ) {
            $this->ajaxFailed('param_error:type_is_null');
        }
        if ( $projectModel->checkNameExist($params['name']) ) {
            $this->ajaxFailed('param_error:name_exist');
        }
        if ( $projectModel->checkKeyExist($params['key']) ) {
            $this->ajaxFailed('param_error:key_exist');
        }

        if ( !preg_match("/^[a-zA-Z\s]+$/", $params['key']) ) {
            $this->ajaxFailed('param_error:must_be_abc');
        }

        if ( strlen($params['key']) > 10 ) {
            $this->ajaxFailed('param_error:key_max_10');
        }
        $params['key'] = trimStr($params['key']);
        $params['name'] = trimStr($params['name']);
        $params['type'] = intval($params['type']);

        if ( !isset($params['lead']) || empty($params['lead']) ) {
            $params['lead'] = $uid;
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['key'] = $params['key'];
        $info['lead'] = $params['lead'];
        $info['description'] = $params['description'];
        $info['type'] = $params['type'];
        $info['category'] = 0;
        $info['url'] = $params['url'];
        $info['create_time'] = time();
        $info['create_uid'] = $uid;
        //$info['avatar'] = !empty($avatar) ? $avatar : "";

        $ret = $projectModel->addProject($info, $uid);
        if ( !$ret['errorCode'] ) {
            $skey = sprintf("%u", crc32($info['key']));
            $this->jump("/project/main/home?project_id={$ret['data']['project_id']}&skey={$skey}");
        } else {
            $this->ajaxFailed('add_failed');
        }

    }


    public function update($project_id, $name, $key, $type, $url = '', $category = '', $avatar = '', $description = '')
    {

        // @todo 判断权限:全局权限和项目角色
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        $this->param_valid($projectModel, $name, $key, $type);


        $project_id = intval($project_id);

        $info = [];
        if ( isset($_REQUEST['name']) ) {
            $name = trimStr($_REQUEST['name']);
            if ( $projectModel->checkIdNameExist($project_id, $name) ) {
                $this->ajaxFailed('param_error:name_exist');
            }
            $info['name'] = trimStr($_REQUEST['name']);
        }
        if ( isset($_REQUEST['key']) ) {
            $key = trimStr($_REQUEST['key']);
            if ( $projectModel->checkIdKeyExist($project_id, $key) ) {
                $this->ajaxFailed('param_error:key_exist');
            }
            $info['key'] = trimStr($_REQUEST['key']);
        }
        if ( isset($_REQUEST['type']) ) {
            $info['type'] = intval($_REQUEST['type']);
        }
        if ( isset($_REQUEST['lead']) ) {
            $info['lead'] = intval($_REQUEST['lead']);
        }
        if ( isset($_REQUEST['description']) ) {
            $info['description'] = $_REQUEST['description'];
        }
        if ( isset($_REQUEST['category']) ) {
            $info['category'] = (int) $_REQUEST['category'];
        }
        if ( isset($_REQUEST['url']) ) {
            $info['url'] = $_REQUEST['url'];
        }
        if ( isset($_REQUEST['avatar']) ) {
            $info['avatar'] = $_REQUEST['avatar'];
        }
        if ( empty($info) ) {
            $this->ajaxFailed('param_error:data_is_empty');
        }
        $project = $projectModel->getRowById($project_id);
        $ret = $projectModel->updateById($project_id, $info);
        if ( $ret[0] ) {
            if ( $project['key'] != $key ) {
                // @todo update issue key
            }
            $this->ajaxSuccess('add_success');
        } else {
            $this->ajaxFailed('add_failed');
        }
    }


    public function delete($project_id)
    {

        if (empty($project_id)) {
            $this->ajaxFailed('no_project_id');
        }
        // @todo 判断权限

        $uid = $this->getCurrentUid();
        $project_id = intval($project_id);
        $projectModel = new ProjectModel($uid);
        $ret = $projectModel->deleteById($project_id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            // @todo 删除问题

            // @todo 删除版本
            $projectVersionModel = new ProjectVersionModel($uid);
            $projectVersionModel->deleteByProject($project_id);

            // @todo 删除模块
            $projectModuleModel = new ProjectModuleModel($uid);
            $projectModuleModel->deleteByProject($project_id);

            $this->ajaxSuccess('success');
        }

    }


}
