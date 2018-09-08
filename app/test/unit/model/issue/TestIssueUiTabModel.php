<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *  IssueUiTabModel.php 测试类
 * User: sven
 */
class TestIssueUiTabModel extends TestBaseIssueModel
{

    public static $insertIdArr = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }


    /**
     * 清除数据
     */
    public static function clearData()
    {
        $model = new IssueUiTabModel();
        if (!empty(self::$insertIdArr)) {
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     *
     */
    public function testMain()
    {
        // 1.测试默认的ui配置
        $issueBugTypeId = IssueTypeModel::getInstance()->getIdByKey('bug');
        $uiType = 'test-type';
        $tabName = 'test-tab';
        $model = new IssueUiTabModel();

        // 2.测试插入
        list($ret, $insertId) = $model->add($issueBugTypeId, 1, $tabName, $uiType);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        $createUIConfigs = $model->getItemsByIssueTypeIdType($issueBugTypeId, $uiType);
        $this->assertNotEmpty($createUIConfigs);
        $this->assertCount(1, $createUIConfigs);

        $deleteCount = (int) $model->deleteByIssueType($issueBugTypeId, $uiType);
        $this->assertEquals(1, $deleteCount);
        // 5.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
