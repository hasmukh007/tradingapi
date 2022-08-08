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
        return $this->Insert('brokers', $data);
    }
	function updateBroker($data,$where)
    {
        return $this->Update('brokers', $data, $where);
    }
    function deleteBroker($code)
    {
        return $this->Delete('brokers', ["code='$code'"]);
    }
	function getCode($length = 8)
	{
		global $db;
		$string = '';
		do{
			$string = generateCode($length);
			$sql = "SELECT * FROM brokers WHERE code='$string'";
			$rs = $db->query($sql);
			if($rs->num_rows == 0){ $found = false; }else{ $found = true; }
		} while($found);
		return $string;
	}
}