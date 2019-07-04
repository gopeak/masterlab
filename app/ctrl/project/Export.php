<?php

namespace main\app\ctrl\project;

use main\app\classes\AgileLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueLogic;
use main\app\classes\IssueStatusLogic;
use main\app\classes\IssueTypeLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserLogic;
use main\app\classes\PermissionLogic;
use main\app\ctrl\BaseUserCtrl;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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
        //检测当前用户角色权限
        if (!$this->isAdmin) {
            if (!isset($this->projectPermArr[PermissionLogic::EXPORT_EXCEL])) {
                $this->ajaxFailed('当前项目中您没有权限进行此操作,需要导出事项权限');
            }
        }

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
            || $_GET['cur_project_id'] <= 0) {
            exit;
        }
        $projectId = $_GET['cur_project_id'];

        $curPage = 1;
        $pageSize = 59990;
        if (isset($_GET['radio-export_range'])) {
            switch ($_GET['radio-export_range']) {
                case 'current_page':
                    $curPage = isset($_GET['cur_page']) ? intval($_GET['cur_page']) : 1;
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
                        array_key_exists($row['module'], $projectModuleMap) ? $projectModuleMap[$row['module']] : '无';
                } else {
                    $tmpRow[$headerMap['module']] = $row['module'];
                }
            }
            if (in_array('sprint', $exportFieldsArr)) {
                if ($_GET['field_format_sprint'] == 'title') {
                    $tmpRow[$headerMap['sprint']] =
                        array_key_exists($row['sprint'], $projectSprintMap) ? $projectSprintMap[$row['sprint']] : '无';
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
                    array_key_exists($row['resolve'], $issueResolveMap) ? $issueResolveMap[$row['resolve']] : '无';
            }
            if (in_array('environment', $exportFieldsArr)) {
                $tmpRow[$headerMap['environment']] = $row['environment'];
            }
            if (in_array('reporter', $exportFieldsArr)) {
                if ($_GET['field_format_reporter'] == 'username') {
                    $tmpRow[$headerMap['reporter']] =
                        isset($usernameMap[$row['reporter']]) ? $usernameMap[$row['reporter']] : '无';
                } elseif ($_GET['field_format_reporter'] == 'avatar') {
                    if (isset($avatarMap[$row['reporter']]) && !empty($avatarMap[$row['reporter']])) {
                        $showAvatar = $avatarMap[$row['reporter']];
                        $showAvatar = '#IMG' . STORAGE_PATH . 'attachment/' . str_replace(strrchr($showAvatar, "?"), "", $showAvatar);
                    } elseif (isset($avatarMap[$row['reporter']]) && empty($avatarMap[$row['reporter']])) {
                        $showAvatar = '#IMG' . PUBLIC_PATH . 'dev/img/default_user_avatar.png';
                    } else {
                        $showAvatar = '无';
                    }
                    $tmpRow[$headerMap['reporter']] = $showAvatar;
                } elseif ($_GET['field_format_reporter'] == 'avatar_url') {
                    $tmpRow[$headerMap['reporter']] =
                        isset($avatarMap[$row['reporter']]) && !empty($avatarMap[$row['reporter']]) ? ATTACHMENT_URL . $avatarMap[$row['reporter']] : '无';
                } else {
                    $tmpRow[$headerMap['reporter']] =
                        isset($displayNameMap[$row['reporter']]) ? $displayNameMap[$row['reporter']] : '无';
                }
            }
            if (in_array('assignee', $exportFieldsArr)) {
                if ($_GET['field_format_assignee'] == 'username') {
                    $tmpRow[$headerMap['assignee']] =
                        isset($usernameMap[$row['assignee']]) ? $usernameMap[$row['assignee']] : '无';
                } elseif ($_GET['field_format_assignee'] == 'avatar') {
                    if (isset($avatarMap[$row['assignee']]) && !empty($avatarMap[$row['assignee']])) {
                        $showAvatar = $avatarMap[$row['assignee']];
                        $showAvatar = '#IMG' . STORAGE_PATH . 'attachment/' . str_replace(strrchr($showAvatar, "?"), "", $showAvatar);
                    } else if (isset($avatarMap[$row['assignee']]) && empty($avatarMap[$row['assignee']])) {
                        $showAvatar = '#IMG' . PUBLIC_PATH . 'dev/img/default_user_avatar.png';
                    } else {
                        $showAvatar = '无';
                    }
                    $tmpRow[$headerMap['assignee']] = $showAvatar;
                } elseif ($_GET['field_format_assignee'] == 'avatar_url') {
                    $tmpRow[$headerMap['assignee']] =
                        isset($avatarMap[$row['assignee']]) && !empty($avatarMap[$row['assignee']]) ? ATTACHMENT_URL . $avatarMap[$row['assignee']] : '无';
                } else {
                    $tmpRow[$headerMap['assignee']] =
                        isset($displayNameMap[$row['assignee']]) ? $displayNameMap[$row['assignee']] : '无';
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
                            if (array_key_exists($v, $usernameMap)) {
                                $assistantsDisplayNameArr[] = $usernameMap[$v];
                            }
                        } elseif ($_GET['field_format_assistants'] == 'avatar') {
                            $showAvatar = '';
                            if (isset($avatarMap[$v]) && !empty($avatarMap[$v])) {
                                $showAvatar = $avatarMap[$v];
                                $showAvatar = '#IMG' . STORAGE_PATH . 'attachment/' . str_replace(strrchr($showAvatar, "?"), "", $showAvatar);
                            } else if (isset($avatarMap[$v]) && empty($avatarMap[$v])) {
                                $showAvatar = '#IMG' . PUBLIC_PATH . 'dev/img/default_user_avatar.png';
                            }
                            $assistantsDisplayNameArr[] = $showAvatar;

                        } elseif ($_GET['field_format_assistants'] == 'avatar_url') {
                            if (array_key_exists($v, $avatarMap) && !empty($avatarMap[$v])) {
                                $assistantsDisplayNameArr[] = ATTACHMENT_URL . $avatarMap[$v];
                            } elseif (array_key_exists($v, $avatarMap) && empty($avatarMap[$v])) {
                                $assistantsDisplayNameArr[] = ROOT_URL . 'dev/img/default_user_avatar.png';
                            }
                        } else {
                            if (array_key_exists($v, $displayNameMap)) {
                                $assistantsDisplayNameArr[] = $displayNameMap[$v];
                            }
                        }
                    }
                    if ($_GET['field_format_assistants'] == 'avatar') {
                        $tmpRow[$headerMap['assistants']] = implode("", $assistantsDisplayNameArr);
                    } else {
                        $tmpRow[$headerMap['assistants']] = implode(",", $assistantsDisplayNameArr);
                    }
                }

            }
            if (in_array('modifier', $exportFieldsArr)) {
                if ($_GET['field_format_modifier'] == 'username') {
                    $tmpRow[$headerMap['modifier']] =
                        isset($usernameMap[$row['modifier']]) ? $usernameMap[$row['modifier']] : '无';
                } elseif ($_GET['field_format_modifier'] == 'avatar') {
                    if (isset($avatarMap[$row['modifier']]) && !empty($avatarMap[$row['modifier']])) {
                        $showAvatar = $avatarMap[$row['modifier']];
                        $showAvatar = '#IMG' . STORAGE_PATH . 'attachment/' . str_replace(strrchr($showAvatar, "?"), "", $showAvatar);
                    } else if (isset($avatarMap[$row['modifier']]) && empty($avatarMap[$row['modifier']])) {
                        $showAvatar = '#IMG' . PUBLIC_PATH . 'dev/img/default_user_avatar.png';
                    } else {
                        $showAvatar = '无';
                    }
                    $tmpRow[$headerMap['modifier']] = $showAvatar;

                } elseif ($_GET['field_format_modifier'] == 'avatar_url') {
                    $tmpRow[$headerMap['modifier']] =
                        isset($avatarMap[$row['modifier']]) && !empty($avatarMap[$row['modifier']]) ? ATTACHMENT_URL . $avatarMap[$row['modifier']] : '无';
                } else {
                    $tmpRow[$headerMap['modifier']] =
                        isset($displayNameMap[$row['modifier']]) ? $displayNameMap[$row['modifier']] : '无';
                }
            }
            if (in_array('master_id', $exportFieldsArr)) {
                $tmpRow[$headerMap['master_id']] = ($row['master_id'] == 0) ? '否' : '是';
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
            //excelData($final, array_keys($final[0]), 'issue.xls', '事项清单');
            $cellHeaderArr = array_slice(excelCell(), 0, count(array_keys($final[0])));
            //dump($cellHeaderArr, true);

            $final2 = [];

            // 设置第一行头字段
            $cellHeaderArr1 = array_map(function ($letter) {
                return $letter . '1';
            }, $cellHeaderArr);
            $final2 = array_merge($final2, array_combine($cellHeaderArr1, array_keys($final[0])));
            // 开始数据转化成矩阵
            $cellIndex = 2;
            foreach ($final as $item) {
                $cellHeaderArrTmp = array_map(function ($letter) use ($cellIndex) {
                    return $letter . $cellIndex;
                }, $cellHeaderArr);

                $newItem = array_combine($cellHeaderArrTmp, array_values($item));
                $final2 = array_merge($final2, $newItem);
                $cellIndex++;
            }
            //dump($final2, true);exit;

            $this->exportExcel(
                $final2,
                date("Y-m-d") . "-issue.xlsx",
                [
                    'print' => true,
                    //'freezePane' => 'A2',
                    'setARGB' => $cellHeaderArr1,
                    'setBorder' => true,
                ]
            );
        }
    }

    /**
     * Excel导出
     * 使用#IMG来标识avatar显示
     * @param array $datas 导出数据，格式['A1' => '标题', 'B1' => '编号', ..., 'V1' => '事项类型', 'A2' => '当前事项的活动记录', ...]
     * @param string $fileName 导出文件名称
     * @param array $options 操作选项，例如：
     *                           bool   print       设置打印格式
     *                           string freezePane  锁定行数，例如表头为第一行，则锁定表头输入A2
     *                           array  setARGB     设置背景色，例如['A1', 'C1']
     *                           array  setWidth    设置宽度，例如['A' => 30, 'C' => 20]
     *                           bool   setBorder   设置单元格边框
     *                           array  mergeCells  设置合并单元格，例如['A1:J1' => 'A1:J1']
     *                           array  formula     设置公式，例如['F2' => '=IF(D2>0,E42/D2,0)']
     *                           array  format      设置格式，整列设置，例如['A' => 'General']
     *                           array  alignCenter 设置居中样式，例如['A1', 'A2']
     *                           array  bold        设置加粗样式，例如['A1', 'A2']
     *                           string savePath    保存路径，设置后则文件保存到服务器，不通过浏览器下载
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportExcel(array $datas, $fileName = '', array $options = [])
    {
        if (empty($datas)) {
            return false;
        }

        set_time_limit(0);
        /** @var Spreadsheet $objSpreadsheet */
        $objSpreadsheet = new Spreadsheet();
        /* 设置默认文字居左，上下居中 */
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $objSpreadsheet->getDefaultStyle()->applyFromArray($styleArray);
        /* 设置Excel Sheet */
        $activeSheet = $objSpreadsheet->setActiveSheetIndex(0);

        /* 打印设置 */
        if (isset($options['print']) && $options['print']) {
            /* 设置打印为A4效果 */
            $activeSheet->getPageSetup()->setPaperSize(PageSetup:: PAPERSIZE_A4);
            /* 设置打印时边距 */
            $pValue = 1 / 2.54;
            $activeSheet->getPageMargins()->setTop($pValue / 2);
            $activeSheet->getPageMargins()->setBottom($pValue * 2);
            $activeSheet->getPageMargins()->setLeft($pValue / 2);
            $activeSheet->getPageMargins()->setRight($pValue / 2);
        }

        /* 行数据处理 */
        foreach ($datas as $sKey => $sItem) {
            if (strpos($sItem, '#IMG') !== false) {
                $sItem = trim($sItem, '#IMG');
                //$sItem = substr($sItem, 4);
                $i = 0;
                foreach (explode("#IMG", $sItem) as $avatarPath) {
                    $drawing = new Drawing();
                    $drawing->setName('Avatar');
                    $drawing->setDescription('Avatar');
                    //$drawing->setPath(STORAGE_PATH . 'attachment/avatar/10000.png');
                    //$drawing->setPath(STORAGE_PATH . 'attachment/' . str_replace(strrchr($shortUrl, "?"),"", $shortUrl));
                    if (file_exists($avatarPath)) {
                        $drawing->setPath($avatarPath);
                    } else {
                        $drawing->setPath(PUBLIC_PATH . 'dev/img/default_user_avatar.png');
                    }
                    $drawing->setCoordinates($sKey);//放入坐标位置
                    $drawing->setOffsetX(1 + $i * 18);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(18, 18);
                    $drawing->setWorksheet($objSpreadsheet->getActiveSheet());
                    $i++;
                }

            } else {
                /* 默认文本格式 */
                $pDataType = DataType::TYPE_STRING;

                /* 设置单元格格式 */
                if (isset($options['format']) && !empty($options['format'])) {
                    $colRow = Coordinate::coordinateFromString($sKey);

                    /* 存在该列格式并且有特殊格式 */
                    if (isset($options['format'][$colRow[0]]) &&
                        NumberFormat::FORMAT_GENERAL != $options['format'][$colRow[0]]) {
                        $activeSheet->getStyle($sKey)->getNumberFormat()
                            ->setFormatCode($options['format'][$colRow[0]]);

                        if (false !== strpos($options['format'][$colRow[0]], '0.00') &&
                            is_numeric(str_replace(['￥', ','], '', $sItem))) {
                            /* 数字格式转换为数字单元格 */
                            $pDataType = DataType::TYPE_NUMERIC;
                            $sItem = str_replace(['￥', ','], '', $sItem);
                        }
                    } elseif (is_int($sItem)) {
                        $pDataType = DataType::TYPE_NUMERIC;
                    }
                }

                $activeSheet->setCellValueExplicit($sKey, $sItem, $pDataType);

                /* 存在:形式的合并行列，列入A1:B2，则对应合并 */
                if (false !== strstr($sKey, ":")) {
                    $options['mergeCells'][$sKey] = $sKey;
                }
            }

        }
        unset($datas);

        /* 设置锁定行 */
        if (isset($options['freezePane']) && !empty($options['freezePane'])) {
            $activeSheet->freezePane($options['freezePane']);
            unset($options['freezePane']);
        }

        /* 设置宽度 */
        if (isset($options['setWidth']) && !empty($options['setWidth'])) {
            foreach ($options['setWidth'] as $swKey => $swItem) {
                $activeSheet->getColumnDimension($swKey)->setWidth($swItem);
            }

            unset($options['setWidth']);
        }

        /* 设置背景色 */
        if (isset($options['setARGB']) && !empty($options['setARGB'])) {
            foreach ($options['setARGB'] as $sItem) {
                $activeSheet->getStyle($sItem)
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(Color::COLOR_DARKGREEN);
            }

            unset($options['setARGB']);
        }

        /* 设置公式 */
        if (isset($options['formula']) && !empty($options['formula'])) {
            foreach ($options['formula'] as $fKey => $fItem) {
                $activeSheet->setCellValue($fKey, $fItem);
            }

            unset($options['formula']);
        }

        /* 合并行列处理 */
        if (isset($options['mergeCells']) && !empty($options['mergeCells'])) {
            $activeSheet->setMergeCells($options['mergeCells']);
            unset($options['mergeCells']);
        }

        /* 设置居中 */
        if (isset($options['alignCenter']) && !empty($options['alignCenter'])) {
            $styleArray = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];

            foreach ($options['alignCenter'] as $acItem) {
                $activeSheet->getStyle($acItem)->applyFromArray($styleArray);
            }

            unset($options['alignCenter']);
        }

        /* 设置加粗 */
        if (isset($options['bold']) && !empty($options['bold'])) {
            foreach ($options['bold'] as $bItem) {
                $activeSheet->getStyle($bItem)->getFont()->setBold(true);
            }

            unset($options['bold']);
        }

        /* 设置单元格边框，整个表格设置即可，必须在数据填充后才可以获取到最大行列 */
        if (isset($options['setBorder']) && $options['setBorder']) {
            $border = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // 设置border样式
                        'color' => ['argb' => 'FF000000'], // 设置border颜色
                    ],
                ],
            ];
            $setBorder = 'A1:' . $activeSheet->getHighestColumn() . $activeSheet->getHighestRow();
            $activeSheet->getStyle($setBorder)->applyFromArray($border);
            unset($options['setBorder']);
        }

        $fileName = !empty($fileName) ? $fileName : (date('YmdHis') . '.xlsx');

        if (!isset($options['savePath'])) {
            /* 直接导出Excel，无需保存到本地，输出07Excel文件 */
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header(
                "Content-Disposition:attachment;filename=" . iconv(
                    "utf-8", "GB2312//TRANSLIT", $fileName
                )
            );
            header('Cache-Control: max-age=0');//禁止缓存
            $savePath = 'php://output';
        } else {
            $savePath = $options['savePath'];
        }

        ob_clean();
        ob_start();
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
        $objWriter->save($savePath);
        /* 释放内存 */
        $objSpreadsheet->disconnectWorksheets();
        unset($objSpreadsheet);
        ob_end_flush();

        return true;
    }

}