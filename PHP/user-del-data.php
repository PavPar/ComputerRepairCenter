<?php
include("db.php");
$fields = array(
    "del"
);
// adminAddUser(getData($fields[0],true),getData($fields[1],true),getData($fields[2],true),getData($fields[3],true),getData($fields[4],false));
adminDelUser(getData($fields[0],true));
// header("Location: admin.php");
?>