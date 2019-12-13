<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项标签数据模型
 */
class IssueLabelDataModel extends BaseIssueItemsModel
{
    public $prefix = 'issue_';

    public $table = 'label_data';

    public $fields = '*';

    const   DATA_KEY = 'issue_label_data';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($issueId = '', $persistent = false)
    {
        parent::__construct($issueId, $persistent);
        $this->issueId = $issueId;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $issueId
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($issueId = '', $persistent = false)
    {
        $index = $issueId . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($issueId, $persistent);
        }
        return self::$instance[$index];
    }

    /**
     * 通过多个标签id获取事项id数组
     * @param $idArr
     * @return array
     */
    public function getIssueIdArrByIds($idArr)
    {
        if (empty($idArr)) {
            return [];
        }
        $idStr = implode(',', $idArr);
        $sql = "select issue_id from " . $this->getTable() . " where label_id in({$idStr})";
        $rows = $this->db->getRows($sql);
        $issueIdArr = [];
        foreach ( $rows as $item) {
            $issueIdArr[] = $item['issue_id'];
        }
        return $issueIdArr;
    }
}
