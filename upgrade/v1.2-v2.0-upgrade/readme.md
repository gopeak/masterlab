Masterlab  v1.2 升级到 v2.0 脚本  

1.找到 php 执行文件的路径, linux 一般是 `/usr/bin/php`, windows 搜索一下 `php.exe`   

2.将 `v1.2-v2.0-upgrade.zip` 解压到 `masterlab/upgrade` 目录下，确保 `upgrade.php` 文件的路径为 `masterlab/upgrade/v1.2-v2.0-upgrade/upgrade.php`    

3.进入命令行程序, cd 到 `masterlab/upgrade/v1.2-v2.0-upgrade/` 根录下，执行 `php ./upgrade.php`  

4.修改web服务器的配置：nginx的要移除掉如下配置    
nginx的要移除掉attachment别名，如下面的配置   
```text
	location ^~ /attachment/ {
		root  /data/www/masterlab/app/storage/;
	}
```

Apache的要移除attachment别名，如下面的配置  
```text
   Alias /attachment "d:/www/masterlab/app/storage/attachment"   
```
  
5.最后重启web服务器  




