<?php

namespace main\app\model;

/**
 *  项目模板模型
 */
class ProjectTemplateModel extends CacheModel
{
    public $prefix = 'project_';

    public $table = 'template';

    public $fields = '*';

    const   DATA_KEY = 'project_tamplate';

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
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }


    /**
     * @param $name
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }


    /**
     * @param $name
     * @return false|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIdByName($name)
    {
        $where = ['name' => trim($name)];
        $id = $this->getField("id", $where);
        return $id;
    }
    /**
     * 通过 key 获取面板
     * @param $key
     * @return array
     * @throws \Doctrine\DBAL\DBALException
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

    public function getItems($categoryId=null)
    {
        $conditionArr = [];
        if($categoryId){
            $conditionArr['category_id'] = (int)$categoryId;
        }
        return $this->getRows('*', $conditionArr, null, 'order_weight', 'desc');
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
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $conditions = [];
        $conditions['id'] = $id;
        return $this->delete($conditions);
    }
}
