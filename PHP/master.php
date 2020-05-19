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
                <button class="btn btn_type-user" value="master" formaction="master.php">Страница Пользователя</button>
                <button  class="btn btn_type-logout" value="logout" formaction="logout.php">Выйти из системы</button>
            </form>
        </div>
    </header>
    <main class="content">
        <nav class="nav-block">
        <a href="ticket__create.php" class="btn btn_type-add"></a>
    </nav>
        <form class="cards">
           <?php GetSpecificCards();?>
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>