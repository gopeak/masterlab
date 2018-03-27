<?php

/**
 * 单元测试基类.
 */
class BaseTestCase extends PHPUnit_Framework_TestCase
{


    public static function setUpBeforeClass()
    {

    }

    public static function tearDownAfterClass()
    {

    }

    /**
     * 封装了GET方式调用api
     * @param \Curl\Curl $curl
     * @param string $url
     * @param array $data
     * @param bool $return_json
     * @return mixed|null
     */
    protected function _get( \Curl\Curl &$curl, string $url,array $data=[],bool $return_json = true )
    {
        //$data['unit_token'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';
        $curl->get( $url ,$data );
        $resp = $curl->rawResponse;
        $this->checkCurlNoError( $curl );
        if( $return_json )
            $resp = $this->parseJsonResp( $resp ,$url);
        return $resp;
    }

    /**
     * 封装了POST方式调用api
     * @param \Curl\Curl $curl
     * @param string $url
     * @param array $data
     * @param bool $parse_json
     * @return mixed|null
     */
    protected function _post( \Curl\Curl &$curl, string $url, array $data=[], bool $parse_json = true )
    {
        $curl->post( $url ,$data );
        $resp = $curl->rawResponse;
        $this->checkCurlNoError( $curl );
        if( $parse_json )
            $resp = $this->parseJsonResp( $resp ,$url);
        return $resp;
    }

    /**
     * 封装了PUT方式调用api
     * @param \Curl\Curl $curl
     * @param string $url
     * @param array $data
     * @param bool $parse_json
     * @return null
     */
    protected function _put( \Curl\Curl $curl, string $url, array $data=[], bool $parse_json = true  )
    {
        $curl->put( $url ,$data );
        $resp = $curl->rawResponse;
        $this->checkCurlNoError( $curl);
        if( $parse_json )
            $resp = $this->parseJsonResp( $resp,$url );
        return $resp;
    }

    /**
     * 通过curl资源判断是否存在错误
     * @param \Curl\Curl $
     */
    protected function checkCurlNoError( \Curl\Curl $curl   )
    {
        if ( $curl->error) {
            $this->fail(  '\Curl\Curl Error: ' . $curl->errorCode . ': ' . $curl->errorMessage.PHP_EOL );
        }
    }

    /**
     *  解析返回数据并转换为json数组
     * @param $res
     */
    protected function parseJsonResp( string $resp , string $url='' )
    {
        $json = json_decode( $resp ,true );
        if( !$json ){
            file_put_contents('error.log', $resp."\n\n" ,FILE_APPEND );
        }
        if( isset($json['ret']) &&  $json['ret']!='200') {
            // $this->fail( $json['data']['key'].':'.$json['data']['value']);
            $msg = $json['data']['value'];
            if( strtoupper(substr(PHP_OS,0,3))==='WIN' ){
                $msg = mb_convert_encoding( $msg ,'GBK','UTF-8' );
            }
            //var_dump(  "{$url}  ". $json['data']['key'].':'.$msg );
            return $this->writeWithLock('error.log', $resp."\n\n"  );
        }
        return $json;
    }


    /**
     * 创建一个模型文件,并写入model/目录
     * @param string $model_name
     * @param string $prefix
     * @param string $table
     * @param string $fields
     * @param string $primary_key
     * @return bool|int
     */
    protected function createModelFile( string $model_name, string $prefix='test_', string $table = 'user',string $fields='*',string $primary_key='id' )
    {
        $model_source = "<?php \n".'
namespace main\\'.APP_NAME.'\\model;
class '.$model_name.' extends DbModel{
    public $prefix = "'.$prefix.'";
    public $table = "'.$table.'";
    public $fields = "'.$fields.'";
    public $primary_key = "'.$primary_key.'";
}'."\n\n";
        return $this->writeWithLock( MODEL_PATH.$model_name.'.php', $model_source  );

    }

    /**
     * 创建一个控制器和内部代码
     * @param string $name
     * @param $function_source
     * @return bool|int
     */
    protected function createCtrlFunctionFile( string $name, $function_source )
    {
        $all_source = "<?php \n".'
                    namespace main\\'.APP_NAME.'\\ctrl;
                    class '.$name.' extends BaseCtrl{
                         '.$function_source.'
                    }'."\n\n";
        return file_put_contents( CTRL_PATH.$name.'.php', $all_source,LOCK_EX  );

    }

    protected function readWithLock( $file )
    {
        $data = '';
        $fp = fopen($file, "r");
        if(flock($fp,LOCK_EX))
        {
            while ( !feof($fp )) {
                $data .= fread( $fp, 4096 );
            }
            flock($fp,LOCK_UN);
        }
        fclose($fp);
        return $data;
    }
    protected function writeWithLock( $file, $data )
    {
        $fp = fopen($file, "w");
        $ret = false;
        if(flock($fp,LOCK_EX))
        {
            $ret = fwrite( $fp, $data );
            flock($fp,LOCK_UN);
        }
        fclose($fp);
        return $ret;
    }

}
