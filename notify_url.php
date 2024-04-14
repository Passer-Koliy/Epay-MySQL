<?php
include_once 'config.php';



        $para_filter = paraFilter($_GET);
        $para_sort = argSort($para_filter);
        $prestr = createLinkstring($para_sort);
        $isSgin = false;
        $isSgin =md5Verify($prestr, $_REQUEST['sign'], $key);
        if ($isSgin) {
           
		   
		   	
				$amount = $_REQUEST['money'];
				$orderid = $_REQUEST['out_trade_no'];
				$order = $db->getrow("select * from #@_Vouchers_pay where no='" . $orderid . "' and status=0");
				if ($order) {
					$money_jl = 0;
					foreach ($money_ms as $k => $v) {
						if ($amount >= $v['amount']) {
							$money_jl = $v['money'];
						}
					}
					$money = $amount * $money_scale + $money_jl;
					$data = array(
						'status' => 1,
						'money' => $money,
						'amount' => $amount
					);
					$re = $db->autoExecute($db->dbprefix . 'Vouchers_pay', $data, 'mod', "no='{$orderid}'");
					$myq = $bq->query("SELECT * FROM {$game_tabel2} WHERE {$game_name} = '" . $order['user'] . "'");
					$results = array();
					while ($row = mysql_fetch_assoc($myq)) {
						$results[] = $row;
					}
					if ($results) {
						$nm = json_encode($results[0]['UID']);
						$obj = remove_quote($nm);
						$db->query("update {$game_tabel} set {$game_field_money}={$game_field_money}+$money where {$game_field_user}='" . $obj . "'");
						echo $obj;
					} else {
						echo mysql_error();
					}
				}
			

			ob_clean();
			echo 'success';
		   
        }






  function paraFilter($para) {
        $para_filter = array();
        foreach ($para as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "")
                continue;
            else
                $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }

    function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }

    function createLinkstring($para) {
        $arg = "";
        foreach ($para as $key => $val) {
            $arg .= $key . "=" . $val . "&";
        }
        $arg = substr($arg, 0, -1);
        return $arg;
    }

    function md5Verify($prestr, $sign, $key) {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);
        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }
	
	
function remove_quote(&$str)
{
	if (preg_match("/^\"/", $str)) {
		$str = substr($str, 1, strlen($str) - 1);
	}
	if (preg_match("/\"$/", $str)) {
		$str = substr($str, 0, strlen($str) - 1);;
	}
	return $str;
}
