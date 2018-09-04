<?php

namespace main\lib;

class SlowLog
{
    private $file;
    private $folder;
    private $storage_path;
    const MAX_FILE_SIZE = 52428800;
    private $pattern;
    protected static $instance;

    /**
     * @param string $storagePath
     * @return SlowLog
     */
    public static function getInstance($storagePath = APP_PATH.'storage/log/slow/sql')
    {
        $index = md5($storagePath);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($storagePath);
        }
        return self::$instance[$index];
    }

    public function __construct($storagePath = APP_PATH.'storage/log/slow/sql')
    {
        $this->pattern = new Pattern();
        $this->storage_path = $storagePath;
    }

    public function setFolder($folder)
    {
        $logsPath = $this->storage_path . '/' . $folder;

        if (file_exists($logsPath)) {
            $this->folder = $folder;
        }
    }

    public function setFile($file)
    {
        $file = $this->pathToLogFile($file);

        if (file_exists($file)) {
            $this->file = $file;
        }
    }

    public function pathToLogFile($file)
    {
        $logsPath = $this->storage_path;
        $logsPath .= ($this->folder) ? '/' . $this->folder : '';

        if (file_exists($file)) {
            return $file;
        }

        $file = $logsPath . '/' . $file;

        if (dirname($file) !== $logsPath) {
            throw new \Exception('No such log file');
        }

        return $file;
    }

    /**
     * @return string
     */
    public function getFolderName()
    {
        return $this->folder;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return basename($this->file);
    }

    /**
     * 获取一个日志文件的数据
     * @return array
     */
    public function getView($filename)
    {
        $log = array();

        if (!$this->file) {
            $log_file = (!$this->folder) ? $this->getFiles() : $this->getFolderFiles();
            if (!count($log_file)) {
                return [];
            }
            // $this->file = $log_file[0];
            $this->file = $this->storage_path.'/'.$filename;
        }

        if (filesize($this->file) > self::MAX_FILE_SIZE) {
            return null;
        }

        $file = file_get_contents($this->file);

        preg_match_all($this->pattern->getPattern('logs'), $file, $headings);
        if (!is_array($headings)) {
            return $log;
        }

        $log_data = preg_split($this->pattern->getPattern('logs'), $file);
        if ($log_data[0] < 1) {
            array_shift($log_data);
        }

        foreach ($headings as $h) {
            for ($i = 0, $j = count($h); $i < $j; $i++) {
                if (strpos(strtolower($h[$i]), '[20') === 0) {
                    preg_match($this->pattern->getPattern('current_log',0) . $this->pattern->getPattern('current_log',1), $h[$i], $current);

                    // dump($current, true);
                    if (!isset($current[2])) {
                        continue;
                    }

                    $log[] = array(
                        'sql' => $current[2],
                        'date' => $current[1],
                        'exec_time' => $current[3],
                        'stack' => preg_replace("/^\n*/", '', $log_data[$i])
                    );
                }

            }
        }

        return array_reverse($log);
    }

    /**
     * @return array
     */
    public function getFolders()
    {
        $folders = glob($this->storage_path.'/*', GLOB_ONLYDIR);
        if (is_array($folders)) {
            foreach ($folders as $k => $folder) {
                $folders[$k] = basename($folder);
            }
        }
        return array_values($folders);
    }

    public function getFolderFiles($basename = false)
    {
        return $this->getFiles($basename, $this->folder);
    }

    public function getFiles($basename = false, $folder = '')
    {
        $pattern = '*.log';
        $files = glob($this->storage_path.'/' . $folder . '/' . $pattern, preg_match($this->pattern->getPattern('files'), $pattern) ? GLOB_BRACE : 0);
        $files = array_reverse($files);

        $files = array_filter($files, 'is_file');
        if ($basename && is_array($files)) {
            foreach ($files as $k => $file) {
                $files[$k] = basename($file);
            }
        }

        return array_values($files);
    }


    /**
     * 记录日志
     */
    public function write($sql, $execTime)
    {
        if ($execTime > 2) {  //>2秒
            $put = '['.date('Y-m-d H:i:s').'] ';
            $put .= $sql;
            $put .= ' in '.$execTime.'s'. "\n";
            $put .= $this->printStackTrace();
            file_put_contents($this->storage_path.'/'.date('Y-m-d').'.log', $put, FILE_APPEND|LOCK_EX);
        }
    }

    private function printStackTrace()
    {
        $out = '';
        $array = debug_backtrace();
        unset($array[0]);
        foreach ($array as $row) {
            if (isset($row['file'])) {
                $out .= $row['file'].': '.$row['line'].'行, 调用方法: ' . $row['function']."\n";
            }
        }
        return $out;
    }
}


class Pattern
{
    private $patterns = [
        'logs' => '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/',
        'current_log' => [
            //'/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
            //'(.*?)( in .*?:[0-9]+)?$/i'
            '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\](.*?) in ',
            '(.*?)([0-9]+\.[0-9]+)?$/i'
        ],
        'files' => '/\{.*?\,.*?\}/i',
    ];


    public function all()
    {
        return array_keys($this->patterns);
    }

    public function getPattern($pattern, $position = null)
    {
        if ($position !== null) {
            return $this->patterns[$pattern][$position];
        }
        return $this->patterns[$pattern];
    }
}