<?php
include_once 'fun.php';
include_once 'config.php';
$no=daddslashes($_REQUEST['no']);
$info_order=$db->getrow("select * from #@_a8tgcom where no='{$no}' and status=1");
header("Content-Type:application/json; charset=utf-8");
if($info_order){
    $re=array(
		'status'=>1,
		'id'=>$info_order['id'],
		'amount'=>$info_order['amount'],
		'money'=>$info_order['money'],
	);
}else{
	$re=array(
		'status'=>0,
	);
}
echo json_encode($re);

