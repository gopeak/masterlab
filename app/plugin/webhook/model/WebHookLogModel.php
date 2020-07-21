<?php

namespace main\app\plugin\webhook\model;

use main\app\model\DbModel;
/**
 * WebHookModel
 * @author sven
 *
 */
class WebHookLogModel extends DbModel
{

    /**
     *  表前缀
     * @var string
     */
    public $prefix = 'main_';

    /**
     * 表名称
     * @var string
     */
    public $table = 'webhook_log';

    /**
     * 要获取字段
     * @var string
     */
    public $fields = '*';

    /**
     * 准备中
     */
    const  STATUS_READY = 0;
    /**
     * 执行成功
     */
    const  STATUS_SUCCESS = 1;
    /**
     * 异步发送失败
     */
    const  STATUS_ASYNC_FAILED = 2;
    /**
     * 队列中
     */
    const  STATUS_PENDING = 3;
    /**
     * 执行失败
     */
    const  STATUS_FAILED = 4;

    /**
     * 定义状态
     * @var array
     */
    public static $statusArr = [
        self::STATUS_READY => '准备中',
        self::STATUS_SUCCESS => '执行成功',
        self::STATUS_ASYNC_FAILED => '异步发送失败',
        self::STATUS_PENDING => '队列中',
        self::STATUS_FAILED => '执行失败',
    ];

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \Exception
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
     * 获取全部数据
     */
    public function getAllItem(){
        return $this->getRows('*');
    }

    /**
     * @param $id
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }


}

