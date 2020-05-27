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

//Получение данных с проверкой на их существовние
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

//Проверка существования сессии => логина пользователя
function userAuthCheck()
{
    if (!array_key_exists('user_id', $_SESSION)) {
        die("Session is missing user id");
    }
}

function userCheck()
{
    if (!array_key_exists('user_id', $_SESSION)) {
        return false;
    }
    return true;
}

//Процедура выхода пользователя из системы
function userLogOut()
{
    session_abort();
    header('Location: index.php');
}

//Получение фИО мастера 
function getMasterName($id){
    global $conn;
    $sql = 'SELECT name,lastname,middlename FROM db.master WHERE master_id = ' . $id;
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
            $usr = array(
                "name" => $data["name"],
                "lastname" => $data["lastname"],
                "middlename" => $data["middlename"],
            );
            return $usr;
        } else {
            return "No master";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}
//Получение логина,имени,фамилии, роли пользователя
function getUserData()
{
    global $conn;
    $sql = 'SELECT role_name,login,name,lastname,middlename FROM db.master a JOIN db.role b ON (a.role_id = b.role_id) WHERE master_id = ' . $_SESSION['user_id'];
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
            $usr = array(
                "role" => $data["role_name"],
                "login" => $data["login"],
                "name" => $data["name"],
                "lastname" => $data["lastname"],
                "middlename" => $data["middlename"],
            );
            return $usr;
        } else {
            return "getUserData:No Such User!";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Проверка логина и пароля пользователя
function userValidation($user)
{
    global $conn;
    $sql = 'SELECT master_id, login, password FROM db.master WHERE login = "' . $user['name'] . '"' . ' AND password = "' . $user['password'] . '"';
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
            $_SESSION['user_id'] = "" . $data['master_id'];
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

function checkPrivalge()
{
    global $conn;
    if (array_key_exists('user_id', $_SESSION)) {
        $sql = 'SELECT role_id FROM db.master WHERE master_id = ' . $_SESSION['user_id'] . '';
        $result = $conn->query($sql);
        if ($result) {
            $data = $result->fetch_assoc();
            if ($data['role_id'] == 0) {
                return true;
            } else {
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
function saveTicketData($owner_name, $owner_phone, $ticket_type, $device_name, $tech_type, $department, $comment, $self)
{
    global $conn;
    global $tickets_table;
    userAuthCheck();

    $states = getTicketStates();

    $sql = 'INSERT INTO ' . $tickets_table . " VALUES (ticket_id,sysdate(),'" . $owner_name . "','" . $owner_phone . "'," . $_SESSION["user_id"] . "," . $ticket_type . ',"' . $device_name . '",' . $tech_type . ',' . $department . ',"' . $comment . '")';
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    if ($self) {
        $sql = "INSERT INTO db.ticket_history (ticket_id,state,master_id) VALUES (" . mysqli_insert_id($conn) . "," . $states["in process"] . "," . $_SESSION["user_id"] . ')';
    } else {
        $sql = "INSERT INTO db.ticket_history (ticket_id,state,master_id) VALUES (" . mysqli_insert_id($conn) . "," . $states["pool"] . "," . 'null)';
    }
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

//Получение возможных состояний тикета
function getTicketStates()
{
    global $conn;
    $sql = 'SELECT * FROM db.ticket_state';
    $result = $conn->query($sql);

    $states = array();
    CheckQuerry($result, $sql);
    if ($result) {
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $states[$row["ticket_state"]] = $row["ticket_state_id"];
                $i++;
            }
        }
    }
    return $states;
}

//Получение всей информации о тикете (с историей) для текущего пользователя
function getTicketInfo($ticket_id)
{
    global $conn;
    $sql = 'SELECT * FROM (db.ticket a join db.ticket_history b on (a.ticket_id = b.ticket_id)) WHERE a.ticket_id = ' . $ticket_id;
    $result = $conn->query($sql);

    $info = array();
    CheckQuerry($result, $sql);
    if ($result) {

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $keys = array_keys($row);
                $vals = array_values($row);
                for ($i = 0; $i < count($keys); $i++) {
                    $info[$keys[$i]] = $vals[$i];
                }

            }
        } 
    }
    return array_change_key_case($info, CASE_LOWER);
}

//Изменение состояния тикета
function changeState($statename, $ticket_id)
{
    global $conn;
    $states = getNamedValue('db.ticket_state');
    $res = array_search($statename, $states);
    if ($res) {
        $sql = 'UPDATE db.ticket_history SET state=' . $res . ' WHERE ticket_id = ' . $ticket_id;
        $result = $conn->query($sql);
        CheckQuerry($result, $sql);
    } else {
        echo "Err: " . $statename . " Doesnt exist !";
    }
}

//Закрытие тикета
function closeTicket($ticket_id, $handout_owner, $handout_owner_phone, $handout_department, $handout_comment)
{
    global $conn;
    $sql = 'UPDATE db.ticket_history
    SET
    handout_date = SYSDATE(),
    handout_owner = "' . $handout_owner . '",
    handout_owner_phone ="' . $handout_owner_phone . '",
    handout_department_id = "' . $handout_department . '",
    final_comment ="' . $handout_comment . '"
    WHERE ticket_id = ' . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    changeState("finished", $ticket_id);
}
//Получение значений которые хранятся в таблице id,name
function getNamedValue($table_name)
{
    global $conn;
    $sql = 'SELECT * FROM ' . $table_name;
    $result = $conn->query($sql);
    $data = array();
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $vals = array_values($row);
                for ($i = 0; $i < count($vals); $i++) {
                    $data[$vals[0]] = $vals[1];
                }
            }
            return array_change_key_case($data, CASE_LOWER);
        }
        return;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}
//Получить карточки текущего мастера
function getPoolCards()
{
    global $conn;
    global $tickets_table;
    userAuthCheck();
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner,state FROM db.ticket a JOiN db.ticket_history USING(Ticket_id) WHERE state = ' . array_search('pool', getNamedValue('db.ticket_state')) . '';
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            $cards = array();
            while ($row = $result->fetch_assoc()) {
                $card = array(
                    "id" => $row["ticket_id"],
                    "date" => $row["ticket_date"],
                    "department" => getNamedValue('db.department')[$row["department_id"]],
                    "owner" => $row["owner"],
                    "state" => getNamedValue('db.ticket_state')[$row["state"]],
                );
                array_push($cards, $card);
            }
            return json_encode($cards, JSON_HEX_TAG);
        } else {
            echo "Empty";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

function getSpecificCards()
{
    global $conn;
    global $tickets_table;
    userAuthCheck();
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner FROM db.ticket a JOiN db.ticket_history b USING(Ticket_id) WHERE b.master_id = ' . $_SESSION['user_id'];
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo fillCard($row["ticket_id"], $row["ticket_date"], $row["department_id"], $row["owner"]);
            }
        } else {
            echo "Empty";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Получить массив карточек

function getCardsArray()
{
    global $conn;
    global $tickets_table;
    userAuthCheck();
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner,state FROM db.ticket a JOiN db.ticket_history b USING(Ticket_id) WHERE b.master_id = ' . $_SESSION['user_id'];
    $result = $conn->query($sql);
    if ($result) {
        $cards = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $card = array(
                    "id" => $row["ticket_id"],
                    "date" => $row["ticket_date"],
                    "department" => getNamedValue('db.department')[$row["department_id"]],
                    "owner" => $row["owner"],
                    "state" => getNamedValue('db.ticket_state')[$row["state"]],
                );
                array_push($cards, $card);
            }
            return json_encode($cards, JSON_HEX_TAG);
            // return serialize($cards);
        } else {
            echo json_encode($cards, JSON_HEX_TAG);
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Получить данные из таблиц в которых два столбца (Id,имя опции) для помещения вариантов в список выбора
function getListElements($table_name)
{
    global $conn;
    $sql = 'SELECT * FROM ' . $table_name;
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row = array_values($row);
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Проверка выполнения SQL запроса в бд
function CheckQuerry($result, $sql)
{
    global $conn;
    if ($result) {
        echo "OK";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

//Получить всю информацию о пользователе
function adminGetAllUserInfo($user_id)
{
    global $conn;
    $sql = 'SELECT * FROM db.master';
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row = array_values($row);
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}
//Добавить пользователя
function adminAddUser($user_login, $user_password, $user_firstname, $user_lastname, $user_middlename)
{
    global $conn;
    $sql = 'INSERT INTO db.master VALUES (master_id,role_id,"' . $user_login . '","' . $user_password . '","' . $user_firstname . '","' . $user_lastname . '","' . $user_middlename . '")';
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}
//Удалить пользователя
function adminRemoveUser($user_id)
{

}
