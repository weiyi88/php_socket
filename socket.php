<?php

$serv= new swoole_server('127.0.0.1',9501);

$serv->set([
    'worker_num'=>2,
]);

//swoole是事件驱动，有回调才需要处理
//新的客户端链接时候，worker进程会出发该回调
$serv->on('Connect',function($serv,$fd){
    echo "new client connected .".PHP_EOL;
});

//server 接收到客户端的数据后，worker进程出发该回调
$serv->on("Receive",function ($serv,$fd,$fomId,$data){
    // 收到数据后发送给客户端
    $serv->send($fd,'Server message .'.$data);
});

//客户端断开链接，或者server主动关闭链接，worker进程内调用
$serv->on('Close',function ($serv,$fd){
    echo "Client close .".PHP_EOL;
});

$serv->start();









