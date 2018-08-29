<?php


namespace main\app\classes;

use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectRoleRelationModel;

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
        $typeDescription = array(
            self::PROJECT_TYPE_SCRUM => 'Agile development with a board, sprints and stories. Connects with source and build tools.',
            self::PROJECT_TYPE_KANBAN => 'Optimise development flow with a board. Connects with source and build tools.',
            self::PROJECT_TYPE_SOFTWARE_DEV => 'Track development tasks and bugs. Connects with source and build tools.',
            self::PROJECT_TYPE_PROJECT_MANAGE => '对你在一个项目中的工作进行计划、追踪与报告。',
            self::PROJECT_TYPE_FLOW_MANAGE => '对经过一个线形流程的所有工作进行追踪。',
            self::PROJECT_TYPE_TASK_MANAGE => '快速整理和分派简单任务给你或你的团队。',
        );

        $fullType = self::$typeAll;

        array_walk($fullType, function (&$typeName, $typeId) use ($typeFace, $typeDescription) {
            $typeName = array(
                'type_name' => $typeName,
                'type_face' => $typeFace[$typeId],
                'type_desc' => $typeDescription[$typeId],
            );
        });

        return $fullType;
    }


    /**
     * @return bool
     */
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

    /**
     * @param $errorCode
     * @param $msg
     * @param array $data
     * @return array
     */
    public static function retModel($errorCode, $msg, $data = array())
    {
        return array('errorCode' => $errorCode, 'msg' => $msg, 'data' => $data);
    }

    /**
     * 格式化项目图标地址
     * @param $avatar
     * @return array
     */
    public static function formatAvatar($avatar)
    {
        $avatarExist = true;
        /*
        if (strpos('?', $avatar) !== false) {
            list($avatar) = explode('?', $avatar);
        }*/
        if (file_exists(STORAGE_PATH . $avatar)) {
            $avatar = ATTACHMENT_URL . $avatar;
        } else {
            $avatarExist = false;
        }
        return [$avatar, $avatarExist];
    }

    /**
     * 下拉菜单选择项目的查询接口
     * @param null $search
     * @param null $limit
     * @return array
     */
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

    /**
     * 项目左连接用户表
     * @return array
     */
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


    /**
     * 项目类型的方案
     * @param $project_id
     * @return array
     */
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

    /**
     * 格式化项目项的内容
     * @param array $item
     * @param array $originsMap 组织信息,用于构建项目的访问地址
     * @return mixed
     */
    public static function formatProject($item, $originsMap)
    {
        $unDoneCount = intval($item['un_done_count']);
        $doneCount = intval($item['done_count']);
        $sumCount = intval($unDoneCount + $doneCount);
        $item['done_percent'] = 0;
        if ($sumCount > 0) {
            $item['done_percent'] = floor(number_format($unDoneCount / $sumCount, 2) * 100);
        }
        $types = self::$typeAll;
        $item['type_name'] = isset($types[$item['type']]) ? $types[$item['type']] : '';
        $item['path'] = isset($originsMap[$item['org_id']]) ? $originsMap[$item['org_id']] : 'default';
        $item['create_time_text'] = format_unix_time($item['create_time'], time());
        $item['create_time_origin'] = '';
        if (intval($item['create_time']) > 100000) {
            $item['create_time_origin'] = date('y-m-d H:i:s', intval($item['create_time']));
        }
        $item['first_word'] = mb_substr(ucfirst($item['name']), 0, 1, 'utf-8');
        list($item['avatar'], $item['avatar_exist']) = self::formatAvatar($item['avatar']);
        return $item;
    }

    /**
     * 新增项目后，将默认的项目觉得导入到项目中
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function initRole($projectId)
    {
        $insertProjectRole = [];
        try {
            $projectRoleModel = new ProjectRoleModel();
            $haveRoleArr = $projectRoleModel->getsByProject($projectId);
            $haveRoleNameArr = [];
            foreach ($haveRoleArr as $item) {
                $haveRoleNameArr[] = $item['name'];
            }
            unset($haveRoleArr);

            $defaultRoleRelationModel = new DefaultRoleRelationModel();
            $defaultRoleRelation = $defaultRoleRelationModel->getAll(false);
            $defaultRoleRelationArr = [];
            foreach ($defaultRoleRelation as $item) {
                $defaultRoleRelationArr[$item['default_role_id']][] = $item;
            }
            //print_r($defaultRoleRelationArr);
            unset($defaultRoleRelation);

            $defaultRoleModel = new DefaultRoleModel();
            $projectRoleRelationModel = new ProjectRoleRelationModel();
            $defaultRoleArr = $defaultRoleModel->getAll(false);

            foreach ($defaultRoleArr as $role) {
                if (!in_array($role['name'], $haveRoleNameArr)) {
                    $defaultRoleId = $role['id'];
                    $info = [];
                    $info['is_system'] = '1';
                    $info['project_id'] = $projectId;
                    $info['name'] = $role['name'];
                    $info['description'] = $role['description'];
                    list($ret, $insertId) = $projectRoleModel->insert($info);
                    if ($ret) {
                        $roleId = $insertId;
                        $insertProjectRole[] = $info;
                        if (isset($defaultRoleRelationArr[$defaultRoleId]) && !empty($defaultRoleRelationArr[$defaultRoleId])) {
                            foreach ($defaultRoleRelationArr[$defaultRoleId] as $relation) {
                                $info = [];
                                $info['project_id'] = $projectId;
                                $info['role_id'] = $roleId;
                                $info['perm_id'] = $relation['perm_id'];
                                $projectRoleRelationModel->insert($info);
                            }
                        }
                    }
                }
            }
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }

        return [true, $insertProjectRole];
    }
}
