<?php

/**
 * 2.1版本迁移到3.0的升级脚本
 */

require_once realpath(dirname(__FILE__)) . '/bootstrap.php';
require_once $rootDir . '/vendor/autoload.php';


$dbConfig = $GLOBALS['_yml_config']['database']['default'];

$version2Dir = '';
if (isset($argv[1]) && !empty($argv[1])) {
    $version2Dir = $argv[1];
}
if (empty($version2Dir)) {
    echo "请指定2.1版本的根目录\n";
    die;
}
$version2Status = 'deploy';
if (file_exists($version2Dir . '/env.ini')) {
    $envArr = parse_ini_file($version2Dir . '/env.ini');
    $version2Status = $envArr['APP_STATUS'];
    unset($envArr);
}
$ver2DbConfigFile = $version2Dir . '/app/config/' . $version2Status . '/database.cfg.php';
if (!file_exists($ver2DbConfigFile)) {
    echo "2.1版本的数据库配置文件不存在:{$ver2DbConfigFile}\n";
    die;
}
include $ver2DbConfigFile;
$issueModel = new \main\app\model\issue\IssueModel();
$ver2DbConfig = $_config['database']['default'];
$ver2Db = getDb($ver2DbConfig);
if (empty($ver2Db)) {
    echo "数据库连接失败\n";
    die;
}

// 先清空demo数据库
clearDemoData();
$issueModel->db->beginTransaction();
$issueModel->connect();
try {
    // 1.导入用户信息
    migrateUsers($ver2Db);

    // 2.导入配置
    migrateMainSetting($ver2Db);

    // 3.导入事项配置
    migrateIssueConfig($ver2Db);

    // 4.导入组织
    migrateOrgs($ver2Db);

    // 5.导入项目,角色，权限，迭代，版本，标签，分类等
    migrateProjects($ver2Db);

    // 6.导入事项及相关数据
    migrateIssues($ver2Db);

    // 7. 导入其他数据
    migrateOther($ver2Db);

} catch (\Exception $e) {
    $issueModel->db->rollBack();
    echo $e->getFile()."\n";
    echo $e->getLine()."\n";
    echo $e->getMessage()."\n";
   // print_r($e->getTrace());
    echo "导入数据失败,请联系管理员\n";
    exit();
}
echo "导入数据成功\n";



// 7. 复制上传的附件到新目录
$src = $version2Dir . '/app/public/attachment';
$dst =  PUBLIC_PATH.'attachment';
recurseCopy( $src , $dst);
echo "迁移文件成功\n";
echo "导入完成\n";
exit;



/**
 *
 */
function clearDemoData()
{

}


