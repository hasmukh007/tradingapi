<?php
require('common/common.php');
require('model/users.php');
require('model/brokers.model.php');
$users = new Users();

$token = getAuthToken();
$r = $users->getUserInfoByToken($token);
if (!$r) sendError('Invalid Token');


$narr = $bnarr = [];
$narr[0]['title'] = 'Nifty 11th Aug 17500 CE';
$narr[0]['prie'] = '230.50';
$narr[1]['title'] = 'Nifty 11th Aug 17550 CE';
$narr[1]['prie'] = '264.50';
$narr[2]['title'] = 'Nifty 11th Aug 17600 CE';
$narr[2]['prie'] = '282.50';
$narr[3]['title'] = 'Nifty 11th Aug 17650 CE';
$narr[3]['prie'] = '302.50';

$bnarr[0]['title'] = 'Bank Nifty 11th Aug 38000 CE';
$bnarr[0]['prie'] = '310.50';
$bnarr[1]['title'] = 'Bank Nifty 11th Aug 38500 CE';
$bnarr[1]['prie'] = '324.50';
$bnarr[2]['title'] = 'Bank Nifty 11th Aug 39000 CE';
$bnarr[2]['prie'] = '362.50';
$bnarr[3]['title'] = 'Bank Nifty 11th Aug 39500 CE';
$bnarr[3]['prie'] = '392.50';

$result = ['nifty'=>$narr, 'banknifty'=>$bnarr];
sendSuccess($result);