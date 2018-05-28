<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\project\ProjectModel;

/**
 *  IssueModel 测试类
 * User: sven
 */
class TestIssueModel extends TestBaseIssueModel
{
    /**
     * issue 数据
     * @var array
     */
    public static $user = [];

    /**
     * project 数据
     * @var array
     */
    public static $project = [];

    public static $insertIdArr = [];

    public static function setUpBeforeClass()
    {
        self::$user = self::initUser();
        self::$project = self::initProject();
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 初始化用户
     */
    public static function initUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);

        // 表单数据 $post_data
        $postData = [];
        $postData['username'] = $username;
        $postData['phone'] = $username;
        $postData['email'] = $username . '@masterlab.org';
        $postData['display_name'] = $username;
        $postData['status'] = UserLogic::STATUS_OK;
        $postData['openid'] = UserAuth::createOpenid($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            parent::fail('initUser  failed,' . $msg);
            return;
        }
        $user = $userModel->getRowById($msg);
        return $user;
    }

    /**
     * 初始化项目
     * @return array|void
     */
    public static function initProject()
    {
        $projectName = 'project-' . mt_rand(12345678, 92345678);

        // 表单数据 $post_data
        $postData = [];
        $postData['name'] = $projectName;
        $postData['origin_id'] = 1;
        $postData['key'] = $projectName;
        $postData['create_uid'] = 1;
        $postData['type'] = 1;

        $model = new ProjectModel();
        list($ret, $insertId) = $model->insert($postData);
        if (!$ret) {
            parent::fail('initUser  failed,' . $insertId);
            return;
        }
        $row = $model->getRowById($insertId);
        return $row;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $model = new IssueModel();
        $model->deleteItemById(self::$issue['id']);

        if (!empty(self::$insertIdArr)) {
            foreach (self::$insertIdArr as $id){
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        // 1. 新增测试需要的数据
        $userId = self::$user['id'];
        $summary = 'testIssue';
        $projectId = self::$project['id'];
        $issueTypeId = 1;
        $priority = 1;
        $resolve = 1;

        // 表单数据 $post_data
        $info = [];
        $info['summary'] = $summary;
        $info['uid'] = $userId;
        $info['project_id'] = $projectId;
        $info['issue_type'] = $issueTypeId;
        $info['priority'] = $priority;
        $info['resolve'] = $resolve;

        $model = new IssueModel();
        list($ret, $issueId) = $model->insertItem($info);
        $this->assertTrue($ret, $issueId);
        if($ret){
            self::$insertIdArr[] = $issueId;
        }
        $issue = $model->getById($issueId);
        $this->assertNotEmpty($issue);
        foreach($info as $key =>$val ){
            $this->assertEquals($val, $issue[$key]);
        }

        // 2.测试 getItemById
        $row = $model->getItemById($issueId);
        $this->assertNotEmpty($row);
        foreach($info as $key =>$val ){
            $this->assertEquals($val, $row[$key]);
        }

        // 3.测试 updateItemById
        $updateInfo = [];
        $updateInfo['summary'] = $summary.'-updated';
        list($ret, $msg) = $model->updateItemById($issueId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getItemById($issueId);
        $this->assertEquals($updateInfo['summary'], $row['version_id']);

        // 4. 测试 getItemsByProjectId
        $rows = $model->getItemsByProjectId($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);

        // 5.删除
        $ret = (bool)$model->deleteItemById($issueId);
        $this->assertTrue($ret);
    }
}
