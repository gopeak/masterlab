<?php
require 'sphinxapi.php';
$cl = new SphinxClient();
$cl->SetServer('127.0.0.1', 9312); //注意这里的主机
#$cl->SetMatchMode(SPH_MATCH_EXTENDED); //使用多字段模式
//dump($cl);
$keyword = '中文';
$index = "issue";
$res = $cl->Query($keyword, $index);
$err = $cl->GetLastError();
print_r($res);
if (!$res) {
    var_dump($err);
}
	 
