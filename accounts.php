<?php
require('common/common.php');
require('model/users.php');
require('model/accounts.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');
$accounts = new Accounts();
sendSuccess($accounts->getAccounts());