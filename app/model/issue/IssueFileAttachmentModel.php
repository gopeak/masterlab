<?php
namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class IssueFileAttachmentModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'file_attachment';
    
    const   DATA_KEY = 'issue_file_attachment/';

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

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByUuid($uuid)
    {
        $where = ['uuid' => trim($uuid)];
        $row    =    $this->getRow("*", $where);
        return  $row;
    }

    public function getsByIssueId($issueId)
    {
        $where = ['issue_id' => $issueId];
        $rows    =    $this->getRows("*", $where);
        return  $rows;
    }

    public function getsByTmpIssueId($issueId)
    {
        $where = ['tmp_issue_id' => $issueId];
        $rows    =    $this->getRows("*", $where);
        return  $rows;
    }

    public function deleteByUuid( $uuid )
    {
        $flag   =  $this->delete( ['uuid' => $uuid] );
        return  $flag;
    }

    public function add($issueId, $info)
    {
        $info['issue_id'] = $issueId;
        return $this->insert($info);
    }
}
