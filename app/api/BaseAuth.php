<?php


namespace main\app\api;


use framework\protocol\Api;
use main\app\classes\JWTLogic;
use main\app\model\PluginModel;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BaseAuth extends BaseApi
{
    protected $authUserId = null;
    protected $authAccount = null;
    /**
     * @var EventDispatcher|null
     */
    public $dispatcher = null;
    protected $_plugins = array();

    /**
     * BaseAuth constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        // 开发模式关闭jwt
        if (0) {
            if (!isset($_GET['access_token']) || empty($_GET['access_token'])) {
                self::echoJson('缺少参数.', [], Constants::HTTP_AUTH_FAIL);
            }
            $accessToken = trim($_GET['access_token']);
            $jwt = JWTLogic::getInstance();
            $parserTokenArr = $jwt->parser($accessToken);

            if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_INVALID || $parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXCEPTION) {
                self::echoJson($parserTokenArr['msg'], [], Constants::HTTP_AUTH_FAIL);
            }

            if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXPIRED) {
                // 前端识别到EXPIRED，调用refresh_token
                self::echoJson(JWTLogic::PARSER_STATUS_EXPIRED, [], Constants::HTTP_AUTH_FAIL);
            }

            $this->authUserId = $parserTokenArr['uid'];
            $this->authAccount = $parserTokenArr['account'];
        }

        $this->dispatcher = new EventDispatcher();
        $this->loadPlugin();

    }

    /**
     * 初始化插件
     * @throws \Exception
     */
    public function loadPlugin()
    {
        $pluginModel = new PluginModel();
        $plugins = $pluginModel->getRows('id, name, title');
        $pluginsKeyArr = array_column($plugins, null, 'name');
        $dirPluginArr = $this->getPluginDirArr(PLUGIN_PATH);
        foreach ($dirPluginArr as $dirName => $item) {
            if (!isset($pluginsKeyArr[$dirName])) {
                $tmp = $item;
                $tmp['status'] = PluginModel::STATUS_UNINSTALLED;
                $tmp['is_system'] = '0';
                $plugins[] = $tmp;
            }
        }

        if ($plugins) {
            foreach ($plugins as $plugin) {
                $pluginName = $plugin['name'];
                $pluginClassName = 'PluginSubscriber';
                $pluginFile = PLUGIN_PATH . $pluginName . "/PluginSubscriber.php";
                //var_dump($pluginFile);
                if (file_exists($pluginFile)) {
                    require_once($pluginFile);
                    $pluginClass = sprintf("main\\app\\plugin\\%s\\%s",  $pluginName, $pluginClassName);
                    if (class_exists($pluginClass)) {
                        $this->_plugins[$pluginName] = new $pluginClass($this->dispatcher, $pluginName);
                        $this->dispatcher->addSubscriber($this->_plugins[$pluginName]);
                    }
                }
            }
        }
        //print_r($this->_plugins);
    }

    /**
     * @param $pluginDir
     * @return array
     */
    public function getPluginDirArr($pluginDir)
    {
        $pluginArr = [];
        $currentDir = dir($pluginDir);
        while ($file = $currentDir->read()) {
            if ((is_dir($pluginDir . $file)) and ($file != ".") and ($file != "..")) {
                $jsonFile = $pluginDir . $file . '/plugin.json';
                if (file_exists($jsonFile)) {
                    $jsonArr = json_decode(file_get_contents($jsonFile), true);
                    $jsonArr['name'] = $file;
                    $pluginArr[$file] = $jsonArr;
                }
            }
        }
        $currentDir->close();
        return $pluginArr;
    }
}