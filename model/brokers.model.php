<?php
require_once(__DIR__ . '/model.php');
class Brokers extends Model
{
    function getBrokers()
    {
        return $this->Query("SELECT * from brokers WHERE status!=3");
    }
    function addBroker($data)
    {
        global $db;
    }
    function deleteBroker($code)
    {
        return $this->Delete('brokers', ["code='$code'"]);
    }
}