<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2020/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use Adldap\Query\Collection;
use Adldap\Schemas\ActiveDirectory;
use main\app\model\SettingModel;
use main\app\model\user\UserModel;

/**
 * 支持LDAP
 * @package main\app\classes
 */
class LdapLogic
{

    /**
     * @var \Adldap\Adldap|null
     */
    public $ad = null;

    /**
     * @var \Adldap\Connections\ProviderInterface|null
     */
    public $provider = null;

    private $err = '';

    /**
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        $ldapRowsArr = SettingModel::getInstance()->getSettingByModule('ldap');
        $ldapSettingArr = array_column($ldapRowsArr, '_value', '_key');
        $this->config = [
            'hosts' => [$ldapSettingArr['ldap_hosts']],
            'port' => $ldapSettingArr['ldap_port'],
            'base_dn' => $ldapSettingArr['ldap_base_dn'],
            'username' => $ldapSettingArr['ldap_username'],
            'password' => $ldapSettingArr['ldap_password'],
            'version' => (int)$ldapSettingArr['ldap_version'],
            'timeout' => (int)$ldapSettingArr['ldap_timeout'],
        ];
        if ($ldapSettingArr['ldap_security protocol'] == 'ssl') {
            $this->config ['use_ssl'] = true;
        }
        if ($ldapSettingArr['ldap_security protocol'] == 'tls') {
            $this->config ['use_tls'] = true;
        }
        if ($ldapSettingArr['ldap_schema'] == 'ActiveDirectory') {
            $this->config ['schema'] = \Adldap\Schemas\ActiveDirectory::class;
        }
        if ($ldapSettingArr['ldap_schema'] == 'OpenLDAP') {
            $this->config ['schema'] = \Adldap\Schemas\OpenLDAP::class;
        }
        if ($ldapSettingArr['ldap_schema'] == 'FreeIPA') {
            $this->config ['schema'] = \Adldap\Schemas\FreeIPA::class;
        }
        $this->ad = new \Adldap\Adldap();
        $this->ad->addProvider($this->config);

        try {
            // If a successful connection is made to your server, the provider will be returned.
            $this->provider = $this->ad->connect();
        } catch (\Adldap\Auth\BindException $e) {
            //throw $e;
            $this->err = $e->getCode() . ': ' . $e->getMessage();
        }

    }

    /**
     * 支持LDAP认证登录
     * @param $username
     * @param $password
     * @return array
     * @throws \Adldap\Auth\PasswordRequiredException
     * @throws \Adldap\Auth\UsernameRequiredException
     */
    public function auth($username, $password)
    {
        if (!$this->provider) {
            return [false, $this->err];
        }
        try {
            $ldapUser = $this->provider->search()->where('cn', '=', $username)->first();
            if (!isset($ldapUser->distinguishedname[0])) {
                return [false, '通过 cn=' . $username . ' 查找失败'];
            }
            $ret = $this->provider->auth()->attempt($ldapUser->distinguishedname[0], $password);
            if (!$ret) {
                return [false, 'ldap用户名或密码认证失败'];
            }
            if ($ldapUser) {
                if ($this->config['schema'] == \Adldap\Schemas\ActiveDirectory::class) {
                    return [true, $this->formatInfo($username, $ldapUser)];
                }
                if ($this->config['schema'] == \Adldap\Schemas\OpenLDAP::class) {
                    return [true, $this->formatInfo($username, $ldapUser)];
                }
                return [true, $this->formatInfo($username, $ldapUser)];
            } else {
                return [false, '认证失败,但获取用户信息失败'];
            }

        } catch (\Exception $e) {
            $this->err = $e->getCode() . ': ' . $e->getMessage();
            return [false, $this->err];
        }
    }

    /**
     * @param $username string
     * @param $results Collection|array
     * @return array
     */
    public function formatInfo($username, $ldapUser)
    {
        if (!$ldapUser) {
            return [];
        }
        $mailHost = '@ldap.com';
        if (preg_match('/,DC=([^,]+),DC=([^,]+)$/sU', $ldapUser->distinguishedname[0], $result)) {
            $mailHost = '@' . $result[1] . '.' . $result[2];
        }
        $email = $username . $mailHost;
        if (isset($ldapUser->mail[0])) {
            $email = $ldapUser->mail[0];
        }
        if (isset($ldapUser->userprincipalname[0])) {
            $email = $ldapUser->userprincipalname[0];
        }

        $title = '';
        if (method_exists($ldapUser, 'getTitle')) {
            $title = $ldapUser->getTitle();
        }
        if (isset($ldapUser->description[0]) && empty($title)) {
            $title = $ldapUser->description[0];
        }

        $displayName = '';
        if (isset($ldapUser->name[0])) {
            $displayName = $ldapUser->name[0];
        }
        if (method_exists($ldapUser, 'getDisplayName')) {
            $displayName = $ldapUser->getDisplayName();
        }
        if(empty($displayName)){
            $displayName = $username;
        }

        $phone = '';
        if (method_exists($ldapUser, 'getTelephoneNumber')) {
            $phone = $ldapUser->getTelephoneNumber();
        }

        $arr = [];
        $arr['username'] = $username;
        $arr['email'] = $email;
        $arr['phone'] = $phone;
        $arr['display_name'] = $displayName;
        $arr['avatar'] = '';
        $arr['schema_source'] = 'ldap';
        $arr['title'] = $title;
        $arr['status'] = UserModel::STATUS_NORMAL;
        $arr['password'] = '';
        if (isset($ldapUser->accountexpires) && $ldapUser->accountexpires != 0) {

        }
        return $arr;
    }

}
