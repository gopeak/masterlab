<?php

namespace main\test\unit\classes;

use main\app\classes\IssueStatusLogic;
use main\test\unit\BaseUnitTranTestCase;
use PHPUnit\Framework\TestCase;

/**
 *  IssueStatusLogic 测试
 * @package main\test\logic
 */
class TestIssueStatusLogic extends BaseUnitTranTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
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
