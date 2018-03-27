<?php

$_config = [
    'max_source_line' => 12,
    'trace_limit' => 15,
    'email_notify' => ['121642038@qq.com'],
    'max_day_send'=>3,
    'enable_write_log'=>true,
    'enable_send_email'=>false

];


$_config['mail_tpl']  = '<style type="text/css">
    #debug {max-width: 1024px;margin:0 auto; color:#504a4a; text-align: left;} 
    #debug fieldset {margin-top: 2em; display: block; padding:10px;border:1px solid #EEAA00;}
    #debug fieldset legend{margin: 0 10px; padding: 2px 4px; color: #008800;}
    #debug pre{padding: 10px;} 
</style>
<div id="debug">
    <h2>日志告警</h2>
    <div id="debug_in" >
        <fieldset>
            <legend><b>error:</b></legend>
            <pre>{{err_msg}}</pre>\ 
        </fieldset> 
        <fieldset>
            <legend><b>Trace:</b></legend>
            <pre>{{traces}}</pre>
        </fieldset>
        <fieldset>
            <legend><b>Source:</b></legend>
            <pre>{{source}}</pre>
        </fieldset>
        <fieldset>
            <legend><b>SQL:</b></legend>
            <pre>{{sql_logs}}</pre>
        </fieldset> 
    </div>
</div>  ';

return $_config;