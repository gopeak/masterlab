<?php

/**
 * 数组函数测试类
 * User: sven
 * Date: 2017/7/15 0015
 * Time: 下午 5:24
 */
class testArray extends PHPUnit_Framework_TestCase
{

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

    public function testArr2json()
    {
        $arr = [];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);
        $this->assertEqual($arr, $tmp);

        $arr = [1,2,3,4,5,6];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);
        $this->assertEqual($arr, $tmp);

        $arr = [];
        $arr['a'] = 1;
        $arr['b'] = 'b';
        $arr['c'] = [];
        $arr['d'] = [1,2,3,4,5];
        $arrJson = arr2json($arr);
        $tmp = json_decode($arrJson, true);
        $this->assertEqual($arr, $tmp);
    }

}
