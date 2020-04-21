<?php

namespace main\app\test\logic;

use main\app\model\DbModel;
use main\app\test\unit\BaseUnitTranTestCase;
use PHPUnit\Framework\TestCase;
use main\app\model\OrgModel;
use main\app\classes\OrgLogic;


/**
 *  OrgLogic 测试类
 * @package main\app\test\logic
 */
class TesOrgLogic extends BaseUnitTranTestCase
{
    public static $orgIdArr = [];
    public static $insertNum = 2;

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function setUpBeforeClass()
    {
        //parent::setUpBeforeClass();
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

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public static function tearDownAfterClass()
    {
        //parent::tearDownAfterClass();
    }

    /**
     * @throws \Exception
     */
    public function testGetOrigins()
    {
        $logic = new OrgLogic();
        $rows = $logic->getOrigins();
        $this->assertNotEmpty($rows);
    }
}
