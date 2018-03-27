<?php

 
/**
 * 数组操作辅助方法.
 */
class ArrayHelper
{
    /**
     * 获取列表行某个字段名对应的值.
     * @param array $list 数据行，每行都含有$field字段名.
     * @param string $field 字段名.
     * @return array 返回字段值数组，找不到对应字段名就返回空数组.
     */
    public static function getListRowField($list, $field)
    {
        $res = [];
        // 不使用isset($list[0][$field])判断，因为$list可能是关联数组
        if (is_array($list) && count($list)){
            $first = pos($list);
            if (isset($first[$field])){
                foreach ($list as $row){
                    $res[] = trim($row[$field]);
                }
                $res = array_unique($res);
            }
        }
        return $res;
    }

    /**
     * 从列表获取某个字段等于指定值的行.
     * @param $list 列表.
     * @param $field 字段名，找到这个字段名，再比对$value.
     * @param $value $field字段需要匹配的值.
     * @return array|mixed 返回$list中$field字段值等于$value的行.找不到就返回空数组.
     */
    public static function getRowFromListByField($list, $field, $value)
    {
        $res = [];
        // 不使用isset($list[0][$field])判断，因为$list可能是关联数组
        if (is_array($list) && count($list)){
            $first = pos($list);
            if (isset($first[$field])){
                foreach ($list as $row){
                    if (strcmp(trim($row[$field]), trim($value)) == 0){
                        $res = $row;
                        break;
                    }
                }
            }
        }
        return $res;
    }

    /**
     * 以第一个元素为key，第二个元素为value，将列表行转为"key=>value"数组.
     * @param $list 列表行.
     * @return array
     */
    public static function wrapListRowAsLine($list)
    {
        $res = [];
        if (is_array($list) && count($list)){
            foreach ($list as $row){
                $key = pos($row);
                $value = next($row);
                $res[$key] = $value;
            }
        }
        return $res;
    }

    /**
     * 验证是否整数或整数列表.
     * @param $list 整数、整数数组或者用逗号分隔的整数字符串.
     * @return bool
     */
    public static function validateIntList($list)
    {
        if (!is_array($list)){
            $list = explode(',', $list);
        }
        $intPattern = '/^\s*[+-]?\d+\s*$/';
        $foundInvalidItem = false;
        foreach ($list as $id){
            if (!preg_match($intPattern, $id)){
                $foundInvalidItem = true;
                break;
            }
        }
        return !$foundInvalidItem;
    }

    /**
     * 验证元素是否在列表中.
     * @param $id 元素.
     * @param $list 列表.
     * @return bool
     */
    public static function validateInsideList($id, $list)
    {
        if (!is_array($list)){
            $list = explode(',', $list);
        }
        return in_array($id, $list);
    }
}