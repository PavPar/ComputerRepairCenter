<?php include "db.php"?>
<?php userAuthCheck();?>
<?php checkPrivalge()?>
<!DOCTYPE html>
<html lang="ru">

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
    <div class="ticket-info">
            <table class="ticket-info__table">
                <tr class="ticket-info__row ticket-info__header">
                    <td class="ticket-info__cell" colspan="1">
                        <p> ID</p>
                    </td>
                    <td class="ticket-info__cell" colspan="1">
                        <p> Значение</p>
                    </td>
                </tr>
                <?php echo getTableElements(valueGetTable(getData('value', true))); ?>
            </table>
            <form method="POST">
                <button class="btn btn_type-logout" value="master" formaction="admin.php">Назад</button>
            </form>
        </div>
    </main>
    <footer class="footer"></footer>
</body>

</html>
