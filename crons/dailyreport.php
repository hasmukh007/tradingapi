<?php
require(__DIR__ . '/../common/common.php');
require(__DIR__ . '/../model/users.php');
require(__DIR__ . '/../model/orders.model.php');

$orders = new Orders();

$sdt = '2022-08-29';
$edt = '2022-08-29';
$res = $orders->getOrderReports($sdt,$edt);
$clArr = getOrderReports($res);

$accountHtml = '';
$overallPL = 0;
$result = [];
$emailArr = [];
foreach($clArr as $cl=>$rs){
	$emailArr[$rs['email']] = $rs['account_name'];
	$innerHtml = '<table cellpadding="2" cellspacing="2" border="1" role="presentation" style="max-width: 100%; width:100%; margin-bottom:30px;">
		<tr>
			<th>Date/Time</th>
			<th>Order ID</th>
			<th>Symbol</th>
			<th>Side</th>
			<th>Qty</th>
			<th>Price</th>
			<th>Charges</th>
		</tr>';
	$buy = 0; $sell = 0; $charges = 0;	
	foreach($rs['orders'] as $ord){
		if($ord['side']=='buy'){
			$buy += $ord['qty']*$ord['price'];
		}
		if($ord['side']=='sell'){
			$sell += $ord['qty']*$ord['price'];
		}
		$charges += $ord['charges'];	
		$innerHtml .= '
			<tr>
				<td>'.$ord['date'].' '.$ord['time'].'</td>
				<td>'.$ord['order_id'].'</td>
				<td>'.$ord['symbol'].'</td>
				<td>'.$ord['side'].'</td>
				<td style="text-align:right">'.$ord['qty'].'</td>
				<td style="text-align:right">'.$ord['price'].'</td>
				<td style="text-align:right">'.$ord['charges'].'</td>
		  </tr>';
	}	
	$innerHtml .= '</table>';
	$rs['date_disp'] = $dateDisp;
	$pl = ($sell-$buy)-$charges;
	$overallPL += $pl;
	$rs['pl'] = $pl;
	$result[] = $rs;
	$accountHtml .= '<table cellpadding="0" cellspacing="0" border="0" role="presentation" style="max-width: 100%; width:100%; margin-bottom:10px;">
		<tr>
			<td class="pb-5 " style="font-size: 18px;">
			'.$rs['account_name'].' ('.$rs['client_name'].')
			</td>
			<td class="pb-5 " style="font-size: 20px; text-align:right">
			'.$rs['pl'].'
			</td>
		  </tr>
	</table>'.$innerHtml;
}

$mailHtml = '
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<!--[if gte mso 9]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <style>
        html, body{font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; width: 100%; height: 100%; padding: 0; margin: 0; color: #fff;}
		table, table tr td, div, p, a{font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; color: #fff !important; font-size: 16px;}
		.links-sec, .links-sec a, .text-gray{color: #a8a8a8 !important;}
		.ii a[href] {
			color: #fff !important;
		}
        .w-full{width: 100%;}
        .h-full{height: 100%;}
        .text-center{text-align: center;}
		.text-right{text-align: right;}
        .h-20{height: 20px;}
        .m-0{margin: 0;}        
        .p-30{padding: 30px;}
        .pb-5{padding-bottom: 5px;}
        .pb-10{padding-bottom: 10px;}
        .pb-20{padding-bottom: 20px;}
        .pb-30{padding-bottom: 30px;}
        .pt-10{padding-top: 10px;}
        .pt-20{padding-top: 20px;}
        .top-bold-text{font-size: 14px; font-weight: bold; color: #000; text-align: center; border-bottom: 1px solid #eee;}
        .login-sec{padding: 40px 0 20px 0;text-align: center;}
        .login-btn{padding: 8px 30px; border-radius: 20px; font-size: 14px; color: #fff; font-weight: 500; background: #1abbd8; text-decoration: none;}
        .v-top{vertical-align: top;}
        .mx-1{margin: 0 1px;}
        .mx-2{margin: 0 2px;}
        .mx-5{margin: 0 5px;}
        .mx-8{margin: 0 8px;}
        .mx-10{margin: 0 10px;}
        .mx-20{margin: 0 20px;}
        .px-10{padding: 0 10px;}
        .px-10per{
            padding: 0 10%;
        }
        .px-3per{
            padding: 0 3%;
        }
        .bold{font-weight: 600;}
        .links-sec, .links-sec a, .text-gray{color: #a8a8a8;}
        .text-left{text-align: left;}
        .fs-13{font-size: 13px;}
    </style>
</head>
<body>
    <table cellpadding="2" cellspacing="2" border="0" role="presentation" style="width: 100%; height: 100%; background: #000; border: 0px; padding:10px;">        
        <tr>
            <td class="w-full h-full v-top">
                <div class="w-full h-full">
                    <p>Hi,</p> 
					<p>Daily Profit/Loss Statement</p>
'.$accountHtml.'                    
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-full h-20" style="font-size: 20px;">Daily Overall(all accounts) Profit/Loss: '.$overallPL.'</td>
        </tr>
    </table>
</body>
</html>';

$body = $mailHtml;
$subject = 'Daily Trading Report- '.$sdt;

sendEmail('meetsushant248@gmail.com', $subject, $body, 'Sushanta Mahanty');

/*
foreach($emailArr as $to=>$toName){
	sendEmail($to, $subject, $body, $toName = '');
}
*/
?>