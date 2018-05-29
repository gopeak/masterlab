<?php
namespace main\app\model\agile;

use main\app\model\BaseDictionaryModel;

/**
 *  看板列模型
 *
 */
class AgileBoardColumnModel extends BaseDictionaryModel
{
    public $prefix = 'agile_';

    public $table = 'board_column';

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
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByName($name)
    {
        $where = ['name' => $name];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }

    /**
     * 获取看板的所有列定义
     * @param $boardId
     * @return array
     * @throws \Exception
     */
    public function getsByBoard($boardId)
    {
        $params = ['board_id' => (int)$boardId];
        $rows = $this->getRows("*", $params);
        return $rows;
    }

    public function deleteByBoardId($projectId)
    {
        $conditions = [];
        $conditions['board_id'] = intval($projectId);
        return $this->delete($conditions);
    }
}
