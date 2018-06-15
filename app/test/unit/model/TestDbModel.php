<?php


namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\DbModel;
use main\app\model\unit_test\FrameworkUserModel;

/**
 * DbModel 测试类
 * Class TestDbModel
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
        $execRet = $frameworkUserModel->exec($sql, $params);
        if (!$execRet) {
            echo ('DbModel exec error:' . $sql) . "\n";
        }
        $insertId = $frameworkUserModel->db->getLastInsId();
        if (empty($insertId)) {
            echo ('DbModel exec failed ,getLastInsId is empty') . "\n";
        }
        $params['id'] = $insertId;
        static::$user = $params;
    }

    /**
     * 测试获取表名
     */
    public function testGetTable()
    {
        $frameworkUserModel = new FrameworkUserModel();
        try {
            $testUserTable = $frameworkUserModel->getTable();
            $frameworkUserModel->db->getFullFields($testUserTable);
        } catch (\PDOException $e) {
            $this->fail('FrameworkUserModel getTable() faild ,' . $e->getMessage());
        }
    }

    /**
     * 测试预连接
     */
    public function testPrepareConnect()
    {
        DbModel::$pdoDriverInstances = [];
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
        DbModel::$pdoDriverInstances = [];
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
        $this->assertNotEquals($str, $quoted_str, 'DbModel expect quote str,bug not change ');
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
        $this->assertEquals(static::$user['name'], $name);
    }

    /**
     * 测试获取某个字段值
     */
    public function testGetOne()
    {
        $this->assertNotEmpty(static::$user, 'static::$user is empty');
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $name = $frameworkUserModel->getOne('name', $conditions);
        $this->assertEquals(static::$user['name'], $name, 'DbModel getFieldById failed');
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
        $this->assertEquals(1, $count, "DbModel getCount error expect 1 ,but get {$count}");
    }

    /**
     * 测试 错误字段的情况
     */
    public function testCheckField()
    {
        $catch = false;

        $frameworkUserModel = new FrameworkUserModel();
        $dbConfig = $frameworkUserModel->dbConfig['database'][$frameworkUserModel->configName];
        // v($db_config);
        if (isset($dbConfig['show_field_info'])
            && $dbConfig['show_field_info']
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

            $execRet = $frameworkUserModel->insert($params);
            $this->assertTrue($execRet, 'DbModel exec error:' . $frameworkUserModel->getLastSql());

            $insertId = $frameworkUserModel->db->getLastInsId();
            $this->assertNotEmpty($insertId, 'DbModel insert failed ,getLastInsId is empty');

            // test InsertIgnore
            $execRet = $frameworkUserModel->insertIgnore($params);
            $this->assertTrue($execRet, 'DbModel insertIgnore error:' . $frameworkUserModel->getLastSql());

            $conditions['phone'] = $params['phone'];
            $users = $frameworkUserModel->getRows("*", $conditions);
            if (count($users) > 1) {
                $this->fail('DbModel insertIgnore error, expect row count is 1,but get ' . count($users));
            }

            // test replace
            $params['id'] = $insertId;
            $params['status'] = 2;
            $params['last_login_time'] = time() + 10;
            $execRet = $frameworkUserModel->replace($params);
            $this->assertTrue($execRet, 'DbModel replace error:' . $frameworkUserModel->getLastSql());
            $user = $frameworkUserModel->getRowById($insertId);
            foreach ($params as $k => $v) {
                $this->assertEquals($v, $user[$k]);
            }

            // test delete
            $deleteRet = $frameworkUserModel->delete($conditions);
            $this->assertTrue($deleteRet, 'DbModel delete error:' . $frameworkUserModel->getLastSql());
        } catch (\PDOException $e) {
            $msg = mb_convert_encoding($e->getMessage(), 'gbk', 'utf-8');
            $this->fail('throw \PDOException :' . $e->getCode() . ' ' . $msg);
        }
    }

    /**
     * 测试批量插入和多行查询
     */
    public function testInsertRowsAndGetRows()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $insertRows = [];
        for ($i = 0; $i < 5; $i++) {
            $params = [];
            $params['name'] = 'unit_test_name_inserts';
            $params['phone'] = '170' . mt_rand(12345678, 92345678);
            $params['password'] = md5('123456');
            $params['status'] = 1;
            $params['reg_time'] = time();
            $params['last_login_time'] = time();
            $insertRows[] = $params;
        }
        $execRet = $frameworkUserModel->insertRows($insertRows);
        if (empty($execRet)) {
            $this->fail('DbModel insertRows error:' . $frameworkUserModel->db->pdo->errorInfo());
        }
        $insertCount = $frameworkUserModel->db->pdoStatement->rowCount();
        if (count($insertRows) != $insertCount) {
            $count = count($insertRows);
            $lastSql = $frameworkUserModel->getLastSql();
            $this->fail("DbModel insertRows expect return {$count}, but get {$execRet}\n{$lastSql}");
        }

        // test normal getRows
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['name'] = $insertRows[0]['name'];
        $users = $frameworkUserModel->getRows('*', $conditions);
        if (empty($users)) {
            $this->fail('DbModel getRows is empty ');
        }
        if ($insertCount != count($users)) {
            $this->fail('DbModel getRows expect count ' . count($insertRows) . ', but get ' . count($users));
        }

        // test getRows append
        $conditions['name'] = $insertRows[0]['name'];
        $append = "status=2 ";
        $users = $frameworkUserModel->getRows('id,name,phone,status,reg_time', [], $append);
        if (!empty($users)) {
            $this->fail('DbModel getRows status=2  expect count 0,but get ' . count($users));
        }
        // test sort and limit
        $conditions['name'] = $insertRows[0]['name'];
        $sort = ' id desc ';
        $limit = 2;
        $users = $frameworkUserModel->getRows('*', [], null, $sort, $limit);
        if (count($users) != $limit) {
            $this->fail('DbModel getRows  limit expect   ' . $limit . ',but get ' . count($users));
        }
        if ($users[0]['id'] < $users[1]['id']) {
            $this->fail('DbModel getRows  sort expect desc  ,but get asc');
        }

        // test getRowsByPage
        $conditions['name'] = $insertRows[0]['name'];
        $order = 'id';
        $desc = 'desc';
        $page = 1;
        $pageSize = 2;
        $frameworkUserModel->getRowsByPage($conditions, $order, $desc, $page, $pageSize);
        if (count($users) != $pageSize) {
            $this->fail('DbModel getRowsByPage  page_size expect   ' . $pageSize . ',but get ' . count($users));
        }
        if ($users[0]['id'] < $users[1]['id']) {
            $this->fail('DbModel getRowsByPage  sort expect desc  ,but get asc');
        }

        $conditions['name'] = $insertRows[0]['name'];
        $deleteRet = $frameworkUserModel->delete($conditions);
        $this->assertTrue($deleteRet, 'DbModel delete error:' . $frameworkUserModel->getLastSql());
    }

    public function testUpdate()
    {
        if (empty(static::$user)) {
            $this->fail('static::$user is empty');
        }
        $frameworkUserModel = new FrameworkUserModel();
        $info ['reg_time'] = time() + mt_rand(100, 1000);
        $info['status'] = 2;
        $info['last_login_time'] = time() + 10;
        $conditions['id'] = static::$user['id'];
        list($ret, $affectCount) = $frameworkUserModel->update($info, $conditions);
        if (!$ret) {
            $this->fail('DbModel updateById error expect true ,but get false');
        }
        if (intval($affectCount) < 1) {
            $this->fail('DbModel updateById error expect affect count 1 ,but get ' . $affectCount);
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

        list($ret, $affectCount) = $frameworkUserModel->updateById(static::$user['id'], $info);
        if (!$ret) {
            $this->fail('DbModel updateById  expect true ,but get false');
        }
        if (intval($affectCount) < 1) {
            $this->fail('DbModel updateById  expect affect count 1 ,but get ' . $affectCount);
        }
        $user = $frameworkUserModel->getRowById(static::$user['id']);
        $this->assertEquals($info ['reg_time'], $user['reg_time']);
        static::$user = $user;
    }


    public function testInc()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $originTime = $frameworkUserModel->getOne('reg_time', $conditions);
        $ret = $frameworkUserModel->inc('reg_time', static::$user['id']);
        if ($ret === false) {
            $this->fail('DbModel inc  expect true ,but get false');
        }
        $incedTime = $frameworkUserModel->getOne('reg_time', $conditions);
        if ($incedTime != ($originTime + 1)) {
            $this->fail('DbModel inc  expect inc to ' . strval($originTime + 1) . ' ,but get ' . $incedTime);
        }
    }

    public function testDec()
    {
        $frameworkUserModel = new FrameworkUserModel();
        $conditions['id'] = static::$user['id'];
        $originTime = $frameworkUserModel->getOne('reg_time', $conditions);
        $ret = $frameworkUserModel->dec('reg_time', static::$user['id']);
        if ($ret === false) {
            $this->fail('DbModel dec  expect true ,but get false');
        }
        $decedTime = $frameworkUserModel->getOne('reg_time', $conditions);
        if ($decedTime != ($originTime - 1)) {
            $this->fail('DbModel inc  expect inc to ' . strval($originTime - 1) . ' ,but get ' . $decedTime);
        }
    }
}
