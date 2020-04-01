### 宝塔一键安装包制作

1. 把项目文件全部复制到一个新目录（不要复制.git、.github、.idea这三个目录）
2. 删除不必要的文件，比如`vendor.zip`
3. 删除 `/app/public/install/lock` 文件
4. 把 `/database.cfg.php` 剪切到 `/app/config/deploy/database.cfg.php`，覆盖
5. 把 `/app/public/install/data/main.sql` 复制到 `/import.sql`
6. 选择全部文件，右键，压缩成`zip`文件
7. 上传到宝塔
8. 测试