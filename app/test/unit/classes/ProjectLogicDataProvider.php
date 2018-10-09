<?php

namespace main\app\test\unit\classes;

use main\app\ctrl\project\Base;
use main\app\model\project\ProjectModel;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;


class ProjectLogicDataProvider
{
    public static $insertProjectIdArr = [];

    public static $insertVersionIdArr = [];

    public static $insertModuleIdArr = [];

    /**
     * 生成一条项目记录及3条对应的版本记录和3条模块记录
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initProjectWithVersionAndModule($info = [])
    {
        $rowProject = BaseDataProvider::createProject($info);
        self::$insertProjectIdArr[] = $rowProject['id'];
        for ($i = 0; $i < 3; $i++) {
            $rowVersion = BaseDataProvider::createProjectVersion(array('project_id' => $rowProject['id']));
            self::$insertVersionIdArr[] = $rowVersion['id'];
            $rowModule= BaseDataProvider::createProjectModule(array('project_id' => $rowProject['id']));
            self::$insertModuleIdArr[] = $rowModule['id'];
        }

        return $rowProject;
    }

    /**
     * 清除项目记录
     */
    public static function clearProject()
    {
        if (!empty(self::$insertProjectIdArr)) {
            $model = new ProjectModel();
            foreach (self::$insertProjectIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 清除项目版本记录
     */
    public static function clearVersion()
    {
        if (!empty(self::$insertVersionIdArr)) {
            $model = new ProjectVersionModel();
            foreach (self::$insertVersionIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 清除模块记录
     */
    public static function clearModule()
    {
        if (!empty(self::$insertModuleIdArr)) {
            $model = new ProjectModuleModel();
            foreach (self::$insertModuleIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clear()
    {
        self::clearProject();
        self::clearVersion();
        self::clearModule();
    }
}
