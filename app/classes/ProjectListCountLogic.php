<?php


namespace main\app\classes;

use main\app\model\project\ProjectListCountModel;
use main\app\model\project\ProjectModel;

class ProjectListCountLogic
{
    /**
     * @param $type
     * @return bool
     * @throws \Exception
     */
    public function resetProjectTypeCount($type)
    {
        // 为了兼容mysql5.6和5.7，不采用分组批量操作

        if (!in_array($type, ProjectLogic::$type_all)) {
            return false;
        }

        $projectModel = new ProjectModel();
        $count = $projectModel->getCount(['type' => $type]);

        $projectListCountModel = new ProjectListCountModel();
        $projectListCountModel->update(['project_total' => $count], ['project_type_id' => $type]);

        return true;
    }
}
