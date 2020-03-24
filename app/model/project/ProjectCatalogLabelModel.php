<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 *  项目分类
 */
class ProjectCatalogLabelModel extends BaseDictionaryModel
{
    public $prefix = 'project_';

    public $table = 'catalog_label';

    const  DATA_KEY = 'project_catalog_label/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @return self
     * @throws \PDOException
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByName($title)
    {
        $where = ['title' => trim($title)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getByProject($projectId = null, $primaryKey = false)
    {
        $condition = ['project_id' => $projectId];
        $rows = $this->getRows('*', $condition, null, 'order_weight', 'desc', $primaryKey);
        return $rows;
    }

    public function removeById($projectId, $id)
    {
        $where = ['project_id' => $projectId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    public function checkNameExist($projectId, $name)
    {
        $conditions['project_id'] = $projectId;
        $conditions['name'] = $name;
        $count = $this->getOne('count(*) as cc', $conditions);
        return $count > 0;
    }

}
