<?php

namespace main\app\test\unit\classes;

use main\app\classes\ProjectLogic;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\test\BaseDataProvider;
use PHPUnit\Framework\TestCase;

/**
 *  ProjectLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestProjectLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * @throws \Exception
     */
    public function testClassSelfCheck()
    {
        $class = new \ReflectionClass('main\app\classes\ProjectLogic');

        $this->assertTrue($class->hasConstant('PROJECT_TYPE_GROUP_SOFTWARE'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_GROUP_BUSINESS'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_SCRUM'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_KANBAN'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_SOFTWARE_DEV'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_PROJECT_MANAGE'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_FLOW_MANAGE'));
        $this->assertTrue($class->hasConstant('PROJECT_TYPE_TASK_MANAGE'));
        $this->assertTrue($class->hasConstant('PROJECT_GET_PARAM_ID'));
        $this->assertTrue($class->hasConstant('PROJECT_CATEGORY_DEFAULT'));
        $this->assertTrue($class->hasConstant('PROJECT_URL_DEFAULT'));
        $this->assertTrue($class->hasConstant('PROJECT_AVATAR_DEFAULT'));
        $this->assertTrue($class->hasConstant('PROJECT_DESCRIPTION_DEFAULT'));
        $this->assertTrue($class->hasConstant('PROJECT_DEFAULT_ISSUE_TYPE_SCHEME_ID'));
        $this->assertTrue($class->hasConstant('PROJECT_SCRUM_ISSUE_TYPE_SCHEME_ID'));

        $this->assertClassHasStaticAttribute('type_all', ProjectLogic::class);
        $this->assertClassHasStaticAttribute('typeAll', ProjectLogic::class);
        $this->assertClassHasStaticAttribute('software', ProjectLogic::class);
        $this->assertClassHasStaticAttribute('business', ProjectLogic::class);
    }

    /**
     * @throws \Exception
     */
    public function testFaceMap()
    {
        $ret = ProjectLogic::faceMap();
        $keys = array_keys($ret);
        $keySeed = mt_rand(0, count($keys)-1);

        $this->assertTrue(array_key_exists('type_name', $ret[$keys[$keySeed]]));
        $this->assertTrue(array_key_exists('type_face', $ret[$keys[$keySeed]]));
        $this->assertTrue(array_key_exists('type_desc', $ret[$keys[$keySeed]]));
    }

    /**
     * @throws \Exception
     */
    public function testGetAllProjectTypeTotal()
    {
        $ret = ProjectLogic::getAllProjectTypeTotal();
        $this->assertTrue(array_key_exists('WHOLE', $ret));
        $this->assertTrue(array_key_exists('SCRUM', $ret));
        $this->assertTrue(array_key_exists('KANBAN', $ret));
        $this->assertTrue(array_key_exists('SOFTWARE_DEV', $ret));
        $this->assertTrue(array_key_exists('PROJECT_MANAGE', $ret));
        $this->assertTrue(array_key_exists('FLOW_MANAGE', $ret));
        $this->assertTrue(array_key_exists('TASK_MANAGE', $ret));

        $total = $ret['WHOLE'];
        unset($ret['WHOLE']);
        $this->assertEquals($total, array_sum($ret));
    }

    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $randString = quickRandom(10);
        $createUid = 99999;
        $projectInfo = array(
            'org_id' => 1,
            'org_path' => 'default',
            'name' => $randString,
            'detail' => 'test-detail',
            'url' => ProjectLogic::PROJECT_URL_DEFAULT,
            'lead' => $createUid,
            'description' => ProjectLogic::PROJECT_DESCRIPTION_DEFAULT . $randString . $randString,
            'key' => strtoupper($randString),
            'default_assignee' => 1,
            'avatar' => ProjectLogic::PROJECT_AVATAR_DEFAULT,
            'category' => ProjectLogic::PROJECT_CATEGORY_DEFAULT,
            'type' => ProjectLogic::PROJECT_TYPE_SCRUM,
            'type_child' => 0,
            'permission_scheme_id' => 0,
            'workflow_scheme_id' => 0,
            'create_uid' => $createUid,
            'create_time' => time(),
        );
        $ectypal = $projectInfo;

        $ret = ProjectLogic::create($projectInfo, $createUid);
        //print_r($ret);
        $this->assertEquals($ret['errorCode'], 0);
        $this->assertNotEmpty($ret['data']);
        $this->assertTrue(array_key_exists('project_id', $ret['data']));
        $projectModel = new ProjectModel();
        $projectModel->deleteById($ret['data']['project_id']);
        $projectIssueTypeSchemeDataModel = new ProjectIssueTypeSchemeDataModel();
        $projectIssueTypeSchemeDataModel->delete(array('project_id' => $ret['data']['project_id']));

        unset($ectypal['name']);
        $ret = ProjectLogic::create($ectypal, $createUid);
        $this->assertEquals($ret['errorCode'], -1);

        $ectypal = $projectInfo;
        unset($ectypal['org_id']);
        $ret = ProjectLogic::create($ectypal, $createUid);
        $this->assertEquals($ret['errorCode'], -1);

        $ectypal = $projectInfo;
        unset($ectypal['key']);
        $ret = ProjectLogic::create($ectypal, $createUid);
        $this->assertEquals($ret['errorCode'], -1);

        $ectypal = $projectInfo;
        unset($ectypal['type']);
        $ret = ProjectLogic::create($ectypal, $createUid);
        $this->assertEquals($ret['errorCode'], -1);

        $ectypal = $projectInfo;
        $ectypal['type'] = 123456;
        $ret = ProjectLogic::create($ectypal, $createUid);
        $this->assertEquals($ret['errorCode'], -1);
    }

    /**
     * @throws \Exception
     */
    public function testFormatAvatar()
    {
        $avatar = '';
        $ret = ProjectLogic::formatAvatar($avatar);
        $this->assertEquals(count($ret), 2);
    }

    /**
     * @throws \Exception
     */
    public function testSelectFilter()
    {
        $logic = new ProjectLogic();
        $ret = $logic->selectFilter();
        $this->assertTrue(is_array($ret));

        if (count($ret) > 0) {
            $keySeed = mt_rand(0, count($ret)-1);
            $itemKey = array_keys($ret[$keySeed]);
            $this->assertTrue(in_array('id', $itemKey));
            $this->assertTrue(in_array('name', $itemKey));
            $this->assertTrue(in_array('username', $itemKey));
            $this->assertTrue(in_array('avatar', $itemKey));
        }

        $searchString = 'JUGG-UNIT-TEST-'.quickRandom(10);
        $ret = $logic->selectFilter($searchString);
        $this->assertEmpty($ret);
    }

    /**
     * @throws \Exception
     */
    public function testProjectListJoinUser()
    {
        $logic = new ProjectLogic();
        $ret = $logic->projectListJoinUser();
        $this->assertTrue(is_array($ret));

        if (count($ret) > 0) {
            $keySeed = mt_rand(0, count($ret)-1);
            $itemKey = array_keys($ret[$keySeed]);

            $this->assertTrue(in_array('id', $itemKey));
            $this->assertTrue(in_array('org_id', $itemKey));
            $this->assertTrue(in_array('org_path', $itemKey));
            $this->assertTrue(in_array('name', $itemKey));
            $this->assertTrue(in_array('url', $itemKey));
            $this->assertTrue(in_array('lead', $itemKey));
            $this->assertTrue(in_array('description', $itemKey));
            $this->assertTrue(in_array('key', $itemKey));
            $this->assertTrue(in_array('pcounter', $itemKey));
            $this->assertTrue(in_array('default_assignee', $itemKey));
            $this->assertTrue(in_array('assignee_type', $itemKey));
            $this->assertTrue(in_array('avatar', $itemKey));
            $this->assertTrue(in_array('category', $itemKey));
            $this->assertTrue(in_array('type', $itemKey));
            $this->assertTrue(in_array('type_child', $itemKey));
            $this->assertTrue(in_array('permission_scheme_id', $itemKey));
            $this->assertTrue(in_array('workflow_scheme_id', $itemKey));
            $this->assertTrue(in_array('create_uid', $itemKey));
            $this->assertTrue(in_array('create_time', $itemKey));
            $this->assertTrue(in_array('leader_username', $itemKey));
            $this->assertTrue(in_array('leader_display', $itemKey));
            $this->assertTrue(in_array('create_username', $itemKey));
            $this->assertTrue(in_array('create_display', $itemKey));
        }
    }

    /**
     * @throws \Exception
     */
    public function testTypeList()
    {
        $project = BaseDataProvider::createProject();

        $logic = new ProjectLogic();
        $ret = $logic->typeList($project['id']);
        $this->assertTrue(is_array($ret));

        $model = new ProjectModel();
        $model->deleteById($project['id']);
    }

    /**
     * @throws \Exception
     */
    public function testFormatProject()
    {
        $project = BaseDataProvider::createProject();
        $ret = ProjectLogic::formatProject($project);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(array_key_exists('first_word', $ret));
        $model = new ProjectModel();
        $model->deleteById($project['id']);
    }

    /**
     * @throws \Exception
     */
    public function testInitRole()
    {
        $project = BaseDataProvider::createProject();

        $ret = ProjectLogic::initRole($project['id']);
        $this->assertTrue(is_array($ret));

        $model = new ProjectModel();
        $model->deleteById($project['id']);

        $model = new ProjectUserRoleModel();
        $model->delete(array('project_id' => $project['id']));

        $model = new ProjectRoleModel();
        $model->delete(array('project_id' => $project['id']));

        $model = new ProjectRoleRelationModel();
        $model->delete(array('project_id' => $project['id']));
    }
}
