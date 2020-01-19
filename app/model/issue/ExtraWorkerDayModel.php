<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  额外工作日的模型
 */
class ExtraWorkerDayModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'extra_worker_day';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_extra_worker_day';

    /**
     * 获取项目的额外上班日
     * @param $projectId
     * @return array
     */
    public function getDays($projectId)
    {
        $conditions = ['project_id'=>$projectId];
        $rows =  $this->getRows('*',$conditions);
        $days = [];
        foreach ($rows as $row) {
            $days[] = $row['day'];
        }
        return $days;
    }

    /**
     * 删除项目的数据
     * @param $projectId
     * @return int
     */
    public function deleteByProject($projectId)
    {
        $conditions = ['project_id'=>$projectId];
        $ret =  $this->delete($conditions);
        return $ret;
    }

}
