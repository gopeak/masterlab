<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-8-28
 * Time: 15:11
 */

namespace main\app\classes;

use main\app\model\project\ProjectModel;

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
}