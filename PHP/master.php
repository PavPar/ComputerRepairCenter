<!DOCTYPE html>
<html lang="ru">
<?php include("master-data.php")?>
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
            <h2 class="acc-info__name">Inquisitor</h2>
            <input type="button" class="btn btn_type-user" value="Страница Пользователя">
            <input type="button" class="btn btn_type-logout" value="Выйти из системы">
        </div>
    </header>
    <main class="content">
        <nav class="nav-block"><input type="button" class="btn btn_type-add"></nav>
        <section class="cards">
           <?php GetCards();?>
        </section>
    </main>
    <footer class="footer"></footer>
</body>

</html>