/**
 * 迁移用户数据
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 */
function migrateUsers(\Doctrine\DBAL\Connection $ver2Db)
{
    $userModel = new \main\app\model\user\UserModel();
    $userModel->truncate($userModel->getTable());

    $sql = "select * from user_main";
    $users = $ver2Db->fetchAll($sql);
    $userModel->insertRows($users);

    // delete from user_setting
    $userSettingModel = new \main\app\model\user\UserSettingModel();
    $userSettingModel->truncate($userSettingModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  user_setting");
    foreach ($rows as $row) {
        $userSettingModel->insert($row);
    }
    $userWidgetModel = new \main\app\model\user\UserWidgetModel();
    $userWidgetModel->truncate($userWidgetModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  user_widget");
    foreach ($rows as $row) {
        $userWidgetModel->replace($row);
    }
}

/**
 * 迁移主要配置
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 * @throws \Exception
 */
function migrateMainSetting(\Doctrine\DBAL\Connection $ver2Db)
{
    $settingModel = new \main\app\model\SettingModel();
    $rows = $ver2Db->fetchAll("select * from  main_setting");
    foreach ($rows as $row) {
        $settingModel->replace($row);
    }
}

/**
 * 迁移事项配置
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 * @throws \Exception
 */
function migrateIssueConfig(\Doctrine\DBAL\Connection $ver2Db)
{
    $issueTypeModel = new \main\app\model\issue\IssueTypeModel();
    $issueTypeModel->truncate($issueTypeModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_type");
    foreach ($rows as $row) {
        $issueTypeModel->replace($row);
    }
    $issueTypeSchemeModel = new \main\app\model\issue\IssueTypeSchemeModel();
    $issueTypeSchemeModel->truncate($issueTypeSchemeModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_type_scheme");
    foreach ($rows as $row) {
        $issueTypeSchemeModel->replace($row);
    }
    $issueTypeSchemeItemsModel = new \main\app\model\issue\IssueTypeSchemeItemsModel();
    $issueTypeSchemeItemsModel->truncate($issueTypeSchemeItemsModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_type_scheme_data");
    foreach ($rows as $row) {
        $issueTypeSchemeItemsModel->replace($row);
    }
    $issueStatusModel = new \main\app\model\issue\IssueStatusModel();
    $issueStatusModel->truncate($issueStatusModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_status");
    foreach ($rows as $row) {
        $issueStatusModel->replace($row);
    }
    $issueResolveModel = new \main\app\model\issue\IssueResolveModel();
    $issueResolveModel->truncate($issueResolveModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_resolve");
    foreach ($rows as $row) {
        $issueResolveModel->replace($row);
    }
    $issuePriorityModel = new \main\app\model\issue\IssuePriorityModel();
    $issuePriorityModel->truncate($issuePriorityModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_priority");
    foreach ($rows as $row) {
        $issuePriorityModel->replace($row);
    }
    $issueUiModel = new \main\app\model\issue\IssueUiModel();
    $issueUiModel->truncate($issueUiModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_ui");
    foreach ($rows as $row) {
        $issueUiModel->replace($row);
    }
    $issueUiTabModel = new \main\app\model\issue\IssueUiTabModel();
    $issueUiTabModel->truncate($issueUiTabModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_ui_tab");
    foreach ($rows as $row) {
        $issueUiTabModel->replace($row);
    }

    $workflowModel = new \main\app\model\issue\WorkflowModel();
    $workflowModel->truncate($workflowModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  workflow");
    foreach ($rows as $row) {
        $workflowModel->replace($row);
    }
    $workflowBlockModel = new \main\app\model\issue\WorkflowBlockModel();
    $workflowBlockModel->truncate($workflowBlockModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  workflow_block");
    foreach ($rows as $row) {
        $workflowBlockModel->replace($row);
    }
    $workflowConnectorModel = new \main\app\model\issue\WorkflowConnectorModel();
    $workflowConnectorModel->truncate($workflowConnectorModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  workflow_connector");
    foreach ($rows as $row) {
        $workflowConnectorModel->replace($row);
    }
    $workflowSchemeModel = new \main\app\model\issue\WorkflowSchemeModel();
    $workflowSchemeModel->truncate($workflowSchemeModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  workflow_scheme");
    foreach ($rows as $row) {
        $workflowSchemeModel->replace($row);
    }
    $workflowSchemeDataModel = new \main\app\model\issue\WorkflowSchemeDataModel();
    $workflowSchemeDataModel->truncate($workflowSchemeDataModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  workflow_scheme_data");
    foreach ($rows as $row) {
        $workflowSchemeDataModel->replace($row);
    }
    $issueDescriptionTemplateModel = new \main\app\model\issue\IssueDescriptionTemplateModel();
    $issueDescriptionTemplateModel->truncate($issueDescriptionTemplateModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  issue_description_template");
    foreach ($rows as $row) {
        $issueDescriptionTemplateModel->replace($row);
    }
    $fieldModel = new \main\app\model\field\FieldModel();
    $fieldModel->truncate($fieldModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  field_main");
    foreach ($rows as $row) {
        $fieldModel->replace($row);
    }
    $fieldCustomValueModel = new \main\app\model\field\FieldCustomValueModel();
    $fieldCustomValueModel->truncate($fieldCustomValueModel->getTable());
    $rows = $ver2Db->fetchAll("select * from  field_custom_value");
    foreach ($rows as $row) {
        $fieldCustomValueModel->replace($row);
    }
}

/**
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 * @throws \Exception
 */
function migrateOrgs(\Doctrine\DBAL\Connection $ver2Db)
{
    $orgModel = new \main\app\model\OrgModel();
    $orgModel->truncate($orgModel->getTable());

    $sql = "select * from main_org";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $orgModel->replace($row);
    }
}

function migrateProjects(\Doctrine\DBAL\Connection $ver2Db)
{
    $master =  $ver2Db->fetchAssoc("select * from user_main where uid=1");
    //print_r($master);
    $projectModel = new \main\app\model\project\ProjectModel();
    $projectModel->truncate($projectModel->getTable());
    $sql = "select * from project_main";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $row['workflow_scheme_id'] = '1';
        $projectModel->replace($row);
    }
    $projectMainExtraModel = new \main\app\model\project\ProjectMainExtraModel();
    $projectMainExtraModel->truncate($projectMainExtraModel->getTable());
    $sql = "select * from project_main_extra";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectMainExtraModel->replace($row);
    }
    $projectFlagModel = new \main\app\model\project\ProjectFlagModel();
    $projectFlagModel->truncate($projectFlagModel->getTable());
    $sql = "select * from project_flag";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectFlagModel->replace($row);
    }
    $projectMindSettingModel = new \main\app\model\project\ProjectMindSettingModel();
    $projectMindSettingModel->truncate($projectMindSettingModel->getTable());
    $sql = "select * from project_mind_setting";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectMindSettingModel->replace($row);
    }
    $projectModuleModel = new \main\app\model\project\ProjectModuleModel();
    $projectModuleModel->truncate($projectModuleModel->getTable());
    $sql = "select * from project_module";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectModuleModel->replace($row);
    }
    $projectLabelModel = new \main\app\model\project\ProjectLabelModel();
    $projectLabelModel->truncate($projectLabelModel->getTable());
    $sql = "select * from project_label";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectLabelModel->replace($row);
    }
    $projectCategoryModel = new \main\app\model\project\ProjectCategoryModel();
    $projectCategoryModel->truncate($projectCategoryModel->getTable());
    $sql = "select * from project_category";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectCategoryModel->replace($row);
    }
    $projectCatalogLabelModel = new \main\app\model\project\ProjectCatalogLabelModel();
    $projectCatalogLabelModel->truncate($projectCatalogLabelModel->getTable());
    $sql = "select * from project_catalog_label";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectCatalogLabelModel->replace($row);
    }
    $projectRoleRelationModel = new \main\app\model\project\ProjectRoleRelationModel();
   // $projectRoleRelationModel->truncate($projectRoleRelationModel->getTable());
    $sql = "select * from project_role_relation";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectRoleRelationModel->replace($row);
    }
    $projectUserRoleModel = new \main\app\model\project\ProjectUserRoleModel();
    $projectUserRoleModel->truncate($projectUserRoleModel->getTable());
    $sql = "select * from project_user_role";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectUserRoleModel->replace($row);
    }
    $projectRoleModel = new \main\app\model\project\ProjectRoleModel();
    $projectRoleModel->truncate($projectRoleModel->getTable());
    $sql = "select * from project_role";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $projectRoleModel->replace($row);
        if(!empty($master['uid'])){
            $arr = [];
            $arr['user_id'] = $master['uid'];
            $arr['project_id'] = $row['project_id'];
            $arr['role_id'] = $row['id'];
            $projectUserRoleModel->replace($arr);
        }
    }
    $sprintModel = new \main\app\model\agile\SprintModel();
    $sprintModel->truncate($sprintModel->getTable());
    $sql = "select * from agile_sprint";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $sprintModel->replace($row);
    }
}

/**
 * 迁移事项数据
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 * @throws \Exception
 */
function migrateIssues(\Doctrine\DBAL\Connection $ver2Db)
{
    $issueModel = new \main\app\model\issue\IssueModel();
    $issueModel->truncate($issueModel->getTable());
    $sql = "select * from issue_main";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueModel->insert($row);
    }
    $issueAssistantsModel = new \main\app\model\issue\IssueAssistantsModel();
    $issueAssistantsModel->truncate($issueAssistantsModel->getTable());
    $sql = "select * from issue_assistant";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueAssistantsModel->insert($row);
    }
    $issueEffectVersionModel = new \main\app\model\issue\IssueEffectVersionModel();
    $issueEffectVersionModel->truncate($issueEffectVersionModel->getTable());
    $sql = "select * from issue_effect_version";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueEffectVersionModel->insert($row);
    }
    $issueFileAttachmentModel = new \main\app\model\issue\IssueFileAttachmentModel();
    $issueFileAttachmentModel->truncate($issueFileAttachmentModel->getTable());
    $sql = "select * from issue_file_attachment";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueFileAttachmentModel->insert($row);
    }
    $issueFixVersionModel = new \main\app\model\issue\IssueFixVersionModel();
    $issueFixVersionModel->truncate($issueFixVersionModel->getTable());
    $sql = "select * from issue_fix_version";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueFixVersionModel->insert($row);
    }
    $issueFollowModel = new \main\app\model\issue\IssueFollowModel();
    $issueFollowModel->truncate($issueFollowModel->getTable());
    $sql = "select * from issue_follow";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueFollowModel->insert($row);
    }
    $holidayModel = new \main\app\model\issue\HolidayModel();
    $holidayModel->truncate($holidayModel->getTable());
    $sql = "select * from issue_holiday";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $holidayModel->insert($row);
    }
    $extraWorkerDayModel = new \main\app\model\issue\ExtraWorkerDayModel();
    $extraWorkerDayModel->truncate($extraWorkerDayModel->getTable());
    $sql = "select * from issue_extra_worker_day";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $extraWorkerDayModel->insert($row);
    }
    $issueLabelDataModel = new \main\app\model\issue\IssueLabelDataModel();
    $issueLabelDataModel->truncate($issueLabelDataModel->getTable());
    $sql = "select * from issue_label_data";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $issueLabelDataModel->insert($row);
    }
    $timelineModel = new \main\app\model\TimelineModel();
    $timelineModel->truncate($timelineModel->getTable());
    $sql = "select * from main_timeline";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $timelineModel->insert($row);
    }
}

