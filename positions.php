<?php
require('common/common.php');
require('model/users.php');
require('model/accounts.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');

$accounts = new Accounts();

$finalArr = [];
$res = $accounts->getAccounts();
foreach($res as $r){
	if($r['status']!=1)
		continue;
	$sub = [];
	$sub['client_id'] = $r['client_id'];
	$sub['account_id'] = $r['account_id'];
	$sub['client_name'] = $r['client_name'];
	$sub['account_name'] = $r['name'];
	$finalArr[] = $sub;
}
sendSuccess($finalArr);