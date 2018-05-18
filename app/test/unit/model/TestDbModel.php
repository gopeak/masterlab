<?php


namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\DbModel;
use main\app\model\unit_test\FrameworkUserModel;

/**
 * DbModel测试类
 * Class testDbModel
 * @package main\app\test\unit\model
 */
class TestDbModel extends TestCase
{

    public static $user = [];

    public static function setUpBeforeClass()
    {
        // 清空数据
        $frameworkUserModel = new FrameworkUserModel();
        $sql = "delete from " . $frameworkUserModel->getTable();
        $frameworkUserModel->exec($sql);

        static::initUser();
    }

    public static function tearDownAfterClass()
    {
        // 清空数据
        $frameworkUserModel = new FrameworkUserModel();
        $sql = "delete from " . $frameworkUserModel->getTable();
        $frameworkUserModel->exec($sql);
    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
    }

    /**
     * 测试exec
     */
    public static function initUser()
    {
        $params = [];
        $frameworkUserModel = new FrameworkUserModel();
        $params['name'] = 'unit_test_name';
        $params['phone'] = '170' . mt_rand(12345678, 92345678);
        $params['email'] = $params['phone'] . '@qq.com';
        $params['password'] = md5('123456');
        $params['status'] = 1;
        $params['reg_time'] = time();
        $sql = "insert into " . $frameworkUserModel->getTable() . " Set 
               `name`=:name, phone=:phone,password=:password,email=:email,status=:status,reg_time=:reg_time";
        $exec_ret = $frameworkUserModel->exec($sql, $params);
        if (!$exec_ret) {
            echo ('DbModel exec error:' . $sql) . "\n";
        }
        $insert_id = $frameworkUserModel->db->getLastInsId();
        if (empty($insert_id)) {
            echo ('DbModel exec failed ,getLastInsId is empty') . "\n";
        }
        $params['id'] = $insert_id;
        static::$user = $params;

    }

    /**
     * 测试获取表名
     */
    public function testGetTable()
    {
        $frameworkUserModel = new FrameworkUserModel();
        try {
            $test_user_table = $frameworkUserModel->getTable();
            $frameworkUserModel->db->getFullFields($test_user_table);
        } catch (\PDOException $e) {
            $this->fail('FrameworkUserModel getTable() faild ,' . $e->getMessage());
        }
    }


    /**
     * 测试预连接
     */
    public function testPrepareConnect()
    {
        DbModel::$_pdoDriverInstances = [];
        closeResources();
        $dbModel = new DbModel();
        if ($dbModel->db->pdo != null) {
            $pdoType = gettype($dbModel->db->pdo);
            $this->fail('expect DbModel prepare not real connect to mysql,but get pdo is ' . $pdoType);
        }
    }


    /**
     * 测试实际连接数据库
     */
    public function testRealConnect()
    {
        DbModel::$_pdoDriverInstances = [];
        closeResources();
        $dbModel = new DbModel();
        $sql = " show tables;";
        $dbModel->db->getRows($sql);
        if (empty($dbModel->db->pdo)) {
            $this->fail(' DbModel expect  real connect to mysql,but get pdo is empty ');
        }
    }

    /**
     * 字符串转义
     */
    public function testQuote()
    {
        $dbModel = new DbModel();
        $str = "13002510000' or '1'='1 ";
        $quoted_str = $dbModel->quote($str);
        if ($str == $quoted_str) {
            $this->fail('DbModel expect quote str,bug not change ');
        }

    }

