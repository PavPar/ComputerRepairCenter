<?php
include("db.php");
$fields = array(
    "master_login",
    "master_password",
    "master_firstname",
    "master_lasname",
    "master_middlename"
);
adminAddUser(getData($fields[0],true),getData($fields[1],true),getData($fields[2],true),getData($fields[3],true),getData($fields[4],false));
// header("Location: user-add.php");
?>