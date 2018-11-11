<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/28 0028
 * Time: 下午 5:59
 */

namespace main\app\api;


/**
 *
 * 实现 restful 示例 
 * GET      /api/restful_example/users                              列出所有用户
 * GET      /api/restful_example/users/1                            获取指定用户的信息
 * POST     /api/restful_example/users/?name=SAT&count=23           新建一个用户
 * PUT      /api/restful_example/users/1?name=SAT&count=23          更新指定用户的信息（全部信息）
 * PATCH    /api/restful_example/users/1?name=SAT                   更新指定用户的信息（部分信息）
 * DELETE   /api/restful_example/users/1                            删除指定用户
 *
 */
class RestfulExample extends BaseApi
{

    //测试数据
    private static $test_users = array(
        1 => array('name' => 'joe', 'count' => 18),
        2 => array('name' => 'marry', 'count' => 20),
    );


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * restful 入口
     * @return bool
     */
    public  function users()
    {
        header('Content-type: application/json; charset=utf-8');
        //请求方式
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (in_array($method, self::$method_type)) {
            //调用请求方式对应的方法
            $handleFnc = $method . 'Handler';
            return self::$handleFnc( );

        }
        return false;
    }

    /**
     * Restful GET , 获取信息
     * @return mixed
     */
    private static function getHandler( )
    {
        $user_id = 0;
        if( isset($_GET['_target'][3]) ){ 
            $user_id = intval( $_GET['_target'][3] );
        }

        // 获取某个指定用户的信息
        if ( $user_id > 0) {
            return self::$test_users [$user_id];
        } else {
            // 列出所有用户
            return self::$test_users ;
        }
    }

    /**
     * Restful POST ,新增用户
     * @return array|bool
     */
    private static function postHandler( )
    {
        if (!empty($_REQUEST['name'])) {
            $data['name'] = $_REQUEST['name'];
            $data['count'] = (int)$_REQUEST['count'];
            self::$test_users [] = $data;
            return self::$test_users ;//返回新生成的资源对象
        } else {
            return false;
        }
    }

    /**
     * Restful PUT ,更新某个指定用户的信息（全部信息）
     * @return array|bool
     */
    private static function putHandler( )
    {


        $user_id = 0;
        if( isset($_GET['_target'][3]) ){
            $user_id = intval( $_GET['_target'][3] );
        }
        if ($user_id == 0) {
            return false;
        }
        $data = [];
        $req_data_arr = [];
        $req_data = file_get_contents('php://input');
        parse_str( $req_data ,$req_data_arr  );
        if (!empty($req_data_arr['name']) && isset($req_data_arr['count'])) {
            $data['name'] = $req_data_arr['name'];
            $data['count'] = (int)$req_data_arr['count'];
            self::$test_users [$user_id] = $data;
            return self::$test_users ;
        } else {
            return false;
        }
    }

    /**
     * Restful PATCH ,更新某个指定用户的信息（部分信息）
     * @return array|bool
     */
    private static function patchHandler( )
    {
        $user_id = 0;
        if( isset($_GET['_target'][3]) ){
            $user_id = intval( $_GET['_target'][3] );
        }
        if ($user_id == 0) {
            return false;
        }

        $req_data_arr = [];
        $req_data = file_get_contents('php://input');
        parse_str( $req_data ,$req_data_arr  );
        if (!empty($req_data_arr['name'])) {
            self::$test_users [$user_id]['name'] = $req_data_arr['name'];
        }
        if (isset($req_data_arr['count'])) {
            self::$test_users [$user_id]['count'] = (int)$req_data_arr['count'];
        }
        return self::$test_users ;
    }

    /**
     * Restful DELETE ,删除某个用户
     * @return array|bool
     */
    private static function deleteHandler( )
    {
        $user_id = 0;
        if( isset($_GET['_target'][3]) ){
            $user_id = intval( $_GET['_target'][3] );
        }
        if ($user_id == 0) {
            return false;
        }
        unset(self::$test_users [$user_id]);
        return self::$test_users ;
    }

}