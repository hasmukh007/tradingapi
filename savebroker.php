<?php
require('common/common.php');
require('model/users.php');
require('model/brokers.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$brokers = new Brokers();

$rowdata = getRequest('rowdata');
$id = isset($rowdata['id'])?$rowdata['id']:'';
$rows = [];
$rows['name'] = $rowdata['name'];
$rows['auth_type'] = $rowdata['auth_type'];
$rows['path'] = $rowdata['path'];
if(isset($rowdata['params']) && count($rowdata['params'])){
	$rows['params'] = addslashes(json_encode($rowdata['params']));
}else{
	$rows['params'] = '';
}
if($id){
	$where = ["id='$id'"];
	$resp = $brokers->updateBroker($rows,$where);
}else{
	$rows['code'] = $brokers->getCode();
	$resp = $brokers->addBroker($rows);
}
sendSuccess($resp);
?>