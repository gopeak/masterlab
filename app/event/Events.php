<?php


namespace main\app\event;

/**
 * 定义 Masterlab的事件名称
 * @package main\app\event
 */
final class Events
{

    /**
     * Private constructor. This class cannot be instantiated.
     */
    public function __construct()
    {
    }

    /**
     * 插件安装时的事件
     */
    public const onPluginInstall = 'onPluginInstall';
    /**
     * 插件卸载时的事件
     */
    public const onPluginUnInstall = 'onPluginUnInstall';

    /**
     *  用户管理事件
     */
    public const onUserAddByAdmin = 'onUserAddByAdmin';
    public const onUserUpdateByAdmin = 'onUserUpdateByAdmin';
    public const onUserActiveByAdmin = 'onUserActiveByAdmin';
    public const onUserDeleteByAdmin = 'onUserDeleteByAdmin';
    public const onUserDisableByAdmin = 'onUserDisableByAdmin';
    public const onUserBatchDisableByAdmin = 'onUserBatchDisableByAdmin';
    public const onUserBatchRecoveryByAdmin = 'onUserBatchRecoveryByAdmin';

    /**
     * 用户事件
     */
    public const onUserRegister = 'onUserRegister';
    public const onUserLogin = 'onUserLogin';
    public const onUserlogout = 'onUserlogout';
    public const onUserUpdateProfile = 'onUserUpdateProfile';

    /**
     * 组织创建前
     */
    public const onOrgCreate = 'onOrgCreate';
    public const onOrgUpdate = 'onOrgUpdate';
    public const onOrgDelete = 'onOrgDelete';

    /**
     * 项目事件
     */
    public const onProjectCreate = 'onProjectCreate';
    public const onProjectUpdate = 'onProjectUpdate';
    public const onProjectDelete = 'onProjectDelete';
    public const onProjectArchive = 'onProjectArchive';
    public const onProjectRecover = 'onProjectRecover';

    // 发送邮件
    public const onSendMailBefore= 'onSendMailBefore';

    /**
     * 事项事件
     */
    public const onIssueCreateBefore = 'onIssueCreateBefore';
    public const onIssueCreateAfter = 'onIssueCreateAfter';
    public const onIssueCreateChild= 'onIssueCreateChild';
    public const onIssueUpdateBefore = 'onIssueUpdateBefore';
    public const onIssueUpdateAfter = 'onIssueUpdateAfter';
    public const onIssueDelete = 'onIssueDelete';
    public const onIssueClose = 'onIssueClose';
    public const onIssueFollow = 'onIssueFollow';
    public const onIssueUnFollow = 'onIssueUnFollow';
    public const onIssueConvertChild = 'onIssueConvertChild';
    public const onIssueBatchDelete = 'onIssueBatchDelete';
    public const onIssueBatchUpdate = 'onIssueBatchUpdate';
    public const onIssueBatchMoveProject = 'onIssueBatchMoveProject';
    public const onIssueImportByExcel = 'onIssueImportByExcel';
    public const onIssueRemoveChild = 'onIssueRemoveChild';
    public const onIssueUpload= 'onIssueUpload';
    public const onIssueMobileUpload= 'onIssueMobileUpload';
    public const onIssueDeleteUpload= 'onIssueDeleteUpload';

    // 加入
    public const onIssueJoinSprint = 'onIssueJoinSprint';
    public const onIssueJoinClose = 'onIssueJoinClose';
    public const onIssueJoinBacklog = 'onIssueJoinBacklog';


    // 过滤器事件
    public const onIssueAddAdvFilter = 'onIssueAddAdvFilter';
    public const onIssueAddFilter = 'onIssueAddFilter';


    // 事项评论事件
    public const onIssueAddComment = 'onIssueAddComment';
    public const onIssueDeleteComment = 'onIssueDeleteComment';
    public const onIssueUpdateComment = 'onIssueUpdateComment';

    /**
     * 迭代事件
     */
    public const onSprintCreate = 'onSprintCreate';
    public const onSprintUpdate = 'onSprintUpdate';
    public const onSprintSetActive = 'onSprintSetActive';
    public const onSprintDelete = 'onSprintDelete';

    /**
     * 版本事件
     */
    public const onVersionCreate = 'onVersionCreate';
    public const onVersionUpdate = 'onVersionUpdate';
    public const onVersionDelete = 'onVersionDelete';
    public const onVersionRelease = 'onVersionRelease';


    /**
     * 模块事件
     */
    public const onModuleCreate = 'onModuleCreate';
    public const onModuleUpdate = 'onModuleUpdate';
    public const onModuleDelete = 'onModuleDelete';

    /**
     * 标签事件
     */
    public const onLabelCreate = 'onLabelCreate';
    public const onLabelUpdate = 'onLabelUpdate';
    public const onLabelDelete = 'onLabelDelete';

    /**
     *分类事件
     */
    public const onCataloglCreate = 'onCataloglCreate';
    public const onCatalogUpdate = 'onCatalogUpdate';
    public const onCatalogDelete = 'onCatalogDelete';

    /**
     * 项目成员事件
     */
    public const onProjectUserAdd = 'onProjectUserAdd';
    public const onProjectUserUpdateRoles = 'onProjectUpdateUserRoles';
    public const onProjectUserRemove = 'onProjectUserRemove';


    /**
     * 项目角色事件
     */
    public const onProjectRoleAdd = 'onProjectRoleAdd';
    public const onProjectRoleUpdate = 'onProjectRoleUpdate';
    public const onProjectRoleRemove = 'onProjectRoleRemove';
    public const onProjectRolePermUpdate = 'onProjectRolePermUpdate';
    public const onProjectRoleAddUser = 'onProjectRoleAddUser';
    public const onProjectRoleRemoveUser = 'onProjectRoleRemoveUser';
    public $arr = [
        Events::onProjectRoleAdd=>'添加项目角色',
        Events::onProjectRoleUpdate=>'编辑项目角色',
        Events::onProjectRoleRemove=>'删除项目角色',
        Events::onProjectRolePermUpdate=>'编辑角色权限',
        Events::onProjectRoleAddUser=>'角色添加用户',
        Events::onProjectRoleRemoveUser=>'角色移除用户',
    ];


}