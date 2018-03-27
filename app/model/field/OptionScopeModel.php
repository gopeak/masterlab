<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *  项目1:M 关系的字段方案模型
 */
class OptionScopeModel  extends CacheModel
{
	public $prefix = 'field_';

	public  $table = 'option_scope';

    public $fields = '*';

    public $option_id = '';

    const   DATA_KEY = 'field_option_scope';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;


    public function __construct( $option_id = '', $persistent = false )
    {
        parent::__construct( $option_id, $persistent );

        $this->uid = $option_id;

    }

    /**
     * 创建一个自身的单例对象
     * @param string $option_id
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $option_id = '', $persistent = false )
    {
        $index = $option_id . strval( intval( $persistent ) );
        if ( !isset(self::$_instance[$index]) || !is_object( self::$_instance[$index] ) ) {

            self::$_instance[$index] = new self( $option_id, $persistent );
        }
        return self::$_instance[$index];
    }

    public function getItemsByOptionId( $option_id  )
    {
        return  $this->getRows( '*',['option_id'=>$option_id ] );

    }

    public function getItemsByOptionAndType( $option_id ,$issue_type,$issue_ui_type )
    {
        return  $this->getRows( '*',['option_id'=>$option_id ,'issue_type'=>$issue_type ,'issue_ui_type'=>$issue_ui_type]);

    }

    public function insertItem( $option_id ,$info)
    {
        $info['option_id'] = $option_id;
        return  $this->insert( $info );
    }

    public function updateItemByOptionId( $option_id ,$info )
    {
        $conditions['option_id'] = $option_id;
        return  $this->update( $info ,$conditions );
    }

    public function deleteByOptionId( $option_id  )
    {
        $conditions = [];
        $conditions['option_id'] = $option_id;
        return  $this->delete( $conditions );
    }

}