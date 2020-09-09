<?php

namespace main\app\model;

use main\app\model\BaseDictionaryModel;

/**
 *  标签模型
 */
class ProjectTplLabelModel extends BaseDictionaryModel
{
    public $prefix = 'project_tpl_';

    public $table = 'label';

    const  DATA_KEY = 'project_tpl_label/';

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
     * @param null $projectTplId
     * @param bool $primaryKey
     * @return array|mixed[]
     */
    public function getByProject($projectTplId = null, $primaryKey = false)
    {
        $table = $this->getTable();
        $params = [];
        $appendSql = '';
        if (!empty($projectTplId)) {
            $params['project_tpl_id'] = $projectTplId;
            $appendSql = ' OR project_tpl_id=:project_tpl_id ';
        }
        $sql = "Select *  From {$table}  Where project_tpl_id=0 {$appendSql}  Order by  id  ASC ";
        $rows = $this->fetchALLForGroup($sql, $params, $primaryKey);
        return $rows;
    }

    /**
     * @param $projectTplId
     * @param $id
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function removeById($projectTplId, $id)
    {
        $where = ['project_tpl_id' => $projectTplId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    /**
     * @param $projectTplId
     * @param $name
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function checkNameExist($projectTplId, $name)
    {
        $conditions['project_tpl_id'] = $projectTplId;
        $conditions['title'] = $name;
        $count = $this->getCount($conditions);
        return $count > 0;
    }

    /**
     * @param $projectTplId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteByProject($projectTplId)
    {
        $where = ['project_tpl_id' => $projectTplId];
        $row = $this->delete($where);
        return $row;
    }

}
