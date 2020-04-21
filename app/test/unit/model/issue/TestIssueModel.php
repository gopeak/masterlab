<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\test\BaseDataProvider;
use main\app\test\unit\BaseUnitTranTestCase;

/**
 *  IssueModel 测试类
 * User: sven
 */
class TestIssueModel extends BaseUnitTranTestCase
{


    public static $insertIdArr = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

    }

    /**
     * 确保生成的测试数据被清除
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }


    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        // 1. 新增测试需要的数据
        $userId = 100001;
        $summary = 'testIssue';
        $projectId = 100086;
        $issueTypeId = 1;
        $priority = 1;
        $resolve = 1;

        // 表单数据 $post_data
        $info = [];
        $info['summary'] = $summary;
        $info['creator'] = $userId;
        $info['assignee'] = $userId;
        $info['project_id'] = $projectId;
        $info['issue_type'] = $issueTypeId;
        $info['priority'] = $priority;
        $info['resolve'] = $resolve;

        $model = new IssueModel();
        list($ret, $issueId) = $model->insertItem($info);
        $this->assertTrue($ret, $issueId);
        if ($ret) {
            self::$insertIdArr[] = $issueId;
        }
        self::$issue = $issue = $model->getById($issueId);
        $this->assertNotEmpty($issue);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $issue[$key]);
        }

        // 2.测试 getById
        $row = $model->getById($issueId);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 3.测试 updateItemById
        $updateInfo = [];
        $updateInfo['summary'] = $summary . '-updated';
        list($ret, $msg) = $model->updateItemById($issueId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getById($issueId);
        $this->assertEquals($updateInfo['summary'], $row['summary']);

        // 4. 测试 getItemsByProjectId
        $rows = $model->getItemsByProjectId($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);

        // 5.删除
        $ret = (bool)$model->deleteItemById($issueId);
        $this->assertTrue($ret);
    }
}
