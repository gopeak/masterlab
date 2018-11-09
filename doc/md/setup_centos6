centos下推荐使用yum包管理器来安装软件

### 为yum设置软件源

1. 备份
```
mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
```

2. 下载新的CentOS-Base.repo 到/etc/yum.repos.d/

```
curl -o /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-6.repo
```
3、之后运行yum makecache生成缓存

### 安装企业级linux扩展源epel
```
yum install epel-release
```

### 安装webtatic源
对centos系统不太熟练的同学，这里推荐使用webtatic来安装php
```
rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
```

### Nginx安装
```
yum install nginx
```


### Mysql5.7安装
推荐使用Percona来安装mysql
1. 安装Percona的yum源
```
yum install http://www.percona.com/downloads/percona-release/redhat/0.1-6/percona-release-0.1-6.noarch.rpm
```
2. 测试一下Percona的yum源
```
yum list | grep percona
```
你会看到如下：
```
...
Percona-Server-57-debuginfo.x86_64      5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-client-57.x86_64         5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-devel-57.x86_64          5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-server-57.x86_64         5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-shared-57.x86_64         5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-shared-compat-57.x86_64  5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-test-57.x86_64           5.7.10-3.1.el7                 @percona-release-x86_64
Percona-Server-tokudb-57.x86_64         5.7.10-3.1.el7                 @percona-release-x86_64
...
```

3. 安装Percona Server
```
yum install Percona-Server-server-57
```

4. 停止mysql服务
```
systemctl stop mysql.service
```
5. 取消mysql的严格模式和新增对ngram的支持
修改配置文件/etc/mysql/percona-server.conf.d/mysqld.cnf
替换掉
```
sql_mode=NO_ENGINE_SUBSTITUTION,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER
ngram_token_size=2
```
6. 启动mysql
```
systemctl start mysql.service
```

### Redis安装
```
yum install redis
```

### PHP安装

```
yum install mod_php71w php71w-bcmath php71w-cli php71w-common php71w-dba php71w-devel php71w-embedded php71w-enchant php71w-fpm php71w-gd php71w-imap php71w-interbase php71w-intl php71w-ldap php71w-mbstring php71w-mcrypt php71w-mysqlnd php71w-odbc php71w-opcache php71w-pdo php71w-pear php71w-pecl-apcu php71w-pecl-imagick php71w-pecl-memcached php71w-pecl-mongodb php71w-pecl-redis php71w-pecl-xdebug php71w-pgsql php71w-phpdbg php71w-process php71w-pspell php71w-recode php71w-snmp php71w-soap php71w-tidy php71w-xml php71w-xmlrpc
```


