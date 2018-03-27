<?php
namespace main\platform\model;

use main\platform\classes\admin\Page;
use main\platform\model\UserAppsModel;

class AppsModel extends CacheModel
{
    public $table = 'apps';

    public $fields = ' * ';

    public $primary_key = 'id';

    const  DATA_KEY = 'apps/';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;
    
    public function __construct( $persistent=false )
    {
        parent::__construct( $persistent );
    }

    /**
     * 创建一个自身的单例对象
     * @param array $dbConfig
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $persistent=false )
    {
        $index =  intval($persistent) ;
        if( !isset(self::$_instance[$index] ) || !is_object( self::$_instance[$index]) ) {

            self::$_instance[$index]  = new self( $persistent );
        }
        return self::$_instance[$index] ;
    }

    /**
     * 通过APPID获取服务器信息
     * @param $appid
     * @return array 一条查询数据
     */
    public function getApp( $appid )
    {
        $table	= $this->getTable();
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['appid' => $appid];
        $row	=	parent::getRow( $table, $fields, $where );
        if(!$row){
            $where = ['id' => $appid];
            $row	=	parent::getRow( $table, $fields, $where );
        }
        return  $row;
    }

    /**
     * 获取所有的数据
     *
     */
    public function getAllRows(){
        $table	= $this->getTable();
        $fields	=	"*,{$this->primary_key} as k";
        $where = [];
        $rows	=	parent::getRows( $table, $fields, $where );
        return  $rows;
    }
    
    /**
     * 通过ID获取服务信息
     * @param $appid
     * @return  array 一条查询数据
     */
    public function getAppById( $id )
    {
        $table	= $this->getTable();
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['id' => $id];
        $row	=	parent::getRow( $table, $fields, $where );
        return  $row;
    }

    /**
     * 添加
     */
    public function addApps($row)
    {
        $table = $this->getTable();
        return parent::insert($table, $row);
    }

    /**
     * 更新
     */
    public function updateApps($id, $row)
    {
        $table = $this->getTable();
        $conditions = ['id' => $id];
        list( $ret ) = parent::update($table, $row, $conditions);
        return $ret;
    }

	/**
     * 获取服务
     */
    public function getAppByName($name){
        $table	= $this->getTable();
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['name' => $name];
        $row	=	parent::getRow( $table, $fields, $where );
        return  $row;
    }
	
	
    /**
     * 删除
     */
    public function deleteApps($id)
    {
        $table = $this->getTable();
        $conditions = ['id' => $id];
        return parent::delete($table, $conditions);
    }

    /**
     * 启用/停用
     */
    public function enableApps($id, $isopen)
    {
        $table = $this->getTable();
        $conditions = ['id' => $id];
        $row = ['isopen' => (int)(!$isopen)];
        list( $ret ) = parent::update($table, $row, $conditions);
        return $ret;
    }

    public function getAppsPaginate()
    {
        $isopen = trim(getQuery('isopen'));
        $type = trim(getQuery('type'));
        $name = addslashes(trim(getQuery('name')));
        $key = addslashes(trim(getQuery('key')));

        $table = $this->getTable();
        $pageSize = 20;
        $where = " WHERE 1 ";

        if ($isopen != '') {
            $where .= " AND `isopen` = " . (int)$isopen;
        }

        if ($type != '') {
            $where .= " AND `type` = " . (int)$type;
        }

        if ($name != '') {
            $where .= " AND `name` LIKE '%" . $name . "%'";
        }

        if ($key != '') {
            $where .= " AND `key` LIKE %" . $key . "%";
        }

        //总数
        $sql = "SELECT COUNT(*) FROM $table $where";
        $total = $this->db->getOne($sql);

        $pager = Page::getInstance($total, $pageSize);
        $totalPages = $pager->getPagenum();

        //列表
        $where .= " ORDER BY _sort DESC, `id` ASC " . $pager->getLimit();
        $sql = "SELECT * FROM $table $where";

        $data = $this->db->getRows($sql);
        return array($pager, $data);
    }

    /**
     * 获取服务列表.
     * @param bool $defaultOpen 是否仅获取默认开通的服务.
     * @param bool $isopen 是否仅获取启用状态的服务.
     * @param array $excludeIdList 仅获取ID不在此列的服务.
     * @return array
     */
    public function getlist($defaultOpen=false, $isopen=false, $excludeIdList=[])
    {
        $table = $this->getTable();
        $sql = "SELECT * FROM  $table WHERE 1 ";
        if ($defaultOpen){
            // 默认开通：包括默认开通，以及默认开通且无法取消两种授权类型.
            $sql .= " AND auth_type > 0 ";
        }
        if ($isopen){
            // 检索启用状态的服务
            $sql .= " AND isopen = 1 ";
        }
        if (is_array($excludeIdList) && !empty($excludeIdList)){
            foreach ($excludeIdList as $index => $value){
                if (empty($value)){
                    unset($excludeIdList[$index]);
                }
            }
            $excludeIdList = implode(',', $excludeIdList);
            $sql .= " AND id NOT IN ($excludeIdList)";
        }
        $sql .= 'ORDER BY _sort DESC, id';
        $data = $this->db->getRows($sql);
        return $data;
    }

    public function getApplist($uid){
        $table = $this->getTable();
        $uMlodel = UserAppsModel::getInstance();
        $uTable = $uMlodel->getTable();
        $table = $table . " as a  LEFT JOIN  $uTable as b  ON  a.`id`= b.`app_id`";
        $sql = "SELECT * FROM  $table WHERE   isopen=1 AND uid = $uid  GROUP BY b.`app_id` ";
       
        $data = $this->db->getRows($sql);
        return $data;
    }


    public function getType($key = null)
    {
        $data = [
            '0' => '平台',
            '1' => '子系统',
        ];
        return getArrayValue($data, $key);
    }

    public function getAuthType($key = null)
    {
        $data = [
            '0' => '需要授权开通',
            '1' => '默认开通',
            '2' => '默认开通且无法取消授权',
        ];
        return getArrayValue($data, $key);
    }
}