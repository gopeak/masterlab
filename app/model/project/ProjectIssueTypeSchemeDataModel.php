<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 *  事项类型方案子项1:M 关系的字段方案模型
 */
class ProjectIssueTypeSchemeDataModel extends CacheModel
{
    public $prefix = 'project_';

    public $table = 'issue_type_scheme_data';

    const   DATA_KEY = 'project_issue_type_scheme_data/';

    public $fields = '*';


    public $master_id = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;


    public function __construct($master_id = '', $persistent = false)
    {
        parent::__construct($master_id, $persistent);

        $this->uid = $master_id;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $master_id
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($master_id = '', $persistent = false)
    {
        $index = $master_id . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($master_id, $persistent);
        }
        return self::$instance[$index];
    }

    public function getSchemeId($projectId)
    {
        return $this->getOne('issue_type_scheme_id', ['project_id' => $projectId]);
    }

    public function deleteBySchemeId($scheme_id)
    {
        $conditions['issue_type_scheme_id'] = $scheme_id;
        return $this->delete($conditions);
    }

    public function getByProjectId($project_id)
    {
        $sql = "SELECT * FROM (
SELECT pitsd.issue_type_scheme_id, pitsd.project_id, itsd.type_id from project_issue_type_scheme_data as pitsd 
JOIN issue_type_scheme_data as itsd ON pitsd.issue_type_scheme_id=itsd.id 
WHERE pitsd.project_id={$project_id}
) as sub JOIN issue_type as issuetype ON sub.type_id=issuetype.id";

        return $this->db->getRows($sql);
    }

}
