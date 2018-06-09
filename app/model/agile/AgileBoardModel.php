<?php

namespace main\app\model\agile;

use main\app\model\BaseDictionaryModel;

/**
 *  看板模型
 *
 */
class AgileBoardModel extends BaseDictionaryModel
{
    public $prefix = 'agile_';

    public $table = 'board';

    const   DATA_KEY = 'agile_board';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    /**
     * 通过id获取记录
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        $row = $this->getRowById($id, "*");
        return $row;
    }

    /**
     * 通过名称获取记录
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }


    /**
     * 获取项目的所有board定义
     * @param $projectId
     * @return array
     */
    public function getsByProject($projectId)
    {
        $params = ['project_id' => (int)$projectId];
        $rows = $this->getRows("*", $params);
        return $rows;
    }

    public function deleteByProjectId($projectId)
    {
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        return $this->delete($conditions);
    }
}
