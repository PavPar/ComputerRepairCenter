<?php include "db.php"?>
<?php userAuthCheck();?>
<?php checkPrivalge()?>
<!DOCTYPE html>
<html lang="ru">
<?php
function createHeader()
{
    require_once 'template.php';
    $parse = new parse_class;
    if (userCheck()) {
        if (checkPrivalge()) {
            $parse->get_tpl('index__header-admin.tpl');
            $parse->set_tpl('{LOGIN}', getUserData()['login']);
        } else {
            $parse->get_tpl('index__header-master.tpl');
            $parse->set_tpl('{LOGIN}', getUserData()['login']);
        }

    } else {
        echo "Auth error!";
        return;
    }
    $parse->tpl_parse();
    echo $parse->template;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать пользователя</title>
    <link href="../pages/ticket__create.css" rel="stylesheet">
</head>

<body class="page">
<?php createHeader();?>
    <main class="content">
    <form class="ticket" action="user-add-data.php" method="POST">
            <input requiered class="ticket__input" name="master_login" type="text" placeholder="Логин">
            <input requiered class="ticket__input" name="master_password" type="text" placeholder="Пароль">
            <input requiered class="ticket__input" name="master_lasname" type="text" placeholder="Фамилия">
            <input requiered class="ticket__input" name="master_firstname" type="text" placeholder="Имя">
            <input class="ticket__input" name="master_middlename" type="text" placeholder="Отчество(если есть)">

            <input class="btn btn_type-accept" type="submit" value="Создать пользователя" name="btn_self">
        </form>
        <form method="POST" class="acc-info">
                <button class="btn btn_type-logout" value="master" formaction="admin.php">Назад</button>
            </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>
