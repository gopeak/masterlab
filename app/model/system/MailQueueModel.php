<?php

namespace main\app\model\system;

use main\app\model\DbModel;

/**
 *
 * 邮件队列model
 * @author Sven
 */
class MailQueueModel extends DbModel
{
    public $prefix = 'main_';

    public $table = 'mail_queue';

    public $fields = ' * ';

    public $primaryKey = 'id';


    const STATUS_READY = 'ready';
    const STATUS_PENDING = 'pending';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';


    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;


    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    /**
     * 获取操作项
     * @return array
     */
    public static function getStatus()
    {
        $reflect = new \ReflectionClass(__CLASS__);
        $constants = $reflect->getConstants();
        $actions = [];
        if (!empty($constants)) {
            foreach ($constants as $k => $c) {
                if (strpos($k, 'STATUS_') === 0) {
                    $actions[$k] = $c;
                }
            }
        }
        return $actions;
    }

    /**
     *
     * 添加一个队列
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public function add($info)
    {
        if (is_object($info)) {
            $info = (array)$info;
        }
        if (!isset($info['create_time'])) {
            $info['create_time'] = time();
        }

        return parent::insert($info);
    }
}
