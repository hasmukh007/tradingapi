<?php
require('common/common.php');
require('model/users.php');
require('model/clients.model.php');
$users = new Users();

$request_body = file_get_contents('php://input');
$data = json_decode($request_body,true);
if(!$data){
	exit;
}

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$clients = new Clients();

if(!$data['client_code']) {
	$client_code = $clients->generateClientCode();
	$rowdata['client_code'] = $client_code;
}
$rowdata['name'] = $data['name'];
$rowdata['email'] = $data['email'];
if($data['passwd'])
	$rowdata['password'] = md5($data['passwd']);
$rowdata['phone'] = $data['phone'];

$senddt['table'] = 'clients';
$senddt['fields'] = $rowdata;
$res=[];
if($data['client_code']) {
	$senddt['where'] = ["client_code='".$data['client_code']."'"];
	$res = $clients->updateClient($senddt);
} else {
	$res = $clients->addClient($senddt);
}
sendSuccess($res);