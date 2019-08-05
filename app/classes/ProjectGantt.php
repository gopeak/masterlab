<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\field\FieldCustomValueModel;
use main\app\model\field\FieldModel;
use main\app\model\issue\IssueAssistantsModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueEffectVersionModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueDescriptionTemplateModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\project\ProjectModel;
use main\app\model\TimelineModel;
use main\app\model\user\UserIssueDisplayFieldsModel;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


/**
 * 事项逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class ProjectGantt
{

    public function getGanttIssue($projectId)
    {
        $projectId = (int)$projectId;
        $issueModel = new IssueModel();
        $sql = "select * from {$issueModel->getTable()} where project_id={$projectId}  order by  master_id asc,level asc ,start_date asc";
        //echo $sql;
        $rows = $issueModel->db->getRows($sql);

        $arr = [];
        foreach ($rows as $k => $row) {
            $item = [];
            $item['id'] = $row['id'];
            $item['level'] = (int)$row['level'];
            $item['code'] = $row['issue_num'];
            $item['name'] = $row['summary'];
            $item['progress'] = (int)$row['progress'];
            $item['progressByWorklog'] = false;
            $item['relevance'] = (int)$row['weight'];
            $item['type'] = $row['issue_type'];
            $item['typeId'] = $row['issue_type'];
            $item['description'] = $row['description'];
            $item['status'] = $row['status'];
            $item['depends'] = $row['depends'];
            $item['canWrite'] = true;
            $item['start'] = strtotime($row['start_date']);
            $item['duration'] = $row['duration'];
            $item['end'] = strtotime($row['due_date']);
            $item['startIsMilestone'] = false;
            $item['endIsMilestone'] = false;
            $item['collapsed'] = false;
            $item['assigs'] = explode(',', $row['assistants']);
            $item['hasChild'] = (bool)$row['have_children'];
            $item['master_id'] = $row['master_id'];
            $arr [] = $item;
        }

        return $arr;
    }


    public function batchUpdateGanttLevel()
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where master_id=0 AND have_children!=0";
        $level1Rows = $issueModel->db->getRows($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }

        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $sql = "update  {$issueModel->getTable()} set level=1 where id in( $idArrStr)";
            $issueModel->db->query($sql);
        }
        $this->batchUpdateGanttLevel2(1);
        $this->batchUpdateGanttLevel2(2);
        $this->batchUpdateGanttLevel2(3);
    }

    public function batchUpdateGanttLevel2($level)
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where  level={$level} AND have_children!=0";
        $level1Rows = $issueModel->db->getRows($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }
        print_r($idArr);
        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $newLevel = $level + 1;
            $sql = "update  {$issueModel->getTable()} set level={$newLevel} where master_id in( $idArrStr)";
            $issueModel->db->query($sql);
        }
    }
}
