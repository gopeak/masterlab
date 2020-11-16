<?php

echo (time()."\n");
echo (date('Y-m-d H:i:s')."\n");

file_put_contents('./test.log', date('Y-m-d H:i:s')."\n", FILE_APPEND);


sleep(100);
