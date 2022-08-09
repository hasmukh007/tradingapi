<?php
require_once(__DIR__ . '/model.php');
class Accounts extends Model
{
    function getAccounts()
    {
        return $this->Query("SELECT accounts.account_id,accounts.name,accounts.code,clients.name client_name,brokers.name broker_name,accounts.status,accounts.client_id,accounts.broker_id,accounts.is_live,accounts.config from accounts inner join clients on accounts.client_id=clients.client_id inner join brokers on accounts.broker_id=brokers.broker_id WHERE accounts.status!=3");
    }
	function addAccount($data)
    {
        return $this->Insert('accounts', $data);
    }
	function updateAccount($data,$where)
    {
        return $this->Update('accounts', $data, $where);
    }
    function deleteAccount($code)
    {
        return $this->Delete('accounts', ["code='$code'"]);
    }
	function getCode($length = 8)
	{
		global $db;
		$string = '';
		do{
			$string = generateCode($length);
			$sql = "SELECT * FROM accounts WHERE code='$string'";
			$rs = $db->query($sql);
			if($rs->num_rows == 0){ $found = false; }else{ $found = true; }
		} while($found);
		return $string;
	}
}