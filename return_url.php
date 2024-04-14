<?php
include_once 'config.php';
$orderno = intval($_REQUEST['out_trade_no']);

$info_order = $db -> getrow("select * from #@_Vouchers_pay where no='{$orderno}'");

if($info_order['status']==1){
    $info_order['status']='已支付';
}else{
	$info_order['status']='未支付';
	if($info_order['amount']==0){
	    $info_order['amount']=$info_order['money']=$info_order['status']='处理中';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>您<?php echo $info_order['status']?><?php echo $info_order['amount']?>元到账<?php echo $money_name;?><?php echo $info_order['money']?>个</title>

</head>
<body>
<div class="pay">
<link rel="stylesheet" type="text/css" href="/static/css/wechat_pay.css" rel="stylesheet" media="screen">
<div class="body">
    <h1 class="mod-title">充值状态
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="money">￥<?php echo $info_order['amount']?>元</div>
        
<span style="font-size:16px;">		
<table width="100%" height="384" border="0">
  <tr>
    <td width="20%"><div align="center">订单金额：</div></td>
    <td width="80%"><div align="left"><?php echo $info_order['amount']?>
    </div>
    <div align="left"></div></td>
  </tr>
  <tr>
    <td><div align="center">充值帐号：</div></td>
    <td><div align="left">
    	<strong><span style="color:#ff0000;">
    		<?php echo $info_order['user']?>
    		</span></strong>
       </div>    
   </td>
  </tr>
    <tr>
    <td><div align="center">到账<?php echo $money_name;?>：</div></td>
    <td><div align="left"><?php echo $info_order['money']?>￥</div>      </td>
  </tr>

  <tr>
    <td><div align="center">订单号：</div></td>
    <td><div align="left"><?php echo $info_order['no']?></div>    </td>
  </tr>
  <tr>
    <td><div align="center">支付状态：</div></td>
    <td><div align="left"><?php echo $info_order['status']?></div></td>
  </tr></span>
</table>


<style>
				.button { background-color: #4CAF50;/* Green */
					border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; -webkit-transition-duration: 0.4s;/* Safari */
					transition-duration: 0.4s;}
				.button1 { box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);}
				.button2:hover { box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);}
			</style>

			<div align="center">
				<button class="button button2" onClick="javascript:window.open('/');">再次充值</button>
				<button class="button button2" onClick="javascript:window.open('https://kingfk.vip/merchant');">返回寄售平台</button>
			</div>





		</div>
		<script type="text/javascript">
		var i=0;
		var cl=setInterval(function () {
			i++;
			jQuery.post(
				'checkpay.php',
				{no:'<?php echo $info_order['no']?>'},
				function(data){
					if(data.status==1){
						jQuery('.amount').html(data.amount);
						jQuery('.money').html(data.money);
						jQuery('.status').html('已支付');
						clearInterval(cl);
					}else if(i>60){
						jQuery('.amount').html('<span style="color:#f00">处理超时</span>');
						jQuery('.money').html('<span style="color:#f00">处理超时</span>');
						jQuery('.status').html('<span style="color:#f00">处理超时</span>');
						clearInterval(cl);
					}
				}
			);
		},3000);
		</script>
			  <div class="tr_rechoth am-form-group">
			
                <br/>
        
	
</div>

<script type="text/javascript">
		jQuery(document).ready(function($){ 
		    try{
		    	jQuery("[name='user']").on('blur',function () {
		    		jQuery.post(
			        	'checkuser.php',
			        	{user:jQuery("[name='user']").val()},
			        	function (data) {
			        		if (data.status==0) {
			        			jQuery(".error_user").html('用户不存在');
			        		}else{
			        			jQuery(".error_user").html('用户名正确，可以充值');
			        		}
			        	}
			        );   
		    	});
		    }catch(e){}
		});
		
</script>
	
</div>
</body>
</html>