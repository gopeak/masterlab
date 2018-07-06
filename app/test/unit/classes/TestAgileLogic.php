<?php

namespace main\app\test\unit\classes;

use main\app\classes\AgileLogic;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\ProjectLabelModel;
use PHPUnit\Framework\TestCase;

/**
 * 敏捷模块业务逻辑
 * Class AgileLogic
 * @package main\app\test\logic
 */
class TestAgileLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        AgileLogicDataProvider::clear();
    }



    public function testGetSprints()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $sprint1 = AgileLogicDataProvider::initSprint($info);
        AgileLogicDataProvider::initSprint($info);
        AgileLogicDataProvider::initSprint($info);

        // 2.测试 getSprints
        $agileLogic = new AgileLogic();
        $sprints = $agileLogic->getSprints($projectId);
        $this->assertCount(3, $sprints);
        foreach ($sprints as $item) {
            if ($sprint1['id'] == $item['id']) {
                foreach ($sprint1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetBacklogIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogic::BACKLOG_VALUE;
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getBacklogIssues
        $agileLogic = new AgileLogic();
        $backlogs = $agileLogic->getBacklogIssues($projectId);
        $this->assertCount(3, $backlogs);
        foreach ($backlogs as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetNotBacklogIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogicDataProvider::initSprint([])['id'];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getNotBacklogIssues
        $agileLogic = new AgileLogic();
        $issues = $agileLogic->getNotBacklogIssues($projectId);
        $this->assertCount(3, $issues);
        foreach ($issues as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetNotBacklogLabelIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogicDataProvider::initSprint([])['id'];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        $issue2 = AgileLogicDataProvider::initIssue($info);
        $issue3 = AgileLogicDataProvider::initIssue($info);
        $this->assertNotEmpty($issue1);
        $this->assertNotEmpty($issue2);
        $this->assertNotEmpty($issue3);

        $projectLabelModel = new ProjectLabelModel();
        list(, $labelId1) = $projectLabelModel->insertItem(['project_id' => $projectId, 'title' => 'test-title']);
        list(, $labelId2) = $projectLabelModel->insertItem(['project_id' => $projectId, 'title' => 'test-title2']);
        $issueLabelModel = new IssueLabelDataModel();
        $issueLabelModel->insertItemByIssueId($issue1['id'], ['label_id' => $labelId1]);
        $issueLabelModel->insertItemByIssueId($issue1['id'], ['label_id' => $labelId2]);
        $issueLabelModel->insertItemByIssueId($issue2['id'], ['label_id' => $labelId1]);
        $issueLabelModel->insertItemByIssueId($issue2['id'], ['label_id' => $labelId2]);
        $issueLabelModel->insertItemByIssueId($issue3['id'], ['label_id' => $labelId1]);
        $issueLabelModel->insertItemByIssueId($issue3['id'], ['label_id' => $labelId2]);

        // 2.测试 getNotBacklogIssues
        $agileLogic = new AgileLogic();
        $issues = $agileLogic->getNotBacklogLabelIssues($projectId);
        $this->assertCount(3, $issues);
        foreach ($issues as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
            $this->assertTrue(isset($item['label_data']));
            $this->assertNotEmpty($item['label_data']);
            $labelDataArr = explode(',', $item['label_data']);
            $this->assertTrue(in_array($labelId1, $labelDataArr));
            $this->assertTrue(in_array($labelId2, $labelDataArr));
        }
    }

    public function testGetNotBacklogSprintIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogicDataProvider::initSprint([])['id'];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getNotBacklogIssues
        $agileLogic = new AgileLogic();
        $issues = $agileLogic->getNotBacklogSprintIssues($info['sprint']);
        $this->assertCount(3, $issues);
        foreach ($issues as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetClosedIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('close');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getNotBacklogIssues
        $agileLogic = new AgileLogic();
        $issues = $agileLogic->getClosedIssues($projectId);
        $this->assertCount(3, $issues);
        foreach ($issues as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetClosedIssuesBySprint()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogicDataProvider::initSprint([])['id'];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('close');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getNotBacklogIssues
        $agileLogic = new AgileLogic();
        $issues = $agileLogic->getClosedIssuesBySprint($info['sprint']);
        $this->assertCount(3, $issues);
        foreach ($issues as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }

    public function testGetSprintIssues()
    {
        // 1.新增3条sprint记录
        $projectId = AgileLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogicDataProvider::initSprint([])['id'];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $issue1 = AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);
        AgileLogicDataProvider::initIssue($info);

        // 2.测试 getBacklogIssues
        $agileLogic = new AgileLogic();
        $backlogs = $agileLogic->getSprintIssues($info['sprint'], $projectId);
        $this->assertCount(3, $backlogs);
        foreach ($backlogs as $item) {
            if ($issue1['id'] == $item['id']) {
                foreach ($issue1 as $key => $val) {
                    if (isset($item[$key])) {
                        $this->assertEquals($val, $item[$key]);
                    }
                }
            }
        }
    }
}
