<?php
namespace main\app\ctrl\project;

use main\app\ctrl\BaseUserCtrl;
class Base extends BaseUserCtrl
{
    protected function getProjectRootRoute()
    {
        $orgName = $_GET['_target'][0];
        $proKey = $_GET['_target'][1];
        return '/'.$orgName.'/'.$proKey;
    }

    public function __call($name, $args)
    {
        $this->redirect('/projects');
    }
}