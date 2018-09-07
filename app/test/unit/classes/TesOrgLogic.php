<?php

namespace main\app\test\logic;

use PHPUnit\Framework\TestCase;
use main\app\model\OrgModel;
use main\app\classes\OrgLogic;

/**
 *  OrgLogic 测试类
 * @package main\app\test\logic
 */
class TesOrgLogic extends TestCase
{

    public static $orgIdArr = [];
    public static $insertNum = 2;

    public static function setUpBeforeClass()
    {
        $model = new OrgModel();
        for ($i = 0; $i < self::$insertNum; $i++) {
            $info = [];
            $info['path'] = 'test-path';
            $info['name'] = 'test-name';
            $info['description'] = 'test-description';
            list($ret, $insertId) = $model->insert($info);
            if ($ret) {
                self::$orgIdArr[] = $insertId;
            }
        }
    }

    public static function tearDownAfterClass()
    {
        if (!empty(self::$orgIdArr)) {
            $model = new OrgModel();
            foreach (self::$orgIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public function testGetOrigins()
    {
        $logic = new OrgLogic();
        $rows = $logic->getOrigins();
        $this->assertNotEmpty($rows);
    }
}
