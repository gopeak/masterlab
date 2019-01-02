<?php

namespace main\app\model\project;

use main\app\model\DbModel;

/**
 *  项目列表统计项目数量模型
 */
class ProjectListCountModel extends DbModel
{
    public $prefix = 'project_';

    public $table = 'list_count';

    const  DATA_KEY = 'project_list_count/';

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

    public function getTotal()
    {
        $total = $this->getOne('sum(`project_total`) as `total`', []);
        return $total;
    }

    /**
     * @param $typeId
     * @return bool
     */
    public function incrByTypeid($typeId)
    {
        return $this->inc('project_total', $typeId, 'project_type_id');
    }

    /**
     * @param $typeId
     * @return bool
     */
    public function decrByTypeid($typeId)
    {
        return $this->dec('project_total', $typeId, 'project_type_id');
    }

}
