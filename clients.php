<?php
require('common/common.php');
require('model/users.php');
require('model/clients.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$clients = new Clients();
sendSuccess($clients->getClients());