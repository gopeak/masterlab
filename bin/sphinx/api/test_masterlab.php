<?php

require './sphinxapi.php';
$s = new SphinxClient;
$s->setServer("127.0.0.1", 9312);

//$s->setMatchMode(SPH_MATCH_ANY);


$s->setMaxQueryTime(30);
$s->SetLimits(0,4);
$res3 = $s->Query('款式', 'issue');


$err = $s->GetLastError();
print_r($res3);

//var_dump(array_keys($res['matches']));
// echo "<br>"."通过获取的ID来读取数据库中的值即可。"."<br>";

echo "---------------------------------------\n";

$match3 = !empty($res3['matches']) ? $res3['matches'] : "";

print_r($match3);

if (!empty($err)) {
    print_r($err);
}

$s->close();
