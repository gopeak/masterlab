<?php

namespace main\app\test\unit\model\issue;

use main\app\model\field\FieldModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\project\ProjectModel;

/**
 *  IssueUiModel 测试类
 * User: sven
 */
class TestIssueUiModel extends TestBaseIssueModel
{

    /**
     * project 数据
     * @var array
     */
    public static $project = [];

    public static $insertIdArr = [];

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
            parent::fail('initUser  failed,' . $insertId);
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
        $model = new IssueUiModel();
        $bugDefaultUiItems = $model->getItemsByProjectId($projectId, $issueBugTypeId);
        $this->assertNotEmpty($bugDefaultUiItems);
        foreach ($bugDefaultUiItems as $item) {
            $this->assertEquals($projectId, $item['project_id']);
            $this->assertEquals($issueBugTypeId, $item['issue_type_id']);
        }

        // 2.测试 getsByUiType
        $uiType = 'create';
        $createUIConfigs = $model->getsByUiType($projectId, $issueBugTypeId, $uiType);
        $this->assertNotEmpty($createUIConfigs);
        $first = current($createUIConfigs);
        foreach ($createUIConfigs as $item) {
            $this->assertEquals($projectId, $item['project_id']);
            $this->assertEquals($issueBugTypeId, $item['issue_type_id']);
            $this->assertEquals($uiType, $item['type']);
        }

        // 3.测试插入
        $fieldPriorityId = 2;
        $weight = (int)$first['order_weight'] + 10;
        list($ret, $insertId) = $model->addField($projectId, $issueBugTypeId, $uiType, $fieldPriorityId, 0, $weight);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        $createUIConfigs2 = $model->getsByUiType($projectId, $issueBugTypeId, $uiType);
        $this->assertNotEmpty($createUIConfigs2);
        $this->assertEquals(count($createUIConfigs2), count($createUIConfigs));

        // 4.测试排序
        $insertId1OrderWeight = parent::getArrItemOrderWeight($createUIConfigs2, 'id', $first['id']);
        $insertId2OrderWeight = parent::getArrItemOrderWeight($createUIConfigs2, 'id', $insertId);
        $this->assertTrue($insertId2OrderWeight < $insertId1OrderWeight);

        // 5.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);

        // 6.测试deleteByIssueType
        $newUiType = 'test-ui';
        $addNum = 10;
        for ($i = 0; $i <= $addNum; $i++) {
            list($ret, $insertId) = $model->addField($projectId, $issueBugTypeId, $newUiType, $i, 0, $i);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$insertIdArr[] = $insertId;
            }
        }
        $deleteCount = (int) $model->deleteByIssueType($projectId, $issueBugTypeId, $newUiType);
        $this->assertEquals($addNum, $deleteCount);
        $this->assertEmpty($model->getsByUiType($projectId, $issueBugTypeId, $newUiType));
    }
}
