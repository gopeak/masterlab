<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;

/**
 * 检查那些继承于DbModel的类是否属性设置正确
 * Class testAllExtendDbModelProperty
 * @package main\app\test\unit\model
 */
class TestAllExtendDbModelProperty extends TestCase
{

    public static $modelFileInfo = [];

    public static function setUpBeforeClass()
    {
        static::getModelFiles(MODEL_PATH);
    }

    /**
     * 获取所有的Model类
     * @param $dir
     */
    public static function getModelFiles($dir)
    {
        $currentDir = dir($dir);

        while ($file = $currentDir->read()) {
            if ((is_dir($dir . $file)) and ($file != ".") and ($file != "..")) {
                static::getModelFiles($dir . $file . '/');
            } else {
                $modulePath = str_replace(MODEL_PATH, '', $dir);
                $modulePath = str_replace('/', "\\", $modulePath);
                $file = pathinfo($file);
                if ($file['extension'] = 'php'
                    && strpos($file['basename'], 'Model') !== false
                    && !in_array($file['basename'], ['BaseModel', 'DbModel'])
                ) {
                    static::$modelFileInfo[] = $modulePath . $file['basename'];
                }
            }
        }

        $currentDir->close();
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 检查 table fields primaryKey 是否设置正确
     */
    public function testModel()
    {
        $excludes = ['CacheModel', 'DbModel', 'BaseDictionaryModel', 'user\BaseUserItemModel', 'user\BaseUserItemsModel',"issue\BaseIssueItemsModel", "issue\BaseIssueItemModel"];
        //SHOW TABLES LIKE 'test_user';
        if (!self::$modelFileInfo) {
            return;
        }

        $sql = '';
        try {
            foreach (self::$modelFileInfo as $modelName) {
                $modelName = str_replace('.php', '', $modelName);
               // var_dump($modelName);
                if (in_array($modelName, $excludes)) {
                    continue;
                }
                // require_once MODEL_PATH.$modelName.'.php';
                $modelClass = sprintf("main\\%s\\model\\%s", APP_NAME, $modelName);
                //var_dump($model_class);
                if (!class_exists($modelClass)) {
                    $this->fail('class ' . $modelName . ' no found');
                }
                $model = new $modelClass();

                if (!isset($model->table)) {
                    continue;
                }

                // 检查表名是否正确
                $table = str_replace("`", '', $model->getTable());
                $sql = "SHOW TABLES LIKE  '" . $table . "'";
                $model->db->exec($sql);
                $row = $model->db->pdoStatement->fetch(\PDO::FETCH_NUM, \PDO::FETCH_ORI_NEXT);
                //var_export($row);
                if ($row === false) {
                    $this->fail($modelName . ':' . $model->getTable() . " table error on ".$sql);
                    continue;
                }
                if (count($row) <= 0) {
                    $this->fail($modelName . " table error");
                }
                $fetchTable = $row[0];
                if ($fetchTable === false) {
                    $this->fail($modelName . " table error,set " . $table . ', but get ' . $fetchTable);
                }

                $sql = "show full fields from  {$table} ";
                $databaseFields = $model->db->getRows($sql, [], true);
                if (empty($databaseFields)) {
                    continue;
                }
                // 检查默认字段是否正确
                if (isset($model->fields) && trimStr($model->fields) != '*') {
                    $modelFields = explode(',', $model->fields);
                    foreach ($modelFields as $f) {
                        if (!isset($databaseFields[$f])) {
                            $this->fail($modelName . " {$model->fields}'s {$f} error ");
                        }
                    }
                }

                // 检查主键是否正确
                $databasePKey = '';
                foreach ($databaseFields as $fieldName => $c) {
                    if ($c['Key'] == "PRI") {
                        $databasePKey = $fieldName;
                    }
                }
                $msg = $modelName . " primaryKey  empty, correct is " . $databasePKey;
                $this->assertNotEmpty($model->primaryKey, $msg);

                if ('main_cache_key' == $table) {
                    //print_r( $database_fields);
                }
                $primaryKey = str_replace("`", '', $model->primaryKey);
                if ($databasePKey != $primaryKey) {
                    $this->fail($modelName . " primaryKey {$primaryKey}'  error, correct is " . $databasePKey);
                }
            }
        } catch (\PDOException $e) {
            echo $sql;
            // var_dump($modelName);
            $this->fail($modelName . ' error:' . $e->getMessage());
        }
    }
}
