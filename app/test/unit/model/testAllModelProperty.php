<?php

/**
 * 检查那些继承于DbModel的类是否属性设置正确
 * User: sven
 * Date: 2017/7/15 0015
 * Time: 下午 5:24
 */
class testAllExtendDbModelProperty extends PHPUnit_Framework_TestCase
{

    static $model_fileinfos = [];

    public static function setUpBeforeClass()
    {
        static::getModelFiles(MODEL_PATH);
    }

    /**
     * 获取所有的Model类
     * @param $dir
     */
    static function getModelFiles ( $dir ){
        $current_dir = dir($dir);
        while($file = $current_dir->read())
        {
            if((is_dir($dir.$file)) AND ($file!=".") AND ($file!=".."))
            {
                static::getModelFiles( $dir.$file.'/');
            } else{
                $file = pathinfo(  $dir.$file );
                if( $file['extension']='php'
                    && strpos( $file['basename'] ,'Model')!==false
                    && !in_array( $file['basename'],['BaseModel','DbModel'] )
                ){
                    static::$model_fileinfos[] = $file['basename'] ;
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
    public function testModel(  )
    {
        $excludes = ['CacheModel','DbModel'];
        //SHOW TABLES LIKE 'test_user';
        if( !self::$model_fileinfos ){
            return;
        }
        $model_name = '';
        try {

            foreach (self::$model_fileinfos as $model_name) {

                $model_name = str_replace('.php', '', $model_name);
                if (in_array($model_name, $excludes)) {
                    continue;
                }
                $model_class = sprintf("main\\%s\\model\\%s", APP_NAME, $model_name);
                if (!class_exists($model_class)) {
                    $this->fail('class ' . $model_name . ' no found');
                }
                $model = new $model_class();

                if (!isset($model->table)) {
                    continue;
                }
                // 检查表名是否正确
                $table = str_replace("`", '', $model->getTable());
                $sql = "SHOW TABLES LIKE  '" . $table . "'";

                $model->db->exec($sql);
                $row = $model->db->pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);

                if (count($row) <= 0) {
                    $this->fail($model_name . " table error");
                }
                $fetch_table = $row[0];
                if( $fetch_table===false ){
                    $this->fail($model_name . " table error,set ".$table.', but get '.$fetch_table);
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
                            $this->fail($model_name . " {$model->fields}'s {$f} error ");
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
                    $this->fail($model_name . " primary_key  empty, correct is " . $database_pri_key);
                }
                if ('main_cache_key' == $table) {
                    //print_r( $database_fields);
                }
                $primary_key = str_replace("`", '', $model->primary_key);
                if ($database_pri_key != $primary_key) {
                    $this->fail($model_name . " primary_key {$model->primary_key}'  error, correct is " . $database_pri_key);
                }

            }
        }catch( \PDOException $e ){
            echo $sql;
            $this->fail( $model_name.' error:'.$e->getMessage());
        }

    }


}
