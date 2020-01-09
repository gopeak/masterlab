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

    public function getDays()
    {
        $rows =  $this->getRows();
        $days = [];
        foreach ($rows as $row) {
            $days[] = $row['day'];
        }
        return $days;
    }

}
