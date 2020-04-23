<?php


namespace main\app\test\unit\model;

use main\app\model\DbModel;


/**
 * Class TestTranDbModel
 * @package main\app\test\unit\model
 */
trait  TestTranDbModel
{

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        (new DbModel())->beginTransaction();
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        (new DbModel())->rollBack();
    }


}
