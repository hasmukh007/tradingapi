<?php
require('common/common.php');
require('model/users.php');
require('model/accounts.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$accounts = new Accounts();
$res = $accounts->getAccounts();
$result = [];
foreach($res as $k=>$v) {
	$v['config'] = json_decode($v['config']);
	$result[] = $v;
}
sendSuccess($result);