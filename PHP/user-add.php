<!DOCTYPE html>
<html lang="ru">
<?php include "ticket-info-data.php"?>
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
            <form method="POST">
            <button class="btn btn_type-user" value="master" formaction="admin.php">Страница Пользователя</button>
            <button  class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header>
    <main class="content">
    <form class="ticket" action="user-add-data.php" method="POST">
            <input requiered class="ticket__input" name="master_login" type="text" placeholder="Логин">
            <input requiered class="ticket__input" name="master_password" type="text" placeholder="Пароль">
            <input requiered class="ticket__input" name="master_lasname" type="text" placeholder="Фамилия">
            <input requiered class="ticket__input" name="master_firstname" type="text" placeholder="Имя">
            <input class="ticket__input" name="master_middlename" type="text" placeholder="Отчество(если есть)">

            <input class="btn btn_type-accept" type="submit" value="Создать пользователя" name="btn_self">
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>
