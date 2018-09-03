<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
/**
 * ProjectModel 测试类
 * User: Lyman
 */
class TestProjectModel extends TestBaseProjectModel
{

    public static $projectData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
    }


    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {

    }


    /**
     * 主流程
     */
    public function testMain()
    {
        $obj = new ProjectModel;
        $key = $obj->getKeyById(10002);
        $this->assertEquals($key, 'IP');
    }


    /**
     * 获取项目总数
     * @return number
     */
    public function getAllCount()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getAll()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function filterByType()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function filterByNameOrKey()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 获取所有项目类型的项目数量
     */
    public function getAllProjectTypeCount()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getFilter()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function updateById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getKeyById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getNameById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getByKey()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getByName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function getsByOrigin()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function checkNameExist()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function checkIdNameExist()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function checkKeyExist()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function checkIdKeyExist()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }








}
