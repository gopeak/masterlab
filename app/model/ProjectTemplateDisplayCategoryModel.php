<?php

namespace main\app\model;

/**
 *  ProjectTemplateDisplayCategoryModel 模型
 */
class ProjectTemplateDisplayCategoryModel extends CacheModel
{
    public $prefix = 'project_template_';

    public $table = 'display_category';

    public $fields = '*';

    const   DATA_KEY = 'project_template_display_category';

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
     * 通过 key 获取面板
     * @param $key
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getByName($name)
    {
        $row = $this->getRow($this->fields, ['name' => $name]);
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
     * @param $categoryId
     * @return array
     */
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
