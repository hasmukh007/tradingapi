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
		$result[] = $v;
	}
}
sendSuccess($result);