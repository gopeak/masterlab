<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueStatusLogic;
use PHPUnit\Framework\TestCase;

/**
 *  IssueStatusLogic 测试
 * @package main\app\test\logic
 */
class TestIssueStatusLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        IssueFavFilterDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testGetAdminIssueStatus()
    {
        $logic = new IssueStatusLogic();

        $rows = $logic->getAdminIssueStatus();
        $this->assertNotEmpty($rows);
        $idArr = [];
        foreach ($rows as $item) {
            $this->assertTrue(isset($item['workflow_count']));
            $idArr[] = (int) $item['id'];
        }
        // status id 是否升序排序
        $this->assertTrue($idArr[1] > $idArr[0]);
    }

    /**
     * @throws \Exception
     */
    public function testGetStatus()
    {
        $logic = new IssueStatusLogic();
        $rows = $logic->getStatus();
        $this->assertNotEmpty($rows);
        $idArr = [];
        foreach ($rows as $item) {
            $idArr[] = (int) $item['sequence'];
        }
        // 是否按照sequence降序
        $this->assertTrue($idArr[0]>$idArr[1]);
    }
}
