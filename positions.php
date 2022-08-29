<?php
require('common/common.php');
require('model/users.php');
require('model/order.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');

$date = Date('Y-m-d');
$orders = new Orders();

$res = $orders->getOrderPositions($date);
$result = [];
foreach($res as $k=>$v) {
	$remQty = $v['buyQty']-$v['sellQty'];
	if($remQty>0){		
		$v['remQty'] = $remQty;		
		$result[$v['client_id']][] = $v;
	}
}
$finalArr = [];
foreach($result as $cl=>$arr){	
	$sub = [];	
	foreach($arr as $r){
		if(!isset($sub['client_id'])){
			$sub['client_id'] = $v['client_id'];
			$sub['account_id'] = $v['account_id'];
			$sub['client_name'] = $v['client_name'];
			$sub['account_name'] = $v['account_name'];
		}		
		$subpos = [];
		$subpos['symbol'] = $r['symbol'];
		$subpos['buyQty'] = $r['buyQty'];
		$subpos['sellQty'] = $r['sellQty'];
		$subpos['remQty'] = $r['remQty'];
		$subpos['buyAmt'] = $r['buyAmt'];
		$subpos['sellAmt'] = $r['sellAmt'];
		$sub['positions'][] = $subpos;
	}
	$finalArr[] = $sub;
}
sendSuccess($finalArr);