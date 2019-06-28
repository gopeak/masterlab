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
        $headerMap = [
            'summary' => '标题', 'project_id' => '项目', 'issue_num' => '编号', 'issue_type' => '事项类型',
            'module' => '模块', 'sprint' => '迭代', 'weight' => '权重值', 'description' => '描述',
            'priority' => '优先级', 'status' => '状态', 'resolve' => '解决结果', 'environment' => '运行环境',
            'reporter' => '报告人', 'assignee' => '经办人', 'assistants' => '协助人', 'modifier' => '最后修改人',
            'master_id' => '是否父任务', 'created' => '创建时间', 'updated' => '修改时间', 'start_date' => '计划开始日期',
            'due_date' => '计划结束日期', 'resolve_date' => '实际解决日期',
        ];


        if (!isset($_GET['cur_project_id'])
            || !is_numeric($_GET['cur_project_id'])
            || $_GET['cur_project_id']<=0) {
            exit;
        }
        $projectId = $_GET['cur_project_id'];

        $curPage = 1;
        $pageSize = 59990;
        if (isset($_GET['radio-export_range'])) {
            switch ($_GET['radio-export_range']) {
                case 'current_page':
                    $curPage = isset($_GET['cur_page'])?intval($_GET['cur_page']):1;
                    $pageSize = 20;
                    break;
                case 'all_page':
                    $curPage = 1;
                    $pageSize = 59990;
                    break;
                case 'project_all':
                    $curPage = 1;
                    $pageSize = 59990;
                    break;
            }
        }

        // $issueFilterLogic->getList 接收到的GET参数需要urlencode
        foreach ($_GET as $key => $get) {
            if (!is_array($get)) {
                if (is_string($get) || is_string($key)) {
                    $_GET[(string)urlencode($key)] = (string)urlencode($get);
                }
            }
        }

        if (!isset($_GET['field_format_project_id']) || !in_array($_GET['field_format_project_id'], ['title', 'id'])) {
            $_GET['field_format_project_id'] = 'title';
        }

        if (!isset($_GET['field_format_module']) || !in_array($_GET['field_format_module'], ['title', 'id'])) {
            $_GET['field_format_module'] = 'title';
        }
        if (!isset($_GET['field_format_sprint']) || !in_array($_GET['field_format_sprint'], ['title', 'id'])) {
            $_GET['field_format_sprint'] = 'title';
        }

        if (!isset($_GET['field_format_reporter'])
            || !in_array($_GET['field_format_reporter'], ['display_name', 'username', 'avatar', 'avatar_url'])) {
            $_GET['field_format_reporter'] = 'display_name';
        }

        if (!isset($_GET['field_format_assignee'])
            || !in_array($_GET['field_format_assignee'], ['display_name', 'username', 'avatar', 'avatar_url'])) {
            $_GET['field_format_assignee'] = 'display_name';
        }

        if (!isset($_GET['field_format_assistants'])
            || !in_array($_GET['field_format_assistants'], ['display_name', 'username', 'avatar', 'avatar_url'])) {
            $_GET['field_format_assistants'] = 'display_name';
        }

        if (!isset($_GET['field_format_modifier'])
            || !in_array($_GET['field_format_modifier'], ['display_name', 'username', 'avatar', 'avatar_url'])) {
            $_GET['field_format_modifier'] = 'display_name';
        }


        $projectMap = ProjectLogic::getAllProjectNameAndId();
        list($usernameMap, $displayNameMap, $avatarMap) = UserLogic::getAllUserNameAndId();
        $issueTypeMap = IssueTypeLogic::getAllIssueTypeNameAndId();
        $issueResolveMap = IssueLogic::getAllIssueResolveNameAndId();
        $issuePriorityMap = IssueLogic::getAllIssuePriorityNameAndId();
        $issueStatusMap = IssueStatusLogic::getAllIssueStatusNameAndId();
        $projectModuleMap = ProjectLogic::getAllProjectModuleNameAndId($projectId);
        $projectSprintMap = (new AgileLogic())->getAllProjectSprintNameAndId($projectId);

        $issueFilterLogic = new IssueFilterLogic();
        $_GET['project'] = $projectId;
        list($ret, $rows, $total) = $issueFilterLogic->getList($curPage, $pageSize);

        //dump($_GET, true);exit;

        if (empty($_GET['export_fields']) || !isset($_GET['export_fields'])) {
            exit;
        }

        $exportFieldsArr = $_GET['export_fields'];

        $final = [];

        if (empty($rows)) {
            echo 'data is empty';
            exit;
        }

        foreach ($rows as &$row) {
            IssueFilterLogic::formatIssue($row);
            //$row['ID'] = $row['id'];

            $tmpRow = [];
            if (in_array('summary', $exportFieldsArr)) {
                $tmpRow[$headerMap['summary']] = $row['summary'];
            }
            if (in_array('issue_num', $exportFieldsArr)) {
                $tmpRow[$headerMap['issue_num']] = $row['issue_num'];
            }
            if (in_array('project_id', $exportFieldsArr)) {
                if ($_GET['field_format_project_id'] == 'title') {
                    $tmpRow[$headerMap['project_id']] = $projectMap[$row['project_id']];
                } else {
                    $tmpRow[$headerMap['project_id']] = $row['project_id'];
                }
            }
            if (in_array('issue_type', $exportFieldsArr)) {
                $tmpRow[$headerMap['issue_type']] = $issueTypeMap[$row['issue_type']];
            }
            if (in_array('module', $exportFieldsArr)) {
                if ($_GET['field_format_module'] == 'title') {
                    $tmpRow[$headerMap['module']] =
                        array_key_exists($row['module'], $projectModuleMap)?$projectModuleMap[$row['module']]:'无';
                } else {
                    $tmpRow[$headerMap['module']] = $row['module'];
                }
            }
            if (in_array('sprint', $exportFieldsArr)) {
                if ($_GET['field_format_sprint'] == 'title') {
                    $tmpRow[$headerMap['sprint']] =
                        array_key_exists($row['sprint'], $projectSprintMap)?$projectSprintMap[$row['sprint']]:'无';
                } else {
                    $tmpRow[$headerMap['sprint']] = $row['sprint'];
                }
            }
            if (in_array('weight', $exportFieldsArr)) {
                $tmpRow[$headerMap['weight']] = $row['weight'];
            }
            if (in_array('description', $exportFieldsArr)) {
                $tmpRow[$headerMap['description']] = $row['description'];
            }
            if (in_array('priority', $exportFieldsArr)) {
                $tmpRow[$headerMap['priority']] = $issuePriorityMap[$row['priority']];
            }
            if (in_array('status', $exportFieldsArr)) {
                $tmpRow[$headerMap['status']] = $issueStatusMap[$row['status']];
            }
            if (in_array('resolve', $exportFieldsArr)) {
                $tmpRow[$headerMap['resolve']] =
                    array_key_exists($row['resolve'], $issueResolveMap)?$issueResolveMap[$row['resolve']]:'无';
            }
            if (in_array('environment', $exportFieldsArr)) {
                $tmpRow[$headerMap['environment']] = $row['environment'];
            }
            if (in_array('reporter', $exportFieldsArr)) {
                if ($_GET['field_format_reporter'] == 'username') {
                    $tmpRow[$headerMap['reporter']] =
                        isset($usernameMap[$row['reporter']])?$usernameMap[$row['reporter']]:'无';
                } elseif ($_GET['field_format_reporter'] == 'avatar') {
                    $tmpRow[$headerMap['reporter']] =
                        isset($avatarMap[$row['reporter']])?'<img width="30" height="30" src="'. ROOT_URL . 'attachment/'. $avatarMap[$row['reporter']].'" style="">':'无';
                } elseif ($_GET['field_format_reporter'] == 'avatar_url') {
                    $tmpRow[$headerMap['reporter']] =
                        isset($avatarMap[$row['reporter']])?$avatarMap[$row['reporter']]:'无';
                } else {
                    $tmpRow[$headerMap['reporter']] =
                        isset($displayNameMap[$row['reporter']])?$displayNameMap[$row['reporter']]:'无';
                }
            }
            if (in_array('assignee', $exportFieldsArr)) {
                if ($_GET['field_format_assignee'] == 'username') {
                    $tmpRow[$headerMap['assignee']] =
                        isset($usernameMap[$row['assignee']])?$usernameMap[$row['assignee']]:'无';
                } elseif ($_GET['field_format_assignee'] == 'avatar') {
                    $tmpRow[$headerMap['assignee']] =
                        isset($avatarMap[$row['assignee']])?'<img width="30" height="30" src="'. ROOT_URL . 'attachment/'. $avatarMap[$row['assignee']].'" style="">':'无';
                } elseif ($_GET['field_format_assignee'] == 'avatar_url') {
                    $tmpRow[$headerMap['assignee']] =
                        isset($avatarMap[$row['assignee']])?$avatarMap[$row['assignee']]:'无';
                } else {
                    $tmpRow[$headerMap['assignee']] =
                        isset($displayNameMap[$row['assignee']])?$displayNameMap[$row['assignee']]:'无';
                }

            }
            if (in_array('assistants', $exportFieldsArr)) {
                if (empty($row['assistants'])) {
                    $tmpRow[$headerMap['assistants']] = '无';
                } else {
                    $assistantsIdArr = explode(',', $row['assistants']);
                    $assistantsDisplayNameArr = [];
                    foreach ($assistantsIdArr as $v) {
                        if ($_GET['field_format_assistants'] == 'username') {
                            $assistantsDisplayNameArr[] = $usernameMap[$v];
                        } else {
                            $assistantsDisplayNameArr[] = $displayNameMap[$v];
                        }
                    }
                    $tmpRow[$headerMap['assistants']] = implode(",", $assistantsDisplayNameArr);
                }

            }
            if (in_array('modifier', $exportFieldsArr)) {
                if ($_GET['field_format_modifier'] == 'username') {
                    $tmpRow[$headerMap['modifier']] =
                        isset($usernameMap[$row['modifier']])?$usernameMap[$row['modifier']]:'无';
                } elseif ($_GET['field_format_modifier'] == 'avatar') {
                    $tmpRow[$headerMap['modifier']] =
                        isset($avatarMap[$row['modifier']])?'<img width="30" height="30" src="'. ROOT_URL . 'attachment/'. $avatarMap[$row['modifier']].'" style="">':'无';
                } elseif ($_GET['field_format_modifier'] == 'avatar_url') {
                    $tmpRow[$headerMap['modifier']] =
                        isset($avatarMap[$row['modifier']])?$avatarMap[$row['modifier']]:'无';
                } else {
                    $tmpRow[$headerMap['modifier']] =
                        isset($displayNameMap[$row['modifier']])?$displayNameMap[$row['modifier']]:'无';
                }
            }
            if (in_array('master_id', $exportFieldsArr)) {
                $tmpRow[$headerMap['master_id']] = ($row['master_id'] == 0)?'否':'是';
            }
            if (in_array('created', $exportFieldsArr)) {
                $tmpRow[$headerMap['created']] = date('Y-m-d H:i:s', $row['created']);
            }
            if (in_array('updated', $exportFieldsArr)) {
                $tmpRow[$headerMap['updated']] = date('Y-m-d H:i:s', $row['updated']);
            }
            if (in_array('start_date', $exportFieldsArr)) {
                $tmpRow[$headerMap['start_date']] = $row['start_date'];
            }
            if (in_array('due_date', $exportFieldsArr)) {
                $tmpRow[$headerMap['due_date']] = $row['due_date'];
            }
            if (in_array('resolve_date', $exportFieldsArr)) {
                $tmpRow[$headerMap['resolve_date']] = $row['resolve_date'];
            }

            $final[] = $tmpRow;
        }
        unset($row);

        if (empty($final)) {
            echo 'data is empty..';
            exit;
        }

        if ($ret) {
            excelData($final, array_keys($final[0]), 'issue.xls', '事项清单');
            //excelData($rows, ['ID','事项','状态','报告人','创建时间'], 'issue.xls', '我的测试事项导出');
        }
    }
}