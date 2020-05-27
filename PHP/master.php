<!DOCTYPE html>
<html lang="ru">
<?php include "master-data.php"?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASTER PAGE</title>
    <link href="../pages/master.css" rel="stylesheet">
</head>

<body class="page">
    <header class="header">
        <div class="acc-info">
            <img class="acc-info__logo" src="../images/inqusition-01.svg">
            <h2 class="acc-info__name"><?php echo $usr['login'] ?></h2>
            <form method="POST">
                <!-- <button class="btn btn_type-user" value="master" formaction="master.php">Страница Пользователя</button> -->
                <button  class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header>
    <main class="content">
        <nav class="nav-block">
            <button class="btn btn_type-current">Текущие</button>
            <button class="btn btn_type-finished">Заврешенные</button>
            <button class="btn btn_type-closed">Закрытые</button>
            <button class="btn btn_type-pool">Pool</button>
            <button class="btn btn_type-all">Все</button>
        <a href="ticket__create.php" class="btn btn_type-add"></a>
    </nav>
        <form class="cards">
           <?php GetSpecificCards();?>
        </form>
    </main>
    <footer class="footer"></footer>
</body>
<template id="card">
<div class="card" method="POST">
        <h2 class="card__title"></h2>
        <h3 class="card__date"></h3>
        <h3 class="card__dept"></h3>
        <h3 class="card__name"></h3>
        <button type="submit" name="ticket-info" class="btn btn_type-card-info" formaction="ticket-info.php">Подробнее</button>
        <button type="submit" name="ticket-close" class="btn btn_type-card-close" formaction="ticket_close.php">Закрыть</button>
    </div>
</template>
<script >
    const userCards = JSON.parse('<?php echo GetCardsArray(); ?>');
    const poolCards = JSON.parse('<?php echo getPoolCards(); ?>');
</script>
<script src="../JS/showCards.js"></script>
</html>