<?php
 
/**
 *
 */
class ExcelHelper
{
    private $_range;

    public function __construct()
    {
        $this->_range = range('A', 'Z');
    }

    /**
     * 下载excel文件.
     * @param $file 文件路径.
     * @param string $filename 下载后文件名.
     */
    public function download($file, $filename='')
    {
        if (!file_exists($file)){
            throw new \Exception("文件 {$file} 不存在.");
        }

        if (empty($filename)){
            $filename = pathinfo($file, PATHINFO_BASENAME);
        }

        $content = file_get_contents($file);
        $size = filesize($file);
        header("Content-Type:application/octet-stream;charset=utf-8");
        header("Accept-Ranges: bytes");
        header("Accept-Length: $size");
        header("Content-Disposition:attachment;filename={$filename}");
        header("Pragma:no-cache");
        header("Expires:0");
        echo $content;
    }

    /**
     * 生成由时间和随机数组成的文件名.
     * @param $prefix 文件名前缀.
     * @param $ext 文件名扩展.
     * @return string
     */
    public function generateDateRandFileName($prefix, $ext)
    {
        return $prefix . date('YmdHis_') . rand() . '.' . $ext;
    }

    /**
     * 生成指定的字母范围（二级）.
     * @param $end 字母范围的最后字母字符串.
     * @param bool $asOneRange 是否将返回结果当做一个范围返回，true表示是，false表示否，默认是true.
     * @return array
     * @throws \Exception
     */
    public function generateColumnRange($end, $asOneRange=true)
    {
        $end = strtoupper(trim($end));
        $len = strlen($end);

        if ($len == 1){
            // 只有一级，直接生成字母范围
            return range('A', $end);
        }elseif ($len == 2){
            // 两级
            $rows = [];

            $first = $end[0];
            $firstRange = range('A', $first);
            $firstRangeLen = count($firstRange);
            $maxIndex = $firstRangeLen-1;
            $second = $end[1];
            for($i=-1; $i<$firstRangeLen; $i++){
                if ($i==-1){
                    $rows[] = $this->assignCharToRange();
                }elseif($i==$maxIndex){
                    $rows[] = $this->assignCharToRange($firstRange[$i], $second);
                }else{
                    $rows[] = $this->assignCharToRange($firstRange[$i]);
                }
            }

            if ($asOneRange){
                // 合成一个范围
                $res = [];
                foreach ($rows as $row){
                    $res = array_merge($res, $row);
                }
                return $res;
            }else{
                return $rows;
            }
        }else{
            throw new \Exception('参数1必须是1或2位英文字母');
        }
    }

    /**
     * 生成指定的字母范围（一级），并将另一个字母拼接到范围中的每一个字母上.
     * 例如，将字母B附加到[A,B,C]，得到结果[BA,BB,BC].
     * @param $char 需要拼接的字母.为空表示直接返回字母范围.
     * @param null $endChar 字母范围的最后一个字母.
     * @return array
     * @throws \Exception
     */
    public function assignCharToRange($char=null, $endChar=null)
    {
        if ($char!==null && !$this->checkChar($char)){
            throw new \Exception('参数1必须是英文字母');
        }

        if ($endChar===null){
            $endChar = 'Z';
        }elseif (!$this->checkChar($endChar)){
            throw new \Exception('参数2必须是英文字母');
        }

        $range = range('A', $endChar);
        if ($char!=null){
            foreach ($range as $index => $item){
                $range[$index] = $char . $item;
            }
        }
        return $range;
    }

    /**
     * 检查是否字母.
     * @param $char 待检查的字符.
     * @return bool
     */
    public function checkChar($char)
    {
        $char = strtoupper($char);
        return in_array($char, $this->_range);
    }

    /**
     * 通过索引数字获取对应的字符编码，只支持二级字母范围.
     * @param $index 索引数字整数.将整个字符范围看做是索引数字从[0,675]的数组.
     * @return string 返回索引数字对应的字符编码.
     * @throws \Exception
     */
    public function getCharByIndex($index)
    {
        if ($index <0 || !is_int($index) || ($index > 675)){
            throw new \Exception('参数1必须是介于[0,675]的整数');
        }

        if ($index <= 25){
            // 一级
            return $this->_range[$index];
        }else{
            // 两级
            $q = floor($index / 26);
            $r = $index % 26;
            if ($r == 0){
                return $this->_range[$q-1];
            }else{
                return $this->_range[$q-1] . $this->_range[$r];
            }
        }
    }

    /**
     * 获取excel数据.
     * @param $sheet
     * @param $columnList
     * @return array 返回数组的title是表头数据，data是数据行.每个单元格的数据都做了去除空白符处理（trim()），因此返回值都是字符串.
     */
    public function getRangeData($sheet, $columnList)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumnLen = count($columnList);

        // 读取表头
        $title = [];
        for ($j=0; $j<$highestColumnLen; $j++){
            $c = $columnList[$j];
            $value = $sheet->getCell($c.'1')->getValue();
            if (is_object($value)){
                $value = $value->getPlainText();
            }

           $title[$c] = trim($value);
        }

        // 读取数据行
        // PHPExcel5比PHPExcel2007的highestRow小1，因此这里$i<=$highestRow
        $data = [];
        for ($i=2; $i<=$highestRow; $i++){
            $data_row = [];
            for ($j=0; $j<$highestColumnLen; $j++){
                $c = $columnList[$j];
                $value = $sheet->getCell($c.$i)->getValue();
                if (is_object($value)){
                    $value = $value->getPlainText();
                }

               $data_row[$c] = trim($value);
            }

            // 遇到空行停止读取
            if ($this->validateEmptyRow($data_row)){
                break;
            }else{
                $data[$i] = $data_row;
            }
        }

        return ['title'=>$title, 'data'=>$data];
    }

    /**
     * 验证是否空行.
     * @param $row
     * @return bool
     */
    public function validateEmptyRow($row)
    {
        $is_empty_row = true;
        foreach ($row as $value){
            if ($value !== null){
                $is_empty_row = false;
            }
        }
        return $is_empty_row;
    }
}
















