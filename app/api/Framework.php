<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/28 0028
 * Time: 下午 5:59
 */

namespace main\app\api;

/**
 * 测试开发框架 api
 * Class framework
 */
class Framework extends BaseApi
{

    /**
     * 测试路由
     * @return string
     */
    public function route()
    {
        return 'route';
    }

    /**
     * 触发错误异常
     * @return bool
     */
    public function showError()
    {
        try {
            timezone_open(1202229163);
            new \DateTimeZone(1202229163);
        } catch (\Exception $e) {
            echo "caught  " . $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * 触发错误异常
     * @return bool
     */
    public function showException()
    {
        timezone_open(1202229163);
        //100/0;
        new \DateTimeZone(1202229163);
        echo 'ok';
    }


    /**
     * 故意返回不符合期望的格式
     * @require_type []
     * @return array
     */
    public function notExpectJson()
    {
        $arr = [9, 1, 8, 3, 4, 1, 8, 5, 7];
        // 注意,经过 array_unique 处理后返回值不是一个纯粹的数组,
        // 而是以字符串下标的新数组 ["0": 9,"1": 1,"2": 8,"3": 3,"4": 4,"7": 5,"8": 7]
        $arr = array_unique($arr);
        return $arr;
    }

    /**
     * 返回符合期望的格式
     * @require_type []
     * @return array
     */
    public function expectJson()
    {
        $arr = [9, 1, 8, 3, 4, 1, 8, 5, 7];
        $arr = array_unique($arr);
        $new_arr = [];
        // 或者使用 array_values 函数
        foreach ($arr as $v) {
            $new_arr[] = $v;
        }
        return $new_arr;
    }

    /**
     * 返回不符合的期望格式
     * @require_type {"name":"","id":121,"fish":[1,3,4],"props":{"x":123,"y":128}}
     * @return array
     */
    public function notExpectMixJson()
    {
        $obj = new \stdClass();
        $obj->id = 12333;
        $obj->name = "sven";
        $obj->fish = [232, 4, 34, 5];
        $obj->props = [];

        return $obj;
    }

    /**
     * 返回符合期望的格式
     * @require_type {"name":"","id":121,"fish":[1,3,4],"props":{"x":123,"y":128}}
     * @return array
     */
    public function expectMixJson()
    {
        //return json_decode( '[]' );
        $obj = new \stdClass();
        $obj->id = 12333;
        $obj->name = "sven";
        $obj->fish = [232, 4, 34, 5];
        $obj_props = new \stdClass();
        $obj_props->x = 123;
        $obj_props->y = 128;
        $obj->props = $obj_props;

        return $obj;
    }
}
