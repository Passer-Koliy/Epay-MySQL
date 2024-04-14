<?php
include_once 'mysql.class.php';

$dof_name = '帝王寄售手续费';//游戏名
$parter = '1000';  //易支付ID
$key = 'v0M6xyNmOEwF8NF2ZK81DNT2mbMbjN4t';   //易支付秘钥

//数据库信息
$SQL_IP = '127.0.0.1';//服务器IP
$SQL_name = 'kingfk';//服务器数据库账号
$SQL_pw = 'kingfk';  //服务器数据库密码


//游戏币名称
$money_name = '手续费';
//充值比利
$money_scale = 1; //意思就是1：多少
//满送
$money_ms = array(
	array(
		'amount' => 0,   //这里是充值多少【金额】可以送。（注意：这是【金额】）
		'money' => 0,  //这里是送多少【点券】，额外送的，如果不送可以设置为0（注意：这是【点券】）
		'desc' => '' //这里是表明送多少，如果不送可以写其他相关字 前台可显示（这是对应介绍文字）
	),
	array(
		'amount' => 0,   //这里是充值多少【金额】可以送（注意：这是【金额】）
		'money' => 0,  //这里是送多少【点券】，额外送的，如果不送可以设置为0（注意：这是【点券】）
		'desc' => '' //这里是表明送多少，如果不送可以写其他相关字 前台可显示（这是对应介绍文字）
	),
	array(
		'amount' => 0,   //这里是充值多少【金额】可以送（注意：这是【金额】）
		'money' => 0,  //这里是送多少【点券】，额外送的，如果不送可以设置为0（注意：这是【点券】）
		'desc' => '' //这里是表明送多少，如果不送可以写其他相关字 前台可显示（这是对应介绍文字）
	),

);

//----------以----下----信----息----不----要----动---------------

$db = new cls_mysql(array(
    'dbhost' => $SQL_IP,
    'dbname' => 'kingfk',
    'dbuser' => $SQL_name,
    'dbpw' => $SQL_pw,
));

$db->query($sql);
$game_tabel = 'user';
$game_field_user = 'username';
$game_field_money = 'fee_money';
$game_tabel2 = 'username';
$game_name = 'username';




$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$db->dbprefix}Vouchers_pay` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `no` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ctime` int(11) NOT NULL,
  `payment` char(20) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `area_id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no` (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOF;
