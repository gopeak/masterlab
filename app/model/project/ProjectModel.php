<?php
namespace main\app\model\project;

use main\app\classes\ProjectLogic;
use main\app\model\CacheModel;

/**
 *   项目模型
 */
class ProjectModel extends CacheModel
{
    public $prefix = 'project_';
    public $table = 'main';
    const   DATA_KEY = 'project_main/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function getAll($page=1, $page_size=20)
    {
        $total = $this->db->getOne($this->projectListSql("count(*) as cc"), array());
        $start = $page_size * ( $page - 1 );

        /*
        $sql = "SELECT p.*,u_lead.username AS leader_username, u_lead.display_name AS leader_display,u_create.username AS create_username,u_create.display_name AS create_display FROM project_main p 
LEFT JOIN user_main u_lead ON p.lead=u_lead.uid 
LEFT JOIN user_main u_create ON p.create_uid=u_create.uid 
ORDER BY p.id ASC LIMIT {$start}, ".$page_size;
        */

        $sql = $this->projectListSql("p.*,u_lead.username AS leader_username, u_lead.display_name AS leader_display,u_create.username AS create_username,u_create.display_name AS create_display");
        $sql .= " LIMIT {$start}, ".$page_size;
        $rows = $this->db->getRows( $sql );

        return array($rows ,$total);
    }

    function projectListSql($queryField = "*")
    {
        $sql = "SELECT {$queryField} FROM project_main p 
LEFT JOIN user_main u_lead ON p.lead=u_lead.uid 
LEFT JOIN user_main u_create ON p.create_uid=u_create.uid 
ORDER BY p.id ASC";

        return $sql;
    }

    /**
     * 获取所有项目类型的项目数量
     */
    public function getAllProjectTypeCount()
    {
        $sql = "
        select 
count(*) as WHOLE , 
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_SCRUM.") as SCRUM ,
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_KANBAN.") as KANBAN ,
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV.") as SOFTWARE_DEV ,
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE.") as PROJECT_MANAGE ,
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_FLOW_MANAGE.") as FLOW_MANAGE ,
(select count(*) from project_main where type=".ProjectLogic::PROJECT_TYPE_TASK_MANAGE.") as TASK_MANAGE 
from project_main
        ";
        return $this->db->getRow( $sql );
    }

    public function getFilter($page, $page_size)
    {
        $table = $this->prefix.$this->table;
        $params = array();

        $sqlCount = "SELECT count(id) as cc FROM {$table} ";
        $total = $this->db->getOne($sqlCount, $params);

        $start = $page_size * ( $page - 1 );
        $limit = wrapBlank("LIMIT {$start}, ".$page_size);
        $order = wrapBlank("ORDER BY id ASC");
        $where = wrapBlank("WHERE 1");
        $where .= $order . $limit;
        $sql = "SELECT * FROM ".$table.$where;
        $rows = $this->db->getRows($sql, $params, false);

        return array($rows ,$total);
    }

