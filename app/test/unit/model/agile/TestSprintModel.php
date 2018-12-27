<?php

namespace main\app\test\unit\model\issue;

use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *  SprintModel 测试类
 * User: sven
 */
class TestSprintModel extends TestBaseIssueModel
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
            $model = new SprintModel();
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
        $model = new SprintModel();
        // 1. 新增测试需要的数据
        $addNum = 5;
        for ($i = 0; $i < $addNum; $i++) {
            $info = [];
            $info['name'] = 'test-name' . $i;
            $info['project_id'] = $projectId;
            $info['active'] = $i == 0 ? '1' : '0';
            $info['status'] = '1';
            $info['order_weight'] = $i;
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$insertIdArr[] = $insertId;
            }
        }

        // 2.测试 getByName
        $row = $model->getByName($info['name']);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }
        // 3.测试 getAllItems
        $rows = $model->getAllItems();
        $this->assertNotEmpty($rows);
        foreach ($rows as $key => $row) {
            $this->assertTrue(is_array($row));
        }
        $rows = $model->getAllItems(true);
        foreach ($rows as $key => $row) {
            $this->assertEquals($key, $row['id']);
        }
        reset($rows);
        $first = current($rows);
        $end = end($rows);

        // 4.测试排序
        $insertId1OrderWeight = parent::getArrItemOrderWeight($rows, 'id', $first['id']);
        $insertId2OrderWeight = parent::getArrItemOrderWeight($rows, 'id', $end['id']);
        $this->assertTrue($insertId1OrderWeight < $insertId2OrderWeight);

        // 5.删除
        $ret = (int)$model->deleteByProjectId($projectId);
        $this->assertTrue($ret>0);
        //$this->assertEquals($addNum, $model->db->pdoStatement->rowCount());
    }
}
