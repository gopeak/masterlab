<?php
/**
 *
 * B2B系统测试基类，基类主要确保各项资源配置正确。维持一个稳定干净的测试环境。
 *
 * @version    php v7.1.1
 * @see        PHPUnit_Framework_TestCase
 * @link
 */

namespace main\app\test;

use main\app\classes\ProjectLogic;
use \main\app\model\project\ProjectModel;
use \main\app\model\project\ProjectModuleModel;
use \main\app\model\project\ProjectVersionModel;
use \main\app\model\project\ProjectUserRoleModel;
use \main\app\model\project\ProjectLabelModel;
use main\app\model\user\PermissionSchemeModel;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\WorkflowModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\agile\SprintModel;
use main\app\model\OrgModel;
use main\app\classes\UserAuth;

class BaseDataProvider extends BaseTestCase
{
    public static $insertProjectIdArr = [];

    public static $insertUserIdArr = [];

    public static $insertSchemeIdArr = [];

    public static $insertTypeSchemeIdArr = [];

    public static $insertUserProjectRoleArr = [];

    public static $insertUserGroupIdArr = [];

    public static $insertOrgIdArr = [];

    public static $insertIssueIdArr = [];

    public static $insertSprintIdArr = [];

    public static $insertModuleIdArr = [];

    public static $insertVersionIdArr = [];

    public static $insertLabelIdArr = [];

    public static $insertWorkflowIdArr = [];

    public static $insertIssueTypeIdArr = [];

    public static $insertFileAttchIdArr = [];

