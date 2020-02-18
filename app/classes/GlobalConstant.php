<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 2019/12/9 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

/**
 * Class GlobalConstant 全局常量定义
 * @package main\app\classes
 */
class GlobalConstant
{
    const PROJECT_TYPE_GROUP_SOFTWARE = 1;
    const PROJECT_TYPE_GROUP_BUSINESS = 2;

    const PROJECT_TYPE_SCRUM = 10;
    const PROJECT_TYPE_KANBAN = 20;
    const PROJECT_TYPE_SOFTWARE_DEV = 30;
    const PROJECT_TYPE_PROJECT_MANAGE = 40;
    const PROJECT_TYPE_FLOW_MANAGE = 50;
    const PROJECT_TYPE_TASK_MANAGE = 60;


    const ISSUE_STATUS_TYPE_ALL = 200010;                           // 全部事项
    const ISSUE_STATUS_TYPE_UNDONE = 200011;                        // 未完成事项
    const ISSUE_STATUS_TYPE_DONE = 200012;                          // 完成事项  包含已解决、已完成


}
