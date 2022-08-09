<?php
require('common/common.php');
require('model/users.php');
require('model/accounts.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$accounts = new Accounts();

$rowdata = getRequest('rowdata');
$id = isset($rowdata['id'])?$rowdata['id']:'';
$rows = [];
$rows['name'] = $rowdata['name'];
$rows['client_id'] = $rowdata['client_id'];
$rows['broker_id'] = $rowdata['broker_id'];
$rows['is_live'] = $rowdata['is_live'];
if(isset($rowdata['params']) && count($rowdata['params'])){
	$rows['config'] = stripslashes(json_encode($rowdata['params']));
}else{
	$rows['config'] = '';
}
if($id){
	$where = ["id='$id'"];
	$resp = $accounts->updateAccount($rows,$where);
}else{
	$rows['code'] = $accounts->getCode();
	$resp = $accounts->addAccount($rows);
}
sendSuccess($resp);
?>