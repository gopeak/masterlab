<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *  项目1:M 关系的字段方案模型
 */
class FieldOptionModel  extends CacheModel
{
	public $prefix = 'field_';

	public  $table = 'option';

    public $fields = '*';

    public $field_id = '';

    const   DATA_KEY = 'field_option';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;


    public function __construct( $field_id = '', $persistent = false )
    {
        parent::__construct( $field_id, $persistent );

        $this->uid = $field_id;

    }

    /**
     * 创建一个自身的单例对象
     * @param string $field_id
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $field_id = '', $persistent = false )
    {
        $index = $field_id . strval( intval( $persistent ) );
        if ( !isset(self::$_instance[$index]) || !is_object( self::$_instance[$index] ) ) {

            self::$_instance[$index] = new self( $field_id, $persistent );
        }
        return self::$_instance[$index];
    }

    public function getItemsByFieldId( $field_id  )
    {
        return  $this->getRows( '*',['field_id'=>$field_id ] );

    }

    public function getItemsByFieldAndType( $field_id ,$issue_type,$issue_ui_type )
    {
        return  $this->getRows( '*',['field_id'=>$field_id ,'issue_type'=>$issue_type ,'issue_ui_type'=>$issue_ui_type]);

    }

    public function insertItem( $field_id ,$info)
    {
        $info['field_id'] = $field_id;
        return  $this->insert( $info );
    }

    public function updateItemByFieldId( $field_id ,$info )
    {
        $conditions['field_id'] = $field_id;
        return  $this->update( $info ,$conditions );
    }

    public function deleteByFieldId( $field_id  )
    {
        $conditions = [];
        $conditions['field_id'] = $field_id;
        return  $this->delete( $conditions );
    }

}