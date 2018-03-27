<?php

/**
 * 生成批量添加SQL语句，$rows为二维数组。
 * @param string $table 表名
 * @param array $rows 二维数组，要插入的数据
 * @return string
 */
function makeMultiInsertSql($table, $rows) {
    $fieldsArr = array_keys($rows[0]);
    $fieldsStr = '(`' . implode('`,`', $fieldsArr) . '`)';

    $valuesArr = array();
    foreach ($rows  as  $row) {
        $line = array_values($row);
        $valuesArr[] = "('" . implode("','", $line) . "')";
    }
    $valuesStr = implode(',', $valuesArr);
    $sql = "INSERT INTO $table $fieldsStr VALUES $valuesStr";
    return $sql;
}
/**
 * 生成批量替换SQL语句，$rows为二维数组。
 * @param string $table 表名
 * @param array $rows 二维数组，要插入的数据
 * @return string
 */
function makeMultiReplaceSql($table, $rows) {
    $fieldsArr = array_keys($rows[0]);
    $fieldsStr = '(`' . implode('`,`', $fieldsArr) . '`)';

    $valuesArr = array();
    foreach ($rows as   $row) {
        $line = array_values($row);
        $valuesArr[] = "('" . implode("','", $line) . "')";
    }
    $valuesStr = implode(',', $valuesArr);
    $sql = "REPLACE INTO $table $fieldsStr VALUES $valuesStr";
    return $sql;
}


/**
 * sets分析,在插入，更新数据时调用
 *
 * @access private
 * @param mixed $sets
 * @return string
 */
function parseSets($sets)
{
    $setsStr = '';
    if (is_array($sets)) {
        foreach ($sets as $key => $val) {
            $key = addSpecialChar($key);
            $val = fieldFormat($val);
            $setsStr .= "$key=$val,";
        }
        $setsStr = substr($setsStr, 0, - 1);
    } elseif (is_string($sets)) {
        $setsStr = $sets;
    }
    return $setsStr;
}


/**
 * 字段和表名添加` 符合
 * 保证指令中使用关键字不出错 针对mysql
 *
 * @access private
 * @param mixed $value
 * @return mixed
 */
function addSpecialChar(&$value)
{
    if ('*' == $value || '`key`' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos($value, '`')) {
        // 如果包含* 或者 使用了sql方法 则不作处理
    } elseif (false === strpos($value, '`')) {
        $value = '`' . trim($value) . '`';
    }
    return $value;
}


/**
 * 字段格式化
 *
 * @access private
 * @param mixed $value
 * @return mixed
 */
function fieldFormat(&$value)
{
    if (is_int($value)) {
        $value = intval($value);
    } elseif (is_float($value)) {
        $value = floatval($value);
    } elseif (preg_match('/^\(\w*(\+|\-|\*|\/)?\w*\)$/i', $value)) {
        // 支持在字段的值里面直接使用其它字段
        // 例如 (score+1) (name) 必须包含括号
        // $value = $value;
    } elseif (is_string($value)) {
        $value = '\'' . escapeString($value) . '\'';
    }

    if (is_null($value)) {
        $value = "''";
    }

    return $value;
}

