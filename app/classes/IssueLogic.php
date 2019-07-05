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
class IssueLogic
{

    public static $uiDisplayFields = [
        'issue_num' => '编号',
        'issue_type' => '类型',
        'priority' => '优先级',
        'project_id' => '项目',
        'module' => '模块',
        'sprint' => '迭代',
        'summary' => '标题',
        'weight' => '权重',
        'assignee' => '经办人',
        'reporter' => '报告人',
        'assistants' => '协助人',
        'status' => '状态',
        'resolve' => '解决结果',
        'environment' => '运行环境',
        'plan_date' => '计划时间',
        'resolve_date' => '实际解决日期',
        'modifier' => '最后修改人',
        'master_id' => '是否父任务',
        'created' => '创建时间',
        'updated' => '最后修改时间',
    ];
    public static $defaultDisplayFields = [
        'issue_num',
        'issue_type',
        'priority',
        'module',
        'summary',
        'assignee',
        'status',
        'resolve',
        'plan_date'
    ];


    /**
     * @param $issueId
     * @param $issueModel IssueModel
     * @param $issue
     * @return mixed
     */
    public function getPreIssue($issueId, $issueModel, $issue)
    {
        $table = $issueModel->getTable();
        $projectId = $issue['project_id'];
        $params = [];
        if (isset($_SESSION['issue_filter_where'])) {
            $filterWhere = $_SESSION['issue_filter_where'];
            $filterOrder = $_SESSION['issue_filter_order_by'];
            $params = $_SESSION['issue_filter_params'];
            $sqlPreNextSql = "SELECT  * FROM  {$table}  {$filterWhere} AND id < $issueId  {$filterOrder} limit 2 ";
        } else {
            $sqlPreNextSql = "SELECT  * FROM  {$table} WHERE  project_id=$projectId  AND id < $issueId limit 2";
        }
        $rows = $issueModel->db->getRows($sqlPreNextSql, $params);
        return $rows;
    }

    /**
     * 获取下一个事项
     * @param $issueId
     * @param $issueModel IssueModel
     * @return array
     */
    public function getNextIssueId($issueId, $issueModel)
    {
        $table = $issueModel->getTable();
        if (isset($_SESSION['filter_id_arr'])) {
            $filterIdArr = $_SESSION['filter_id_arr'];
            $issueIdkey = array_search($issueId, $filterIdArr);
            if (!is_int($issueIdkey)) {
                return [false, 0];
            }
            if (isset($filterIdArr[$issueIdkey + 1])) {
                return [true, $filterIdArr[$issueIdkey + 1]];
            } else {
                $filterPages = $_SESSION['filter_pages'];
                $filterCurrentPage = $_SESSION['filter_current_page'];
                // 如果是最后一个事项,而且还有下一页则获取下一页的第一个id
                if ($filterPages > $filterCurrentPage) {
                    $filterWhere = $_SESSION['issue_filter_where'];
                    $filterOrder = $_SESSION['issue_filter_order_by'];
                    $params = $_SESSION['issue_filter_params'];
                    $pageSize = $_SESSION['filter_page_size'];
                    $currentPage = $filterCurrentPage;
                    $start = $pageSize * ($currentPage);
                    $limit = " limit $start , 1 ";
                    $sqlPreNextSql = "SELECT  id FROM  {$table}  {$filterWhere}  $filterOrder  $limit";
                    $nextId = $issueModel->db->getOne($sqlPreNextSql, $params);
                    return [true, $nextId];
                }
            }
        }
        return [false, 0];
    }

