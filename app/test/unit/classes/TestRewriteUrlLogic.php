<?php

namespace main\app\test\unit\classes;

use PHPUnit\Framework\TestCase;

use main\app\model\system\MailQueueModel;
use main\app\classes\RewriteUrl;
use main\app\test\data\LogDataProvider;

/**
 *  RewriteUrlLogic 测试类
 * Class testRewriteUrl
 * @package main\app\test\logic
 */
class TestRewriteUrlLogic extends TestCase
{


    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        RewriteUrlDataProvider::clear();
    }

    /**
     * 测试主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $org = RewriteUrlDataProvider::initOrg();
        $project = RewriteUrlDataProvider::initProject();
        $logic = new RewriteUrl();

        // 测试 setProjectData
        $data = [];
        $_GET['project_id'] = $project['id'];
        $ret = $logic->setProjectData($data);
        $this->assertTrue(isset($ret['project_root_url']));
        $this->assertTrue(isset($ret['org_name']));
        $this->assertTrue(isset($ret['pro_key']));
        $this->assertEquals((int)$project['id'], $ret['project_id']);
        $this->assertEquals($project['name'], $ret['project_name']);

        // 测试 readDir
        $dirs = $logic->readDir(APP_PATH . '/ctrl');
        $this->assertTrue(isset($dirs['Index']));
        $this->assertTrue(isset($dirs['OrgRoute']));
        $this->assertTrue(isset($dirs['issue']));
        $this->assertTrue(isset($dirs['project']));

        // 测试 orgRoute
        // enableSecurityMap 为true
        $config = new \stdClass();
        $config->mod = '';
        $config->ctrl = $org['path'];
        $config->enableSecurityMap = true;
        $ret = $logic->orgRoute($config);
        $this->assertNotEmpty($ret);
        list($arg1, $arg2, $arg3) = $ret;
        $this->assertEquals('OrgRoute', $arg1);
        $this->assertEquals('', $arg2);
        $this->assertEquals('index', $arg3);

        // mod 不为空
        $config = new \stdClass();
        $config->mod = 'issue';
        $config->ctrl = '';
        $config->enableSecurityMap = true;
        $ret = $logic->orgRoute($config);
        $this->assertEmpty($ret);

        // enableSecurityMap 为false
        $config = new \stdClass();
        $config->mod = '';
        $config->ctrl = $org['path'];
        $config->enableSecurityMap = false;
        $ret = $logic->orgRoute($config);
        $this->assertNotEmpty($ret);
        list($arg1, $arg2, $arg3) = $ret;
        $this->assertEquals('OrgRoute', $arg1);
        $this->assertEquals('', $arg2);
        $this->assertEquals('index', $arg3);
    }
}
