<?php

use main\app\model\DbModel;
use main\app\model\DemoModel;

/**
 * DbModel测试类
 * User: sven
 * Date: 2017/7/15 0015
 * Time: 下午 5:24
 */
class testDbModel extends BaseTestCase
{

    static $user = [];

    public static function setUpBeforeClass()
    {
        // 清空数据
        $demoModel = new DemoModel();
        $sql = "delete from ".$demoModel->getTable();
        $demoModel->exec( $sql);

        static::initUser();
    }

    public static function tearDownAfterClass()
    {
        // 清空数据
        $demoModel = new DemoModel();
        $sql = "delete from ".$demoModel->getTable();
        $demoModel->exec( $sql);
    }

    /**
     * 测试构造函数
     */
    public function testConstruct(  )
    {

    }

    /**
     * 测试exec
     */
    static  public function initUser(  )
    {
        $params = [];
        $demoModel = new DemoModel();
        $params['name'] = 'unit_test_name';
        $params['phone'] = '170'.mt_rand(12345678,92345678);
        $params['email'] = $params['phone'].'@qq.com';
        $params['password'] = md5('123456');
        $params['status'] = 1;
        $params['reg_time'] = time();
        $sql = "insert into ".$demoModel->getTable()." Set 
               `name`=:name, phone=:phone,password=:password,email=:email,status=:status,reg_time=:reg_time";
        $exec_ret =  $demoModel->exec( $sql, $params );
        if( !$exec_ret ){
            echo( 'DbModel exec error:'.$sql)."\n";
        }
        $insert_id = $demoModel->db->getLastInsId();
        if( empty($insert_id) ){
            echo( 'DbModel exec failed ,getLastInsId is empty' )."\n";
        }
        $params['id'] = $insert_id;
        static::$user = $params;

    }

    /**
     * 测试获取表名
     */
    public function testGetTable(  )
    {
        $demoModel = new DemoModel();
        try{
            $test_user_table = $demoModel->getTable();
            $demoModel->db->getFullFields( $test_user_table );
        }catch( \PDOException $e ){
            $this->fail( 'DemoModel getTable() faild ,'.$e->getMessage() );
        }
    }


    /**
     * 测试预连接
     */
    public function testPrepareConnect(  )
    {
        DbModel::$_pdoDriverInstances  = [];
        closeResources();
        $dbModel = new DbModel();
        if(  $dbModel->db->pdo!=null ){
            $this->fail( 'expect DbModel prepare not real connect to mysql,but get pdo is ',gettype($dbModel->db->pdo) );
        }
    }


    /**
     * 测试实际连接数据库
     */
    public function testRealConnect(  )
    {
        DbModel::$_pdoDriverInstances  = [];
        closeResources();
        $dbModel = new DbModel();
        $sql = " show tables;";
        $dbModel->db->getRows( $sql );
        if(  empty($dbModel->db->pdo) ){
            $this->fail( ' DbModel expect  real connect to mysql,but get pdo is empty ' );
        }
    }

    /**
     * 字符串转义
     */
    public function testQuote(  )
    {
        $dbModel = new DbModel();
        $str = "13002510000' or '1'='1 ";
        $quoted_str = $dbModel->quote(  $str );
        if( $str==$quoted_str ) {
            $this->fail( 'DbModel expect quote str,bug not change ');
        }

    }

    /**
     * 测试通过id获取一行数据
     */
    public function testGetRowById(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $uid = static::$user['id'];
        $user =  $demoModel->getRowById( $uid );
        foreach( static::$user as $k=>$v ){
            $this->assertEquals( $v,$user[$k] );
        }

    }

    /**
     * 测试获取某个字段值
     */
    public function testGetFieldById(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $uid = static::$user['id'];
        $name =  $demoModel->getFieldById( 'name', $uid );
        if( $name!= static::$user['name'] ) {
            $this->fail(  'DbModel getFieldById failed' );
        }
    }

    /**
     * 测试获取某个字段值
     */
    public function testGetOne(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $conditions['id'] = static::$user['id'];
        $name =  $demoModel->getOne( 'name', $conditions );
        if( $name!= static::$user['name'] ) {
            $this->fail(  'DbModel getFieldById failed' );
        }
    }

    /**
     *
     */
    public function testGetRow(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $conditions['id'] = static::$user['id'];
        $user =  $demoModel->getRow( '*', $conditions );
        if( empty( $user ) ){
            $this->fail( 'DbModel getRow is empty ' );
        }
        foreach( static::$user as $k=>$v ){
            $this->assertEquals( $v,$user[$k] );
        }
    }


