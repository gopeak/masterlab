<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueFavFilterLogic;
use main\app\model\issue\IssueFilterModel;
use PHPUnit\Framework\TestCase;

/**
 *  IssueFavFilterLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestIssueFavFilterLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        IssueFavFilterDataProvider::clear();
    }

    public function testGetCurUserFavFilter()
    {
        $loginUserId = IssueFavFilterDataProvider::initLoginUser()['uid'];
        $model = new IssueFilterModel();
        $logic = new IssueFavFilterLogic();
        $logic->displayNum = 2;
        $info = [];
        $info['author'] = $loginUserId;
        for ($i = 0; $i < $logic->displayNum; $i++) {
            $model->insert($info);
        }
        $rows = $logic->getCurUserFavFilter();
        $this->assertNotEmpty($rows);
        $this->assertNotEmpty($rows[0], $rows[1]);
    }

    public function testSaveFilter()
    {
        $model = new IssueFilterModel();
        $logic = new IssueFavFilterLogic();
        $name = 'test-name';
        $filter = 'test-filter';
        $description = 'test-description';
        $shared = 'all';
        list($ret, $insertId) = $logic->saveFilter($name, $filter, $description, $shared);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            IssueFavFilterDataProvider::$insertIdArr[] = $insertId;
            $model->deleteById($insertId);
        }
    }
}
