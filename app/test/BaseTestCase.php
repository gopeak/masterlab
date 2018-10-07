<?php

namespace main\app\test;

use PHPUnit\Framework\TestCase;

/**
 * 单元测试基类.
 */
class BaseTestCase extends TestCase
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
    protected function curlGet(\Curl\Curl &$curl, $url, $data = [], $return_json = true)
    {
        //$data['unit_token'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';
        $curl->get($url, $data);
        $resp = $curl->rawResponse;
        $this->checkCurlNoError($curl);
        if ($return_json) {
            $resp = $this->parseJsonResp($resp);
        }
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
    protected function postPost(\Curl\Curl &$curl, $url, $data = [], $parse_json = true)
    {
        $curl->post($url, $data);
        $resp = $curl->rawResponse;
        $this->checkCurlNoError($curl);
        if ($parse_json) {
            $resp = $this->parseJsonResp($resp);
        }
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
    protected function curlPut(\Curl\Curl $curl, $url, $data = [], $parse_json = true)
    {
        $curl->put($url, $data);
        $resp = $curl->rawResponse;
        $this->checkCurlNoError($curl);
        if ($parse_json) {
            $resp = $this->parseJsonResp($resp);
        }
        return $resp;
    }

    /**
     * 通过curl资源判断是否存在错误
     * @param \Curl\Curl $curl
     */
    protected function checkCurlNoError(\Curl\Curl $curl)
    {
        if ($curl->error) {
            $this->fail('\Curl\Curl Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . PHP_EOL);
        }
    }

    /**
     * 解析返回数据并转换为json数组
     * @param $resp
     * @return bool|int|mixed
     */
    protected function parseJsonResp($resp)
    {
        $json = json_decode($resp, true);
        if (!$json) {
            file_put_contents('error.log', $resp . "\n\n", FILE_APPEND);
        }

        if (isset($json['ret']) && $json['ret'] != '200') {
            // $this->fail( $json['data']['key'].':'.$json['data']['value']);
            $msg = $json['data']['value'];
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                //$msg = mb_convert_encoding($msg, 'GBK', 'UTF-8');
            }
            // var_dump("{$url}  " . $json['data']['key'] . ':' . $msg);
            return $this->writeWithLock('error.log', $msg . "  " . $resp . "\n\n");
        }
        return $json;
    }

    /**
     * 创建一个模型文件,并写入model/目录
     * @param string $model_name
     * @param string $prefix
     * @param string $table
     * @param string $fields
     * @param string $primaryKey
     * @return bool|int
     */
    protected function createModelFile($model_name, $prefix = 'test_', $table = 'user', $fields = '*', $primaryKey = 'id')
    {
        $model_source = "<?php \n" . '
namespace main\\' . APP_NAME . '\\model;
class ' . $model_name . ' extends DbModel{
    public $prefix = "' . $prefix . '";
    public $table = "' . $table . '";
    public $fields = "' . $fields . '";
    public $primaryKey = "' . $primaryKey . '";
}' . "\n\n";
        return $this->writeWithLock(MODEL_PATH . $model_name . '.php', $model_source);
    }

    /**
     * 创建一个控制器和内部代码
     * @param string $name
     * @param $function_source
     * @return bool|int
     */
    protected function createCtrlFunctionFile(string $name, $function_source)
    {
        $all_source = "<?php \n" . '
                    namespace main\\' . APP_NAME . '\\ctrl;
                    class ' . $name . ' extends BaseCtrl{
                         ' . $function_source . '
                    }' . "\n\n";
        return file_put_contents(CTRL_PATH . $name . '.php', $all_source, LOCK_EX);
    }

    /**
     * 以读锁的方式获取文件内容
     * @param $file
     * @return string
     */
    protected function readWithLock($file)
    {
        $data = '';
        $fp = fopen($file, "r");
        if (flock($fp, LOCK_EX)) {
            while (!feof($fp)) {
                $data .= fread($fp, 4096);
            }
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        return $data;
    }

    /**
     * 写锁的方式写入文件
     * @param $file
     * @param $data
     * @return bool|int
     */
    protected function writeWithLock($file, $data)
    {
        $fp = fopen($file, "w");
        $ret = false;
        if (flock($fp, LOCK_EX)) {
            $ret = fwrite($fp, $data);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        return (bool)$ret;
    }

    /**
     * 获得一个开发框架的实例
     * @param $config
     * @return \framework\HornetEngine|void
     */
    protected function getFrameworkInstance($config)
    {
        if (file_exists(PRE_APP_PATH . 'vendor/hornet/framework/src/framework/bootstrap.php')) {
            require_once PRE_APP_PATH . 'vendor/hornet/framework/src/framework/bootstrap.php';
        } else {
            if (!file_exists(PRE_APP_PATH . '/../hornet-framework/src/framework/bootstrap.php')) {
                $this->fail("File framework/bootstrap.php not exist");
                return;
            }
            require_once PRE_APP_PATH . '/../hornet-framework/src/framework/bootstrap.php';
        }
        $framework = new  \framework\HornetEngine($config);
        return $framework;
    }

    /**
     * 获取数组中某一项的权重值
     * @param $arr
     * @param $itemKey
     * @param $itemValue
     * @return int
     */
    protected function getArrItemOrderWeight($arr, $itemKey, $itemValue)
    {
        reset($arr);
        $orderWeight = 0;
        $i = 0;
        foreach ($arr as $item) {
            $i++;
            if (!isset($item[$itemKey])) {
                continue;
            }
            if ($item[$itemKey] == $itemValue) {
                $orderWeight = $i;
                return $orderWeight;
            }
        }
        return $orderWeight;
    }
}

