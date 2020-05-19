<?php
include "db.php";
function showTicketInfo($ticket_info)
{

    echo '
    <div style="margin: auto;">
    <p> Ticket ID: ' . $ticket_info['ticket_id']. '</p>
    <p> Ticket Date: ' . $ticket_info['ticket_date']. '</p>    
    <p> Owner :' . $ticket_info['owner']. '</p>
    <p> Owner phone : ' . $ticket_info['owner_phone'] . '</p>
    <p> master ID (Тот кто принял):' . $ticket_info['master_id'] . '</p>
    <p> Тип тикета : ' . getNamedValue('db.ticket_type')[$ticket_info['ticket_type_id']] . '</p>
    <p> Тип техники : ' . getNamedValue('db.tech_type')[$ticket_info['tech_type_id']] . '</p>
    <p> Отдел : ' . getNamedValue('db.department')[$ticket_info['department_id']] . '</p>
    <p> Комментарий : ' . $ticket_info['comment'] . '</p>
    <p> Состояние тикета :' . getNamedValue('db.ticket_state')[$ticket_info['state']] . '</p>
    <p> Кто забрал : ' . $ticket_info['handout_owner'] . '</p>
    <p> Номер того кто забрал : ' . $ticket_info['handout_owner_phone'] . '</p>
    <p> Отдел того кто забрал : ' . $ticket_info['handout_department_id'] . '</p>
    <p> Финальный комментарий : ' . $ticket_info['final_comment'] . '</p>
    </div>
    ';
};
