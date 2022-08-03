<?php
class Model
{
    function Insert($table, $fields)
    {
        global $db;
        $strArray = [];
        foreach ($fields as $f => $val) {
            $strArray[] = "`$f`='" . addslashes($val) . "'";
        }
        $sql = "INSERT INTO $table SET " . implode(',', $strArray);
        $rtn = $db->query($sql);
        if (!$rtn) false;
        return $db->insert_id;
    }
    function Update($table, $fields, $where)
    {
        global $db;
        $strArray = [];
        foreach ($fields as $f => $val) {
            $strArray[] = "`$f`='" . addslashes($val) . "'";
        }
        $sql = "UPDATE $table SET " . implode(',', $strArray) . ' WHERE ' . implode(' AND ', $where);
        $rtn = $db->query($sql);
        if (!$rtn) false;
        return true;
    }
    function Delete($table, $where)
    {
        global $db;
        $sql = "DELETE from $table WHERE " . implode(' AND ', $where);
        $rtn = $db->query($sql);
        if (!$rtn) false;
        return true;
    }
    function SimpleQuery($table, $fields, $where)
    {
        global $db;
        $sql = "SELECT $fields from $table WHERE " . implode(' AND ', $where);
        $rtn = $db->query($sql);
        if (!$rtn) false;
        return $rtn->fetch_all(MYSQLI_ASSOC);
    }
    function Query($sql)
    {
        global $db;
        $rtn = $db->query($sql);
        if (!$rtn) false;
        return $rtn->fetch_all(MYSQLI_ASSOC);
    }
}