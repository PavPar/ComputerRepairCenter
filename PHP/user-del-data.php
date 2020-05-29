<?php
include("db.php");
$fields = array(
    "del"
);
adminDelUser(getData($fields[0],true));
header("Location: admin.php");
?>