<?php

namespace main\app\model;

/**
 *  Timeline模型
 */
class OriginModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'origin';

    public $fields = '*';

    const   DATA_KEY = 'main_origin';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByPath($path)
    {
        return $this->getRow('*', ['path' => $path]);
    }

    public function getByName($name)
    {
        return $this->getRow('*', ['name' => $name]);
    }

    public function getAllItems()
    {
        return $this->getRows('*', [], null, 'id', 'asc');
    }

    public function getMapIdAndPath()
    {
        $map = [];
        $result = $this->getRows('id,path', [], null, 'id', 'asc');
        foreach ($result as $item) {
            $map[$item['id']] = $item['path'];
        }
        unset($result);
        return $map;
    }

    public function getPaths()
    {
        return $this->getRows('path,name', [], null, 'id', 'asc', null, true);
    }

    public function insertItem($info)
    {
        return $this->insert($info);
    }

    public function updateItem($id, $info)
    {
        $conditions['id'] = $id;
        return $this->update($info, $conditions);
    }

    public function deleteById($id)
    {
        $conditions = [];
        $conditions['id'] = $id;
        return $this->delete($conditions);
    }
}
