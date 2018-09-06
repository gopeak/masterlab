<?php
namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class IssueTypeSchemeModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'type_scheme';
    
    const   DATA_KEY = 'issue_type_scheme/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    /**
     * 通过名称获取记录
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }
}