    /**
     * 获取下一个事项
     * @param $issueId
     * @param $issueModel
     * @return array
     */
    public function getPrevIssueId($issueId, $issueModel)
    {
        $table = $issueModel->getTable();
        //print_r($_SESSION);
        if (isset($_SESSION['filter_id_arr'])) {
            $filterIdArr = $_SESSION['filter_id_arr'];
            $filterCurrentPage = $_SESSION['filter_current_page'];
            $issueIdkey = array_search($issueId, $filterIdArr);
            //var_export($issueIdkey);
            if (!is_int($issueIdkey)) {
                return [false, 0];
            }
            if ($issueIdkey == 0 && $filterCurrentPage == 1) {
                return [false, 0];
            }
            if (isset($filterIdArr[$issueIdkey - 1])) {
                return [true, $filterIdArr[$issueIdkey - 1]];
            } else {

                // 如果是第一个事项,而且还有上一页
                if ($filterCurrentPage > 1) {
                    $filterWhere = $_SESSION['issue_filter_where'];
                    $filterOrder = $_SESSION['issue_filter_order_by'];
                    $params = $_SESSION['issue_filter_params'];
                    $pageSize = $_SESSION['filter_page_size'];
                    $start = $pageSize * ($filterCurrentPage - 1);
                    $limit = " limit $start , $pageSize ";
                    $sqlPreNextSql = "SELECT  id FROM  {$table}  {$filterWhere}  $filterOrder  $limit";
                    $rows = $issueModel->db->getRows($sqlPreNextSql, $params);
                    $prevRow = end($rows);
                    return [true, $prevRow['id']];
                }
            }
        }
        return [false, 0];
    }

    /**
     * 获取自定义字段
     * @param $issueId
     * @return array
     */
    public function getCustomFieldValue($issueId)
    {
        $model = new FieldModel();
        $customFields = $model->getCustomFields();
        $fields = [];
        foreach ($customFields as $customField) {
            $fields[$customField['id']] = $customField;
        }

        $model = new FieldCustomValueModel($issueId);
        $rows = $model->getItemsByIssueId($issueId);
        foreach ($rows as &$row) {
            $row['field'] = new \stdClass();
            $row['field_title'] = '';
            if (isset($fields[$row['custom_field_id']])) {
                $row['field'] = $fields[$row['custom_field_id']];
                $row['field_title'] = $row['field']['title'];
            }

            $valueType = $row['value_type'];
            $row['value'] = null;
            if (isset($row[$valueType . '_value'])) {
                $row['value'] = $row[$valueType . '_value'];
            }
            $row['show_value'] = '';
            if (!empty($row['value'])) {
                $row['show_value'] = mb_substr(ucfirst($row['value']), 0, 20, 'utf-8');
            }
        }
        return $rows;
    }

    /**
     * 获取某一事项的子任务
     * @param $issueId
     * @return array
     */
    public function getChildIssue($issueId)
    {
        $model = new IssueModel();
        $field = 'id, issue_num, assignee,summary';
        $conditions['master_id'] = $issueId;
        $rows = $model->getRows($field, $conditions);
        foreach ($rows as &$row) {
            $row['show_title'] = mb_substr(ucfirst($row['summary']), 0, 20, 'utf-8');
        }
        return $rows;
    }


    /**
     * 转换为子任务
     * @param $currentId
     * @param $masterId
     * @return array
     * @throws \Exception
     */
    public function convertChild($currentId, $masterId)
    {
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($currentId);
        if (empty($issue)) {
            return [false, 'data_is_empty'];
        }
        list($ret, $msg) = $issueModel->updateById($currentId, ['master_id' => $masterId]);
        if (!$ret) {
            return [false, 'server_error:' . $msg];
        } else {
            $issueModel->updateTime($currentId);
            $masterChildrenCount = $issueModel->getChildrenCount($masterId);
            $issueModel->updateById($masterId, ['have_children' => $masterChildrenCount, 'updated' => time()]);

            $currentChildrenCount = $issueModel->getChildrenCount($currentId);
            $issueModel->updateById($currentId, ['have_children' => $currentChildrenCount, 'updated' => time()]);
            return [true, 'ok'];
        }
    }

    /**
     * 当前事项不再是子任务
     * @param $currentId
     * @return array
     * @throws \Exception
     */
    public function removeChild($currentId)
    {
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($currentId);
        if (empty($issue)) {
            return [false, 'data_is_empty'];
        }
        list($ret, $msg) = $issueModel->updateById($currentId, ['master_id' => '0']);
        if (!$ret) {
            return [false, 'server_error:' . $msg];
        } else {
            $masterId = $issue['master_id'];
            $masterChildrenCount = $issueModel->getChildrenCount($masterId);
            $issueModel->updateById($masterId, ['have_children' => $masterChildrenCount, 'updated' => time()]);
            return [true, 'ok'];
        }
    }

    /**
     * 获取描述的模板
     * @return array
     */
    public function getDescriptionTemplates()
    {
        $descTplModel = new IssueDescriptionTemplateModel();
        $rows = $descTplModel->getToolbars(false);
        return $rows;
    }


