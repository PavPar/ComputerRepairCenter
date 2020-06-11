<?php include "db.php"?>
<?php userAuthCheck();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Завершение тикета</title>
    <link href="../pages/ticket__create.css" rel="stylesheet">
</head>

<body class="page">
    <header class="header">
        <div class="acc-info">
            <img class="acc-info__logo" src="../images/inqusition-01.svg">
            <h2 class="acc-info__name">Master_1</h2>
            <form method="POST">
                <button class="btn btn_type-user" value="master" formaction="master.php">Страница Пользователя</button>
                <button  class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header>
    <main class="content">
            <form class="ticket" action="ticket_finish-data.php" method="POST">
                <h2>Тикет № <?php echo getData('ticket-close', true); ?></h2>
                        <textarea class="ticket__comment" name="comment" type="text" placeholder="Комментарий"></textarea>
                        <button class="btn btn_type-accept" type="submit" value=<?php echo getData('ticket-close', true); ?> name="btn_close">Закрыть тикет</button>
            </form>
            <form method="POST" class="acc-info">
                <button class="btn btn_type-logout" value="master" formaction="master.php">Назад</button>
            </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>
