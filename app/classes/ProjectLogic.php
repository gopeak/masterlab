<?php


namespace main\app\classes;

use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectListCountModel;
use main\app\model\project\ProjectMainExtra;
use main\app\model\project\ProjectMainExtraModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\project\ProjectUserRoleModel;

/**
 *
 * 项目逻辑类
 * @package main\app\classes
 */
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
        //self::PROJECT_TYPE_KANBAN => '看板开发',//'Kanban software development',
        self::PROJECT_TYPE_SOFTWARE_DEV => '软件开发',//'Basic software development',
        //self::PROJECT_TYPE_PROJECT_MANAGE => '项目管理',
        //self::PROJECT_TYPE_FLOW_MANAGE => '流程管理',
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
    const PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID = 1;         // 默认事项方案
    const PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID = 2;           // 敏捷开发事项方案
    const PROJECT_SOFTWARE_DEV_ISSUE_TYPE_SCHEME_ID = 3;    // 瀑布模型的事项方案
    const PROJECT_FLOW_MANAGE_ISSUE_TYPE_SCHEME_ID = 4;     // 流程管理事项方案
    const PROJECT_TASK_MANAGE_ISSUE_TYPE_SCHEME_ID = 5;     // 任务管理事项解决方案


    public static function getIssueTypeSchemeId($projectTypeId)
    {
        $projectTypeId = intval($projectTypeId);
        switch ($projectTypeId) {
            case self::PROJECT_TYPE_SCRUM:
                $schemeId = self::PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID;
                break;
            case self::PROJECT_TYPE_KANBAN:
                $schemeId = self::PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID;
                break;
            case self::PROJECT_TYPE_SOFTWARE_DEV:
                $schemeId = self::PROJECT_SOFTWARE_DEV_ISSUE_TYPE_SCHEME_ID;
                break;
            case self::PROJECT_TYPE_PROJECT_MANAGE:
                $schemeId = self::PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID;
                break;
            case self::PROJECT_TYPE_FLOW_MANAGE:
                $schemeId = self::PROJECT_FLOW_MANAGE_ISSUE_TYPE_SCHEME_ID;
                break;
            case self::PROJECT_TYPE_TASK_MANAGE:
                $schemeId = self::PROJECT_TASK_MANAGE_ISSUE_TYPE_SCHEME_ID;
                break;
            default:
                $schemeId = self::PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID;
        }

        return $schemeId;
    }

    /**
     * 带图标的项目map
     */
    public static function faceMap()
    {
        $typeFace = array(
            self::PROJECT_TYPE_SCRUM => 'fa fa-caret-right',
            self::PROJECT_TYPE_KANBAN => 'fa fa-bitbucket',
            self::PROJECT_TYPE_SOFTWARE_DEV => 'fa fa-caret-right',
            self::PROJECT_TYPE_PROJECT_MANAGE => 'fa fa-google',
            self::PROJECT_TYPE_FLOW_MANAGE => 'fa fa-gitlab',
            self::PROJECT_TYPE_TASK_MANAGE => 'fa fa-caret-right',
        );
        $typeDescription = array(
            self::PROJECT_TYPE_SCRUM => '搜集用户故事、规划迭代、进度管理、团队协作、用例管理、缺陷追踪、评审回顾、总结沉淀',
            self::PROJECT_TYPE_KANBAN => '用看板优化开发流程。',
            self::PROJECT_TYPE_SOFTWARE_DEV => '跟踪开发任务和bug。',
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
     * discard this function
     * @return bool
     * @throws \Exception
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
     * @param $projectInfo
     * @param int $createUid
     * @return array
     * @throws \Exception
     */
    public static function create($projectInfo, $createUid = 0)
    {
        if (empty($projectInfo)) {
            return self::retModel(-1, 'lose input data!');
        }

        if (!isset($projectInfo['name'])) {
            return self::retModel(-1, 'name field is required');
        }
        if (!isset($projectInfo['org_id'])) {
            return self::retModel(-1, 'org_id field is required');
        }
        if (!isset($projectInfo['org_path'])) {
            return self::retModel(-1, 'org_path field is required');
        }
        if (!isset($projectInfo['key'])) {
            return self::retModel(-1, 'key field is required');
        }

        if (!isset($projectInfo['type'])) {
            return self::retModel(-1, 'type field is required');
        }

        if (!in_array($projectInfo['type'], self::$type_all)) {
            return self::retModel(-1, 'type field is error');
        }

        $row = array(
            'org_id' => $projectInfo['org_id'],
            'org_path' => $projectInfo['org_path'],
            'name' => $projectInfo['name'],
            'url' => isset($projectInfo['url']) ? $projectInfo['url'] : self::PROJECT_URL_DEFAULT,
            'lead' => $projectInfo['lead'],
            'description' =>
                isset($projectInfo['description']) ? $projectInfo['description'] : self::PROJECT_DESCRIPTION_DEFAULT,
            'key' => $projectInfo['key'],
            'default_assignee' => 1,
            'avatar' => $projectInfo['avatar'],//self::PROJECT_AVATAR_DEFAULT,
            'category' => self::PROJECT_CATEGORY_DEFAULT,
            'type' => $projectInfo['type'],
            'type_child' => 0,
            'permission_scheme_id' => 0,
            'workflow_scheme_id' => 0,
            'create_uid' => $createUid,
            'create_time' => time(),
            //'detail' => $projectInfo['detail'],
        );

        $projectModel = new ProjectModel();
        $flag = $projectModel->insert($row);

        if ($flag[0]) {
            $pid = $flag[1];
            // 使用默认的事项类型方案

            $schemeId = self::getIssueTypeSchemeId($projectInfo['type']);
            $projectIssueTypeSchemeDataModel = new ProjectIssueTypeSchemeDataModel();
            $ret = $projectIssueTypeSchemeDataModel->insert(
                array('issue_type_scheme_id' => $schemeId, 'project_id' => $pid)
            );
            if (!$ret[0]) {
                return self::retModel(-1, 'insert is error.');
            }

            $projectListCountLogic = new ProjectListCountLogic();
            if (!$projectListCountLogic->resetProjectTypeCount($projectInfo['type'])) {
                return self::retModel(-1, 'resetProjectTypeCount is error..');
            }

            $projectMainExtra = new ProjectMainExtraModel();
            $ret = $projectMainExtra->insert(array('project_id' => $pid, 'detail' => $projectInfo['detail']));
            if (!$ret) {
                return self::retModel(-1, 'insert detail is error..');
            }

            return self::retModel(0, 'success', array('project_id' => $pid));
        } else {
            return self::retModel(-1, 'insert main project is error');
        }
    }

    /**
     * 获取所有项目类型的项目数量
     * @throws  \Exception
     */
    public static function getAllProjectTypeTotal()
    {
        $model = ProjectListCountModel::getInstance();
        $ret = $model->getRows();

        $final = array(
            'WHOLE' => 0,
            'SCRUM' => 0,
            'KANBAN' => 0,
            'SOFTWARE_DEV' => 0,
            'PROJECT_MANAGE' => 0,
            'FLOW_MANAGE' => 0,
            'TASK_MANAGE' => 0,
        );

        foreach ($ret as $item) {
            switch ($item['project_type_id']) {
                case self::PROJECT_TYPE_SCRUM:
                    $final['SCRUM'] = $item['project_total'];
                    break;
                case self::PROJECT_TYPE_KANBAN:
                    $final['KANBAN'] = $item['project_total'];
                    break;
                case self::PROJECT_TYPE_SOFTWARE_DEV:
                    $final['SOFTWARE_DEV'] = $item['project_total'];
                    break;
                case self::PROJECT_TYPE_PROJECT_MANAGE:
                    $final['PROJECT_MANAGE'] = $item['project_total'];
                    break;
                case self::PROJECT_TYPE_FLOW_MANAGE:
                    $final['FLOW_MANAGE'] = $item['project_total'];
                    break;
                case self::PROJECT_TYPE_TASK_MANAGE:
                    $final['TASK_MANAGE'] = $item['project_total'];
                    break;
            }
        }

        $final['WHOLE'] = array_sum($final);

        return $final;
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
        if (strpos($avatar, '?') !== false) {
            list($avatar) = explode('?', $avatar);
        }
        //var_dump(STORAGE_PATH .'attachment/'. $avatar);
        $file = STORAGE_PATH . 'attachment/' . $avatar;
        if (!is_dir($file) && file_exists($file)) {
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
     * @throws \Exception
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
     * @throws \Exception
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
     * 获取所有项目的简单信息
     * @return array
     */
    public function getAllShortProjects()
    {
        $model = new ProjectModel();
        $rows = $model->getAllByFields('id,org_id,org_path,name,url,`key`,avatar,create_time,un_done_count,done_count');
        return $rows;
    }

    /**
     * 项目类型的方案
     * @param $project_id
     * @return array
     * @throws \Exception
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
     * @return mixed
     */
    public static function formatProject($item)
    {
        $item['done_percent'] = 0;
        if (isset($item['un_done_count']) && isset($item['done_count'])) {
            $unDoneCount = intval($item['un_done_count']);
            $doneCount = intval($item['done_count']);
            $sumCount = intval($unDoneCount + $doneCount);
            if ($sumCount > 0) {
                $item['done_percent'] = floor(number_format($unDoneCount / $sumCount, 2) * 100);
            }
        }

        $types = self::$typeAll;
        $item['type_name'] = isset($types[$item['type']]) ? $types[$item['type']] : '';
        $item['path'] = empty($item['org_path']) ? 'default' : $item['org_path'];
        $item['create_time_text'] = format_unix_time($item['create_time'], time());
        $item['create_time_origin'] = '';
        if (intval($item['create_time']) > 100000) {
            $item['create_time_origin'] = format_unix_time($item['create_time'], time(), 'full_datetime_format');
        }
        $item['first_word'] = mb_substr(ucfirst($item['name']), 0, 1, 'utf-8');
        list($item['avatar'], $item['avatar_exist']) = self::formatAvatar($item['avatar']);
        return $item;
    }

    /**
     * 获取基本的项目字段
     * @param $project
     * @return array
     */
    public static function formatBasicProject($project)
    {
        $item = [];
        $item['id'] = $project['id'];
        $item['name'] = $project['name'];
        $item['path'] = empty($item['org_path']) ? 'default' : $item['org_path'];
        $item['key'] = $project['key'];
        $item['avatar'] = $project['avatar'];
        $item['avatar_exist'] = $project['avatar_exist'];
        $item['first_word'] = $project['first_word'];
        return $item;
    }

    /**
     * 新增项目后，将默认的项目角色导入到项目中
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
                        $info['id'] = $roleId;
                        $insertProjectRole[] = $info;
                        if (isset($defaultRoleRelationArr[$defaultRoleId])
                            && !empty($defaultRoleRelationArr[$defaultRoleId])
                        ) {
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

    /**
     * 创建项目,把项目负责人赋予该项目的Administrators权限
     * @param $projectId
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public static function assignAdminRoleForProjectLeader($projectId, $userId)
    {
        $projectRoleModel = new ProjectRoleModel();
        $projectAdminRoleId = $projectRoleModel->getProjectRoleIdByProjectIdRoleName($projectId, 'Administrators');
        $projectUserRoleModel = new ProjectUserRoleModel();

        list($ret, $msg) = $projectUserRoleModel->insertRole($userId, $projectId, $projectAdminRoleId);
        if (!$ret) {
            return [false, $msg];
        }

        return [true, $msg];
    }

    /**
     * 获取所有项目的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @return array
     * @throws \Exception
     */
    public static function getAllProjectNameAndId()
    {
        $projectModel = new ProjectModel();
        $originalRes = $projectModel->getAll(false, 'id,name');
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }

    /**
     * 获取某项目下所有模块的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function getAllProjectModuleNameAndId($projectId)
    {
        $model = new ProjectModuleModel();
        $originalRes = $model->getByProject($projectId, false);
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }

}
