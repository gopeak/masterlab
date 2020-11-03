<?php

namespace main\app\model;


/**
 *  项目分类
 */
class ProjectTplCatalogLabelModel extends BaseDictionaryModel
{
    public $prefix = 'project_tpl_';

    public $table = 'category_label';

    const  DATA_KEY = 'project_tpl_category_label/';

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
     * @throws \Exception
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    /**
     * @param $id
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * @param $title
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getByName($title)
    {
        $where = ['title' => trim($title)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    /**
     * @param null $projectId
     * @param bool $primaryKey
     * @return array
     */
    public function getByProject($projectId = null, $primaryKey = false)
    {
        $condition = ['project_tpl_id' => $projectId];
        $rows = $this->getRows('*', $condition, null, 'order_weight', 'desc', $primaryKey);
        return $rows;
    }

    /**
     * @param $projectId
     * @param $id
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function removeById($projectId, $id)
    {
        $where = ['project_tpl_id' => $projectId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    /**
     * @param $projectId
     * @param $name
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function checkNameExist($projectId, $name)
    {
        $conditions['project_tpl_id'] = $projectId;
        $conditions['name'] = $name;
        $count = $this->getField('count(*) as cc', $conditions);
        return $count > 0;
    }

    /**
     * @param $projectId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteByProject($projectId)
    {
        $where = ['project_tpl_id' => $projectId];
        $row = $this->delete($where);
        return $row;
    }


}
