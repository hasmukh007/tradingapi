<?php
require_once(__DIR__ . '/model.php');
class Accounts extends Model
{
    function getAccounts()
    {
        return $this->Query("SELECT accounts.name,accounts.code,clients.name client_name,brokers.name broker_name,accounts.status from accounts inner join clients on accounts.client_id=clients.client_id inner join brokers on accounts.broker_id=brokers.broker_id WHERE accounts.status!=3");
    }
    function addClient($data)
    {
        global $db;
    }
    function deleteAccount($code)
    {
        return $this->Delete('accounts', ["code='$code'"]);
    }
}