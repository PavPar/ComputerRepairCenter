<?php
include "db.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fields = array(
    "owner_name",
    "owner_phone",
    "device_name",
    "comment",
);

saveData(getData($fields[0], true), getData($fields[1], true), getData($fields[2], false), getData($fields[3], false));
