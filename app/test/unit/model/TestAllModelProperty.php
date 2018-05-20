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

    public static $modelFileinfos = [];

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
        $current_dir = dir($dir);
        while ($file = $current_dir->read()) {
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
                    static::$modelFileinfos[] = $modulePath.$file['basename'];
                }
            }
        }
        $current_dir->close();
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 检查 table fields primary_key 是否设置正确
     */
    public function testModel()
    {
        $excludes = ['CacheModel', 'DbModel','BaseDictionaryModel'];
        //SHOW TABLES LIKE 'test_user';
        if (!self::$modelFileinfos) {
            return;
        }
        $modelName = '';
        try {
            foreach (self::$modelFileinfos as $modelName) {
                $modelName = str_replace('.php', '', $modelName);
                //var_dump($modelName);
                if (in_array($modelName, $excludes)) {
                    continue;
                }
                // require_once MODEL_PATH.$modelName.'.php';
                $model_class = sprintf("main\\%s\\model\\%s", APP_NAME, $modelName);
                //var_dump($model_class);
                if (!class_exists($model_class)) {
                    $this->fail('class ' . $modelName . ' no found');
                }
                $model = new $model_class();

                if (!isset($model->table)) {
                    continue;
                }
                // 检查表名是否正确
                $table = str_replace("`", '', $model->getTable());
                $sql = "SHOW TABLES LIKE  '" . $table . "'";
                $model->db->exec($sql);
                $row = $model->db->pdoStatement->fetch(\PDO::FETCH_NUM, \PDO::FETCH_ORI_NEXT);
                if ($row===false) {
                    $this->fail($modelName . " table error");
                    continue;
                }
                if (count($row) <= 0) {
                    $this->fail($modelName . " table error");
                }
                $fetch_table = $row[0];
                if ($fetch_table === false) {
                    $this->fail($modelName . " table error,set " . $table . ', but get ' . $fetch_table);
                }

                $sql = "show full fields from  {$table} ";
                $database_fields = $model->db->getRows($sql, [], true);
                if (empty($database_fields)) {
                    continue;
                }
                // 检查默认字段是否正确
                if (isset($model->fields) && trimStr($model->fields) != '*') {
                    $model_fields = explode(',', $model->fields);
                    foreach ($model_fields as $f) {
                        if (!isset($database_fields[$f])) {
                            $this->fail($modelName . " {$model->fields}'s {$f} error ");
                        }
                    }
                }

                // 检查主键是否正确
                $database_pri_key = '';
                foreach ($database_fields as $field_name => $c) {
                    if ($c['Key'] == "PRI") {
                        $database_pri_key = $field_name;
                    }
                }
                if (empty($model->primary_key)) {
                    $this->fail($modelName . " primary_key  empty, correct is " . $database_pri_key);
                }
                if ('main_cache_key' == $table) {
                    //print_r( $database_fields);
                }
                $primary_key = str_replace("`", '', $model->primary_key);
                if ($database_pri_key != $primary_key) {
                    $this->fail($modelName . " primary_key {$primary_key}'  error, correct is " . $database_pri_key);
                }
            }
        } catch (\PDOException $e) {
            echo $sql;
            $this->fail($modelName . ' error:' . $e->getMessage());
        }
    }
}
