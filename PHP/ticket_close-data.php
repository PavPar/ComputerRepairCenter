<?php
include("db.php");
$fields = array(
    "handout_name",
    "handout_phone",
    "departments",
    "comment",
);

if(getData("btn_close",true)){
    closeTicket(getData('btn_close',true),getData($fields[0],true),getData($fields[1],true),getData($fields[2],true),getData($fields[3],true));
}
header("Location: master.php");
?>