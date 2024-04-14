<?php
include_once 'fun.php';
include_once 'config.php';

$userid=$parter; //商户编号
$channel_key=$key; //商户秘钥
$apiurl='https://billing.p.koliy.top/submit.php'; //接口地址
$notify_url="http://".$_SERVER['HTTP_HOST']."/pay/notify_url.php"; //异步通知回调地址
$return_url="http://".$_SERVER['HTTP_HOST']."/pay/return_url.php"; //支持成功跳转地址
$orderno=date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); //商户订单号


//写入订单表
$data=array(
	'no'=>$orderno,
	'amount'=>$_REQUEST['amount'],
	'ctime'=>time(),
	'payment'=> $_REQUEST['paycode'],
	'area_name'=>$_REQUEST['area_name$_REQUEST'],
	'area_id'=>intval($_REQUEST['area_id']),
	'user'=>daddslashes($_REQUEST['user']),
);
$re=$db->autoExecute($db->dbprefix.'Vouchers_pay', $data);
if(!$re){
    exit('写入订单失败');
}
$title=daddslashes($_REQUEST['user']);

//以下部分不用修改

  $native = array(
            "pid" => $userid,
            "type" => $_REQUEST['paycode'],
            "out_trade_no" => $orderno,
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "name" => $title,
            "money" => $_REQUEST['amount'],
            "sitename" =>$dof_name,
        );
        ksort($native);
        $arg = "";
        foreach ($native as $key => $val) {
            $arg .= $key . "=" . ($val) . "&";
        }
        $arg = substr($arg, 0, -1);
        $sign = md5($arg . $channel_key);
        $native["sign"] = $sign;
        $native['sign_type'] = "MD5";

        $html = '<form  name="form1" class="form-inline" method="post" action="' . $apiurl . '">';
        foreach ($native as $key => $val) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $val . '">';
        }
        $html .= '</form>';
        $html .= '<script type="text/javascript">document.form1.submit()</script>';
        echo $html;