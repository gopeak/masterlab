<?php


namespace main\app\classes;

use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;

class ProjectLogic
{
    const PROJECT_TYPE_GROUP_SOFTWARE = 1;
    const PROJECT_TYPE_GROUP_BUSINESS = 2;

    const PROJECT_TYPE_SCRUM = 10;
    const PROJECT_TYPE_KANBAN = 20;
    const PROJECT_TYPE_SOFTWARE_DEV = 30;
    const PROJECT_TYPE_PROJECT_MANAGE = 40;
    const PROJECT_TYPE_FLOW_MANAGE = 50;
    const PROJECT_TYPE_TASK_MANAGE = 60;

    static public $type_all = [
        self::PROJECT_TYPE_SCRUM,
        self::PROJECT_TYPE_KANBAN,
        self::PROJECT_TYPE_SOFTWARE_DEV,
        self::PROJECT_TYPE_PROJECT_MANAGE,
        self::PROJECT_TYPE_FLOW_MANAGE,
        self::PROJECT_TYPE_TASK_MANAGE,
    ];

    static public $typeAll = [
        self::PROJECT_TYPE_SCRUM => '敏捷开发',//'Scrum software development',
        self::PROJECT_TYPE_KANBAN => '看板开发',//'Kanban software development',
        self::PROJECT_TYPE_SOFTWARE_DEV => '软件开发',//'Basic software development',
        self::PROJECT_TYPE_PROJECT_MANAGE => '项目管理',
        self::PROJECT_TYPE_FLOW_MANAGE => '流程管理',
        self::PROJECT_TYPE_TASK_MANAGE => '任务管理',
    ];

    static public $software = [
        self::PROJECT_TYPE_SCRUM,
        self::PROJECT_TYPE_KANBAN,
        self::PROJECT_TYPE_SOFTWARE_DEV,
    ];

    static public $business = [
        self::PROJECT_TYPE_PROJECT_MANAGE,
        self::PROJECT_TYPE_FLOW_MANAGE,
        self::PROJECT_TYPE_TASK_MANAGE,
    ];

    /**
     * 项目相关页面的必要参数
     */
    const PROJECT_GET_PARAM_ID = 'project_id';
    const PROJECT_GET_PARAM_SECRET_KEY = 'skey';

    const PROJECT_CATEGORY_DEFAULT = 0;
    const PROJECT_URL_DEFAULT = '';
    const PROJECT_AVATAR_DEFAULT = 0;
    const PROJECT_DESCRIPTION_DEFAULT = '';

    /**
     * 默认项目事项类型方案ID为1
     */
    const PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID = 1;
    const PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID = 2;

    /**
     * 带图标的项目map
     */
    public static function faceMap()
    {
        $typeFace = array(
            self::PROJECT_TYPE_SCRUM => 'fa fa-github',
            self::PROJECT_TYPE_KANBAN => 'fa fa-bitbucket',
            self::PROJECT_TYPE_SOFTWARE_DEV => 'fa fa-gitlab',
            self::PROJECT_TYPE_PROJECT_MANAGE => 'fa fa-google',
            self::PROJECT_TYPE_FLOW_MANAGE => 'fa fa-gitlab',
            self::PROJECT_TYPE_TASK_MANAGE => 'fa fa-bug',
        );
        $fullType = self::$typeAll;
        array_walk($fullType, function (&$typeName, $typeId) use ($typeFace){
            $typeName = array(
                'type_name' => $typeName,
                'type_face' => $typeFace[$typeId]
            );
        });

        return $fullType;
    }


    public static function check()
    {
        if (isset($_REQUEST[self::PROJECT_GET_PARAM_ID]) && isset($_REQUEST[self::PROJECT_GET_PARAM_SECRET_KEY])) {
            $projectModel = new ProjectModel();
            $key = $projectModel->getKeyById($_REQUEST[self::PROJECT_GET_PARAM_ID]);
            if (sprintf("%u", crc32($key)) == $_REQUEST[self::PROJECT_GET_PARAM_SECRET_KEY]) {
                return true;
            }
        }
        return false;
    }

    public static function retModel($errorCode, $msg, $data = array())
    {
        return array('errorCode' => $errorCode, 'msg' => $msg, 'data' => $data);
    }

    public static function formatAvatar($avatar)
    {
        $avatarExist = true;
        if (strpos('?', $avatar) !== false) {
            list($avatar) = explode('?', $avatar);
        }
        if (file_exists(STORAGE_PATH . $avatar)) {
            $avatar= ATTACHMENT_URL.$avatar;
        }else{
            $avatarExist = false;
        }
        return [$avatar, $avatarExist];
    }

    public function selectFilter($search = null, $limit = null)
    {

        $model = new ProjectModel();
        $table = $model->getTable();

        $fields = " id,name ,`key` as username,avatar ";

        $sql = "Select {$fields} From {$table} Where 1 ";
        $params = [];
        if (!empty($search)) {
            $params['search'] = $search;
            $sql .= " AND  ( locate(:search,name)>0  )";
        }

        if (!empty($limit)) {
            $limit = intval($limit);
            $sql .= " limit $limit ";
        }
        //echo $sql;
        $rows = $model->db->getRows($sql, $params);
        unset($model);

        return $rows;
    }

    public function projectListJoinUser()
    {
        $model = new ProjectModel();
        $projectTable = $model->getTable();
        $userTable = 'user_main';

        $fields = " p.*, u_lead.username AS leader_username, u_lead.display_name AS leader_display,u_create.username AS create_username,u_create.display_name AS create_display ";

        $sql = "SELECT {$fields} FROM {$projectTable} p 
                LEFT JOIN {$userTable} u_lead ON p.lead=u_lead.uid 
                LEFT JOIN {$userTable} u_create ON p.create_uid=u_create.uid 
                ORDER BY p.id ASC";

        return $model->db->getRows($sql);
    }


    public function typeList($project_id)
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $sql = "SELECT * FROM (
SELECT pitsd.issue_type_scheme_id, pitsd.project_id, itsd.type_id from project_issue_type_scheme_data as pitsd 
JOIN issue_type_scheme_data as itsd ON pitsd.issue_type_scheme_id=itsd.scheme_id 
WHERE pitsd.project_id={$project_id}
) as sub JOIN issue_type as issuetype ON sub.type_id=issuetype.id";

        return $model->db->getRows($sql);

    }


}
