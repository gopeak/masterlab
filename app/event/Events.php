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

    public const postConnect = 'postConnect';

    public const onIssueCreateBefore           = 'onIssueCreateBefore';
    public const onIssueCreateAfter           = 'onIssueCreateAfter';


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