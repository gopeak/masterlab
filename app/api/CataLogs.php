<?php


namespace main\app\api;


use Doctrine\DBAL\DBALException;
use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectCatalogLabelModel;

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
            $this->dispatcher->dispatch($event,  Events::onCataloglCreate);

            return self::returnHandler('分类添加成功');
        } else {
            return self::returnHandler('服务器执行失败' . $errMsg, [], Constants::HTTP_BAD_REQUEST);
        }
    }

    private function getHandler()
    {

    }

    private function patchHandler()
    {

    }

    private function deleteHandler()
    {

    }
}