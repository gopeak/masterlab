<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFixVersionModel;

/**
 *  IssueFixVersionModel 测试类
 * User: sven
 */
class TestIssueFixVersionModel extends TestBaseIssueModel
{
    /**
     * issue 数据
     * @var array
     */
    public static $issue = [];

    public static $insertIdArr = [];

    public static function setUpBeforeClass()
    {
        self::$issue = self::initIssue();
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 初始化issue
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
            parent::fail(__CLASS__ . ' initIssue  failed,' . $issueId);
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

        if (!empty(self::$insertIdArr)) {
            $model = new IssueFixVersionModel();
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new IssueFixVersionModel();
        // 1. 新增测试需要的数据
        $issueId = self::$issue['id'];
        $versionId = 1;
        $info = [];
        $info['version_id'] = $versionId;
        list($ret, $insertId) = $model->insertItemByIssueId($issueId, $info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        // 2.测试 getItemById
        $row = $model->getItemById($insertId);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        $info = [];
        $info['version_id'] = '2';
        list($ret, $insertId2) = $model->insertItemByIssueId($issueId, $info);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }


        // 3.测试 updateItemId
        $updateInfo = [];
        $updateInfo['version_id'] = '2';
        list($ret, $msg) = $model->updateItemById($insertId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getItemById($insertId);
        $this->assertEquals($updateInfo['version_id'], $row['version_id']);

        // 4. 测试 getItemsByIssueId
        $rows = $model->getItemsByIssueId($issueId);
        $this->assertNotEmpty($rows);
        $this->assertCount(2, $rows);

        // 5.删除
        $ret = (bool)$model->deleteItemById($insertId);
        $this->assertTrue($ret);
        $ret = (bool)$model->deleteItemByIssueId($insertId);
        $this->assertTrue($ret);
    }
}
