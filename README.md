# Masterlab

MasterLab是用php开发的基于项目管理和缺陷跟踪的软件，参考了Jira和Gitlab一些优秀特性发展而来，
主要功能有组织 项目 事项 敏捷Backlog Kanban 工作流 自定义字段等

## 功能点
 
 
## 安装 
1. 要求
git v2.1 +
php v7.1 +
phpunit v7.0
composer v1.6.0 +



3. 在git命令行界面执行
mkdir /c/www/
cd /c/www/
git clone git@github.com:gopeak/hornet-framework.git
git clone git@github.com:gopeak/masterlab.git
cd masterlab
git checkout -b dev
git pull origin dev
composer update

4. 修改 apache  httpd.conf

<Directory />
    Options FollowSymLinks
    AllowOverride All      
    Allow from All  
</Directory>

5. apache 的 httpd-vhosts.conf 加入

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


6.修改 hosts

127.0.0.1 masterlab.ink

7. 开发环境设置
  cp -f /c/www/masterlab/env.ini-example /c/www/masterlab/env.ini
  cp -rf  /c/www/masterlab/app/config/deploy /c/www/masterlab/app/config/development
  
8. 数据库
  vim /c/www/masterlab/app/config/development/database.cfg.php
  








 
## 第二次里程碑Todo

1. 跟进不同角色有不通的 UI和交互
2. 首页可以自定义面板
3. 创建事项时,提供描述模板供用户选择
4. 增加一个便签功能，类似 http://www.jq22.com/yanshi19271
5. 使用Hopscotch进行友好提示 http://www.jq22.com/yanshi215
6. 参考 hotjar 功能,网页热图、鼠标轨迹记录、转换漏斗(识别访问者离开)、表单分析、反馈调查、收集反馈、问卷、等
7. 帮助界面参考 https://ned.im/noty/
