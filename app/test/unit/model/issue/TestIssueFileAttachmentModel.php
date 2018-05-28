<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFileAttachmentModel;

/**
 *  IssueFileAttachmentModel 测试类
 * User: sven
 */
class TestIssueFileAttachmentModel extends TestBaseIssueModel
{
    /**
     * issue 数据
     * @var array
     */
    public static $issue = [];

    public static function setUpBeforeClass()
    {
        self::$issue = self::initIssue();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }
    /**
     * 初始化用户
     */
    public static function initIssue()
    {
        $userId = 1;
        $summary = 'testSummary';
        $projectId = 1;
        $issueTypeId = 1;
        $priority = 1;
        $resolve = 1;

        // 表单数据 $post_data
        $info = [];
        $info['summary'] = $summary;
        $info['creator'] = $userId;
        $info['project_id'] = $projectId;
        $info['issue_type'] = $issueTypeId;
        $info['priority'] = $priority;
        $info['resolve'] = $resolve;

        $model = new IssueModel();
        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            //var_dump('TestBaseUserModel initUser  failed,' . $msg);
            parent::fail(__CLASS__.' initIssue  failed,' . $issueId);
            return;
        }
        $issue = $model->getRowById($issueId);
        return $issue;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $model = new IssueModel();
        $model->deleteItemById(self::$issue['id']);
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new IssueFileAttachmentModel();
        // 1. 新增测试需要的数据
        $issueId = self::$issue['id'];
        $uuid = 'uuid-' . mt_rand(12345678, 92345678);
        $info = [];
        $info['uuid'] = $uuid;
        $info['mime_type'] = 'test-mime_type';
        $info['file_name'] = 'null';
        $info['origin_name'] = 'test-origin_name';
        $info['file_size'] = 1;
        $info['file_ext'] = '.test';
        $info['author'] = 1;
        $info['created'] = time();
        list($ret, $insertId) = $model->add($issueId, $info);
        $this->assertTrue($ret, $insertId);

        // 2.测试 getByEmail
        $row = $model->getById($insertId);
        $this->assertEquals($uuid, $row['uuid']);
        $this->assertEquals($issueId, $row['issue_id']);
        $this->assertEquals($info['mime_type'], $row['mime_type']);
        $this->assertEquals($info['origin_name'], $row['origin_name']);
        $this->assertEquals($info['file_size'], $row['file_size']);
        $this->assertEquals($info['file_ext'], $row['file_ext']);
        $this->assertEquals($info['author'], $row['author']);
        $this->assertEquals($info['created'], $row['created']);

        // 3.测试 getByUuid
        $row = $model->getByUuid($uuid);
        $this->assertEquals($uuid, $row['uuid']);
        $this->assertEquals($issueId, $row['issue_id']);
        $this->assertEquals($info['mime_type'], $row['mime_type']);
        $this->assertEquals($info['origin_name'], $row['origin_name']);
        $this->assertEquals($info['file_size'], $row['file_size']);
        $this->assertEquals($info['file_ext'], $row['file_ext']);
        $this->assertEquals($info['author'], $row['author']);
        $this->assertEquals($info['created'], $row['created']);
        
        // 4. 测试 getsByIssueId
        $rows = $model->getsByIssueId($issueId);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);

        // 5.删除
        $ret = (bool)$model->deleteByUuid($uuid);
        $this->assertTrue($ret);
        $model->deleteById($insertId);
    }
}
