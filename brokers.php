<?php
require('common/common.php');
require('model/users.php');
require('model/brokers.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$brokers = new Brokers();
$res = $brokers->getBrokers();
$result = [];
foreach($res as $k=>$v) {
	$v['params'] = json_decode($v['params']);
	$result[] = $v;
}
sendSuccess($result);