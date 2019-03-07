<?php

namespace main\app\model\system;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class NotifySchemeModel extends BaseDictionaryModel
{
    public $prefix = 'main_';

    public $table = 'notify_scheme';

    public $fields = '*';

    const DEFAULT_SCHEME_ID = 1;
}
