单元测试运行说明

全部测试用例执行：
1.命令行模式下进入app\test目录
2.执行
    phpunit --bootstrap ./bootstrap.php --configuration ./phpunit.xml  --coverage-clover=coverage.xml

单个测试文件运行示例:
1.命令行模式下进入b2b\test目录
2.执行

phpunit --bootstrap ./bootstrap.php requirement/TestEnv.php  --coverage-clover=../../coverage.xml
