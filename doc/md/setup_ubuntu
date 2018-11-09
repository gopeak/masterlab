0. **Ubuntu版本**

18.04

***

1. **准备**


    1. 替换系统源,用下面内容替换掉 /etc/apt/sources.list 这个文件
    ```
    deb http://mirrors.163.com/ubuntu/ bionic main restricted universe multiverse
    deb http://mirrors.163.com/ubuntu/ bionic-security main restricted universe multiverse
    deb http://mirrors.163.com/ubuntu/ bionic-updates main restricted universe multiverse
    deb http://mirrors.163.com/ubuntu/ bionic-proposed main restricted universe multiverse
    deb http://mirrors.163.com/ubuntu/ bionic-backports main restricted universe multiverse
    deb-src http://mirrors.163.com/ubuntu/ bionic main restricted universe multiverse
    deb-src http://mirrors.163.com/ubuntu/ bionic-security main restricted universe multiverse
    deb-src http://mirrors.163.com/ubuntu/ bionic-updates main restricted universe multiverse
    deb-src http://mirrors.163.com/ubuntu/ bionic-proposed main restricted universe multiverse
    deb-src http://mirrors.163.com/ubuntu/ bionic-backports main restricted universe multiverse
    ```

    2. 依次执行
    ```
    apt-get update
    apt-get upgrade
    apt-get install -y software-properties-common
    apt-get install -y vim wget
    ```


***

2. **安装php**


- 添加PPA源
```
add-apt-repository ppa:ondrej/nginx
按回车继续
add-apt-repository ppa:ondrej/php
按回车继续
```
- apt-get安装php
```
apt-get install -y php7.2

apt-get install -y php7.2-bcmath\
 php7.2-bz2\
 php7.2-dba\
 php7.2-enchant\
 php7.2-fpm\
 php7.2-imap\
 php7.2-interbase\
 php7.2-intl\
 php7.2-mbstring\
 php7.2-phpdbg\
 php7.2-soap\
 php7.2-sybase\
 php7.2-xsl\
 php7.2-zip\
 php7.2-xmlrpc\
 php7.2-xml\
 php7.2-tidy\
 php7.2-sqlite3\
 php7.2-snmp\
 php7.2-recode\
 php7.2-readline\
 php7.2-pspell\
 php7.2-pgsql\
 php7.2-opcache\
 php7.2-odbc\
 php7.2-mysql

apt-get install -y php7.2-ldap\
 php7.2-json\
 php7.2-gmp\
 php7.2-gd\
 php7.2-dev\
 php7.2-curl\
 php7.2-common\
 php7.2-cli\
 php7.2-cgi
```
- 查看版本
```
php7.2 -v
php-fpm7.2 -v
```

- 启动php-fpm
```
service php7.2-fpm start
或
systemctl status php7.2-fpm.service
```


***

3. **安装nginx**


- 安装命令
```
apt-get install nginx
```

- 编辑配置以支持PHP-FPM
修改这个文件  vi /etc/nginx/sites-enabled/default
```

location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.2-fpm.sock;
}
```

- 启动nginx
```
systemctl start nginx.service
或
service nginx start
```



***

4. **安装mysql**


- 安装
```
wget https://repo.percona.com/apt/percona-release_0.1-6.$(lsb_release -sc)_all.deb
dpkg -i percona-release_0.1-6.$(lsb_release -sc)_all.deb
apt-get update
apt-get install percona-server-server-5.7
```
- 停止mysql
```
systemctl stop mysql.service
```
- 取消mysql的严格模式和新增对ngram的支持

修改配置文件/etc/mysql/percona-server.conf.d/mysqld.cnf

替换掉sql_mode的值和新增ngram_token_size
```
sql_mode=NO_ENGINE_SUBSTITUTION,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER
ngram_token_size=2
```
- 启动mysql
```
systemctl start mysql.service
```



***

5. **安装redis**


- 安装命令
```
apt-get install redis-server
```
- 启动redis
```
systemctl start redis.service
```