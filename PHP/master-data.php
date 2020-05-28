<?php
include "db.php";
userAuthCheck();
$usr = getUserData();
function fillCard($ticket_name, $ticket_date, $ticket_dept, $ticket_customer)
{
    return
        '
    <div class="card" method="POST">
        <h2 class="card__title">' . $ticket_name . '</h2>
        <h3 class="card__date">' . $ticket_date . '</h3>
        <h3 class="card__dept">' . $ticket_dept . '</h3>
        <h3 class="card__name">' . $ticket_customer . '</h3>
        <button type="submit" name="ticket-info" class="btn btn_type-card-info" value='.$ticket_name.' formaction="ticket-info.php">Подробнее</button>
        <button type="submit" name="ticket-close" class="btn btn_type-card-close" value='.$ticket_name.' formaction="ticket_close.php">Закрыть</button>
    </div>
    ';
}
