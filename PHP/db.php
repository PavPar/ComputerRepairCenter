<?php
$servername = "localhost";
$username = "root";
$password = "vertrigo";
$conn = new mysqli($servername, $username, $password);
$tickets_table = "db.ticket";

session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Получение данных с проверкой
function getData($key, $mandatory)
{
    if ($mandatory) {
        if (key_exists($key, $_REQUEST)) {
            return $_REQUEST[$key];
        } else {
            die("Mandatory field is empty: " . $key);
            return null;
        }
    } else {
        if (key_exists($key, $_REQUEST)) {
            return $_REQUEST[$key];
        } else {
            return null;
        }
    }

};

//Проверка логина и пароля пользователя
function userValidation($user)
{
    global $conn;
    $sql = 'SELECT master_id, login, password FROM db.master WHERE login = "' . $user['name'] . '"' . ' AND password = "' . $user['password'] . '"';
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
            $_SESSION['user_id'] = "".$data['master_id']; 
            return true;
        } else {
           return false; 
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Проверка привелегий пользователя

function checkPrivalge(){
    global $conn;
    if(array_key_exists('user_id',$_SESSION)){
        $sql = 'SELECT role_id FROM db.master WHERE master_id = ' . $_SESSION['user_id'] . '';
        $result = $conn->query($sql);
        if ($result) {
            $data = $result->fetch_assoc();
            if($data['role_id'] == 0){
                return true;
            }else{
                return false;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
    die('Session is empty!');
}
//Сохранение данных тикета
function saveTicketData($owner_name, $owner_phone, $device_name, $comment)
{
    global $conn;
    global $tickets_table;
    $sql = 'INSERT INTO ' . $tickets_table . " VALUES (ticket_id,sysdate(),'" . $owner_name . "','" . $owner_phone . "',1,1,'" . $device_name . "','1','1','" . $comment . "')";
    // $sql = 'INSERT INTO ' .$tickets_table." VALUES (ticket_id,sysdate(),'".$owner_name."','".$owner_phone."','test_master',1,'".$device_name."','1','1','".$comment."')";
    $result = $conn->query($sql);
    if ($result) {
        echo "OK";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getCards()
{
    global $conn;
    global $tickets_table;
    $sql = 'SELECT ticket_id,ticket_date,department_id,"owner" FROM ' . $tickets_table;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo fillCard($row["ticket_id"], $row["ticket_date"], $row["department_id"], $row["owner"]);
        }
    } else {
        echo "Empty";
    }
}
