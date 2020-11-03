<?php

namespace main\app\ctrl;

use Doctrine\Common\Inflector\Inflector;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\DbModel;
use main\app\model\PluginModel;
use main\app\model\user\UserPostedFlagModel;
use main\app\model\SettingModel;
use main\app\model\system\AnnouncementModel;
use main\app\model\user\UserModel;
use main\app\protocol\Ajax;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * 控制器基类
 *
 * @author user
 *
 */
class BaseCtrl
{

    /**
     * @var EventDispatcher|null
     */
    public $dispatcher = null;

    protected $_plugins = array();

    /**
     * 模板引擎对象
     * @var
     */
    protected $tpl;


    /**
     * 模板引擎对象2,自定义twig标记
     * @var
     */
    protected $tpl2;

    /**
     * 模板引擎加载器
     * @var
     */
    protected $loader;

    /**
     * 错误数组
     * @var array
     */
    protected $error = [];

    /**
     * 全局模板变量数组
     * @var array
     */
    public static $gTplVars = [];

    /**
     * 页面标题.
     * @var string
     */
    public $pageTitle = '';

    /**
     * 每个页面的token
     */
    public $csrfToken = '';

    /**
     * ajax请求失败时,客户端提示用户
     */
    const AJAX_FAILED_TYPE_TIP = 101;

    /**
     * ajax请求失败时,客户端显示警告信息
     */
    const AJAX_FAILED_TYPE_WARN = 102;

    /**
     * ajax请求失败时,客户端显示错误信息
     */
    const AJAX_FAILED_TYPE_ERROR = 103;

    /**
     * ajax请求失败时,告诉客户端将把错误信息显示在对应的表单项上
     */
    const AJAX_FAILED_TYPE_FORM_ERROR = 104;


    /**
     * BaseCtrl constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        static $siteName, $twigLoader, $twigTpl, $twigTpl2;
        //print_r($_SESSION);
        $this->dispatcher = new EventDispatcher();
        $this->loadPlugin();

        if (count($_GET) > 200) {
            throw new \Exception('GET参数过多', 300);
        }

        if (count($_POST) > 200) {
            throw new \Exception('POST参数过多', 400);
        }

        if (count($_COOKIE) > 50) {
            throw new \Exception('COOKIE参数过多', 500);
        }
        if (getCommonConfigVar('common')['csrf']) {
            $this->checkCSRF();
        }
        if (empty($twigLoader)) {
            $twigLoader = new \Twig\Loader\FilesystemLoader(VIEW_PATH . '');
        }
        $this->loader  = $twigLoader;
        if (empty($twigTpl)) {
            $debug = XPHP_DEBUG ? true : false;
            $twigTpl = new \Twig\Environment($this->loader, [
                'debug' => $debug
            ]);
            $function = new \Twig\TwigFunction('str_replace', function ($find, $replace, $string) {
                return str_replace($find, $replace, $string);
            });
            $twigTpl->addFunction($function);
            $twigTpl->addExtension(new \Twig\Extension\DebugExtension());
            $options = ['tag_variable'=>['<?=', '?>'],'tag_comment' => ['{!', '!}']];
            $lexer = new \Twig\Lexer($twigTpl, $options);
            $twigTpl->setLexer($lexer);
        }
        $this->tpl = $twigTpl;

        if (empty($siteName)) {
            $siteName = (new \main\app\classes\SettingsLogic())->showSysTitle();
            if (isset($title) && !empty($title)) {
                $title = $title . ' · ' . $siteName;
            } else {
                $title = $siteName;
            }
            $this->addGVar('_title', $title);
            $this->getSystemInfo();
        }
        $this->addGVar('_currenPhpUser', isset($_SERVER['USER'])? $_SERVER['USER']:@get_current_user());
        $this->addGVar('_root_path', PRE_APP_PATH);
    }

    /**
     * 在渲染页面的时候调用
     */
    public function initCSRF()
    {
        // 向页面输出csrf_token
        $this->csrfToken = csrfToken('csrf_token');
    }

