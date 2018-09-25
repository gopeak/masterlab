<?php

namespace main\app\test\unit\model\issue;

use  main\app\test\BaseAppTestCase;

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

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
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
