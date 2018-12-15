<?php

namespace main\app\model;

/**
 *  WidgetModel 模型
 */
class WidgetModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'widget';

    public $fields = '*';

    const   DATA_KEY = 'main_widget';

    /**
     * WidgetModel constructor.
     * @param string $uid
     * @param bool $persistent
     * @throws /Exception
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
     * 通过 key 获取面板
     * @param $key
     * @return array
     */
    public function getByKey($key)
    {
        $row = $this->getRow($this->fields, ['_key' => $key]);
        return $row;
    }

    /**
     * 获取所有数据
     * @return array
     */
    public function getAllItems()
    {
        return $this->getRows('*', [], null, 'order_weight', 'desc');
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
