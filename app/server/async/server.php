<?php
namespace main\async;

$serv = new swoole_server("127.0.0.1", 9501);
$serv->set(array(
    'worker_num' => 8,   //工作进程数量
    'daemonize' => true, //是否作为守护进程
));
$serv->on('connect', function ($serv, $fd){
    echo "Client:Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {

    echo "Client:Data. fd=$fd|from_id=$from_id|data=$data";

    $json_obj = json_decode( $data );
    if( !isset($json_obj->cmd) ){
        $serv->send($fd,['ret'=>0,'msg'=>'cmd is null']);
        $serv->close($fd);
        return ;
    }

    list ( $class, $method ) = explode('.',$json_obj->cmd);
    $class_obj =  new $class();
    if (! method_exists($class_obj, $method)) {
        throw new \Exception($class.'->'.$method . ' no found;', 500);
    }
    // 开始执行worker
    $result = call_user_func_array( [ $class_obj, $method ], [$json_obj] );
    $ret = [];
    $ret['ret'] = 1;
    $ret['data'] = $result;
    $serv->send($fd, json_encode($ret) );
    $serv->close($fd);
});
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();