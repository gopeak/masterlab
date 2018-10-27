<?php

namespace main\app\model\unit_test;

use main\app\model\CacheKeyModel;

/**
 * 缓存键表模型操作类
 *
 * @author sven
 *
 */
class FrameworkCacheKeyModel extends CacheKeyModel
{

    public $prefix = 'hornet_';

    public $table = 'cache_key';

    public $primaryKey = '`key`';

    public $fields = ' * ';

    /**
     * 用于实现单例模式
     *
     * @var self
     */
    protected static $instance;

    public function __construct()
    {
        parent::__construct();
        parent::gc();
    }
}
