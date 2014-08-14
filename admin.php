<?php

error_reporting(2047);
ini_set("display_errors",true);

require_once("zookeeper.php");
#echo "bbbb";exit;
$action = empty($_GET['action']) ? 'default' : trim($_GET['action']);

$hostname = $_SERVER["HOSTNAME"];   //服务器做设置，每个服务器一个独立的名字  /etc/sysconfig/network
$sitename = "word.iciba.com";  //站点设置
$appname = "index";  //一个站点下可能有多个app模块，如果只有一个，则用默认名字index

$node = "/".$hostname."/".$sitename."/".$appname."/";

$service['mysql'] = array(
    'host' =>'192.168.10.97',
    'port' => '3306',
    'charset' => 'utf8',
    'user' => 'root',
    'pass' => '123456',
);

$service['redis'] = array(
    'host' => '192.168.10.97',
    'port' => 11380,
    'timeout' => 5
);
$service['tt'] = array(
    'host' => '192.168.10.97',
    'port' => 11233 
);
$zookeeper = new ZookeeperApi("127.0.0.1:2181");



foreach( $service as $key => $val ){
    foreach( $val as $k => $v ){
        $zookeeper->set( $node.$key."/".$k , $v );
    }
}


