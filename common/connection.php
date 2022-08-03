<?php
if (!defined(('MYSQL_HOST'))) {
    require(__DIR__ . '/commonheader.php');
    require(__DIR__ . '/config.php');
    require(__DIR__ . '/functions.php');
}

$db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
if ($db->connect_errno) {
    sendError('Could not connect do database. Server facing some issue please try again later');
}