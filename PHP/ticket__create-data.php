<?php
include "db.php";

$fields = array(
    "owner_name",
    "owner_phone",
    "device_name",
    "comment",
);

saveTicketData(getData($fields[0], true), getData($fields[1], true), getData($fields[2], false), getData($fields[3], false));
