# 开发指南
## 开发框架
>Masterlab使用Hornet-framework框架进行开发的，Hornet-framework是一个高性能,轻量级,易于上手,功能完备的PHP LMVC 开发框架。 LMVC分别是 Logic逻辑 Model模型 View视图 Ctrl控制器，与传统的MVC框架比多一层Logic层，目的是解决在复杂的应用系统时，逻辑代码混杂于Model或Ctrl之间的问题。


1. 要求
git v2.1 +
php v7.1 +
phpunit v7.0
composer v1.6.0 +

## 配置开发环境
```

mkdir /c/www/
cd /c/www/
git clone git@github.com:gopeak/hornet-framework.git
git clone git@github.com:gopeak/masterlab.git
cd masterlab
git checkout -b dev
git pull origin dev
composer update

#修改 apache  httpd.conf

<Directory />
    Options FollowSymLinks
    AllowOverride All
    Allow from All
</Directory>

#apache 的 httpd-vhosts.conf 加入

<VirtualHost *:80>
    DocumentRoot "c:/www/masterlab/app/public"
    ServerName  masterlab.ink

    <Directory />
        Options Indexes FollowSymLinks
        AllowOverride All
        Allow from All
    </Directory>
    <Directory "c:/www/masterlab/app/public">
        Options  Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from All
    </Directory>

	Alias /attachment "c:/www/masterlab/app/storage/attachment"
	<Directory "c:/www/masterlab/app/storage/attachment">
		Options Indexes FollowSymLinks
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>


#修改 hosts

127.0.0.1 masterlab.ink

#开发环境设置
  cp -f /c/www/masterlab/env.ini-example /c/www/masterlab/env.ini
  cp -rf  /c/www/masterlab/app/config/deploy /c/www/masterlab/app/config/development

8. 数据库
  vim /c/www/masterlab/app/config/development/database.cfg.php






```

## Masterlab的目录结构
```
    vendor 为composer的第三方类库
    lib  为非vendor的第三方类库
    app 为项目代码
      |--   app/classes  为逻辑实现类
      |--   app/config   为配置文件目录，有部署 开发不同的配置可切换
      |--   app/ctrl     控制器目录，用于编写流程控制
      |--   app/function 为函数存放目录
      |--   app/model    为模型类，主要用于数据库 缓存 IO 等交互
      |--   app/public   为网站访问到目录，入口文件在此，可存放静态文件
      |--   app/api      为api接口的控制器类
      |--   app/storage  为存储目录,可存放临时文件 上传文件 大数据等
      |--   app/test     测试相关目录,采用bdd自动测试框架
      |--   app/view     视图层
      |--   app/server   异步，队列,定时执行的服务代码
```



