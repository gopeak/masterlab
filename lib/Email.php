<?php
 


/**
 * Created by PhpStorm.
 * User: cszchen
 * Date: 2016/5/19
 * Time: 11:28
 */

class Email
{
    public $host;

    public $port;

    public $username;

    public $password;

    public $encryption;

    public $charset = 'utf-8';

    protected $mailer;

    public function __construct( array $config = [])
    {
        $defaltConfig = getConfigVar('mail');
        $config = array_merge($defaltConfig, $config);
        foreach ($config as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            } elseif (($method = 'set'. ucfirst($property)) && method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        $fromEmail = !empty($config['from']['address']) ? $config['from']['address'] : $this->username;
        $fromName = !empty($config['from']['realname']) ? $config['from']['realname'] : '';
        $this->setFrom($fromEmail, $fromName);
    }

    /**
     * @param mixed $email
     * @param string $name
     * @return $this
     */
    public function setTo($email, $name = '')
    {
        header("Content-type: text/html; charset=utf-8");
        $this->getMailer()->clearAddresses();
        $this->addTo($email, $name);
        return $this;

    }

    public function addTo($email, $name = '')
    {
        if (is_array($email)) {
            foreach ($email as $e => $n) {
                if (is_numeric($e)) {
                    $this->getMailer()->addAddress($n);
                } else {
                    $this->getMailer()->addAddress($e, $n);
                }
            }
        } else {
            $this->getMailer()->addAddress($email, $name);
        }
        return $this;
    }

    public function setTextBody($text)
    {
        $this->getMailer()->isHTML(false);
        $this->getMailer()->Body = $text;
        return $this;
    }

    public function setHtmlBody($html)
    {
        $this->getMailer()->isHTML(true);
        $this->getMailer()->Body = $html;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->getMailer()->Subject = $subject;
        return $this;
    }

    public function setFrom($email, $name = '') {
        if (is_array($email)) {
            $e = key($email);
            if ($e) {
                $this->getMailer()->setFrom($e, $email[$e]);
            }
        } else {
            $this->getMailer()->setFrom($email, $name);
        }
        return $this;
    }

    public function renderFile($_file_, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($_file_);
        $html = ob_get_clean();
        $this->setHtmlBody($html);
        return $this;
    }

    public function send()
    {
        return $this->getMailer()->send();
    }

    protected function getMailer()
    {
        if (!$this->mailer) {
            require_once PRE_APP_PATH . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
            
            $this->mailer = new \PHPMailer();
            $this->mailer->Charset='gbk';
            $this->mailer->CharSet = "utf-8";
            $this->mailer->isSMTP();                                      // Set mailer to use SMTP
            $this->mailer->Host = $this->host;  // Specify main and backup SMTP servers
            $this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
            $this->mailer->Username = $this->username;                 // SMTP username
            $this->mailer->Password = $this->password;                           // SMTP password
            $this->mailer->SMTPSecure = $this->encryption;                            // Enable TLS encryption, `ssl` also accepted
            $this->mailer->Port = $this->port;
            $this->mailer->charset = $this->charset;
        }

        return $this->mailer;
    }

    public function __call($name, $params)
    {
        if (method_exists($this->getMailer(), $name)) {
            return call_user_func_array([$this->getMailer(), $name], $params);
        }
    }
}
