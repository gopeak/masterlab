<?php

namespace main\app\test\logic;

use PHPUnit\Framework\TestCase;

use main\app\classes\LogOperatingLogic;
use main\app\test\data\LogDataProvider;

/**
 * 日志业务逻辑
 * Class testLogLogic
 * @package main\app\test\logic
 */
class TestLogOperatingLogic extends TestCase
{
    public static $pageSize = 10;

    public static $logs = [];


    public static function setUpBeforeClass()
    {

    }

    public static function tearDownAfterClass()
    {

    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
    }



   /* public function testAdd()
    {

        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time() - 10;
        $pre_data['f3'] = 'google';

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';

        $obj_id = 0;
        $uid = 10000;

        $result = LogLogic::add('日志测试111' , $pre_data, $cur_data, $obj_id,
                                '日志', '新增' , 'issuse', $uid);



        $this->assertNotEmpty($result);
    }*/

    public function testAddByArr()
    {

        $uid = 10000;

        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time() - 10;
        $pre_data['f3'] = 'google';
        $data['pre_data'] = $pre_data;

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';
        $data['cur_data'] = $cur_data;

        $data['user_name'] = 'test';
        $data['real_name'] = '测试';
        $data['module'] = 'issues';
        $data['page'] = 'main';
        $data['action'] = '新增';
        $data['obj_id'] = 10000;
        $data['remark'] = '添加事项';

        $result = LogOperatingLogic::addByArr($uid, 0, $data);

        $this->assertNotEmpty($result);
    }
}
