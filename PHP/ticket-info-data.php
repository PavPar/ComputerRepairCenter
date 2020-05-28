<?php
include "db.php";
require 'template.php';
function showTicketInfo($ticket_info)
{
    if (count($ticket_info) == 0) {
        echo '<div class="ticket-info"><h2>Такого Заказа не существует.</h2></div>';
        return;
    }
    ;
    $parse = new parse_class;
    $master = getMasterName($ticket_info['master_id']);

    // if (userCheck()) {
        switch (getNamedValue('db.ticket_state')[$ticket_info['state']]) {
            case "pool":
                $parse->get_tpl('../templates/ticket-info/ticket-info-pool.tpl');
                break;
            case "in process":
                $parse->get_tpl('../templates/ticket-info/ticket-info-process.tpl');
                break;
            case "finished":
                $parse->get_tpl('../templates/ticket-info/ticket-info-finished.tpl');
                break;
            case "closed":
                $parse->get_tpl('../templates/ticket-info/ticket-info-closed.tpl');
                break;
        };

    // } else {
    //     $parse->get_tpl('header-client.tpl');
    // }
    $parse->set_tpl('{ID}', $ticket_info['ticket_id']);
    $parse->set_tpl('{STATE}', getNamedValue('db.ticket_state')[$ticket_info['state']]);
    $parse->set_tpl('{MASTER_ID_IN}', $master["lastname"] . ' ' . $master["name"] . ' ' . $master["middlename"]);

    $parse->set_tpl('{OWNER}', $ticket_info['owner']);
    $parse->set_tpl('{DATE}', $ticket_info['ticket_date']);
    $parse->set_tpl('{PHONE}', $ticket_info['owner_phone']);
    $parse->set_tpl('{OWNER_DEPT}', getNamedValue('db.department')[$ticket_info['department_id']]);

    $parse->set_tpl('{TYPE}', getNamedValue('db.ticket_type')[$ticket_info['ticket_type_id']]);
    $parse->set_tpl('{TECH_TYPE}', getNamedValue('db.tech_type')[$ticket_info['tech_type_id']]);

    $parse->set_tpl('{COMMENT_IN}', $ticket_info['comment']);

    if ($ticket_info["worker_id"] != "") {
        $worker = getMasterName($ticket_info['worker_id']);
        $parse->set_tpl('{WORKER_ID}', $worker["lastname"] . ' ' . $worker["name"] . ' ' . $worker["middlename"]);
    }

    $parse->set_tpl('{COMMENT_OUT}', $ticket_info['final_comment']);

    $parse->set_tpl('{COURIER}', $ticket_info['handout_owner']);
    $parse->set_tpl('{COURIER_PHONE}', $ticket_info['handout_owner_phone']);
    if($ticket_info['handout_department_id']!=""){
        $parse->set_tpl('{COURIER_DEPT}', getNamedValue('db.department')[$ticket_info['handout_department_id']]);
    }
    $parse->tpl_parse();
    echo $parse->template;
    // $master = getMasterName($ticket_info['master_id']);
    // if (userCheck()) {
    //     echo '
    //     <div style="margin: auto;">
    //     <p> Ticket ID: ' . $ticket_info['ticket_id'] . '</p>
    //     <p> Ticket Date: ' . $ticket_info['ticket_date'] . '</p>
    //     <p> Owner :' . $ticket_info['owner'] . '</p>
    //     <p> Owner phone : ' . $ticket_info['owner_phone'] . '</p>
    //     <p> master ID (Тот кто принял):' . $master["lastname"].' '.$master["name"] .' '.$master["middlename"].'</p>
    //     <p> Тип тикета : ' . getNamedValue('db.ticket_type')[$ticket_info['ticket_type_id']] . '</p>
    //     <p> Тип техники : ' . getNamedValue('db.tech_type')[$ticket_info['tech_type_id']] . '</p>
    //     <p> Отдел : ' . getNamedValue('db.department')[$ticket_info['department_id']] . '</p>
    //     <p> Комментарий : ' . $ticket_info['comment'] . '</p>
    //     <p> Состояние тикета :' . getNamedValue('db.ticket_state')[$ticket_info['state']] . '</p>
    //     <p> Кто забрал : ' . $ticket_info['handout_owner'] . '</p>
    //     <p> Номер того кто забрал : ' . $ticket_info['handout_owner_phone'] . '</p>
    //     <p> Отдел того кто забрал : ' . $ticket_info['handout_department_id'] . '</p>
    //     <p> Финальный комментарий : ' . $ticket_info['final_comment'] . '</p>
    //     </div>
    //     ';
    // } else {
    //     echo '
    //     <div style="margin: auto;">
    //     <p> Ticket ID: ' . $ticket_info['ticket_id'] . '</p>
    //     <p> Ticket Date: ' . $ticket_info['ticket_date'] . '</p>
    //     <p> master ID (Тот кто принял):' . $master["lastname"].' '.$master["name"] .' '.$master["middlename"] . '</p>
    //     <p> Состояние тикета :' . getNamedValue('db.ticket_state')[$ticket_info['state']] . '</p>
    //     ';
    // }

};

function createHeader()
{
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
