<?php

namespace main\app\classes;

use main\app\model\SettingModel;

/**
 * 系统全局设置的各种配置属性
 *
 */
class Settings
{
    //时间类型列表
    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;
    public $timeTypeList = [
        'time_format',   //* 时间格式
        'datetime_format', //* 日期格式(年月日)
        'week_format',  //* 星期格式
        'full_datetime_format' //* 完整日期/时间格式
    ];

    /**
     * 创建一个自身的单例对象
     * @throws \PDOException
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance) || !is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 格式化时间戳为相应的时间格式
     * @param int $timestamp
     * @param string $timeType
     * @return false|string
     * @throws \Exception
     */
    public function time($timestamp = 0, $timeType = 'full_datetime_format')
    {

        if (!in_array($timeType, $this->timeTypeList)) {
            return 'timeType Error';
        }

        $settingModel = new SettingModel();
        $rows = $settingModel->getSettingByKey($timeType);

        if (!empty($rows)) {
            $_value = $rows['_value'];

            return date($_value, $timestamp);
        }

        return 'timeType is Empty';
    }


    /**
     * 附件上传的系统参数
     * @return array
     * @throws \Exception
     */
    public function attachment()
    {
        $settingModel = new SettingModel();
        $rows = $settingModel->getSettingByModule('attachment');

        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $data[$row['_key']] = $row['_value'];
            }
            $attachmentDir = $data['attachment_dir'];
            if (!empty($attachmentDir)) {
                preg_match_all("/(?:\{{)(.*)(?:\}})/i", $attachmentDir, $rs);
                $dirName = str_replace($rs[0][0], '', $attachmentDir);
                $data['attachment_dir'] = constant($rs[1][0]) . $dirName . '/';
                $data['attachment_size'] = (int)$data['attachment_size'] * 1024 * 1024;
            }
        }
        return $data;
    }
}
