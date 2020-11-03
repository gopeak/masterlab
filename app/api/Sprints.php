<?php


namespace main\app\api;


use main\app\classes\AgileLogic;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;

class Sprints extends BaseAuth
{
    /**
     * 项目迭代接口
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
     * 激活迭代
     * @return array
     * @throws \Exception
     */
    private function setSprintActive()
    {
        if ($this->requestMethod == 'patch') {
            $sprintId = 0;

            if (isset($_GET['_target'][3])) {
                $sprintId = intval($_GET['_target'][3]);
            }
            if ($sprintId == 0) {
                return self::returnHandler('需要有迭代ID', [], Constants::HTTP_BAD_REQUEST);
            }

            $sprintModel = new SprintModel();
            $sprint = $sprintModel->getItemById($sprintId);
            if (empty($sprint)) {
                return self::returnHandler('迭代数据错误.', [], Constants::HTTP_BAD_REQUEST);
            }

            if (!isset($sprint['id'])) {
                return self::returnHandler('迭代数据不存在.', [], Constants::HTTP_BAD_REQUEST);
            }
            $updateArr = ['active' => '0'];
            $conditionArr = ['project_id' => $sprint['project_id']];
            //var_dump($updateArr, $conditionArr);
            $sprintModel->update($updateArr, $conditionArr);
            $sprintModel->updateById($sprintId, ['active' => '1']);

            return self::returnHandler('修改成功.', ['id' => $sprintId]);
        }

        return self::returnHandler('api方法错误.');
    }

    /**
     * Restful POST 添加项目迭代
     * {{API_URL}}/api/sprints/v1/?project_id=1&access_token==xyz
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

        if (!isset($_POST['name'])) {
            return self::returnHandler('需要迭代名.', [], Constants::HTTP_BAD_REQUEST);
        }
        $sprintName = trim($_POST['name']);

        if (!isset($_POST['description'])) {
            $_POST['description'] = '';
        }

        $model = new SprintModel();
        $activeSprint = $model->getActive($projectId);

        $row = [];
        $row['project_id'] = $projectId;
        $row['name'] = $sprintName;
        $row['active'] = '0';
        if (!isset($activeSprint['id'])) {
            $row['active'] = '1';
        }
        if (isset($_POST['description'])) {
            $row['description'] = $_POST['description'];
        }

        if (isset($_POST['start_date']) && !empty($_POST['start_date']) && is_datetime_format($_POST['start_date'])) {
            $row['start_date'] = $_POST['start_date'];
        }

        if (isset($_POST['end_date']) && !empty($_POST['end_date']) && is_datetime_format($_POST['end_date'])) {
            $row['end_date'] = $_POST['end_date'];
        }

        $sprintModel = new SprintModel();
        $ret = $sprintModel->insertItem($row);

        if ($ret[0]) {
            return self::returnHandler('操作成功', ['id' => $ret[1]]);
        } else {
            return self::returnHandler('添加迭代失败.', [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful GET , 获取迭代列表 | 单个迭代信息
     * 获取迭代列表: {{API_URL}}/api/sprints/v1/?project_id=1&access_token==xyz
     * 获取单个迭代: {{API_URL}}/api/sprints/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $sprintId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (isset($_GET['_target'][3])) {
            $sprintId = intval($_GET['_target'][3]);
        }

        $final = [];
        $list = [];
        $row = [];

        $projectModel = new ProjectModel();
        $projectList = $projectModel->getAll2();


        $model = new SprintModel();

        if ($sprintId > 0) {
            $row = $model->getById($sprintId);
        } else {
            // 全部模块
            if ($projectId > 0) {
                $list = $model->getItemsByProject($projectId);
            } else {
                $list = $model->getAll();
            }
        }

        if (!empty($list)) {
            foreach ($list as &$item) {
                $item['project_name'] = $projectList[$item['project_id']]['name'];
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
     * Restful PATCH ,更新迭代
     * {{API_URL}}/api/sprints/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $sprintId = 0;

        if (isset($_GET['_target'][3])) {
            $sprintId = intval($_GET['_target'][3]);
        }
        if ($sprintId == 0) {
            return self::returnHandler('需要有迭代ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            return self::returnHandler('迭代数据错误.', [], Constants::HTTP_BAD_REQUEST);
        }

        $patch = self::_PATCH();

        $row = [];
        if (isset($patch['name']) && !empty($patch['name'])) {
            $row['name'] = $patch['name'];
        } else {
            return self::returnHandler('需要有迭代名', [], Constants::HTTP_BAD_REQUEST);
        }

        if (isset($patch['description']) && !empty($patch['description'])) {
            $row['description'] = $patch['description'];
        }

        if (isset($patch['start_date'])) {
            $row['start_date'] = $patch['start_date'];
        }
        if (isset($_POST['start_date'])) {
            $row['end_date'] = $patch['end_date'];
        }
        if (isset($_POST['params']['status'])) {
            $row['status'] = (int)$patch['status'];
        }

        $changed = false;
        foreach ($row as $key => $value) {
            if ($sprint[$key] != $value) {
                $changed = true;
            }
        }
        if ($changed) {
            list($ret, $msg) = $sprintModel->updateItem($sprintId, $row);
            return self::returnHandler('修改成功', array_merge($row, ['id' => $sprintId]));
        }

        return self::returnHandler('修改成功.', array_merge($row, ['id' => $sprintId]));
    }


    /**
     * Restful DELETE ,删除某个迭代
     * {{API_URL}}/api/sprints/v1/36?access_token==xyz
     * @return array
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;
        $sprintId = 0;

        if (isset($_GET['_target'][3])) {
            $sprintId = intval($_GET['_target'][3]);
        }
        if ($sprintId == 0) {
            return self::returnHandler('需要有迭代ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            return self::returnHandler('迭代数据错误.', [], Constants::HTTP_BAD_REQUEST);
        }

        $ret = $sprintModel->deleteItem($sprintId);
        if ($ret) {
            $issueModel = new IssueModel();
            $updateInfo = ['sprint' => AgileLogic::BACKLOG_VALUE, 'backlog_weight' => 0];
            $condition = ['sprint' => $sprintId];
            $issueModel->update($updateInfo, $condition);
        }

        return self::returnHandler('操作成功');
    }
}
