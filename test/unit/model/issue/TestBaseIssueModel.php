<?php

namespace main\test\unit\model\issue;

use main\app\model\DbModel;
use  main\test\BaseAppTestCase;

/**
 *  TestBaseIssueModel issue基类
 * User: sven
 */
class TestBaseIssueModel extends BaseAppTestCase
{
    /**
     * issue 数据
     * @var array
     */
    public static $issue = [];

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
     * 初始化 issue
     */
    public static function initIssue()
    {
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
    }

    public function testMain()
    {
        $abc = true;
        $this->assertTrue($abc);
    }
}
