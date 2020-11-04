### 宝塔一键安装包制作

1. 把项目文件全部复制到一个新目录（不要复制.git、.github、.idea这三个目录）
2. 删除不必要的文件，比如`vendor.zip`
3. 删除 `/public/install/lock` 文件
4. 把 `/database.cfg.php` 剪切到 `/app/config/database.cfg.php`，覆盖
5. 把 `/public/install/data/main.sql` 复制到 `/import.sql`
6. 选择全部文件，右键，压缩成`zip`文件
7. 上传到宝塔
8. 测试

### 宝塔用到的相关文件
```
/auto_install.json      自动安装脚本
/.htaccess              Apache重写规则
/.nginx.rewrite         Nginx重写规则
/database.cfg.php       含有变量的数据库配置文件
/import.sql             数据库安装SQL脚本，拷贝自/app/public/install/data/main.sql
/composer.json          如果没有composer.lock，将使用composer.json安装composer包
```