<?php


namespace main\app\event;

/**
 * 定义 Masterlab的事件
 * @package main\app\event
 */
final class Events
{

    /**
     * Private constructor. This class cannot be instantiated.
     */
    private function __construct()
    {
    }


    /**
     * 插件安装时的事件
     */
    public const onPluginInstall           = 'onPluginInstall';
    /**
     * 插件卸载时的事件
     */
    public const onPluginUnInstall          = 'onPluginUnInstall';

    /**
     * 组织创建前
     */
    public const onOrgCreateBefore           = 'onOrgCreateBefore';

    /**
     * 组织创建后
     */
    public const onOrgCreateAfter           = 'onOrgCreateAfter';


    /**
     * 项目创建前
     */
    public const onProjectCreateBefore           = 'onProjectCreateBefore';

    /**
     * 项目创建后
     */
    public const onProjectCreateAfter           = 'onProjectCreateAfter';

    /**
     * 事项创建前
     */
    public const onIssueCreateBefore           = 'onIssueCreateBefore';

    /**
     * 事项创建后
     */
    public const onIssueCreateAfter           = 'onIssueCreateAfter';


    /**
     * 事项更新前
     */
    public const onIssueUpdateBefore           = 'onIssueUpdateBefore';

    /**
     * 事项更新后
     */
    public const onIssueUpdateAfter           = 'onIssueUpdateAfter';


    public const onSchemaCreateTableColumn      = 'onSchemaCreateTableColumn';
    public const onSchemaDropTable              = 'onSchemaDropTable';
    public const onSchemaAlterTable             = 'onSchemaAlterTable';
    public const onSchemaAlterTableAddColumn    = 'onSchemaAlterTableAddColumn';
    public const onSchemaAlterTableRemoveColumn = 'onSchemaAlterTableRemoveColumn';
    public const onSchemaAlterTableChangeColumn = 'onSchemaAlterTableChangeColumn';
    public const onSchemaAlterTableRenameColumn = 'onSchemaAlterTableRenameColumn';
    public const onSchemaColumnDefinition       = 'onSchemaColumnDefinition';
    public const onSchemaIndexDefinition        = 'onSchemaIndexDefinition';

}