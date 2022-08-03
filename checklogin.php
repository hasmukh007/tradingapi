<?php
require('common/common.php');
require('model/users.php');
$users = new Users();

$token = getRequest('token');
$type = getRequest('type') == 'admin' ? 1 : 2;
$id = getRequest('id', 0);

$r = $users->verifyToken($type, $id, $token);
sendSuccess(['valid' => $r]);