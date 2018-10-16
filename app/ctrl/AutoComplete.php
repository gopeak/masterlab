<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/10/23 0023
 * Time: 下午 3:05
 */

namespace main\app\ctrl;

use main\app\classes\ConfigLogic;
use main\app\classes\UserLogic;
use main\app\model\project\ProjectModel;

/**
 * Class AutoComplete
 * @package main\app\ctrl
 */
class AutoComplete extends BaseCtrl
{
    public function users()
    {
        header('Content-Type:application/json; charset=utf-8');

        $configLogic = new ConfigLogic();
        $users = $configLogic->getUsers();
        $arr = [];
        foreach ($users as $user) {
            UserLogic::formatAvatarUser($user);
            $tmp = [];
            $tmp['id'] = $user['uid'];
            $tmp['name'] = $user['display_name'];
            $tmp['username'] = $user['username'];
            $tmp['avatar_url'] = $user['avatar'];
            $arr[] = $tmp;
        }
        echo json_encode($arr);
        die;
        /*
                echo '[

          {
            "id": 1,
            "name": "Administrator",
            "username": "root",
            "avatar_url": "http://www.gravatar.com/avatar/fe9832e90a7fbb5fff87bac06a4adff4?s=80\u0026d=identicon"
          },
          {
            "id": 22,
            "name": "gitlab-runner",
            "username": "gitlab-runner",
            "avatar_url": "http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80\u0026d=identicon"
          }
        ]';*/
    }

    /**
     * @param $search
     */
    public function projects($search)
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->filterByNameOrKey(trim($search));

        $final = array();
        foreach ($projects as &$item) {
            $item['path'] = $item['org_path'];
            $final[] = array(
                'id' => $item['id'],
                'http_url_to_repo' => $search,
                'web_url' => ROOT_URL . $item['path'] . '/' . $item['key'],
                'name' => $item['name'],
                'name_with_namespace' => $item['path'] . ' / ' . $item['key'],
                'path' => $item['path'],
                'path_with_namespace' => $item['path'] . '/' . $item['key'],
            );
        }
        unset($item);

        header('Content-Type:application/json');
        echo json_encode($final);
        exit;
    }
}