    /**
     * 添加一个自定义字段值
     * @param $issueId
     * @param $projectId
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function addCustomFieldValue($issueId, $projectId, $params)
    {
        $model = new FieldModel();
        $customFields = $model->getCustomFields();
        $fields = [];
        foreach ($customFields as $field) {
            $fields[$field['name']] = $field;
        }
        if (!$params) {
            return [false, 'param_error'];
        }
        $model = new FieldCustomValueModel();
        foreach ($params as $key => $param) {
            if (isset($fields[$key])) {
                $field = $fields[$key];
                $valueType = self::getValueType($field['type']);
                $info = [];
                $info['issue_id'] = $issueId;
                $info['project_id'] = $projectId;
                $info['custom_field_id'] = $field['id'];
                $info['value_type'] = $valueType;
                $info[$valueType . '_value'] = $param;
                $model->insert($info);
            }
        }
        return [true, 'ok'];
    }

    /**
     * 获取字段类型
     * @param $type
     * @return string
     */
    public static function getValueType($type)
    {
        $valueType = 'string';
        switch ($type) {
            case "MARKDOWN":
            case "TEXT":
                $valueType = 'text';
                break;
            case "USER":
            case "GROUP":
            case "MODULE":
            case "MILESTONE":
            case "SPRINT":
            case "RESOLUTION":
            case "STATUS":
                $valueType = 'number';
                break;
            case "DATE":
                $valueType = 'date';
                break;

            default:
                break;
        }
        return $valueType;
    }

    /**
     * 更新自定义字段的值
     * @param $issueId
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function updateCustomFieldValue($issueId, $params)
    {
        // @todo 为避免频繁更新该表，应该通过patch方式提交
        $model = new FieldModel();
        $customFields = $model->getCustomFields();
        $fields = [];
        foreach ($customFields as $field) {
            $fields[$field['name']] = $field;
        }
        if (!$params) {
            return [false, 'param_error'];
        }
        $model = new FieldCustomValueModel();
        foreach ($params as $key => $param) {
            if (isset($fields[$key])) {
                $field = $fields[$key];
                $valueType = self::getValueType($field['type']);
                $conditions = [];
                $conditions['issue_id'] = $issueId;
                $conditions['custom_field_id'] = $field['id'];
                $info = [];
                $info['value_type'] = $valueType;
                $info[$valueType . '_value'] = $param;
                $model->update($info, $conditions);
            }
        }
        return [true, 'ok'];
    }

    /**
     * 添加协助人
     * @param $issueId
     * @param $assistants
     * @return array
     * @throws \Exception
     */
    public function addAssistants($issueId, $assistants)
    {
        // 确保 $assistants 是数组
        if (!is_array($assistants)) {
            $assistants = explode(',', $assistants);
        }
        $assistantsStr = implode(',', $assistants);
        $issueModel = new IssueModel();
        $assistantsModel = new IssueAssistantsModel();
        try {
            $issueModel->db->beginTransaction();
            list($ret, $msg) = $issueModel->updateById($issueId, ['assistants' => $assistantsStr]);
            if (!$ret) {
                $issueModel->db->rollBack();
                return [false, $msg];
            }
            foreach ($assistants as $userId) {
                $info = [];
                $info['user_id'] = $userId;
                list($insertRet, $msg) = $assistantsModel->insertItemByIssueId($issueId, $info);
                if (!$insertRet) {
                    $issueModel->db->rollBack();
                    return [false, $msg];
                }
            }
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true, 'ok'];
    }

    /**
     * 置空协助人
     * @param $issueId
     * @return array
     * @throws \Exception
     */
    public function emptyAssistants($issueId)
    {
        $issueModel = new IssueModel();
        $assistantsModel = new IssueAssistantsModel();
        try {
            $issueModel->db->beginTransaction();
            list($ret, $msg) = $issueModel->updateById($issueId, ['assistants' => '']);
            if (!$ret) {
                $issueModel->db->rollBack();
                return [false, $msg];
            }
            $assistantsModel->deleteItemByIssueId($issueId);
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true, 'ok'];
    }

