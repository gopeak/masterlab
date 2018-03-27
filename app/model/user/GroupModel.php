<?php
namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *
 *
 *
 */
class GroupModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'group';
    
    const   DATA_KEY = 'main_group/';
    
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
    
        $this->uid = $uid;
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }


    public function getAll($primary_key = true)
    {
        $fields="id as k,".$this->getTable().'.* ';
        return $this->getRows(
            $fields,
            $conditions = array(),
            $append = null,
            $sort = 'id asc',
            $limit = null,
            $primary_key
        );
    }

    public function getIds()
    {
        $rows =  $this->getRows(
            $fields = "id as k,group_name",
            $conditions = array(),
            $append = null,
            $ordryBy = 'id',
            $sort = 'asc',
            $limit = null,
            $primary_key = true
        );
        return array_keys($rows);
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }
}
