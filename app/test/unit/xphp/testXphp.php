<?php

/**
 * DbModel测试类
 * User: sven
 * Date: 2017/7/15 0015
 * Time: 下午 5:24
 */
class testXphp extends PHPUnit_Framework_TestCase
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
    public function testConstruct(  )
    {
        // 初始化开发框架基本设置
        $config = new \stdClass();
        $config->current_app = APP_NAME;
        $config->app_path = APP_PATH;
        $config->xphp_root_path =  ROOT_PATH;
        $config->app_status = APP_STATUS;
        $config->enable_trace = ENABLE_TRACE;
        $config->enable_xhprof = ENABLE_XHPROF;
        $config->xhprof_rate = XHPROF_RATE;
        $config->enable_write_req_log = WRITE_REQUEST_LOG;
        $config->enable_security_map = SECURITY_MAP_ENABLE;
        $config->exception_page = VIEW_PATH.'exception.php';

        // 实例化开发框架对象
        $xphp = new  \Xphp( $config );

        foreach(  $config as $k=>$v ) {

            if(   $xphp->getProperty($k)===null ) {
                $this->fail( '$xphp '. $k.' no found' );
            }
            if( $xphp->getProperty($k)!==null &&  $v != $xphp->getProperty($k) ) {
                $this->fail( '$xphp '.$k.' expect equal '.$v.',but get '.$xphp->$k );
            }
        }


    }

}
