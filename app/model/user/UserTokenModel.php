<?php
namespace main\app\model\user;
use main\app\model\CacheModel;

/**
 *
 * 用户token模块
 *
 * @author seven@haowan11.com
 *
 */
class UserTokenModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'token';

    const   DATA_KEY = 'user_token/';

    const   VALID_TOKEN_RET_OK = 1;

    const   VALID_TOKEN_RET_NOT_EXIST = 2;

    const   VALID_TOKEN_RET_EXPIRE = 3;

    public $uid = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;


    public function __construct( $uid = '', $persistent = false )
    {
        parent::__construct( $uid, $persistent );

        $this->uid = $uid;

    }


    /**
     * 创建一个自身的单例对象
     * @param string $uid
     * @param bool $persistent
     * @return self
     */
    public static function getInstance( $uid = '', $persistent = false )
    {
        $index = $uid . strval( intval( $persistent ) );
        if ( !isset(self::$_instance[$index]) || !is_object( self::$_instance[$index] ) ) {

            self::$_instance[$index] = new self( $uid, $persistent );
        }
        return self::$_instance[$index];
    }

    /**
     * 生成token
     * @param string $uid
     * @param string $pass
     * @return string
     */
    static function makeUserToken( $uid, $pass )
    {
        $token_cfg =  getConfigVar( 'data' );
        $public_key = $token_cfg['token']['public_key'];
        $secret_key = $token_cfg['token']['secret_key'];
        $expire_time = $token_cfg['token']['expire_time'];

        return md5( md5( $uid ) . $public_key . $secret_key . $pass . time() ) . md5( time() . $expire_time . $uid );

    }

    /**
     * 刷新token
     * @param string $uid
     * @param string $pass
     * @return string
     */
    static function makeUserRefreshToken( $uid, $pass )
    {
        $token_cfg   = getConfigVar( 'data' );
        $public_key  = $token_cfg['token']['public_key'];
        $secret_key  = $token_cfg['token']['secret_key'];
        $expire_time = $token_cfg['token']['expire_time'];

        return md5( $uid . $public_key . md5( $pass ) . $secret_key . time() ) . md5( $uid . $expire_time );

    }

    /**
     * 校验token是否有效
     * @param string $uid
     * @param string $token
     * @return array string
     */
    public function validUidToken( $uid, $token )
    {
        $row = $this->getUserToken( $uid );

        if ( !isset($row['token']) || $row['token'] != $token ) {
            return array(self::VALID_TOKEN_RET_NOT_EXIST, 'token值错误!');
        }

        $data_config = getConfigVar( 'data' );

        if ( (time() - intval( $row['token_time'] )) > intval( $data_config['token']['expire'] ) ) {
            return array(self::VALID_TOKEN_RET_EXPIRE, 'token值过期了!');
        }

        return array(self::VALID_TOKEN_RET_OK, 'ok');

    }

    /**
     * 校验token是否有效
     * @param string $token
     * @return array string
     */
    public function validToken(  $token )
    {
        $row = $this->getUserTokenByToken( $token );

        if ( !isset($row['token'])  ) {
            return array(self::VALID_TOKEN_RET_NOT_EXIST, 'token值错误!');
        }

        $data_config =  getConfigVar( 'data' );

        if ( (time() - intval( $row['token_time'] )) > intval( $data_config['token']['expire'] ) ) {
            return array(self::VALID_TOKEN_RET_EXPIRE, 'token值过期了!');
        }

        return array(self::VALID_TOKEN_RET_OK, 'ok');

    }

    /**
     * 生成和刷新token
     * @param array $user
     * @return array
     */
    public function makeToken( $user )
    {
        $token_row = $this->getUserToken( $user['uid'] );
        // v( $token_row );
        $token = self::makeUserToken( $user['uid'], $user['password'] );
        $refresh_token = self::makeUserRefreshToken( $user['uid'], $user['password'] );
        $userTokenInfo = [];
        $userTokenInfo['uid'] = $user['uid'];
        $userTokenInfo['token'] = $token;
        $userTokenInfo['token_time'] = time();
        $userTokenInfo['refresh_token'] = $refresh_token;
        $userTokenInfo['refresh_token_time'] = time();

        if ( !isset($token_row['token']) ) {
            $ret = (bool)$this->insertUserToken( $userTokenInfo );
        } else {
            $ret = $this->updateUserToken( $user['uid'], $userTokenInfo );
        }
        return array($ret, $token, $refresh_token);

    }


    /**
     *  获取用户token的记录信息
     * @param $uid
     * @return array
     */
    public function getUserToken( $uid )
    {
        //使用缓存机制
        $fields = '* ';
        $where = ['uid' => $uid];//" Where `uid`='$uid'  limit 1 ";
        $key = self::DATA_KEY . $uid;
        $final = parent::getRowByKey(  $fields, $where, $key );
        return $final;

    }

    /**
     *  获取用户token的记录信息
     * @param $token
     * @return array
     */
    public function getUserTokenByToken( $token )
    {
        //使用缓存机制
        $fields = '* ';
        $where = ['token' => $token];//" Where `token`='$token'  limit 1 ";
        $key = "";
        $final = parent::getRowByKey(  $fields, $where, $key );
        return $final;

    }


    /**
     * 插入一条用户token记录
     * @param $insertInfo
     * @return int
     */
    public function insertUserToken( $insertInfo )
    {

        $key = self::DATA_KEY . $insertInfo['uid'];

        $re = parent::insertByKey( $insertInfo, $key );

        return $re;

    }

    /**
     *
     * @param string $uid
     * @param array $update_info
     * @return boolean
     */
    public function updateUserToken( $uid, $update_info )
    {
        if ( empty($update_info) ) {
            return false;
        }
        if ( !is_array( $update_info ) ) {
            return false;
        }
        $key = self::DATA_KEY . $uid;
        $where = ['uid' => $uid];//"  where `uid`='$uid'";
        list( $flag ) = $this->updateByKey( $where, $update_info, $key );

        return $flag;
    }

    /**
     * 删除用户token记录
     * Enter description here ...
     */
    public function delUserToken( $uid )
    {

        $key = self::DATA_KEY . $uid;
        $where = ['uid' => $uid];//" Where uid = '$uid'";

        $flag = parent::deleteBykey( $where, $key );
        return $flag;
    }

}