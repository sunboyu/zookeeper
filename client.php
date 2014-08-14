<?php
header("Content-type:text/html;charset=utf-8");
require_once( "zookeeper.php" );
$zk = new ZookeeperApi("127.0.0.1:2181");

$hostname = $_SERVER["HOSTNAME"];   //服务器做设置，每个服务器一个独立的名字  /etc/sysconfig/network
$sitename = "word.iciba.com";  //站点设置
$appname = "index";  //一个站点下可能有多个app模块，如果只有一个，则用默认名字index

$node = "/".$hostname."/".$sitename."/".$appname."/";

$db = mysql_connect( $zk->get($node."mysql/host").":".$zk->get($node."mysql/port") , $zk->get($node."mysql/user") , $zk->get($node."mysql/pass") ) or die( mysql_error() );
mysql_select_db("dict_dj");
mysql_query( "set names utf8" );
$query = mysql_query( "SELECT * FROM New_dj_date_v2 LIMIT 1" );
print_r( mysql_fetch_array( $query ) );
