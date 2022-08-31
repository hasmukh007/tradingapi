<?php
require(__DIR__ . '/common/common.php');
require(__DIR__ . '/model/users.php');
require(__DIR__ . '/model/orders.model.php');

$orders = new Orders();

$sdt = date('Y-m-d');
$edt = date('Y-m-d');
$dateDisp = '';
if(strtotime($sdt)==strtotime($edt)){
	$dateDisp = date('m/d/Y',strtotime($sdt));
}else{
	$dateDisp = date('m/d/Y',strtotime($sdt)).' to '.date('m/d/Y',strtotime($edt));
}
$res = $orders->getOrderReports($sdt,$edt);
$clArr = getOrderReports($res);

$result = [];
foreach($clArr as $cl=>$rs){
	$buy = 0; $sell = 0; $charges = 0;
	foreach($rs['orders'] as $ord){
		if($ord['side']=='buy'){
			$buy += $ord['qty']*$ord['price'];
		}
		if($ord['side']=='sell'){
			$sell += $ord['qty']*$ord['price'];
		}
		$charges += $ord['charges'];		
	}	
	$rs['date_disp'] = $dateDisp;
	$rs['pl'] = ($sell-$buy)-$charges;
	$result[] = $rs;
}
sendSuccess($result);