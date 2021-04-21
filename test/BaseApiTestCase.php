<?php
namespace main\test;

use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectVersionModel;

/**
 * Class BaseApiTestCase
 * @package main\test
 */
class BaseApiTestCase extends BaseTestCase
{
    public static $accessToken = '';
    public static $projectId = 0;

    /**
     * 初始化测试资源
     */
    public static function setUpBeforeClass()
    {
        self::createProject();
    }

    /**
     * 释放初始化的资源
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public static function tearDownAfterClass()
    {
        self::deleteProjectById(self::$projectId);
    }


    /**
     * 创建项目
     */
    public static function createProject()
    {
        $accessToken = self::$accessToken;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/projects/v1/?access_token=' . $accessToken;

        $response = $client->post($url, [
            'form_params' => [
                'name' => 'test-' . quickRandomStr(50),
                'org_id' => 1,
                'key' => 'TEST' . strtoupper(quickRandomStr(15)),
                'lead' => 1,
                'type' => 10,
                'description' => '描述：' . quickRandomStr(),
                'project_tpl_id' => 1,
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        self::$projectId = $respArr['data']['project_id'];
    }

    /**
     * 删除项目
     * @param $projectId
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public static function deleteProjectById($projectId)
    {
        $uid = 1;

        $model = new ProjectModel($uid);

        $model->db->beginTransaction();

        $retDelProject = $model->deleteById($projectId);
        if ($retDelProject) {
            // 删除对应的事项
            $issueModel = new IssueModel();
            $issueModel->deleteItemsByProjectId($projectId);

            // 删除版本
            $projectVersionModel = new ProjectVersionModel($uid);
            $projectVersionModel->deleteByProject($projectId);

            // 删除模块
            $projectModuleModel = new ProjectModuleModel($uid);
            $projectModuleModel->deleteByProject($projectId);

            // 删除标签
            $projectLabelModel = new ProjectLabelModel();
            $projectLabelModel->deleteByProject($projectId);

            // 删除分类
            $projectCatalogLabelModel = new ProjectCatalogLabelModel();
            $projectCatalogLabelModel->deleteByProject($projectId);

            // 删除初始化的角色
            $projectUserRoleModel = new ProjectUserRoleModel();
            $projectUserRoleModel->deleteByProject($projectId);

        }

        $model->db->commit();
    }
}