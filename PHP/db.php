<?php
$servername = "localhost";
$username = "id13213450_barabar";
$password = "J$5%p3hL[/]t1RNU";
$database = "id13213450_db";
$conn = new mysqli($servername, $username, $password,$database);
$tickets_table = "ticket";

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
        die(header("Location: ../index.php"));
    }
}

function userCheck()
{
    if (!array_key_exists('user_id', $_SESSION)) {
        return false;
    }
    return true;
}

//Получение фИО мастера
function getMasterName($id)
{
    global $conn;
    $sql = 'SELECT name,lastname,middlename FROM master WHERE master_id = ' . $id;
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
    $sql = 'SELECT role_name,login,name,lastname,middlename FROM master a JOIN role b ON (a.role_id = b.role_id) WHERE master_id = ' . $_SESSION['user_id'];
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
    $sql = 'SELECT master_id, login, password FROM master WHERE login = "' . $user['name'] . '"' . ' AND password = "' . $user['password'] . '"';
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
        $sql = 'SELECT role_id FROM master WHERE master_id = ' . $_SESSION['user_id'] . '';
        $result = $conn->query($sql);
        if ($result) {
            $data = $result->fetch_assoc();
            if ($data['role_id'] == 0) {
                return true;
            } else {
                header("Location: ../index.php");
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
        $sql = "INSERT INTO ticket_history (ticket_id,state,worker_id) VALUES (" . mysqli_insert_id($conn) . "," . $states["in process"] . "," . $_SESSION["user_id"] . ')';
    } else {
        $sql = "INSERT INTO ticket_history (ticket_id,state,worker_id) VALUES (" . mysqli_insert_id($conn) . "," . $states["pool"] . "," . 'null)';
    }
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

//Получение возможных состояний тикета
function getTicketStates()
{
    global $conn;
    $sql = 'SELECT * FROM ticket_state';
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
    $sql = 'SELECT * FROM (ticket a join ticket_history b on (a.ticket_id = b.ticket_id)) WHERE a.ticket_id = ' . $ticket_id;
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
    $states = getNamedValue('ticket_state');
    $res = array_search($statename, $states);
    if ($res) {
        $sql = 'UPDATE ticket_history SET state=' . $res . ' WHERE ticket_id = ' . $ticket_id;
        $result = $conn->query($sql);
        CheckQuerry($result, $sql);
    } else {
        echo "Err: " . $statename . " STATE Doesnt exist !";
    }
}

//Завершение тикета (finished, но еще на забрали)
function finishTicket($ticket_id, $handout_comment)
{
    global $conn;
    $sql = 'UPDATE ticket_history
    SET
    final_comment ="' . $handout_comment . '."
    WHERE ticket_id = ' . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    changeState("finished", $ticket_id);
}

//Закрытие тикета
function closeTicket($ticket_id, $handout_owner, $handout_owner_phone, $handout_department)
{
    global $conn;
    $sql = 'UPDATE ticket_history
    SET
    handout_date = SYSDATE(),
    handout_owner = "' . $handout_owner . '",
    handout_owner_phone ="' . $handout_owner_phone . '",
    handout_department_id = "' . $handout_department . '"
    WHERE ticket_id = ' . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    changeState("closed", $ticket_id);
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
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner,state FROM ticket a JOiN ticket_history USING(Ticket_id) WHERE state = ' . array_search('pool', getNamedValue('ticket_state')) . '';
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            $cards = array();
            while ($row = $result->fetch_assoc()) {
                $card = array(
                    "id" => $row["ticket_id"],
                    "date" => $row["ticket_date"],
                    "department" => getNamedValue('department')[$row["department_id"]],
                    "owner" => $row["owner"],
                    "state" => getNamedValue('ticket_state')[$row["state"]],
                );
                array_push($cards, $card);
            }
            return json_encode($cards, JSON_HEX_TAG);
        } else {
            $cards = array();
            return json_encode($cards, JSON_HEX_TAG);;
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
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner FROM ticket a JOiN ticket_history b USING(Ticket_id) WHERE worker_id = ' . $_SESSION['user_id'];
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
    $sql = 'SELECT ticket_id,ticket_date,department_id,owner,state FROM ticket a JOiN ticket_history b USING(Ticket_id) WHERE worker_id = ' . $_SESSION['user_id'];
    $result = $conn->query($sql);
    if ($result) {
        $cards = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $card = array(
                    "id" => $row["ticket_id"],
                    "date" => $row["ticket_date"],
                    "department" => getNamedValue('department')[$row["department_id"]],
                    "owner" => $row["owner"],
                    "state" => getNamedValue('ticket_state')[$row["state"]],
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
            $res = "";
            while ($row = $result->fetch_assoc()) {
                $row = array_values($row);
                $res = $res . '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
            return $res;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

//Получить данные из таблиц в которых два столбца (Id,имя опции) для помещения в таблицу
function getTableElements($table_name)
{
    global $conn;
    require_once 'template.php';
    $parse = new parse_class;
    $sql = 'SELECT * FROM ' . $table_name;

    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            $res = "";
            while ($row = $result->fetch_assoc()) {
                $row = array_values($row);
                $parse->get_tpl('../templates/table/table-row.tpl');
                $parse->set_tpl('{VAL_0}', $row[0]);
                $parse->set_tpl('{VAL_1}', $row[1]);
                $parse->tpl_parse();
                $res = $res . $parse->template;
            }
            return $res;
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
        // echo "OK";
    } else {
        die("Error: " . $sql . "<br>" . $conn->error);
    }
}

//Получить всю информацию о пользователе
function adminGetAllUserInfo()
{
    global $conn;
    $sql = 'SELECT * FROM master WHERE role_id!=0';
    $result = $conn->query($sql);
    if ($result) {
        $res = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // $row = array_values($row);
                array_push($res, $row);
            }
        }
        return $res;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}
//Добавить пользователя
function adminAddUser($user_login, $user_password, $user_firstname, $user_lastname, $user_middlename)
{
    global $conn;
    $sql = 'INSERT INTO master VALUES (master_id,role_id,"' . $user_login . '","' . $user_password . '","' . $user_firstname . '","' . $user_lastname . '","' . $user_middlename . '")';
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}
//Удалить пользователя
function adminDelUser($user_id)
{
    global $conn;
    echo $user_id;
    poolAllTickets($user_id);
    $sql = 'DELETE FROM master WHERE master_id = ' . $user_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

//Переместить все тикеты в pool (при удалении);
function poolAllTickets($user_id)
{
    $res = getAllMasterTickets($user_id);
    foreach ($res as &$id) {
        saveTicketState($id[0]);
        changeState("pool", $id[0]);
        removeWorkerFromTicket($id[0]);
    }
}

function getAllMasterTickets($user_id)
{
    global $conn;
    $sql = "SELECT ticket_id FROM ticket_history WHERE worker_id=" . $user_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    $res = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row = array_values($row);
            array_push($res, $row);
        }
    }
    return $res;
}

function removeWorkerFromTicket($ticket_id)
{
    global $conn;
    $sql = "UPDATE ticket_history SET worker_id=null WHERE ticket_id=" . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

function assignWorkerToTicket($ticket_id, $worker_id)
{
    global $conn;
    $sql = "UPDATE ticket_history SET worker_id =" . $worker_id . " WHERE ticket_id = " . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

function takeTicketFromPool($ticket_id)
{
    changeState(getNamedValue("ticket_state")[restoreTicket($ticket_id)], $ticket_id);
    assignWorkerToTicket($ticket_id, $_SESSION["user_id"]);
}

//Получить состояние тикета
function getTicketState($ticket_id)
{
    global $conn;
    $sql = "SELECT state from ticket_history WHERE ticket_id = " . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row = array_values($row);
            return $row[0];
        }
    }
}

// echo restoreTicket($ticket_id);

function saveTicketState($ticket_id)
{
    global $conn;
    if (!checkTicketPoolState($ticket_id)) {
        $sql = "INSERT INTO ticket_pool_states VALUES(" . $ticket_id . "," . getTicketState($ticket_id) . ")";
    } else {
        $sql = "UPDATE ticket_pool_states SET prev_state=" . getTicketState($ticket_id) . " WHERE ticket_id = " . $ticket_id;
    }
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}
//Проверить сохраненнено ли состояние тикета

function checkTicketPoolState($ticket_id)
{
    global $conn;
    $sql = "SELECT ticket_id FROM ticket_pool_states WHERE ticket_id = " . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}
function retrivePoolTicketState($ticket_id)
{
    global $conn;
    $sql = "SELECT prev_state FROM ticket_pool_states WHERE ticket_id = " . $ticket_id;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row = array_values($row);
            return $row[0];
        }
    } else {
        return "ignore";
    }
}

//Восстанавливаем только исходное состояние тикета, если он находился в pool, то делать этого не нужно
function restoreTicket($ticket_id)
{
    $state = retrivePoolTicketState($ticket_id);
    if ($state == getTicketStates()['pool'] || ($state == "ignore")) {
        return getTicketStates()['in process'];
    } else {
        return $state;
    }
}
//Админ получить имена таблиц
function valueGetTable($tableName)
{
    switch ($tableName) {
        case "department":
            return "department";
        case "tech":
            return "tech_type";
    }
}

function valueGetPK($tableName)
{
    switch ($tableName) {
        case "department":
            return "department_id";
        case "tech":
            return "tech_type_id";
    }
}

function addValue($value, $table)
{
    global $conn;
    $sql = "INSERT INTO " . valueGetTable($table) . ' VALUES (NULL,"' . $value . '")';
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

function deleteValue($value, $table)
{
    global $conn;
    $sql = "DELETE FROM " . valueGetTable($table) . " WHERE " . valueGetPK($table) . " = " . $value;
    $result = $conn->query($sql);
    CheckQuerry($result, $sql);
}

// function createHeader()
// {
//     require_once 'template.php';
//     $parse = new parse_class;
//     if (userCheck()) {
//         if (checkPrivalge()) {
//             $parse->get_tpl('index__header-admin.tpl');
//             $parse->set_tpl('{LOGIN}', getUserData()['login']);
//         } else {
//             $parse->get_tpl('index__header-master.tpl');
//             $parse->set_tpl('{LOGIN}', getUserData()['login']);
//         }

//     } else {
//         echo "Auth error!";
//         return;
//     }
//     $parse->tpl_parse();
//     echo $parse->template;
// }

function getUserRowsDel()
{
    require_once 'template.php';
    $parse = new parse_class;
    $rows = adminGetAllUserInfo();
    $result = "";
    foreach ($rows as &$row) {
        $parse->get_tpl('../templates/table/table__user-row-del.tpl');
        $parse->set_tpl('{USER_ID}', $row['master_id']);
        $parse->set_tpl('{USER_LASTNAME}', $row['lastname']);
        $parse->set_tpl('{USER_NAME}', $row['name']);
        $parse->set_tpl('{USER_MIDDLENAME}', $row['middleName']);
        $parse->set_tpl('{USER_LOGIN}', $row['login']);
        $parse->set_tpl('{USER_PASSWORD}', $row['password']);
        $parse->tpl_parse();
        $result = $result . $parse->template;
    }
    return $result;
}
