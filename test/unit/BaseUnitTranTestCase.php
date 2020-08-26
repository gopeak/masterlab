<?php


namespace main\test\unit;

use main\app\model\DbModel;
use PHPUnit\Framework\TestCase;
use main\test\BaseTestCase;

/**
 * Class BaseUnitTestCase
 * @package main\test\unit
 */
class  BaseUnitTranTestCase extends BaseTestCase
{

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function setUpBeforeClass()
    {
        (new DbModel())->beginTransaction();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function tearDownAfterClass()
    {
        (new DbModel())->rollBack();
    }

    /**
     * @throws \Exception
     */
    public function testMain(){

        $this->assertEquals(APP_STATUS, 'test');
    }
}
