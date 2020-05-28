<?php
include "db.php";
$fields = array(
    "value",
    "btn_add",
    "btn_del",
);

if (getData($fields[1], false) != null && getData($fields[0], false)!= null) {
    echo addValue(getData($fields[0], true), getData($fields[1], true));
}

if (getData($fields[2], false) != null && getData($fields[0], false)!= null) {
    echo deleteValue(getData($fields[0], true), getData($fields[2], true));
}

header("Location: admin.php");