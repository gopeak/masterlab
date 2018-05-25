<?php

namespace main\app\model\user;

use main\app\model\CacheModel;
use main\app\classes\SettingsLogic;
/**
 *  系统消息模型操作类
 * @author sven
 *
 */
class MessageModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'message';

    public $primaryKey = 'id';

    const DATA_KEY = 'msg/';

    public $module_key = '';

    /**
     * 系统到用户
     *
     * @var int
     */
    const DIRECTION_SYS_2_USER = 1;

    /**
     * 用户到用户
     *
     * @var int
     */
    const DIRECTION_USER_2_USER = 1;

    /**
     * 消息未读
     *
     * @var int
     */
    const READED_NO = 0;

    /**
     * 消息已读
     *
     * @var int
     */
    const READED_YES = 1;

    /**
     * 消息类型,系统通知
     * @var int
     */
    const TYPE_SYSTEM = 1;

    /**
     * 系统公告
     * @var int
     */
    const TYPE_ANNOUS = 2;


    const LAST_UNREADED_LIMIT = 5;

    /**
     * 用于实现单例模式
     *
     * @var self
     */
    protected static $instance;

    protected static $instances;

    public function __construct($uid = 0)
    {
        parent::__construct($uid);
        $this->module_key = MessageModel::DATA_KEY . 'module/' . $uid;
    }

    /**
     *
     * @param int $uid
     * @return \main\platform\model\self
     */
    public static function getInstance($uid)
    {
        if (!isset(self::$instances[$uid]) || !is_object(self::$instances[$uid])) {
            self::$instances[$uid] = new self($uid);
        }
        return self::$instances[$uid];
    }

    /**
     * 系统消息到用户
     *
     * @param string $msg_uid
     * @param string $type
     * @param string $title
     * @param string $text
     */
    public function setMsg2User($msg_uid, $type, $title, $content)
    {
        $siteName = (new SettingsLogic())->showSysTitle();
        $insertInfo = [];
        $insertInfo['sender_uid'] = '0';
        $insertInfo['sender_name'] = $siteName;
        $insertInfo['direction'] = self::DIRECTION_SYS_2_USER;
        $insertInfo['receiver_uid'] = $msg_uid;
        $insertInfo['title'] = $title;
        $insertInfo['content'] = $content;
        $insertInfo['readed'] = self::READED_NO;
        $insertInfo['type'] = $type;
        $insertInfo['create_time'] = time();
        return $this->addMessage($insertInfo);
    }

    /**
     * 添加一条消息到数据库
     *
     * @param array $row
     * @return boolean
     * @author sven
     */
    public function addMessage($info)
    {
        $ret = parent::insertByKey($this->getTable(), $info);
        if ($ret) {
            $this->clearModuleCache();
        }
        return $ret;
    }

    /**
     *
     * @param int $uid
     * @param string $where
     * @param int $page
     * @param int $pagesize
     * @param string $order
     * @param string $orderby
     * @return  mixed[]
     */
    public function getMessagesByWhere($uid, $where, $page, $pagesize = 20, $orderby = 'id', $sort = 'DESC')
    {
        $start = $pagesize * ($page - 1);

        $table = $this->getTable();

        $total = $this->getCountMessage($uid, $where);
        $totalPages = ceil($total / $pagesize);
        if (!$total) {
            $totalPages = 0;
        }

        $fields = ' id,direction,title, sender_uid,sender_name,receiver_uid,type,readed,create_time ';
        //$where .= " ORDER BY $order $orderby LIMIT $start,$pagesize ";
        $limit = "$start, $pagesize";
        $messages = parent::getRowsByKey($table, $fields, $where, null, $orderby, $sort, $limit);

        return [
            $total,
            $totalPages,
            $messages
        ];
    }

    /**
     * 更新消息已读
     * @param string $id
     * @param string $msg
     * @return boolean
     */
    public function updateMsgReaded($id, $msg)
    {
        $info = [];
        $msg['read_time'] = $info['read_time'] = time();

        // 更新用户表的unreaded_msg，减去1
        if ($msg['readed'] == self::READED_NO) {
            $info['readed'] = self::READED_YES;
            UserFlagModel::getInstance($this->uid)->decUnreadFlag($this->uid);
        }
        return $this->updateMessage($id, $info);
    }

    /**
     * 获取未读的消息列表
     * @return []
     */
    public function getLastUnreaded()
    {
        $uid = $this->uid;
        $key = self::DATA_KEY . 'get_last_unreaded/' . $uid;
        $memFlag = $this->cache->get($key);
        if ($memFlag !== false) {
            return $memFlag;
        }

        $readed = self::READED_NO;
        $page = 1;
        $pagesize = self::LAST_UNREADED_LIMIT;
        //$where = " Where receiver_uid='$uid'  ";
        //$where .= " AND readed='$readed'  ";
        $where = array('receiver_uid' => $uid, 'readed' => $readed);

        list (, , $messages) = $this->getMessagesByWhere($uid, $where, $page, $pagesize);
        foreach ($messages as &$row) {
            $row['create_time'] = gettime($row['create_time']);
        }

        $module = self::DATA_KEY . 'module/' . $uid;
        CacheKeyModel::getInstance()->saveCache($module, $key, $messages);

        return $messages;
    }

    /**
     * 取出总数
     * @param int $uid
     * @param string $where
     * @return number
     */
    public function getCountMessage($where)
    {
        $fields = "COUNT(*) as cc ";
        $total = parent::getOneByKey($fields, $where);
        if (!$total) {
            $total = 0;
        }
        return (int)$total;
    }


    public function getUnreaedCount()
    {
        $uid = $this->uid;
        $key = self::DATA_KEY . 'unreaded_count/' . $uid;
        $memFlag = $this->cache->get($key);
        if ($memFlag !== false) {
            return $memFlag;
        }

        $readed = MessageModel::READED_NO;
        $where = array('receiver_uid' => $uid);
        //$where = " Where receiver_uid='$uid'  ";
        if ($readed != 2) {
            //$where .= " AND readed='$readed'  ";
            $where['readed'] = $readed;
        }
        $fields = "COUNT(*) as cc ";
        $total = parent::getOne($this->getTable(), $fields, $where);
        // v( $this->db->queryStr  );
        //v( $total );
        if (!$total) {
            $total = 0;
        }
        $module = self::DATA_KEY . 'module/' . $uid;
        CacheKeyModel::getInstance()->saveCache($module, $key, $total);
        return (int)$total;
    }

    public function getUnreadedCountByType($type)
    {
        $uid = $this->uid;
        $type = (int)$type;
        $key = self::DATA_KEY . 'unreaded_TYPE_count/' . $type . '/' . $uid;
        $memFlag = $this->cache->get($key);
        if ($memFlag !== false) {
            return $memFlag;
        }

        $readed = MessageModel::READED_NO;
        //$where = " Where receiver_uid='$uid' AND type='$type' ";
        $where = array('receiver_uid' => $uid, 'type' => $type);
        if ($readed != 2) {
            //$where .= " AND readed='$readed'  ";
            $where['readed'] = $readed;
        }
        $fields = "COUNT(*) as cc ";
        $total = parent::getOneByKey($fields, $where);
        if (!$total) {
            $total = 0;
        }
        $module = self::DATA_KEY . 'module/' . $uid;
        CacheKeyModel::getInstance()->saveCache($module, $key, $total);
        return (int)$total;
    }

    /**
     * 读取一条消息
     * @param int $id
     * @return string[]
     */
    public function getMessage($id)
    {
        $fields = '*';
        //$where = "WHERE id=$id";
        $where = array('id' => $id);
        $key = self::DATA_KEY . 'id/' . $id;
        $result = parent::getRowByKey($fields, $where, false, $key);
        return $result;
    }

    /**
     * 更新一条记录
     * @param int $id
     * @param [] $row
     * @return bool
     */
    public function updateMessage($id, $row)
    {
        $table = $this->getTable();
        //$where = "WHERE id=$id";
        $where = array('id' => $id);
        $key = self::DATA_KEY . 'id/' . $id;
        list($ret) = parent::updateByKey($table, $where, $row, $key);
        if ($ret) {
            $this->clearModuleCache();
        }
        return $ret;
    }

    /**
     * 删除一条记录
     * @param integer $id
     * @return bool
     */
    public function deleteMessage($id)
    {
        $table = $this->getTable();
        //$where = "WHERE id=$id";
        $where = array('id' => $id);
        $key = self::DATA_KEY . 'id/' . $id;
        $ret = parent::deleteByKey($table, $where, $key);
        if ($ret) {
            $this->clearModuleCache();
        }
        return $ret;
    }

    /**
     * 删除用户的所有记录
     * @param integer $id
     * @return bool
     */
    public function deleteUserMessage($uid)
    {
        $table = $this->getTable();
        //$where  = "WHERE receiver_uid=$uid";
        $where = array('receiver_uid' => $uid);
        $key = '';
        $ret = parent::deleteByKey($table, $where, $key);
        if ($ret) {
            $this->clearModuleCache();
        }
        return $ret;
    }

    /**
     * 删除用户相关的所有缓存
     */
    public function clearModuleCache()
    {
        CacheKeyModel::getInstance()->clearCache($this->module_key);
    }

    public function pushMessage($rows, $data)
    {
        foreach ($rows as $row) {
            $data['receiver_uid'] = $row['uid'];
            $this->insert($data);
        }
        return true;
    }
}
