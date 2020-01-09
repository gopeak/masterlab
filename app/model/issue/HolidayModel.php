<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  额外假日的模型
 */
class HolidayModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'holiday';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_holiday';

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
