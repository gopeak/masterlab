<?php

namespace main\app\model;


/**
 *
 * 操作记录基类model
 * @author Sven
 */
class LogOperatingModel extends DbModel
{
    public $prefix = 'log_';

    public $table = 'operating';

    public $fields = ' * ';

    public $primaryKey = 'id';

    const ACT_ADD = '新增';
    const ACT_EDIT = '编辑';
    const ACT_DELETE = '删除';


    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;


    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * 获取操作项
     * @return array
     */
    public static function getActions()
    {
        $reflect = new \ReflectionClass(__CLASS__);
        $constants = $reflect->getConstants();
        $actions = [];
        if (!empty($constants)) {
            foreach ($constants as $k => $c) {
                if (strpos($k, 'ACT_') === 0) {
                    $actions[$k] = $c;
                }
            }
        }
        return $actions;
    }

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }


    public function getById($id, $fields = '*')
    {
        $row = $this->getRowById($id, $fields);
        if (isset($row['pre_data'])) {
            $row['pre_data'] = json_decode($row['pre_data'], true);
        }
        if (isset($row['cur_data'])) {
            $row['cur_data'] = json_decode($row['cur_data'], true);
        }
        return $row;
    }


    /**
     * 通过对象id获取所有相关的日志信息
     * @param $obj_id
     * @param string $fields
     * @return array
     */
    public function getsByObj($obj_id, $fields = '*')
    {
        $sql = " SELECT {$fields} FROM {$this->getTable()} Where obj_id='$obj_id' order by id desc ";
        $rows = $this->db->getRows($sql);
        return $rows;
    }


    /**
     * 添加日志,需要传入一个对象，取出其public属性作为数据
     * @param  \stdClass $log
     * @return  array [$ret,$msg]
     */
    public function add($log)
    {
        if (is_object($log)) {
            $log = (array)$log;
        }

        if (isset($log['pre_data'])) {
            $log['pre_data'] = $this->convert2ObjectJson($log['pre_data']);
        }
        if (isset($log['cur_data'])) {
            $log['cur_data'] = $this->convert2ObjectJson($log['cur_data']);
        }

        if (!isset($log['ip'])) {
            $log['ip'] = getIp();
        }

        if (!isset($log['time'])) {
            $log['time'] = time();
        }
        return parent::insert($log);
    }

    /**
     * 判断参数是如果为数组或者对象,则转换为对象json
     * @param $data
     * @return string
     */
    private function convert2ObjectJson($data)
    {
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
            if ($data === false) {
                $data = '{}';
            }
        }
        return $data;
    }
}
