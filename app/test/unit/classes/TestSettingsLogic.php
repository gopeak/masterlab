<?php

namespace main\app\test\unit\classes;

use main\app\classes\SettingsLogic;
use PHPUnit\Framework\TestCase;

class TestSettingsLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * @throws \Exception
     */
    public function testShowSysTitle()
    {
        $logic = new SettingsLogic();
        $ret = $logic->showSysTitle();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testSysSwitch()
    {
        $logic = new SettingsLogic();
        $ret = $logic->sysSwitch();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMaxLoginErrorNumber()
    {
        $logic = new SettingsLogic();
        $ret = $logic->maxLoginErrorNumber();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testLoginRequireCaptcha()
    {
        $logic = new SettingsLogic();
        $ret = $logic->loginRequireCaptcha();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testRegRequireCaptcha()
    {
        $logic = new SettingsLogic();
        $ret = $logic->regRequireCaptcha();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testSenderFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->senderFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDescription()
    {
        $logic = new SettingsLogic();
        $ret = $logic->description();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDateTimezone()
    {
        $logic = new SettingsLogic();
        $ret = $logic->dateTimezone();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAllowSharePublic()
    {
        $logic = new SettingsLogic();
        $ret = $logic->allowSharePublic();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMaxLengthProjectName()
    {
        $logic = new SettingsLogic();
        $ret = $logic->maxLengthProjectName();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMaxLengthProjectKey()
    {
        $logic = new SettingsLogic();
        $ret = $logic->maxLengthProjectKey();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testEmailPublic()
    {
        $logic = new SettingsLogic();
        $ret = $logic->emailPublic();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAllowGravatars()
    {
        $logic = new SettingsLogic();
        $ret = $logic->allowGravatars();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGravatarServer()
    {
        $logic = new SettingsLogic();
        $ret = $logic->gravatarServer();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testSendMailFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->sendMailFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testIssuePageSize()
    {
        $logic = new SettingsLogic();
        $ret = $logic->issuePageSize();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testTimeFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->timeFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testWeekFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->weekFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testFullDatetimeFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->fullDatetimeFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDatetimeFormat()
    {
        $logic = new SettingsLogic();
        $ret = $logic->datetimeFormat();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testUseISO()
    {
        $logic = new SettingsLogic();
        $ret = $logic->useISO();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAttachmentDir()
    {
        $logic = new SettingsLogic();
        $ret = $logic->attachmentDir();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAttachmentSize()
    {
        $logic = new SettingsLogic();
        $ret = $logic->attachmentSize();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testEnbaleThumb()
    {
        $logic = new SettingsLogic();
        $ret = $logic->enbaleThumb();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testEnableZip()
    {
        $logic = new SettingsLogic();
        $ret = $logic->enableZip();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testPasswordStrategy()
    {
        $logic = new SettingsLogic();
        $ret = $logic->passwordStrategy();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testSendMailer()
    {
        $logic = new SettingsLogic();
        $ret = $logic->sendMailer();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailPrefix()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailPrefix();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailHost()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailHost();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailPort()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailPort();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailAccount()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailAccount();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailPassword()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailPassword();
        $this->assertTrue(is_string($ret));
    }

    /**
     * @throws \Exception
     */
    public function testMailTimeout()
    {
        $logic = new SettingsLogic();
        $ret = $logic->mailTimeout();
        $this->assertTrue(is_numeric($ret));
    }
}