    /**
     * 测试获取总数
     */
    public function testGetCount(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $conditions['id'] = static::$user['id'];
        $count =  $demoModel->getCount(  $conditions );
        if( $count!=1 ){
            $this->fail( 'DbModel getCount error expect 1 ,but get '.$count );
        }
    }

    /**
     * 测试 错误字段的情况
     */
    public function testCheckField(  )
    {
        $catch = false;

        $demoModel = new DemoModel();
        $db_config = $demoModel->dbConfig['database'][$demoModel->configName];
       // v($db_config);
        if( isset($db_config['show_field_info'])
            && $db_config['show_field_info']
            && !empty($demoModel->table )
        ){
            //print_r( $demoModel->field_info );
            try{
                $params = [];
                $params['name'.strval(time())] = 'unit_test_name_insert';
                $demoModel->insert(  $params );

            }catch ( \PDOException $e ){
                $catch = true;
            }
            if( !$catch ){
                $this->fail('expect throw \PDOException ,but not catch it');
            }
        }



    }

    /**
     * 测试插入替换删除
     */
    public function testInsertAndReplaceAndDelete(  )
    {
        $demoModel = new DemoModel();
        try{

            $params = [];
            $params['name'] = 'unit_test_name_insert';
            $params['phone'] = '170'.mt_rand(12345678,92345678);
            $params['email'] = $params['phone'].'@qq.com';
            $params['password'] = md5('123456');
            $params['status'] = 1;
            $params['reg_time'] = time();
            $params['last_login_time'] = time();
            $exec_ret =  $demoModel->insert(  $params );
            if( !$exec_ret ){
                $this->fail( 'DbModel exec error:'.$demoModel->getLastSql());
            }
            $insert_id = $demoModel->db->getLastInsId();
            if( empty($insert_id) ){
                $this->fail( 'DbModel insert failed ,getLastInsId is empty' );
            }

            // test InsertIgnore
            $exec_ret =  $demoModel->insertIgnore(  $params );
            if( !$exec_ret ){
                $this->fail( 'DbModel insertIgnore error:'.$demoModel->getLastSql());
            }
            $conditions['phone'] = $params['phone'];
            $users =  $demoModel->getRows( "*",$conditions );
            if(  count($users)>1 ){
                $this->fail( 'DbModel insertIgnore error, expect row count is 1,but get '.count($users) );
            }

            // test replace
            $params['id'] = $insert_id;
            $params['status'] = 2;
            $params['last_login_time'] = time()+10;
            $exec_ret =  $demoModel->replace(  $params );
            if( !$exec_ret ){
                $this->fail( 'DbModel replace error:'.$demoModel->getLastSql());
            }
            $user = $demoModel->getRowById( $insert_id );
            foreach( $params as $k=>$v ){
                $this->assertEquals( $v,$user[$k] );
            }

            // test delete
            $delete_ret = $demoModel->delete( $conditions );
            if( !$delete_ret ){
                $this->fail( 'DbModel delete error:'.$demoModel->getLastSql());
            }
        }catch( \PDOException $e ){
            $this->fail( 'throw \PDOException :' .$e->getCode().' '.mb_convert_encoding( $e->getMessage(), 'gbk','utf-8') );
        }

    }

