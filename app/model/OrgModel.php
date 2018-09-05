<?php

namespace main\app\model;

/**
 *  OrgModel 模型
 */
class OrgModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'org';

    public $fields = '*';

    const   DATA_KEY = 'main_org';

    /**
     * OrgModel constructor.
     * @param string $uid
     * @param bool $persistent
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
    }

    /**
     * 通过 id 获取一条记录
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 通过 path 获取一条记录
     * @param $path
     * @return array
     */
    public function getByPath($path)
    {
        return $this->getRow('*', ['path' => $path]);
    }

    /**
     * 通过 name 获取一条记录
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        return $this->getRow('*', ['name' => $name]);
    }

    /**
     * 获取所有数据
     * @return array
     */
    public function getAllItems()
    {
        return $this->getRows('*', [], null, 'id', 'asc');
    }

    /**
     * 返回 path 和 name 记录
     * @return array
     */
    public function getPaths()
    {
        return $this->getRows('path,name', [], null, 'id', 'asc', null, true);
    }

    /**
     * 新增记录
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($info)
    {
        return $this->insert($info);
    }

    /**
     * 更新记录
     * @param $id
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItem($id, $info)
    {
        $conditions['id'] = $id;
        return $this->update($info, $conditions);
    }

    /**
     * 删除记录
     * @param $id
     * @return bool|int
     */
    public function deleteById($id)
    {
        $conditions = [];
        $conditions['id'] = $id;
        return $this->delete($conditions);
    }
}
