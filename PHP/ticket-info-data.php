<?php
include "db.php";

function showTicketInfo($ticket_info)
{
    if (count($ticket_info) == 0) {
        echo "<div><h2>Такого Заказа не существует.</h2></div>";
        return;
    }
    $master = getMasterName($ticket_info['master_id']);
    if (userCheck()) {
        echo '
        <div style="margin: auto;">
        <p> Ticket ID: ' . $ticket_info['ticket_id'] . '</p>
        <p> Ticket Date: ' . $ticket_info['ticket_date'] . '</p>
        <p> Owner :' . $ticket_info['owner'] . '</p>
        <p> Owner phone : ' . $ticket_info['owner_phone'] . '</p>
        <p> master ID (Тот кто принял):' . $master["lastname"].' '.$master["name"] .' '.$master["middlename"].'</p>
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
    } else {
        echo '
        <div style="margin: auto;">
        <p> Ticket ID: ' . $ticket_info['ticket_id'] . '</p>
        <p> Ticket Date: ' . $ticket_info['ticket_date'] . '</p>
        <p> master ID (Тот кто принял):' . $master["lastname"].' '.$master["name"] .' '.$master["middlename"] . '</p>
        <p> Состояние тикета :' . getNamedValue('db.ticket_state')[$ticket_info['state']] . '</p>
        ';
    }

};

function createHeader()
{
    require 'template.php';
    $parse = new parse_class;
    if (userCheck()) {
        $parse->get_tpl('header-master.tpl');
        $parse->set_tpl('{LOGIN}', getUserData()['login']);
    } else {
        $parse->get_tpl('header-client.tpl');
    }
    $parse->tpl_parse();
    echo $parse->template;
}
