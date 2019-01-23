<?php
namespace main\app\ctrl\project;

use main\app\ctrl\BaseUserCtrl;

/**
 * Class Base
 * @package main\app\ctrl\project
 */
class Base extends BaseUserCtrl
{
    protected $dataMerge = array();

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * @return string
     */
    protected function getProjectRootRoute()
    {
        $orgName = $_GET['_target'][0];
        $proKey = $_GET['_target'][1];
        return ROOT_URL.$orgName.'/'.$proKey;
    }

    /**
     * @param $name
     * @param $args
     */
    public function __call($name, $args)
    {
        $this->redirect(ROOT_URL.'/projects');
    }
}