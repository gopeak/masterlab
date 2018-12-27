<?php

namespace main\app\test\unit\classes;

use main\app\classes\FieldLogic;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use PHPUnit\Framework\TestCase;

/**
 *  FieldLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestFieldLogic extends TestCase
{

    public static $issueTypeSchemeItemIdArr = [];

    public static function setUpBeforeClass()
    {
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        FieldLogicDataProvider::clear();

        $model = new IssueTypeSchemeItemsModel();
        if (!empty(self::$issueTypeSchemeItemIdArr)) {
            foreach (self::$issueTypeSchemeItemIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function testUpdateSchemeTypes()
    {
        $schemeId = FieldLogicDataProvider::initScheme()['id'];
        $model = new IssueTypeSchemeItemsModel();
        $typeIds = [1, 2, 3];
        foreach ($typeIds as $id) {
            $info = [];
            $info['scheme_id'] = $schemeId;
            $info['type_id'] = $id;
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$issueTypeSchemeItemIdArr[] = $insertId;
            }
        }
        $logic = new FieldLogic();

        $typeIds = [4, 5, 6];
        list($ret, $rowsAffected) = $logic->updateSchemeTypes($schemeId, $typeIds);
        $this->assertTrue($ret);
        $this->assertEquals(count($typeIds), $rowsAffected);
        $rows = $model->getItemsBySchemeId($schemeId);
        foreach ($rows as $row) {
            $typeId = $row['type_id'];
            $this->assertTrue(in_array($typeId, $typeIds));
        }
        $ret = (bool)$model->deleteBySchemeId($schemeId);
        $this->assertTrue($ret);
    }
}
