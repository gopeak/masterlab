<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\CacheKeyModel;

/**
 *  CacheKeyModel 测试类
 * User: sven
 */
class TestCacheKeyModel extends TestCase
{

    public static $moduleNameArr = [];

    /**
     * @var CacheKeyModel
     */
    public static $model = null;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        // 构建实例
        self::$model = new CacheKeyModel();
    }

    public static function tearDownAfterClass()
    {
        if (!empty(self::$moduleNameArr)) {
            foreach (self::$moduleNameArr as $name) {
                $condition = [];
                $condition['module'] = $name;
                self::$model->delete($condition);
            }
        }
    }

    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $model = self::$model;

        // 1.创建测试数据
        $module = 'test-module-' . mt_rand(10000, 99999);
        self::$moduleNameArr[] = $module;
        $expire = 3600;
        for ($i = 1; $i <= 5; $i++) {
            $cacheKey = 'key-' . $i;
            $cacheValue = 'value-' . $i;
            $model->saveCache($module, $cacheKey, $cacheValue, $expire);
        }
        $rows = $model->getRows('key', ['module' => $module]);
        $this->assertNotEmpty($rows);
        if ($model->cache) {
            for ($i = 1; $i <= 5; $i++) {
                $cacheKey = 'key-' . $i;
                $cacheValue = 'value-' . $i;
                $this->assertEquals($cacheValue, $model->getCache($cacheKey));
            }
        }

        $ret = $model->clearCache($module);
        $this->assertTrue($ret);
        if ($model->cache) {
            for ($i = 1; $i <= 5; $i++) {
                $cacheKey = 'key-' . $i;
                $this->assertFalse($model->getCache($cacheKey));
            }
        }
    }

    /**
     * 资源回收
     * @throws \Exception
     */
    public function testGc()
    {
        $model = self::$model;

        // 1.创建测试数据
        $module = 'test-module-' . mt_rand(10000, 99999);
        self::$moduleNameArr[] = $module;
        $expire = 2;
        for ($i = 1; $i <= 5; $i++) {
            $cacheKey = 'gc-key-' . $i;
            $cacheValue = 'gc-value-' . $i;
            $model->saveCache($module, $cacheKey, $cacheValue, $expire);
        }
        // 停止3秒,然后执行 gc(),检查是否清除
        usleep(3);
        $ret = $model->gc();
        $this->assertTrue($ret);
        if ($model->cache) {
            for ($i = 1; $i <= 5; $i++) {
                $cacheKey = 'gc-key-' . $i;
                $this->assertFalse($model->getCache($cacheKey));
            }
        }
        $rows = $model->getRows('key', ['module' => $module]);
        $this->assertEmpty($rows);
    }
}
