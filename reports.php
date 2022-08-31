<?php
require('common/common.php');
require('model/users.php');
require('model/orders.model.php');

$orders = new Orders();

$sdt = '2022-08-29';
$edt = '2022-08-29';
$dateDisp = '';
if(strtotime($sdt)==strtotime($edt)){
	$dateDisp = date('m/d/Y',strtotime($sdt));
}else{
	$dateDisp = date('m/d/Y',strtotime($sdt)).' to '.date('m/d/Y',strtotime($edt));
}
$res = $orders->getOrderReports($sdt,$edt);
$clArr = [];
foreach($res as $r){
	$cid = $r['client_id'];
	$acid = $r['account_id'];
	$cname = $r['client_name'];
	$aname = $r['account_name'];
	if(!isset($clArr[$acid])){
		$clArr[$acid]['client_id'] = $cid;
		$clArr[$acid]['client_name'] = $cname;
		$clArr[$acid]['account_name'] = $aname;
		$clArr[$acid]['client_id'] = $acid;
		$clArr[$acid]['date_disp'] = $dateDisp;
		$clArr[$acid]['orders'] = [];
	}	
	$clArr[$acid]['orders'][] = $r;
}
$result = [];
foreach($clArr as $cl=>$rs){
	$result[] = $rs;
}
sendSuccess($result);