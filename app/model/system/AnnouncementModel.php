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

    /**
     * 发布新的公告
     * @param $content
     * @param $expireTime
     * @return bool
     * @throws \Exception
     */
    public function release($content, $expireTime)
    {
        $info = [];
        $info['content'] = $content;
        $info['expire_time'] = strtotime($expireTime); // time() + $expireTime * 60;
        $info['status'] = self::STATUS_RELEASE;
        $ret = $this->updateById(self::ID, $info);
        if ($ret[0]) {
            // 每次发布自增flag值
            return $this->inc('flag', self::ID, 'id', 1);
        } else {
            return false;
        }
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