    /**
     *
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function createUser($info = [])
    {
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';
        $password = UserAuth::createPassword($originPassword);

        if (!isset($info['username'])) {
            $info['username'] = $username;
        }
        if (!isset($info['phone'])) {
            $info['phone'] = $username;
        }
        if (!isset($info['email'])) {
            $info['email'] = $username . '@masterlab.org';
        }
        if (!isset($info['display_name'])) {
            $info['display_name'] = $username;
        }
        if (!isset($info['status'])) {
            $info['status'] = UserModel::STATUS_NORMAL;
        }
        if (!isset($info['password'])) {
            $info['password'] = $password;
        }
        if (!isset($info['openid'])) {
            $info['openid'] = UserAuth::createOpenid($info['email']);
        }
        $model = new UserModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . $insertId);
            return [];
        }
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createOrg($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-org-' . mt_rand(100, 999);
        }
        if (!isset($info['path'])) {
            $info['path'] = 'test-path-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        $model = new OrgModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initScheme  failed,' . $insertId);
            return [];
        }
        self::$insertOrgIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createProject($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'project-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['org_path'])) {
            $info['org_path'] = 'default';
        }
        if (!isset($info['key'])) {
            $info['key'] = 'TESTKEY' . strtoupper(quickRandom(5).mt_rand(12345678, 92345678)); //$info['name'];
        }
        if (!isset($info['org_id'])) {
            $info['org_id'] = 0;
        }
        if (!isset($info['create_uid'])) {
            $info['create_uid'] = 0;
        }
        if (!isset($info['type'])) {
            $info['type'] = ProjectLogic::PROJECT_TYPE_SCRUM;
        }

        if (!isset($info['permission_scheme_id'])) {
            $info['permission_scheme_id'] = 0;
        }

        if (!isset($info['workflow_scheme_id'])) {
            $info['workflow_scheme_id'] = 0;
        }

        $model = new ProjectModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . $insertId);
            return [];
        }
        self::$insertProjectIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }


    public static function createProjectModule($info=[])
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name';
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        if (!isset($info['lead'])) {
            $info['lead'] = 0;
        }
        if (!isset($info['default_assignee'])) {
            $info['default_assignee'] = 0;
        }

        $model = new ProjectModuleModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createProjectModule  failed,' . $insertId);
            return [];
        }
        self::$insertModuleIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createProjectVersion($info)
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name-'.quickRandomStr(10);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }
        if (!isset($info['sequence'])) {
            $info['sequence'] = 0;
        }
        if (!isset($info['released'])) {
            $info['released'] = 0;
        }

        $model = new ProjectVersionModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initVersion  failed,' . $insertId);
            return [];
        }
        self::$insertVersionIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createProjectLabel($info = [])
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['title'])) {
            $info['title'] = 'test-title-label-' . quickRandom(5);
        }
        if (!isset($info['color'])) {
            $info['color'] = '#FFFFFF';
        }
        if (!isset($info['bg_color'])) {
            $info['bg_color'] = '#FF0000';
        }

        $model = new ProjectLabelModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createProjectLabel  failed,' . $insertId);
            return [];
        }
        self::$insertLabelIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createPermissionScheme($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-name-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        $model = new PermissionSchemeModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . $insertId);
            return [];
        }
        self::$insertSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createUserProjectRole($uid, $projectId, $roleId)
    {
        $model = new ProjectUserRoleModel();
        list($ret, $insertId) = $model->insertRole($uid, $projectId, $roleId);
        if (!$ret) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . $insertId);
            return [];
        }
        self::$insertUserProjectRoleArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createUserGroup($uid, $groupId)
    {
        $model = new UserGroupModel();
        list($ret, $insertId) = $model->add($uid, $groupId);
        if (!$ret) {
            var_dump(__CLASS__ . '/createUserGroup  failed,' . $insertId);
            return [];
        }
        self::$insertUserGroupIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createTypeScheme($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-type-scheme-name-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-type-scheme-description';
        }

        $model = new IssueTypeSchemeModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createTypeScheme  failed,' . $insertId);
            return [];
        }
        self::$insertTypeSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createIssue($info = [])
    {
        if (!isset($info['summary'])) {
            $info['summary'] = 'test-summary-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }
        if (!isset($info['environment'])) {
            $info['environment'] = 'test-environment';
        }
        if (!isset($info['creator'])) {
            $info['creator'] = 0;
        }
        if (!isset($info['modifier'])) {
            $info['modifier'] = 0;
        }
        if (!isset($info['reporter'])) {
            $info['reporter'] = 0;
        }
        if (!isset($info['assignee'])) {
            $info['assignee'] = 0;
        }
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['sprint'])) {
            $info['sprint'] = 0;
        }
        if (!isset($info['issue_type'])) {
            $info['issue_type'] = 1;
        }
        if (!isset($info['priority'])) {
            $info['priority'] = 1;
        }
        if (!isset($info['resolve'])) {
            $info['resolve'] = 1;
        }
        if (!isset($info['status'])) {
            $info['status'] = 1;
        }
        if (!isset($info['created'])) {
            $info['created'] = time();
        }
        if (!isset($info['updated'])) {
            $info['updated'] = 0;
        }
        if (!isset($info['start_date'])) {
            $info['start_date'] = date('Y-m-d');
        }
        if (!isset($info['due_date'])) {
            $info['due_date'] = '';
        }
        if (!isset($info['resolve_date'])) {
            $info['resolve_date'] = '';
        }
        if (!isset($info['module'])) {
            $info['module'] = 0;
        }
        if (!isset($info['sprint'])) {
            $info['sprint'] = 0;
        }

        $model = new IssueModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . $insertId);
            return [];
        }
        self::$insertIssueIdArr[] = $insertId;
        $issue = $model->getRowById($insertId);
        return $issue;
    }

    public static function createSprint($info)
    {
        if (!isset($info['project_id'])) {
            $info['project_id'] = 0;
        }
        if (!isset($info['name'])) {
            $info['name'] = 'test-name';
        }
        if (!isset($info['active'])) {
            $info['active'] = 0;
        }
        if (!isset($info['status'])) {
            $info['status'] = 0;
        }
        if (!isset($info['order_weight'])) {
            $info['order_weight'] = 0;
        }

        $model = new SprintModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createSprint  failed,' . $insertId);
            return [];
        }
        self::$insertSprintIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createWorkflow($info = [])
    {
        $model = new WorkflowModel();
        // 1. 新增测试需要的数据
        $info['name'] = 'test-name-' . mt_rand(11111, 999999);
        $info['description'] = 'test-description';
        $info['create_uid'] = 1;
        $info['steps'] = 0;
        $info['data'] = '{}';
        $info['is_system'] = 0;
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createWorkflow  failed,' . $insertId);
            return [];
        }
        self::$insertWorkflowIdArr  = $insertId;
        return $model->getRowById($insertId);
    }

    public static function createFineUploaderJson($fileInfo = [])
    {
        $uuid = 'uuid-' . mt_rand(10000, 999999);
        if (!isset($fileInfo['uuid'])) {
            $fileInfo['uuid'] = $uuid;
        }
        if (!isset($fileInfo['mime_type'])) {
            $fileInfo['mime_type'] = 'image/png';
        }
        if (!isset($fileInfo['file_name'])) {
            $fileInfo['file_name'] = 'unittest/sample.png';
        }
        if (!isset($fileInfo['origin_name'])) {
            $fileInfo['origin_name'] = 'sample.png';
        }
        if (!isset($fileInfo['file_size'])) {
            $fileInfo['file_size'] = 44055;
        }
        if (!isset($fileInfo['file_ext'])) {
            $fileInfo['file_ext'] = 'png';
        }
        if (!isset($fileInfo['author'])) {
            $fileInfo['author'] = '0';
        }
        $fileInfo['created'] = time();
        $model = new IssueFileAttachmentModel();
        list($ret, $insertId) = $model->insert($fileInfo);
        self::$insertFileAttchIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        if (!$ret) {
            var_dump(__CLASS__ . '/createFineUploaderJson  failed,' . $insertId);
            return ['[]', []];
        }
        $uploadObj = [];
        $uploadObj['uuid'] = $fileInfo['uuid'];
        $uploadObj['name'] = $fileInfo['origin_name'];
        $uploadObj['originalName'] = $fileInfo['origin_name'];
        $uploadObj['size'] = $fileInfo['file_size'];
        $uploadObj['status'] = 'upload successful';
        $uploadObj['file']['qqButtonId'] = '3607e1bb-14c3-4802-b165-f5261a60b2c6';
        $uploadObj['file']['qqThumbnailId'] = 0;
        $uploadObj['batchId'] = 'e3197434-dec5-496e-99fc-6b4a98e5d3f0';
        $uploadObj['id'] = 0;
        $uploadObj['insert_id'] = $insertId;
        $arr[] = $uploadObj;
        return [json_encode($arr), $row];
    }
    public static function createIssueType($info = [])
    {
        $model = new IssueTypeModel();
        // 1. 新增测试需要的数据
        $info['name'] = 'test-name' . mt_rand(12345678, 92345678);
        $info['_key'] = 'test-key' . mt_rand(12345678, 92345678);
        $info['sequence'] = mt_rand(10, 100);
        $info['description'] = 'test-description1';
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/createIssueType  failed,' . $insertId);
            return [];
        }
        self::$insertIssueTypeIdArr = $insertId;
        return $model->getRowById($insertId);
    }



    public static function deleteIssueType($id)
    {
        $model = new IssueTypeModel();
        return $model->deleteById($id);
    }

    public static function deleteIssue($id)
    {
        $model = new IssueModel();
        return $model->deleteById($id);
    }

    public static function deleteFileAttachment($id)
    {
        $model = new IssueFileAttachmentModel();
        return $model->deleteById($id);
    }

    public static function deleteUser($id)
    {
        $conditions['uid'] = $id;
        $model = new UserModel();
        return $model->delete($conditions);
    }

    public static function deleteOrg($id)
    {
        $model = new OrgModel();
        return $model->deleteById($id);
    }

    public static function deleteProject($id)
    {
        $conditions['id'] = $id;
        $model = new ProjectModel();
        return $model->delete($conditions);
    }

    public static function deleteSprint($id)
    {
        $model = new SprintModel();
        return $model->deleteById($id);
    }

    public static function deleteWorkflow($id)
    {
        $model = new WorkflowModel();
        return $model->deleteById($id);
    }

    public static function deleteModule($id)
    {
        $model = new ProjectModuleModel();
        return $model->deleteById($id);
    }

    public static function deleteProjectVersion($id)
    {
        $model = new ProjectVersionModel();
        return $model->deleteById($id);
    }

    public static function deleteProjectLabel($id)
    {
        $model = new ProjectLabelModel();
        return $model->deleteById($id);
    }


    public static function deletePermissionScheme($id)
    {
        $conditions['uid'] = $id;
        $model = new PermissionSchemeModel();
        return $model->delete($conditions);
    }

    public static function deleteUserProjectRole($id)
    {
        $model = new ProjectUserRoleModel();
        return $model->deleteById($id);
    }

    public static function deleteUserGroup($id)
    {
        $model = new UserGroupModel();
        return $model->deleteById($id);
    }

    public static function deleteTypeScheme($id)
    {
        $model = new IssueTypeSchemeModel();
        return $model->deleteById($id);
    }
}
