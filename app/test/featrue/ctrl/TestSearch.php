<?php

namespace main\app\test\featrue;

use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;
use main\app\test\BaseAppTestCase;

/**
 *
 * @link
 */
class TestSearch extends BaseAppTestCase
{
    public static $clean = [];

    public static $users = [];

    public static $activityArr = [];

    public static $projectArr = [];

    public static $issueArr = [];

    public static $model = null;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // 1.插入项目数据
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['name'] = '测试项目Search' . $i;
            self::$projectArr[] = BaseDataProvider::createProject();
        }

        // 2.插入事项
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['summary'] = '测试事项 '.$i;
            $info['assignee'] = parent::$user['uid'];
            $info['project_id'] = self::$project['id'];
            self::$issueArr[] = BaseDataProvider::createIssue($info);
        }

        $sphinxPath = realpath(APP_PATH.'../').'/bin/sphinx-for-chinese';
        exec($sphinxPath."/bin/indexer.exe -c ".$sphinxPath.'/bin/sphinx.conf  --all  ', $retval);
        var_dump($retval) ."\n\n";
    }

    /**
     *  测试完毕后执行此方法
     */
    public static function tearDownAfterClass()
    {
        self::$model = new ProjectModel();
        foreach (self::$projectArr as $item) {
            self::$model->deleteById($item['id']);
        }

        $model = new IssueModel();
        foreach (self::$issueArr as $item) {
            $model->deleteById($item['id']);
        }
        parent::tearDownAfterClass();
    }

    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'search');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/搜索结果/', $resp);
    }


    public function testSearchProject()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'search?data_type=json&scope=project&keyword=用户');
        $this->assertNotRegExp('/Sphinx服务查询错误/', self::$userCurl->rawResponse);
        // f(APP_PATH.'/test/testSearchProject.log',self::$userCurl->rawResponse);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('search failed');
            return;
        }
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['projects']);
        $this->assertNotEmpty($respArr['data']['project_pages']);
        $this->assertNotEmpty(intval($respArr['data']['project_total']));
    }

    public function testSearchIssue()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'search?data_type=json&scope=issue&keyword='.urlencode('测试事项'));
        $this->assertNotRegExp('/Sphinx服务查询错误/', self::$userCurl->rawResponse);
        // f(APP_PATH.'/test/testSearchIssue.log',self::$userCurl->rawResponse);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('search failed');
            return;
        }
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['issue_pages']);
        $this->assertNotEmpty(intval($respArr['data']['issue_total']));
    }
}
