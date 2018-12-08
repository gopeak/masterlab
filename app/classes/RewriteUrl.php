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
use main\app\model\user\UserModel;

/**
 * @todo 需要缓存处理,否则文件扫描目录很费资源
 * Class RewriteUrl
 * @package main\app\classes
 */
class RewriteUrl
{

    /**
     * 将url的参数解析,转发到 OrgRoute 控制器的 index 方法上
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
                    $pathParts = pathinfo($entry);
                    $array[$pathParts['filename']] = $entry;
                } else {
                    $pathParts = pathinfo($entry);
                    $array[$pathParts['filename']] = $entry;
                }
            }
        }
        $dirObject->close();
        return $array;
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
        $data['project'] = $project;
        $data['project_root_url'] = '/'.$project['org_path'] . '/' . $project['key'];
        $data['project_name'] = $project['name'];
        $data['data']['first_word'] = mb_substr(ucfirst($project['name']), 0, 1, 'utf-8');
        $data['data']['info'] = $project['description'];
        $data['bg_color'] = mapKeyColor($project['key']);

        $model = new UserModel();
        $leadDisplayName = $model->getFieldById('display_name', $project['lead']);
        $data['lead_display_name'] = $leadDisplayName;

        //$data['org_name'] = isset($_GET['_target'][0]) ? $_GET['_target'][0] : '';
        //$data['pro_key'] = isset($_GET['_target'][1]) ? $_GET['_target'][1] : '';
        $data['avatar'] = $project['avatar'];
        $data['org_name'] = $project['org_path'];
        $data['pro_key'] = $project['key'];

        return $data;
    }
}
