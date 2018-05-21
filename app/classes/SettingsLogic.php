<?php

class SettingsLogic
{
    public $settings;
    /**
     * 显示系统标题
     */
    function showSysTitle()
    {
        return $this->settings['title']['_value'];
    }

    /**
     * 系统开关
     */
    function sysSwitch()
    {
        return $this->settings['open_status']['_value'];
    }

    /**
     * 显示系统日期
     */
    function showDate()
    {
        return $this->settings['open_status']['_value'];
    }
}
