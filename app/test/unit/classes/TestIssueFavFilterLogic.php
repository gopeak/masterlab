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

    public static $issueFavFilterIdArr = [];

    public static function setUpBeforeClass()
    {
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        IssueFavFilterDataProvider::clear();

        $model = new IssueFilterModel();
        if (!empty(self::$issueFavFilterIdArr)) {
            foreach (self::$issueFavFilterIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 用户自定义过滤器
     * @throws \Exception
     */
    public function testGetCurUserFavFilter()
    {
        $loginUserId = IssueFavFilterDataProvider::initLoginUser()['uid'];
        $model = new IssueFilterModel();
        $logic = new IssueFavFilterLogic();
        $logic->displayNum = 2;
        $info = [];
        $info['author'] = $loginUserId;
        for ($i = 0; $i < $logic->displayNum; $i++) {
            list($ret, $insertId) = $model->insert($info);
            if ($ret) {
                self::$issueFavFilterIdArr [] = $insertId;
            }
        }
        $rows = $logic->getCurUserFavFilter();
        $this->assertNotEmpty($rows);
        $this->assertNotEmpty($rows[0]);
        $this->assertNotEmpty($rows[1]);
    }

    /**
     * @throws \Exception
     */
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
            $issueFavFilterIdArr[] = $insertId;
            IssueFavFilterDataProvider::$insertIdArr[] = $insertId;
            $model->deleteById($insertId);
        }
    }
}
