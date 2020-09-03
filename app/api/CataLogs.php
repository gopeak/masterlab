<?php


namespace main\app\api;


use Doctrine\DBAL\DBALException;
use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectModel;

class CataLogs extends BaseAuth
{
    /**
     * 项目的分类接口
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
     * Restful POST 添加分类
     * {{API_URL}}/api/cata_logs/v1/?project_id=1&access_token==xyz
     * @return array
     * @throws DBALException
     */
    private function postHandler()
    {
        $uid = $this->masterUid;
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            return self::returnHandler('项目id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $errorMsg = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (!isset($_POST['label_id_arr']) || empty($_POST['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }

        if (!isset($_POST['font_color']) || empty($_POST['font_color'])) {
            $_POST['font_color'] = 'blueviolet';
        }
        if (!empty($errorMsg)) {
            return self::returnHandler('参数错误', $errorMsg, Constants::HTTP_BAD_REQUEST);
        }
        $projectCatalogLabelModel = new ProjectCatalogLabelModel();

        if ($projectCatalogLabelModel->checkNameExist($projectId, $_POST['name'])) {
            return self::returnHandler('分类名称已存在', [], Constants::HTTP_BAD_REQUEST);
        }
        $insertArr = [];
        $insertArr['project_id'] = $projectId;
        $insertArr['name'] = $_POST['name'];
        $insertArr['font_color'] = $_POST['font_color'];
        $insertArr['label_id_json'] = json_encode($_POST['label_id_arr']);
        if (isset($_POST['description'])) {
            $insertArr['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $insertArr['order_weight'] = (int)$_POST['order_weight'];
        }

        list($ret, $errMsg) = $projectCatalogLabelModel->insert($insertArr);
        if ($ret) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->authAccount;
            $logData['real_name'] = $this->authAccount;
            $logData['obj_id'] = $errMsg;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '添加分类';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $insertArr;
            LogOperatingLogic::add($uid, $projectId, $logData);

            $insertArr['id'] = $errMsg;
            $event = new CommonPlacedEvent($this, $insertArr);
            $this->dispatcher->dispatch($event, Events::onCataloglCreate);

            return self::returnHandler('分类添加成功');
        } else {
            return self::returnHandler('服务器执行失败' . $errMsg, [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful GET , 获取项目分类列表 | 单个分类信息
     * 获取列表: {{API_URL}}/api/cata_logs/v1/?project_id=1&access_token==xyz
     * 获取单个: {{API_URL}}/api/cata_logs/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $cataLoglabelId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (isset($_GET['_target'][3])) {
            $cataLoglabelId = intval($_GET['_target'][3]);
        }

        $final = [];
        $list = [];
        $row = [];

        $projectModel = new ProjectModel();
        $projectList = $projectModel->getAll2();

        $model = new ProjectCatalogLabelModel();

        if ($cataLoglabelId > 0) {
            $row = $model->getById($cataLoglabelId);
        } else {
            // 全部分类
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
     * Restful PATCH ,更新分类
     * {{API_URL}}/api/cata_logs/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $cataLoglabelId = 0;

        if (isset($_GET['_target'][3])) {
            $cataLoglabelId = intval($_GET['_target'][3]);
        }
        if ($cataLoglabelId == 0) {
            return self::returnHandler('需要有分类ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $patch = self::_PATCH();
        $errorMsg = [];
        if (isset($patch['name']) && empty($patch['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (isset($patch['label_id_arr']) && empty($patch['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }
        if (!empty($errorMsg)) {
            return self::returnHandler('参数错误', $errorMsg, Constants::HTTP_BAD_REQUEST);
        }


        $updateArr = [];
        if (isset($patch['name'])) {
            $updateArr['name'] = $patch['name'];
        }
        if (isset($patch['label_id_arr'])) {
            $updateArr['label_id_json'] = json_encode($patch['label_id_arr']);
        }
        if (isset($patch['font_color'])) {
            $updateArr['font_color'] = $patch['font_color'];
        }
        if (isset($patch['description'])) {
            $updateArr['description'] = $patch['description'];
        }
        if (isset($patch['order_weight'])) {
            $updateArr['order_weight'] = (int)$patch['order_weight'];
        }

        $model = new ProjectCatalogLabelModel();
        $catalog = $model->getById($cataLoglabelId);
        if (empty($catalog)) {
            return self::returnHandler('参数错误, 数据为空', [], Constants::HTTP_BAD_REQUEST);
        }

        if ($catalog['name'] != $updateArr['name']) {
            if ($model->checkNameExist($catalog['project_id'], $updateArr['name'])) {
                return self::returnHandler('分类名已存在', [], Constants::HTTP_BAD_REQUEST);
            }
        }
        $ret = $model->updateById($cataLoglabelId, $updateArr);
        if ($ret[0]) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->authAccount;
            $logData['real_name'] = $this->authAccount;
            $logData['obj_id'] = $cataLoglabelId;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改分类';
            $logData['pre_data'] = $catalog;
            $logData['cur_data'] = $updateArr;
            LogOperatingLogic::add($uid, $catalog['project_id'], $logData);

            $updateArr['id'] = $cataLoglabelId;
            $event = new CommonPlacedEvent($this, $updateArr);
            $this->dispatcher->dispatch($event, Events::onCatalogUpdate);

            return self::returnHandler('分类修改成功', array_merge($updateArr, ['id' => $cataLoglabelId]));
        } else {
            return self::returnHandler('服务器执行失败', [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful DELETE ,删除某个项目分类
     * {{API_URL}}/api/cata_logs/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;
        $id = 0;
        $projectId = 0;

        if (isset($_GET['_target'][3])) {
            $id = intval($_GET['_target'][3]);
        }
        if ($id == 0) {
            return self::returnHandler('需要有分类ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $model = new ProjectCatalogLabelModel();
        $info = $model->getById($id);
        $model->deleteItem($id);

        $callFunc = function ($value) {
            return '已删除';
        };
        $info2 = array_map($callFunc, $info);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->authAccount;
        $logData['real_name'] = $this->authAccount;
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除分类';
        $logData['pre_data'] = $info;
        $logData['cur_data'] = $info2;
        LogOperatingLogic::add($uid, $info['project_id'], $logData);

        $event = new CommonPlacedEvent($this, $info);
        $this->dispatcher->dispatch($event, Events::onCatalogDelete);

        return self::returnHandler('操作成功');
    }
}