    /**
     * 更新协助人
     * @param $issueId
     * @param $assistants
     * @return array
     * @throws \Exception
     */
    public function updateAssistants($issueId, $assistants)
    {
        // 确保 $assistants 是数组
        if (!is_array($assistants)) {
            $assistants = explode(',', $assistants);
        }
        $assistantsStr = implode(',', $assistants);

        $issueModel = new IssueModel();
        $assistantsModel = new IssueAssistantsModel();
        $issueAssistantsRows = $assistantsModel->getItemsByIssueId($issueId);
        $issueAssistantsArr = [];
        foreach ($issueAssistantsRows as $item) {
            $issueAssistantsArr[] = $item['issue_id'];
        }
        sort($issueAssistantsArr);
        sort($assistants);
        //print_r($issueAssistantsArr);
        //print_r($assistants);
        //var_dump($assistantsStr);
        // 如果无修改 则什么都不做
        if ($issueAssistantsArr == $assistants) {
            return [false, 'nothing_to_do'];
        }

        // 执行事务
        try {
            $issueModel->db->beginTransaction();
            list($ret, $msg) = $issueModel->updateById($issueId, ['assistants' => $assistantsStr]);
            if (!$ret) {
                $issueModel->db->rollBack();
                return [false, $msg];
            }
            $assistantsModel->deleteItemByIssueId($issueId);
            foreach ($assistants as $userId) {
                $info = [];
                $info['user_id'] = $userId;
                list($insertRet, $msg) = $assistantsModel->insertItemByIssueId($issueId, $info);
                if (!$insertRet) {
                    $issueModel->db->rollBack();
                    return [false, $msg];
                }
            }
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true, 'ok'];
    }

    /**
     * 添加子项数据
     * @param $model
     * @param $issueId
     * @param $arr
     * @param $field
     * @return array
     */
    public function addChildData($model, $issueId, $arr, $field)
    {
        if (!is_array($arr)) {
            $arr = explode(',', $arr);
        }
        foreach ($arr as $itemId) {
            if (empty($itemId)) {
                continue;
            }
            $info = [];
            $info[$field] = $itemId;
            $info['issue_id'] = $issueId;
            $model->insert($info);
        }
        return [true, 'ok'];
    }

    /**
     * 更新子项数据
     * @param IssueFixVersionModel $model
     * @param $issueId
     * @param $arr
     * @param $field
     * @return array
     * @throws \Exception
     */
    public function updateChildData($model, $issueId, $arr, $field)
    {
        // 确保为数组
        if (!is_array($arr)) {
            $arr = explode(',', $arr);
        }
        $originArr = $model->getItemsByIssueId($issueId);
        $originIdArr = [];
        foreach ($originArr as $item) {
            $originIdArr [] = $item[$field];
        }
        sort($originIdArr);
        sort($arr);
        if ($originIdArr == $arr) {
            return [false, 'nothing_to_do'];
        }
        $model->deleteItemByIssueId($issueId);
        foreach ($arr as $itemId) {
            $info = [];
            $info[$field] = $itemId;
            $info['issue_id'] = $issueId;
            $model->insert($info);
        }
        return [true, 'ok'];
    }

    /**
     * 获取事项活动动态信息
     * @throws \Exception
     */
    public function getActivityInfo($statusModel, $resolveModel, $info)
    {
        $title = '更新了事项';
        if (isset($info['status'])) {
            //修改状态
            $statusName = $statusModel->getById($info['status']);
            $title = '修改事项状态为 ' . $statusName["name"];
        }
        if (isset($info['resolve'])) {
            //修改解决结果
            $ResolveName = $resolveModel->getById($info['resolve']);
            $title = '修改事项解决结果为 ' . $ResolveName["name"];
        }
        return $title;
    }

    /**获取模块、迭代、解决结果等的动态名称
     * @param $moduleModel
     * @param $sprintModel
     * @param $resolveModel
     * @param $field
     * @param $value
     * @return string
     */
    public function getModuleOrSprintName($moduleModel, $sprintModel, $resolveModel, $field, $value)
    {
        $name = '';
        if ($field === 'module') {
            //获取模块名称
            $statusName = $moduleModel->getById($value);
            $name = '模块:' . $statusName["name"];
        } else if ($field === 'sprint') {
            //获取迭代名称
            $ResolveName = $sprintModel->getById($value);
            $name = '迭代:' . $ResolveName["name"];
        } else {
            $ResolveName = $resolveModel->getById($value);
            $name = '解决结果:' . $ResolveName["name"];
        }
        return $name;
    }

