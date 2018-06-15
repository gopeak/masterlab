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

use \main\app\model\project\ProjectModel;
use main\app\model\user\PermissionSchemeModel;
use main\app\model\user\UserProjectRoleModel;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueModel;
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
            $info['name'] = 'test-name-' . mt_rand(100, 999);
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
            var_dump(__CLASS__.'/initScheme  failed,' . $insertId);
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
        if (!isset($info['key'])) {
            $info['key'] = $info['name'];
        }
        if (!isset($info['origin_id'])) {
            $info['origin_id'] = 0;
        }
        if (!isset($info['create_uid'])) {
            $info['create_uid'] = 0;
        }
        if (!isset($info['type'])) {
            $info['type'] = 1;
        }

        if (!isset($info['permission_scheme_id'])) {
            $info['permission_scheme_id'] = 0;
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
        $model = new UserProjectRoleModel();
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
            var_dump(__CLASS__ . '/UserGroupModel  failed,' . $insertId);
            return [];
        }
        self::$insertUserGroupIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createTypeScheme($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-name-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        $model = new IssueTypeSchemeModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initScheme  failed,' . $insertId);
            return [];
        }
        self::$insertTypeSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function createIssue($info = [])
    {
        if (!isset($info['summary'])) {
            $info['summary'] = 'testSummary-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['creator'])) {
            $info['creator'] = 0;
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

        $model = new IssueModel();
        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            parent::fail(__CLASS__ . '/initIssue failed,' . $issueId);
            return [];
        }
        self::$insertIssueIdArr[] = $issueId;
        $issue = $model->getRowById($issueId);
        return $issue;
    }

    public static function deleteUser($id)
    {
        $conditions['uid'] = $id;
        $model = new UserModel();
        return $model->delete($conditions);
    }

    public static function deleteProject($id)
    {
        $conditions['uid'] = $id;
        $model = new ProjectModel();
        return $model->delete($conditions);
    }

    public static function deletePermissionScheme($id)
    {
        $conditions['uid'] = $id;
        $model = new PermissionSchemeModel();
        return $model->delete($conditions);
    }

    public static function deleteUserProjectRole($id)
    {
        $model = new UserProjectRoleModel();
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
