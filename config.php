<?php
header("Content-type:text/html;charset=utf-8");
require_once( "zookeeper.php" );

$hostname = $_SERVER["HOSTNAME"];   //服务器做设置，每个服务器一个独立的名字  /etc/sysconfig/network
$sitename = "word.iciba.com";  //站点设置
$appname = "index";  //一个站点下可能有多个app模块，如果只有一个，则用默认名字index

$node = "/".$hostname."/".$sitename."/".$appname."/";

$cachefile = "conf_cache.php";
if( file_exists( $cachefile ) ){
    include( $cachefile );
    echo "cache加载:<br />";
}
if( empty( $conf ) || !file_exists( $cachefile ) || !empty( $argv[1] ) ){
    echo "zookeeper查询<br />";
    $zk = new ZookeeperApi("127.0.0.1:2181");
    $conf['mysql']['host'] = $zk->get( $node."mysql/host" );
    $conf['mysql']['user'] = $zk->get( $node."mysql/user" );
    $conf['mysql']['pass'] = $zk->get( $node."mysql/pass" );
    $conf['mysql']['port'] = $zk->get( $node."mysql/port" );
    $handle = fopen( $cachefile , "w+" );
    $content = "<?php\r\n";
    foreach( $conf['mysql'] as $key => $val ){
        $content .= '$conf["mysql"]["'.$key.'"] = "'.$val.'";'."\r\n";
    }
    fwrite( $handle , $content );
    fclose( $handle );
}

print_r( $conf['mysql'] );


$db = mysql_connect( $conf['mysql']['host'].":".$conf['mysql']['port'] , $conf['mysql']['user'] , $conf['mysql']['pass'] ) or die( mysql_error() );
mysql_select_db("dict_dj");
mysql_query( "set names utf8" );
$query = mysql_query( "SELECT * FROM New_dj_date_v2 LIMIT 1" );
print_r( mysql_fetch_array( $query ) );
