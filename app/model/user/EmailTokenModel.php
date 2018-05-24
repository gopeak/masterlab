<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 * EmailToken表模型操作类
 *
 * @author sven
 *
 */
class EmailTokenModel extends CacheModel
{

    public $prefix = 'user_';

    public $table = 'email_token';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 创建一个自身的单例对象
     *
     * @param array $dbConfig
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance) || !is_object(self::$_instance)) {

            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
