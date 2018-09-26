<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;

/**
 * IssueTypeSchemeItemsModel 测试类
 * User: sven
 */
class TestIssueTypeSchemeItemsModel extends TestBaseIssueModel
{

    public static $scheme = [];

    public static $insertIdArr = [];

    public static function setUpBeforeClass()
    {
        self::$scheme = self::initScheme();
    }


    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 初始化 scheme
     */
    public static function initScheme()
    {
        $info = [];
        $info['name'] = 'test-'.mt_rand(10000, 99999);
        $info['description'] = 'test-description';
        $info['is_default'] = '0';

        $model = new IssueTypeSchemeModel();
        list($ret, $schemeId) = $model->insert($info);
        if (!$ret) {
            //var_dump('TestBaseUserModel initUser  failed,' . $msg);
            parent::fail(__CLASS__ . ' initScheme  failed,' . $schemeId);
            return;
        }
        $row = $model->getRowById($schemeId);
        return $row;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $model = new IssueTypeSchemeModel();
        $model->deleteById(self::$scheme['id']);

        if (!empty(self::$insertIdArr)) {
            $model = new IssueTypeSchemeItemsModel();
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
        $schemeId = self::$scheme['id'];
        $model = new IssueTypeSchemeItemsModel();

        $model->deleteBySchemeId($schemeId);

        // 1. 新增测试需要的数据
        $info = [];
        $info['scheme_id'] = self::$scheme['id'];
        $info['type_id'] = IssueTypeModel::getInstance()->getIdByKey('bug');
        list($ret, $insertId1) = $model->insert($info);
        $this->assertTrue($ret, $insertId1);
        if ($ret) {
            self::$insertIdArr[] = $insertId1;
        }
        $info = [];
        $info['scheme_id'] = self::$scheme['id'];
        $info['type_id'] = IssueTypeModel::getInstance()->getIdByKey('task');
        list($ret, $insertId2) = $model->insert($info);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }
        // 2.测试 getItemsBySchemeId
        $rows = $model->getItemsBySchemeId($schemeId);
        $this->assertNotEmpty($rows);
        $this->assertCount(2, $rows);
        $row = $rows[0];
        $this->assertEquals($schemeId, $row['scheme_id']);


        // 3.删除
        $ret = (bool)$model->deleteBySchemeId($schemeId);
        $this->assertTrue($ret);
    }
}
