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
$narr[0]['price'] = '230.50';
$narr[1]['title'] = 'Nifty 11th Aug 17550 CE';
$narr[1]['price'] = '264.50';
$narr[2]['title'] = 'Nifty 11th Aug 17600 CE';
$narr[2]['price'] = '282.50';
$narr[3]['title'] = 'Nifty 11th Aug 17650 CE';
$narr[3]['price'] = '302.50';

$bnarr[0]['title'] = 'Bank Nifty 11th Aug 38000 CE';
$bnarr[0]['price'] = '310.50';
$bnarr[1]['title'] = 'Bank Nifty 11th Aug 38500 CE';
$bnarr[1]['price'] = '324.50';
$bnarr[2]['title'] = 'Bank Nifty 11th Aug 39000 CE';
$bnarr[2]['price'] = '362.50';
$bnarr[3]['title'] = 'Bank Nifty 11th Aug 39500 CE';
$bnarr[3]['price'] = '392.50';

$result = ['nifty'=>$narr, 'banknifty'=>$bnarr];
sendSuccess($result);