/**
 * 迁移其他数据
 * @param \Doctrine\DBAL\Connection $ver2Db
 * @throws \Doctrine\DBAL\DBALException
 * @throws \Exception
 */
function migrateOther(\Doctrine\DBAL\Connection $ver2Db)
{
    $activityModel = new \main\app\model\ActivityModel();
    $activityModel->truncate($activityModel->getTable());
    $sql = "select * from main_activity";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $activityModel->insert($row);
    }
    $notifySchemeModel = new \main\app\model\system\NotifySchemeModel();
    $notifySchemeModel->truncate($notifySchemeModel->getTable());
    $sql = "select * from main_notify_scheme";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $notifySchemeModel->insert($row);
    }
    $notifySchemeDataModel = new \main\app\model\system\NotifySchemeDataModel();
    $notifySchemeDataModel->truncate($notifySchemeDataModel->getTable());
    $sql = "select * from main_notify_scheme_data";
    $rows = $ver2Db->fetchAll($sql);
    foreach ($rows as $row) {
        $notifySchemeDataModel->insert($row);
    }
}

/**
 * @param $dbConfig
 * @return \Doctrine\DBAL\Connection|null
 * @throws \Doctrine\DBAL\DBALException
 */
function getDb($dbConfig)
{
    $db = null;
    try {
        $connectionParams = array(
            'dbname' => $dbConfig['db_name'],
            'user' => $dbConfig['user'],
            'password' => $dbConfig['password'],
            'port' => $dbConfig['port'],
            'host' => $dbConfig['host'],
            'charset' => $dbConfig['charset'],
            'driver' => 'pdo_mysql',
        );
        $db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        $sqlMode = "SET SQL_MODE='IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
        $db->exec($sqlMode);
    } catch (\Doctrine\DBAL\DBALException $e) {
        echo "数据库链接失败:" . print_r($dbConfig, true) . "\n";
        return null;
    } catch (\Exception $e) {
        echo "数据库链接失败:" . print_r($dbConfig, true) . "\n";
        return null;
    }
    return $db;
}

/**
 * @param $src
 * @param $dst
 */
function recurseCopy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurseCopy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
























