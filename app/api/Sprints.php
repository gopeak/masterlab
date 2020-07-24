<?php


namespace main\app\api;


use main\app\model\agile\SprintModel;

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
}