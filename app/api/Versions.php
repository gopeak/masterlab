<?php


namespace main\app\api;

use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;

class Versions extends BaseAuth
{
    /**
     * 项目版本接口
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
     * Restful GET , 获取项目版本列表 | 单个版本信息
     * 获取模块列表: {{API_URL}}/api/versions/v1/?project_id=1&access_token==xyz
     * 获取单个模块: {{API_URL}}/api/versions/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $versionId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (isset($_GET['_target'][3])){
            $versionId = intval($_GET['_target'][3]);
        }

        $final = [];
        $list = [];
        $row = [];

        $projectModel = new ProjectModel();
        $projectList = $projectModel->getAll2();

        $model = new ProjectVersionModel();

        if ($versionId > 0) {
            $row = $model->getById($versionId);
        } else {
            // 全部标签
            if ($projectId > 0) {
                $list = $model->getByProject($projectId, true);
            } else {
                $list = $model->getAll();
            }
        }

        if (!empty($list)) {
            foreach ($list as &$version) {
                $version['project_name'] = $projectList[$version['project_id']]['name'];
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
     * Restful POST 添加项目版本
     * {{API_URL}}/api/versions/v1/?project_id=1&access_token==xyz
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

        if (!isset($_POST['label_name'])) {
            return self::returnHandler('需要版本名.', [], Constants::HTTP_BAD_REQUEST);
        }
        $labelName = trim($_POST['label_name']);

        if (!isset($_POST['description'])) {
            $_POST['description'] = '';
        }

        $projectLabelModel = new ProjectLabelModel($uid);

        if ($projectLabelModel->checkNameExist($projectId, $labelName)) {
            return self::returnHandler('name is exist.', [], Constants::HTTP_BAD_REQUEST);
        }

        $row = [];
        $row['project_id'] = $projectId;
        $row['title'] = $labelName;
        $row['color'] = '#FFFFFF';
        $row['bg_color'] = '#428BCA';
        $row['description'] = $_POST['description'];

        $ret = $projectLabelModel->insert($row);

        if ($ret[0]) {
            return self::returnHandler('操作成功', ['id' => $ret[1]]);
        } else {
            return self::returnHandler('添加标签失败.', [], Constants::HTTP_BAD_REQUEST);
        }
    }

}