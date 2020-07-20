<?php


namespace main\app\api;


use main\app\classes\ProjectLogic;
use main\app\classes\ProjectModuleFilterLogic;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;

class Modules extends BaseAuth
{
    /**
     * @return array
     */
    public function v1()
    {
        if (in_array($this->requestMethod, self::$method_type)) {
            $handleFnc = $this->requestMethod . 'Handler';
            return $this->$handleFnc();
        }
        return self::returnHandler('api方法错误');
    }

    /**
     * Restful GET , 获取模块列表 | 单个模块信息
     * 获取模块列表: {{API_URL}}/api/modules/v1/?project_id=1&access_token==xyz
     * 获取单个模块: {{API_URL}}/api/modules/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $moduleId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (isset($_GET['_target'][3])){
            $moduleId = intval($_GET['_target'][3]);
        }

        $final = [];
        $list = [];
        $row = [];

        $projectModel = new ProjectModel();
        $projectList = $projectModel->getAll2();

        $model = new ProjectModuleModel();
        if ($projectId > 0) {
            $list = $model->getByProject($projectId, true);
        } else {
            if ($moduleId > 0) {
                $row = $model->getById($moduleId);
            } else {
                // 全部模块
                $list = $model->getAll();
            }
        }

        if (!empty($list)) {
            foreach ($list as &$module) {
                $module['project_name'] = $projectList[$module['project_id']]['name'];
            }
            $final = $list;
        }

        if (!empty($row)) {
            $row['project_name'] = $projectList[$row['project_id']]['name'];
            $final = $row;
        }

        return self::returnHandler('OK', $final);
    }

    /**
     * Restful POST 添加模块
     * {{API_URL}}/api/modules/v1/?project_id=1&access_token==xyz
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    private function postHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (!isset($_POST['module_name'])) {
            return self::returnHandler('需要模块名.', [], Constants::HTTP_BAD_REQUEST);
        }
        $moduleName = trim($_POST['module_name']);

        if (!isset($_POST['description'])) {
            $_POST['description'] = '';
        }

        $projectModuleModel = new ProjectModuleModel($uid);

        if ($projectModuleModel->checkNameExist($projectId, $moduleName)) {
            return self::returnHandler('name is exist.', [], Constants::HTTP_BAD_REQUEST);
        }

        $row = [];
        $row['project_id'] = $projectId;
        $row['name'] = $moduleName;
        $row['description'] = $_POST['description'];
        $row['lead'] = 0;
        $row['default_assignee'] = 0;
        $row['ctime'] = time();

        $ret = $projectModuleModel->insert($row);

        if ($ret[0]) {
            return self::returnHandler('操作成功');
        } else {
            return self::returnHandler('添加模块失败.', [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful DELETE ,删除某个项目模块
     * {{API_URL}}/api/modules/v1/36?access_token==xyz
     * @return array
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;
        $moduleId = 0;
        $projectId = 0;

        if (isset($_GET['_target'][3])) {
            $moduleId = intval($_GET['_target'][3]);
        }
        if ($moduleId == 0) {
            return self::returnHandler('需要有模块ID', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }
        if ($projectId == 0) {
            return self::returnHandler('需要有项目ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $projectModuleModel = new ProjectModuleModel();
        $projectModuleModel->removeById($projectId, $moduleId);

        return self::returnHandler('操作成功');
    }

    /**
     * Restful PATCH ,更新模块
     * {{API_URL}}/api/modules/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $moduleId = 0;
        $projectId = 0;

        if (isset($_GET['_target'][3])) {
            $moduleId = intval($_GET['_target'][3]);
        }
        if ($moduleId == 0) {
            return self::returnHandler('需要有模块ID', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }
        if ($projectId == 0) {
            return self::returnHandler('需要有项目ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $patch = self::_PATCH();

        $row = [];
        if (isset($patch['module_name']) && !empty($patch['module_name'])) {
            $row['name'] = $patch['module_name'];
        } else {
            return self::returnHandler('需要有模块名', [], Constants::HTTP_BAD_REQUEST);
        }


        if (isset($patch['description']) && !empty($patch['description'])) {
            $row['description'] = $patch['description'];
        }

        $projectModuleModel = new ProjectModuleModel();
        $ret = $projectModuleModel->updateById($moduleId, $row);

        return self::returnHandler('修改成功');

    }
}