    /**
     *
     * @param $issueIds
     * @return array
     * @throws \Exception
     */
    public function getIssueSummary($issueIds)
    {
        $issueModel = new IssueModel();
        $issueTable = $issueModel->getTable();
        $sql = "Select group_concat(summary) as names  From {$issueTable}  Where id in ({$issueIds})";
        $issueNames = $issueModel->db->getRows($sql);
        if (empty($issueNames)) {
            return $issueIds;
        } else {
            return $issueNames[0]['names'];
        }
    }

    /**
     * 获取所有事项优先级的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @return array
     * @throws \Exception
     */
    public static function getAllIssuePriorityNameAndId()
    {
        $model = new IssuePriorityModel();
        $originalRes = $model->getAllItem(false);
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }

    /**
     * 获取所有事项的resolve的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @return array
     * @throws \Exception
     */
    public static function getAllIssueResolveNameAndId()
    {
        $model = new IssueResolveModel();
        $originalRes = $model->getAllItem(false);
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }

    /**
     * @param $userId
     * @param $projectId
     * @return mixed
     * @throws \Exception
     */
    public static function getUserIssueDisplayFields($userId, $projectId)
    {
        $fields = self::$defaultDisplayFields;
        $displayFieldsModel = new UserIssueDisplayFieldsModel();
        $row = $displayFieldsModel->getByUserProject($userId, $projectId);

        if (!isset($row['fields'])) {
            return $fields;
        }
        $tmp = explode(',', $row['fields']);
        if (!empty($tmp)) {
            foreach ($tmp as $k => $f) {
                if (empty($f)) {
                    unset($tmp[$k]);
                }
            }
            $tmp = array_values($tmp);
        }
        if (!empty($tmp)) {
            $fields = $tmp;
        }
        return $fields;
    }

    /**
     * 更新关注数
     * @param $issueId
     * @return array
     * @throws \Exception
     */
    public function updateFollowCount($issueId)
    {
        $issueModel = new IssueModel();
        $issueFollowModel = new IssueFollowModel();
        $updateCount = $issueFollowModel->getCountByIssueId($issueId);
        $ret = $issueModel->updateItemById($issueId, ['followed_count' => $updateCount]);
        return $ret;
    }

    public function syncFollowCount()
    {
        $issueModel = new IssueModel();
        $sql = "SELECT i.id,i.issue_num ,count(f.id) as cc FROM `issue_main` i LEFT JOIN issue_follow f ON i.id=f.issue_id GROUP BY i.id";
        $issueDataArr = $issueModel->db->getRows($sql);
        foreach ($issueDataArr as $item) {
            $updateCount = intval($item['cc']);
            if ($updateCount > 0) {
                $issueModel->updateItemById($item['id'], ['followed_count' => $updateCount]);
            }
        }
    }

    public function syncCommentCount()
    {
        $issueModel = new IssueModel();
        $sql = "SELECT i.id,i.issue_num ,count(f.id) as cc FROM `issue_main` i LEFT JOIN main_timeline f ON i.id=f.issue_id GROUP BY i.id";
        $issueDataArr = $issueModel->db->getRows($sql);
        foreach ($issueDataArr as $item) {
            $updateCount = intval($item['cc']);
            if ($updateCount > 0) {
                $issueModel->updateItemById($item['id'], ['comment_count' => $updateCount]);
            }
        }
    }

    /**
     * 更新评论数
     * @param $issueId
     * @return array
     * @throws \Exception
     */
    public function updateCommentsCount($issueId)
    {
        $issueModel = new IssueModel();
        $timelineModel = new TimelineModel();
        $updateCount = $timelineModel->getCountByIssueId($issueId);
        $ret = $issueModel->updateItemById($issueId, ['comment_count' => $updateCount]);
        return $ret;
    }


