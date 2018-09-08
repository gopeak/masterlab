<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\TimelineModel;

/**
 *  TimelineModel 测试类
 * User: sven
 */
class TestTimelineModel extends TestBaseIssueModel
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
     * 初始化用户
     * @return array
     * @throws \Exception
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
            return [];
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
            $model = new TimelineModel();
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $model = new TimelineModel();
        // 1. 新增测试需要的数据
        $issueId = self::$issue['id'];
        $info = [];
        $info['uid'] = 0;
        $info['issue_id'] = $issueId;
        $info['content'] = 'test-content';
        $info['content_html'] = 'test-content_html';
        $info['time'] = time();
        $info['type'] = 'issue';
        $info['action'] = 'commented';
        list($ret, $insertId) = $model->insertItem($issueId, $info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        $info2 = $info;
        $info2['content'] = 'test-content2';
        $info2['content_html'] = 'test-content_html2';
        list($ret, $insertId2) = $model->insertItem($issueId, $info2);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }
        // 2.测试插入数据的正确性
        $row = $model->getRowById($insertId);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 3.测试 updateItemById
        $updateInfo = [];
        $updateInfo['content'] = 'test-content-updated';
        $updateInfo['content_html'] = 'test-content_html-updated';
        list($ret, $msg) = $model->updateById($insertId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getRowById($insertId);
        $this->assertNotEmpty($row);
        foreach ($updateInfo as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 4. 测试 getItemsByIssueId
        $rows = $model->getItemsByIssueId($issueId);
        $this->assertNotEmpty($rows);
        $this->assertCount(2, $rows);

        // 5.删除
        $ret = (bool)$model->deleteByIssueId($issueId);
        $this->assertTrue($ret);
    }
}
