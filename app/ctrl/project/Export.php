<?php
namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
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
        $projectId = $_GET['project'];

        $issueFilterLogic = new IssueFilterLogic();
        list($ret, $rows, $total) = $issueFilterLogic->getList(1, 59990);

        foreach ($rows as &$row) {
            IssueFilterLogic::formatIssue($row);
        }
        unset($row);

        if ($ret) {
            excelData($rows, array_keys($rows[0]), 'issue.xls', '事项清单');
            //excelData($rows, ['ID','事项','状态','报告人','创建时间'], 'issue.xls', '我的测试事项导出');
        }
    }
}