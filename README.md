
<p align="center">
  <a href="http://www.masterlab.vip ">
    <img width="200" src="http://www.masterlab.vip/Images/logo_orange.png">
  </a>
</p>

<h1 align="center">MasterLab </h1>

<div align="center">

MasterLab是一款简单高效、基于敏捷开发的项目管理工具，以事项驱动和敏捷开发最佳实践作为设计思想，同时参考了Jira和Gitlab优秀特性发展而来，适用于互联网团队进行高效协作和敏捷开发，交付极致卓越的产品。

[![Travis branch](https://travis-ci.org/gopeak/masterlab.svg?branch=master)](https://travis-ci.org/gopeak/masterlab)
![](https://img.shields.io/travis/php-v/gopeak/masterlab.svg)
![](https://img.shields.io/github/languages/code-size/gopeak/masterlab.svg)
![](https://img.shields.io/github/commit-activity/y/gopeak/masterlab.svg)
[![codecov](https://codecov.io/gh/gopeak/masterlab/branch/master/graph/badge.svg)](https://codecov.io/gh/gopeak/masterlab)
</div>


## 功能特点
- 简单易用,拥有良好的用户体验和扁平化风格
- 创新的将思维导图和项目事项进行整合，让项目管理更轻松
- 重视质量,服务器端代码(php)遵循PSR2标准规范,编写单元和功能测试
- 支持敏捷开发(待办事项列表，迭代冲刺，看板)
- Masterlab团队本身践行敏捷开发最佳实践(迭代开发,单元测试,持续集成,自动化部署),树立开发极致产品的典范
- 项目管理,包含事项,迭代,看板,统计,图表,设置功能
- 基于事项驱动，用它管理项目，跟踪bug，新功能，任务，优化改进等,提高团队协作效率
- 支持整个项目或迭代的甘特图计划
- 可定制的状态状态流和界面
- 直观数据统计和图表，可以随时了解项目和迭代的进展 


## **在线演示**

http://demo.masterlab.vip
账号 master 密码 testtest


## **安装**

详细的安装示例  

[Windows安装教程](http://www.masterlab.vip/help.php?md=install-windows "Windows安装教程")  
[Linux安装示例](http://www.masterlab.vip/help.php?md=install-linux "Linux安装教程")  
[Linux 宝塔安装示例](http://www.masterlab.vip/help.php?md=install-linux-bt "基于宝塔(bt.cn)的安装教程")  

本质上的安装步骤如下:  

 1. 搭建php的运行环境 
     ```
     - Web Server : Nginx 或 Apache
     
     - Php
       - 版本 >= 7.0
       - 必备扩展 ：curl,mysqlnd,pdo,mysqli,mbstring
       - php.ini   修改 upload_max_filesize = 8M
       - php.ini   修改 post_max_size = 8M
       - php.ini   修改 memory_limit = 128M  
       - php.ini   修改 max_execution_time = 30  
       
     - Mysql
       - 版本 >= 5.7
     
     -  masterlab\app\storage 目录要求写入权限
     -  masterlab\app\public\attachment 目录要求写入权限
     -  masterlab\app\public\install 目录要求写入权限
     ```
 2. 下载代码，将根目录的运行依赖库`vendor.zip`解压出来  
       ```text
         - masterlab
           - vendor
               - autoload.php 
       ```
 3. 在web服务器添加虚拟主机并映射到masterlab的 app/public 目录  
    如果Web服务器是Apache,首先编辑主配置文件`httpd.conf`将  
      ```
      <Directory />
          AllowOverride none
          Require all denied
      </Directory>
      ```
      替换为  
      ```
      <Directory />
        Options FollowSymLinks
        AllowOverride All
        #Allow from All
      </Directory>
      ```
      找到 `httpd-vhosts.conf` 文件，添加：  
      ```text
      <VirtualHost *:80>
        # 请更改为实际的masterlab目录
        DocumentRoot "c:/phpenv/www/masterlab/app/public"
        # 这里使用的是示例域名，你可以更改为你的域名
        ServerName  www.yoursite.com
        <Directory />
            Options Indexes FollowSymLinks
            AllowOverride All
            #Allow from All
        </Directory>
        # 请更改为实际的masterlab目录
        <Directory "c:/phpenv/www/masterlab/app/public">
            Options  Indexes FollowSymLinks
            AllowOverride All
            #Order allow,deny
            #Allow from All
        </Directory>
      </VirtualHost>
    ```
     如果Web服务器是Nginx  
    ```nginx
    server {
        listen 80;
        # 这里使用的是示例域名，你可以更改为你的域名
        server_name www.yoursite.com;
        # masterlab的入口访问路径,请更改为实际的masterlab目录
        root /data/www/masterlab/app/public;
        index index.html index.htm index.php; 
        gzip on;
        gzip_min_length 1k;
        gzip_buffers 4 16k;
        #gzip_http_version 1.0;
        gzip_comp_level 2;
        gzip_types  application/javascript  text/plain application/x-javascript  application/json  text/css application/xml text/javascript application/x-httpd-php;
        gzip_vary off;
        gzip_disable "MSIE [1-6]\.";
        location ~* \.(jpg|jpeg|gif|png|ico|swf)$ {
            expires 3y; 
            access_log off; 
            # gzip off;
        }
        location ~* \.(css|js)$ {
            access_log off;
            expires 3y;
        }
        location ~ ^/files/.*\.(php|php5)$ {
            deny all;
        } 
        location ~ ^/attachment/.*\.(php|php5)$ {
            deny all;
        }
        location  /{
            if (!-e $request_filename) {
                    rewrite ^/((?!upload).*)$ /index.php/$1 last;
                    break;
             }
        }
        location ~ \.php {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
         }
    }
    
    ```

 4. 重启web服务器  

 5. 运行 masterlab_socket  
    masterlab_socket 是用于执行异步任务和定时计算事项的后台程序,该步骤可省略, 下载地址 https://github.com/gopeak/masterlab_socket/releases  
    
     Windows操作系统的
     ```text
    # 在masterlab目录直接运行
    bin/masterlab_socket.exe
    ```
     Linux操作系统的
     ```text
    # 在masterlab目录直接运行
    chmod +x bin/masterlab_socket
    ./bin/masterlab_socket
    ```
     其他操作系统 参考 https://github.com/gopeak/masterlab_socket 的文档自行编译  
     
 6. 在浏览器访问 /install ,根据提示进行安装  
 
 
## **更多文档**
http://www.masterlab.vip/help.php


## 截 图
![首页](http://www.masterlab.vip/fireshot/index2.png "首页")
![事项列表](http://www.masterlab.vip/fireshot/issue.png "事项列表")
![看板](http://www.masterlab.vip/fireshot/kanban.png "看板")
![WBS](http://www.masterlab.vip/fireshot/wbs.jpg "思维导图与事项整合")


在使用中有任何问题，请使用以下联系方式联系我们


QQ技术支持群: 314155057 https://jq.qq.com/?_wv=1027&k=51oDG9Z







 
