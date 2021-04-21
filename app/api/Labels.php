<?php


namespace main\app\api;


use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\SettingModel;

class Labels extends BaseAuth
{
    public $isTriggerEvent = false;

    /**
     * 项目标签接口
     * @return array
     */
    public function v1()
    {
        if (in_array($this->requestMethod, self::$method_type)) {
            $handleFnc = $this->requestMethod . 'Handler';
            return $this->$handleFnc();
        }
        $this->isTriggerEvent = (bool)SettingModel::getInstance()->getSettingValue('api_trigger_event');
        return self::returnHandler('api方法错误');
    }

    /**
     * Restful GET , 获取标签列表 | 单个标签信息
     * 获取列表: {{API_URL}}/api/labels/v1/?project_id=1&access_token==xyz
     * 获取单个: {{API_URL}}/api/labels/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $labelId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (isset($_GET['_target'][3])) {
            $labelId = intval($_GET['_target'][3]);
        }

        $final = [];
        $list = [];
        $row = [];

        $projectModel = new ProjectModel();
        $projectList = $projectModel->getAll2();

        $model = new ProjectLabelModel();

        if ($labelId > 0) {
            $row = $model->getById($labelId);
        } else {
            // 全部标签
            if ($projectId > 0) {
                $list = $model->getByProject($projectId, true);
            } else {
                $list = $model->getAll();
            }
        }

        if (!empty($list)) {
            foreach ($list as &$label) {
                $label['project_name'] = $projectList[$label['project_id']]['name'];
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
     * Restful POST 添加标签
     * {{API_URL}}/api/labels/v1/?project_id=1&access_token==xyz
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
            return self::returnHandler('需要标签名.', [], Constants::HTTP_BAD_REQUEST);
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

    /**
     * Restful DELETE ,删除某个项目标签
     * {{API_URL}}/api/labels/v1/36?access_token==xyz
     * @return array
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;
        $labelId = 0;
        $projectId = 0;

        if (isset($_GET['_target'][3])) {
            $labelId = intval($_GET['_target'][3]);
        }
        if ($labelId == 0) {
            return self::returnHandler('需要有标签ID', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }
        if ($projectId == 0) {
            return self::returnHandler('需要有项目ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $projectLabelModel = new ProjectLabelModel();
        $projectLabelModel->removeById($projectId, $labelId);

        return self::returnHandler('操作成功');
    }

    /**
     * Restful PATCH ,更新标签
     * {{API_URL}}/api/labels/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $labelId = 0;
        $projectId = 0;

        if (isset($_GET['_target'][3])) {
            $labelId = intval($_GET['_target'][3]);
        }
        if ($labelId == 0) {
            return self::returnHandler('需要有标签ID', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }
        if ($projectId == 0) {
            return self::returnHandler('需要有项目ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $patch = self::_PATCH();

        $row = [];
        if (isset($patch['label_name']) && !empty($patch['label_name'])) {
            $row['title'] = $patch['label_name'];
        } else {
            return self::returnHandler('需要有模块名', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($patch['description']) && !empty($patch['description'])) {
            $row['description'] = $patch['description'];
        }

        $projectLabelModel = new ProjectLabelModel();
        $ret = $projectLabelModel->updateById($labelId, $row);

        return self::returnHandler('修改成功', array_merge($row, ['id' => $labelId]));
    }
}