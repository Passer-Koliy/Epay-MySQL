<?php
include_once 'fun.php';
include_once 'config.php';
$user=daddslashes($_REQUEST['user']);
$user=$bq->getone("select {$game_name} from {$game_tabel2} where {$game_name}='{$user}'");
header("Content-Type:application/json; charset=utf-8");
if($user){
    $re=array(
		'status'=>1,
	);
}else{
	$re=array(
		'status'=>0,
	);
}
echo json_encode($re);


$db = new cls_mysql(array(
	'dbhost' => $SQL_IP,
	'dbname' => 'kingfk',
	'dbuser' => $SQL_name,
	'dbpw' => $SQL_pw,
));
$bq = new cls_mysql(array(
	'dbhost' => $SQL_IP,
	'dbname' => 'kingfk',
	'dbuser' => $SQL_name,
	'dbpw' => $SQL_pw,
));

//这段
$db->query($sql);
$game_tabel = 'user';
$game_field_user = 'username';
$game_field_money = 'fee_money';
$game_tabel2 = 'username';
$game_name = 'username';


//数据库信息
$SQL_IP = '127.0.0.1';//服务器IP
$SQL_name = 'kingfk';//服务器数据库账号
$SQL_pw = 'kingfk';  //服务器数据库密码
