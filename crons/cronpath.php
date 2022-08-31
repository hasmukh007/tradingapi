<?php
	$pagename = 'dailyreport.php';
	if(isset($_REQUEST['page']) && $_REQUEST['page']!='')
		$pagename = $_REQUEST['page'];
	
	$absolute_path = realpath($pagename);
	$dir = dirname($absolute_path);	
	
	if(__DIR__ == $dir){ 
        echo 'Correct Path: '.$dir;
		echo '<br>';
		echo '<br>';
		echo 'Cron Job Link: ' . $absolute_path;
    }	

?>