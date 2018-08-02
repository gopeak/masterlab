<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 *  迭代汇总表模型
 */
class ReportSprintIssueModel extends BaseDictionaryModel
{
    public $prefix = 'report_';

    public $table = 'sprint_issue';

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
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getsBySprint($sprintId)
    {
        $params = ['sprint_id' => (int)$sprintId];
        $rows = $this->getRows("*", $params);
        return $rows;
    }

    public function removeById($sprintId, $id)
    {
        $where = ['sprint_id' => $sprintId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    public function removeBySprint($sprintId)
    {
        $where = ['sprint_id' => $sprintId];
        $row = $this->delete($where);
        return $row;
    }
}
