<?php 
$servername = "localhost";
$username = "root";
$password = "vertrigo";
$conn = new mysqli($servername, $username, $password);
$tickets_table = "db.ticket";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fields = array(
    "owner_name",
    "owner_phone",
    "device_name",
    "comment"
);

function getData($key,$mandatory){
    if($mandatory){
        if(key_exists($key,$_REQUEST)){
            return $_REQUEST[$key];
         }else{
            die("Mandatory field is empty: ".$key);
            return null;
         }
    }else{
        if(key_exists($key,$_REQUEST)){
            return $_REQUEST[$key];
         }else{
            return null;
         }
    }
    
};

function saveData($owner_name,$owner_phone,$device_name,$comment){
    global $conn;
    global $tickets_table;
    ;
    $sql = 'INSERT INTO ' .$tickets_table." VALUES (ticket_id,sysdate(),'".$owner_name."','".$owner_phone."','test_master',1,'".$device_name."','1','1','".$comment."')";
    $result = $conn->query($sql);
    if($result){
        echo "OK";
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

saveData(getData($fields[0],true),getData($fields[1],true),getData($fields[2],false),getData($fields[3],false));
?>