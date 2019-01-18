<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 *  项目汇总表模型
 */
class ReportProjectIssueModel extends BaseDictionaryModel
{
    public $prefix = 'report_';

    public $table = 'project_issue';

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

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getsByProject($projectId)
    {
        $params = ['project_id' => (int)$projectId];
        $rows = $this->getRows("*", $params);
        return $rows;
    }

    public function removeById($projectId, $id)
    {
        $where = ['project_id' => $projectId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    public function removeByProject($projectId)
    {
        $where = ['project_id' => $projectId];
        $row = $this->delete($where);
        return $row;
    }
}