    /**
     * 在提交表单的时候进行csrf_token验证
     * @throws \Exception
     */
    public function checkCSRF()
    {
        if (isPost()) {
            if (isset($_SERVER['HTTP_MLTEST_CSRFTOKEN']) && $_SERVER['HTTP_MLTEST_CSRFTOKEN'] == ENCRYPT_KEY) {
                return;
            }

            if (isset($_REQUEST['_csrftoken'])) {
                $csrfToken = $_REQUEST['_csrftoken'];
            } elseif (isset($_SERVER['HTTP_ML_CSRFTOKEN'])) {
                $csrfToken = $_SERVER['HTTP_ML_CSRFTOKEN'];
            } else {
                throw new \Exception('缺少_TOKEN', 500);
            }

            if (!checkCsrfToken($csrfToken, 'csrf_token')) {
                throw new \Exception('_TOKEN 无效', 500);
            }
        }
    }

    /**
     * 是否是ajax请求
     * @return bool
     */
    public function isAjax()
    {
        if (isset($_SERVER['CONTENT_TYPE']) && strtolower($_SERVER['CONTENT_TYPE']) == 'application/json') {
            return true;
        }
        if (isset($_GET['data_type']) && $_GET['data_type'] == 'json') {
            return true;
        }
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    /**
     * 是否是APP请求
     * @return bool
     */
    public function isApp()
    {
        if (isset($_SERVER['HTTP_MASTERLAB_APP']) && !empty($_SERVER['HTTP_MASTERLAB_APP'])) {
            return true;
        }
        return false;
    }

    /**
     * 添加类全局变量
     * @param $key
     * @param $value
     */
    public function addGVar($key, $value)
    {
        self::$gTplVars[$key] = $value;
    }

    /**
     * 控制器将数据传递给视图
     * @param $tpl
     * @param array $dataArr
     * @param bool $partial
     * @throws \Exception
     */
    public function render($tpl, $dataArr = [], $partial = false)
    {
        $this->initCSRF();
        // 向视图传入通用的变量
        $this->addGVar('_GET', $_GET);
        $this->addGVar('site_url', ROOT_URL);
        $this->addGVar('attachment_url', ATTACHMENT_URL);
        $this->addGVar('_version', MASTERLAB_VERSION);
        $this->addGVar('app_name', SITE_NAME);
        $this->addGVar('csrf_token', $this->csrfToken);
        $user = [];
        $curUid = UserAuth::getInstance()->getId();
        if ($curUid) {
            $user = UserModel::getInstance($curUid)->getUser();
            $user = UserLogic::format($user);
        }
        $this->addGVar('user', $user);

        $dataArr = array_merge(self::$gTplVars, $dataArr);
        ob_start();
        ob_implicit_flush(false);
        extract($dataArr, EXTR_PREFIX_SAME, 'tpl_');

        $tplEngine = 'php';
        if (defined('TPL_ENGINE')) {
            $tplEngine = TPL_ENGINE;
        }
        if ($tplEngine == 'php') {
            require_once VIEW_PATH . $tpl;
            if (!$partial && XPHP_DEBUG) {
                $sqlLogs = DbModel::$sqlLogs;
                include_once VIEW_PATH . 'debug.php';
                unset($sqlLogs);
            }
        } else {
            $tpl = str_replace(['gitlab', '.php'], ['twig', '.twig'], $tpl);
            $extension = pathinfo($tpl)['extension'] ?? 'twig';
            if($extension=='twig2'){
                echo $this->tpl2->render($tpl, $dataArr);
            }else{
                echo $this->tpl->render($tpl, $dataArr);
            }

        }
        echo ob_get_clean();
    }

    /**
     * 重定向到一个新的url
     * @param string $url
     */
    public function redirect($url)
    {
        $this->cleanOutput();
        header('Location:' . $url);
        exit;
    }

    public function cleanOutput()
    {
        for ($level = ob_get_level(); $level > 0; --$level) {
            if (!@ob_end_clean()) {
                ob_clean();
            }
        }
    }

    /**
     * 通过ajax 协议返回格式
     * @param string $msg
     * @param array $data
     * @param int $code
     * @throws \Exception
     */
    public function ajaxSuccess($msg = '', $data = [], $code = 200)
    {
        global $framework;
        $ajaxProtocolClass = sprintf("main\\%s\\protocol\\%s", $framework->currentApp, $framework->ajaxProtocolClass);
        if (class_exists($ajaxProtocolClass)) {
            //@var \main\app\protocol\Ajax
            $ajaxProtocol = new $ajaxProtocolClass();
        } else {
            $ajaxProtocol = new \framework\Protocol\Ajax();
        }
        $ajaxProtocol->builder($code, $data, $msg);
        $result = $ajaxProtocol->getResponse();
        if ($framework->enableReflectMethod) {
            $function = '';
            $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            if (isset($traces[1]['class'])) {
                $function = $traces[1]['function'];
            }
            $reflectMethod = new \ReflectionMethod($this, $function);
            $returnObj = json_decode(json_encode($data));
            $this->validReturnJson($reflectMethod, $ajaxProtocol, $returnObj, $result);
        }

        //@header('Content-Type:application/json');
        $this->_ajaxResponseHeader();
        echo $result;
        exit;
    }

    /**
     * @param \ReflectionMethod $reflectMethod
     * @param \main\app\protocol\Ajax $ajaxProtocol
     * @param object $returnObj
     * @param string $jsonStr
     */
    private function validReturnJson($reflectMethod, $ajaxProtocol, $returnObj, &$jsonStr)
    {
        // 检查属性是否存在并且类型一致
        $commentString = $reflectMethod->getDocComment();
        if (!$commentString) {
            return;
        }
        $pattern = "#@require_type\s+([^*/].*)#";
        preg_match_all($pattern, $commentString, $matches, PREG_PATTERN_ORDER);
        if (isset($matches[1][0])) {
            $requireObj = json_decode($matches[1][0]);
            if ($requireObj !== null) {
                list($validRet, $validMsg) = $this->compareReturnJson($requireObj, $returnObj);
                if (!$validRet) {
                    $ajaxProtocol->builder('600', ['key' => 'return_type_err', 'value' => $validMsg]);
                    $jsonStr = $ajaxProtocol->getResponse();
                }
            }
        }
    }

    /**
     * 检查返回值是否符合格式要求
     *
     * @param object $requireTypeObj type object
     * @param object $returnObj return object
     *
     * @return array
     */
    private function compareReturnJson($requireTypeObj, $returnObj)
    {
        // 检查属性是否存在并且类型一致
        if (empty($requireTypeObj)
            && gettype($requireTypeObj) != gettype($returnObj)
        ) {
            return [false, 'expect  type is ' . gettype($returnObj) . ', but get ' . gettype($requireTypeObj)];
        }
        if (!empty($requireTypeObj) && is_object($requireTypeObj)) {
            foreach ($requireTypeObj as $k => $v) {
                if (!isset($returnObj->$k)) {
                    return [false, 'property:' . $k . ' not exist'];
                }
                if (gettype($v) != gettype($returnObj->$k)) {
                    return [false, 'expect ' . $k . ' type is ' . gettype($v) . ', but get ' . gettype($returnObj->$k)];
                }
                if (!empty($returnObj->$k) && (is_array($returnObj->$k) || is_object($returnObj->$k))) {
                    list($ret, $msg) = $this->compareReturnJson($v, $returnObj->$k);
                    if (!$ret) {
                        return [$ret, $msg];
                    }
                }
            }
        }
        return [true, ''];
    }

    /**
     * 通过ajax 协议返回异常格式
     * @param $msg
     * @param array $data
     * @param int $code
     */
    public function ajaxFailed($msg, $data = [], $code = 0)
    {
        //header('Content-Type:application/json');
        $this->_ajaxResponseHeader();
        $ajaxProtocol = new ajax();
        $ajaxProtocol->builder($code, $data, $msg);
        echo $ajaxProtocol->getResponse();
        exit;
    }

    private function _ajaxResponseHeader()
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:*');
        header('Content-Type:application/json');
    }

