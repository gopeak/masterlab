<?php

namespace main\app\test\unit\classes;

use main\app\classes\AgileLogic;
use main\app\model\issue\IssueStatusModel;
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

    public function testGetNotBacklogLabelIssues()
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
}
