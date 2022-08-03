<?php
require('common/common.php');
require('model/users.php');
require('model/brokers.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$brokers = new Brokers();
$code = getRequest('code');
sendSuccess($brokers->deleteBroker($code));