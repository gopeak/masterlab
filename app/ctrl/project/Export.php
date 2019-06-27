<?php
namespace main\app\ctrl\project;

use main\app\classes\AgileLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueLogic;
use main\app\classes\IssueStatusLogic;
use main\app\classes\IssueTypeLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;

/**
 * Class Export 数据导出excel控制器
 * @package main\app\ctrl\project
 */
class Export extends BaseUserCtrl
{

    /**
     * @throws \Exception
     */
    public function pageIssue()
    {
        $projectId = $_GET['project_id'];

        $projectMap = ProjectLogic::getAllProjectNameAndId();
        $userMap = UserLogic::getAllUserNameAndId('display_name');
        $issueTypeMap = IssueTypeLogic::getAllIssueTypeNameAndId();
        $issueResolveMap = IssueLogic::getAllIssueResolveNameAndId();
        $issuePriorityMap = IssueLogic::getAllIssuePriorityNameAndId();
        $issueStatusMap = IssueStatusLogic::getAllIssueStatusNameAndId();
        $projectModuleMap = ProjectLogic::getAllProjectModuleNameAndId($projectId);
        $projectSprintMap = (new AgileLogic())->getAllProjectSprintNameAndId($projectId);

        $issueFilterLogic = new IssueFilterLogic();
        list($ret, $rows, $total) = $issueFilterLogic->getList(1, 59990);

        foreach ($rows as &$row) {
            IssueFilterLogic::formatIssue($row);
            $row['ID'] = $row['id'];
            $row['事项#'] = $row['issue_num'];
            $row['主题'] = $row['summary'];
            $row['项目名'] = $projectMap[$row['project_id']];
            $row['报告人'] = $userMap[$row['reporter']];
            $row['经办人'] = $userMap[$row['assignee']];
            $row['事项类型'] = $issueTypeMap[$row['issue_type']];
            $row['模块'] = array_key_exists($row['module'], $projectModuleMap)?$projectModuleMap[$row['module']]:'无';
            $row['优先级'] = $issuePriorityMap[$row['priority']];
            $row['解决'] = array_key_exists($row['resolve'], $issueResolveMap)?$issueResolveMap[$row['resolve']]:'无';
            $row['状态'] = $issueStatusMap[$row['status']];
            $row['迭代'] = array_key_exists($row['sprint'], $projectSprintMap)?$projectSprintMap[$row['sprint']]:'无';
            $row['开始日期'] = $row['start_date'];
            $row['到期日期'] = $row['due_date'];
            $row['父任务'] = $row['master_id'] == 0?'无':$row['master_id'];
            $row['创建时间'] = date('Y-m-d H:i:s', $row['created']);
            $row['修改时间'] = date('Y-m-d H:i:s', $row['updated']);

            unset($row['id']);
            unset($row['issue_num']);
            unset($row['resolve']);
            unset($row['project_id']);
            unset($row['reporter']);
            unset($row['assignee']);
            unset($row['issue_type']);
            unset($row['summary']);
            unset($row['module']);
            unset($row['priority']);
            unset($row['status']);
            unset($row['created']);
            unset($row['updated']);
            unset($row['sprint']);
            unset($row['master_id']);
            unset($row['have_children']);
            unset($row['start_date']);
            unset($row['due_date']);
            unset($row['warning_delay']);
            unset($row['postponed']);
            unset($row['created_text']);
            unset($row['updated_text']);
        }
        unset($row);



        if ($ret) {
            excelData($rows, array_keys($rows[0]), 'issue.xls', '事项清单');
            //excelData($rows, ['ID','事项','状态','报告人','创建时间'], 'issue.xls', '我的测试事项导出');
        }
    }
}