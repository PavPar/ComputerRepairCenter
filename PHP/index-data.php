<?php
include "db.php";


function createIndexHeader()
{
    require 'template.php';
    $parse = new parse_class;
    if (userCheck()) {
        $parse->get_tpl('./php/index__header-master.tpl');
        $parse->set_tpl('{LOGIN}', getUserData()['login']);
    } else {
        $parse->get_tpl('./php/index__header-client.tpl');
    }
    $parse->tpl_parse();
    echo $parse->template;
}