<?php
/**
 *
 * B2B系统测试基类，基类主要确保各项资源配置正确。维持一个稳定干净的测试环境。
 * 
 * @version php v7.1.1
 * @author     2017-3-10 Jesen     
 * @copyright  2014-2017 闪盟珠宝
 * @see  PHPUnit_Framework_TestCase     
 * @link       
 */

use \main\app\model\UserModel;
//平台model
use Katzgrau\KLogger\Logger;



class BaseAppTestCase extends BaseTestCase
{

    public static $logger          = null;

    /**
     *  跟平台交互curl资源
     * @var \Curl\Curl
     */
    public static $app_curl      = null;

    /**
     * 用户curl资源
     * @var \Curl\Curl
     */
    public static $user_curl       = null;


    /**
     * 用户数据
     * @var array
     */
    public static $user    = [];

 

    /**
     * @var main\app\model\UserModel
     */
    public static $userModel = null;


    
    public static function setUpBeforeClass()
    {
    
        self::$app_curl = new \Curl\Curl();
        self::$app_curl->setCookieFile( './data/cookie/app.txt');
    
        self::$user_curl = new \Curl\Curl();
        self::$user_curl->setCookieFile( './data/cookie/user.txt');

        self::$userModel    = UserModel::getInstance();

        self::$logger = new Logger(TEST_LOG);

        self::$user = self::initUser(  );
        //self::getAccessToken();

    }



    /**
     * 初始化用户
     */
    public static  function initUser(  )
    {
        // 表单数据 $post_data
        $post_data = [];
        $openid = MD5( time() );
        $post_data['phone'] = '170'.mt_rand(12345678,92345678);
        $post_data['username'] = $post_data['phone'] ;
        $post_data['openid'] =  $openid;
        $post_data['realname'] = 'realname'.time();
        $post_data['company_id'] = time();

        list( $ret , $msg ) =static::$userModel->insert( $post_data );
        if( !$ret ){
            var_dump( 'initUser   failed,'. $msg );
            return;
        }
        // 绕过平台一账通进行授权
        self::$user_curl->get( ROOT_URL.'unit_test/auth?openid='.$openid  );
        $resp = self::$user_curl->rawResponse;
        if( $resp!=='ok' ){
            var_dump( 'user auth failed,'. $resp );
            return;
        }
        $conditions['openid'] = $openid;
        $user = static::$userModel->getRow('*',$conditions );
        return $user;
    }

 

    /**
     * 删除用户
     * @param $openid
     * @return bool
     */
    public static  function deleteUser( $openid )
    {
        $conditions['openid'] = $openid;
        static::$userModel->delete( $conditions );

        return true;
    }
    

    
    public static function tearDownAfterClass()
    {

        self::deleteUser( self::$user['openid'] );
        //清空对象资源
        self::$app_token       = null;
        

    }
}