<?php


namespace main\test\unit\model;

use main\app\model\DbModel;


/**
 * Class TestTranDbModel
 * @package main\test\unit\model
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
