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
use main\app\model\issue\IssueDescriptionTemplateModel;
use main\app\model\issue\IssueModel;

/**
 * 事项逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class IssueLogic
{
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
}