    /**
     * 测试通过id获取一行数据
     */
    public function testGetRowById()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $uid = static::$user['id'];
        $user = $frameworkUserModel->getRowById($uid);
        foreach (static::$user as $k => $v) {
            $this->assertEquals($v, $user[$k]);
        }

    }

    /**
     * 测试获取某个字段值
     */
    public function testGetFieldById()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $uid = static::$user['id'];
        $name = $frameworkUserModel->getFieldById('name', $uid);
        if ($name != static::$user['name']) {
            $this->fail('DbModel getFieldById failed');
        }
    }

    /**
     * 测试获取某个字段值
     */
    public function testGetOne()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $name = $frameworkUserModel->getOne('name', $conditions);
        if ($name != static::$user['name']) {
            $this->fail('DbModel getFieldById failed');
        }
    }

    /**
     * 测试获取一条记录
     */
    public function testGetRow()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $user = $frameworkUserModel->getRow('*', $conditions);
        if (empty($user)) {
            $this->fail('DbModel getRow is empty ');
        }
        foreach (static::$user as $k => $v) {
            $this->assertEquals($v, $user[$k]);
        }
    }


    /**
     * 测试获取总数
     */
    public function testGetCount()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $count = $frameworkUserModel->getCount($conditions);
        if ($count != 1) {
            $this->fail('DbModel getCount error expect 1 ,but get ' . $count);
        }
    }

    /**
     * 测试 错误字段的情况
     */
    public function testCheckField()
    {
        $catch = false;

        $frameworkUserModel = new FrameworkUserModel();
        $db_config = $frameworkUserModel->dbConfig['database'][$frameworkUserModel->configName];
        // v($db_config);
        if (isset($db_config['show_field_info'])
            && $db_config['show_field_info']
            && !empty($frameworkUserModel->table)
        ) {
            //print_r( $frameworkUserModel->field_info );
            try {
                $params = [];
                $params['name' . strval(time())] = 'unit_test_name_insert';
                $frameworkUserModel->insert($params);

            } catch (\PDOException $e) {
                $catch = true;
            }
            if (!$catch) {
                $this->fail('expect throw \PDOException ,but not catch it');
            }
        }


    }

    /**
     * 测试插入替换删除
     */
    public function testInsertAndReplaceAndDelete()
    {
        $frameworkUserModel = new FrameworkUserModel();
        try {

            $params = [];
            $params['name'] = 'unit_test_name_insert';
            $params['phone'] = '170' . mt_rand(12345678, 92345678);
            $params['email'] = $params['phone'] . '@qq.com';
            $params['password'] = md5('123456');
            $params['status'] = 1;
            $params['reg_time'] = time();
            $params['last_login_time'] = time();
            $exec_ret = $frameworkUserModel->insert($params);
            if (!$exec_ret) {
                $this->fail('DbModel exec error:' . $frameworkUserModel->getLastSql());
            }
            $insert_id = $frameworkUserModel->db->getLastInsId();
            if (empty($insert_id)) {
                $this->fail('DbModel insert failed ,getLastInsId is empty');
            }

            // test InsertIgnore
            $exec_ret = $frameworkUserModel->insertIgnore($params);
            if (!$exec_ret) {
                $this->fail('DbModel insertIgnore error:' . $frameworkUserModel->getLastSql());
            }
            $conditions['phone'] = $params['phone'];
            $users = $frameworkUserModel->getRows("*", $conditions);
            if (count($users) > 1) {
                $this->fail('DbModel insertIgnore error, expect row count is 1,but get ' . count($users));
            }

            // test replace
            $params['id'] = $insert_id;
            $params['status'] = 2;
            $params['last_login_time'] = time() + 10;
            $exec_ret = $frameworkUserModel->replace($params);
            if (!$exec_ret) {
                $this->fail('DbModel replace error:' . $frameworkUserModel->getLastSql());
            }
            $user = $frameworkUserModel->getRowById($insert_id);
            foreach ($params as $k => $v) {
                $this->assertEquals($v, $user[$k]);
            }

            // test delete
            $delete_ret = $frameworkUserModel->delete($conditions);
            if (!$delete_ret) {
                $this->fail('DbModel delete error:' . $frameworkUserModel->getLastSql());
            }
        } catch (\PDOException $e) {
            $msg =  mb_convert_encoding($e->getMessage(), 'gbk', 'utf-8');
            $this->fail('throw \PDOException :' . $e->getCode() . ' ' .$msg);
        }

    }

    /**
     * 测试批量插入和多行查询
     */
    public function testInsertRowsAndGetRows()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $insert_rows = [];
        for ($i = 0; $i < 5; $i++) {
            $params = [];
            $params['name'] = 'unit_test_name_inserts';
            $params['phone'] = '170' . mt_rand(12345678, 92345678);;
            $params['password'] = md5('123456');
            $params['status'] = 1;
            $params['reg_time'] = time();
            $params['last_login_time'] = time();
            $insert_rows[] = $params;
        }
        $exec_ret = $frameworkUserModel->insertRows($insert_rows);
        if (empty($exec_ret)) {
            $this->fail('DbModel insertRows error:' . $frameworkUserModel->db->pdo->errorInfo());
        }
        $insert_count = $frameworkUserModel->db->pdoStatement->rowCount();
        if (count($insert_rows) != $insert_count) {
            $count = count($insert_rows) ;
            $lastSql = $frameworkUserModel->getLastSql();
            $this->fail("DbModel insertRows expect return {$count}, but get {$exec_ret}\n{$lastSql}")  ;
        }

        // test normal getRows
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['name'] = $insert_rows[0]['name'];
        $users = $frameworkUserModel->getRows('*', $conditions);
        if (empty($users)) {
            $this->fail('DbModel getRows is empty ');
        }
        if ($insert_count != count($users)) {
            $this->fail('DbModel getRows expect count ' . count($insert_rows) . ', but get ' . count($users));
        }

        // test getRows append
        $conditions['name'] = $insert_rows[0]['name'];
        $append = "status=2 ";
        $users = $frameworkUserModel->getRows('id,name,phone,status,reg_time', [], $append);
        if (!empty($users)) {
            $this->fail('DbModel getRows status=2  expect count 0,but get ' . count($users));
        }
        // test sort and limit
        $conditions['name'] = $insert_rows[0]['name'];
        $sort = ' id desc ';
        $limit = 2;
        $users = $frameworkUserModel->getRows('*', [], NULL, $sort, $limit);
        if (count($users) != $limit) {
            $this->fail('DbModel getRows  limit expect   ' . $limit . ',but get ' . count($users));
        }
        if ($users[0]['id'] < $users[1]['id']) {
            $this->fail('DbModel getRows  sort expect desc  ,but get asc');
        }

        // test getRowsByPage
        $conditions['name'] = $insert_rows[0]['name'];
        $order = 'id';
        $desc = 'desc';
        $page = 1;
        $page_size = 2;
        $frameworkUserModel->getRowsByPage($conditions, $order, $desc, $page, $page_size);
        if (count($users) != $page_size) {
            $this->fail('DbModel getRowsByPage  page_size expect   ' . $page_size . ',but get ' . count($users));
        }
        if ($users[0]['id'] < $users[1]['id']) {
            $this->fail('DbModel getRowsByPage  sort expect desc  ,but get asc');
        }

        $conditions['name'] = $insert_rows[0]['name'];
        $delete_ret = $frameworkUserModel->delete($conditions);
        if (!$delete_ret) {
            $this->fail('DbModel delete error:' . $frameworkUserModel->getLastSql());
        }
    }

    public function testUpdate()
    {

        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $info ['reg_time'] = time() + mt_rand(100, 1000);;
        $info['status'] = 2;
        $info['last_login_time'] = time() + 10;
        $conditions['id'] = static::$user['id'];
        list($ret, $affect_count) = $frameworkUserModel->update($info, $conditions);
        if (!$ret) {
            $this->fail('DbModel updateById error expect true ,but get false');
        }
        if (intval($affect_count) < 1) {
            $this->fail('DbModel updateById error expect affect count 1 ,but get ' . $affect_count);
        }
        $user = $frameworkUserModel->getRowById(static::$user['id']);
        foreach ($info as $k => $v) {
            $this->assertEquals($v, $user[$k]);
        }
        static::$user = $user;
    }

    public function testUpdateById()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $info ['reg_time'] = time() + mt_rand(100, 1000);

        list($ret, $affect_count) = $frameworkUserModel->updateById(static::$user['id'], $info);
        if (!$ret) {
            $this->fail('DbModel updateById  expect true ,but get false');
        }
        if (intval($affect_count) < 1) {
            $this->fail('DbModel updateById  expect affect count 1 ,but get ' . $affect_count);
        }
        $user = $frameworkUserModel->getRowById(static::$user['id']);
        $this->assertEquals($info ['reg_time'], $user['reg_time']);
        static::$user = $user;
    }


    public function testInc()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $origin_time = $frameworkUserModel->getOne('reg_time', $conditions);
        $ret = $frameworkUserModel->inc('reg_time', static::$user['id']);
        if ($ret === false) {
            $this->fail('DbModel inc  expect true ,but get false');
        }
        $inced_time = $frameworkUserModel->getOne('reg_time', $conditions);
        if ($inced_time != ($origin_time + 1)) {
            $this->fail('DbModel inc  expect inc to ' . strval($origin_time + 1) . ' ,but get ' . $inced_time);
        }

    }

    public function testDec()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $origin_time = $frameworkUserModel->getOne('reg_time', $conditions);
        $ret = $frameworkUserModel->dec('reg_time', static::$user['id']);
        if ($ret === false) {
            $this->fail('DbModel dec  expect true ,but get false');
        }
        $deced_time = $frameworkUserModel->getOne('reg_time', $conditions);
        if ($deced_time != ($origin_time - 1)) {
            $this->fail('DbModel inc  expect inc to ' . strval($origin_time - 1) . ' ,but get ' . $deced_time);
        }
    }


}
