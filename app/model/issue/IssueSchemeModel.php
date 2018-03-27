<?php
namespace main\app\model\issue;
use main\app\model\BaseDictionaryModel;
/**
 *  系统自带的字段
 *
 */
class IssueSchemeModel extends BaseDictionaryModel
{
	public $prefix = 'issue_';

	public  $table = 'scheme';
	
	const   DATA_KEY = 'issue_scheme/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $persistent=false )
    {
        if( !isset(self::$_instance[intval($persistent)] ) || !is_object( self::$_instance[intval($persistent)]) ) {

            self::$_instance[intval($persistent)]  = new self( $persistent );
        }
        return self::$_instance[intval($persistent)] ;
    }

}