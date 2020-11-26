#获取主域名(网站名称)
domain=$1

#获取配置文件位置
config_file=/www/server/panel/vhost/nginx/${domain}.conf
#获取PHP版本
php_version=$(cat $config_file|grep 'enable-php'|grep -Eo "[0-9]+"|head -n 1)

php_bin=/www/server/php/$php_version/bin/php

root_path=$(pwd)
$php_bin $root_path/replace.php
