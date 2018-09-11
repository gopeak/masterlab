# Masterlab

MasterLab是用php开发的基于项目管理和缺陷跟踪的软件，参考了Jira和Gitlab一些优秀特性发展而来，
主要功能有组织 项目 事项 敏捷Backlog Kanban 工作流 自定义字段等

## 功能点
- 扁平化风格
- 良好的交互体验
- 多组织管理
- 多项目管理
- 项目模块，版本，标签，自定义角色
- 基于项目事项的推进
- 项目不同类型的事项方案
- 事项类型: bug，新功能，任务，子任务，优化改进，用户故事，史诗任务，技术任务
- 工作流
- 自定义事项的创建和编辑界面
- 待办事项列表
- 迭代事项冲刺
- 项目数据统计和图表
- 迭代数据和图表
- 看板

## windows apache 安装 
1. 要求

```
git v2.1 +
php v7.1 +
phpunit v7.0
composer v1.6.0 +
```

3. 在git命令行界面执行

```
mkdir /c/www/ 
git clone git@github.com:gopeak/hornet-framework.git
git clone git@github.com:gopeak/masterlab.git
cd masterlab
git checkout -b master
git pull origin master
composer update
```

4. 修改 apache  httpd.conf
```
<Directory />
    Options FollowSymLinks
    AllowOverride All      
    Allow from All  
</Directory>
```
5. apache 的 httpd-vhosts.conf 加入
```
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
```

6.修改 hosts
```
127.0.0.1 masterlab.ink
```
7. 开发环境设置
```
  cp -f /c/www/masterlab/env.ini-example /c/www/masterlab/env.ini
```
8. 修改数据库配置
```
  /c/www/masterlab/app/config/development/database.cfg.php
```  


 
