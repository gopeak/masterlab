<?php

class Page
{
    private $total; //总记录
    private $pagesize;//每页显示多少条
    private $limit;//limit
    private $page;//当前页码
    private $pagenum;//总页码
    private $url;//地址
    private $bothnum;//当前页码两边保持数字分页的量
    private static $_instance = null;
    private $offset;
    private $is_show_info = true;
    /**
     * @param int $_total 是数据集的总条数
     * @param int $_pagesize 是每页显示的数量
     * @return null|Page
     */
    public static function getInstance($_total, $_pagesize)
    {
        if (self::$_instance == null) {
            self::$_instance = new self($_total, $_pagesize);
        }
        return self::$_instance;
    }
    /**
     * @param int $_total  是数据集的总条数
     * @param int $_pagesize  是每页显示的数量
     */
    private function __construct($_total, $_pagesize)
    {
        $this->total = $_total ? $_total : 1;
        $this->pagesize = $_pagesize;
        $this->pagenum = ceil($this->total / $this->pagesize);
        $this->page = $this->setPage();
        $this->offset = intval(($this->page - 1) * $this->pagesize);
        $this->limit = "LIMIT " . ($this->page - 1) * $this->pagesize . ",$this->pagesize";
        $this->url = $this->setUrl();
        $this->bothnum = 2;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPagenum()
    {
        return $this->pagenum;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPagesize()
    {
        return $this->pagesize;
    }

    public function getTotal()
    {
        return $this->total;
    }
    
    public function getOffset()
    {
        return $this->offset;
    }
    public function getShowInfo()
    {
        return $this->is_show_info;
    }
    public function setShowInfo($bool)
    {
        $this->is_show_info = $bool;
    }
    //拦截器
    public function __get($_key)
    {
        return $this->$_key;
    }
    //获取当前页码
    private function setPage()
    {
        if (!empty($_GET['page'])) {
            if ($_GET['page'] > 0) {
                if ($_GET['page'] > $this->pagenum) {
                    return $this->pagenum;
                } else {
                    return (int)$_GET['page'] ?: 1;
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }
    //获取地址
    private function setUrl()
    {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        if (isset($_par['query'])) {
            parse_str($_par['query'], $_query);
            unset($_query['page']);
            $_url = $_par['path'] . '?' . http_build_query($_query);
        }

        if (strpos($_url, '?') === false) {
            $_url .= '?';
        }
        return $_url;
    }
    //数字目录
    private function pageList()
    {
        $_pagelist = '';
        for ($i = $this->bothnum; $i >= 1; $i--) {
            $_page = $this->page - $i;
            if ($_page < 1) {
                continue;
            }
            $_pagelist .= ' <li><a href="' . $this->url . '&page='.$_page.'">'. $_page . '</a></li> ';
        }
        $_pagelist .= ' <li class="active"><span class="me">' . $this->page . '</span></li> ';
        for ($i = 1; $i <= $this->bothnum; $i++) {
            $_page = $this->page + $i;
            if ($_page > $this->pagenum) {
                break;
            }
            $_pagelist .= ' <li><a href="' . $this->url . '&page=' . $_page . '">' . $_page . '</a></li> ';
        }
        return $_pagelist;
    }
    //上一页
    private function info()
    {
        if ($this->is_show_info) {
            return '<span>每页 '.$this->getPagesize().' 条,共 '.$this->getTotal().' 条数据</span>';
        }
    }
    //首页
    private function first()
    {
        if ($this->page > $this->bothnum + 1) {
            return ' <li><a href="' . $this->url . '">1</a></li> <li><a>...</a></li>';
        }
    }
    //上一页
    private function prev()
    {
        if ($this->page == 1) {
            return '<li class="disabled"><span>上一页</span></li>';
        }
        return ' <li><a href="' . $this->url . '&page=' . ($this->page - 1) . '"><span aria-hidden=\"true\">上一页</span></a></li> ';
    }
    //下一页
    private function next()
    {
        if ($this->page == $this->pagenum) {
            return '<li class="disabled"><span>下一页</span></li>';
        }
        return ' <li><a href="' . $this->url . '&page=' . ($this->page + 1) . '"><span aria-hidden=\"true\">下一页</span></a></li> ';
    }
    //尾页
    private function last()
    {
        if ($this->pagenum - $this->page > $this->bothnum) {
            return ' <li><a>...</a></li><li><a href="' . $this->url . '&page=' . $this->pagenum . '">' . $this->pagenum . '</a></li> ';
        }
    }
    //分页信息
    public function showpage()
    {
        $_page = '';
        $_page .= $this->info();
        $_page .= $this->prev();
        $_page .= $this->first();
        $_page .= $this->pageList();
        $_page .= $this->last();
        $_page .= $this->next();
        return $_page;
    }
    
    //追加参数到url中, 如果已经存在,就替换
    public function appendVars($vars)
    {
        $url_items = parse_url($this->url);
        
        if (isset($url_items['query'])) {
            parse_str($url_items['query'], $query);
            $new_vars = array_merge($query, $vars);
        } else {
            $new_vars = $vars;
        }
        
        $this->url = $url_items['path'] . '?' . http_build_query($new_vars);
    }

    public function renderPage($layout=true, $is_show_info = true)
    {
        $this->is_show_info = (bool) $is_show_info;
        $bothnum = $this->bothnum;

        // 前后
        $next_page = $this->page + 1;
        $prev_page = $this->page - 1;
        $info = $this->info();
        $prev = ($this->page == 1) ? "<a href=\"#\" class=\"disabled\">&lt;</a>" : "<a href=\"{$this->url}&page={$prev_page}\">&lt;</a>";
        $next = ($this->page == $this->pagenum) ? "<a href=\"#\" class=\"disabled\">&gt;</a>" : "<a href=\"{$this->url}&page={$next_page}\">&gt;</a>";
        $first = ($this->page > $bothnum + 1) ? "<a href=\"{$this->url}\">1</a><span class=\"ellipsis\">...</span>" : "";
        $last = ($this->pagenum - $this->page > $bothnum) ? "<span class=\"ellipsis\">...</span><a href=\"{$this->url}&page={$this->pagenum}\">{$this->pagenum}</a>" : "";

        // 列表
        $list = '';
        for ($i = $bothnum; $i >= 1; $i--) {
            $page = $this->page - $i;
            if ($page < 1) {
                continue;
            }
            $list .= "<a href=\"{$this->url}&page={$page}\">{$page}</a>";
        }
        $list .= "<a href=\"#\" class=\"current\">{$this->page}</a>";
        for ($i = 1; $i <= $bothnum; $i++) {
            $page = $this->page + $i;
            if ($page > $this->pagenum) {
                break;
            }
            $list .= "<a href=\"{$this->url}&page={$page}\">{$page}</a>";
        }

        // 跳转到分页js
        $page_go_btn_id = 'page_go_btn_' . rand();
        $page_go_input_id = 'page_go_input_' . rand();
        
        $js = <<<EOD
<script>
$(function(){
    // 点击跳转到分页
    $('#$page_go_btn_id').click(function(){
        go_to_page_$page_go_input_id();
    });
    // 按下确定键跳转到分页
    $('#$page_go_input_id').keydown(function(event){
        if (event.keyCode == 13){
            go_to_page_$page_go_input_id();
        }
    });
    // 执行跳转到分页
    function go_to_page_$page_go_input_id(){
        var input = $('#$page_go_input_id');
        page = input.val();
        url = input.data('url');
        window.location.href = url + '&page=' + page;
    }
});
</script>
EOD;
        $js = '<script src="'.ROOT_URL.'assets/vendor/jquery.min.js"></script>'.$js;

        // 拼接返回
        //$layoutClass = $layout ? 'layout' : '';
        $layoutClass = '';
        $html = "<div class=\"{$layoutClass} pad-t-lg pad-b-lg\"><div class=\"page\">";
        $html .= $info. $prev . $first . $list . $last . $next;
        $html .= "<label>到<input type=\"text\" class=\"page-num\" name=\"\" id=\"{$page_go_input_id}\" data-url=\"{$this->url}\">页</label>
                  <input type=\"submit\" value=\"GO\" class=\"page-go btn btn-white\" name=\"\" id=\"{$page_go_btn_id}\">
                  </div></div>";
        $html .= $js;
        return $html;
    }
}
