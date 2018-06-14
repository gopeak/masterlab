<?php

namespace main\app\test\unit\model\issue;

use main\app\model\agile\AgileBoardModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *  AgileBoardModel 测试类
 * User: sven
 */
class TestAgileBoardModel extends TestBaseIssueModel
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
    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
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
            $model = new AgileBoardModel();
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
        $projectId = self::$project['id'];
        $model = new AgileBoardModel();
        // 1. 新增测试需要的数据
        $addNum = 3;
        for ($i = 0; $i < $addNum; $i++) {
            $info = [];
            $info['name'] = 'test-name' . $i;
            $info['project_id'] = $projectId;
            $info['weight'] = $i;
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$insertIdArr[] = $insertId;
            }
        }

        // 2.测试 getById
        $row = $model->getById($insertId);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 3.测试 getByName
        $row = $model->getByName($info['name']);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 2.测试 getItemsByWorkflowId
        $rows = $model->getsByProject($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount($addNum, $rows);

        // 5.删除
        $ret = (bool)$model->deleteByProjectId($projectId);
        $this->assertTrue($ret);
    }
}
