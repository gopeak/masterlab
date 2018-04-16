<?php


namespace main\app\classes;

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
     * 默认项目问题类型方案ID为1
     */
    const PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID = 1;
    const PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID = 2;

    static public function check()
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

    static public function retModel($errorCode, $msg, $data = array())
    {
        return array('errorCode' => $errorCode, 'msg' => $msg, 'data' => $data);
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


}