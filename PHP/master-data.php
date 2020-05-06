<?php
$servername = "localhost";
$username = "root";
$password = "vertrigo";
$conn = new mysqli($servername, $username, $password);
$tickets_table = "db.ticket";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fillCard($ticket_name,$ticket_date,$ticket_dept,$ticket_customer){
    return 
    '
    <div class="card">
        <h2 class="card__title">'.$ticket_name.'</h2>
        <h3 class="card__date">'.$ticket_date.'</h3>
        <h3 class="card__dept">'.$ticket_dept.'</h3>
        <h3 class="card__name">'.$ticket_customer.'</h3>
        <input type="button" class="btn btn_type-card-info" value="Подробнее">
        <input type="button" class="btn btn_type-card-close" value="Закрыть">
    </div>
    ';
}

function getCards()
{
    global $conn;
    global $tickets_table;
    $sql = 'SELECT ticket_id,ticket_date,department_id,"owner" FROM '.$tickets_table;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo fillCard($row["ticket_id"],$row["ticket_date"],$row["department_id"],$row["owner"]);
        }
    } else {
        echo "Empty";
    }
}
?>