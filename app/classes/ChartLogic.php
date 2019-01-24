<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ReportSprintIssueModel;

/**
 * Class ChartLogic
 * @package main\app\classes
 */
class ChartLogic
{
    /**
     * 获取某个迭代的汇总数据
     * @param $field
     * @param $sprintId
     * @return array
     */
    public static function getSprintReport($field, $sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = new ReportSprintIssueModel();
        $table = $model->getTable();
        $params = [];
        $params['sprint_id'] = $sprintId;
        $sql = "SELECT {$field} as label,{$table}.* FROM {$table} 
                          WHERE sprint_id =:sprint_id  ORDER BY {$field}  ASC";
        if ($field != 'date') {
            $sql = "SELECT 
                      {$field} as label,
                      sum(count_done) as count_done,
                      sum(count_no_done) as count_no_done,
                      sum(count_done_by_resolve) as count_done_by_resolve, 
                      sum(count_no_done_by_resolve) as count_no_done_by_resolve,
                      sum(today_done_points) as today_done_points,
                      sum(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE sprint_id =:sprint_id  GROUP BY {$field} ";
        }
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    /**
     * 获取两个时间的日期数组
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public static function getDatesBetweenTwoDays($startDate, $endDate)
    {
        $dates = [];
        if (strtotime($startDate) > strtotime($endDate)) {
            //如果开始日期大于结束日期，直接return 防止下面的循环出现死循环
            return $dates;
        } elseif ($startDate == $endDate) {
            //开始日期与结束日期是同一天时
            array_push($dates, $startDate);
            return $dates;
        } else {
            array_push($dates, $startDate);
            $currentDate = $startDate;
            do {
                $nextDate = date('Y-m-d', strtotime($currentDate . ' +1 days'));
                array_push($dates, $nextDate);
                $currentDate = $nextDate;
            } while ($endDate != $currentDate);
            return $dates;
        }
    }


    /**
     * 计算燃尽图
     * @param $sprintId
     * @return array
     */
    public static function computeSprintBurnDownLine($sprintId)
    {
        $colorArr = [
            'red' => 'rgb(255, 99, 132)',
            'orange' => 'rgb(255, 159, 64)',
            'yellow' => 'rgb(255, 205, 86)',
            'green' => 'rgb(75, 192, 192)',
            'blue' => 'rgb(54, 162, 235)',
            'purple' => 'rgb(153, 102, 255)',
            'grey' => 'rgb(201, 203, 207)'
        ];
        $lineConfig = [];

        $dataSetArr = [];
        $dataSetArr['type'] = 'line';
        $dataSetArr['label'] = '按状态';
        $dataSetArr['backgroundColor'] = $colorArr['red'];
        $dataSetArr['borderColor'] = $colorArr['red'];
        $dataSetArr['fill'] = false;
        $data = [];

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getById($sprintId);
        $sprintStartDate = $sprint['start_date'];
        $sprintStartDate = $sprint['end_date'];

        $field = 'date';
        $reportRows = self::getSprintReport($field, $sprintId);
        $planRows = self::getSprintPlanReport($sprintId);
        $sprintCount = IssueFilterLogic::getCountBySprint($sprintId);
        // 找出最小的起始时间
        $minReportDate = self::getMinDate($reportRows, 'label');
        $minPlanDate = self::getMinDate($planRows, 'due_date');
        $sprintStartTime = strtotime($sprintStartDate);
        $minReportTime = strtotime($minReportDate);
        $minPlanTime = strtotime($minPlanDate);
        $compareArr = [$sprintStartTime => $sprintStartDate, $minReportTime => $minReportDate, $minPlanTime => $minPlanDate];
        foreach ($compareArr as $t => $item) {
            if ($t < strtotime('-180 day')) {
                unset($compareArr[$t]);
            }
        }
        $minDate = $compareArr[min(array_keys($compareArr))];
        $last2WeekDate = date('Y-m-d', strtotime('-14 day'));
        $minDate = max($minDate, $last2WeekDate);
        $maxDate = max(date('Y-m-d'), $sprintStartDate);
        $maxDate = min($maxDate, date('Y-m-d', strtotime('+14 day')));
        // 按状态已经解决的数量
        $computeDateArr = self::getDatesBetweenTwoDays($minDate, $maxDate);
        $reportData = [];
        foreach ($reportRows as $item) {
            $reportData[$item['label']] = (int)$item['count_no_done'];
        }
        // 进行日期的补位
        $i = 0;
        //print_r($computeDateArr);
        foreach ($computeDateArr as $date) {
            $todayLastTime = strtotime(date('Y-m-d') . ' 23:59:59');
            if (strtotime($date . ' 00:00:01') > $todayLastTime) {

            } else {
                if (isset($reportData[$date])) {
                    $unDoneCount = $reportData[$date];
                } else {
                    $key = max(0, $i - 1);
                    if (isset($data[$key])) {
                        $unDoneCount = $data[$key];
                    } else {
                        $unDoneCount = $sprintCount;
                    }
                }
                $data[$i] = $unDoneCount;
            }
            $i++;
        }

        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $dataSetArr = [];
        $dataSetArr['type'] = 'line';
        $dataSetArr['label'] = '计划时间';
        $dataSetArr['backgroundColor'] = $colorArr['blue'];
        $dataSetArr['borderColor'] = $colorArr['blue'];
        $dataSetArr['fill'] = false;

        // 按日期获得计划时间
        $data = [];
        $planData = [];
        $sum = $sprintCount;
        foreach ($planRows as $k => &$item) {
            if ($item['due_date'] == '0000-00-00') {
                $endKey = count($planRows) - 1;
                $planRows[$endKey]['cc'] = $planRows[$endKey]['cc'] + $item['cc'];
                unset($planRows[$k]);
                break;
            }
        }
        //print_r($planRows);
        foreach ($planRows as $k => &$item) {
            $planData[$item['due_date']] = max(0, intval($sum - (int)$item['cc']));
            $sum = $sum - (int)$item['cc'];
        }
        //print_r($planData);
        reset($computeDateArr);
        // 进行日期的补位
        $i = 0;
        foreach ($computeDateArr as $date) {
            if (isset($planData[$date])) {
                $unDoneCount = $planData[$date];
            } else {
                $key = max(0, $i - 1);
                if (isset($data[$key])) {
                    $unDoneCount = $data[$key];
                } else {
                    $unDoneCount = $sprintCount;
                }
            }
            $data[$i] = $unDoneCount;
            $i++;
        }
        reset($data);
        $data = array_values($data);
        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $lineConfig['data']['labels'] = $computeDateArr;

        return $lineConfig;
    }

    /**
     * 找出最小的起始时间
     * @param $rows
     * @param $field
     * @return mixed
     */
    public static function getMinDate($rows, $field)
    {
        $dateArr = [];
        foreach ($rows as $row) {
            if ($row[$field] == '0000-00-00') {
                continue;
            }
            $time = strtotime($row[$field]);
            $dateArr[$time] = $row[$field];
        }
        $minTime = min(array_keys($dateArr));
        $minDate = $dateArr[$minTime];
        return $minDate;
    }

    /**
     * @param $sprintId
     * @return array
     */
    public static function getSprintPlanReport($sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $params = [];
        $params['sprint_id'] = $sprintId;
        $sql = "SELECT due_date, count(*) as cc FROM {$table}  WHERE `sprint` =:sprint_id  GROUP BY due_date ORDER BY due_date ASC ";
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }
}
