<?php

/**
 * 输出excel的cell列字母头 ['A','B','C','D',...,'AA','AB','AC',...,'AZ']
 * @return array
 */
function excelCell()
{
    $letterArr = [];
    foreach (range('A', 'Z') as $letter) {
        $letterArr[] = $letter;
    }

    foreach (range('A', 'Z') as $letter) {
        $letterArr[] = 'A'.$letter ;
    }
    return $letterArr;
}

/**
 * 导出excel, 由于功能受限，未采用该方法
 * @param array $rowsData
 * @param array $tableHeader 如：['ID','事项','状态','报告人','创建时间'];
 * @param string $fileName
 * @param string $title
 * @return bool
 */
function excelData(array $rowsData, array $tableHeader, $fileName = 'output.xls', $title = '')
{
    if (empty($tableHeader)) {
        return false;
    }

    if (!empty($title)) {
        $colspan = count($tableHeader);
        $title = '<tr style="height:35px;border-style:none;background-color: #66B3FF;"><td border="0" style="height:50px;width:1800px;color: #FFFFFF;font-size:18px;text-align:center" colspan="' . $colspan . '" >' . $title . '</th></tr>';
        unset($colspan);
    }

    $headerStr = $title . "<tr>";
    foreach ($tableHeader as $v) {
        $headerStr .= "<td>$v</td>";
    }
    $headerStr .= "</tr>";

    $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
    $str .="<table border=1>" . $headerStr;
    $str .= '';
    if (!empty($rowsData)) {
        foreach ($rowsData as $key => $row) {
            $str .= "<tr>";
            foreach ($row as $v) {
                $str .= "<td >{$v}</td>";
            }
            $str .= "</tr>\n";
        }
    }

    $str .= "</table></body></html>";
    $str .= "<span>Creator: Masterlab</span>";
    header("Content-Type: application/vnd.ms-excel; name='excel'");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . date("Y-m-d") . "-" . $fileName);
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    exit($str);

}

