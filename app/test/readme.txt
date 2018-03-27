单元测试运行说明

全部测试用例执行：
1.命令行模式下进入app\test目录
2.执行
    php ../../phpunit.phar --bootstrap ./bootstrap.php --configuration ./phpunit.xml

单个测试文件运行示例:
1.命令行模式下进入b2b\test目录
2.执行

    php ../../phpunit.phar --bootstrap ./bootstrap.php require/testEnv.php


