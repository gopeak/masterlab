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
     * @throws PDOException
     * @return self
     */
    public static function getInstance($persistent=false)
    {
        if (!isset(self::$instance[intval($persistent)]) || !is_object(self::$instance[intval($persistent)])) {
            self::$instance[intval($persistent)]  = new self($persistent);
        }
        return self::$instance[intval($persistent)] ;
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }
}
