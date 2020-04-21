<?php


namespace main\app\test\unit;

use main\app\model\DbModel;
use PHPUnit\Framework\TestCase;
use main\app\test\BaseTestCase;

/**
 * Class BaseUnitTestCase
 * @package main\app\test\unit
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

}
