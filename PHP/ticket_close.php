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
            <form class="ticket" action="ticket_close-data.php" method="POST">
                <h2>Тикет № <?php echo getData('ticket-close', true);?></h2>
                        <input required class="ticket__input" name="handout_name" type="text" placeholder="Имя Принявшего">
                        <input required class="ticket__input" name="handout_phone" type="phone" placeholder="Телефон Принявшего">
                        <!-- Департамент -->
            
                        <select required class="ticket__input" name="departments">
                            <?php getListElements("db.department")?>
                        </select>

                        <textarea class="ticket__comment" name="comment" type="text" placeholder="Комментарий"></textarea>
                        
                        <button class="btn btn_type-accept" type="submit" value=<?php echo getData('ticket-close', true);?> name="btn_close">Закрыть тикет</button>
                    </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>