    public function addProject($projectInfo, $createUid=0)
    {
        if (empty($projectInfo)) {
            return ProjectLogic::retModel(-1, 'lose input data!');
        }

        if (!isset($projectInfo['name'])) {
            return ProjectLogic::retModel(-1, 'name field is required');
        }

        if (!isset($projectInfo['key'])) {
            return ProjectLogic::retModel(-1, 'key field is required');
        }

        if (!isset($projectInfo['type'])) {
            return ProjectLogic::retModel(-1, 'type field is required');
        }

        if (!in_array($projectInfo['type'], ProjectLogic::$type_all)) {
            return ProjectLogic::retModel(-1, 'type field is error');
        }

        $row = array(
            'name' => $projectInfo['name'],
            'url' => isset($projectInfo['url']) ? $projectInfo['url'] : ProjectLogic::PROJECT_URL_DEFAULT,
            'lead' => $projectInfo['lead'],
            'description' => isset($projectInfo['description']) ? $projectInfo['description'] : ProjectLogic::PROJECT_DESCRIPTION_DEFAULT,
            'key' => $projectInfo['key'],
            'pcounter' => 1,
            'default_assignee' => 1,
            'assignee_type' => 1,
            'avatar' => ProjectLogic::PROJECT_AVATAR_DEFAULT,
            'category' => ProjectLogic::PROJECT_CATEGORY_DEFAULT,
            'type' => $projectInfo['type'],
            'permission_scheme_id' => 0,
            'create_uid' => $createUid,
            'create_time' => time(),
        );

        $flag = $this->insert($row);

        if ($flag[0]) {
            $pid = $flag[1];
            // 使用默认的问题类型方案
            $sql = "SELECT * FROM issue_type_scheme_data WHERE scheme_id=".ProjectLogic::PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID;
            $rows = $this->db->getRows($sql, [], false);
            if($rows){
                foreach ($rows as $row){
                    $issueTypeSchemeIds[] = array('issue_type_scheme_id' => $row['id'], 'project_id' => $pid);
                }
                $projectIssueTypeSchemeDataModel = new ProjectIssueTypeSchemeDataModel();
                $projectIssueTypeSchemeDataModel->insertRows($issueTypeSchemeIds);
            }

            return ProjectLogic::retModel(0, 'success', array('project_id'=>$pid));
        } else {
            return ProjectLogic::retModel(-1, 'insert is error');
        }
    }

    public function updateById( $updateInfo, $projectId )
    {
        if(empty($updateInfo)) {
            throw new \Exception(__CLASS__ . __METHOD__ . '参数$updateInfo不能为空');
        }
        if(!is_array($updateInfo)) {
            throw new \Exception(__CLASS__ . __METHOD__ . '参数$updateInfo必须是数组');
        }
        if(!$projectId) {
            throw new \Exception(__CLASS__ . __METHOD__ . '参数$projectId不能为空');
        }
        $where = ['id'=>$projectId];
        $flag = $this->update( $updateInfo, $where );
        return 	$flag;
    }

    public function getKeyById($projectId)
    {
        $table = $this->getTable();
        $fields =   "`key`";

        $sql = "SELECT {$fields}  FROM {$table} Where id= {$projectId} ";
        $key = $this->db->getOne($sql);
        return $key;
    }

    public function getById($projectId)
    {
        $table = $this->getTable();
        $fields =   "*";

        $where = ['id' => $projectId];
        $row    =   $this->getRow($fields, $where);
        return $row;
    }

    public function getByKey($key)
    {
        $fields =   "*,{$this->primaryKey} as k";
        $where = ['key' => trim($key)];
        $row    =   $this->getRow($fields, $where);
        return  $row;
    }

    public function getByName($name)
    {
        $fields =   "*,{$this->primaryKey} as k";
        $where = ['name' => $name];
        $row    =   $this->getRow($fields, $where);
        return  $row;
    }

    public function getsByOrigin($originId)
    {
        $fields =   "*";
        $where = ['origin_id' => $originId];
        $row    =   $this->getRows($fields, $where);
        return  $row;
    }

    public function checkNameExist($name)
    {

        $fields =   "count(*) as cc";
        $where = ['name' => $name];
        $count  =   $this->getOne($fields, $where);
        return $count>0;
    }

    public function checkIdNameExist($id, $name)
    {
        $table = $this->getTable();
        $conditions['id'] = $id;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND name=:name  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count>0;
    }

    public function checkKeyExist($key)
    {

        $fields =   "count(*) as cc";
        $where = ['key' => $key];
        $count  =   $this->getOne($fields, $where);
        return $count>0;
    }

    public function checkIdKeyExist($id, $key)
    {
        $table = $this->getTable();
        $conditions['id'] = $id;
        $conditions['key'] = $key;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND `key`=:key  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count>0;
    }
}
