<?php include("./PHP/index-data.php");?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASTER PAGE</title>
    <link href="../pages/master.css" rel="stylesheet">
</head>

<body class="page">
    <?php createIndexHeader()?>
    <main class="content">
        <form method="POST" class="acc-info" action="php/ticket-info.php">
            <input name="ticket-info" type="text" required>
            <button type="submit"> Получить информацию о состоянии тикета</button>
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>