    public function jump($url, $info = null, $sec = 3)
    {
        if (is_null($info)) {
            header("Location:$url");
        } else {
            echo "<meta http-equiv=\"refresh\" content=" . $sec . ";URL=" . $url . ">";
            echo $info;
        }
        exit;
    }

    /**
     * 跳转至信息展示页面
     * @param string $title 标题
     * @param string $content 内容
     * @param array $links 链接
     * @param string $icon 图标样式
     * @throws \Exception
     */
    public function info(
        $title = '信息提示',
        $content = '',
        $links = ['type' => 'link', 'link' => '/', 'title' => '回到首页'],
        $icon = 'icon-font-ok',
        $colorType = 'alert-info'
    )
    {
        $arr = [];

        $arr['_title'] = $title;
        $arr['_links'] = $links;
        $arr['_content'] = $content;
        $arr['_icon'] = $icon;
        $arr['_color_type'] = $colorType;
        $this->render('twig/common/info.twig', $arr);
    }


    /**
     * 跳转至警告页面
     * @param string $title 标题
     * @param string $content 内容
     * @param array $links 链接
     * @throws \Exception
     */
    public function warn(
        $title = '警告!',
        $content = '',
        $links = ['type' => 'link', 'link' => '/', 'title' => '回到首页']
    )
    {
        $this->info( $title , $content, $links, 'icon-font-fail', 'alert-warning');
    }

