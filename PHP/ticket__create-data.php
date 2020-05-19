<?php
include "db.php";

$fields = array(
    "owner_name",
    "owner_phone",
    "ticket_type",
    "device_name",
    "tech_type",
    "departments",
    "comment",
);

if (getData("btn_self", false) != null) {
    saveTicketData(getData($fields[0], true), getData($fields[1], true), getData($fields[2], true), getData($fields[3], false), getData($fields[4], true), getData($fields[5], true), getData($fields[6], false), true);
} else {
    if (getData("btn_pool", false) != null) {
        saveTicketData(getData($fields[0], true), getData($fields[1], true), getData($fields[2], true), getData($fields[3], false), getData($fields[4], true), getData($fields[5], true), getData($fields[6], false), false);
    }
}

header("Location: master.php");
