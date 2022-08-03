<?php
require_once(__DIR__ . '/model.php');
class Clients extends Model
{
    function getClients()
    {
        return $this->Query("SELECT * from clients WHERE status!=3");
    }
    function addClient($data)
    {
        global $db;
    }
    function deleteClient($code)
    {
        return $this->Delete('clients', ["client_code='$code'"]);
    }
}