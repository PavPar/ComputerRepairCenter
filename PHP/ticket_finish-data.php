<?php
include("db.php");
userAuthCheck();
$fields = array(
    "comment",
);

if(getData("btn_close",true)){
    finishTicket(getData('btn_close',false),getData($fields[0],false));
}
header("Location: master.php");
?>