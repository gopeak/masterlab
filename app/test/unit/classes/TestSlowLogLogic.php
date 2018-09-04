<?php

namespace main\app\test\unit\classes;

use main\app\classes\SlowLogLogic;
use PHPUnit\Framework\TestCase;

/**
 *  SlowLogLogic 模块业务逻辑
 * @package main\app\test\unit\classes
 */
class TestSlowLogLogic extends TestCase
{
    public static $objectLogic = null;

    public static function setUpBeforeClass()
    {
        self::$objectLogic = SlowLogLogic::getInstance();
    }

    public static function tearDownAfterClass()
    {
        self::$objectLogic = null;
    }

    public function main()
    {
        $start_time = array_sum(explode(' ', microtime()));
        $ret = $sth->execute();
        $end_time = array_sum(explode(' ', microtime()));
        $diff = $end_time - $start_time;
        SlowLogLogic::getInstance()->write($sql, $diff);
    }

    public function testSetFolder()
    {
        SlowLogLogic::getInstance()->setFolder();
    }

    public function testSetFile()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testPathToLogFile()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetFolderName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetFileName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetView()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetFolders()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetFolderFiles()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetFiles()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testWrite()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
