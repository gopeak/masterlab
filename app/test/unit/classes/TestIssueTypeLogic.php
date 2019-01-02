<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueTypeLogic;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use PHPUnit\Framework\TestCase;

/**
 *  IssueTypeLogic 测试
 * @package main\app\test\unit\classes;
 */
class TestIssueTypeLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        IssueTypeLogicDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testGetIssueType()
    {
        $logic = new IssueTypeLogic();
        $rows = $logic->getIssueType(null);
        $this->assertNotEmpty($rows);

        $info['type'] = IssueTypeLogic::SCRUME_ISSUE_TYPE_SCHEME_ID;
        $projectId = IssueTypeLogicDataProvider::initProject($info)['id'];
        $rows2 = $logic->getIssueType($projectId);
        $this->assertNotEmpty($rows2);
        //$this->assertNotEquals($rows, $rows2);

        $projectId = IssueTypeLogicDataProvider::initProject($info)['id'];
        $schemeId =  '2';
        $model = new ProjectIssueTypeSchemeDataModel();
        $insertRow = [];
        $insertRow['project_id'] = $projectId;
        $insertRow['issue_type_scheme_id'] = $schemeId;
        list($ret, $insertId) = $model->insert($insertRow);
        $this->assertTrue($ret);
        $rows3 = $logic->getIssueType($projectId);
        $this->assertNotEmpty($rows3);
        $model->deleteById($insertId);
        // $this->assertNotEquals($rows2, $rows3);
    }

    /**
     * @throws \Exception
     */
    public function testGetAdminIssueStatus()
    {
        $logic = new IssueTypeLogic();

        $rows = $logic->getAdminIssueTypes();
        $this->assertNotEmpty($rows);
        $idArr = [];
        foreach ($rows as $item) {
            $this->assertArrayHasKey('scheme_ids', $item);
            $idArr[] = (int)$item['id'];
        }
        // status id 是否升序排序
        $this->assertTrue($idArr[1]>$idArr[0]);
    }

    /**
     * @throws \Exception
     */
    public function testGetAdminIssueTypesBySplit()
    {
        $logic = new IssueTypeLogic();

        $rows = $logic->getAdminIssueTypesBySplit();
        $this->assertNotEmpty($rows['issue_types']);
        $this->assertNotEmpty($rows['issue_type_schemes']);
        $this->assertNotEmpty($rows['issue_type_schemes_data']);
    }

    /**
     * @throws \Exception
     */
    public function testGetAdminIssueTypeSchemes()
    {
        $logic = new IssueTypeLogic();
        $rows = $logic->getAdminIssueTypeSchemes();
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testUpdateSchemeTypes()
    {
        $schemeId = IssueTypeLogicDataProvider::initScheme()['id'];
        $logic = new IssueTypeLogic();
        list($ret, $updatedNum) = $logic->updateSchemeTypes($schemeId, []);
        $this->assertFalse($ret, $updatedNum);

        $typeIdArr = [];
        $typeIdArr[] = IssueTypeModel::getInstance()->getIdByKey('bug');
        $typeIdArr[] = IssueTypeModel::getInstance()->getIdByKey('task');
        list($ret, $updatedNum) = $logic->updateSchemeTypes($schemeId, $typeIdArr);
        $this->assertTrue($ret, $updatedNum);
        $this->assertEquals(count($typeIdArr), (int)$updatedNum);

        $model = new IssueTypeSchemeItemsModel();
        $model->deleteBySchemeId($schemeId);
    }
}
