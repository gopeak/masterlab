<?php

namespace main\app\test\unit\classes;

use main\app\classes\WorkflowLogic;
use main\app\model\DbModel;
use main\app\test\BaseAppTestCase;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\issue\WorkflowSchemeDataModel;

/**
 *  WorkflowLogic 测试类
 * @package main\app\test\logic
 */
class TestWorkflowLogic extends BaseAppTestCase
{

    public static $insertIdArr = [];

    public static function setUpBeforeClass()
    {
        (new DbModel())->beginTransaction();
    }

    public static function tearDownAfterClass()
    {
        (new DbModel())->rollBack();
    }

    /**
     * @throws \Exception
     */
    public function testGetAdminWorkflow()
    {
        $logic = new WorkflowLogic();
        $rows = $logic->getAdminWorkflow();
        $this->assertNotEmpty($rows);
        foreach ($rows as $row) {
            $this->assertArrayHasKey('scheme_ids', $row);
            $this->assertArrayHasKey('update_time_text', $row);
            $this->assertArrayHasKey('create_time_text', $row);
        }
    }

    /**
     * 更新状态流方案的事项类型
     * @throws \Exception
     */
    public function testUpdateSchemeTypesWorkflow()
    {
        $model = new WorkflowSchemeModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-' . mt_rand(10000, 99999);
        $info['description'] = 'test-description';
        $info['is_system'] = '0';
        list($ret, $insertId) = $model->insert($info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }

        $json = [];
        $json[] = ['issue_type_id' => 1, 'workflow_id' => 1];
        $json[] = ['issue_type_id' => 2, 'workflow_id' => 2];

        $logic = new WorkflowLogic();

        list($ret, $msg) = $logic->updateSchemeTypesWorkflow($insertId, $json);
        $this->assertTrue($ret, $msg);

        $model->deleteById($insertId);
        $model = new WorkflowSchemeDataModel();
        $model->deleteBySchemeId($insertId);
    }
}
