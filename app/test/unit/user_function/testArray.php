<?php

namespace main\app\test\user_function;

use PHPUnit\Framework\TestCase;
/**
 * 数组函数测试类
 */
class testArray extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    public function testArr2json()
    {
        $arr = [];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);
        $this->assertEquals($arr, $tmp);

        $arr = [1,2,3,4,5,6];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);
        $this->assertEquals($arr, $tmp);

        $arr = [];
        $arr['a'] = 1;
        $arr['b'] = 'b';
        $arr['c'] = [];
        $arr['d'] = [1,2,3,4,5];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);

        $this->assertEquals($arr, $tmp);
    }
}