    /**
     * 导入excel数据到项目中
     * @param $projectId
     * @param $filename
     * @return array
     * @throws \Exception
     */
    public function importExcel($projectId, $filename)
    {
        try {
            // 支持Xls和Xlsx格式两种
            $objReader = IOFactory::createReader('Xlsx');
            if (!$objReader->canRead($filename)) {
                $objReader = IOFactory::createReader('Xls');
                if (!$objReader->canRead($filename)) {
                    throw new \Exception('只支持导入Excel文件！');
                }
            }
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($filename);  //$filename可以是上传的表格，或者是指定的表格
            $sheet = $objPHPExcel->getSheet(0);   //excel中的第一张sheet
            $highestRow = (int)$sheet->getHighestRow();       // 取得总行数
            $columnH = $sheet->getHighestColumn();
            $highestColumn = Coordinate::columnIndexFromString($columnH);

            if ($highestRow < 2) {
                return [false, '行数格式错误，不足两行'];
            }

            // 首先获取头部字段信息
            $keyColumnArr = [];
            $columnIndexArr = [];
            $rowFieldArr = [];
            $indexColumns = [];
            $importFields = self::$importFields;
            for ($i = 1; $i <= $highestColumn; $i++) {
                $columnIndex = Coordinate::stringFromColumnIndex($i);
                $indexColumns[$i] = $columnIndex;
                $columnValue = '';
                $columnCellValue = $sheet->getCell($columnIndex . '2')->getValue();
                if (!empty($columnCellValue) && is_string($columnCellValue)) {
                    $columnValue = str_replace(["'", " "], ["", ""], $columnCellValue);
                }
                $field = array_search($columnValue, $importFields);
                if ($field !== false) {
                    $keyColumnArr[$field] = $i;
                    $columnIndexArr[$field] = $columnIndex;
                    $rowFieldArr[$i] = $field;
                }
            }
            //print_r($keyColumnArr);
            // 准备好事项关联数据
            $priorityArr = [];
            foreach (ConfigLogic::getPriority() as $item) {
                $priorityArr[self::trimSpace($item['name'])] = $item['id'];
            }
            $issueTypeArr = [];
            foreach (ConfigLogic::getTypes() as $item) {
                $issueTypeArr[self::trimSpace($item['name'])] = $item['id'];
            }
            $issueStatusArr = [];
            foreach (ConfigLogic::getStatus() as $item) {
                $name = str_replace(" ", "", trimStr($item['name']));
                $issueStatusArr[$name] = $item['id'];
            }
            $issueResolveArr = [];
            foreach (ConfigLogic::getResolves() as $item) {
                $issueResolveArr[self::trimSpace($item['name'])] = $item['id'];
            }
            $usersArr = [];
            foreach (ConfigLogic::getAllUser() as $item) {
                $usersArr[$item['username']] = $item['uid'];
            }
            $projectSprintsArr = [];
            foreach (ConfigLogic::getSprints($projectId) as $item) {
                $projectSprintsArr[$item['name']] = $item['id'];
            }
            $projectModulesArr = [];
            foreach (ConfigLogic::getModules($projectId) as $item) {
                $projectModulesArr[$item['name']] = $item['id'];
            }
            $projectVersionsArr = [];
            foreach (ConfigLogic::getVersions($projectId) as $item) {
                $projectVersionsArr[$item['name']] = $item['id'];
            }
            $projectLabelsArr = [];
            foreach (ConfigLogic::getLabels($projectId) as $item) {
                $projectLabelsArr[$item['title']] = $item['id'];
            }
            $projectModel = new ProjectModel();
            $project = $projectModel->getById($projectId);
            // 获取插入的数据
            $insertRows = [];
            for ($i = 3; $i <= $highestRow; $i++) {
                $insertRow = [];
                $extraData = [];
                foreach ($columnIndexArr as $field => $columnIndex) {
                    $value = $sheet->getCell($columnIndex . $i)->getValue();
                    if ($field === 'summary') {
                        if (empty($value)) {
                            break;
                        } else {
                            $insertRow['summary'] = $value;
                        }
                    }
                    if ($field == 'issue_num' && !empty($value)) {
                        $insertRow[$field] = $value;
                    }
                    if ($field == 'description' && !empty($value)) {
                        $insertRow[$field] = $value;
                    }
                    if ($field == 'issue_type' && isset($issueTypeArr[$value])) {
                        $value = self::trimSpace($value);
                        $insertRow[$field] = $issueTypeArr[$value];
                    }
                    if ($field == 'priority' && isset($priorityArr[$value])) {
                        $value = self::trimSpace($value);
                        $insertRow[$field] = $priorityArr[$value];
                    }
                    if ($field == 'module' && isset($projectModulesArr[$value])) {
                        $insertRow[$field] = $projectModulesArr[$value];
                    }
                    if ($field == 'sprint' && isset($projectSprintsArr[$value])) {
                        $insertRow[$field] = $projectSprintsArr[$value];
                    }
                    if ($field == 'weight') {
                        $insertRow[$field] = max(0, (int)$value);
                    }
                    if ($field == 'assignee' && isset($usersArr[$value])) {
                        $insertRow[$field] = $usersArr[$value];
                    }
                    if ($field == 'reporter' && isset($usersArr[$value])) {
                        $insertRow[$field] = $usersArr[$value];
                    }
                    if ($field == 'assistants') {
                        $valueArr = explode(',', str_replace(';', ',', $value));
                        $assistantsArr = [];
                        foreach ($valueArr as $userName) {
                            if (isset($usersArr[$userName])) {
                                $assistantsArr[] = $usersArr[$userName];
                            }
                        }
                        if (!empty($assistantsArr)) {
                            $insertRow[$field] = implode(',', $assistantsArr);
                        }
                    }
                    if ($field == 'status' && isset($issueStatusArr[$value])) {
                        $value = trimStr($value);
                        $insertRow[$field] = $issueStatusArr[$value];
                    }
                    if ($field == 'resolve' && isset($issueResolveArr[$value])) {
                        $value = self::trimSpace($value);
                        $insertRow[$field] = $issueResolveArr[$value];
                    }
                    if ($field == 'environment' && !empty($value)) {
                        $insertRow[$field] = $value;
                    }
                    if ($field == 'start_date' && !empty($value)) {
                        $toTimestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
                        if ($toTimestamp < strtotime('2000-01-01')) {
                            continue;
                        }
                        $date = date("Y-m-d", $toTimestamp);
                        $insertRow[$field] = date('Y-m-d', strtotime($date));
                    }
                    if ($field == 'due_date' && !empty($value)) {
                        $toTimestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
                        if ($toTimestamp < strtotime('2000-01-01')) {
                            continue;
                        }
                        $date = date("Y-m-d", $toTimestamp);
                        $insertRow[$field] = date('Y-m-d', strtotime($date));
                    }
                    if ($field == 'fix_version') {
                        $valueArr = explode(',', str_replace(';', ',', $value));
                        $fixVersionArr = [];
                        foreach ($valueArr as $v) {
                            if (isset($projectVersionsArr[$v])) {
                                $fixVersionArr[] = $projectVersionsArr[$v];
                            }
                        }
                        if (!empty($fixVersionArr)) {
                            $extraData['fix_version'] = $fixVersionArr;
                        }
                    }
                    if ($field == 'effect_version') {
                        $valueArr = explode(',', str_replace(';', ',', $value));
                        $effectVersionArr = [];
                        foreach ($valueArr as $v) {
                            if (isset($effectVersionArr[$v])) {
                                $effectVersionArr[] = $projectVersionsArr[$v];
                            }
                        }
                        if (!empty($effectVersionArr)) {
                            $extraData['effect_version'] = $effectVersionArr;
                        }
                    }
                    if ($field == 'effect_version') {
                        $valueArr = explode(',', str_replace(';', ',', $value));
                        $effectVersionArr = [];
                        foreach ($valueArr as $v) {
                            if (isset($effectVersionArr[$v])) {
                                $effectVersionArr[] = $projectVersionsArr[$v];
                            }
                        }
                        if (!empty($effectVersionArr)) {
                            $extraData['effect_version'] = $effectVersionArr;
                        }
                    }
                    if ($field == 'labels') {
                        //$value = self::trimSpace($value);
                        $valueArr = explode(',', str_replace(';', ',', $value));
                        $labelArr = [];
                        foreach ($valueArr as $v) {
                            if (isset($projectLabelsArr[$v])) {
                                $labelArr[] = $projectLabelsArr[$v];
                            }
                        }
                        if (!empty($labelArr)) {
                            $extraData['labels'] = $labelArr;
                        }
                    }
                }
                if (isset($insertRow['summary'])) {
                    $insertRow['project_id'] = $projectId;
                    if (isset($insertRow['issue_num'])) {
                        $insertRow['updated'] = time();
                        $insertRows[] = ['cell' => $i, 'add' => [], 'update' => $insertRow, 'extra' => $extraData];
                    } else {
                        $insertRow['pkey'] = $project['key'];
                        $insertRow['created'] = time();
                        $insertRows[] = ['cell' => $i, 'add' => $insertRow, 'update' => [], 'extra' => $extraData];
                    }
                }
            }
        } catch (\Exception $e) {
            return [false, $e->getMessage()];
        }

        //print_r($insertRows);
        return $this->importDataToDb($insertRows);
    }

