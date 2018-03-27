<?php
namespace main\app\model\field;
use main\app\model\BaseDictionaryModel;
/**
 *  系统默认的字段排列方案
 *
 */
class LayoutDefaultModel extends BaseDictionaryModel
{
	public $prefix = 'field_';

	public  $table = 'layout_default';
	
	const   DATA_KEY = 'field_layout_default/';

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