<?php
include "db.php";
function showTicketInfo($ticket_info)
{

    echo '
    <p>' . $ticket_info['ticket_id']. '</p>
    <p>' . $ticket_info['ticket_date']. '</p>    
    <p>' . $ticket_info['owner']. '</p>
    <p>' . $ticket_info['owner_phone'] . '</p>
    <p>' . $ticket_info['master_id'] . '</p>
    <p>' . getNamedValue('db.ticket_type')[$ticket_info['ticket_type_id']] . '</p>
    <p>' . getNamedValue('db.tech_type')[$ticket_info['tech_type_id']] . '</p>
    <p>' . getNamedValue('db.department')[$ticket_info['department_id']] . '</p>
    <p>' . $ticket_info['comment'] . '</p>
    <p>' . getNamedValue('db.ticket_state')[$ticket_info['state']] . '</p>
    <p>' . $ticket_info['handout_owner'] . '</p>
    <p>' . $ticket_info['handout_owner_phone'] . '</p>
    <p>' . $ticket_info['handout_department_id'] . '</p>
    <p>' . $ticket_info['final_comment'] . '</p>
    ';
};
