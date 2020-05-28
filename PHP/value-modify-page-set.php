<?php
include "db.php";
$fields = array(
    "value_add",
    "value_del",
);
require 'template.php';
function getTPLFieldVals($key)
{
    global $fields;
    switch ($key) {
        case "department":
            return array(
                "title" => "Добавить/Удалить отеделы",
                "value" => "department",
                "table" => valueGetTable("department"),
            );
        case "tech":
            return array(
                "title" => "Добавить/Удалить поддерживаемую технику",
                "value" => "tech",
                "table" => valueGetTable("tech"),
            );
    }
}

function CreateForm()
{
    global $fields;

    $parse = new parse_class;

    if (getData($fields[0], false) != null) {
        $parse->get_tpl('../templates/value/value-add.tpl');
        $TPLFields = getTPLFieldVals(getData($fields[0], true));
    }

    if (getData($fields[1], false) != null) {
        $parse->get_tpl('../templates/value/value-del.tpl');
        $TPLFields = getTPLFieldVals(getData($fields[1], true));
    }
    $parse->set_tpl('{TITLE}', $TPLFields["title"]);
    $parse->set_tpl('{OPTIONS}', getListElements($TPLFields["table"]));
    $parse->set_tpl('{VALUE}', $TPLFields["value"]);
    $parse->set_tpl('{TABLE_VALS}', getTableElements($TPLFields["table"]));
    $parse->tpl_parse();
    echo $parse->template;
}