    /**
     * 跳转至错误页面
     * @param string $title 标题
     * @param string $content 内容
     * @param array $links 链接
     * @throws \Exception
     */
    public function error(
        $title = '错误提示!',
        $content = '',
        $links = ['type' => 'link', 'link' => '/', 'title' => '回到首页']
    )
    {
        $this->info( $title , $content, $links, 'icon-font-fail','alert-danger');
    }


    /**
     * @return array
     * @throws \Exception
     */
    protected function getAnnouncement()
    {
        $model = new AnnouncementModel();
        $ret = $model->getRow('*', []);

        if (empty($ret)) {
            return [false];
        }

        if (!$ret['status']) {
            return [false];
        }

        if ($ret['expire_time'] < time()) {
            return [false];
        }

        if (isset($_COOKIE['announcement']) && $_COOKIE['announcement'] == $ret['flag']) {
            return [false];
        }

        return [true, $ret['content'], $ret['flag']];
    }

    /**
     * 收集用户的基本信息,以获取用户使用活跃度
     * @throws \Exception
     */
    public function getSystemInfo()
    {
        // 首页才会触发
        if (empty($_GET['_target']) || $_SERVER['REQUEST_URI'] == '/') {
            $userId = UserAuth::getId();
            $userPostedFlagModel = new UserPostedFlagModel();
            $havePostedSystemInfo = $userPostedFlagModel->getByDateIp($userId, date('Y-m-d'), getIp());
            if (isset($havePostedSystemInfo['ip'])) {
                return;
            }

            $issueModel = new SettingModel();
            $versionSql = 'select version() as vv';
            $versionStr = $issueModel->getFieldBySql($versionSql);
            $basicSettingArr = $issueModel->getSettingByModule();
            $companyInfo = [];
            $fetchKeyArr = ['title', 'company', 'company_linkman', 'company_phone'];
            foreach ($basicSettingArr as $row) {
                if (in_array($row['_key'], $fetchKeyArr)) {
                    $companyInfo[$row['_key']] = $row['_value'];
                }
            }
            $postInfo = array(
                'company_info' => $companyInfo,
                'os' => PHP_OS,
                'server' => php_uname(),
                'env' => $_SERVER["SERVER_SOFTWARE"],
                'php_sapi_name' => php_sapi_name(),
                'php_version' => PHP_VERSION,
                'zend_version' => Zend_Version(),
                'mysql_version' => $versionStr,
                'server_ip' => $_SERVER['SERVER_ADDR'],
                'client_ip' => $_SERVER['REMOTE_ADDR'],
                'host' => $_SERVER["HTTP_HOST"],
                'port' => $_SERVER['SERVER_PORT'],
                'masterlab_version' => MASTERLAB_VERSION,
                'upload_max' => ini_get('upload_max_filesize'),
                'max_execution' => ini_get('max_execution_time'),
                'server_time' => time(),
                'server_name' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            );
            $curl = new \Curl\Curl();
            $curl->setTimeout(10);
            $curl->post('http://www.masterlab.vip/client_info.php', $postInfo);

            $date = date('Y-m-d');
            $ip = getIp();
            $userPostedFlagModel->deleteSettingByDate($userId, $date);
            $userPostedFlagModel->insertDateIp($userId, $date, $ip);
            //echo $curl->rawResponse;
        }
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
                    $pluginClass = sprintf("main\\plugin\\%s\\%s",  $pluginName, $pluginClassName);
                    if (class_exists($pluginClass)) {
                        $this->_plugins[$pluginName] = new $pluginClass($this->dispatcher, $pluginName);
                        $this->dispatcher->addSubscriber($this->_plugins[$pluginName]);
                    }
                }
            }
        }
         //print_r($this->_plugins);
    }
}
