<?php
require_once(__DIR__ . '/model.php');
class Orders extends Model
{
    function getOrders()
    {
		return $this->Query("SELECT * from orders");
    }
    function getOrderPositions($date)
    {
        return $this->Query("SELECT Ord.client_id,Ord.account_id, Ord.symbol, SUM(IF(Ord.side='buy',Ord.qty,0)) as buyQty, 
		SUM(IF(Ord.side='sell',Ord.qty,0)) as sellQty, SUM(IF(Ord.side='buy',(Ord.price*Ord.qty),0)) as buyAmt, SUM(IF(Ord.side='sell',(Ord.price*Ord.qty),0)) as sellAmt, A.name as account_name, C.name as client_name from orders as Ord LEFT JOIN accounts as A ON A.account_id=Ord.account_id LEFT JOIN clients as C ON C.client_id=Ord.client_id WHERE Ord.date='".$date."' GROUP BY Ord.client_id,Ord.account_id, Ord.symbol");
    }
	function getOrderReports($sdt='',$edt='')
    {
		if($sdt==''){
			$sdt = date('Y-m-d');
		}
		if($edt==''){
			$edt = $sdt;
		}
		return $this->Query("SELECT Ord.*, A.name as account_name, C.name as client_name from orders as Ord LEFT JOIN accounts as A ON A.account_id=Ord.account_id LEFT JOIN clients as C ON C.client_id=Ord.client_id WHERE Ord.date BETWEEN '".$sdt."' AND '".$edt."'");
    }
}