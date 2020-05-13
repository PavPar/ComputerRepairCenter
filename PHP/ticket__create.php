<!DOCTYPE html>
<html lang="ru">
<?php include "db.php"?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASTER PAGE</title>
    <link href="../pages/ticket__create.css" rel="stylesheet">
</head>

<body class="page">
    <header class="header">
        <div class="acc-info">
            <img class="acc-info__logo" src="../images/inqusition-01.svg">
            <h2 class="acc-info__name">Master_1</h2>

            <input type="button" class="btn btn_type-user" value="Страница Пользователя">
            <input type="submit" class="btn btn_type-logout" value="Выйти из системы">
        </div>
    </header>
    <main class="content">
        <nav class="nav-block">
            <a href="ticket__create.php" class="btn btn_type-add"></a>
        </nav>
        <form class="ticket" action="ticket__create-data.php" method="POST">
            <!-- <input type="datetime-local" value=""> -->
            <input class="ticket__input" name="owner_name" type="text" placeholder="Имя Ответственного">
            <input class="ticket__input" name="owner_phone" type="phone" placeholder="Телефон Ответственного">
            <!-- Департамент -->
            
            <select class="ticket__input" id="departments">
                <?php getListElements("db.department")?>
            </select>
           
            <!-- Вид устройства -->
            <select class="ticket__input" id="tech-type">
                <?php getListElements("db.tech_type")?>
            </select>

            <input class="ticket__input" name="device_name" type="text" placeholder="Имя устройства (Если Есть)">
            <textarea class="ticket__comment" name="comment" type="text" placeholder="Комментарий"></textarea>
            <input class="btn btn_type-accept" type="submit" value="Принять заявку на себя" name="btn_self">
            <input class="btn btn_type-decline-yellow" type="submit" value="Отправить заявку в pool" name="btn_pool">
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>