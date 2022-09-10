<?php
require_once(__DIR__ . '/model.php');
class Admin extends Model
{
    function getAdmins()
    {
        return $this->Query("SELECT * from admin WHERE status=1");
    }
}