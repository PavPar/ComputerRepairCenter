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
    <!-- <header class="header">
        <div class="acc-info">
            <img class="acc-info__logo" src="../images/inqusition-01.svg">
            <h2 class="acc-info__name">Master_1</h2>
            <form method="POST">
                <button class="btn btn_type-user" value="master" formaction="master.php">Страница Пользователя</button>
                <button  class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header> -->
    <?php createHeader()?>
    <main class="content">
      <?php showTicketInfo(getTicketInfo(getData('ticket-info', true))); ?>
    </main>
    <footer class="footer"></footer>
</body>

</html>
