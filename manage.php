<?php
header("Content-type:text/html;charset=utf-8");
require_once( "zookeeper.php" );
$zk = new ZookeeperApi("127.0.0.1:2181");

echo "<br />查看一个站点下的应用<br />";

$hostname = $_SERVER["HOSTNAME"];   //服务器做设置，每个服务器一个独立的名字  /etc/sysconfig/network
$sitename = "word.iciba.com";  //站点设置

$node = "/".$hostname."/".$sitename;

$res = $zk->getChildren( $node );

print_r( $res );

echo "<br />继续查看应用下的资源<br />";

foreach( $res  as $key => $val ){
    $_res[$key] = $zk->getChildren( $node."/".$val );
    print_r( $_res );
}

echo "<br />查看每个资源的具体数据<br />";

foreach( $_res[0] as $key => $val ){
   echo "<br />".$val."<br>";
   print_r( json_decode($zk->get( $node."/index/".$val ),true) );
}



