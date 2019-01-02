<?php

namespace main\app\model;

/**
 * 缓存键表模型操作类
 *
 * @author sven
 *
 */
class CacheKeyModel extends CacheModel
{

    public $prefix = 'main_';

    public $table = 'cache_key';

    public $primaryKey = '`key`';

    public $fields = ' * ';

    /**
     * 用于实现单例模式
     *
     * @var self
     */
    protected static $instance;

    /**
     * CacheKeyModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->gc();
    }

    /**
     * 创建一个自身的单例对象
     * @return CacheKeyModel
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (!isset(self::$instance) || !is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 读取某个模块的缓存键名列表
     * @param string $module 模块名称
     * @return array
     * @throws \Exception
     */
    private function getModuleKeys($module)
    {
        $field = '`key`';
        $where = array('module' => $module);

        $fetchFlag = $this->cache->get($module);
        if ($fetchFlag !== false) {
            return $fetchFlag;
        }
        $results = parent::getRowsByKey($field, $where, null, null, null, false, $module);
        $ret = [];

        foreach ($results as $row) {
            $ret[] = $row['key'];
        }
        return $ret;
    }

    /**
     * 删除某一模块的缓存键名
     * @param string $module 缓存模块名
     * @return int
     * @throws \Exception
     */
    private function deleteModuleKeys($module)
    {
        $where = array('module' => $module);
        $ret = parent::deleteBykey($where, $module);
        return $ret;
    }

    /**
     * 尝试读取缓存
     * @param string $key 缓存键名
     * @return mixed|boolean 如果缓存存在，则返回缓存内容，否则返回false
     * @throws \Exception
     */
    public function getCache($key)
    {
        // 尝试读取缓存
        if (is_object($this->cache)) {
            $cache = $this->cache->get($key);
            return $cache;
        } else {
            return false;
        }
    }

    /**
     * 尝试保存缓存，并记录键名到数据库
     * @param string $module 缓存模块名
     * @param string $key 缓存键名
     * @param mixed $cache 缓存内容
     * @param int $expire 过期时间
     * @return boolean 返回值
     * @throws \Exception
     */
    public function saveCache($module, $key, $cache, $expire = 604800)
    {
        // 尝试放入并记录缓存
        if (is_object($this->cache)) {
            $flag = $this->cache->set($key, $cache, $expire);
            if ($flag) {
                // 先找找看这个键名是否在数据库中
                $row = [];
                $row['module'] = $module;
                $row['key'] = safeStr($key);
                $row['datetime'] = date('Y-m-d H:i:s', time() + $expire);
                $row['expire'] = time() + $expire;
                $this->replaceByKey($row);
                // var_dump($ret);
                $this->cache->redis->sAdd($module, $key);
            }
        }
        return true;
    }

    /**
     * 清理某一个模型的缓存
     * @param string $module 缓存模型名称
     * @return boolean
     * @throws \Exception
     */
    public function clearCache($module)
    {
        if (is_object($this->cache)) {
            $cacheKeysList = $this->getModuleKeys($module);
            if (!empty($cacheKeysList)) {
                foreach ($cacheKeysList as $cache) {
                    $this->cache->delete($cache);
                }
                $this->deleteModuleKeys($module);
            }
        }
        return true;
    }

    /**
     * 删除缓存
     * @param string $key
     * @return boolean
     * @throws \Exception
     */
    public function deleteCache($key)
    {
        if (is_object($this->cache)) {
            $this->cache->delete($key);
        }
        return true;
    }

    /**
     * 一定的概率删除过期的缓存
     * @return bool
     * @throws \Exception
     */
    public function gc()
    {
        if (!is_object($this->cache)) {
            return false;
        }

        $curRate = mt_rand(0, 1000);
        $_config = getConfigVar('cache');
        if (!isset($_config['cache_gc_rate'])) {
            $_config['cache_gc_rate'] = 1;
        }

        if (intval($_config['cache_gc_rate']) < $curRate) {
            return false;
        }

        /*
         * INSERT INTO `cache_key` (`key`, `module`, `expire`, `datetime`) VALUES
         * ('msg/4111/page/1', 'msg/4111', 11111111, '2014-12-23 00:00:00'),
         * ('msg/4111/page/2', 'msg/4111', 11111111, '2014-12-23 00:00:00'),
         * ('msg/4111/page/3', 'msg/4111', 11111111, '2014-12-23 00:00:00');
         */
        $now = time();
        $sql = "SELECT  *  FROM {$this->getTable()} Where `expire` < $now limit 500";
        $this->db->connect();
        $pdo = $this->db->pdo;
        try {
            $stmt = $pdo->prepare($sql, array(
                \PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL
            ));
            $stmt->execute();
            $modules = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)) {
                $key = safeStr($row['key']);
                $modules[$row['module']][] = $key;
            }
            if (!empty($modules)) {
                $pdo->query("Delete from {$this->getTable()} Where  $now>expire  ");
                $this->cache->delete(array_keys($modules));
                foreach ($modules as $keys) {
                    if (!empty($modules)) {
                        $this->cache->delete($keys);
                    }
                }
            }
            $stmt = null;
        } catch (\PDOException $e) {
            $savePath = STORAGE_PATH . '/log/cache/' . date("Y-m-d") . '_cache_key_gc_err.log';
            $content = date("H:i:s") . " " . $e->getMessage() . "\n";
            file_put_contents($savePath, $content, FILE_APPEND);
        }
        return true;
    }
}
