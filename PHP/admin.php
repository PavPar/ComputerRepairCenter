<?php include("db.php");?>
<?php checkPrivalge();?>
<?php $usr = getUserData();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управлние</title>
    <link href="../pages/admin.css" rel="stylesheet">
</head>

<body class="page">
    <header class="header">
        <div class="acc-info">
            <img class="acc-info__logo" src="../images/inqusition-01.svg">
            <h2 class="acc-info__name"><?php echo $usr['login'] ?></h2>
            <form method="POST">
                <button class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header>
    <main class="content">
        <form class="cards" method="POST" action="value-modify.php">
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Пользователь</h2>
                <button type="submit" name="value" class="btn btn_type-card-info" value='tech' formaction="user-view.php"
                   >Посмотреть</button>
                <button type="submit" name="user-add" class="btn btn_type-card-add" value='USER_ADD'
                    formaction="user-add.php">Добавить</button>
                <button type="submit" name="user-delete" class="btn btn_type-card-close" value='USER_DELETE'
                    formaction="user-del.php">Удалить</button>
            </div>
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Департамент</h2>
                <button type="submit" name="value" class="btn btn_type-card-info" value='department' formaction="value-view.php"
                   >Посмотреть</button>
                <button type="submit" name="value_add" class="btn btn_type-card-add" value='department'
                   >Добавить</button>
                <button type="submit" name="value_del" class="btn btn_type-card-close" value='department'
                    >Удалить</button>
            </div>
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Техника</h2>
                <button type="submit" name="value" class="btn btn_type-card-info" value='tech' formaction="value-view.php"
                   >Посмотреть</button>
                <button type="submit" name="value_add" class="btn btn_type-card-add" value='tech'
                   >Добавить</button>
                <button type="submit" name="value_del" class="btn btn_type-card-close" value='tech'
                   >Удалить</button>
            </div>
            <!-- <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Роли</h2>
                <button type="submit" name="ticket-info" class="btn btn_type-card-info" value='.$ticket_name.'
                    formaction="ticket-info.php">Добавить</button>
                <button type="submit" name="ticket-close" class="btn btn_type-card-close" value='.$ticket_name.'
                    formaction="ticket_close.php">Удалить</button>
            </div> -->
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>