    /**
     * 去除空格
     * @param $str
     * @return mixed
     */
    public static function trimSpace($str)
    {
        return str_replace(" ", "", trimStr($str));
    }

    /**
     * 导入数据到数据库中
     * @param $insertRows
     * @return array
     * @throws \Exception
     */
    private function importDataToDb($insertRows)
    {
        $issueModel = new IssueModel();
        if (empty($insertRows)) {
            return [false, [], ['empty data']];
        }
        $successRows = [];
        $errorRows = [];
        try {
            $issueModel->db->beginTransaction();
            foreach ($insertRows as $item) {
                $opt = false;
                $issueId = null;
                // 插入数据
                if (!empty($item['add'])) {
                    $opt = true;
                    list($ret, $issueId) = $issueModel->insertItem($item['add']);
                    //var_dump($insertIssueId);
                    if ($ret) {
                        $issueModel->updateItemById($issueId, ['issue_num' => $issueId]);
                    } else {
                        //var_dump($insertIssueId);
                        $errorRows[$item['cell']] = $issueId;
                    }
                }
                // 更新数据
                if (!empty($item['update']) && isset($item['update']['issue_num']) && !empty($item['update']['issue_num'])) {
                    $opt = true;
                    $issueId = $issueModel->getOne('id', ['issue_num' => $item['update']['issue_num']]);
                    //var_dump($issueId);
                    if ($issueId) {
                        list($ret, $insertIssueId) = $issueModel->updateItemById($issueId, $item['update']);
                    } else {
                        $ret = false;
                        $errorRows[$item['cell']] = '编号 ' . $item['issue_num'] . ' 错误，找不到相应的事项';
                    }
                }
                if (!$opt) {
                    continue;
                }
                $successRow = $item['add'] + $item['update'] + $item['extra'];
                $successRow['id'] = $issueId;
                $successRow['cell'] = $item['cell'];
                $successRows[] = $successRow;
                if ($ret && !empty($item['extra'])) {
                    $extraData = $item['extra'];
                    // 协助人
                    if (isset($extraData['assistants'])) {
                        $assistantsModel = new IssueAssistantsModel();
                        $assistantsModel->deleteItemByIssueId($insertIssueId);
                        foreach ($extraData['assistants'] as $userId) {
                            $info = [];
                            $info['user_id'] = $userId;
                            $assistantsModel->insertItemByIssueId($insertIssueId, $info);
                        }
                    }
                    // fix version
                    if (isset($extraData['fix_version'])) {
                        $model = new IssueFixVersionModel();
                        $model->delete(['issue_id' => $insertIssueId]);
                        $this->addChildData($model, $insertIssueId, $extraData['fix_version'], 'version_id');
                    }
                    // effect version
                    if (isset($extraData['effect_version'])) {
                        $model = new IssueEffectVersionModel();
                        $ret = $model->delete(['issue_id' => $insertIssueId]);
                        $this->addChildData($model, $insertIssueId, $extraData['effect_version'], 'version_id');
                    }
                    // labels
                    if (isset($extraData['labels'])) {
                        $model = new IssueLabelDataModel();
                        if (empty($extraData['labels'])) {
                            $model->delete(['issue_id' => $insertIssueId]);
                        } else {
                            $this->addChildData($model, $insertIssueId, $extraData['labels'], 'label_id');
                        }
                    }
                } // end of  if ($ret
            } // end foreach
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            return [false, [], [$e->getMessage()]];
        }

        return [true, $successRows, $errorRows];
    }

    public static $importFields = [
        'issue_num' => '编号',
        'issue_type' => '类型',
        'priority' => '优先级',
        'summary' => '标题',
        'module' => '模块',
        'sprint' => '迭代',
        'summary' => '标题',
        'description' => '描述',
        'weight' => '权重',
        'assignee' => '经办人',
        'reporter' => '报告人',
        'assistants' => '协助人',
        'status' => '状态',
        'resolve' => '解决结果',
        'environment' => '运行环境',
        'start_date' => '开始日期',
        'due_date' => '结束日期',
        'fix_version' => '解决版本',
        'effect_version' => '影响版本',
        'labels' => '标签',
    ];
}
