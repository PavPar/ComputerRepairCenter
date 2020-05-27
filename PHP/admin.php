<!DOCTYPE html>
<html lang="ru">
<?php include "master-data.php"?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASTER PAGE</title>
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
        <nav class="nav-block">
            <a href="ticket__create.php" class="btn btn_type-add"></a>
        </nav>
        <form class="cards" method="POST">
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Пользователь</h2>
                <button type="submit" name="user-add" class="btn btn_type-card-info" value='USER_ADD'
                    formaction="user-add.php">Добавить</button>
                <button type="submit" name="user-delete" class="btn btn_type-card-close" value='USER_DELETE'
                    formaction="value-add.php">Удалить</button>
            </div>
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Департамент</h2>
                <button type="submit" name="ticket-info" class="btn btn_type-card-info" value='.$ticket_name.'
                    formaction="ticket-info.php">Добавить</button>
                <button type="submit" name="ticket-close" class="btn btn_type-card-close" value='.$ticket_name.'
                    formaction="ticket_close.php">Удалить</button>
            </div>
            <div class="card card_level-admin" method="POST">
                <h2 class="card__title">Техника</h2>
                <button type="submit" name="ticket-info" class="btn btn_type-card-info" value='.$ticket_name.'
                    formaction="ticket-info.php">Добавить</button>
                <button type="submit" name="ticket-close" class="btn btn_type-card-close" value='.$ticket_name.'
                    formaction="ticket_close.php">Удалить</button>
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