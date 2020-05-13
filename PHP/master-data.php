<?php
include "db.php";

function fillCard($ticket_name, $ticket_date, $ticket_dept, $ticket_customer)
{
    return
        '
    <div class="card">
        <h2 class="card__title">' . $ticket_name . '</h2>
        <h3 class="card__date">' . $ticket_date . '</h3>
        <h3 class="card__dept">' . $ticket_dept . '</h3>
        <h3 class="card__name">' . $ticket_customer . '</h3>
        <input type="button" class="btn btn_type-card-info" value="Подробнее">
        <input type="button" class="btn btn_type-card-close" value="Закрыть">
    </div>
    ';
}
