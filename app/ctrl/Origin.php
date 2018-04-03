<?php

namespace main\app\ctrl;

use main\app\classes\OriginLogic;
use main\app\model\OriginModel;
use main\app\model\project\ProjectModel;

class Origin extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {

        $data = [];
        $data['title'] = '组织';
        $data['nav_links_active'] = 'origin';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/origin/main.php', $data);
    }


    public function fetchAll()
    {
        $data = [];
        $originLogic = new OriginLogic();
        $origins = $originLogic->getOrigins();

        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();

        $originProjects = [];
        foreach ($projects as $p ){
            $originProjects[$p['origin_id']][] = $p;
        }
        foreach ($origins as &$origin ){
            $id = $origin['id'];
            $origin['projects'] = [];
            $origin['is_more'] = false;
            if(isset($originProjects[$id])){
                $origin['projects'] = $originProjects[$id];
                if(count($origin['projects'])>10){
                    $origin['is_more'] = true;
                    $origin['projects'] = array_slice($origin['projects'], 0, 10);
                }
            }
        }
        unset($projects,$originProjects);
        $data['origins'] = $origins;
        $this->ajaxSuccess('success', $data);
    }


    public function create()
    {
        $data = [];
        $data['title'] = '创建组织';
        $data['nav_links_active'] = 'origin';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/origin/form.php', $data);
    }

    /**
     * 添加origin
     */
    public function add( $params=[] )
    {
        // @todo 判断权限:全局权限和项目角色

        $uid = $this->get_current_uid();

        if (!isset($params['path']) || empty(trimStr($params['path']))) {
            $this->ajaxFailed('param_error:path_is_null');
        }
        if ( !isset($params['name']) || empty(trimStr($params['name'])) ) {
            $this->ajaxFailed('param_error:name_is_null');
        }
        $path = $params['path'];
        $model = new OriginModel();
        $origin = $model->getByPath($path);
        if(isset($origin['id'])){
            $this->ajaxFailed('path_exists');
        }
        $name = $params['name'];
        $origin = $model->getByName($name);
        if(isset($origin['id'])){
            $this->ajaxFailed('name_exists');
        }

        $info = [];
        $info['path'] = $params['path'];
        $info['name'] = $params['name'];
        $info['description'] = $params['description'];
        $info['avatar'] = $params['avatar'];
        $info['scope'] = $params['scope'];
        $info['created'] = time();
        $info['created_uid'] = $uid;

        list( $ret, $insertId) = $model->insert($info);
        if( !$ret ){
            $this->ajaxFailed('add_failed,error:'.$insertId);
        }

        $this->ajaxSuccess('add_success');
    }

    public function update( $params )
    {
        // @todo 判断权限:全局权限和项目角色
        $id = null;
        if (!isset($_REQUEST['id']) ) {
            $this->ajaxFailed('param_error:id_is_null');
        }
        $id = (int)$_REQUEST['id'];

        $model = new OriginModel();
        $origin = $model->getById( $id );

        $uid = $this->get_current_uid();

        $info = [];
        if (isset($params['name']) ) {
            $info['name'] = $params['name'];
        }

        if( isset($params['description']) ){
            $info['description'] =  $params['description'];
        }

        if( isset($params['avatar']) ){
            $info['avatar'] =  $params['avatar'];
        }

        $noModified = true;
        foreach ($info as $k=>$v){
            if($v!=$origin[$k]){
                $noModified = false;
            }
        }
        if($noModified){
            $this->ajaxSuccess('success');
        }

        if( !empty($info) ){
            $info['updated'] = time();
        }

        list( $ret, $affectedRows ) = $model->updateById($id,$info);
        if( !$ret ){
            $this->ajaxFailed('update_failed,error:'.$id);
        }

        $this->ajaxSuccess('success');
    }

}
