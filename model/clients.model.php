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
		
		return $this->Insert($data['table'], $data['fields']);
    }
	
	function updateClient($data)
    {
        global $db;
		
		return $this->Update($data['table'], $data['fields'], $data['where']);
    }
	
	function generateClientCode($num=10) {
		global $db;
		
		$code = generateCode($num);
		$ret = $this->Query("SELECT * from clients WHERE client_code='$code' and status = 1");
		if(count($ret)) {
			$this->generateClientCode();
		} else {
			return $code;
		}
	}
	
    function deleteClient($code)
    {
        return $this->Delete('clients', ["client_code='$code'"]);
    }
}