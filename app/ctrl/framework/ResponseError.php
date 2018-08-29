<?php
/**
 * 开发框架测试的代码,请勿随意修改或删除
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:49
 */

namespace main\app\ctrl\framework;

use main\app\ctrl\BaseCtrl;

/**
 * 产生错误页面和数据
 * @package main\app\ctrl
 */
class ResponseError extends BaseCtrl
{
    private $enableXdebug = false;

    public function __construct()
    {
        $enableXdebug = '0';
        if (isset($_GET['enable_xdebug']) && $_GET['enable_xdebug'] == '1' && extension_loaded('xdebug')) {
            $enableXdebug = $_GET['enable_xdebug'];
        }
        if ($enableXdebug == '0' || !extension_loaded('xdebug')) {
            if (function_exists('xdebug_disable')) {
                xdebug_disable();
            }
            $this->enableXdebug = false;
        } else {
            if (function_exists('xdebug_enable')) {
                xdebug_enable();
                $this->enableXdebug = true;
            }
        }
    }

    public function pageUserError()
    {
        $errorTypes = [];
        $errorTypes['Deprecated'] = 16384;
        $errorTypes['Notice'] = 1024;
        $errorTypes['Warning'] = 512;
        foreach ($errorTypes as $key => $errorNo) {
            if ($this->enableXdebug) {
                echo "<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan=\"5\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> {$key}: trigger:{$key} in F:\www\hornet\app\ctrl\framework\ResponseError.php on line <i>52</i></th></tr>
</table></font>";
            } else {
                trigger_error('trigger:' . $key, $errorNo);
            }
        }
    }

    public function pageException()
    {
        throw new \Exception('Division by zero.');
    }

    public function pageTriggerError()
    {
        if ($this->enableXdebug) {
            echo "
<br />
<font size='1'><table class='xdebug-error xe-uncaught-exception' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan=\"5\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Fatal error: Uncaught Error: trigger_error in F:\www\hornet\app\ctrl\framework\ResponseError.php on line <i>70</i></th></tr>
<tr><th align='left' bgcolor='#f57900' colspan=\"5\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Error: trigger_error in F:\www\hornet\app\ctrl\framework\ResponseError.php on line <i>70</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
</table></font>
";
        } else {
            throw new \Error('trigger_error', 4);
        }
    }

    public function pageFatalError()
    {
        if ($this->enableXdebug) {
            echo '<br />
<font size=\'1\'><table class=\'xdebug-error xe-parse-error\' dir=\'ltr\' border=\'1\' cellspacing=\'0\' cellpadding=\'1\'>
<tr><th align=\'left\' bgcolor=\'#f57900\' colspan="5"><span style=\'background-color: #cc0000; color: #fce94f; font-size: x-large;\'>( ! )</span> Parse error: syntax error, unexpected \'$errLine\' (T_VARIABLE) in F:\www\hornet\app\ctrl\framework\ResponseError.php on line <i>57</i></th></tr>
</table></font>
';
        } else {
            echo '
<br />
<b>Parse error</b>:  syntax error, unexpected \'$bbb\' (T_VARIABLE) in <b>F:\www\hornet\app\ctrl\framework\ResponseError.php</b> on line <b>64</b><br />
';
        }
    }

    public function pageUnDefine()
    {
        if($this->enableXdebug){
            echo "
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan=\"5\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: not_exist_key in F:\www\hornet\app\ctrl\framework\ResponseError.php on line <i>108</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
</table></font>
";
        }else{
            $arr = [];
            echo $arr['not_exist_key'];
        }

    }
}
