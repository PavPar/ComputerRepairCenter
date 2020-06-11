<?php include("./PHP/index-data.php");?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отдел по ремонту ПК и прочих устройств</title>
    <link href="./pages/master.css" rel="stylesheet">
</head>

<body class="page">
    <?php createIndexHeader()?>
    <main class="content">
        <form method="POST" class="search-bar" action="PHP/ticket-info.php">
            <h2 class="search-bar__title">Узнать состояние заказа по его номеру</h2>
            <input class="search-bar__input" name="ticket-info" type="text" required placeholder="Номер тикета">
            <button class="btn btn_type-card-add" type="submit"> Получить информацию о состоянии тикета</button>
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>