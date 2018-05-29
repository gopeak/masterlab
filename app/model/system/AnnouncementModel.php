<?php

namespace main\app\model\system;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class AnnouncementModel extends BaseDictionaryModel
{
    public $prefix = 'main_';

    public $table = 'announcement';

    public $fields = '*';

    const STATUS_DISABLE = 0;

    const STATUS_RELEASE = 1;

    const ID = 1;

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

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

    public function release($content, $expireTime)
    {
        $info = [];
        $info['id'] = self::ID;
        $info['content'] = $content;
        $info['expire_time'] = time() + $expireTime * 60;
        $info['status'] = self::STATUS_RELEASE;
        $this->replace($info);

        // 每次发布自增flag值
        $this->inc('flag', self::ID, 'id', 1);
    }

    public function disable()
    {
        $info = [];
        $info['status'] = self::STATUS_DISABLE;
        $condition = [];
        $condition['id'] = self::ID;
        $this->update($info, $condition);
    }
}
