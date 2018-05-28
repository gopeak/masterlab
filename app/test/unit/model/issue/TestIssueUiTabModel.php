<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\model\project\ProjectModel;

/**
 *  IssueUiTabModel.php 测试类
 * User: sven
 */
class TestIssueUiTabModel extends TestBaseIssueModel
{

    /**
     * project 数据
     * @var array
     */
    public static $project = [];

    public static $insertIdArr = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
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
     * 初始化项目
     * @return array
     * @throws \Exception
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
            parent::fail(__CLASS__.'/initProject  failed,' . $insertId);
            return [];
        }
        $row = $model->getRowById($insertId);
        return $row;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$project['id']);

        $model = new IssueUiTabModel();
        if (!empty(self::$insertIdArr)) {
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
        // 1.测试默认的ui配置
        $projectId = self::$project['id'];
        $issueBugTypeId = IssueTypeModel::getInstance()->getIdByKey('bug');
        $uiType = 'test-type';
        $tabName = 'test-tab';
        $model = new IssueUiTabModel();

        // 2.测试插入
        list($ret, $insertId) = $model->add($projectId, $issueBugTypeId, 1, $tabName, $uiType);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        $createUIConfigs = $model->getItemsByIssueTypeIdType($projectId, $issueBugTypeId, $uiType);
        $this->assertNotEmpty($createUIConfigs);
        $this->assertCount(1, $createUIConfigs);

        $deleteCount = (int) $model->deleteByIssueType($projectId, $issueBugTypeId, $uiType);
        $this->assertEquals(1, $deleteCount);
        // 5.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
