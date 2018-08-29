<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/25 0025
 * Time: 上午 10:24
 */

namespace main\app\ctrl\framework;

use main\app\ctrl\BaseUserCtrl;
use main\app\classes\LogLogic;
use main\app\model\LogBaseModel;

class Log extends BaseUserCtrl
{
    /**
     * 当前用户id
     * @var
     */
    private $user_id;

    /**
     * 当前用户所属公司id
     * @var
     */
    private $company_id;


    public function __construct()
    {
        parent::__construct();
        $this->auth->checkLogin();
        $user = $this->auth->getUser();
        $this->user_id = $user['id'];
        $this->company_id = $user['company_id'];
    }

    /**
     * 操作日志入口页面
     */
    public function pageIndex()
    {
        $data['actions'] = LogBaseModel::getActions() ;
        $this->render('log/index.php' ,$data );

    }

    /**
     * ajax请求日志列表
     */
    public function _list()
    {
        $ret = [];
        $page = request_get('page');
        if (empty($page)) {
            $page = 1;
        } else {
            $page = intval($page);
        }
        $conditions = [];
        $conditions['company_id'] = $this->company_id;
        $remark = '';
        if( isset($_GET['remark']) && !empty( trimStr($_GET['remark']) ) ){
            $remark= request_get('remark');
        }
        if( isset($_GET['user_name']) && !empty( trimStr($_GET['user_name']) ) ){
            $conditions['user_name'] = request_get('user_name');
        }
        if( isset($_GET['action']) && !empty( trimStr($_GET['action']) ) ){
            $conditions['action'] = request_get('action');
        }

        $logLogic = new LogLogic(  );
        $logModel  = LogBaseModel::getInstance();

        $ret['page_str'] = $logLogic->getPageHtml( $conditions,$page );
        $ret['logs'] = $logLogic->query( $conditions,  $page, $remark, $logModel->primaryKey,'desc' );

        $this->ajaxSuccess('ok', $ret);

    }

    /**
     * 日志细节
     */
    public function pageDetail()
    {
        if( !isset($_REQUEST['id']) ){
            echo '参数错误';
            die;
        }
        $id = (int) $_REQUEST['id'];
        $logModel = new LogBaseModel();
        $log = $logModel->getById( $id );
        $this->render('log/detail.php', $log );

    }

    /**
     * 测试插入日志
     */
    public function pageTestAdd( )
    {
        $logModel = new LogBaseModel();

        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time()-10;
        $pre_data['f3'] = 'google';

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';

        $log = new \stdClass();
        $log->uid = $this->user_id;
        $log->user_name = $this->auth->getUser()['username'];
        $log->real_name = $this->auth->getUser()['realname'];
        $log->obj_id = 0;
        $log->module = '日志';
        $log->page = '操作日志';
        $log->action = '编辑';
        $log->remark =  '日志插入测试';
        $log->pre_data = $pre_data;
        $log->cur_data = $cur_data;
        $log->company_id = $this->company_id;
        var_dump( $logModel->add( $log ) ) ;
    }
}