<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-8-28
 * Time: 15:11
 */

namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ReportProjectIssueModel;
use main\app\model\project\ReportSprintIssueModel;

/**
 * Class CrontabProject
 * @package main\app\classes
 */
class CrontabProject
{

    /**
     * 计算冗余的项目事项数
     * @throws \Exception
     */
    public function computeIssue()
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll(false);
        $ret = [];
        foreach ($projects as $project) {
            $projectId = (int)$project['id'];
            $info = [];
            $count = IssueFilterLogic::getCount($projectId);
            $info['closed_count'] = IssueFilterLogic::getClosedCount($projectId);
            $info['un_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
            $info['done_count'] = intval($count) - intval($info['un_done_count']);
            $ret[] = $projectModel->updateById($info, $projectId);
        }
        return $ret;
    }

    /**
     * 每天计算当前项目的数据
     * @return array
     * @throws \Exception
     */
    public function computeProjectDayReportIssue()
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll(false);
        $ret = [];
        $model = new ReportProjectIssueModel();
        $yesterday = strftime('%Y-%m-%d', strtotime("-1 day"));
        $yesterdayRow = $model->getRow('*', ['date' => $yesterday]);

        foreach ($projects as $project) {
            $projectId = (int)$project['id'];
            $row = [];
            $row['project_id'] = $projectId;
            $row['date'] = strftime('%Y-%m-%d', time());
            $row['week'] = date("w", time());
            $row['month'] = date("m", time());

            //$count = IssueFilterLogic::getCount($projectId);
            $row['count_done'] = IssueFilterLogic::getDoneCount($projectId);
            $row['count_no_done'] = IssueFilterLogic::getNoDoneCount($projectId);

            $row['count_done_by_resolve'] = IssueFilterLogic::getDoneCountByResolve($projectId);
            $row['count_no_done_by_resolve'] = IssueFilterLogic::getNoDoneCountByResolve($projectId);

            $yesterdayPoints = @intval($yesterdayRow['today_done_points']);
            $yesterdayDoneNumber = @intval($yesterdayRow['count_done']);
            $row['today_done_points'] = IssueFilterLogic::getDonePoints($projectId) - $yesterdayPoints;
            $row['today_done_number'] = $row['count_done'] - $yesterdayDoneNumber;
            $ret[] = $model->replace($row);
        }
        return $ret;
    }

    /**
     * 计算迭代的每天数据
     * @return array
     * @throws \Exception
     */
    public function computeSprintDayReportIssue()
    {
        $model = new SprintModel();
        $sprints = $model->getAll(false);
        $ret = [];
        $model = new ReportSprintIssueModel();
        $yesterday = strftime('%Y-%m-%d', strtotime("-1 day"));
        $yesterdayRow = $model->getRow('*', ['date' => $yesterday]);

        foreach ($sprints as $sprint) {
            $sprintId = (int)$sprint['id'];
            $row = [];
            $row['sprint_id'] = $sprintId;
            $row['date'] = strftime('%Y-%m-%d', time());
            $row['week'] = date("w", time());
            $row['month'] = date("m", time());

            //$count = IssueFilterLogic::getCount($projectId);
            $row['count_done'] = IssueFilterLogic::getSprintDoneCount($sprintId);
            $row['count_no_done'] = IssueFilterLogic::getSprintNoDoneCount($sprintId);

            $row['count_done_by_resolve'] = IssueFilterLogic::getSprintDoneCountByResolve($sprintId);
            $row['count_no_done_by_resolve'] = IssueFilterLogic::getSprintNoDoneCountByResolve($sprintId);

            $yesterdayPoints = @intval($yesterdayRow['today_done_points']);
            $yesterdayDoneNumber = @intval($yesterdayRow['count_done']);
            $row['today_done_points'] = IssueFilterLogic::getSprintDonePoints($sprintId) - $yesterdayPoints;
            $row['today_done_number'] = $row['count_done'] - $yesterdayDoneNumber;
            $ret[] = $model->replace($row);
        }
        return $ret;
    }
}