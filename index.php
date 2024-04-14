<?php
include_once 'config.php';
$area_id = $_REQUEST['area_id'];
$area_name = $area[$area_id]['name'];
$payment = $_REQUEST['payment'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $dof_name; ?>充值中心</title>

	<link rel="stylesheet" type="text/css" href="static/css/amazeui.min.css" />
	<link rel="stylesheet" type="text/css" href="static/css/main.css" />

	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<style>
		.tr_rechhead>p {
			display: -webkit-box
		}

		.tr_rechhead>p input[name=account] {
			border: 2px solid #CCCCCC;
			border-radius: 4px;
		}
	</style>
</head>

<body>
	<div class="pay">
		<div class="tr_recharge">
			<div class="tr_rechtext">
				<p class="te_retit"><img src="static/picture/coin.png" alt="" /><?php echo $dof_name; ?>充值中心</p>
				<p>充值比例为1：<?php echo $money_scale . $money_name; ?>，即1元=<?php echo $money_scale . $money_name; ?>，且只能使用付款方式来进行充值，<?php echo $money_name; ?>30元起充。</p>
				<?php foreach ($money_ms as $k => $v) { ?>
					<p><?php echo $v['desc'] ?></p>
				<?php } ?>
			</div>
			<form action="api.php" class="am-form" id="doc-vld-msg" method="post">
				<div class="tr_rechbox">

					<div class="tr_rechhead am-form-group">
						<img src="static/picture/ys_head2.jpg" />
						<p style="display: -webkit-box">

							充值账号：
							</span><input type="text" id="user" name="user" maxlength="50" required="required" /><a href="#" class="error_user" style="text-decoration: none;color: #959595;">请输入兑换帐号</a>
					</div>
					<div class="tr_rechli am-form-group">
						<span>充值金额：</span>
						<ul class="ui-choose am-form-group" id="uc_01">
							<input id="tMoney" onKeyUp="onlyIntegerKeyUp(event)" class="othbox" name="amount" type="text" maxlength="18" size="50" required="required" />
						</ul>

					</div>
					<br />
					<div class="tr_rechcho am-form-group">
						<span>充值类型：</span>
						<label class="am-radio" style="line-height:50px;">
							<input type="radio" name="title" value="<?php echo $money_name; ?>" checked data-am-ucheck required data-validation-message="<?php echo $money_name; ?>"> <?php echo $money_name; ?>
						</label>

					</div>
					<div class="clear"></div>
					<div class="tr_rechcho am-form-group">
						<span>充值方式：</span>
						<label class="am-radio" style="margin-right:30px;">
							<input type="radio" name="paycode" value="alipay" checked data-am-ucheck data-validation-message="请选择一种充值方式"><img src="static/picture/zfbpay.png">
						</label>

						<label class="am-radio" style="margin-right:30px;">
							<input type="radio" name="paycode" value="wxpay" data-am-ucheck required data-validation-message="请选择一种充值方式"><img src="static/picture/wechatpay.png">
						</label>
						<!--<label class="am-radio" style="margin-right:30px;">
							<input type="radio" name="paycode" value="qqpay" data-am-ucheck required data-validation-message="请选择一种充值方式"><img src="static/picture/qqpay.jpg">
						</label>-->
						</label>
					</div>
					<div class="tr_rechnum">
						<span>应付金额：</span>
						<p type="text" class="rechnum" value="0元"></p>
					</div>
				</div>
				<div class="tr_paybox">
					<a href="#" class="error_u" style="text-decoration: none;color: #959595;"></a>

				</div>
			</form>
		</div>
	</div>


	<script type="text/javascript" src="static/js/jquery.min.js"></script>
	<script type="text/javascript" src="static/js/amazeui.min.js"></script>
	<script type="text/javascript" src="static/js/ui-choose.js"></script>
	<script type="text/javascript">
		$('.ui-choose').ui_choose();
		var uc_01 = $('#uc_01').data('ui-choose'); 
		uc_01.click = function(index, item) {
			console.log('click', index, item.text())
		}
		uc_01.change = function(index, item) {
			console.log('change', index, item.text())
		}
		$(function() {
			$('#uc_01 li:eq(3)').click(function() {
				$('.tr_rechoth').show();
				$('.tr_rechoth').find("input").attr('required', 'true')
				$('.rechnum').text('1元');
			})
			$('#uc_01 li:eq(0)').click(function() {
				$('.tr_rechoth').hide();
				$('.rechnum').text('1元');
				$('.othbox').val('');
			})

			$(document).ready(function() {
				$('.othbox').on('input propertychange', function() {
					var num = $(this).val();
					$('.rechnum').html(num + "元");
				});
			});
			$(".othbox").focus(function() {
				$(".qt").val($(this).val());
			});
			$(".othbox").blur(function() {
				$(".qt").val($(this).val());
			});
		})

		$(function() {
			$('#doc-vld-msg').validator({
				onValid: function(validity) {
					$(validity.field).closest('.am-form-group').find('.am-alert').hide();
				},
				onInValid: function(validity) {
					var $field = $(validity.field);
					var $group = $field.closest('.am-form-group');
					var $alert = $group.find('.am-alert');
					var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

					if (!$alert.length) {
						$alert = $('<div class="am-alert am-alert-danger"></div>').hide().
						appendTo($group);
					}
					$alert.html(msg).show();
				}
			});
		});

		jQuery(document).ready(function($) {
			try {
				jQuery("[name='user']").on('blur', function() {
					jQuery.post(
						'checkuser.php', {
							user: jQuery("[name='user']").val()
						},
						function(data) {
							if (data.status == 0) {
								jQuery(".error_user").html('<img  src="/static/images/X.png" />用户不存在');
								jQuery(".error_u").html('');
							} else {
								jQuery(".error_user").html('<img  src="/static/images/Y.png" />用户名正确，可以充值');
								jQuery(".error_u").html('<input type="submit" value="确认支付" class="tr_pay am-btn" />	<span>温馨提示：成功充值后系统会自动将<?php echo $money_name; ?>充值到您的账户中。</span>');
							}
						}
					);
				});
			} catch (e) {}
		});
	</script>
	<script type="text/javascript">
		onlyIntegerKeyUp = function(e) {
			if (e === undefined) {
				e = window.event;
			}
			var obj = e.srcElement ? e.srcElement : e.target;
			var pattern = /[^\d]/ig;
			var val = obj.value;
			if (pattern.test(val)) {
				var i = getCursortPosition(e);
				obj.value = val.replace(pattern, '');
				setCaretPosition(e, i);
			}
		};

		getCursortPosition = function(event) { 
			if (event === undefined || event === null) {
				event = arguments.callee.caller.arguments[0] || window.event;
			}
			var obj = event.srcElement ? event.srcElement : event.target;
			var CaretPos = 0; 
			if (document.selection) {
				obj.focus();
				var Sel = document.selection.createRange();
				Sel.moveStart('character', -obj.value.length);
				CaretPos = Sel.text.length;
			} else if (obj.selectionStart || obj.selectionStart == '0') {
				CaretPos = obj.selectionStart;
			}

			return (CaretPos);
		};

		setCaretPosition = function(event, pos) { 
			if (event === undefined || event === null) {
				event = arguments.callee.caller.arguments[0] || window.event;
			}
			var obj = event.srcElement ? event.srcElement : event.target;
			if (pos > 0) {
				pos = pos - 1; 
			}
			if (obj.setSelectionRange) {
				obj.focus();
				obj.setSelectionRange(pos, pos);
			} else if (obj.createTextRange) {
				var range = obj.createTextRange();
				range.collapse(true);
				range.moveEnd('character', pos);
				range.moveStart('character', pos);
				range.select();
			}
		};
		
		onlyNumAndAlphKeyUp = function(event) {
			if (event === undefined) {
				event = window.event;
			}
			var obj = event.srcElement ? event.srcElement : event.target;
			var pattern = /[^\w]/ig;
			if (pattern.test(obj.value)) {
				var i = getCursortPosition(event);
				obj.value = obj.value.replace(pattern, '');
				setCaretPosition(event, i);
			}
		};
	</script>

	<div style="text-align:center;">

	</div>
</body>

</html>