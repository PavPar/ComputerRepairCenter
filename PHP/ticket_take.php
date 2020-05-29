<?php
include "db.php";
$fields = array(
    "ticket-close",
);
takeTicketFromPool(getData($fields[0], true));
header("Location: master.php");