    /**
     * 测试批量插入和多行查询
     */
    public function testInsertRowsAndGetRows(  )
    {
        $demoModel = new DemoModel();
        $insert_rows = [];
        for( $i=0; $i<5; $i++ ){
            $params = [];
            $params['name'] = 'unit_test_name_inserts';
            $params['phone'] = '170'.mt_rand(12345678,92345678);;
            $params['password'] = md5('123456');
            $params['status'] = 1;
            $params['reg_time'] = time();
            $params['last_login_time'] = time();
            $insert_rows[] = $params;
        }
        $exec_ret =  $demoModel->insertRows(  $insert_rows );
        if( empty($exec_ret) ){
            $this->fail( 'DbModel insertRows error:'.$demoModel->db->pdo->errorInfo() );
        }
        $insert_count = $demoModel->db->pdoStatement->rowCount();
        if( count($insert_rows)!=$insert_count ){
            $this->fail( 'DbModel insertRows expect return '.count($insert_rows).', but get '.$exec_ret ."\n".$demoModel->getLastSql());
        }

        // test normal getRows
        $demoModel = new DemoModel();
        $conditions['name'] = $insert_rows[0]['name'];
        $users =  $demoModel->getRows( '*', $conditions );
        if( empty( $users ) ){
            $this->fail( 'DbModel getRows is empty ' );
        }
        if( $insert_count!=count($users) ){
            $this->fail( 'DbModel getRows expect count '.count($insert_rows).', but get '.count($users)  );
        }

        // test getRows append
        $conditions['name'] = $insert_rows[0]['name'];
        $append = "status=2 ";
        $users =  $demoModel->getRows( 'id,name,phone,status,reg_time', [], $append );
        if( !empty( $users ) ){
            $this->fail( 'DbModel getRows status=2  expect count 0,but get ' .count($users) );
        }
        // test sort and limit
        $conditions['name'] = $insert_rows[0]['name'];
        $sort = ' id desc ';
        $limit = 2;
        $users =  $demoModel->getRows( '*', [], NULL ,$sort, $limit );
        if( count( $users )!= $limit){
            $this->fail( 'DbModel getRows  limit expect   '.$limit.',but get '.count( $users )  );
        }
        if( $users[0]['id']<$users[1]['id'] ) {
            $this->fail( 'DbModel getRows  sort expect desc  ,but get asc' );
        }

        // test getRowsByPage
        $conditions['name'] = $insert_rows[0]['name'];
        $order='id';
        $desc='desc';
        $page = 1;
        $page_size = 2;
        $demoModel->getRowsByPage( $conditions, $order,$desc, $page, $page_size );
        if( count( $users )!= $page_size){
            $this->fail( 'DbModel getRowsByPage  page_size expect   '.$page_size.',but get '.count( $users )  );
        }
        if( $users[0]['id']<$users[1]['id'] ) {
            $this->fail( 'DbModel getRowsByPage  sort expect desc  ,but get asc' );
        }

        $conditions['name'] = $insert_rows[0]['name'];
        $delete_ret = $demoModel->delete( $conditions );
        if( !$delete_ret ){
            $this->fail( 'DbModel delete error:'.$demoModel->getLastSql());
        }
    }

    public function testUpdate(  )
    {

        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $info ['reg_time'] = time()+mt_rand(100,1000);;
        $info['status'] = 2;
        $info['last_login_time'] = time()+10;
        $conditions['id'] = static::$user['id'];
        list( $ret, $affect_count ) =  $demoModel->update(  $info ,$conditions  );
        if( !$ret ){
            $this->fail( 'DbModel updateById error expect true ,but get false' );
        }
        if( intval($affect_count)<1 ) {
            $this->fail( 'DbModel updateById error expect affect count 1 ,but get '.$affect_count );
        }
        $user = $demoModel->getRowById( static::$user['id'] );
        foreach( $info as $k=>$v ){
            $this->assertEquals( $v, $user[$k] );
        }
        static::$user = $user;
    }

    public function testUpdateById(  )
    {
        if( empty( static::$user ) ){
            $this->fail( 'static::$user is empty' );
        }
        $demoModel = new DemoModel();
        $info ['reg_time'] = time()+mt_rand(100,1000);

        list( $ret, $affect_count ) =  $demoModel->updateById( static::$user['id'] ,$info );
        if( !$ret ){
            $this->fail( 'DbModel updateById  expect true ,but get false' );
        }
        if( intval($affect_count)<1 ) {
            $this->fail( 'DbModel updateById  expect affect count 1 ,but get '.$affect_count );
        }
        $user = $demoModel->getRowById( static::$user['id'] );
        $this->assertEquals( $info ['reg_time'] , $user['reg_time'] );
        static::$user = $user;
    }


    public function testInc(  )
    {
        $demoModel = new DemoModel();
        $conditions['id'] = static::$user['id'];
        $origin_time = $demoModel->getOne( 'reg_time', $conditions );
        $ret = $demoModel->inc( 'reg_time', static::$user['id']  );
        if( $ret===false ){
            $this->fail( 'DbModel inc  expect true ,but get false' );
        }
        $inced_time = $demoModel->getOne( 'reg_time', $conditions );
        if( $inced_time!=($origin_time+1)){
            $this->fail( 'DbModel inc  expect inc to '.strval($origin_time+1).' ,but get '.$inced_time );
        }

    }

    public function testDec(  )
    {
        $demoModel = new DemoModel();
        $conditions['id'] = static::$user['id'];
        $origin_time = $demoModel->getOne( 'reg_time', $conditions );
        $ret = $demoModel->dec( 'reg_time', static::$user['id']  );
        if( $ret===false ){
            $this->fail( 'DbModel dec  expect true ,but get false' );
        }
        $deced_time = $demoModel->getOne( 'reg_time', $conditions );
        if( $deced_time!=($origin_time-1)){
            $this->fail( 'DbModel inc  expect inc to '.strval($origin_time-1).' ,but get '.$deced_time );
        }
    }



}
