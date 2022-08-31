<?php
require('./common/config.php');
require('./common/functions.php');
require('../model/orders.model.php');
require('../model/dailysummary.model.php');

$orders = new Orders();
$dailySummary = new DailySummary();
