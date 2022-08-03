<?php
require_once(__DIR__ . '/model.php');
class Users extends Model
{
    private $table = [1 => 'admin', 2 => 'clients'];

    function adminLogin($username, $password)
    {
        global $db;
        $epassword = md5($password);
        $username = addslashes($username);
        $rs = $db->query("SELECT * from admin WHERE password='$epassword' AND status=1 AND email='$username'");
        if ($rs->num_rows == 0) return false;
        $rec = $rs->fetch_assoc();
        return [
            'id' => $rec['id'],
            'name' => $rec['name'],
            'email' => $username,
            'phone' => $rec['phone']
        ];
    }
    function clientLogin($username, $password)
    {
        global $db;
        $epassword = md5($password);
        $username = addslashes($username);
        $rs = $db->query("SELECT * from clients WHERE password='$epassword' AND status=1 AND email='$username'");
        if ($rs->num_rows == 0) return false;
        $rec = $rs->fetch_assoc();
        return [
            'id' => $rec['id'],
            'client_code' => $rec['client_code'],
            'name' => $rec['name'],
            'email' => $username,
            'phone' => $rec['phone']
        ];
    }
    function getToken()
    {
        global $db;
        $token = generateCode(TOKEN_LENGTH);
        $rs = $db->query("SELECT id from tokens where token='$token' AND status=1");
        if ($rs->num_rows == 0)
            return $token;
        return $this->getToken();
    }
    function generateToken($type, $id, $remember)
    {
        global $db;
        $token = $this->getToken();
        $db->query("UPDATE tokens set status=2 where user_type='$type' AND user_id='$id'");
        $maxDays = $remember === true ? MAX_REMEMBER : 1;
        $expire = date('Y-m-d H:i:s', strtotime("+$maxDays days"));
        $db->query("INSERT INTO tokens set status=1,user_id='$id',user_type='$type',token='$token',expire_on='$expire'");

        if ($db->affected_rows != 1) return false;
        return ["token" => $token,  "expireOn" => strtotime($expire) . '000'];
    }
    function verifyToken($type, $id, $token)
    {
        global $db;
        $rs = $db->query("SELECT id from tokens WHERE user_id='$id' AND user_type='$type' AND token='$token' AND status=1 and expire_on>=now()");
        return $rs->num_rows > 0;
    }
    function getIdByUsername($type, $username)
    {
        global $db;
        $table = $this->table[$type];
        $rs = $db->query("SELECT id from $table where email='$username' and status=1");
        if ($rs->num_rows == 0) return 0;
        $rec = $rs->fetch_assoc();
        return $rec['id'];
    }
    function generateForgotPassword($type, $username)
    {
        global $db;
        $id = $this->getIdByUsername($type, $username);
        if ($id == 0) return false;
        $isUniqe = false;

        while ($isUniqe == false) {
            $code = generateCode(FORGOT_CODE);
            $rs = $db->query("SELECT * from forgot_password WHERE code='$code' AND valid_till>=now() AND status=1");
            $isUniqe = $rs->num_rows == 0;
            if ($isUniqe) {
                $validity = date('Y-m-d H:i:s', strtotime("+$" . FORGOT_VALIDTY . " minutes"));
                $db->query("INSERT INTO forgot_password set status=1,code='$code',user_id='$id',user_type='$type',valid_till='$validity'");
                if ($db->affected_rows == 0) return false;
            }
        }
        return $code;
    }
    function changePassword($type, $id, $password)
    {
        global $db;
        $table = $this->table[$type];
        $epassword = md5($password);
        $db->query("UPDATE $table set password='$epassword' where id='$id'");
        if ($db->affected_rows == 0) return false;
    }
    function addClient($name, $email, $password, $phone, $created_by)
    {
        global $db;
        $isUniqe = false;
        $epassword = md5($password);
        while ($isUniqe == false) {
            $code = generateCode(CLIENT_CODE_LEN);
            $rs = $db->query("SELECT * from clients WHERE client_code='$code'");
            $isUniqe = $rs->num_rows == 0;
        }
        $db->query("INSERT INTO clients SET name='$name',email='$email',password='$epassword',client_code='$code',phone='$phone',status=1,created_by='$created_by'");
        if ($db->affected_rows > 0) return true;
        return $db->error;
    }
    function updateClient($id, $name, $email, $phone, $status)
    {
        global $db;
        $db->query("UPDATE clients SET name='$name',email='$email',phone='$phone',status='$status' WHERE id='$id'");
        if ($db->affected_rows > 0) return true;
        return $db->error;
    }
    function changeStatus($type, $id, $status)
    {
        global $db;
        $table = $this->table[$type];
        $db->query("UPDATE $table set status='$status' WHERE id='$id'");
        if ($db->affected_rows == 0) return $db->error;
        return true;
    }
    function addAdmin($name, $email, $password, $phone)
    {
        global $db;
        $epassword = md5($password);
        $db->query("INSERT INTO admin SET name='$name',email='$email',password='$epassword',phone='$phone',status=1");
        if ($db->affected_rows > 0) return true;
        return $db->error;
    }
    function updateAdmin($id, $name, $email, $phone, $status)
    {
        global $db;
        $db->query("UPDATE admin SET name='$name',email='$email',status='$status',phone='$phone' WHERE id='$id'");
        if ($db->affected_rows > 0) return true;
        return $db->error;
    }
    function getUserInfoByToken($token)
    {
        return $this->SimpleQuery('tokens', 'user_type,user_id', ["token='$token'", "status=1"]);
    }
}