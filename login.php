<?php
require('common/common.php');
require('model/users.php');
$users = new Users();

$userName = getRequest('username');
$password = getRequest('password');
$type = strtolower(getRequest('type'));
$remember = getRequest('remember', false);

if ($type == 'admin')
    $r = $users->adminLogin($userName, $password);
else if ($type == 'clients')
    $r = $users->clientLogin($userName, $password);

if ($r == false) sendError('Invalid username or password');
$token = $users->generateToken($type == 'admin' ? 1 : 2, $r['id'], $remember);

$r['token'] = $token["token"];
$r['expireOn'] = $token["expireOn"];
$r["type"] = $type;
sendSuccess($r);