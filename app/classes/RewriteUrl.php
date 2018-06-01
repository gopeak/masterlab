<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 16:13
 */

namespace main\app\classes;

use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;

class RewriteUrl
{

    /**
     * @todo 需要缓存处理
     * @param $engine
     * @return array
     */
    public function orgRoute($engine)
    {
        $ctrl = $engine->ctrl;
        // var_dump($engine);
        if ($engine->enableSecurityMap) {
            $mapConfig = getCommonConfigVar('map');
            if (empty($engine->mod)) {
                if (!isset($mapConfig['ctrl'][$ctrl])) {
                    $originModel = new OrgModel();
                    $origins = $originModel->getPaths();
                    if (isset($origins[$ctrl])) {
                        return ['OrgRoute', '', 'index'];
                    }
                }
            }
        } else {
            $list = $this->readDir(APP_PATH . '/' . 'ctrl');
            if (!isset($list[$ctrl])) {
                $originModel = new OrgModel();
                $origins = $originModel->getPaths();
                if (isset($origins[$ctrl])) {
                    return ['OrgRoute', '', 'index'];
                }
            }
        }
    }

    /**
     * 读取目录下的所有控制器
     * @param $dir
     * @return array
     */
    public function readDir($dir)
    {
        $array = array();
        $dirObject = dir($dir);
        while (false !== ($entry = $dirObject->read())) {
            if ($entry != '.' && $entry != '..') {
                $entry = $dir . '/' . $entry;
                if (is_dir($entry)) {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                } else {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                }
            }
        }
        $dirObject->close();
        return $array;
    }

    /**
     * 获取项目url
     * @return string
     */
    public static function getProjectRootRoute()
    {
        $orgName = $_GET['_target'][0];
        $proKey = $_GET['_target'][1];
        return '/' . $orgName . '/' . $proKey;
    }

    /**
     * 获取项目信息
     * @param $data
     * @return mixed
     */
    public static function setProjectData($data)
    {
        $projectId = null;
        $data['project_id'] = $projectId;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        } else {
            return $data;
        }
        $data['project_id'] = $projectId;
        $model = new ProjectModel();
        $project = $model->getById($projectId);
        $data['project_root_url'] = self::getProjectRootRoute();
        $data['project_name'] = $project['name'];
        $data['data']['first_word'] = mb_substr(ucfirst($project['name']), 0, 1, 'utf-8');
        $data['data']['info'] = $project['description'];

        $data['org_name'] = $_GET['_target'][0];
        $data['pro_key'] = $_GET['_target'][1];
        return $data;
    }
}
